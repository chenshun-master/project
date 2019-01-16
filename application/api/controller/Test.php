<?php
namespace app\api\controller;

use think\Db;

use app\common\helpers\Jwt;
use think\Request;

class Test
{
    public function tt(){
//        $all = Db::name('sp_goods')->alias('goods')->leftJoin('wl_sp_seller seller','seller.id = goods.seller_id')->field('goods.id,goods.seller_id,seller.user_id')->select();
//        foreach ($all as $v){
//            Db::name('sp_goods')->where('id',$v['id'])->update(['seller_id'=>$v['user_id']]);
//            Db::name('sh_order')->where('goods_id',$v['id'])->update(['seller_id'=>$v['user_id']]);
//        }
    }

    public function t2(Request $request){

    }
}