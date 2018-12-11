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
     /**
      *支付页面
      */
    public function pay(){
        return $this->fetch('shop/pay');
     }
     /**
       *支付方式
       */
     public function methodPayment(){
          return $this->fetch('shop/method_payment');
       }
     /**
       *我的订单
       */
     public function myOrder(){
          return $this->fetch('shop/my_order');
       }

     /**
       *订单详情
       */
     public function orderDetails(){
          return $this->fetch('shop/order_details');
       }
     /**
       *支付成功页面
       */
     public function paySuccess(){
          return $this->fetch('shop/pay_success');
       }
      /**
        *用户相册详情页
        */
      public function fairyAlbum(){
           return $this->fetch('shop/fairy_album');
        }

}