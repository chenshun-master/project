<?php
namespace app\admin\controller;
use think\App;
use think\Controller;

class BaseController extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->view->engine->layout('layout/layout');
    }
    public function initialize()
    {
        // 判断是否登录，没有登录跳转登录页面
        if(!session('user_info')){
            return $this->fetch('login/index');
        }
    }

    /**
     * 返回接口数据
     * @param array $data    接口数据
     * @param string $msg    信息提示
     * @param int $code      状态码
     * @return false|string
     */
    protected function returnData($data=[],$msg='',$code = 200){
        return json_encode([
            'code' =>$code,
            'msg'  =>$msg,
            'data' =>$data
        ]);
    }
}