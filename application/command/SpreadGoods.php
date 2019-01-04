<?php
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

/**
 * 商品分销兑付计划任务
 * @package app\command
 */
class SpreadGoods extends Command
{

    protected function configure()
    {
        $this->setName('spreadgoods')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
        $time = date('Y-m-d 00:00:00',strtotime('-7 day'));
        $field = ['spread.id','spread.uid','spread.type','spread.num','order.status as order_status'];
        $infos = Db::name('sp_spread_record')->alias('spread')
            ->join('sh_order order','order.id = spread.order_id')
            ->where('spread.status',1)->field($field)
            ->where('pay_time', '<= time', $time)
            ->select();

        if(!$infos){
            $output->writeln("No data detected");exit;
        }

        foreach ($infos as $data){
            Db::startTrans();
            try {
                if (!$uInfo = Db::name('user')->where('id', $data['uid'])->field('id,score,usable_score')->find()) {
                    throw new \think\Exception('查询分销用户信息失败');
                }

                if(in_array($data['order_status'],[3,5])){
                    if (!Db::name('user')->where('id', $data['uid'])->inc('usable_score',$data['num'])->update()) {
                        throw new \think\Exception('更新账户积分失败');
                    }

                    if (!Db::name('score_record')->where('source_id', $data['id'])->update(['status'=>5])) {
                        throw new \think\Exception('更新积分记录状态失败');
                    }

                    if(!Db::name('sp_spread_record')->where('id',$data['id'])->where('status',1)->update(['status'=>2])){
                        throw new \think\Exception('分销产品兑付记录表跟新失败');
                    }
                }
                else{
                    if (!Db::name('user')->where('id', $data['uid'])->dec('score',$data['num'])->update()) {
                        throw new \think\Exception('更新账户总积分失败');
                    }

                    if (!Db::name('score_record')->where('source_id', $data['id'])->update(['status'=>5])) {
                        throw new \think\Exception('更新积分记录状态失败');
                    }

                    $scoreRecord = [
                        'user_id'       => $data['uid'],
                        'status'        => 6,
                        'type'          => 1,//  商品分销
                        'style'         => 2,//  操作类型 1:增加  2:减少
                        'score'         => intval($data['num']),
                        'remarks'       =>'[分销商品]商品退款，积分奖励退还',
                        'source_id'     =>$data['id'],
                        'created_time'  => date('Y-m-d H:i:s')
                    ];

                    if (!Db::name('score_record')->insertGetId($scoreRecord)) {
                        throw new \think\Exception('添加积分记录失败');
                    }
                }

                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
    }
}