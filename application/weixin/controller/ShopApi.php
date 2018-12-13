<?php

namespace app\weixin\controller;

use app\api\domain\SpGoodsDomain;
use think\App;

class ShopApi extends BaseController
{
    private $_userDomain;
    private $_spGoodsDomain;
    private $_shOrderDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_userDomain = new \app\api\domain\UserDomain();
        $this->_shOrderDomain = new \app\api\domain\ShOrderDomain();
    }

    /**
     * 获取商品列表数据
     */
    public function getGoodsList()
    {
        $data = [
            'category' => $this->request->post('category', ''),
            'sort' => $this->request->post('sort/d', 0),
            'city' => $this->request->post('city', ''),
            'keywords' => $this->request->post('keywords', '')
        ];

        $doamin = new \app\api\domain\SpGoodsDomain();
        $data = $doamin->getSearchGoods($data);
        return $this->returnData($data, '', 200);
    }

    /**
     * 商品下单
     */
    public function placeOrder()
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $goodsid = $this->request->post('goodsid/d', 0);
        $num = $this->request->post('num/d', 0);

        if (empty($goodsid) || empty($num)) {
            return $this->returnData([], '参数不符合规范', 301);
        }

        $uid = $this->getUserId();
        $order_id = $this->_spGoodsDomain->placeOrder($goodsid, $num, $uid);
        if ($order_id === false) {
            return $this->returnData([], '下单失败', 305);
        }

        return $this->returnData(['order_id' => $order_id], '下单成功', 200);
    }

    /**
     * 获取商家热门商品
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSellerHotGoods()
    {
        $sellerid = $this->request->post('sellerid/d', 0);
        $page = $this->request->post('page/d', 1);
        $page_size = $this->request->post('page_size/d', 5);

        $data = $this->_spGoodsDomain->getSellerHotGoods($sellerid, $page, $page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     * 获取用户订单列表数据
     */
    public function getUserOrder()
    {
        $status = $this->request->post('status/d', 0);
        $page = $this->request->post('page/d', 1);
        $page_size = $this->request->post('page_size/d', 10);
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $data = $this->_shOrderDomain->getUserOrder($this->getUserId(), $status, $page, $page_size);
        return $this->returnData($data, '', 200);
    }
}