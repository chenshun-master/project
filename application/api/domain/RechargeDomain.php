<?php
namespace app\api\domain;

use think\Db;

class RechargeDomain
{
    /**
     * 创建充值订单记录
     */
    public function addRechargeOrder(array $params){
        $data = [
            'user_id'       =>$params['user_id'],
            'mode'          =>$params['mode'],
            'account'       =>$params['account'],
            'return_url'    =>$params['return_url'],
            'notify_url'    =>$params['notify_url'],
            'request_ip'    =>$params['request_ip'],
            'created_time'  =>date('Y-m-d H:i:s')
        ];

        return Db::name('recharge_record')->insertGetId($data);
    }

    /**
     *  处理充值订单
     */
    public function handleRechargeOrder(){

    }
}