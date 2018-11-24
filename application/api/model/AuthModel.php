<?php
namespace app\api\model;

use think\Model;

class AuthModel extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_auth';

    /**
     * 查询身份证号是否已存在
     */
    public function findIdCard($idcard){
        $res = self::where('idcard',$idcard)->field('user_id')->find();
        return $res ? $res['user_id'] : false;
    }

    public function findPhone($mobile){
        $res = self::where('phone',$mobile)->field('user_id')->find();
        return $res ? $res['user_id'] : false;
    }
}