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
     */
    public function getGoodsList($page,$page_size){
        $status = $this->request->post('status');
        $data = $this->SpGoodsDomain->getGoodsList($status,0,$page,$page_size);
        return $this->returnData($data,'',0);
    }

    public function modifyStatus(){
        $goodsId = $this->request->post('id');
        $status  = $this->request->post('status',0);
        $data = $this->SpGoodsDomain->examineGoods($goodsId,$status);
        if($data){
            return $this->returnData([],'修改成功','200');
        }else{
            return $this->returnData([],'修改失败','301');
        }
    }
}