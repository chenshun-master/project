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

        $infos = Db::name('sp_spread_record')->alias('spread')
            ->leftJoin('sh_order order','order.id = spread.order_id')
            ->where('spread.status',1)->field(['spread.id','spread.uid','spread.type','spread.num'])
            ->select();

        if(!$infos){
            $output->writeln("No data detected");exit;
        }

        foreach ($infos as $data){
            Db::startTrans();
            try {
                if (!$uInfo = Db::name('user')->where('id', $data['uid'])->field('id,score,account')->find()) {
                    throw new \think\Exception('查询分销用户信息失败');
                }

                $getId = 0;
                if($data['type'] === 2){
                    /** 分销产品赠送余额返现*/
                    if (!Db::name('user')->where('id', $data['uid'])->setInc('account', $data['num'])) {
                        throw new \think\Exception('更新账户余额失败');
                    }

                    $accountRecord = [
                        'user_id' => $data['uid'],
                        'status' => 1,'type' => 1,
                        'amount' => $data['num'],
                        'amount_front' => $uInfo['account'],
                        'amount_after' => $uInfo['account'] + $data['num'],
                        'remarks'    =>'商品分销获得佣金奖励',
                        'created_time' => date('Y-m-d H:i:s')
                    ];
                    if (!$getId = Db::name('account_record')->insertGetId($accountRecord)) {
                        throw new \think\Exception('添加账户余额记录失败');
                    }
                }else if($data['type'] === 1){
                    /** 分销产品赠送积分*/
                    if (!Db::name('user')->where('id', $data['uid'])->setInc('score', intval($data['num']))) {
                        throw new \think\Exception('更新账户积分失败');
                    }

                    $scoreRecord = [
                        'user_id' => $data['uid'],
                        'status' => 2,
                        'type' => 1,
                        'score' => intval($data['num']),
                        'score_front' => $uInfo['score'],
                        'score_after' => $uInfo['score'] + intval($data['num']),
                        'remarks'    =>'商品分销赠送积分奖励',
                        'created_time' => date('Y-m-d H:i:s')
                    ];

                    if (!$getId = Db::name('score_record')->insertGetId($scoreRecord)) {
                        throw new \think\Exception('添加积分记录失败');
                    }
                }

                if(!Db::name('sp_spread_record')->where('id',$data['id'])->where('status',1)->update(['status'=>2,'record_id'=>$getId])){
                    throw new \think\Exception('分销产品兑付记录表跟新失败');
                }

                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
        }
    }
}