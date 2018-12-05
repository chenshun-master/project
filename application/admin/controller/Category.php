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
     * 分类列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $cate = new CategoryModel();
        $cate = $cate->catetree();
        $this->assign('cate',$cate);
        return $this->fetch('/category/index');
    }

    /**
     * 发布分类
     * @param Request $request
     * @return int|mixed
     * @throws \think\exception\DbException
     */
    public function add(Request $request)
    {
        $model = new CategoryModel();
        if(request()->isPost())
        {
            $data = $request->param();
            $res =$model->save($data);
            if($res) {
                return $this->returnData([],'添加成功',200);
            }else{
                return $this->returnData([],'添加失败',301);
            }
        }else{
            $cateid = input('param.id');
            $res = $model->cateOne($cateid);
            $cate = $model->catetree();
            $this->assign('cate',$cate);
            $this->assign('res',$res);
            return $this->fetch('/category/add');
        }
    }

    /**
     * 是否推送到首页
     */
    public function update()
    {
        $data = input('param.');
        if(isset($data['visibility'])) {
            $result = Db::name('sp_category')->where('id', $data['id'])->update(['visibility' => $data['visibility']]);
        }
        if($result){
            $this->redirect('/admin/category/index');
        }else{
            $this->error('修改失败', cookie("prevUrl"));
        }
    }

//    /**
//     * 通过要删除的分类ID，去循环查出，该分类下面的子目录，全部删除。
//     * @throws \think\db\exception\DataNotFoundException
//     * @throws \think\db\exception\ModelNotFoundException
//     * @throws \think\exception\DbException
//     */
//    public function del()
//    {
//        //  要删除的当前分类的id
//        $cateid =input('param.id') ;
//        $cate = new CategoryModel();
//        $sonids = $cate->getchilrenid($cateid);
//        //  获得全部的分类ID
//        $allcateid = $sonids;
//        $allcateid[] = $cateid;
//        if ($sonids) {
//            $cate->delete($sonids);
//        }
//    }
}