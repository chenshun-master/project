<?php
namespace app\seller\controller;

class Index extends BaseController
{

    public function index(){
        $this->view->engine->layout('layout/layout');

        return $this->fetch('index/index');
    }
}
