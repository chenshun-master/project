<?php
namespace app\api\controller;
use app\api\domain\AuthDomain;
use think\Request;
use app\api\domain\UserDomain;
use app\api\model\UserModel;

/**
 * 用户信息类
 * @package app\api\controller
 */
class User extends BaseController
{
    private $userDomain;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->userDomain = new UserDomain();
        $this->authDomain = new AuthDomain();
    }

    /**
     * 发送注册短信方法
     */
    public function sendRegisterSms(Request $request){
        $mobile    = $request->param('mobile','');
        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $userModel = new UserModel();
        if($userModel->findMobileExists($mobile)){
            return $this->returnData([],'该用户已被使用',302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsObject->sendCode($mobile,1,9715,12318);

        return $this->returnData([],'发送成功',200);
    }

    /**
     * 用户注册接口
     */
    public function register(Request $request){
        $mobile    = $request->param('mobile','');
        $password  = $request->param('password','');
        $sms_code  = $request->param('sms_code','');


        if(empty($mobile) || empty($password) || empty($sms_code)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $data = [
            'mobile'   =>$mobile,
            'password' =>$password
        ];

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,1,$sms_code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $userDomain = new UserDomain();
        $result = $userDomain->createUser($data);

        if($result == 3){
            return $this->returnData([],'手机号已被使用',304);
        }

        if(!$result){
            return $this->returnData([],'用户注册失败',305);
        }

        return $this->returnData([],'用户注册成功',200);
    }

    /**
     * 用户登录接口
     */
    public function login(Request $request){
        $mobile    = $request->param('mobile','');
        $password  = $request->param('password','');
        if(empty($mobile) || empty($password)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $userDomain = new UserDomain();
        $info = $userDomain->login($mobile,$password);
        $token = $this->getUserToken($info);

        unset($info['password']);

        return $this->returnData([
            'user_info'=>$info,
            'token'=>$token
        ],'登录成功',200);
    }

    /**
     * 用户修改密码
     */
    public function changePwd(Request $request){
        $user_info = $this->checkUserToken();
        $old_password  = $request->param('old_password','');
        $new_password  = $request->param('new_password','');

        $userDomain = new UserDomain();;
        $isTrue = $userDomain->editPwd($user_info['id'],$old_password,$new_password);

        if($isTrue){
            return $this->returnData([],'密码修改成功',200);
        }

        return $this->returnData([],'密码修改失败',305);
    }

    /**
     * 用户重置密码
     */
    public function resetPwd(Request $request){
        $mobile         = $request->param('mobile','');
        $verify_code    = $request->param('verify_code','');
        $password       = $request->param('password','');

        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $secret_key = config('conf.secret_key');
        if(encryptStr($verify_code,'D',$secret_key) !== $mobile){
            return $this->returnData([],'密码重置失败',305);
        }

        $userDomain = new UserDomain();
        $isTrue = $userDomain->resetPassword($mobile,$password);
        if(!$isTrue){
            return $this->returnData([],'密码重置失败',305);
        }

        return $this->returnData([],'密码重置成功',200);
    }

    /**
     * 重置密码短信验证码验证接口
     */
    public function checkSmsCode(Request $request){
        $mobile    = $request->param('mobile','');
        $code    = $request->param('code','');

        $smsObj  = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,2,$code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $secret_key = config('conf.secret_key');
        return $this->returnData([
            'mobile'       =>$mobile,
            'verify_code'  =>encryptStr($mobile,'E',$secret_key)
        ],'验证通过',200);
    }

    /**
     * 用户上传认证图片接口
     */
    public function uploadAuthImg(){
        $this->checkUserToken();

        $file = request()->file("image");

        $img_domain = config('conf.file_save_domain');

        #文件上传类型
        $fileExt   = ['jpg','jpeg','png'];
        if($file){
            $size = 1024*1024*3;              #单位字节
            if(!$file->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过3M',302);
            }

            if(!$file->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持jpg,jpeg及png格式的图片',303);
            }

            $info = $file->move( 'uploads/auth');
            if($info){
                $path_dir = $img_domain.'/uploads/auth/'.str_replace("\\","/",$info->getSaveName());
                return $this->returnData([
                    'image_url'=>$path_dir
                ],'图片上传成功',200);
            }else{
                return $this->returnData([],$file->getError(),305);
            }
        }
    }

    /**
     * 用户添加认证申请
     */
    public function addAuth(Request $request){
        $user_info = $this->checkUserToken();

        $type                                   = $request->param('type','');
        $username                               = $request->param('username','');
        $idcard                                 = $request->param('idcard','');
        $p_qualification                        = $request->param('p_qualification','');
        $p_practice_certificate                 = $request->param('p_practice_certificate','');
        $business_licence                       = $request->param('business_licence','');

        if(empty($username) || empty($idcard)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        if(!checkIdCard($idcard)){
            return $this->returnData([],'身份证号不合法',301);
        }

        $data = [];
        $data['user_id'] = $user_info['id'];
        $data['username'] = $username;
        $data['idcard']   = $idcard;

        if($type == 1){             #个人认证
            $data['type']     = 1;
        }else if($type == 2){      #医生认证
            $data['type']     = 2;
            if(empty($p_qualification)){
                return $this->returnData([],'医师资格证书不能为空',301);
            }
            if(empty($p_practice_certificate)){
                return $this->returnData([],'医师执业证书不能为空',301);
            }

            $data['physician_qualification']            = $p_qualification;
            $data['physician_practice_certificate']     = $p_practice_certificate;
        }else if($type == 3){      #医院认证
            $data['type']     = 3;
            if(empty($business_licence)){
                return $this->returnData([],'医院营业执照不能为空',301);
            }
            $data['business_licence']     = $business_licence;

        }else if($type == 4){      #官方认证
            $data['type']     = 4;
        }

        $isTrue = $this->authDomain->addAuthentication($data);
        if(!$isTrue){
            return $this->returnData([],'认证申请提交失败',305);
        }

        return $this->returnData([],'认证申请提交成功',200);
    }

    /**
     * 获取用户认证结果
     */
    public function getAuthInfo(){

    }
}