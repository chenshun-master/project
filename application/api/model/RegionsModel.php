<?php
namespace app\api\model;
use think\Model;

class RegionsModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_regions';

    /**
     * 获取地址联动列表数据
     * @param $region_path         Path 路径
     * @param int $region_grade
     * @return mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getListData($region_path,$region_grade = 1){
        return self::query("SELECT * from wl_regions where  region_grade = {$region_grade} and  region_path LIKE '{$region_path}%'");
    }
}