<?php

namespace app\api\controller;

use app\api\model\SpCategoryModel;
use think\Db;
use app\api\domain\ShOrderDomain;
use app\api\domain\SpGoodsDomain;

class Test
{



    public function tt(){
        $time = date('Y-m-d 00:00:00',strtotime('-7 day'));
        $field = ['spread.id','spread.uid','spread.type','spread.num','order.status as order_status'];

        $infos = Db::name('sp_spread_record')->alias('spread')
            ->join('sh_order order','order.id = spread.order_id')
            ->where('spread.status',1)->field($field)
            ->where('pay_time', '<= time', $time)
            ->select();

        foreach ($infos as $data){
            Db::startTrans();
            try {
                if (!$uInfo = Db::name('user')->where('id', $data['uid'])->field('id,score,account')->find()) {
                    throw new \think\Exception('查询分销用户信息失败');
                }

                if(in_array($data['order_status'],[3,5])){
                    if (!Db::name('user')->where('id', $data['uid'])->inc('score',$data['num'])->dec('lock_score',$data['num'])->update()) {
                        throw new \think\Exception('更新账户积分失败');
                    }

                    $scoreRecord = [
                        'user_id' => $data['uid'],
                        'status' => 1,
                        'type' => 1,
                        'score' => intval($data['num']),
                        'score_front' => $uInfo['score'],
                        'score_after' => $uInfo['score'] + intval($data['num']),
                        'remarks'    =>'分销商品 - 冻结积分解冻',
                        'created_time' => date('Y-m-d H:i:s')
                    ];

                    if (!$getId = Db::name('score_record')->insertGetId($scoreRecord)) {
                        throw new \think\Exception('添加积分记录失败');
                    }

                    if(!Db::name('sp_spread_record')->where('id',$data['id'])->where('status',1)->update(['status'=>2,'thaw_record_id'=>$getId])){
                        throw new \think\Exception('分销产品兑付记录表跟新失败');
                    }
                }
                else{
                    if (!Db::name('user')->where('id', $data['uid'])->dec('lock_score',$data['num'])->update()) {
                        throw new \think\Exception('更新账户积分失败');
                    }

                    $scoreRecord = [
                        'user_id' => $data['uid'],
                        'status' => 0,
                        'type' => 2,
                        'score' => intval($data['num']),
                        'score_front' => $uInfo['score'],
                        'score_after' => $uInfo['score'] + intval($data['num']),
                        'remarks'    =>'分销商品 - 退回冻结积分',
                        'created_time' => date('Y-m-d H:i:s')
                    ];

                    if (!$getId = Db::name('score_record')->insertGetId($scoreRecord)) {
                        throw new \think\Exception('添加积分记录失败');
                    }

                    if(!Db::name('sp_spread_record')->where('id',$data['id'])->where('status',1)->update(['status'=>3,'thaw_record_id'=>$getId])){
                        throw new \think\Exception('分销产品兑付记录表跟新失败');
                    }
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
                halt($e->getMessage());
            }
        }
    }
}