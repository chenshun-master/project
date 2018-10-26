<?php
namespace app\weixin\controller;
use app\api\domain\UserDomain;
use think\Request;
use app\api\model\UserModel;
use anerg\OAuth2\OAuth;
class Index extends BaseController
{
    /**
     * 网站首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('index/index');
    }

    /**
     * 用户登录注册页面
     */
    public function loginReister(){
        if($this->checkLogin()){
            return redirect('/weixin/user/main');
        }

        return $this->fetch('index/loginReister');
    }

	/**
	 * 用戶登录页
     */
	 public function login(){
        if($this->checkLogin()){
            return redirect('/weixin/user/main');
        }

         #判断是否为微信浏览器
         if(is_weixin() && config('conf.weixin_automatic_logon')){
             return $this->redirect('weixin/index/otherLogin?platform=weixin');
         }

        return $this->fetch('index/login');
    }
      /**
     * 用户主页
     */
    public function homepage(){
        return $this->fetch('index/home_page');

    }
    /**
	 * 找回密码页
     */
	 public function backpwd(){
        return $this->fetch('index/backpwd');
     }

    /**
     * 用户密码登录提交处理控制器
     */
    public function postLogin(Request $request){
        if($this->checkLogin()){
            return $this->returnData([],'登录成功',200);
        }

        $mobile    = $request->param('mobile','');
        $password  = $request->param('password','');
        if(empty($mobile) || empty($password)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $userDomain = new UserDomain();
        $info = $userDomain->login($mobile,$password);

        if($info === 2){
            return $this->returnData([],'用户不存在',302);
        }

        if($info === 3){
            return $this->returnData([],'输入密码错误',303);
        }

        $this->saveUserLogin($info);
        return $this->returnData([],'登录成功',200);
    }

    /**
     * 手机短信快捷登录提交处理页面
     */
    public function codeLogin(Request $request){
        $mobile    = $request->param('mobile','');
        $sms_code  = $request->param('sms_code','');

        if(empty($mobile) || empty($sms_code)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,3,$sms_code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $userDomain = new UserDomain();
        $info = $userDomain->login($mobile,'',true);

        if($info === 2){
            return $this->returnData([],'用户不存在',304);
        }

        $this->saveUserLogin($info);
        return $this->returnData([],'登录成功',200);
    }

    /**
     * 用户注册提交处理控制器
     */
    public function postReister(Request $request){
        if($this->checkLogin()){
            return $this->returnData([],'已登录不能注册',306);
        }

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
        if($result === 3){
            return $this->returnData([],'手机号已被使用',304);
        }

        if(!$result){
            return $this->returnData([],'用户注册失败',305);
        }

        return $this->returnData([],'用户注册成功',200);
    }

    /**
     * 发送手机注册短信验证码
     */
    public function sendRegisterCode(Request $request){
        $mobile    = $request->param('mobile','');
        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $userModel = new UserModel();
        if($userModel->findMobileExists($mobile)){
            return $this->returnData([],'该用户已被使用',302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $isTrue = $smsObject->sendCode($mobile,1,9715,12318);
        if(!$isTrue){
            return $this->returnData([],'发送失败',305);
        }
        return $this->returnData([],'发送成功',200);
    }

    /**
     * 发送快捷登录验证码
     */
    public function sendQuickLoginSmsCode(Request $request){
        $mobile    = $request->param('mobile','');
        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $userModel = new UserModel();
        if(!$userModel->findMobileExists($mobile)){
            return $this->returnData([],'该手机号未注册',302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsObject->sendCode($mobile,3,9715,12318);
        return $this->returnData([],'发送成功',200);
    }

    /**
     * 发送第三方登录绑定手机号验证码
     */
    public function sendOtherLoginSmsCode(Request $request){

        $mobile    = $request->param('mobile','');
        $id    = $request->param('id','');
        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $domain = new \app\api\domain\RhirdPartyUserDomain();

        $res = $domain->getBindingInfo($mobile,$id);
        if($res){
            return $this->returnData([],'手机号已绑定第三方账号',302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsObject->sendCode($mobile,4,9715,12318);

        return $this->returnData([],'发送成功',200);
    }

    /**
     * 第三方登录页面
     */
    public function otherLogin(Request $request){
        $platform    = $request->param('platform','');

        //获取配置
        $confData = Config('conf.sns_login.' . $platform);

        //设置回跳地址
        $confData['callback'] = 'https://weixin.alimx.cn/weixin/index/otherLoginCallback?platform='.$platform;

        /**
         * 对于微博，如果登录界面要适用于手机，则需要设定->setDisplay('mobile')
         * 对于微信，如果是公众号登录，则需要设定->setDisplay('mobile')，否则是WEB网站扫码登录
         * 其他登录渠道的这个设置没有任何影响，为了统一，可以都写上
         */
        return redirect(OAuth::$platform($confData)->setDisplay('mobile')->getRedirectUrl());
    }

    /**
     * 第三方登录回调处理登录页面
     */
    public function otherLoginCallback(Request $request){
        $platform    = $request->param('platform','');
        $confData = Config('conf.sns_login.' . $platform);

        $snsInfo = OAuth::$platform($confData)->userinfo();

        $obj = new \app\api\domain\RhirdPartyUserDomain();
        $res = $obj->userHandle($snsInfo,$platform);

        #判断第三方账号是否绑定手机号
        if($res['binding'] === 1){
            $userDomain = new UserDomain();
            $info = $userDomain->login($res['mobile'],'',true);
            $this->saveUserLogin($info);

            ##登录成功跳转到登录页面
            return redirect('/weixin/user/main');
        }

        ##第三方登录未绑定手机号跳转到绑定手机号页面
        return redirect('/weixin/index/otherLoginBindingMobile')->params(['id'=>$res['id']]);
    }

    /**
     * 第三方登录绑定手机号页面
     */
    public function otherLoginBindingMobile(Request $request){
        $id    = $request->param('id','');

        return $this->fetch('index/otherLoginBindingMobile');
    }

    /**
     * 第三方账号绑定手机号处理
     */
    public function bindingMobileHandle(Request $request){
        $mobile    = $request->param('mobile','');
        $id    = $request->param('id','');
        $sms_code  = $request->param('sms_code','');

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,4,$sms_code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $userDomain = new UserDomain();
        $isTrue = $userDomain->bindingMobile($mobile,$id);

        if($isTrue){
            $userDomain = new UserDomain();
            $info = $userDomain->login($res['mobile'],'',true);
            $this->saveUserLogin($info);
            return $this->returnData([],'绑定成功',200);
        }

        return $this->returnData([],'绑定失败',305);
    }

    /**
     * 发送重置密码验证码
     */
    public function sendResetPwdSmsCode(Request $request){
        $mobile    = $request->param('mobile','');
        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $userModel = new UserModel();
        if(!$userModel->findMobileExists($mobile)){
            return $this->returnData([],'该用户未被使用',302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $isTrue = $smsObject->sendCode($mobile,2,9715,12318);
        if(!$isTrue){
            return $this->returnData([],'发送失败',305);
        }
        return $this->returnData([],'发送成功',200);
    }

    /**
     * 重置密码短信验证码验证接口
     */
    public function checkSmsCode(Request $request){
        $mobile    = $request->param('mobile','');
        $code    = $request->param('sms_code','');

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
     * 用户重置密码页面
     * @param Request $request
     * @return mixed
     */
    public function rePwd(Request $request){
        $this->assign([
            'mobile'        =>$request->param('mobile'),
            'verify_code'   =>$request->param('verify_code')
        ]);

        return $this->fetch('index/resetpwd');
    }

    /**
     * 重置密码提交页面
     */
    public function postResetPwd(Request $request){
        $mobile         = $request->param('mobile','');
        $verify_code    = $request->param('verify_code','');
        $password1      = $request->param('password1','');
        $password2      = $request->param('password2','');

        if(empty($mobile) || empty($verify_code) || empty($password1) || empty($password2) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        if($password1 !== $password2){
            return $this->returnData([],'两次密码不一致',302);
        }

        $secret_key = config('conf.secret_key');
        $tmp_str =  encryptStr($verify_code,'D',$secret_key);

        if($tmp_str !== $mobile){
            return $this->returnData([],'密码重置失败',305);
        }

        $userDomain = new UserDomain();
        $isTrue = $userDomain->resetPassword($mobile,$password1);

        if(!$isTrue){
            return $this->returnData([],'密码重置失败',305);
        }
        return $this->returnData([],'密码重置成功',200);
    }


    /**
     * 404错误页面
     */
    public function error404(){
        echo '404 错误页面';
    }

    /**
     * 404错误页面
     */
    public function error500(){
        echo '500 错误页面';
    }

}
