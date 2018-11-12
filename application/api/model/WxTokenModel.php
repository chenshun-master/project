<?php
namespace app\api\model;
use think\Model;

class WxTokenModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_wx_token';

    /**
     * 添加Access_token
     * @param type $data
     * @return type
     */
    public function createToken($data){
        $insterRes = self::create($data);
        return $insterRes;
    }

    /**
     * 获取最新的Access_token信息
     * @return type
     */
    public function findAccessToekn($appid){
        $res = self::where('app_id',$appid)->order('created_at', 'desc')->find();
        if($res){
            return $res;
        }
        return [];
    }
}