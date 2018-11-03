<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/2
 * Time: 18:04
 */

namespace app\api\domain;


/**
 * 账号认证处理业务层
 * @package app\api\domain
 */
class AuthDomain
{

    /**
     * 添加认证申请记录
     * @param $params
     * @return bool
     */
    public function addAuthentication($params){
        $params['status'] =  1;
        $params['created_time'] =  date('Y-m-d H:i:s');
        $res = Db::name('real_name')->where('user_id',$params['user_id'])->find();
        if(!$res){
            $isTrue  = Db::name('real_name')->insert($params);
        }else if($res['status'] == 2){
            $isTrue  = Db::name('real_name')->where('id', $res['id'])->data($params)->update();
        }else{
            return false;
        }
        return $isTrue ? true : false;
    }


    /**
     * 认证审核接口
     */
    public function authVerify(){

    }

}