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
     * @param int $page 当前页码
     * @param int $page_size 每页展示的条数
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
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
     * @return bool
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
     * @param $id 当前ID
     * @param $data 修改的数据
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function getUpdate($id,$data){
        $res = Db::name('admin')->where('id',$id)->update($data);
        return $res;
    }

    /**
     * 查找单挑数据
     * @param $id
     * @return array|null|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getOne($id){
        return Db::name('admin')->where('id',$id)->find();
    }

    /**
     * 删除数据
     * @param $id
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function getDelete($id){
        return Db::name('admin')->where('id',$id)->delete();
    }
}