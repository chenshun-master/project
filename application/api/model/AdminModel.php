<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/30
 * Time: 16:44
 */

namespace app\api\model;


use think\Model;

class AdminModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_admin';
    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名）
     * @return integer           登录成功
     */
    public function login($username, $password, $type = 1){
        $map = array();
        switch ($type) {
            case 1:
                $map['username'] = $username;
                break;
            default:
                return 0; //参数错误
        }
        /* 获取用户数据 */
        $user = $this->get($map);
        if($user){
            /* 验证用户密码 */
            if(encryptPwd($password) !== $user->password) {
                return 2;
            }
        } else {
            return 3; //用户不存在或被禁用
        }
    }
}