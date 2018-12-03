<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/29
 * Time: 21:17
 */

namespace app\admin\controller;

use app\api\model\AdminModel;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $model = new AdminModel();
            $res = $model->login($data['username'], $data['password']);
            if($res === 2){
                return $res = ['status' => 0, 'msg' => '密码错误'];
            }

            if($res === 3){
                return $res = ['status' => 0, 'msg' => '用户名不存在或者有误'];
            }

            session('user_info',$data);
            return json(['status' => 1, 'msg' => '登录成功！']);
        }
        //检测登录状态
        if(session('user_info')){
            $this->redirect('index/index');
        }
        return $this->fetch('login/index');
    }

    /**
     * 退出登陆
     */
    public function loginout(){
        session(null);
        return $this->fetch('login/index');
    }
}