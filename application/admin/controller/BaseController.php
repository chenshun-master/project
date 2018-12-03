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
}