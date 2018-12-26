<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/29
 * Time: 21:17
 */

namespace app\admin\controller;

use app\api\model\AdminModel;
use think\App;
use think\Controller;
use think\facade\Session;

class Login extends Controller
{
    /**
     * 后台登陆
     * @return array|false|mixed|string|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
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
            Session::set('user_auth',$res);
            return json(['status' => 200, 'msg' => '登录成功！']);
        }
        if(Session::get('user_auth')){
            $this->redirect('index/index');
        }
        return $this->fetch('login/index');
    }

    /**
     * 退出登陆
     */
    public function loginout(){
        session::clear();
        return $this->fetch('login/index');
    }
}