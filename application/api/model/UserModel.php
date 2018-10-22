<?php
namespace app\api\model;
use think\Model;

class UserModel extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_user';

    public function findMobileExists($mobile){
        $res = self::where('mobile',$mobile)->find();
        return  $res ? true : false;
    }

    public function findMobile($mobile){
        return  self::where('mobile',$mobile)->find();
    }

    public function findUserId($user_id){
        return  self::where('id',$user_id)->find();
    }


}