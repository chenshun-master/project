<?php

namespace app\weixin\controller;

use think\App;
use app\api\domain\SpGoodsDomain;


class Shop extends BaseController
{
    private $_spGoodsDomain;



    public function __construct(App $app = null)
    {
        parent::__construct($app);



        $this->_spGoodsDomain = new SpGoodsDomain();
    }


    /**
     *商城首页
     */
    public function index()
    {

        $spCategoryDomain = new \app\api\domain\SpCategory();
        $categoryNav = $spCategoryDomain->getCategoryAll();

        $this->assign('categoryNav', $categoryNav);

        return $this->fetch('shop/index');
    }

    /**
     *商城详情页
     */
    public function goodsDetails()
    {
        $goodsid = $this->request->param('goodsid/d',0);



        $goodsDetail = $this->_spGoodsDomain->getGoodsDetail($goodsid);

        return $this->fetch('shop/goods_details');
    }

    /**
     *支付页面
     */
    public function pay()
    {
        return $this->fetch('shop/pay');
    }

    /**
     *支付方式
     */
    public function methodPayment()
    {
        return $this->fetch('shop/method_payment');
    }

    /**
     *我的订单
     */
    public function myOrder()
    {
        return $this->fetch('shop/my_order');
    }

    /**
     *订单详情
     */
    public function orderDetails()
    {
        return $this->fetch('shop/order_details');
    }

    /**
     *支付成功页面
     */
    public function paySuccess()
    {
        return $this->fetch('shop/pay_success');
    }

    /**
     *用户相册详情页
     */
    public function fairyAlbum()
    {
        return $this->fetch('shop/fairy_album');
    }

}