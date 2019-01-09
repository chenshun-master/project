<?php
namespace app\index\controller;

use think\App;
use think\Controller;
use think\facade\Session;

/**
 * 微信端基类控制器
 * Class BaseController
 * @package app\weixin\controller
 */
class CController extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        #配置Session作用域
        Session::prefix('PC');



        if($this->request->isGet() && !$this->request->isAjax()){
            if($u = $this->getUserInfo()){
                $this->assign('u',[
                    'type'      =>$u['type'],
                    'nickname'  =>$u['nickname']
                ]);
            }
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
     * 获取登陆用户id
     */
    protected function getUserId(){
        $info = Session::get('user_info');
        if($info){
            return $info['id'];
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


    /**
     * 404错误页面
     */
    public function error404(){
        echo '404 错误页面';
    }

    /**
     * 500错误页面
     */
    public function error500(){
        echo '500 错误页面';
    }
}