<?php
namespace app\admin\controller;

class Index
{
    public function index()
    {
        return '后台入口';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
