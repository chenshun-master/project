<?php
namespace app\weixin\controller;
use app\api\domain\SpGoodsDomain;
use think\App;
class ShopApi extends BaseController
{

    private  $_userDomain;
    private  $_spGoodsDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_userDomain          = new \app\api\domain\UserDomain();
    }

    /**
     * 搜索产品
     */
    public function getGoodsList(){

        $data = [];

        $doamin = new \app\api\domain\SpGoodsDomain();
        $data = $doamin->getSearchGoods($data);

        return $this->returnData($data,'',200);
    }


    /**
     * 商品下单
     */
    public function placeOrder(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $goodsid = $this->request->post('goodsid/s',0);
        $num     = $this->request->post('num/s',0);

        if(empty($goodsid) || empty($num)){
            return $this->returnData([],'参数不符合规范',301);
        }

        $uid = $this->getUserId();
        $order_id = $this->_spGoodsDomain->directBuyGoods($goodsid,$num,$uid);

        if($order_id === false){
            return $this->returnData([],'下单失败',305);
        }

        return $this->returnData(['order_id'=>$order_id],'下单成功',200);
    }
}