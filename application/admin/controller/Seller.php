<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/11
 * Time: 18:24
 */

namespace app\admin\controller;


use app\api\domain\AuthDomain;
use app\api\domain\SellerDomain;
use app\api\domain\SpGoodsDomain;
use think\App;
use think\Db;

class Seller extends BaseController
{
    private $_sellerDomain;
    private $_spGoodsDomain;
    private $_authDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_sellerDomain = new SellerDomain();
        $this->_spGoodsDomain = new SpGoodsDomain();
        $this->_authDomain = new AuthDomain();
    }

    /**
     * 商户列表页面
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('/seller/index');
    }

    /**
     * 商品列表页面
     * @return mixed
     */
    public function goodsIndex()
    {
        return $this->fetch('/seller/goods_index');
    }

    /**
     * 认证列表页面
     * @return mixed
     */
    public function authIndex(){
        return $this->fetch('/seller/auth_index');
    }

    /**
     * 商户列表
     * @param $page
     * @param $page_size
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSellerList($page=1,$page_size=10){
        $data = $this->_sellerDomain->getSellerList($page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 是否锁定
     */
    public function update(){
        $id = $this->request->post('id');
        $is_lock = $this->request->post('is_lock');
        if($is_lock == 0){
            $result = Db::name('sp_seller')->where('id', $id)->update(['is_lock' => 1]);
        }else{
            $result = Db::name('sp_seller')->where('id', $id)->update(['is_lock' => 0]);
        }
        if($result){
            return $this->returnData([],'修改成功',200);
        }else{
            return $this->returnData([],'修改失败',301);
        }
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

    /**
     * 认证列表
     * @param int $page
     * @param int $page_size
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthList($page=1,$page_size=10){
        $status = $this->request->param('status/d',0);
        $data = $this->_authDomain->getAuthList($status,$page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 修改认证状态 1-待审核 2-审核失败 3-已审核
     * @return false|string
     */
    public function updateAuthStatus(){
        $id = $this->request->post('id','');
        $flag = $this->request->post('flag','');
        $audit_remark = $this->request->post('audit_remark','');


        if(empty($id) || empty($status) || empty($audit_remark)){
            $this->returnData([],'参数不符合规范',301);
        }

        if($flag == 'fail'){
            $status = 2;
        }else if($flag == 'success'){
            $status = 3;
        }else{
            return $this->returnData([],'参数不符合规范',301);
        }

        $isTrue = $this->_authDomain->authVerify($id,$status,$audit_remark);

        if($isTrue){
            return $this->returnData([],'更新成功',200);
        }

        return $this->returnData([],'',305);
    }
}