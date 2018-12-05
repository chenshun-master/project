<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/5
 * Time: 9:58
 */

namespace app\api\model;


use think\Model;

class CategoryModel extends Model
{
    protected $table = 'wl_sp_category';

    /**
     * 查找单条数据
     */
    public function cateOne($cateid)
    {
        $category = $this->where('id',$cateid)->find();
        return $category;
    }

    /**
     * 让项目分类 按照降序排序
     * @return array
     * @throws \think\exception\DbException
     */
    public function catetree(){
        $category=$this->order('sort desc')->select();
        return $this->sort($category);
    }

    /**
     * 排序方法
     * @param $data
     * @param int $parent_id
     * @param int $level
     * @return array
     */
    public function sort($data,$parent_id=0,$level=0){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['parent_id']==$parent_id){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }

    /**
     * 通过ID 获得子节点信息
     * @param $cateid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getchilrenid($cateid){
        $cateres=$this->select();
        return $this->_getchilrenid($cateres,$cateid);
    }

    /**
     * 递归方法
     * @param $cateres
     * @param $cateid
     * @return array
     */
    public function _getchilrenid($cateres,$cateid){
        static $arr=array();
        foreach ($cateres as $k => $v) {
            if($v['parent_id'] == $cateid){
                $arr[]=$v['id'];
                $this->_getchilrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }

}