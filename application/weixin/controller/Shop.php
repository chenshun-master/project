<?php
namespace app\weixin\controller;

class Shop extends BaseController
{


    /**
     *商城首页
     */
    public function index(){
        return $this->fetch('shop/index');
    }

}