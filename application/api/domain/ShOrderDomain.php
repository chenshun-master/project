<?php

namespace app\api\domain;

use think\Db;
use app\api\model\RegionsModel;

class ShOrderDomain
{

    /**
     * 获取用户订单列表
     * @param $user_id           用户ID
     * @param int $status        0：待支付、已支付、退款订单   1:待支付   2:已支付,待消费  3:退款订单 4:已完成订单
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
        }else if($status == 4){
            $status = [5];
        }

        $field = [
            'order.id',
            'order.order_no',
            'order.goods_id',
            'order.user_id',
            'order.img',
            'order.goods_price',
            'order.goods_nums',
            'order.real_amount',
            'doctor.real_name'=>'doctor_name',
            'hospital.hospital_name',
            'order.status',
            'order.goods_name'
        ];

        $obj = Db::name('sh_order')->alias('order');
        if($status == 3){
            $obj->leftJoin('wl_sp_refund_order refund','order.id = refund.order_id');
            $field['refund.status'] = ' refund_status';
        }

        $obj->leftJoin('wl_hospital hospital','hospital.id = order.hospital_id');
        $obj->leftJoin('wl_doctor doctor','doctor.id = order.doctor_id');

        $obj->where('order.user_id',$user_id);
        $obj->where('order.status','in',$status);

        $total = $obj->count(1);
        $rows = $obj->field($field)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取用户订单详情信息
     * @param $user_id            用户ID
     * @param $order_id           订单ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getOrderDetail($user_id,$order_id)
    {
        $data = [];
        $data['order_info'] = (array)$order_info = Db::name('sh_order')->where('user_id',$user_id)->where('id',$order_id)->find();
        return $data;
    }

    public function getPayOrderDetail($user_id,$order_id){
        $obj = Db::name('sh_order')->alias('order');
        $obj->leftJoin('wl_hospital hospital','order.hospital_id = hospital.id');
        $obj->leftJoin('wl_auth auth','auth.user_id = hospital.user_id');

        $obj->where('order.user_id',$user_id);
        $obj->where('order.id',$order_id);
        $obj->field([
            'order.order_no','order.goods_name','order.goods_nums','order.goods_price','order.discount_price','order.payable_amount',
            'order.prepay_price','order.topay_price','order.real_amount','order.pay_type','order.status','order.create_time',
            'auth.province','auth.city','auth.area','auth.address','auth.enterprise_name','order.pay_status'
        ]);

        $info = $obj->find();
        if($info){
            $regionsModel = new RegionsModel();
            $info['address_detail'] = $regionsModel->getAddress([$info['province'],$info['city'],$info['area']],$info['address']);
        }
        return $info;
    }


    /**
     * 获取用户订单列表
     * @param $user_id           用户ID
     * @param int $status        0：待支付、已支付、退款订单   1:待支付   2:已支付,待消费  3:退款订单 4:已完成订单
     * @param int $page          当前分页
     * @param int $page_size     分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSellerOrder($seller_id,$status=0,$page=1,$page_size=15){
        if($status == 0){
            $status = [1,3,6];
        }else if($status == 1){
            $status = [1];
        }else if($status == 2){
            $status = [3];
        }else if($status == 3){
            $status = [6];
        }else if($status == 4){
            $status = [5];
        }

        $field = [
            'order.id',
            'order.order_no',
            'order.goods_id',
            'order.user_id',
            'order.img',
            'order.goods_nums',
            'order.status',
            'goods.name',
            'order.goods_price',
            'order.discount_price',
            'order.payable_amount',
            'order.prepay_price',
            'order.topay_price',
            'order.real_amount',
            'order.pay_time',
            'user.mobile',
            'auth.username',
        ];

        $obj = Db::name('sh_order')->alias('order');

        $obj->leftJoin('wl_sp_goods goods','goods.id = order.goods_id');
        $obj->leftJoin('wl_user user','order.user_id = user.id');
        $obj->leftJoin('wl_auth auth','order.user_id = auth.user_id');

        $obj->where('order.seller_id',$seller_id);
        $obj->where('order.status','in',$status);

        $total = $obj->count(1);
        $rows = $obj->field($field)->page($page,$page_size)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 处理支付订单
     */
    public function  processingOrder($data,$flag =''){
        dump($data);

        $order_no = '';
        if($flag == 'weixin'){
            $order_no = $data['out_trade_no'];
        }else if($flag == 'alipay'){

        }

        $field = [
            'id','real_amount','status','pay_status'
        ];


        $orderRes = Db::name('sh_order')->where('order_no',$order_no)->field($field)->find();
        dump($orderRes['real_amount'] == $data['total_fee']);




        Db::startTrans();
        try {

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            return [false,'处理订单异常',null];
        }
    }
}