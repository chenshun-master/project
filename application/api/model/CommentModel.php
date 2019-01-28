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


    /**
     * 获取评论数量
     */
    public static function getCommentNum(int $obj_id,string $table_name){
        return self::where('object_id',$obj_id)->where('table_name',$table_name)->where('status',1)->count('id');
    }
}