<?php

namespace app\weixin\controller;

use think\App;
use app\api\domain\SpGoodsDomain;


class Shop extends BaseController
{
    private $_spGoodsDomain;
    private $_userDomain;


    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_userDomain = new \app\api\domain\UserDomain();
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

        if(empty($goodsDetail['goods_info'])){
            return $this->fetch('error/loss');
        }


        $referer = $this->request->server('HTTP_REFERER');
        $this->assign('referer',$referer);

        $this->assign('info',$goodsDetail);
        return $this->fetch('shop/goods_details');
    }

    /**
     * 商品下单页面
     */
    public function confirmOrder()
    {
        if(!$this->checkLogin()){
            return $this->redirect('index/login');
        }

        $goodsid = $this->request->param('goodsid/d',0);
        $num     = $this->request->param('num/d',1);

        $placeOrderPayInfo = $this->_spGoodsDomain->getPlaceOrderPayInfo($goodsid,$num);
        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign('mobile',mobileFilter($user_info['mobile']));
        $this->assign('infos',$placeOrderPayInfo);

        return $this->fetch('shop/confirm_order');
    }

    /**
     *支付方式
     */
    public function methodPayment()
    {
        $order_id = $this->request->param('order_id',0);

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
      *有好货页面
      */
       public function haveGood()
       {
           return $this->fetch('shop/have_good');
       }
    /**
      *有好货详情页面
      */
       public function haveGoodDetails()
       {
           return $this->fetch('shop/havegood_details');
       }





    /**
     *用户相册详情页
     */
    public function diary()
    {
        return $this->fetch('shop/diary');
    }

    /**
     *用户相册详情页二
     */
    public function diaryOf()
    {
        return $this->fetch('shop/diary_of');
    }


    /**
     *用户相册详情页三
     */
    public function diarySecond()
    {
        return $this->fetch('shop/diary_second');
    }

}