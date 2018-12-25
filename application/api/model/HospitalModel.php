<?php
namespace app\api\model;

use think\Model;

class HospitalModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_hospital';

    public function findId($id){
        return  self::where('user_id',$id)->value('id');
    }
}