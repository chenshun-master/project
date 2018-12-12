<?php

namespace app\api\domain;

use think\Db;

class ShOrderDomain
{
    /**
     * 获取用户订单列表
     * @param $user_id           用户ID
     * @param int $status        0：待支付、已支付、退款订单   1:待支付   2:已支付,待消费  3:退款订单
     * @param int $page          当前分页
     * @param int $page_size     分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserOrder($user_id,$status=0,$page=1,$page_size=15)
    {
        if($status == 0){
            $status = [1,3,6];
        }else if($status == 1){
            $status = [1];
        }else if($status == 2){
            $status = [3];
        }else if($status == 3){
            $status = [6];
        }

        $obj = Db::name('sh_order')->where('user_id',$user_id)->where('status','in',$status);

        $total = $obj->count(1);
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}