<?php

namespace app\weixin\controller;

use app\api\domain\SpGoodsDomain;
use think\App;
use app\api\domain\SpGoodGoodsDomain;

class ShopApi extends BaseController
{
    private $_userDomain;
    private $_spGoodsDomain;
    private $_shOrderDomain;
    private $_spGoodGoodsDomain;
    private $_commentDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_spGoodGoodsDomain = new SpGoodGoodsDomain();
        $this->_userDomain = new \app\api\domain\UserDomain();
        $this->_shOrderDomain = new \app\api\domain\ShOrderDomain();

        $this->_commentDomain = new \app\api\domain\CommentDomain();
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

    /**
     * 获取分销商品列表
     * @return false|string
     */
    public function getGoodGoodsList(){
        $page = $this->request->get('page/d', 1);
        $page_size = $this->request->get('page_size/d', 15);

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
     * 获取分销商品评论
     */
    public function createGoodGoodsComment()
    {
        $data  = [
            'parent_id'=>$this->request->post('pid/d', 0),
            'user_id'=>$this->getUserId(),
            'object_id'=>$this->request->post('obj_id/d', 0),
            'content'=>$this->request->post('content/d', ''),
        ];

        if(!$this->checkLogin()){
            return $this->returnData([], '用户未登录', 401);
        }else if(empty($data['object_id']) || empty($data['content'])){
            return $this->returnData([], '参数不符合规范', 301);
        }else if($this->_commentDomain->createComment($data,'sp_good_goods')){
            return $this->returnData([], '评论成功...', 200);
        }

        return $this->returnData([], '评论失败...', 200);
    }

    /**
     *  获取分销产品有关的产品
     */
    public function getGoodGoodsRelevant(){
        $gid = $this->request->param('gid/d', 1);
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = $this->_spGoodGoodsDomain->getGoodGoodsRelevant($gid,$page,$page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     * 点赞操作
     * @param  obj_id        点赞的对象id
     * @param  flag          点赞对象的标识   1:文章点赞  2:评论点赞   3:分销商品点赞
     * @param  type          点赞操作方式  1:点赞  2:取消点赞
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function giveFabulous(){
        $object_id = $this->request->param('obj_id/d', 0);
        $flag = $this->request->param('flag/d', '');
        $type = $this->request->param('type/d', 1);

        $result = false;
        $linkDomain = new \app\api\domain\UserLikeDomain();
        $flag = $linkDomain::getTypeName($flag);
        if(!$this->checkLogin()){
            return $this->returnData([], '用户未登录', 401);
        }else if(empty($object_id) || empty($flag)){
            return $this->returnData([], '参数不符合规范', 301);
        }elseif($type == 1){
            $result = $linkDomain->createLike($this->getUserId(),$object_id,$flag);
        }else if($type == 2){
            $result = $linkDomain->cancelLike($object_id,$this->getUserId(),$flag);
        }

        if($result){
            return $this->returnData([], '操作成功', 200);
        }else{
            return $this->returnData([], '操作失败', 305);
        }
    }
}