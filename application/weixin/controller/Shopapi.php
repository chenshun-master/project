<?php
namespace app\weixin\controller;

use app\api\domain\SpGoodsDomain;
use think\App;
use app\api\domain\SpGoodGoodsDomain;
use mypay\MyPay;
use app\api\domain\UDomain;

class Shopapi extends BaseController
{
    private $_userDomain;
    private $_spGoodsDomain;
    private $_shOrderDomain;
    private $_spGoodGoodsDomain;
    private $_commentDomain;
    private $_orderDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_spGoodGoodsDomain = new SpGoodGoodsDomain();
        $this->_userDomain = new \app\api\domain\UserDomain();
        $this->_shOrderDomain = new \app\api\domain\ShOrderDomain();

        $this->_commentDomain = new \app\api\domain\CommentDomain();
        $this->_orderDomain = new \app\api\domain\ShOrderDomain();
    }

    /**
     * 获取商品列表数据
     */
    public function getGoodsList()
    {
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 5);
        $data = [
            'category' => $this->request->param('category', ''),
            'sort' => $this->request->param('sort/d', 0),
            'city' => $this->request->param('city', ''),
            'keywords' => $this->request->param('keywords', '')
        ];

        $doamin = new \app\api\domain\SpGoodsDomain();
        $data = $doamin->getSearchGoods($data,$page,$page_size);
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
        $gid     = $this->request->post('gid/d', 0);
        $num = $this->request->post('num/d', 0);

        if (empty($goodsid) || empty($num)) {
            return $this->returnData([], '参数不符合规范', 301);
        }

        $uid = $this->getUserId();
        $order_id = $this->_spGoodsDomain->placeOrder($goodsid, $num, $uid,$gid);
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
        $uid = $this->request->param('uid/d', 0);
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 5);

        $data = $this->_spGoodsDomain->getSellerHotGoods($uid, $page, $page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     * 获取用户订单列表数据
     */
    public function getUserOrder()
    {
        $status = $this->request->param('status/d', 0);
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 10);
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        if($status == 3){
            $status = 5;
        }


        $data = $this->_shOrderDomain->getUserOrder($this->getUserId(), $status, $page, $page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     * 获取分销商品列表
     * @return false|string
     */
    public function getGoodGoodsList(){
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = $this->_spGoodGoodsDomain->getGoodGoodsList($page,$page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     * 获取分销商品评论
     */
    public function getGoodGoodsComment()
    {
        $gid = $this->request->param('gid/d', 0);
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = $this->_spGoodGoodsDomain->getGoodGoodsCommentList($gid,$this->getUserId(),$page,$page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     *  获取分销产品有关的产品
     */
    public function getGoodGoodsRelevant(){
        $gid = $this->request->param('gid/d', 0);
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = $this->_spGoodGoodsDomain->getGoodGoodsRelevant($gid,$page,$page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     * 获取支付数据
     */
    public function getPaymentData(){
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $order_id = $this->request->param('oid/d', 0);
        $type     = $this->request->param('type', '');

        if(empty($order_id) || empty($type)){
            return $this->returnData([], '支付请求参数错误', 301);
        }

        $data     = $this->_orderDomain->getOrderDetail($this->getUserId(), $order_id);
        if (!$data['order_info']) {
            return $this->returnData([], '订单不存在', 302);
        }

        if($type == 'weixin'){
            $wxAuthorize = \Session::get('wxAuthorize');

            if(!isset($wxAuthorize['openid'])){
                return $this->returnData([], '调取微信用户信息失败', 303);
            }

            list($ok,$msg,$data) = MyPay::wechat()->mp(['body'=>$data['order_info']['goods_name'],'out_trade_no'=>$data['order_info']['order_no'],'total_fee'=>$data['order_info']['real_amount'] * 100,'notify_url'=>url('/api/pay/notify/', '', '', true),'openid'=>$wxAuthorize['openid']]);
            if($ok === true){
                return $this->returnData(['jsApiParameters'=>json_decode($data),true], '', 200);
            }

            return $this->returnData(['jsApiParameters'=>$data], '操作失败', 305);
        }else{
            return $this->returnData([], '支付方式不存在', 306);
        }
    }

    /**
     * 网站搜索
     */
    public function search()
    {
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);
        $type = $this->request->param('type', 0);
        $keyword = $this->request->param('keywords', '');

        $data = [
            'rows'          =>[],
            'page'          =>1,
            'page_total'    =>0,
            'total'         =>0
        ];
        if(empty($type) || empty($keyword) || !in_array($type,[1,2,3])){
            return $this->returnData($data,'',200);
        }else if($type == 1){
            $data = $this->_spGoodsDomain->getSearchGoods(['keywords'=>addslashes($keyword)],$page,$page_size);
        }else if($type == 2){
            $data = (new UDomain())->searchDoctor(['keywords'=>addslashes($keyword)],$page,$page_size);
        }else if($type == 3){
            $data = (new UDomain())->searchHospital(['keywords'=>addslashes($keyword)],$page,$page_size);
        }

        return $this->returnData($data, '', 200);
    }

    /**
     * 订单完成操作
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function orderComplete(){
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $order_id =  $this->request->post('oid/d', 0);
        $isTrue = $this->_shOrderDomain->orderComplete($this->getUserId(),$order_id);
        if($isTrue){
            return $this->returnData([],'订单确认完成操作成功...');
        }

        return $this->returnData([],'操作失败...',305);
    }
}