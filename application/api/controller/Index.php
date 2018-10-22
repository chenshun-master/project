<?php
namespace app\api\controller;

class Index extends BaseController
{
    public function index()
    {
        return '接口文档';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
