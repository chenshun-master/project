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
        $name = $this->request->post('name');
        $goodsList = $this->SpGoodsDomain->getGoodsList();
        $this->assign('goods',$goodsList);
        return $this->fetch('/goods/index');
    }
}