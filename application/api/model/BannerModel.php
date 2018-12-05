<?php
namespace app\api\model;
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

}