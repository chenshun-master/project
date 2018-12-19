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
        return $this->fetch('user/index');
    }

    /**
     * 用户列表
     * @param $page
     * @param $page_size
     * @return false|string
     */
    public function getUserList($page=1,$page_size=10){
        $data = $this->userDomain->userInfo($page,$page_size);
        return $this->returnData($data,'',0);
    }
}