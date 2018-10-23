<?php
namespace app\index\controller;

class Index extends CController
{

    public function index()
    {
        return 'PC端网站首页---测试';
    }

    public function test(){
        $mobile    = $request->param('mobile','');
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