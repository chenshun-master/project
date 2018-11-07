<?php
namespace app\api\domain;

use think\Db;

/**
 * 用户收藏业务处理层
 * Class FavoriteDomain
 * @package app\api\domain
 */
class FavoriteDomain
{

    /**
     * 添加文章收藏
     * @param $data
     * @return bool|int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function create($data){
        if(!isset($data['user_id']) || !isset($data['table_name']) || !isset($data['title']) || !isset($data['object_id']) || !isset($data['thumbnail'])){
            return 2;
        }

        $isTrue = DB::name('user_favorite')->where('user_id',$data['user_id'])->where('table_name',$data['table_name'])->where('object_id',$data['object_id'])->find();
        if($isTrue){
            return 1;
        }

        $data['created_time'] = date('Y-m-d H:i:s');

        $res = Db::name('user_favorite')->insertGetId($data);
        if(!$res){
            return false;
        }
        return true;
    }

    /**
     * 删除收藏
     * @param $id            收藏ID
     * @param $user_id       用户ID
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete($id,$user_id){
        $isTrue = DB::name('user_favorite')->where('user_id',$user_id)->where('id',$id)->delete();
        return $isTrue ? true :  false ;
    }

    /**
     * 获取用户收藏列表
     * @param int $user_id              用户ID
     * @param int $page                 当前分页
     * @param int $page_size            分页大小
     * @param string $table_name        数据对应得表名
     * @param int $type                 类型（仅对于 table_name 为 article 时有效）
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFavoriteList($user_id,$page=1,$page_size=15,$table_name = 'article',$type = 0){
        $obj = Db::name('user_favorite')->alias('favorite');
        $obj->where('favorite.user_id',$user_id);
        $obj->where('favorite.table_name',$table_name);

        if($table_name == 'article'){
            $obj->join('wl_article article',' favorite.object_id = article.id');
        }

        $obj->order('favorite.created_time desc');
        $total = $obj->count();

        if($table_name == 'article'){
            $obj->field('favorite.*,article.type');
        }else{
            $obj->field('favorite.*,"" as type');
        }

        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}