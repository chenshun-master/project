<?php
namespace app\api\controller;

use mypay\MyPay;
use mypay\lib\wechat\WxPayConfig;
use mypay\lib\wechat\WxPayNotify;
use app\api\domain\ShOrderDomain;
use think\Db;

class Pay extends  WxPayNotify
{
    /**
     *  微信支付回调通知接口
     */
    public function notify(){
        $GLOBALS['HTTP_RAW_POST_DATA'] = <<<CTN
                <xml>
                  <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
                  <attach><![CDATA[支付测试]]></attach>
                  <bank_type><![CDATA[CFT]]></bank_type>
                  <fee_type><![CDATA[CNY]]></fee_type>
                  <is_subscribe><![CDATA[Y]]></is_subscribe>
                  <mch_id><![CDATA[10000100]]></mch_id>
                  <nonce_str><![CDATA[5d2b6c2a8db53831f7eda20af46e531c]]></nonce_str>
                  <openid><![CDATA[oUpF8uMEb4qRXf22hE3X68TekukE]]></openid>
                  <out_trade_no><![CDATA[20181220145305451785]]></out_trade_no>
                  <result_code><![CDATA[SUCCESS]]></result_code>
                  <return_code><![CDATA[SUCCESS]]></return_code>
                  <sign><![CDATA[B552ED6B279343CB493C5DD0D78AB241]]></sign>
                  <sub_mch_id><![CDATA[10000100]]></sub_mch_id>
                  <time_end><![CDATA[20140903131540]]></time_end>
                  <total_fee>9900</total_fee>
                <coupon_fee_0><![CDATA[10]]></coupon_fee_0>
                <coupon_count><![CDATA[1]]></coupon_count>
                <coupon_type><![CDATA[CASH]]></coupon_type>
                <coupon_id><![CDATA[10000]]></coupon_id> 
                  <trade_type><![CDATA[JSAPI]]></trade_type>
                  <transaction_id><![CDATA[1004400740201409030005092168]]></transaction_id>
                </xml>
CTN;



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
        halt($data);
        \Log::notice('微信交易记录通知[支付跟踪]  '.var_export($data,true));

        //1、进行参数校验
        if(!array_key_exists("return_code", $data) || (array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            \Log::notice('微信交易记录通知[异常订单]  '.var_export($data,true));
            $msg = "异常订单";return false;
        }else if(!array_key_exists("transaction_id", $data)){
            \Log::notice('微信交易记录通知[输入参数不正确]  '.var_export($data,true));
            $msg = "输入参数不正确";return false;
        }

        //2、进行签名验证(父类已验证通过)

        //3、处理业务逻辑
        $res = Db::name('sh_order')->where('order_no',$data['out_trade_no'])->field('id,status,pay_status,real_amount')->find();
        if(!$res){
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】查询失败] ".json_encode($data));
            return false;
        }else if(floatval($res['real_amount'] * 100) === floatval($data['total_fee'])){
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】支付金额异常] ".json_encode($data));
            return false;
        }else if($res['pay_status'] == 1){
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】订单状态为已支付] ".json_encode($data));
            return true;
        }


        Db::startTrans();
        try {
            $orderUpdateRes  = Db::name('sh_order')->where('order_no',$data['out_trade_no'])->update([
                'pay_type'=>2,
                'pay_status'=>1,
                'pay_time'=>date('Y-m-d H:i:s'),
                'trade_no'=>$data['transaction_id'],
            ]);

            if(!$orderUpdateRes){
                throw new \think\Exception('订单状态更新失败');
            }

            $paymentRecord = [
                'order_id'        =>$data['id'],
                'trade_id'        =>$data['transaction_id'],
                'order_no'        =>$data['out_trade_no'],
                'pay_type'        =>2,
                'status'          =>2,
                'money'           =>$res['real_amount'],
                'attch'           =>json_encode($data),
                'created_time'    =>date('Y-m-d H:i:s'),
            ];


            if(!Db::name('payment_record')->insertGetId($paymentRecord)){
                throw new \think\Exception('订单交易记录插入失败');
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            \Log::error("微信交易记录通知【订单号[{$data['out_trade_no']}】订单状态更新失败,服务器发送错误]".json_encode($e));
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】订单处理失败] 提示信息：{$e->getMessage()}");
            return false;
        }
    }
}