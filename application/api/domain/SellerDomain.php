<?php
namespace app\api\domain;


use think\Db;

class SellerDomain
{

    /**
     * 商家登录验证
     * @param $mobile         手机号
     * @param $password       密码
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($mobile,$password){
        $user_info = Db::name('user')->where('mobile',$mobile)->where('type','in',[2,3,4])->field('id,mobile,password,type')->find();
        if(!$user_info){
            return 1;
        }

        if($user_info['password'] !== encryptPwd($password)){
            return 2;
        }

        $seller_info = Db::name('sp_seller')->where('user_id',$user_info['id'])->field('id as seller_id,is_lock,user_id')->find();
        if(!$seller_info){
            return 3;
        }

        if($seller_info['is_lock'] == 1){
            return 4;
        }

        $auth_info = Db::name('auth')->where('user_id',$user_info['id'])->field('username,enterprise_name')->find();
        return [
            'seller_id'     =>$seller_info['seller_id'],
            'user_id'       =>$seller_info['user_id'],
            'type'          =>$user_info['type'],
            'hospital_name' =>$auth_info['enterprise_name'],
            'real_name'     =>$auth_info['username'],
        ];
    }
}