<?php
namespace app\index\controller;

use think\App;
use app\api\domain\SpGoodsDomain;

class Shop extends CController
{
    private $_spGoodsDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_spGoodsDomain = new SpGoodsDomain();
    }

    public function index(){
        if (!$this->checkLogin()) {
            return redirect('/login');
        }

        $domain = new \app\api\domain\SpCategory();
        $data = $domain->getCategoryList(0);
        $this->assign('categoryList',$data);

        return $this->fetch('shop/shoplist');
    }

    /**
     * 分销商品编辑页面
     */
    public function shopEditor(){
        if (!$this->checkLogin()) {
            return redirect('/login');
        }

        $shopGoodInfo = [];
        $gid = $this->request->param('gid/d',0);
        if($gid){
            $data  = $this->_spGoodsDomain->getGoodsDetail($gid);
            $shopGoodInfo = [
                'id'=>$data['goods_info']['id'],
                'name' =>$data['goods_info']['name'],
                'sell_price' =>$data['goods_info']['market_price'],
                'sell_price' =>$data['goods_info']['sell_price'],
                'img' =>$data['goods_info']['img'],
                'hospital_name'=>$data['hospital_info']['hospital_name'],
            ];
        }

        $this->assign('goods_info',$shopGoodInfo);
        return $this->fetch('shop/good_editor');
    }

    /**
     * 创建分销商品
     */
    public function createGoodGoods(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $good_goods_id = $this->request->post('goodsid/d',0);
        $gid = $this->request->post('gid/d',0);
        $title = $this->request->post('title','');
        $content = $this->request->post('content','');

        if(empty($gid) || empty($title) || empty($content)){
            return $this->returnData([],'参数不符合规范',301);
        }

        $data = [
            'user_id'   =>$this->getUserId(),
            'goods_id'  =>$gid,
            'title'     =>$title,
            'article_text'=>$content
        ];

        $res = false;
        if($good_goods_id == 0){
            $domain = new \app\api\domain\SpGoodGoodsDomain();
            if($domain->findGoodGoods($this->getUserId(),$gid)){
                return $this->returnData([],'此商品不能重复发表',301);
            }
            $res = $domain->create($data);
        }

        if(!$res){
            return $this->returnData([],'操作成功',301);
        }

        return $this->returnData([],'操作成功',200);
    }

    /**
     * 获取分销列表
     * @return mixed|\think\response\Redirect
     */
    public function myShopList(){
        if (!$this->checkLogin()) {
            return redirect('/login');
        }

        $page = $this->request->param('page/d',1);
        $page_size = $this->request->param('page_size',15);
        $data = (new \app\api\domain\SpGoodGoodsDomain())->getUserGoodGoodsList($this->getUserId(),$page,$page_size);

        $this->assign('list',$data);
        return $this->fetch('shop/myshoplist');
    }

    /**
     * 获取商品列表
     */
    public function getShopList(){
        $data = [
            'category' => $this->request->post('category', ''),
            'sort' => $this->request->post('sort/d', 0),
            'city' => $this->request->post('city', ''),
            'keywords' => $this->request->post('keywords', '')
        ];

        $page = $this->request->param('page/d',1);
        $page_size = $this->request->param('page_size',12);

        $data = $this->_spGoodsDomain->getSearchGoods($data,$page,$page_size);
        return $this->returnData($data, '', 200);
    }

    /**
     *
     * @param Request $request
     * @return false|string
     */
    public function getCategoryList(){
        $category_id = $this->request->post('category_id',0);
        $domain = new \app\api\domain\SpCategory();
        $data = $domain->getCategoryList($category_id);
        return $this->returnData(['rows'=>$data],'',200);
    }
}