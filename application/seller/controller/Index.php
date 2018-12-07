<?php
namespace app\seller\controller;

use think\Request;

class Index extends BaseController
{

    public function index(){
        return $this->fetch('index/index');
    }


    /**
     * 商家登录页面
     */
    public function login(){
        return $this->fetch('index/login');
    }

    /**
     * 商家登录处理页面
     */
    public function postLogin(Request $request){
        $mobile   = $request->post('mobile','');
        $password = $request->post('password','');

        if(empty($username) || empty($password)){

        }

        $domain = new \app\api\domain\SellerDomain();
        $loginRes = $domain->login($mobile,$password);

        if(is_array($loginRes) && count($loginRes)){

        }
    }
}
