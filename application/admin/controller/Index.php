<?php
namespace app\admin\controller;


use app\api\model\AdminModel;

class Index extends BaseController
{
    public function index(){

        return $this->fetch('/index/main');

    }
    public function index2(){
        return $this->fetch('/index/index');
    }

    /**
     * 后台登陆
     * @return array|false|mixed|string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        if (request()->isPost()) {
            $username = $this->request->post('username','');
            $password = $this->request->post('password','');
            if (empty($username) || empty($password)) {
                return returnData([], '请求参数不符合规范', 301);
            }
            $model = new AdminModel();
            $res = $model->login($username, $password);
            if ($res === 2) {
                return $res = ['status' => 0, 'msg' => '用户名不存在'];
            }
            if ($res === 3) {
                return $res = ['status' => 0, 'msg' => '密码错误'];
            }
            if($res === 4){
                return $res = ['status' => 0, 'msg' => '账号已禁用'];
            }
            $this->saveAdminLogin($res);
            return json(['status' => 200, 'msg' => '登录成功！']);
        }
        if($this->getAdminInfo()){
            $this->redirect('index/index');
        }
        return $this->fetch('index/login');
    }

    /**
     * 退出登陆
     */
    public function loginOut(){
        $this->clearAdminLogin();
        return $this->fetch('index/login');
    }
}
