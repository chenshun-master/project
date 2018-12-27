<?php
namespace app\admin\controller;
use think\App;
use think\Controller;
use think\facade\Session;

class BaseController extends Controller
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->view->engine->layout('layout/layout');
    }
    public function initialize()
    {
        parent::initialize();
        //判断是否登录，没有登录跳转登录页面
        if($this->request->isGet() && !$this->request->isAjax()){
            if(!Session::get('user_auth')){
                $u =  $this->request->controller(true).'/'.$this->request->action(true);
                if($u != 'login/index'){
                    header('Location: /admin/login/index');exit;
                }
            }
            $this->assign('user_auth',Session::get('user_auth'));
        }
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