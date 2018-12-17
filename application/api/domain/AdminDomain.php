<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/30
 * Time: 16:46
 */

namespace app\api\domain;

use think\Db;

class AdminDomain
{
    /**
     * 后台管理员列表
     * @param  int $page
     * @param  int $page_size
     * @throws \think\exception\DbException
     */
    public function getAdminList($page=1,$page_size=10){
        $obj = Db::name('admin')->order('id desc');
        $total = $obj->count(1);
        $rows = $obj->page($page,$page_size)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 新增管理员
     * @param $data
     */
    public function createAdmin($data){
        $res = Db::name('admin')->insert($data);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 修改管理员
     * @param  $id  修改的ID
     * @param $data 要修改的数据
     */
    public function getUpdate($id,$data){
        $res = Db::name('admin')->where('id',$id)->update($data);
        return $res;
    }

    /**
     * 查询当前ID的数据
     * @param int $id
     */
    public function getOne($id){
        return Db::name('admin')->where('id',$id)->find();
    }

    /**
     * 删除管理员
     * @param int $id 删除数据的ID
     */
    public function getDelete($id){
        return Db::name('admin')->where('id',$id)->delete();
    }
}