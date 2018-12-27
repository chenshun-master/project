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
    private $_spGoodsDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_spGoodsDomain = new SpGoodsDomain();
    }

    public function index()
    {
        return $this->fetch('/goods/index');
    }

    /**
     * 商品列表
     * @param int $page
     * @param int $page_size
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsList($page=1,$page_size=10){
        $status = $this->request->param('status/d',0);
        $data = $this->_spGoodsDomain->getGoodsList($status,$page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
    * 更新商品状态
    */
    public function updateGoodsStatus(){
        $ids = $this->request->post('ids/a',[]);
        $flag = $this->request->post('flag','');
        if(empty($ids) || empty($flag)){
            return $this->returnData([],'参数不符合规范',301);
        }

        if($flag == 'normal'){
            $status = 0;
        }else if($flag == 'lower'){
            $status = 2;
        }else{
            return $this->returnData([],'参数不符合规范',301);
        }

        $isTrue = $this->_spGoodsDomain->examineGoods($ids,$status);

        if($isTrue){
            return $this->returnData([],'更新成功',200);
        }

        return $this->returnData([],'',305);
    }
}