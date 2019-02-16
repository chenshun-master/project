<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/8
 * Time: 13:54
 */

namespace app\admin\controller;


use app\api\domain\AdminDomain;
use app\api\domain\UserDomain;
use think\App;
use think\Db;
use think\Request;

class User extends BaseController
{
    private $_userDomain;
    private $_adminDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_userDomain = new UserDomain();
        $this->_adminDomain = new AdminDomain();
    }

    /**
     * 用户列表页面
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('user/index');
    }

    /**
     * 管理员列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function adminList()
    {
        return $this->fetch('/user/admin_index');
    }
    /**
     * 新增管理员页面
     */
    public function newAdmin(){
        return $this->fetch('/user/admin_add');
    }

    /**
     * 用户列表
     * @param $page
     * @param $page_size
     * @return false|string
     */
    public function getUserList($page=1,$page_size=10){
        $data = $this->_userDomain->userInfo($page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     *修改管理员信息页面
     */
    public function updateAdmin(){
        $id = input('param.id');
        $data = $this->_adminDomain->getOne($id);
        $this->assign('data',$data);
        return $this->fetch('/user/admin_update');
    }

    /**
     *修改管理员信息
     * @param Request $request
     */
    public function updateInfo(Request $request){
        $id = $request->post('id');
        $username = $request->post('username');
        $password = $request->post('password');
        $status = $request->post('status');
        $data = [
            'username' => $username,
            'password' => encryptPwd($password),
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $result = $this->_adminDomain->getUpdate($id,$data);
        if (!$result) {
            return $this->returnData([], '修改失败', 301);
        } else {
            return $this->returnData([], '修改成功', 200);
        }
    }
    /**
     * 管理员列表
     * @param $page
     * @param $page_size
     * @return false|string
     * @throws \think\exception\DbException
     */
    public function getAdminList($page=1,$page_size=10){
        $data = $this->_adminDomain->getAdminList($page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 新增管理员
     * @param  Request $request
     */
    public function releaseAdmin(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $status = $request->post('status');
        $data = [
            'username' => $username,
            'password' => encryptPwd($password),
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $res = Db::name('admin')->where('username',$data['username'])->find();
        if(!$res){
            $result = $this->_adminDomain->createAdmin($data);
            if (!$result) {
                return $this->returnData([], '新增失败', 301);
            } else {
                return $this->returnData([], '新增成功', 200);
            }
        }else{
            return $this->returnData([],'管理员名称重复',302);
        }
    }

    /**
     * 修改状态
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function update(){
        $id = $this->request->post('id');
        $status = $this->request->post('status');
        if($status == 0){
            $result = Db::name('admin')->where('id', $id)->update(['status' => 10]);
        }else{
            $result = Db::name('admin')->where('id', $id)->update(['status' => 0]);
        }
        if($result){
            return $this->returnData([],'修改成功',200);
        }else{
            return $this->returnData([],'修改失败',301);
        }
    }
}