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
    private $SellerDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->SellerDomain = new SellerDomain();
    }

    public function index()
    {
        return $this->fetch('/seller/index');
    }
    /**
     * 商户列表
     */
    public function getSellerList(){
        $data = $this->SellerDomain->getSellerList();
        return $this->returnData($data,'',0);
    }

    /**
     * 是否锁定
     */
    public function update(){
        $data = input('param.');
        $result = Db::name('sp_seller')->where('id', $data['id'])->update(['is_lock' => $data['is_lock']]);
        if($result){
            $this->redirect('/admin/seller/index');
        }else{
            $this->error('修改失败', cookie("prevUrl"));
        }
    }
}