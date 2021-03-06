<?php

namespace app\weixin\controller;

use think\App;
use app\api\domain\SpGoodsDomain;
use app\api\domain\SpGoodGoodsDomain;
use mypay\MyPay;

use app\api\domain\UserLikeDomain;


use app\api\domain\Singleton;

class Shop extends BaseController
{
    private $_spGoodsDomain;
    private $_spGoodGoodsDomain;
    private $_userDomain;
    private $_orderDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_spGoodGoodsDomain = new SpGoodGoodsDomain();
        $this->_userDomain = new \app\api\domain\UserDomain();
        $this->_orderDomain = new \app\api\domain\ShOrderDomain();
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
        $goodsid = $this->request->param('goodsid/d', 0);
        $gid = $this->request->param('gid/d', 0);

        $this->_spGoodsDomain->updateBrowseVolume($goodsid);

        $goodsDetail = $this->_spGoodsDomain->getGoodsDetail($goodsid, $this->getUserId());

        if (empty($goodsDetail['goods_info'])) {
            return $this->fetch('error/loss');
        }

        $is_localhost = config('conf.is_localhost');
        if ($is_localhost) {
            $weixin_config = ['appId' => '', 'timestamp' => '', 'nonceStr' => '', 'signature' => ''];
        } else {
            $config = config('conf.sns_login.weixin');
            $wechatJsSdk = new \wechat\WeChatJsSDK($config['app_id'], $config['app_secret']);
            $weixin_config = $wechatJsSdk->getSignPackage();
        }

        $this->assign('weixin_config', $weixin_config);

        $referer = $this->request->server('HTTP_REFERER');
        $this->assign('referer', $referer);
        $this->assign('info', $goodsDetail);
        $this->assign('gid', $gid);
        return $this->fetch('shop/goods_details');
    }

    /**
     * 商品下单页面
     */
    public function confirmOrder()
    {
        if (!$this->checkLogin()) {
            return $this->redirect('index/login', ['redir' => base64url_encode($this->request->server('HTTP_REFERER'))]);
        }

        $goodsid = $this->request->param('goodsid/d', 0);
        $gid = $this->request->param('gid/d', 0);
        $num = $this->request->param('num/d', 1);

        $placeOrderPayInfo = $this->_spGoodsDomain->getPlaceOrderPayInfo($goodsid, $num);
        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign('mobile', mobileFilter($user_info['mobile']));
        $this->assign('infos', $placeOrderPayInfo);
        $this->assign('gid', $gid);
        return $this->fetch('shop/confirm_order');
    }

    /**
     *支付方式
     */
    public function methodPayment()
    {
        if (!$this->checkLogin()) {
            return $this->redirect('index/login');
        }

        $order_id = $this->request->param('oid/d', 0);
        $data = $this->_orderDomain->getOrderDetail($this->getUserId(), $order_id);
        if (!$data['order_info']) {
            return $this->fetch('error/loss');
        }

        $this->assign('data', $data);
        return $this->fetch('shop/method_payment');
    }

    /**
     *我的订单
     */
    public function myOrder()
    {
        if (!$this->checkLogin()) {
            return $this->redirect('index/login');
        }

        return $this->fetch('shop/my_order');
    }

    /**
     *订单详情
     */
    public function orderDetails()
    {
        if (!$this->checkLogin()) {
            return $this->redirect('index/login');
        }

        $order_id = $this->request->param('oid/d', 0);
        $data = $this->_orderDomain->getOrderDetail($this->getUserId(), $order_id);


        if (!$data['order_info']) {
            return $this->fetch('error/loss');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign('mobile', mobileFilter($user_info['mobile']));

        $this->assign('data', $data);
        return $this->fetch('shop/order_details');
    }

    /**
     *支付成功页面
     */
    public function paySuccess()
    {
        if (!$this->checkLogin()) {
            return $this->redirect('index/login');
        }

        $order_id = $this->request->param('oid/d', 0);
        if ($order_id == 0) {
            return $this->fetch('error/loss');
        }

        $data = $this->_orderDomain->getPayOrderDetail($this->getUserId(), $order_id);
        if (!$data) {
            return $this->fetch('error/loss');
        }

        $data['mobile'] = $this->getUserInfo()['mobile'];

        $this->assign('order_info', $data);
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

        $gid = $this->request->param('gid/d', 0);
        $data = $this->_spGoodGoodsDomain->getGoodGoodsDetail($gid, $this->getUserId());
        if (empty($data['info'])) {
            return $this->fetch('error/loss');
        }

        $is_localhost = config('conf.is_localhost');
        if ($is_localhost) {
            $weixin_config = ['appId' => '', 'timestamp' => '', 'nonceStr' => '', 'signature' => ''];
        } else {
            $config = config('conf.sns_login.weixin');
            $wechatJsSdk = new \wechat\WeChatJsSDK($config['app_id'], $config['app_secret']);
            $weixin_config = $wechatJsSdk->getSignPackage();
        }

        $this->assign('weixin_config', $weixin_config);
        $this->assign($data);
        return $this->fetch('shop/havegood_details');
    }

    /**
     *用户订单详情页
     */
    public function paymentOrder()
    {

        $oid = $this->request->param('oid/d', 0);
        if (empty($oid)) {
            return $this->fetch('error/loss');
        }

        $data = $this->_orderDomain->getPayOrderDetail($this->getUserId(), $oid);
        if (!$data) {
            return $this->fetch('error/loss');
        }

        $this->assign('order_info', $data);
        $this->assign('mobile', $this->getUserInfo()['mobile']);

        return $this->fetch('shop/payment_order');
    }

    /**
     *商品搜索页面
     */
    public function searchGoods()
    {
        return $this->fetch('shop/search_goods');
    }

    /**
     *用户美丽日记
     */
    public function diary($id)
    {
        Singleton::getDomain('diarydomain')->updateDiaryVisit($id);

        $sort = $this->request->param('sort','desc');
        if($sort != 'desc'){
            $sort = 'asc';
        }

        $data = Singleton::getDomain('diarydomain')->getDiaryInfo($id, $this->getUserId(),$sort);

        $myID = $this->getUserId();
        $uid = $data['info']['user_id'];
        $isFollow = 0;
        if ($uid == $myID) {
            $isFollow = 2;
        } else if ($uid != $myID) {
            $isFollow = Singleton::getDomain('userfrienddomain')->checkFollow((int)$uid, (int)$myID, $myID) ? 1 : 0;
        }

        $this->assign('isFollow', $isFollow);
        $this->assign($data);
        $this->assign('sort',$sort);
        return $this->fetch('shop/diary');
    }

    /**
     * 用户美丽日记详情页
     */
    public function diaryDetails()
    {
        return $this->fetch('shop/diary_details');
    }

    /**
     * 用户美丽日记相册页面
     */
    public function photoDetails()
    {
        return $this->fetch('shop/photo_details');
    }

}