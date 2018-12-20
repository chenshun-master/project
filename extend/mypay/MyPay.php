<?php
namespace mypay;
use mypay\lib\WechatPay;

class MyPay
{

    /**
     * 微信支付实例化入口
     * @return lib\WechatPay
     */
    public static function wechat(){
        return new WechatPay();
    }


    /**
     * 支付宝实例化入口
     * @param array $config  支付接口配置
     */
    public static function alipay($config){

    }
}