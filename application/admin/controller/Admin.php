<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/12
 * Time: 18:10
 */

namespace app\admin\controller;


use app\api\domain\AdminDomain;
use think\App;
use think\Db;
use think\Request;

class Admin extends BaseController
{
    private $AdminDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->AdminDomain = new AdminDomain();
    }

    /**
     * 管理员列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $data = $this->AdminDomain->getAdminList();
        $this->assign('data',$data);
        return $this->fetch('/admin/index');
    }

    /**
     * 新增管理员页面
     */
    public function newAdmin()
    {
        $id = input('param.id');
        $data = $this->AdminDomain->getOne($id);
        $this->assign('data',$data);
        return $this->fetch('/admin/add');
    }

    /**
     * 新增管理员
     * @param  Request $request
     */
    public function releaseAdmin(Request $request){
        $username = $request->post('username');
        $password = $request->post('password');
        $status   = $request->post('status');
        $file     = $request->file("pic");
        $img_domain = config('conf.file_save_domain');
        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];
        if($file) {
            $size = 1024 * 1024 * 5;              #单位字节
            if (!$file->checkSize($size)) {
                return $this->returnData([], '上传图片大小不能超过5M', 305);
            }

            if (!$file->checkExt($fileExt)) {
                return $this->returnData([], '文件格式错误只支持gif,jpg,jpeg及png格式的图片', 305);
            }

            $info = $file->move('../uploads/');
            if ($info) {
                $path_dir = $img_domain . '/uploads/' . str_replace("\\", "/", $info->getSaveName());
                $data = [
                    'username' => $username,
                    'password' => encryptPwd($password),
                    'pic'      => $path_dir,
                    'status'   => $status,
                ];
                $result = $this->AdminDomain->createAdmin($data);
                if (!$result) {
                    return $this->returnData([], '新增失败',301);
                } else {
                    return $this->returnData([], '新增成功', 200);
                }
            } else {
                return $this->returnData([], $file->getError(), 305);
            }

        }
    }

    /**
     * 修改状态
     * @param int (0-禁用 10-开启)
     */
    public function update(){
        $data = input('param.');
        $result = Db::name('admin')->where('id', $data['id'])->update(['status' => $data['status']]);
        if($result){
            $this->redirect('/admin/admin/index');
        }else{
            $this->error('修改失败', cookie("prevUrl"));
        }
    }

    /**
     * 删除管理员
     */
    public function del(){
        $id = $this->request->post('id');
        $del = $this->AdminDomain->getDelete($id);
        if($del){
            return $this->returnData([],'删除成功',200);
        }else{
            return $this->returnData([],'删除失败',301);
        }
    }
}