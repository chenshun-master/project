<?php
namespace app\api\domain;

use think\Db;

class RhirdPartyUserDomain
{

    /**
     * 返回第三方登录结果
     * @param $user_info
     * @param $type
     * @return array|bool
     */
    public function userHandle($user_info,$type){
        $openid = $user_info['openid'];
        $res = Db::query("select a.*,b.id as uid,b.mobile from wl_third_party_user a left join wl_user b on a.user_id=b.id where a.openid=? AND a.type=?", [$openid, $type]);
        $data = [];
        $data['type'] = $type;
        if($res){
            $data['binding'] = empty($res[0]['uid']) ? 0 : 1;
            $data['id'] =  $res[0]['id'];
            $data['openid'] =  $res[0]['openid'];
            $data['mobile'] =  isset($res[0]['mobile']) && !empty($res[0]['mobile']) ? $res[0]['mobile'] : '';
        }else{
            $id = Db::name('third_party_user')->insertGetId([
                'user_id'           =>0,
                'type'              =>$type,
                'nickname'          =>$user_info['nick'],
                //'app_id'            =>$user_info['app_id'],
                'openid'            =>$user_info['openid'],
                'union_id'          =>isset($user_info['union_id'])?$user_info['union_id']:'',
                'created_time'      =>date('Y-m-d H:i:s')
            ]);

            if(!$id){return false;}

            $data['binding'] = 0;
            $data['id'] =  $id;
            $data['openid'] =  $user_info['openid'];
        }
        return $data;
    }

    /**
     * 查询手机号与第三方登录绑定信息
     * @param $mobile
     * @param $id
     * @return bool
     */
    public function getBindingInfo($mobile,$id){
        $sql = "SELECT a.id as user_id,b.id as third_id,b.type FROM wl_user a LEFT JOIN wl_third_party_user b ON a.id = b.user_id where a.mobile = '{$mobile}' and b.type = (SELECT type from wl_third_party_user WHERE id ={$id}) limit 1";

        $res = Db::query($sql);
        if($res){
            return $res[0];
        }
        return false;
    }
}