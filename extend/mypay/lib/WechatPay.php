<?php
namespace mypay\lib;

use mypay\lib\wechat\WxPayApi;
use mypay\lib\wechat\WxPayUnifiedOrder;
use mypay\lib\wechat\WxPayConfig;
use mypay\lib\wechat\JsApiPay;
use mypay\lib\wechat\WxPayNotify;

/**
 * 微信支付入口类
 * @package mypay\lib
 */
class WechatPay
{

    /**
     * 公众号支付
     * @param $params 订单参数
     * @return array|bool
     */
    public function mp($params)
    {
        try{
            $mustKeys = ['body','out_trade_no','total_fee','notify_url','openid'];

            $intersection = array_intersect($mustKeys,array_keys($params));
            if($mustKeys != $intersection){
                throw new \think\Exception('订单缺少参数');
            }

            \Log::error('支付调试1   '.json_encode($params));

            $input = new WxPayUnifiedOrder();
            $input->SetBody($params['body']);
            if(isset($params['attach']) && empty($params['attach'])){
                //附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用。
                $input->SetAttach($params['attach']);
            }

            $input->SetOut_trade_no($params['out_trade_no']);                                                           //商户订单号
            $input->SetTotal_fee($params['total_fee']);                                                                 //标价金额 支付总金额
            $input->SetFee_type('CNY');
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetNotify_url($params['notify_url']);
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($params['openid']);
            $config = new WxPayConfig();
            $order = WxPayApi::unifiedOrder($config, $input);
            $jsApiParameters = [];


            \Log::error('支付调试2   '.json_encode($order));
            if($order['return_code'] == 'SUCCESS'){
                $tools = new JsApiPay();
                $jsApiParameters = $tools->GetJsApiParameters($order);
            }

            \Log::error('支付调试3   '.json_encode($jsApiParameters));
            if($order['return_code'] == 'FAIL'){
                return [false,$order['return_code'],$jsApiParameters];
            }

            return [true,$order['return_code'],$jsApiParameters];
        } catch(\Exception $e) {
            \Log::error(json_encode($e));
            return [false,$e->getMessage(),null];
        }
    }

    /**
     * PC端扫码支付 模式二
     * 流程：
     *      1、调用统一下单，取得code_url，生成二维码
     *      2、用户扫描二维码，进行支付
     *      3、支付完成之后，微信服务器会通知支付成功
     *      4、在支付成功通知中需要查单确认是否真正支付成功
     * @param $params
     * @return array
     */
    public function scan($params)
    {
        try{
            $mustKeys = ['body','out_trade_no','total_fee','notify_url','product_id'];
            $intersection = array_intersect($mustKeys,array_keys($params));
            if($mustKeys != $intersection){
                throw new \think\Exception('订单缺少参数');
            }

            $input = new WxPayUnifiedOrder();
            $input->SetBody($params['body']);
            if(isset($params['attach']) && empty($params['attach'])){
                $input->SetAttach($params['attach']);
            }
            $input->SetOut_trade_no($params['out_trade_no']);                                                           //商户订单号
            $input->SetTotal_fee($params['total_fee']);                                                                 //标价金额 支付总金额
            $input->SetFee_type('CNY');                                                                          //标价币种
            $input->SetNotify_url($params['notify_url']);                                                               //通知地址
            $input->SetTrade_type("NATIVE");                                                                     //交易类型
            $input->SetProduct_id($params['product_id']);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));

            $notify = new NativePay();
            $result = $notify->GetPayUrl($input);
            return [true,'SUCCESS',$result["code_url"]];
        } catch(\Exception $e) {
            \Log::error(json_encode($e));
            return [false,$e->getMessage(),null];
        }
    }

    /**
     * 微信退款申请入口
     * @param $params
     * @return array
     * @throws \think\Exception
     */
    public function refund($params){
        try{
            $mustKeys = ['total_fee','refund_fee','refund_no'];
            $intersection = array_intersect($mustKeys,array_keys($params));
            if($mustKeys != $intersection){
                throw new \think\Exception('订单缺少参数');
            }

            $input = new WxPayRefund();
            $config = new WxPayConfig();

            if($params['transaction_id']){
                $input->SetTransaction_id($params['transaction_id']);
            }else if($params['out_trade_no']){
                $input->SetOut_trade_no($params['out_trade_no']);
            }else{
                throw new \think\Exception('订单缺少参数');
            }

            $input->SetTotal_fee($params['total_fee']);
            $input->SetRefund_fee($params['refund_fee']);
            $input->SetOut_refund_no($params['refund_no']);
            $input->SetOp_user_id($config->GetMerchantId());

            $data = WxPayApi::refund($config, $input);
            return [true,'SUCCESS',$data];
        } catch(Exception $e) {
            return [false,$e->getMessage(),null];
        }
    }

    /**
     * 退款查询入口
     * @param $params   查询参数
     * @return array
     * @throws \think\Exception
     */
    public function refundQuery($params){
        try{
            $input = new WxPayRefundQuery();
            if($params['transaction_id']){
                $input->SetTransaction_id($params['transaction_id']);
            }else if($params['out_trade_no']){
                $input->SetOut_trade_no($params['out_trade_no']);
            }else if($params['out_refund_no']){
                $input->SetOut_refund_no($params['out_refund_no']);
            }else if($params['refund_id']){
                $input->SetRefund_id($params['refund_id']);
            }else{
                throw new \think\Exception('订单缺少参数');
            }

            $data = WxPayApi::refundQuery(new WxPayConfig(), $input);
            return [true,'SUCCESS',$data];
        } catch(Exception $e) {
            return [false,$e->getMessage(),null];
        }
    }
}