<?php
namespace app\api\model;
use think\Db;
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

    public function getMobile($user_id){
        return  self::where('id',$user_id)->value('mobile');
    }

    public function info($page=1,$page_size=10){
        $obj = Db::name('user')->order('created_time desc');
        $total = $obj->count(1);
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows' => $rows,
            'page' => $page,
            'page_total' => getPageTotal($total,$page_size),
            'total' => $total,
        ];
    }

    /**
     * 判断ID是否存在
     * @return bool
     */
    public function findIdExists($user_id){
        $id = self::where('id',$user_id)->value('id');

        return $id ? true : false;
    }
}