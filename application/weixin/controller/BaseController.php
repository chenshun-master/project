<?php
namespace app\weixin\controller;

use think\App;
use think\Controller;
use think\facade\Session;
use think\route\dispatch\Redirect;

/**
 * 微信端基类控制器
 * Class BaseController
 * @package app\weixin\controller
 */
class BaseController extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        #配置Session作用域
        //Session::prefix('weixin');

        #判断是否为微信浏览器
        if(is_weixin() && config('conf.weixin_automatic_logon')){
            return $this->redirect('weixin/index/otherLogin?platform=weixin');
        }
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
}