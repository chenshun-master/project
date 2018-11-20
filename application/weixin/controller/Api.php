<?php
namespace app\weixin\controller;


/**
 * ajax 请求接口
 * @package app\weixin\controller
 */
class Api extends BaseController
{



    public function getAddressList(){
        $model = new \app\api\model\RegionsModel();

        halt($model->getListData(',19,20,',3));
    }
}