<?php

namespace app\api\controller;

use app\api\model\SpCategoryModel;
use think\Db;
use app\api\domain\ShOrderDomain;
use app\api\domain\SpGoodsDomain;

class Test
{

    public function test(){
//        $obj = new \app\api\domain\RhirdPartyUserDomain();
//        $user_info = [
//            'wx_unionid' =>'omVTG0xnnNWVjStsPqvLLGyHvemg',
//        ];
//
//        $mobile = $obj->getMobile($user_info,'weixin');
//
//        halt($mobile);

        $str = encryptStr('TEt3AV9wEmP8MTNHTm3L7ehtKYmNbqQ9YBzP58SGJ47gh+qb','D',config('conf.secret_key'));
        halt($str);
        return redirect('/weixin/index/otherLoginBindingMobile')->params(['auth_token'=>urlencode($str),'type'=>1]);
    }

    public function tt(){

        //密码加密
        $str = 'aa123456';
        $pwd = password_hash('aa123456',PASSWORD_DEFAULT);
        dump($pwd);
        dump(strlen($pwd));
        dump(password_verify( $str, $pwd));
    }
}