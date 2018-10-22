<?php
namespace app\index\controller;

class Index extends \app\index\controller\CController
{

    public function index()
    {
        return 'PC端网站首页阿斯顿发生的';
    }


    public function testLogin(){
        $data = [
            "id" =>9,
            "mobile" =>  "18798276809",
            "nickname" => '',
            "password" =>  "182e9b78ab083ade9e4ab0401eddaa0d",
            "type" => '',
            "score" => '',
            "last_login_time" => '',
            "last_login_ip" => "",
            "created_time"=>  "2018-10-21 16:33:52"
        ];

        $this->saveUserLogin($data);
    }

    public function test(){
        dump($this->getUserInfo());
    }

}
