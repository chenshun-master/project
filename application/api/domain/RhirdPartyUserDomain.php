<?php
namespace app\api\domain;

use think\Db;

class RhirdPartyUserDomain
{

    /**
     * 返回第三方登录手机号
     * @param array $params    授权参数
     * @param $type            授权类型 1:微信授权   2:
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMobile(array $params,$type){
        $obj = Db::name('third_party_user other');
        $obj->leftJoin('wl_user user','user.id = other.user_id');
        if($type == 1){
            $obj->where('other.wx_unionid',$params['wx_unionid']);
        }
        return $obj->value('user.mobile');
    }

    /**
     * 查询手机号与第三方登录绑定信息
     * @param $mobile           手机号
     * @param $authToken        授权token
     * @param $authType         授权type
     * @return bool
     */
    public function getBindingInfo($mobile,$authToken,$authType){

        $authObj = Db::name('third_party_user');
        if($authType == 1){
            $where = ['wx_unionid'=>$authToken];
        }else if($authType == 2){
            $where = ['qq_openid'=>$authToken];
        }else if($authType == 3){
            $where = ['wb_openid'=>$authToken];
        }else if($authType == 4){
            $where = ['zfb_openid'=>$authToken];
        }

        if($authObj->where($where)->find()){
            return true;
        }

        $obj = Db::name('user')->alias('user');
        $obj->leftJoin('third_party_user other','other.user_id = user.id');
        $obj->where('user.mobile',$mobile);
        $obj->field('other.*,user.mobile');
        $info = $obj->find();
        if($info){
            if($authType == 1 && !empty($info['wx_unionid'])){
                return true;
            }else if($authType == 2 && !empty($info['qq_openid'])){
                return true;
            }else if($authType == 3 && !empty($info['wb_openid'])){
                return true;
            }else if($authType == 4 && !empty($info['zfb_openid'])){
                return true;
            }
        }

        return false;
    }
}