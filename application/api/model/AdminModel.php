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
     * 登录操作
     * @param $username
     * @param $password
     * @param bool $quickLogin 是否需要验证密码
     * @return array|int|null|\PDOStatement|string|Model 2:用户不存在   3:密码错误
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($username,$password,$quickLogin=false){
        $info = self::where('username',$username)->find();
        if(!$info['username']){
            return 2;
        }

        #判断是否需要验证登录密码
        if(!$quickLogin){
            if($info['password'] !== encryptPwd($password)){
                return 3;
            }
        }

        //登录用户读取属于自己的消息通知(后期会加入异步队列处理)
        (new \app\api\domain\MessageDomain())->readMsg($info['id']);
        return $info;
    }

}