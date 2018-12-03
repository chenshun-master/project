<?php
namespace app\admin\controller;
use think\App;
use think\Controller;

class BaseController extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->view->engine->layout('layout/layout');
    }
}