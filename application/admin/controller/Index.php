<?php
namespace app\admin\controller;


use think\Db;

class Index extends BaseController
{
    public function index(){

        return $this->fetch('/layout/index');

    }

    public function getUserInfo(){
        $info = Db::name('admin')->where('username',$username)->find();
    }
}
