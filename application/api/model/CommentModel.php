<?php
namespace app\api\model;
use think\Model;

class CommentModel extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_comment';

    public function findId($id){
        return  self::where('id',$id)->find();
    }



}