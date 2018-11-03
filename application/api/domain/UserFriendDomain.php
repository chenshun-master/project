<?php
namespace app\api\domain;

use think\Db;

/**
 * 好友关系操作类
 * @package app\api\domain
 */
class UserFriendDomain
{

    /**
     * 判断两个用户是否已经成功好友
     * @param $user_id
     * @param $to_user_id
     * @return bool
     */
    public function checkFriend($user_id,$to_user_id){
        $sql = "SELECT id from wl_users_friends where status = 2  AND  user_id = {$user_id} and friend_id = {$to_user_id}
                union all
                SELECT id from wl_users_friends where status = 2  AND  user_id = {$to_user_id} and friend_id = {$user_id}";
        $res = Db::query($sql);
        return $res ? true : false;
    }

    /**
     * 解除好友关系
     * @param int $user_id         用户1
     * @param int $friend_id       用户2
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delFriend($user_id,$friend_id){
        $user_id2   = $user_id > $friend_id ? $friend_id : $user_id;
        $friend_id2 = $user_id > $friend_id ? $user_id : $friend_id;

        $isTrue = Db::name('users_friends')
            ->where('user_id', $user_id2)
            ->where('friend_id', $friend_id2)
            ->update(['status' =>3]);

        return $isTrue ? true : false;
    }

    /**
     * 创建好友关系
     */
    public function createFriend($user_id,$friend_id){
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
     * 获取我的好友列表
     * @param $user_id
     * @return mixed
     */
    public function getFriendList($user_id){
        $sql = "SELECT friend_id AS friends, user_group AS my_group FROM wl_users_friends WHERE user_id = {$user_id} AND  status = 2  UNION ALL SELECT user_id AS friends, friend_group AS my_group FROM wl_users_friends WHERE friend_id ={$user_id} AND  status = 2 ";
        return Db::query($sql);
    }

    /**
     * 添加好友信息
     */
    public function createFriendMsg($data){
        $isTrue = Db::name('chat_record')->insertGetId($data);
        return $isTrue ? true : false;
    }
}