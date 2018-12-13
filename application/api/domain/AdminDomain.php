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
     * @throws \think\exception\DbException
     */
    public function getAdminList(){
        $adminList = Db::name('admin')->order('id desc')->select();
        return $adminList;
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