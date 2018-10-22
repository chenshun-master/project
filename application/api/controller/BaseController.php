<?php
namespace app\api\controller;
use think\Request;
use app\api\model\UserModel;

/**
 * 接口基类控制器
 * Class BaseController
 * @package app\api\controller
 */
class BaseController
{

    /**
     * 验证请求来源用户验证
     */
    protected function checkUserToken(){
        $secret_key = config('conf.secret_key');
        $token = request()->param('token');
        $token = encryptStr($token,'D',$secret_key);
        if(empty($token)){
            returnData([],'非法请求，用户验证失败',401);
        }

        $info = json_decode($token,true);

        if(strtotime($info['expire_time']) < time()){
            returnData([],'用户登录已失效',403);
        }

        $userModel = new UserModel();
        $userInfo = $userModel->findMobile($info['mobile']);

        if($userInfo && md5($userInfo['id']) == $info['uid']){
            return $userInfo;
        }

        returnData([],'非法请求，用户验证失败',401);
    }

    /**
     * 生成用户验证token
     * @param $user_info
     * @return bool|mixed|string
     */
    protected function getUserToken($user_info){
        $secret_key = config('conf.secret_key');
        $token = json_encode([
            'uid'=>md5($user_info['id']),
            'expire_time'=>date('YmdHis',time()+60*60*24),
            'mobile'=>$user_info['mobile']
        ]);

        return encryptStr($token,'E',$secret_key);
    }

    /**
     * 返回接口数据
     * @param array $data    接口数据
     * @param string $msg    信息提示
     * @param int $code      状态码
     * @return false|string
     */
    protected function returnData($data=[],$msg='',$code = 200){
        return json_encode([
            'code' =>$code,
            'msg'  =>$msg,
            'data' =>$data
        ]);
    }

    /**
     * 验证用户权限
     * @param $type        用户类型; 1:普通用户;2:认证用户;3:认证医生;4:认证医院;5:官方团队
     * @param $authType    授权类型: 1:发表评论 2:购买商品 3:关注用户 4:发送私信 5:发表说说 6:发布提问 7:发表内容 8:发表案例 9:开设店铺 10:入驻医院 11:关联认证医生
     * @return bool
     */
    protected function checkUserAuth($type,$authType){
        return checkUserAuth($type,$authType);
    }
}