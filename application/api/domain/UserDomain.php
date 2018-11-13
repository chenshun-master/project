<?php
namespace app\api\domain;
use app\api\model\UserModel;
use think\Db;

/**
 * 用户数据业务处理层
 * @package app\api\domain
 */
class UserDomain
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * 创建用户
     */
    public function createUser($params){
        $isTrue = $this->userModel->findMobileExists($params['mobile']);
        if($isTrue){
            return 3;
        }

        $data = [
            'mobile'        =>$params['mobile'],
            'nickname'      =>mobileFilter($params['mobile']),
            'password'      =>encryptPwd($params['password']),
            'type'          =>1,
            'created_time'  =>date('Y-m-d H:i:s')
        ];

        $id = Db::table('wl_user')->insertGetId($data);
        if(!$id){
            return false;
        }

        return true;
    }

    /**
     * 获取用户信息
     * @param $user_id     用户id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function getUserInfo($user_id){
        return $this->userModel->findUserId($user_id);
    }

    /**
     * 获取用户认证信息
     */
    public function getAuthInfo($user_id){
        $authInfo = Db::name('auth')->where('user_id',$user_id)->find();

        return $authInfo ?: [];
    }

    /**
     * 登录操作
     * @param $mobile
     * @param $password
     * @param bool $quickLogin   是否需要验证密码
     * @return array|int|null|\PDOStatement|string|\think\Model     2:用户不存在   3:密码错误
     */
    public function login($mobile,$password,$quickLogin=false){
        $info = $this->userModel->findMobile($mobile);
        if(!$info){
            return 2;
        }

        #判断是否需要验证登录密码
        if(!$quickLogin){
            if($info['password'] !== encryptPwd($password)){
                return 3;
            }
        }

        return $info;
    }

    /**
     * 修改用户登录密码
     * @param $user_id           用户id
     * @param $old_password      用户旧密码
     * @param $new_password      用户新密码
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editPwd($user_id,$old_password,$new_password){
        $info = $this->userModel->findUserId($user_id);

        if(!$info){
            return false;
        }

        if($info['password'] !== encryptPwd($old_password)){
            return false;
        }

        $res = Db::table('wl_user')
            ->where('id', $user_id)
            ->update(['password' => encryptPwd($new_password)]);

        if(!$res){
            return false;
        }

        return true;
    }

    /**
     * 通过手机号修改密码
     * @param $mobile
     * @param $password
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resetPassword($mobile,$password){
        $res = Db::table('wl_user')
            ->where('mobile', $mobile)
            ->update(['password' => encryptPwd($password)]);

        if($res === false){
            return false;
        }

        return true;
    }

    /**
     * 第三方登录绑定手机号
     */
    public function bindingMobile($mobile,$id){
        $domain = new \app\api\domain\RhirdPartyUserDomain();

        $res = $domain->getBindingInfo($mobile,$id);

        if($res){return false;}

        $pwd = 'wl'.substr($mobile,5,6);
        $data = [
            'mobile'        =>$mobile,
            'nickname'      =>mobileFilter($mobile),
            'password'      =>encryptPwd($pwd),
            'type'          =>1,
            'created_time'  =>date('Y-m-d H:i:s')
        ];

        $user_info = Db::name('user')->where('mobile',$mobile)->field('id')->find();

        Db::startTrans();
        try {
            if($user_info){
                $user_id = $user_info['id'];
            }else{
                $user_id = Db::name('user')->insertGetId($data);
                if(!$user_id){
                    Db::rollback();return false;
                }
            }
            $res2 = Db::name('third_party_user')->where('id', $id)->data(['user_id' => $user_id])->update();
            if(!$res2){
                Db::rollback();return false;
            }
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();return false;
        }
    }

    /**
     * 修改用户信息
     * @param $user_id          用户id
     * @param $data             修改数据
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editProfile($user_id,$data){
        $res = Db::name('user')
            ->where('id', $user_id)
            ->update($data);

        if($res === false){
            return false;
        }

        return true;
    }

    /**
     * 修改用户手机号
     * @param $user_id         用户ID
     * @param $old_mobile      用户旧手机号
     * @param $new_mobile      用户新手机号
     * @param $sms_code        用户手机号验证码
     * @return bool|int
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function changeMobile($user_id,$old_mobile,$new_mobile,$sms_code){
        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($new_mobile,6,$sms_code);
        if($res == 0){
            return 1;
        }else if($res == 2){
            return 2;
        }

        $isTrue = Db::name('user')->where('id',$user_id)->where('mobile',$old_mobile)->update(['mobile'=>$new_mobile]);
        if($isTrue === false){
            return false;
        }

        return true;
    }

    /**
     * 获取文章发布者信息
     */
    public function getArticleUserInfo($user_id){
        return  Db::name('user')->where('id',$user_id)->field('id,type,mobile,nickname,portrait,profile')->find();
    }
}