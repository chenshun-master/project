<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/8
 * Time: 13:54
 */

namespace app\admin\controller;


use app\api\domain\UserDomain;
use think\App;

class User extends BaseController
{
    private $userDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->userDomain = new UserDomain();
    }

    public function index()
    {
        if(input('param.name') != ""){
            $key = input('param.name');
        }else{
            $key = "";
        }
        $info = $this->userDomain->userInfo($key);
        $this->assign('info',$info);
        return $this->fetch('user/index');
    }
}