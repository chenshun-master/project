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
     * @param  $page 当前页码
     * @param  $page_size 每页展示的数据
     */
    public function getGoodsList($page=1,$page_size=10){
        if($this->request->post('status')){
            $search = $this->request->post('status');
        }else{
            $search = '';
        }
        $data = $this->SpGoodsDomain->getGoodsList($search,0,$page,$page_size);
        return $this->returnData($data,'',0);
    }

}