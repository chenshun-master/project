<?php
namespace app\api\model;

use think\Model;

class SpGoodsPhotoModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_sp_goods_photo';

    /**
     * 添加图片
     * @param $img          图片地址
     * @return int|string
     */
    public function createGoodsPhoto($img){
        return self::insertGetId(['img'=>$img,'created_time'=>date('Y-m-d H:i:s')]);
    }
}