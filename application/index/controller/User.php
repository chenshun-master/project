<?php
namespace app\index\controller;
use app\api\domain\UserDomain;
use think\App;
use think\Request;
use app\api\model\UserModel;

class User extends CController
{
    private $userDomain;
    private $_userModel;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->userDomain  = new \app\api\domain\UserDomain();

        $this->_userModel = new UserModel();
    }

    /**
     * 用户个人中心主页
     */
    public function main(Request $request){
        if(!$this->checkLogin()){
            return redirect('/login');
        }

        $user_info = $this->userDomain->getUserInfo($this->getUserInfo()['id']);

        $this->assign('user_info',$user_info);

        return $this->fetch('user/main');
    }

    /**
     * 用户认证页面
     */
    public function certification(){
        if(!$this->checkLogin()){
            return redirect('/login');
        }

        return $this->fetch('user/certification');
    }

    /**
     * 修改手机号接口
     */
    public function modifyMobile(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $mobile      = $request->post('mobile','');
        $sms_code    = $request->post('sms_code','');
        $user_id     = $this->getUserId();


        $userDomain = new UserDomain();
        $oldMobile = $this->_userModel->getMobile($user_id);

        if(empty($mobile) || empty($sms_code)  || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $result = $userDomain->changeMobile($user_id,$oldMobile,$mobile,$sms_code);

        if($result === 1){
            return $this->returnData([],'验证码错误',302);
        }else if($result === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        if(!$result){
            return $this->returnData([],'修改手机号失败',305);
        }

        return $this->returnData([],'修改手机号成功',200);
    }

    /**
     * 短信修改密码
     */
    public function modifyPassword(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $password    = $request->post('password','');
        $sms_code    = $request->post('sms_code','');

        $userDomain = new UserDomain();
        if(empty($password) || empty($sms_code)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $mobile = $this->_userModel->getMobile($this->getUserId());
        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,5,$sms_code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $result = $userDomain->resetPassword($mobile,$password);
        if(!$result){
            return $this->returnData([],'修改失败',305);
        }

        return $this->returnData([],'修改成功',200);
    }

    /**
     * 用户添加认证申请接口
     */
    public function addAuth(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $type = $request->post('type',0);
        if(!in_array($type,[1,2,3,4])){
            return $this->returnData([],'参数不符合规范',301);
        }

        $validate = new \app\index\validate\addAuth();
        if(!$validate->scene('auth'.$type)->check($request->post())){
            return $this->returnData([],$validate->getError(),301);
        }

        $username           = $request->post('username');
        $idcard             = $request->post('idcard');
        $card_img1          = $request->post('card_img1');
        $card_img2          = $request->post('card_img2');
        $qualification      = $request->post('qualification');
        $practice_certificate = $request->post('practice_certificate');
        $name               = $request->post('name');
        $business_licence   = $request->post('business_licence');

        $data = [];
        $data['type']       =  $type;
        $data['user_id']    =  $this->getUserInfo()['id'];
        $data['user_id']    = 4;
        $data['username']   =  $username;
        $data['idcard']     =  $idcard;
        $data['card_img1']  =  $card_img1;
        $data['card_img2']  =  $card_img2;
        if($type == 2){
            $data['qualification']          = $qualification;
            $data['practice_certificate']   = $practice_certificate;
        }else if($type == 3 || $type == 4){
            $data['name']               = $name;
            $data['business_licence']   = $business_licence;
        }

        $isTrue = (new \app\api\domain\AuthDomain())->addAuthentication($data);
        if(!$isTrue){
            return $this->returnData([],'认证申请提交失败',305);
        }
        return $this->returnData([],'认证申请提交成功',200);
    }


    /**
     * 退出登录
     */
    public function signOut(){
        $this->clearUserLogin();
        return redirect('/index/index/login');
    }

    /**
    * 提交修改信息页面
    */
    public function editProfile(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $nickname   = $request->post('nickname','');
        $profile    = $request->post('profile','');
        if(empty($nickname)){
            return $this->returnData([],'请求参数不符合规范',301);
        }



        $res = $this->userDomain->editProfile($this->getUserId(),[
            'nickname'      =>$nickname,
            'profile'       =>$profile
        ]);

        if(!$res){
            return $this->returnData([],'修改失败',305);
        }

        return $this->returnData([],'修改成功',200);
    }
}