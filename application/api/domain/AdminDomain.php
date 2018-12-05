<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/30
 * Time: 16:46
 */

namespace app\api\domain;

use app\api\model\AdminModel;

class AdminDomain
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }



}