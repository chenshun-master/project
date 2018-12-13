<?php
namespace app\api\domain;


use app\api\model\CategoryModel;
use think\Db;

class SpCategory
{

    /**
     * 获取分类列表信息
     */
    public function getCategoryList($category_id = 0){
        return Db::name('sp_category')->order('sort desc,id asc')->where('parent_id',$category_id)->field('id,name,parent_id,is_leaf')->select();
    }
}