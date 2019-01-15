<?php
namespace app\api\controller;
use think\Request;
use app\api\model\UserModel;

use app\common\classs\Jwt;

/**
 * 接口基类控制器
 * Class BaseController
 * @package app\api\controller
 */
class BaseController
{

    protected $uid = 0;

    protected function getUid(){
        if(empty($uid)){
            $verifyResult = (new Jwt())->verifyToken(\request()->param('token',''));
            if($verifyResult !== false){
                $this->uid = $verifyResult;
            }
        }
        return $this->uid;
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

}