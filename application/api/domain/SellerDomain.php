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
    public function login($mobile,$password,$noPassword = false){
        $user_info = Db::name('user')->alias('user')
            ->leftJoin('wl_auth auth','user.id = auth.user_id')
            ->where('user.mobile',$mobile)
            ->where('user.type','in',[3,4])
            ->field('user.id,user.mobile,user.password,user.type,user.portrait,auth.username,auth.enterprise_name')
            ->find();

        if(!$user_info){return 1;}

        if(!$noPassword && $user_info['password'] !== encryptPwd($password)){
            return 2;
        }

        return [
            'user_id'       =>$user_info['id'],
            'type'          =>$user_info['type'],
            'hospital_name' =>$user_info['enterprise_name'],
            'real_name'     =>$user_info['username'],
            'portrait'      =>$user_info['portrait']
        ];
    }

    /**
     * 商户信息列表
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSellerList($page=1,$page_size=10)
    {
        $sellerInfo = Db::name('user');
        $sellerInfo->where('type','in',[3,4]);
        $sellerInfo->order('created_time desc');
        $total = $sellerInfo->count(1);

        $field  = [
            'mobile',
            'nickname',
            'portrait',
            'type',
            'profile',
            'created_time',
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