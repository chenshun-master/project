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


    public function getCategoryAll(){

        $rows = Db::name('sp_category')->field('id,name,parent_id,path')->order('id asc')->select();

        return  $this->_getCategoryNav($rows,0);
    }

    /**
     * 处理分类导航
     */
    private function _getCategoryNav($data,$pid){
        $tmpArr = [];

        foreach($data as $k => $v){
            if($v['parent_id'] == $pid){
                $v['subclass'] = $this->_getCategoryNav($data, $v['id']);
                $tmpArr[] = $v;
            }
        }

        return $tmpArr;
    }
}