<?php
namespace app\index\controller;
use app\api\domain\UserDomain;
use think\App;
use think\Request;
use app\api\model\UserModel;

class User extends CController
{
    private $_userDomain;
    private $_userModel;
    private $_authDomain;
    private $_pictureLibraryDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_userDomain  = new \app\api\domain\UserDomain();

        $this->_authDomain  = new \app\api\domain\AuthDomain();

        $this->_userModel = new UserModel();
    }

    /**
     * 用户个人中心主页
     */
    public function main(Request $request){
        if(!$this->checkLogin()){
            return redirect('/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());
        $authInfo = $this->_userDomain->getAuthInfo($this->getUserId());

        $this->assign('user_info',$user_info);
        $this->assign('auth_info',$authInfo);
        return $this->fetch('user/main1');
    }

    /**
     * 用户认证页面
     * @param Request $request
     * @return mixed|\think\response\Redirect
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function certification(Request $request){
        if(!$this->checkLogin()){
            return redirect('/login');
        }

        $authResult = $this->_authDomain->findAuthResult($this->getUserId());
        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $recertification = (int)$request->get('recertification',0);

        $this->assign('recertification',$recertification);

        $this->assign('authResult',$authResult);
        $this->assign('user_info',$user_info);

        $this->assign('type',isset($authResult['type'])? $authResult['type'] :0);

        return $this->fetch('user/certification1');
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
        }else if(!$result){
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

        $data = \Request::only([
            'username'=>'','idcard'=>'',
            'card_img1'=>'','card_img2'=>'',
            'qualification'=>'','practice_certificate'=>'',
            'enterprise_name'=>'','business_licence'=>'',
            'mobile'=>'','sms_code'=>'',
            'hospital_type'=>'',
            'founding_time'=>'','speciality'=>'',
            'profile'=>'','scale'=>'','duties'=>'',

            'province'=>'',
            'city'=>'',
            'area'=>'',
            'address'=>'',
        ], 'post');

        $type = $request->post('type',0);
        if(!in_array($type,[1,2,3,4])){
            return $this->returnData([],'参数不符合规范',301);
        }

        $data['type']       =  $type;
        $data['user_id']    =  $this->getUserId();
        $validate = new \app\index\validate\addAuth();
        if(!$validate->scene('auth'.$type)->check($data)){
            return $this->returnData([],$validate->getError(),301);
        }

        if($type == 3 || $type == 4){
            $smsObj = new \app\api\domain\SendSms();
            $res = $smsObj->checkSmsCode($data['mobile'],7,$data['sms_code']);
            if($res === 0 || $res === 2){
                return $this->returnData([],'验证码错误',302);
            }
        }

        $data['phone']       =  $data['mobile'];
        unset($data['mobile']);
        unset($data['sms_code']);

        $isTrue = $this->_authDomain->addAuthentication($data);
        if($isTrue === true){
            return $this->returnData([],'认证申请提交成功',200);
        }else if($isTrue === 1){
            return $this->returnData([],'身份证号已被使用',303);
        }else{
            return $this->returnData([],'认证申请提交失败',305);
        }
    }

    /**
     * 退出登录
     */
    public function signOut(){
        $this->clearUserLogin();
        return redirect('/login');
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

        $res = $this->_userDomain->editProfile($this->getUserId(),[
            'nickname'      =>$nickname,
            'profile'       =>$profile
        ]);

        if(!$res){
            return $this->returnData([],'修改失败',305);
        }

        return $this->returnData([],'修改成功',200);
    }

    /**
     * 用户头像修改
     */
    public function uploadHead(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $img = $request->post('img');
        $data = base64_decode(str_replace(['data:image/jpeg;base64,',' '],['','+'],$img));

        $img = $this->_userDomain->uploadHead($this->getUserId(),$data);
        if($img === false){
            return $this->returnData([],'上传失败',305);
        }

        return $this->returnData(['imgUrl' =>$img],'上传成功',200);
    }


    /**
     * 获取地址列表
     */
    public function getAddress(Request $request){
        $region_path  = $request->param('region_path',',');
        $region_grade = $request->param('region_grade/d',1);
        $model = new \app\api\model\RegionsModel();
        $list = $model->getListData(addslashes($region_path),$region_grade);

        if($list){
            foreach ($list as $k=>$val){
                $list[$k]['find_next_region_grade'] = $val['region_grade'] + 1;
            }
        }

        return $this->returnData([
            'infos'=>$list,
            'region_grade'=>$region_grade,
            'request_params'=>[
                'region_path'=>$region_path,
                'region_grade'=>$region_grade
            ]
        ],'',200);
    }
    /**
     * 修改资料页面
     */
     public function modifyUserInfo(Request $request){
             $user_info = $this->_userDomain->getUserInfo($this->getUserId());
             $authInfo = $this->_userDomain->getAuthInfo($this->getUserId());

             $this->assign('user_info',$user_info);
             $this->assign('auth_info',$authInfo);

             return $this->fetch('user/modify_userinfo');
     }

    /**
     * 安全中心页面
     */
     public function security(Request $request){
             if(!$this->checkLogin()){
                 return redirect('/login');
             }

             $user_info = $this->_userDomain->getUserInfo($this->getUserId());
             $authInfo = $this->_userDomain->getAuthInfo($this->getUserId());

             $this->assign('user_info',$user_info);
             $this->assign('auth_info',$authInfo);

             return $this->fetch('user/security');
     }
}