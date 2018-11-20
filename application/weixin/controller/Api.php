<?php
namespace app\weixin\controller;

use think\App;
use think\Request;

/**
 * ajax 请求接口
 * @package app\weixin\controller
 */
class Api extends BaseController
{
    private  $_uDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_uDomain = new \app\api\domain\UDomain();
    }

    /**
     * 获取医生列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDoctorList(Request $request){
        $page      = $request->get('page/d',1);
        $page_size = $request->get('page_size/d',15);

        $data = $this->_uDomain->getDoctorListData($page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 获取医院机构列表
     */
    public function getHospitalList(Request $request){
        $page      = $request->get('page/d',1);
        $page_size = $request->get('page_size/d',15);

        $data = $this->_uDomain->getHospitalListData($page,$page_size);
        return $this->returnData($data,'',200);
    }
}