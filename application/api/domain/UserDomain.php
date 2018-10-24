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
     * 添加认证申请记录
     * @param $params
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function addAuthentication($params){
        $params['status'] =  1;
        $params['created_time'] =  date('Y-m-d H:i:s');
        $res = Db::name('real_name')->where('user_id',$params['user_id'])->find();
        if(!$res){
            $isTrue  = Db::name('real_name')->insert($params);
        }else if($res['status'] == 2){
            $isTrue  = Db::name('real_name')->where('id', $res['id'])->data($params)->update();
        }else{
            return false;
        }

        if(!$isTrue){
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
     * 获取文章发布者信息
     */
    public function getArticleUserInfo($user_id){
        return  Db::name('user')->where('id',$user_id)->field('id,type,mobile,nickname,portrait,profile')->find();
    }

    /**
     * 判断两个用户是否已经成功好友
     * @param $user_id
     * @param $to_user_id
     * @return bool
     */
    public function checkFriend($user_id,$to_user_id){
        $sql = "SELECT id from wl_users_friends where status = 1  AND  user_id = {$user_id} and friend_id = {$to_user_id}
                union all
                SELECT id from wl_users_friends where status = 1  AND  user_id = {$to_user_id} and friend_id = {$user_id}
                ";

        $res = Db::query($sql);

        return $res ? true : false;
    }

    /**
     * 解除好友关系
     * @param int $user_id         用户1
     * @param int $friend_id      用户2
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function addFriend($user_id,$friend_id){
        $user_id2   = $user_id > $friend_id ? $friend_id : $user_id;
        $friend_id2 = $user_id > $friend_id ? $user_id : $friend_id;

        $isTrue = Db::name('users_friends')
            ->where('user_id', $user_id2)
            ->where('friend_id', $friend_id2)
            ->update(['status' =>3]);

        return $isTrue ? true : false;
    }

    /**
     * 解除好友关系
     */
    public function delFriend($user_id,$friend_id){
        $user_id = (int)$user_id;
        $friend_id = (int)$friend_id;

        if($user_id == $friend_id || $user_id ==0){
            return false;
        }

        $data = [
            'user_id'        =>$user_id > $friend_id ? $friend_id : $user_id,
            'friend_id'      =>$user_id > $friend_id ? $user_id : $friend_id,
            'user_group'     =>0,
            'friend_group'   =>0,
            'status'         =>1,
            'create_time'    =>date('Y-m-d H:i:s')
        ];


        $isTrue = Db::name('users_friends')->insertGetId($data);

        return $isTrue ? true : false;
    }

    /**
     * 获取好友列表
     * @link https://blog.csdn.net/u011283226/article/details/80706784   可通过这个查看
     * @param $user_id
     */
    public function getFriendList($user_id){

        #查询好友列表
        $sql = "
                SELECT friend_id AS friends, user_group AS my_group FROM wl_users_friends WHERE user_id = 4
                UNION ALL
                SELECT user_id AS friends, friend_group AS my_group FROM wl_users_friends WHERE friend_id = 4;
                ";
    }
}