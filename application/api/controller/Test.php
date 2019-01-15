<?php
namespace app\api\controller;

use app\api\model\SpCategoryModel;
use think\Db;
use app\api\domain\ShOrderDomain;
use app\api\domain\SpGoodsDomain;

use app\common\classs\MyJwt;
use app\common\classs\Jwt;

class Test
{
    public function tt(){
//        $all = Db::name('sp_goods')->alias('goods')->leftJoin('wl_sp_seller seller','seller.id = goods.seller_id')->field('goods.id,goods.seller_id,seller.user_id')->select();
//        foreach ($all as $v){
//            Db::name('sp_goods')->where('id',$v['id'])->update(['seller_id'=>$v['user_id']]);
//            Db::name('sh_order')->where('goods_id',$v['id'])->update(['seller_id'=>$v['user_id']]);
//        }
    }



    public function t2(){
        $payload_test = array('iss' => 'adminsdfasd');



        halt(MyJwt::getPayload($payload_test));

    }


}