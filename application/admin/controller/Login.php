<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/29
 * Time: 21:17
 */

namespace app\admin\controller;

use app\api\domain\AdminDomain;
use think\Controller;
use think\Request;

class Login extends Controller
{
    public function index(Request $request)
    {
        if (request()->isPost()) {
            $data = input('post.');
            $uid = (new AdminDomain())->login($data['username'], $data['password']);

            $auth = [
                'use'
            ];

        }
        return $this->fetch('login/index');
    }
}