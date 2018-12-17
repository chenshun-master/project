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
     * 管理员列表
     */
    public function getAdminList(){
        $data = $this->AdminDomain->getAdminList(1,10);
        return $this->returnData($data,'',0);
    }

    /**
     * 新增管理员
     * @param  Request $request
     */
    public function releaseAdmin(Request $request)
    {
        $id = $request->post('id');
        $username = $request->post('username');
        $password = $request->post('password');
        $status = $request->post('status');
        $data = [
            'username' => $username,
            'password' => encryptPwd($password),
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        if ($id) {
            $data = [
                'username' => $username,
                'password' =>encryptPwd($password),
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $result = $this->AdminDomain->getUpdate($id,$data);
        } else {
            $result = $this->AdminDomain->createAdmin($data);
        }
        if (!$result) {
            return $this->returnData([], '新增失败', 301);
        } else {
            return $this->returnData([], '新增成功', 200);
        }
    }

    /**
     * 修改状态
     * @param int (0-禁用 10-开启)
     */
    public function update(){
        $data = input('param.');
        if($data['status'] == 0){
            $result = Db::name('admin')->where('id', $data['id'])->update(['status' => 10]);
        }else{
            $result = Db::name('admin')->where('id', $data['id'])->update(['status' => 0]);
        }
        if($result){
            return $this->returnData([],'修改成功','200');
        }else{
            return $this->returnData([],'修改失败','301');
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