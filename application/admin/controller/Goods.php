<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/12
 * Time: 15:33
 */

namespace app\admin\controller;


use app\api\domain\SpGoodsDomain;
use think\App;

class Goods extends BaseController
{
    private $SpGoodsDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->SpGoodsDomain = new SpGoodsDomain();
    }

    public function index()
    {
        return $this->fetch('/goods/index');
    }

    /**
     * 商品列表
     * @param  $page 当前页码
     * @param  $page_size 每页展示的数据
     * @param  $seller_id  商家ID
     */
    public function getGoodsList($page=1,$page_size=10){
        $status = input('param.status');
        $seller_id = $this->request->post('seller_id','0');
        $data = $this->SpGoodsDomain->getGoodsList($status,$seller_id,$page,$page_size);
        return $this->returnData($data,'',0);
    }

    public function getGoodsStatus(){
        $id = $this->request->post('id','0');
        $status = $this->request->post('status','3');
        $data = $this->SpGoodsDomain->examineGoods($id,intval($status));
        if(!$data){
            return $this->returnData([],'修改失败','301');
        }else{
            return $this->returnData([],'修改成功','200');
        }
    }
}