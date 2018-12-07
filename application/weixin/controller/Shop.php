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
    /**
     *商城详情页
     */
    public function goodsDetails(){
        return $this->fetch('shop/goods_details');
    }

}