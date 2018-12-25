<?php
namespace app\api\domain;


use function PHPSTORM_META\type;
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
        $user_info = Db::name('user')->where('mobile',$mobile)->where('type','in',[3,4])->field('id,mobile,password,type,portrait')->find();
        if(!$user_info){
            return 1;
        }

        if($user_info['password'] !== encryptPwd($password)){
            return 2;
        }

        $seller_info = Db::name('sp_seller')->where('user_id',$user_info['id'])->field('id as seller_id,is_lock,user_id')->find();
        if($seller_info){
            $seller_id = $seller_info['seller_id'];
            if($seller_info['is_lock'] == 1){
                return 4;
            }
        }else{
            $seller_id = Db::name('sp_seller')->insertGetId(['user_id'=>$user_info['id'],'is_lock'=>0,'create_time'=>date('Y-m-d H:i:s')]);
            if(!$seller_id){
                return 3;
            }
        }

        $auth_info = Db::name('auth')->where('user_id',$user_info['id'])->field('username,enterprise_name')->find();
        return [
            'seller_id'     =>$seller_id,
            'user_id'       =>$user_info['id'],
            'type'          =>$user_info['type'],
            'hospital_name' =>$auth_info['enterprise_name'],
            'real_name'     =>$auth_info['username'],
            'portrait'      =>$user_info['portrait']
        ];
    }

    /**
     * 商户信息列表
     * @param int $page
     * @param int $page_size
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSellerList($page=1,$page_size=10)
    {
        $sellerInfo = Db::name('auth')->alias('auth');
        $sellerInfo->join('wl_user user','auth.user_id = user.id');
        $sellerInfo->join('sp_seller sp','user.id = sp.user_id');
        $sellerInfo->where('user.type','in',[2,3,4]);
        $sellerInfo->order('sp.id desc');

        $total = $sellerInfo->count(1);

        $field  = [
          'sp.id',
          'user.mobile',
          'user.nickname',
          'user.portrait',
          'user.type',
          'auth.enterprise_name',
          'sp.is_lock',
          'sp.account',
          'sp.grade',
          'sp.sale',
          'sp.comments',
          'sp.create_time',
        ];
        $rows = $sellerInfo->field($field)->page($page,$page_size)->select();
        return [
            'rows' => $rows,
            'page' => $page,
            'page_total' => getPageTotal($total,$page_size),
            'total' => $total,
        ];
    }
}