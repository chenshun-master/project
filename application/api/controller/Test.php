<?php
namespace app\api\controller;

use think\Db;
use app\common\helpers\Jwt;
use think\Request;
use app\api\model\InquiryModel;

class Test
{
//    public function tt(){
//        $all = Db::name('sp_goods')->alias('goods')->leftJoin('wl_sp_seller seller','seller.id = goods.seller_id')->field('goods.id,goods.seller_id,seller.user_id')->select();
//        foreach ($all as $v){
//            Db::name('sp_goods')->where('id',$v['id'])->update(['seller_id'=>$v['user_id']]);
//            Db::name('sh_order')->where('goods_id',$v['id'])->update(['seller_id'=>$v['user_id']]);
//        }
//    }

//    public function t2(Request $request){
//        $image = \think\Image::open('./20150521142543307.jpg');
//        //将图片裁剪为300x300并保存为crop.png
//        $image->thumb(240, 180,\think\Image::THUMB_CENTER)->save('./20150521142543307_240_180.png');
//    }

      public function test(){
          $data = app('domain')->getDomain('rechargedomain')->addRechargeOrder([
              'user_id'   =>61,
              'mode'      =>1,
              'account'   =>500.00,
              'return_url'=>'http://172.16.100.85/weixin/shop/index',
              'notify_url'=>'http://172.16.100.85/weixin/shop/index',
              'request_ip'=>'192.168.220.180',
          ]);
          halt($data);
      }
}