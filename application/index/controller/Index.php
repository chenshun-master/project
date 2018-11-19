<?php
namespace app\index\controller;

use think\Request;
use app\api\domain\UserDomain;
use app\api\model\UserModel;

/**
 * Class Index
 * @package app\index\controller
 * @route('index')
 */
class Index extends CController
{

    /**
     * 网站首页
     * @return string
     */
    public function index()
    {
        if(is_weixin()){
            return $this->redirect('/weixin/index/index');
        }

        return $this->redirect('user/main');
    }

    /**
     * 用户登录页面
     * @route('/login','get')
     * @return false|string
     */
    public function login(){
        if($this->checkLogin()){
            return redirect('/index/user/main');
        }

        return $this->fetch('index/login');
    }

    /**
     * 账号密码登录页面
     * @route('index/index/postLogin','post')
     * @param Request $request
     * @return false|string
     */
    public function postLogin(Request $request){
        if($this->checkLogin()){
            return $this->returnData([],'登录成功',200);
        }

        $mobile    = $request->post('mobile','');
        $password  = $request->post('password','');

        if(empty($mobile) || empty($password) || !checkMobile($mobile)){
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
     * 手机帐注册接口提交接口
     * @param Request $request
     * @route('/index/index/postRegister','post')
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function postRegister(Request $request){
        if($this->checkLogin()){
            return $this->returnData([],'已登录不能注册',306);
        }

        $mobile    = $request->post('mobile','');
        $password  = $request->post('password','');
        $sms_code  = $request->post('sms_code','');

        if(empty($mobile) || empty($password) || empty($sms_code) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,1,$sms_code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $userDomain = new UserDomain();
        $result = $userDomain->createUser(['mobile'   =>$mobile,'password' =>$password]);
        if($result === 3){
            return $this->returnData([],'手机号已被使用',304);
        }

        if(!$result){
            return $this->returnData([],'用户注册失败',305);
        }
        return $this->returnData([],'用户注册成功',200);
    }

    /**
     * 手机号重置密码接口
     * @param Request $request
     * @route('/index/index/postResetPassword','post')
     * @return false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function postResetPassword(Request $request){
        $mobile    = $request->post('mobile','');
        $password  = $request->post('password','');
        $sms_code  = $request->post('sms_code','');

        if(empty($mobile) || empty($password) || empty($sms_code) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile,2,$sms_code);
        if($res === 0){
            return $this->returnData([],'验证码错误',302);
        }else if($res === 2){
            return $this->returnData([],'验证码已过期',303);
        }

        $userDomain = new UserDomain();
        $isTrue = $userDomain->resetPassword($mobile,$password);

        if(!$isTrue){
            return $this->returnData([],'密码重置失败',305);
        }

        return $this->returnData([],'密码重置成功',200);
    }

    /**
     * 用户重置密码页面
     * @param Request $request
     * @return mixed
     */
    public function rePwd(Request $request){
        $this->assign([
            'mobile'        =>$request->param('mobile'),
            'sms_code'   =>$request->param('sms_code'),
            'password'   =>$request->param('password')
        ]);

        return $this->fetch('index/login');
    }

    /**
     * 发送短信验证码
     * @param  string  mobile  手机号
     * @param  int     type    验证码用途(1:注册;2:重置密码;3:手机号快捷登录;4:第三方手机号绑定;5:修改密码 6:修改手机号)
     * @param Request $request
     * @route('/index/index/sendSmsCode','post')
     * @return false|string
     */
    public function sendSmsCode(Request $request){
        $mobile    = $request->post('mobile','');
        $type      = $request->post('type','');
        if(empty($mobile) || !checkMobile($mobile)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $sign = 9715;
        $template_id = 12318;

        switch ($type){
            case 1:
                $userModel = new UserModel();
                if($userModel->findMobileExists($mobile)){
                    return $this->returnData([],'该用户已被使用',302);
                }
                break;
            case 2:
                $userModel = new UserModel();
                if(!$userModel->findMobileExists($mobile)){
                    return $this->returnData([],'该用户未被使用',302);
                }
                break;
            case 3:
            case 4:
            case 7:
                break;
            case 5:
                $userModel = new UserModel();
                if(!$userModel->findMobileExists($mobile)){
                    return $this->returnData([],'该用户未被使用',302);
                }
                break;
            case 6:
                $userModel = new UserModel();
                if($userModel->findMobileExists($mobile)){
                    return $this->returnData([],'该用户已被使用',302);
                }
                break;
            default :
                $type = 0;
                break;
        }

        if($type == 0){
            return $this->returnData([],'发送失败',305);
        }else if(in_array($type,[5,6,7])){
            if(!$this->checkLogin()){
                return $this->returnData([],'发送失败',305);
            }
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsObject->sendCode($mobile,$type,$sign,$template_id);

        return $this->returnData([],'发送成功',200);
    }

    /**
     * 404错误
     */
    public function error404(){
        return $this->fetch('error/loss');
    }
}