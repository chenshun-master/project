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
        \Log::notice("微信交易记录通知 input".var_export(file_get_contents('php://input'),true));
        $this->Handle(new WxPayConfig(),false);
    }

    /**
     * 微信回调处理入口  1、进行参数校验 2、进行签名验证 3、处理业务逻辑
     * 注意： 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器   2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
     * @param WxPayNotifyResults $objData 回调解释出的参数
     * @param WxPayConfigInterface $config
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return bool|\mypay\lib\wechat\true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function NotifyProcess($objData, $config, &$msg)
    {
        $data = $objData->GetValues();
        $logData = json_encode($data);
        \Log::notice('微信交易记录通知[支付跟踪]  '.var_export($data,true));

        if(!array_key_exists("return_code", $data) || (array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
            $msg = "异常订单";return false;
        }else if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";return false;
        }

        //查询支付订单记录
        $orderInfo = Db::name('sh_order')->alias('order')
            ->leftJoin('wl_sp_good_goods good_goods','good_goods.id = order.good_goods_id')
            ->leftJoin('wl_user touser','touser.id = good_goods.user_id')
            ->where('order.order_no',$data['out_trade_no'])
            ->field('order.id,order.goods_id,.order.good_goods_id,order.status,order.pay_status,order.payable_amount,order.real_amount,good_goods.user_id as uid,touser.type as utype')->find();

        if(!$orderInfo){
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】查询失败] 回调数据: {$logData}");return false;
        }else if(floatval($orderInfo['real_amount'] * 100) !== floatval($data['total_fee'])){
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】支付金额异常] 回调数据: {$logData}");return false;
        }else if($orderInfo['pay_status'] == 1){
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】订单状态为已支付] 回调数据: {$logData}");return true;
        }

        Db::startTrans();
        try {
            $orderUpdateRes  = Db::name('sh_order')->where('order_no',$data['out_trade_no'])->update([
                'pay_type'=>2,
                'status'=>3,
                'pay_status'=>1,
                'pay_time'=>date('Y-m-d H:i:s'),
                'trade_no'=>$data['transaction_id'],
            ]);

            if(!$orderUpdateRes){
                throw new \think\Exception('订单状态更新失败');
            }

            if(!Db::table('wl_sp_goods')->where('id', $orderInfo['goods_id'])->setInc('sale_num')){
                throw new \think\Exception('更新商品预约数失败');
            }

            $paymentRecord = [
                'order_id'        =>$orderInfo['id'],
                'trade_id'        =>$data['transaction_id'],
                'order_no'        =>$data['out_trade_no'],
                'pay_type'        =>2,
                'status'          =>2,
                'money'           =>$orderInfo['real_amount'],
                'attch'           =>json_encode($data),
                'created_time'    =>date('Y-m-d H:i:s'),
            ];

            if(!Db::name('payment_record')->insertGetId($paymentRecord)){
                throw new \think\Exception('订单交易记录插入失败');
            }

            if($orderInfo['good_goods_id'] > 0){
                $score   =   1;
                if(!$recordId = Db::name('sp_spread_record')->insertGetId(['order_id'=> $orderInfo['id'],'uid'=>$orderInfo['uid'],'type'=> 1,'num'=> $score,'status'=>1])){
                    throw new \think\Exception('添加分销兑付记录失败');
                }

                $scoreRecord = [
                    'user_id'       => $orderInfo['uid'],
                    'status'        => 4,
                    'type'          => 1,//  商品分销
                    'style'         => 1,//  操作类型 1:增加  2:减少
                    'score'         => intval($score),
                    'remarks'       =>'[分销商品]积分奖励',
                    'source_id'     =>$recordId,
                    'created_time'  => date('Y-m-d H:i:s')
                ];

                if (!Db::name('score_record')->insertGetId($scoreRecord)) {
                    throw new \think\Exception('添加积分记录失败');
                }

                if (!Db::name('user')->where('id', $orderInfo['uid'])->setInc('score', intval($score))) {
                    throw new \think\Exception('更新账户冻结积分失败');
                }
            }

            Db::commit();return true;
        } catch (\Exception $e) {
            \Log::notice("微信交易记录通知【订单号[{$data['out_trade_no']}】订单状态更新失败,服务器发送错误][错误信息:{$e->getMessage()}] 回调数据:{$logData}");
            Db::rollback();
            return false;
        }
    }
}