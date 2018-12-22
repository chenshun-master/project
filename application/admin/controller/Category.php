<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/4
 * Time: 15:20
 */

namespace app\admin\controller;

use app\api\model\CategoryModel;
use think\Db;
use think\Request;

class Category extends BaseController
{
    /**
     * 渲染分类展示页面
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $cate = new CategoryModel();
        $data = $cate->catetree();
        $this->assign('cate',$data);
        return $this->fetch('/category/index');
    }
    /**
     * 发布分类页面
     */
    public function addCategory(){
        $model = new CategoryModel();
        $cate_id = input('param.id');
        $res = $model->findOne($cate_id);
        $cate = $model->catetree();
        $this->assign('cate',$cate);
        $this->assign('res',$res);
        return $this->fetch('/category/add');
    }
    /**
     * 发布分类
     * @param Request $request
     * @return int|mixed
     * @throws \think\exception\DbException
     */
    public function releaseCategory(Request $request)
    {
        $model = new CategoryModel();
        $id = $request->post('id');
        $name = $request->post('name');
        $parent_id = $request->post('parent_id');
        $sort = $request->post('sort');
        $title = $request->post('title');
        $keywords = $request->post('keywords');
        $descript = $request->post('descript');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        if($parent_id==0){
            $model['path']=0;
        }else{
            $model['path']=$model->path($parent_id);
        }
        $data = [
            'name' => $name,
            'parent_id' => $parent_id,
            'sort' => $sort,
            'title' => $title,
            'keywords' => $keywords,
            'descript' => $descript,
            'created_time' => $created_at,
        ];
        if($id){
            $data = [
                'name' => $name,
                'parent_id' => $parent_id,
                'sort' => $sort,
                'title' => $title,
                'keywords' => $keywords,
                'descript' => $descript,
                'updated_time' => $updated_at,
            ];
            $res = $model->where('id',$id)->update($data);
        }else{
            $res =$model->save($data);
        }
        if($res) {
            return $this->returnData([],"添加成功",200);
        }else{
            return $this->returnData([],'添加失败',301);
        }
    }

    /**
     * 是否推送到首页
     */
    public function update()
    {
        $id = input('param.id');
        $visibility = input('param.visibility');
        $result = Db::name('sp_category')->where('id', $id)->update(['visibility' => $visibility]);
        if($result){
            $this->redirect('/admin/category/index');
        }else{
            $this->error('修改失败', cookie("prevUrl"));
        }
    }
}