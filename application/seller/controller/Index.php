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

        if(empty($mobile) || empty($password)){
            return $this->returnData([],'参数不符合规范',301);
        }

        $domain = new \app\api\domain\SellerDomain();
        $loginRes = $domain->login($mobile,$password);

        if(is_array($loginRes) && count($loginRes)){
            $this->saveUserLogin($loginRes);
            return $this->returnData([],'登录成功',200);
        }else{
            return $this->returnData([],'登录失败',305);
        }
    }

    /**
     * 退出登录
     */
    public function signOut(){
        $this->clearUserLogin();
        return redirect('/seller/index/login');
    }
}
