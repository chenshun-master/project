<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/12
 * Time: 15:33
 */

namespace app\admin\controller;


use app\api\domain\SpGoodsDomain;
use think\App;

class Goods extends BaseController
{
    private $SpGoodsDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->SpGoodsDomain = new SpGoodsDomain();
    }

    public function index()
    {
        return $this->fetch('/goods/index');
    }

    /**
     * 商品列表
     */
    public function getGoodsList(){
        $name = $this->request->post('name');
        $data = $this->SpGoodsDomain->getGoodsList($name,0,1,10);
        return $this->returnData($data,'',0);
    }
}