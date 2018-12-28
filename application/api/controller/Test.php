<?php

namespace app\api\controller;

use app\api\model\SpCategoryModel;
use think\Db;
use app\api\domain\ShOrderDomain;
use app\api\domain\SpGoodsDomain;

class Test
{
    public function myTest()
    {
        $user_id = 71;
        $score = 5;
        Db::startTrans();
        try {
            $user_info = Db::name('user')->where('id', $user_id)->field('id,score')->find();
            if (!$user_info) {
                throw new \think\Exception('异常消息阿斯蒂芬阿萨德发生的');
            }

            $res = Db::name('user')->where('id', $user_id)->setInc('score', $score);
            if (!$res) {
                throw new \think\Exception('异常消息');
            }

            $data = [
                'user_id' => $user_info['id'],
                'status' => 2,
                'type' => 1,
                'score' => $score,
                'score_front' => $user_info['score'],
                'score_after' => $user_info['score'] + $score,
                'created_time' => date('Y-m-d H:i:s')
            ];

            $res = Db::name('score_record')->insertGetId($data);
            if (!$res) {
                throw new \think\Exception('异常消息');
            }

            Db::commit();
            return $res;
        } catch (\Exception $e) {
            Db::rollback();
            halt($e->getMessage());
        }
    }

    public function tt()
    {

        halt(formatMoney(18.012341)) ;

        exit;
        $score = 5;
        $amount = 5;
        $orderInfo = Db::name('sh_order')
            ->alias('order')
            ->leftJoin('wl_sp_good_goods good_goods','good_goods.id = order.good_goods_id')
            ->leftJoin('wl_user touser','touser.id = good_goods.user_id')
            ->where('order.order_no','20181227135222283645')
            ->field('order.id,order.goods_id,.order.good_goods_id,order.status,order.pay_status,order.real_amount,good_goods.user_id as uid,touser.type as utype')
            ->find();

        if($orderInfo && $orderInfo['uid']){
            if (!$uInfo = Db::name('user')->where('id', $orderInfo['uid'])->field('id,score,account')->find()) {
                throw new \think\Exception('异常消息阿斯蒂芬阿萨德发生的');
            }

            $type = 0;
            $getId = 0;
            if($orderInfo['utype'] === 2){
                /** 分销产品赠送余额返现*/
                if (!Db::name('user')->where('id', $orderInfo['uid'])->setInc('account', $amount)) {
                    throw new \think\Exception('更新账户余额失败');
                }

                $accountRecord = ['user_id' => $orderInfo['uid'],'status' => 1,'type' => 1,'amount' => $score, 'amount_front' => $uInfo['account'], 'amount_after' => $uInfo['account'] + $amount, 'created_time' => date('Y-m-d H:i:s')];
                if (!$getId = Db::name('account_record')->insertGetId($accountRecord)) {
                    throw new \think\Exception('添加账户余额记录失败');
                }

                $type = 2;
            }else if($orderInfo['utype'] === 1){
                /** 分销产品赠送积分*/
                if (!Db::name('user')->where('id', $orderInfo['uid'])->setInc('score', $score)) {
                    throw new \think\Exception('更新账户积分失败');
                }

                $scoreRecord = ['user_id' => $orderInfo['uid'], 'status' => 2, 'type' => 1, 'score' => $score, 'score_front' => $uInfo['score'], 'score_after' => $uInfo['score'] + $score, 'created_time' => date('Y-m-d H:i:s')];
                if (!$getId = Db::name('score_record')->insertGetId($scoreRecord)) {
                    throw new \think\Exception('添加积分记录失败');
                }

                $type = 1;
            }

            $isTrue1 = Db::name('sp_spread_record')->insertGetId([
                'order_id'  => $orderInfo['id'],
                'type'      => $type,
                'record_id' => $getId,
                'created_time' => date('Y-m-d H:i:s')
            ]);

            if(!$isTrue1){
                throw new \think\Exception('添加分销兑换记录失败');
            }
        }
    }
}