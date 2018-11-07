<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/2
 * Time: 18:04
 */

namespace app\api\domain;

use app\api\model\AuthModel;
use think\Db;

/**
 * 账号认证处理业务层
 * @package app\api\domain
 */
class AuthDomain
{

    /**
     * 提交认证申请记录
     * @param $params
     * @return bool|int  (true : 提交成功  false:提交失败  1:身份证号已被使用 2:认证类型与上次申请类型不符)
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addAuthentication($params){
        $params['status'] =  1;
        $params['created_time'] =  date('Y-m-d H:i:s');

        $authModel = new AuthModel();
        $res = Db::name('auth')->where('user_id',$params['user_id'])->field('id,user_id,status,idcard,type')->find();
        $res1 = $authModel->findIdCard($params['idcard']);

        try {
            if(!$res){
                if($res1){return 1;}

                $isTrue  = Db::name('auth')->insert($params);
            }else if($res['status'] != 3){
                if($res1 !== $res['user_id']){
                    return 1;
                }

                if(intval($params['type']) != intval($res['type'])){
                    return 2;
                }

                $isTrue  = Db::name('auth')->where('id', $res['id'])->data($params)->update();
            }
        } catch (\Exception $e) {
            return false;
        }

        return $isTrue ? true : false;
    }

    /**
     * 后台认证审核接口
     * @param $id               认证ID
     * @param $status           审核状态
     * @param $audit_remark     审核备注
     * @return bool
     */
    public function authVerify($id,$status,$audit_remark){
        Db::startTrans();
        try {
            if((int)$status === 2){
                $auth_info = Db::name('auth')->find($id);
                $isTrue1  = Db::name('user')->where('id', $auth_info['id'])->data(['type'=>$auth_info['type']])->update();
                if(!$isTrue1){
                    Db::rollback();return false;
                }
            }

            $isTrue2  = Db::name('auth')->where('id', $id)->data([
                'status'        =>$status,
                'audit_time'    =>date('Y-m-d H:i:s'),
                'audit_remark'  =>$audit_remark
            ])->update();
            if(!$isTrue2){
                Db::rollback();return false;
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }
}