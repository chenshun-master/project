<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/11/30
 * Time: 16:46
 */

namespace app\api\domain;


use app\api\model\AdminModel;

class AdminDomain
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }


    /**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名）
	 * @return integer           登录成功-
	 */
	public function login($username, $password, $type = 1){
		$map = array();
		switch ($type) {
			case 1:
				$map['username'] = $username;
				break;
			case 2:
				$map['email'] = $username;
				break;
			case 3:
				$map['mobile'] = $username;
				break;
			case 4:
				$map['id'] = $username;
				break;
			default:
				return 0; //参数错误
		}
		/* 获取用户数据 */
		$user = $this->get($map);
		if($user){
			/* 验证用户密码 */
			if(md5($password) === $user->password){
				$this->updateLogin($user->id); //更新用户登录信息
				return $user->id; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}
}