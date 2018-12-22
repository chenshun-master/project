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
use think\Db;

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
        $status = input('param.status');
        $data = $this->SpGoodsDomain->getGoodsList($status,$page,$page_size);
        return $this->returnData($data,'',0);
    }

    /**
     * 修改商品状态
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function getGoodsStatus(){
        $data = input('param.');
        if($data['status'] == 0){
            $data = Db::name('sp_goods')->where('id',$data['id'])->update(['status' => 3,'up_time'=>date('Y-m-d H:i:s')]);
        }else if($data['status'] == 3){
            $data = Db::name('sp_goods')->where('id',$data['id'])->update(['status'=> 2,'down_time'=>date('Y-m-d H:i:s')]);
        }else if($data['status'] == 2){
            $data = Db::name('sp_goods')->where('id',$data['id'])->update(['status' => 3,'up_time'=>date('Y-m-d H:i:s')]);
        }
        if(!$data){
            return $this->returnData([],'修改失败','301');
        }else{
            return $this->returnData([],'修改成功','200');
        }
    }
}