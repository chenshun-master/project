<?php
namespace app\api\model;

use think\Model;


class ScoreRecordModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_score_record';


    //积分的操作类型
    public static $type = [
        1=>'普通用户商品分销获取积分奖励',
    ];
}