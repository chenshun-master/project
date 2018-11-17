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
     * @param $user_id     用户ID1
     * @param $friend_id   用户ID2
     * @return bool
     */
    public function checkFriend($user_id,$friend_id){
        $sql = "SELECT id from wl_user_friends where status = 2  AND  user_id = {$user_id} and friend_id = {$friend_id}
                union all
                SELECT id from wl_user_friends where status = 2  AND  user_id = {$friend_id} and friend_id = {$user_id}";
        $res = Db::query($sql);

        return $res ? true : false;
    }

    /**
     * 解除好友关系
     * @param $user_id     用户ID1
     * @param $friend_id   用户ID2
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delFriend($user_id,$friend_id){
        $user_id2   = $user_id > $friend_id ? $friend_id : $user_id;
        $friend_id2 = $user_id > $friend_id ? $user_id : $friend_id;

        $isTrue = Db::name('user_friends')
            ->where('user_id', $user_id2)
            ->where('friend_id', $friend_id2)
            ->update(['status' =>3]);

        return $isTrue ? true : false;
    }

    /**
     * 创建好友关系
     * @param $user_id     用户ID1
     * @param $friend_id   用户ID2
     * @return bool
     */
    public function createFriend($user_id,$friend_id,$remarks=''){
        $user_id = (int)$user_id;
        $friend_id = (int)$friend_id;

        if($user_id == $friend_id || $user_id ==0){
            return false;
        }

        $sql = "SELECT id from wl_user_friends where user_id = {$user_id} and friend_id = {$friend_id}  union all  SELECT id from wl_user_friends where user_id = {$friend_id} and friend_id = {$user_id}";
        $isTrue = Db::query($sql);
        if($isTrue){
            return true;
        }

        $data = [
            'user_id'        =>$user_id > $friend_id ? $friend_id : $user_id,
            'friend_id'      =>$user_id > $friend_id ? $user_id : $friend_id,
            'applicant_id'   =>$user_id,
            'user_group'     =>0,
            'friend_group'   =>0,
            'status'         =>1,
            'remarks'        =>htmlspecialchars($remarks),
            'create_time'    =>date('Y-m-d H:i:s')
        ];

        $isTrue = Db::name('user_friends')->insertGetId($data);
        return $isTrue ? true : false;
    }

    /**
     * 获取我的好友列表
     * @param $user_id    用户ID
     * @return mixed
     */
    public function getFriendList($user_id){
        $sql = "SELECT friend_id AS friends, user_group AS my_group FROM wl_user_friends WHERE user_id = {$user_id} AND  status = 2  
                UNION ALL 
                SELECT user_id AS friends, friend_group AS my_group FROM wl_user_friends WHERE friend_id ={$user_id} AND  status = 2 ";
        return Db::query($sql);
    }

    /**
     * 添加好友私信
     * @param $send_user        发送者
     * @param $receive_user     接收者
     * @param $content          发送内容
     * @param int $type         发送类型
     * @return bool
     */
    public function createFriendMsg($send_user,$receive_user,$content,$type = 1){
        $data = [
            'send_user_id'      =>$send_user,
            'receive_user_id'   =>$receive_user,
            'is_read'           =>1,
            'created_time'      =>date('Y-m-d H:i:s')
        ];

        if($type == 1){
            $data['content']  = $content;
        }else{
            $data['image']   = $content;
        }

        $isTrue = Db::name('chat_record')->insertGetId($data);
        return $isTrue ? true : false;
    }

    /**
     * 更新私信阅读状态
     * @param  int|array  $id               消息ID
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateReadStatus($id){
        $ids = [];
        if(is_int($id)){
            $ids[] = $id;
        }else if(is_array($id)){
            $ids = $id;
        }else{
            return false;
        }

        $isTrue = Db::name('chat_record')->where('id','in',$ids)->update(['is_read'=>2]);
        return $isTrue === false ? false : true;
    }

    /**
     * 获取好友申请列表
     * @param $user_id    用户ID
     * @return mixed
     */
    public function getFriendsApplyList($user_id){
        $sql = "SELECT tmp_table.*,wl_user.nickname,wl_user.portrait
                from (
                    SELECT id,friend_id AS friends_id,remarks FROM wl_user_friends WHERE user_id = {$user_id} AND  status = 1 and applicant_id != {$user_id}
                    UNION ALL 
                    SELECT id,user_id AS friends_id,remarks FROM wl_user_friends WHERE friend_id ={$user_id} AND  status = 1 and applicant_id != {$user_id}
                ) tmp_table
                INNER JOIN wl_user  on wl_user.id = tmp_table.friends_id";

        return Db::query($sql);
    }

    /**
     * 处理好友申请状态
     * @param $user_id
     * @param $id            申请记录ID
     * @param $status
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function handleFriendsApply(int $user_id,$id,int $status){
        $isTrue = Db::name('user_friends')
            ->where('id', $id)
            ->where("user_id = {$user_id} OR friend_id={$user_id}")
            ->update(['status' =>$status]);

        return $isTrue ? true : false;
    }

    public function getPrivateLetterList($user_id,$page,$page_size){
        return [
            'rows'          =>0,
            'page'          =>1,
            'page_total'    =>1,
            'total'         =>0
        ];
    }
}