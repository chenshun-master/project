<?php
namespace app\seller\controller;
use think\App;
use think\Controller;
use think\facade\Session;
use think\route\dispatch\Redirect;

class BaseController extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        #配置Session作用域
        Session::prefix('seller');

        if($this->request->isGet() && !$this->request->isAjax()){
            if(!$this->checkLogin()){
                $u =  $this->request->controller(true).'/'.$this->request->action(true);
                if($u != 'index/login'){
                    header('Location: /seller/index/login');exit;
                }
            }
            $this->assign('user_info',$this->getUserInfo());
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
     * 获取用户登录信息
     */
    protected function getSellerId(){
        $info = Session::get('user_info');
        if($info){
            return $info['seller_id'];
        }
        return 0;
    }

    /**
     * 获取用户ID
     * @return int
     */
    protected function getUserId(){
        $info = Session::get('user_info');
        if($info){
            return $info['user_id'];
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
     * 获取医院ID
     * @return int|mixed
     */
    protected function getHospitalId(){
        if(!$this->getUserId()){
            return 0;
        }

        return (new \app\api\model\HospitalModel())->findId($this->getUserId());
    }
}