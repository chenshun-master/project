<?php
namespace app\api\model;
use think\Db;
use think\Model;

class BannerModel extends Model
{
    protected $table = 'wl_sp_banner';

    /**
     * 获取最大的排序
     */
    public static function getMaxOrder($platform){
        return self::where('is_del',0)->where('platform',$platform)->max('order');
    }

    /**
     * 查询单条数据
     */
    public static function findOne($id)
    {
        return self::where('id',$id)->find();
    }

    /**
     * banner 列表
     * @param  $page
     * @param  $page_size
     */
    public function getList($page = 1,$page_size = 10)
    {
        $obj = self::where('is_del',0)->order('id desc');
        $total = $obj->count(1);
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

}