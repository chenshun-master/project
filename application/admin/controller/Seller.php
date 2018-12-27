<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/11
 * Time: 18:24
 */

namespace app\admin\controller;


use app\api\domain\SellerDomain;
use think\App;
use think\Db;

class Seller extends BaseController
{
    private $_sellerDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_sellerDomain = new SellerDomain();
    }

    public function index()
    {
        return $this->fetch('/seller/index');
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
            return $this->returnData([],'修改成功','200');
        }else{
            return $this->returnData([],'修改失败','301');
        }
    }
}