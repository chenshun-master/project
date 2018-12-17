<?php
namespace app\api\model;
use think\Model;

class SpGoodsModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_sp_goods';

    /**
     * 获取商品的推荐图片列表
     * @param $goods_id   商品ID
     * @return array
     */
    public static function getImgs($goods_id){
        $imgs = self::alias('goods')
            ->leftJoin('wl_sp_goods_photo_relation pr','pr.goods_id = goods.id')
            ->leftJoin('wl_sp_goods_photo goods_photo','pr.photo_id = goods_photo.id')
            ->where('goods.id',$goods_id)->cache(true,60)
            ->column('goods_photo.img');
        return $imgs;
    }
}