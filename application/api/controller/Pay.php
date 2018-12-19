<?php
namespace app\api\controller;

use mypay\MyPay;
use mypay\lib\wechat\WxPayConfig;
use mypay\lib\wechat\WxPayNotify;
use app\api\domain\ShOrderDomain;

class Pay extends  WxPayNotify
{
    /**
     *  微信支付回调通知接口
     */
    public function notify(){
        $GLOBALS['HTTP_RAW_POST_DATA'] = $xml = <<<TCN
                    <xml>
                      <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
                      <attach><![CDATA[支付测试]]></attach>
                      <bank_type><![CDATA[CFT]]></bank_type>
                      <fee_type><![CDATA[CNY]]></fee_type>
                      <is_subscribe><![CDATA[Y]]></is_subscribe>
                      <mch_id><![CDATA[10000100]]></mch_id>
                      <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
                      <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
                      <out_trade_no><![CDATA[20181215160439286473]]></out_trade_no>
                      <result_code><![CDATA[SUCCESS]]></result_code>
                      <return_code><![CDATA[SUCCESS]]></return_code>
                      <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
                      <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
                      <time_end><![CDATA[20140903131540]]></time_end>
                      <total_fee><![CDATA[176.01]]></total_fee>
                      <coupon_fee><![CDATA[10]]></coupon_fee>
                    <coupon_count><![CDATA[1]]></coupon_count>
                    <coupon_type><![CDATA[CASH]]></coupon_type>
                    <coupon_id><![CDATA[10000]]></coupon_id>
                    <coupon_fee_0><![CDATA[100]]></coupon_fee_0>
                      <trade_type><![CDATA[JSAPI]]></trade_type>
                      <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
                    </xml>
TCN;

        $this->Handle(new WxPayConfig(),false);
    }

    /**
     *
     * 微信回调处理入口  1、进行参数校验 2、进行签名验证 3、处理业务逻辑
     * 注意： 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器   2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
     * @param WxPayNotifyResults $objData 回调解释出的参数
     * @param WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();

        //1、进行参数校验
        if(!array_key_exists("return_code", $data) ||(array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            \Log::notice('微信交易记录通知[异常订单]  '.var_export($data,true));
            $msg = "异常订单";return false;
        }else if(!array_key_exists("transaction_id", $data)){
            \Log::notice('微信交易记录通知[输入参数不正确]  '.var_export($data,true));
            $msg = "输入参数不正确";return false;
        }

        //2、进行签名验证(父类已验证通过)

        //3、处理业务逻辑
        $domain = new ShOrderDomain();
        return $domain->processingOrder($data,'weixin');
    }
}