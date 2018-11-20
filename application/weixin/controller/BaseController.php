<?php
namespace app\weixin\controller;

use think\App;
use think\Controller;
use think\facade\Session;
use think\facade\Url;
use think\route\dispatch\Redirect;
use think\facade\Request;


/**
 * 微信端基类控制器
 * Class BaseController
 * @package app\weixin\controller
 */
class BaseController extends Controller
{

    public $weChatApiClass;
    public function __construct(App $app = null)
    {
        parent::__construct($app);

        #配置Session作用域
        Session::prefix('weixin');
    }

    /**
     * 验证用户是否登录
     */
    protected function checkLogin(){
        return $this->getUserInfo() ? true : false;
    }

    /**
     * 获取用户登录信息
     */
    protected function getUserInfo(){
        $info = Session::get('user_info');
        if($info){
            return $info;
        }
        return false;
    }

    /**
     * 获取用户ID
     * @return int
     */
    protected function getUserId(){
        $info = Session::get('user_info');
        if($info){
            return $info['id'];
        }
        return 0;
    }

    /**
     * 用户信息
     * @param $data
     * @return bool
     */
    protected function saveUserLogin($data){
        Session::set('user_info',$data);
        return true;
    }

    /**
     * 清除用户登录信息
     */
    protected function clearUserLogin(){
        return Session::clear();
    }

    /**
     * ajax返回数据
     * @param array $data    接口数据
     * @param string $msg    信息提示
     * @param int $code      状态码
     * @param int $httpCode  http状态码
     * @return false|string
     */
    protected function returnData($data=[],$msg='',$code = 200,$httpCode=200){
        return json([
            'code' =>$code,
            'msg'  =>$msg,
            'data' =>$data
        ],$httpCode);
    }

    /**
     * 微信授权登录
     * @return type
     */
    public function wxAuthorize($snsapi_userinfo = false){
        $this->weChatApiClass = new \wechat\WeChatApi();

        //获取当前页面
        $redirect = Request::url(true);
        Session::set('previous_page',$redirect);


        //微信授权回调地址
        $url = Url('/weixin/index/authCallback','','',true);
        if(Session::has('wxAuthorize')){
            $wxAuthorize = Session::get('wxAuthorize');
            if($snsapi_userinfo === true && $wxAuthorize['scope'] != 'snsapi_userinfo'){
                $redirect = $this->weChatApiClass->getWeChatAuthCode($url,$redirect,$snsapi_userinfo);
                $this->weChatApiClass->redirect($redirect);exit;
            }else{
                #1.检验用户网页授权凭证（access_token）是否有效
                $valid_result = $this->weChatApiClass->getUserAuthorizeAccessTokenValid($wxAuthorize['access_token'],$wxAuthorize['openid']);
                if(!$valid_result){
                    #2.刷新user access token  ||　refresh user access token还失效 重新获取授权
                    $res = $this->weChatApiClass->refreshUserAuthorizeAccessToken($wxAuthorize['refresh_token']);
                    if(!isset($res['errcode'])){
                        $res['expires_time'] = time() + $res['expires_in'];
                        $res['userinfo'] = [];
                        if($res['scope'] == 'snsapi_userinfo'){
                            $res['userinfo'] = $this->weChatApiClass->getUserAuthorizedUserInfo($res['access_token'],$res['openid']);
                        }

                        Session::set('wxAuthorize',$res);
                    }
                }
            }

            return true;
        }else{
            $redirect = $this->weChatApiClass->getWeChatAuthCode($url,$redirect,true);
            $this->weChatApiClass->redirect($redirect);exit;
        }
    }

    /**
     * 微信授权回调地址
     */
    public function authCallback(Request $request){
        $this->weChatApiClass = new \wechat\WeChatApi();

        $code   = $_GET['code'];
        $state  = $_GET['state'];

        $res = $this->weChatApiClass->getUserAuthorizeAccessToken($code);
        if(!isset($res['errcode'])){
            $res['expires_time'] = time() + $res['expires_in'];
            $res['userinfo'] = [];
            if($res['scope'] == 'snsapi_userinfo'){
                $res['userinfo'] = $this->weChatApiClass->getUserAuthorizedUserInfo($res['access_token'],$res['openid']);
            }

            Session::set('wxAuthorize',$res);
            if($res['userinfo']){
                $obj = new \app\api\domain\RhirdPartyUserDomain();
                $user_info = [
                    'openid'=>$res['userinfo']['openid'],
                    'nick'=>$res['userinfo']['nickname']
                ];

                $myUserInfo = $obj->userHandle($user_info,'weixin');

                #判断第三方账号是否绑定手机号
                if($myUserInfo['binding'] === 1){
                    $userDomain = new \app\api\domain\UserDomain();
                    $info = $userDomain->login($myUserInfo['mobile'],'',true);
                    $this->saveUserLogin($info);

                    ##登录成功跳转到登录页面
                    return redirect(Session::get('previous_page'));
                }else{
                    ##第三方登录未绑定手机号跳转到绑定手机号页面
                    return redirect('/weixin/index/otherLoginBindingMobile')->params(['id'=>$myUserInfo['id']]);
                }
            }

            return redirect(Session::get('previous_page'));
        }
    }

    /**
     * 重定向到用户登录页面
     * @param $redir          登录后跳转地址
     * @return \think\response\Redirect
     */
    public function toLogin($redir = ''){
        #记录跳转路径
        return redirect('index/login');
    }
}