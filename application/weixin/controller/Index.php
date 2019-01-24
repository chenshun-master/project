<?php

namespace app\weixin\controller;

use app\api\domain\UserDomain;
use think\App;
use think\Request;
use app\api\model\UserModel;
use anerg\OAuth2\OAuth;

use think\facade\Session;

class Index extends BaseController
{
    private $articleDomain;
    private $_uDomain;
    private $_userFriendDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->articleDomain = new \app\api\domain\ArticleDomain();

        $this->_uDomain = new \app\api\domain\UDomain();

        $this->_userFriendDomain = new \app\api\domain\UserFriendDomain();
    }

    /**
     * 网站首页
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->fetch('index/index');
    }

    /**
     * 获取首页文章列表
     */
    public function getArticleList(Request $request)
    {
        $type = $request->param('type', 0);
        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $data = $this->articleDomain->getHomeList($page, $page_size, $type);//halt($data);
        $this->assign($data);

        $data['conetnt'] = $this->fetch('index/index_tpl');
        return $this->returnData($data, '', 200);
    }

    /**
     * 用户登录注册页面
     */
    public function loginReister()
    {
        if ($this->checkLogin()) {
            return redirect('/weixin/user/main');
        }

        return $this->fetch('index/loginReister');
    }

    /**
     * 医生主页页面
     */
    public function doctor()
    {
        return $this->fetch('index/doctor');
    }

    /**
     * 用戶登录页
     */
    public function login()
    {
        $redir = $this->request->param('redir', '');
        if (empty($redir)) {
            url('/weixin/user/main', '', '', true);
        } else {
            $redir = base64url_decode($redir);
        }

        if ($this->checkLogin()) {
            return redirect('/weixin/user/main');
        } else if (is_weixin() && config('conf.weixin_automatic_logon')) {
            Session::delete('wxAuthorize');
            $this->wxAuthorize(true, $redir);
        }

        $this->assign('redir', $redir);


        return $this->fetch('index/login');
    }

    /**
     * 找回密码页
     */
    public function backpwd()
    {
        return $this->fetch('index/backpwd');
    }

    /**
     * 用户密码登录提交处理控制器
     */
    public function postLogin(Request $request)
    {
        if ($this->checkLogin()) {
            return $this->returnData([], '登录成功', 200);
        }

        $mobile = $request->param('mobile', '');
        $password = $request->param('password', '');
        if (empty($mobile) || empty($password)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $userDomain = new UserDomain();
        $info = $userDomain->login($mobile, $password);

        if ($info === 2) {
            return $this->returnData([], '用户不存在', 302);
        }

        if ($info === 3) {
            return $this->returnData([], '输入密码错误', 303);
        }

        $this->saveUserLogin($info);
        return $this->returnData([], '登录成功', 200);
    }

    /**
     * 手机短信快捷登录提交处理页面
     */
    public function codeLogin(Request $request)
    {
        $mobile = $request->param('mobile', '');
        $sms_code = $request->param('sms_code', '');

        if (empty($mobile) || empty($sms_code)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile, 3, $sms_code);
        if ($res === 0) {
            return $this->returnData([], '验证码错误', 302);
        } else if ($res === 2) {
            return $this->returnData([], '验证码已过期', 303);
        }

        $userDomain = new UserDomain();
        $info = $userDomain->login($mobile, '', true);

        if ($info === 2) {
            return $this->returnData([], '用户不存在', 304);
        }

        $this->saveUserLogin($info);
        return $this->returnData([], '登录成功', 200);
    }

    /**
     * 用户注册提交处理控制器
     */
    public function postReister(Request $request)
    {
        if ($this->checkLogin()) {
            return $this->returnData([], '已登录不能注册', 306);
        }

        $mobile = $request->param('mobile', '');
        $password = $request->param('password', '');
        $sms_code = $request->param('sms_code', '');
        if (empty($mobile) || empty($password) || empty($sms_code)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $data = [
            'mobile' => $mobile,
            'password' => $password
        ];

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile, 1, $sms_code);
        if ($res === 0) {
            return $this->returnData([], '验证码错误', 302);
        } else if ($res === 2) {
            return $this->returnData([], '验证码已过期', 303);
        }

        $userDomain = new UserDomain();
        $result = $userDomain->createUser($data);
        if ($result === 3) {
            return $this->returnData([], '手机号已被使用', 304);
        }

        if (!$result) {
            return $this->returnData([], '用户注册失败', 305);
        }

        return $this->returnData([], '用户注册成功', 200);
    }

    /**
     * 发送手机注册短信验证码
     */
    public function sendRegisterCode(Request $request)
    {
        $mobile = $request->param('mobile', '');
        if (empty($mobile) || !checkMobile($mobile)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $userModel = new UserModel();
        if ($userModel->findMobileExists($mobile)) {
            return $this->returnData([], '该用户已被使用', 302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsConfig = config('conf.sms_config.yzm');
        $isTrue = $smsObject->sendCode($mobile, 1, $smsConfig['sign'], $smsConfig['template_id']);
        if (!$isTrue) {
            return $this->returnData([], '发送失败', 305);
        }

        return $this->returnData([], '发送成功', 200);
    }

    /**
     * 发送快捷登录验证码
     */
    public function sendQuickLoginSmsCode(Request $request)
    {
        $mobile = $request->param('mobile', '');
        if (empty($mobile) || !checkMobile($mobile)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $userModel = new UserModel();
        if (!$userModel->findMobileExists($mobile)) {
            return $this->returnData([], '该手机号未注册', 302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsConfig = config('conf.sms_config.yzm');
        $isTrue = $smsObject->sendCode($mobile, 3, $smsConfig['sign'], $smsConfig['template_id']);
        if (!$isTrue) {
            return $this->returnData([], '发送失败', 305);
        }

        return $this->returnData([], '发送成功', 200);
    }

    /**
     * 发送第三方登录绑定手机号验证码
     */
    public function sendOtherLoginSmsCode(Request $request)
    {

        $mobile = $request->param('mobile', '');
        $authToken = $request->param('auth_token', '');
        $authType = (int)$request->param('auth_type', 0);

        $authToken = encryptStr(urldecode($authToken), 'D', config('conf.secret_key'));
        if (empty($mobile) || !checkMobile($mobile) || empty($authToken) || !in_array($authType, [1, 2, 3, 4])) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $domain = new \app\api\domain\RhirdPartyUserDomain();
        $res = $domain->getBindingInfo($mobile, $authToken, $authType);
        if ($res) {
            return $this->returnData([], '手机号已绑定第三方账号', 302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsConfig = config('conf.sms_config.yzm');
        $isTrue = $smsObject->sendCode($mobile, 4, $smsConfig['sign'], $smsConfig['template_id']);
        if (!$isTrue) {
            return $this->returnData([], '发送失败', 305);
        }
        return $this->returnData([], '发送成功', 200);
    }

    /**
     * 第三方登录页面
     */
    public function otherLogin(Request $request)
    {
        $platform = $request->param('platform', '');
        if ($platform == 'weixin') {
            Session::delete('wxAuthorize');
            $this->wxAuthorize(true, $request->server('HTTP_REFERER'));
            exit;
        }

        $confData = Config('conf.sns_login.' . $platform);

        //设置回跳地址
        $confData['callback'] = 'https://weixin.alimx.cn/weixin/index/otherLoginCallback?platform=' . $platform;

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
    public function otherLoginCallback(Request $request)
    {
        $platform = $request->param('platform', '');
        $confData = Config('conf.sns_login.' . $platform);

        $snsInfo = OAuth::$platform($confData)->userinfo();

        $obj = new \app\api\domain\RhirdPartyUserDomain();
        $res = $obj->userHandle($snsInfo, $platform);

        #判断第三方账号是否绑定手机号
        if ($res['binding'] === 1) {
            $userDomain = new UserDomain();
            $info = $userDomain->login($res['mobile'], '', true);
            $this->saveUserLogin($info);

            ##登录成功跳转到登录页面
            return redirect('/weixin/user/main');
        }

        ##第三方登录未绑定手机号跳转到绑定手机号页面
        return redirect('/weixin/index/otherLoginBindingMobile')->params(['id' => $res['id']]);
    }

    /**
     * 第三方登录绑定手机号页面
     */
    public function otherLoginBindingMobile(Request $request)
    {
        $auth_token = $request->param('auth_token', '');
        $auth_type = $request->param('type', 0);
        $this->assign('auth_token', $auth_token);
        $this->assign('auth_type', $auth_type);

        $redir = $request->param('redir', '');
        $this->assign('redir', !empty($redir) ? base64url_decode($redir) : '');
        return $this->fetch('index/otherLoginBindingMobile');
    }

    /**
     * 第三方账号绑定手机号处理
     */
    public function bindingMobileHandle(Request $request)
    {
        $mobile = $request->post('mobile', '');
        $sms_code = $request->post('sms_code', '');
        $auth_token = $request->post('auth_token', '');
        $auth_type = $request->post('auth_type', 0);
        $auth_token = encryptStr(urldecode($auth_token), 'D', config('conf.secret_key'));
        if (empty($mobile) || !checkMobile($mobile) || empty($auth_token) || !in_array($auth_type, [1, 2, 3, 4])) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile, 4, $sms_code);
        if ($res === 0) {
            return $this->returnData([], '验证码错误', 302);
        } else if ($res === 2) {
            return $this->returnData([], '验证码已过期', 303);
        }

        $userDomain = new UserDomain();
        $wxAuthorize = Session::get('wxAuthorize');
        $isTrue = $userDomain->bindingMobile($mobile, $auth_token, $auth_type, $wxAuthorize['openid']);
        if ($isTrue) {
            $userDomain = new UserDomain();
            $info = $userDomain->login($mobile, '', true);
            $this->saveUserLogin($info);
            return $this->returnData([], '绑定成功', 200);
        }

        return $this->returnData([], '绑定失败', 305);
    }

    /**
     * 发送重置密码验证码
     */
    public function sendResetPwdSmsCode(Request $request)
    {
        $mobile = $request->param('mobile', '');
        if (empty($mobile) || !checkMobile($mobile)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $userModel = new UserModel();
        if (!$userModel->findMobileExists($mobile)) {
            return $this->returnData([], '该用户未被使用', 302);
        }

        $smsObject = new \app\api\domain\SendSms();
        $smsConfig = config('conf.sms_config.yzm');
        $isTrue = $smsObject->sendCode($mobile, 2, $smsConfig['sign'], $smsConfig['template_id']);
        if (!$isTrue) {
            return $this->returnData([], '发送失败', 305);
        }
        return $this->returnData([], '发送成功', 200);
    }

    /**
     * 重置密码短信验证码验证接口
     */
    public function checkSmsCode(Request $request)
    {
        $mobile = $request->param('mobile', '');
        $code = $request->param('sms_code', '');

        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($mobile, 2, $code);
        if ($res === 0) {
            return $this->returnData([], '验证码错误', 302);
        } else if ($res === 2) {
            return $this->returnData([], '验证码已过期', 303);
        }

        $secret_key = config('conf.secret_key');
        return $this->returnData([
            'mobile' => $mobile,
            'verify_code' => encryptStr($mobile, 'E', $secret_key)
        ], '验证通过', 200);
    }

    /**
     * 用户重置密码页面
     * @param Request $request
     * @return mixed
     */
    public function rePwd(Request $request)
    {
        $this->assign([
            'mobile' => $request->param('mobile'),
            'verify_code' => $request->param('verify_code')
        ]);

        return $this->fetch('index/resetpwd');
    }

    /**
     * 重置密码提交页面
     */
    public function postResetPwd(Request $request)
    {
        $mobile = $request->param('mobile', '');
        $verify_code = $request->param('verify_code', '');
        $password1 = $request->param('password1', '');
        $password2 = $request->param('password2', '');

        if (empty($mobile) || empty($verify_code) || empty($password1) || empty($password2) || !checkMobile($mobile)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        if ($password1 !== $password2) {
            return $this->returnData([], '两次密码不一致', 302);
        }

        $secret_key = config('conf.secret_key');
        $tmp_str = encryptStr($verify_code, 'D', $secret_key);

        if ($tmp_str !== $mobile) {
            return $this->returnData([], '密码重置失败', 305);
        }

        $userDomain = new UserDomain();
        $isTrue = $userDomain->resetPassword($mobile, $password1);

        if (!$isTrue) {
            return $this->returnData([], '密码重置失败', 305);
        }
        return $this->returnData([], '密码重置成功', 200);
    }

    /**
     * 404错误页面
     */
    public function error404()
    {
        return $this->fetch('error/loss');
    }

    /**
     * 我的医院页面
     * @return mixed
     */
    public function hospital()
    {
        return $this->fetch('index/hospital');
    }

    /**
     * 我的医院详情页面
     * @return mixed
     */
    public function hospitalDetails(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $uDomain = new \app\api\domain\UDomain();
        $info = $uDomain->getHospitalInfo($uid);

        $myID = $this->getUserId();
        $isFollow = 0;
        if ($uid == $myID) {
            $isFollow = 2;
        } else if ($uid != $myID) {
            $isFollow = $this->_userFriendDomain->checkFollow((int)$uid, (int)$myID, $myID) ? 1 : 0;
        }

        $this->assign('info', $info);
        $this->assign('statistics', app('domain')->getDomain('udomain')->statistics($uid));
        $this->assign('uid', $uid);
        $this->assign('isFollow', $isFollow);
        return $this->fetch('index/hospital_details');
    }

    /**
     * 医院资料详情页面
     * @return mixed
     */
    public function detailsHospital(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $info = $this->_uDomain->getHospitalDetail($uid);

        $this->assign('info', $info);
        return $this->fetch('index/details_hospital');
    }

    /**
     * 医院证件详情页面
     * @return mixed
     */
    public function hospitalDertificate(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $info = $this->_uDomain->getUserLicence($uid);

        $this->assign('info', $info);

        return $this->fetch('index/hospital_certificate');
    }

    /**
     * 医院荣誉证书详情页面
     * @return mixed
     */
    public function hospitalHonor()
    {

        return $this->fetch('index/hospital_honor');
    }

    /**
     * 我的医生详情页面
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function doctorDetails(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $uDomain = new \app\api\domain\UDomain();
        $info = $uDomain->getDoctorInfo($uid);

        $myID = $this->getUserId();
        $isFollow = 0;
        if ($uid == $myID) {
            $isFollow = 2;
        } else if ($uid != $myID) {
            $isFollow = $this->_userFriendDomain->checkFollow((int)$uid, (int)$myID, $myID) ? 1 : 0;
        }

        $this->assign('info', $info);
        $this->assign('statistics', app('domain')->getDomain('udomain')->statistics($uid));
        $this->assign('uid', $uid);
        $this->assign('isFollow', $isFollow);
        return $this->fetch('index/doctor_details');
    }

    /**
     * 医生资料详情页面
     * @return mixed
     */
    public function detailsDoctor(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $uDomain = new \app\api\domain\UDomain();
        $info = $uDomain->getDoctorInfo($uid);
        $this->assign('info', $info);

        return $this->fetch('index/detailsDoctor');
    }

    /**
     * 显示医生证件页面
     * @return mixed
     */
    public function doctorCertificate(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $uDomain = new \app\api\domain\UDomain();
        $info = $uDomain->getDoctorCertificate($uid);

        $this->assign('info', $info);
        return $this->fetch('index/doctor_certificate');
    }

    /**
     * 显示医生荣誉证书页面
     * @return mixed
     */
    public function honor(Request $request)
    {
        $uid = $request->param('uid/d', 0);
        $model = new UserModel();
        if (!$model->findIdExists($uid)) {
            return $this->fetch('error/loss');
        }

        $uDomain = new \app\api\domain\UDomain();
        $info = $uDomain->getUserHonorCertificate($uid);

        $this->assign('info', $info);
        $this->assign('type', $request->param('type/d', 1));

        return $this->fetch('index/honor');
    }

    /**
     * 发送短信验证码
     * @param  string  mobile  手机号
     * @param  int     type    验证码用途(1:注册;2:重置密码;3:手机号快捷登录;4:第三方手机号绑定;5:修改密码 6:修改手机号)
     * @param Request $request
     * @return false|string
     */
    public function sendSmsCode(Request $request)
    {
        $mobile = $request->post('mobile', '');
        $type = $request->post('type', '');
        if (empty($mobile) || !checkMobile($mobile)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $smsConfig = config('conf.sms_config.yzm');
        $sign = $smsConfig['sign'];
        $template_id = $smsConfig['template_id'];

        switch ($type) {
            case 1:
                $userModel = new UserModel();
                if ($userModel->findMobileExists($mobile)) {
                    return $this->returnData([], '该用户已被使用', 302);
                }
                break;
            case 2:
            case 8:
                $userModel = new UserModel();
                if (!$userModel->findMobileExists($mobile)) {
                    return $this->returnData([], '该用户未被使用', 302);
                }
                break;
            case 3:
            case 4:
            case 7:
                break;
            case 5:
                $userModel = new UserModel();
                if (!$userModel->findMobileExists($mobile)) {
                    return $this->returnData([], '该用户未被使用', 302);
                }
                break;
            case 6:
                $userModel = new UserModel();
                if ($userModel->findMobileExists($mobile)) {
                    return $this->returnData([], '该用户已被使用', 302);
                }
                break;
            default :
                $type = 0;
                break;
        }

        if ($type == 0) {
            return $this->returnData([], '发送失败', 305);
        } else if (in_array($type, [5, 6, 7])) {
            if (!$this->checkLogin()) {
                return $this->returnData([], '发送失败', 305);
            }
        }

        $smsObject = new \app\api\domain\SendSms();
        $isTrue = $smsObject->sendCode($mobile, $type, $sign, $template_id);
        if (!$isTrue) {
            return $this->returnData([], '发送失败', 305);
        }

        return $this->returnData([], '发送成功', 200);
    }

    /**
     * 地图
     * @return mixed
     */
    public function map()
    {

        return $this->fetch('index/map');
    }

    /**
     * 日记页面
     * @return mixed
     */
    public function diaryUser()
    {

        return $this->fetch('index/diary_user');
    }

    /**
     * 问答页面
     * @return mixed
     */
    public function inquiry()
    {
        $data = app('domain')->getDomain('InquiryDomain')->getUserInquiryNum($this->getUserId());

        $this->assign('info',$data);
        $this->assign('nickname',$this->getUserInfo() ?$this->getUserInfo()['nickname']:'');
        $this->assign('portrait',$this->getUserInfo() ?$this->getUserInfo()['portrait']:'');
        $this->assign('isLogin',$this->checkLogin());

        return $this->fetch('index/inquiry');
    }

     /**
      * 问答详情页
      * @return mixed
      */
     public function inquiryDetails(int $id)
     {
         $data = app('domain')->getDomain('InquiryDomain')->getInquiryDetail($id);

         if(!$data){
             return $this->fetch('error/loss');
         }

         $this->assign('info',$data);
         return $this->fetch('index/inquiry-details');
     }



    /**
     * 我的问答详情页
     * @return mixed
     */
    public function answerDetails()
    {
        return $this->fetch('index/answer-details');
    }
}