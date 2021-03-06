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
     * @param $uid1     用户ID1
     * @param $uid2     用户ID2
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkFriend($uid1,$uid2){
        $user_id   = $uid1 > $uid2 ? $uid2 : $uid1;
        $friend_id = $uid1 > $uid2 ? $uid1 : $uid2;
        $res = Db::name('user_friends')->where('user_id',$user_id)->where('friend_id',$friend_id)->where('status',2)->field('id')->find();
        return $res ? true : false;
    }

    /**
     * 判断两个用户是否已经成功好友或者相互关注
     * @param $uid1     用户ID1
     * @param $uid2     用户ID2
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkFollowOrFriend(int $uid1,int $uid2){
        $user_id   = $uid1 > $uid2 ? $uid2 : $uid1;
        $friend_id = $uid1 > $uid2 ? $uid1 : $uid2;
        $res = Db::name('user_friends')->where('user_id',$user_id)->where('friend_id',$friend_id)->where('status','in',[2,3])->field('id')->find();
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
            ->update(['status' =>5]);

        return $isTrue ? true : false;
    }

    /**
     * 创建好友关系
     * @param $user_id              用户ID1
     * @param $friend_id            用户ID2
     * @param string $remarks       申请备注
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
     * 添加好友私信
     * @param $send_user        发送者
     * @param $receive_user     接收者
     * @param $content          发送内容
     * @param int $type         发送类型
     * @return bool
     */
    public function createFriendMsg($send_user,$receive_user,$content,$type = 1){
        $data = [
            'type'              =>$type,
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

        $id = Db::name('chat_record')->insertGetId($data);

        if(!$id){
            return false;
        }

        $data['id'] = $id;
        return $data;
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
     * @param $status        好友状态
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

    /**
     * 获取私信记录
     * @param $uid        用户ID1
     * @param $uid2       用户ID2
     * @param int $record_id
     * @return array
     */
    public function getPrivateLetterList($uid,$uid2,$record_id = 0){
        $where = '';
        $record_id = (int)$record_id;
        if($record_id != 0){
            $where = "  where tmp_tab.id < {$record_id} ";
        }

        $sql = "SELECT tmp_tab.*,user1.portrait as send_user_portrait,user2.portrait as receive_user_portrait from (
                    SELECT * from wl_chat_record where send_user_id = {$uid} and receive_user_id = {$uid2}
                    UNION all
                    SELECT * from wl_chat_record where send_user_id = {$uid2} and receive_user_id = {$uid}
                ) tmp_tab
                LEFT JOIN wl_user user1 on user1.id = tmp_tab.send_user_id
                LEFT JOIN wl_user user2 on user2.id = tmp_tab.receive_user_id
                {$where}  ORDER BY tmp_tab.id desc limit 10";

        return [
            'rows'          =>Db::query($sql),
            'page'          =>1,
            'page_total'    =>1,
            'total'         =>1
        ];
    }

    /**
     * 更新用户私信的阅读状态
     * @param $receive_user_id
     * @param array $ids
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function uploadPrivateLetterStatus($receive_user_id , $ids = []){
        Db::name('chat_record')->where('id','in', $ids)->where('receive_user_id', $receive_user_id)->update(['is_read' => 2]);
    }


    /**
     * 获取未读信息总数
     * @param $send_user_id          发送者
     * @param $receive_user_id       接收者
     * @param $record_id             记录ID
     * @return float|string
     */
    public function getUnreadNum($send_user_id,$receive_user_id,$record_id){
        $obj = Db::name('chat_record')->where('send_user_id', $send_user_id)->where('receive_user_id',$receive_user_id)->where('is_read',1);
        if($record_id > 0){
            $obj->where('id','<', $record_id);
        }
        return $obj->count();
    }

    /**
     * 获取私信消息通知列表
     */
    public function getMessageListData($receive_user_id){
        $count1 = Db::name('chat_record')->where('receive_user_id',$receive_user_id)->count();
        $count2 = Db::name('chat_record')->where('send_user_id',$receive_user_id)->count();

        $sql = "select tmp_tab.*,user.nickname,user.portrait,user.type,auth.username,auth.enterprise_name from (
                
                select tmp.send_user_id as uid,tmp.content,tmp.is_read,tmp.created_time,(SELECT count(1) FROM wl_chat_record r2 WHERE tmp.send_user_id = r2.send_user_id  and r2.is_read = 1 and r2.receive_user_id = {$receive_user_id}) AS unread_num 
                from (SELECT send_user_id,content,is_read,created_time FROM wl_chat_record WHERE receive_user_id = {$receive_user_id} ORDER BY id desc LIMIT {$count1}) tmp GROUP BY tmp.send_user_id
                
                UNION ALL
                
                select tmp.receive_user_id as uid,tmp.content,tmp.is_read,tmp.created_time,0 AS unread_num 
                from (SELECT receive_user_id,content,is_read,created_time FROM wl_chat_record WHERE send_user_id = {$receive_user_id} ORDER BY id desc  LIMIT {$count2}) tmp GROUP BY tmp.receive_user_id
                
                ) tmp_tab 
                
                LEFT JOIN wl_user user on user.id = tmp_tab.uid
                LEFT JOIN wl_auth auth on auth.user_id = tmp_tab.uid
                GROUP BY tmp_tab.uid";
        $rows = Db::query($sql);
        return [
            'rows'          =>$rows,
            'page'          =>1,
            'page_total'    =>1,
            'total'         =>count($rows)
        ];
    }

    /**
     * 判断两个用户是否互相关注
     * @param int $uid1     用户1
     * @param int $uid2     用户2
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkFollow(int $uid1,int $uid2,$applicant_id){
        $user_id   = $uid1 > $uid2 ? $uid2 : $uid1;
        $friend_id = $uid1 > $uid2 ? $uid1 : $uid2;
        $res = Db::name('user_friends')->where('user_id',$user_id)->where('friend_id',$friend_id)->where('applicant_id',$applicant_id)->where('status',3)->fetchSql(false)->field('id')->find();
        return $res ? true : false;
    }

    /**
     * 添加用户关注
     * @param int $user_id         用户ID1
     * @param int $friend_id       用户ID2
     * @param int $applicant_id    发起关注的用户
     * @return bool|int|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function createFollow(int $uid1,int $uid2,$applicant_id){
        $user_id   = $uid1 > $uid2 ? $uid2 : $uid1;
        $friend_id = $uid1 > $uid2 ? $uid1 : $uid2;

        $res = Db::name('user_friends')->where('user_id',$user_id)->where('friend_id',$friend_id)->where('applicant_id',$applicant_id)->where('status','in',[3,4])->find('id,status');
        if($res && $res['status'] == 3){
            return true;
        }else if($res && $res['status'] == 4){
            return Db::name('user_friends')->where('id',$res['id'])->where('status',4)->update(['status'=>3]);
        }

        $data = [
            'user_id'       => $user_id,
            'friend_id'     => $friend_id,
            'applicant_id'  => $applicant_id,
            'status'        => 3,
            'create_time'   => date('Y-m-d H:i:s')
        ];

        $isTrue = Db::name('user_friends')->insertGetId($data);
        return $isTrue  ? true : false;
    }

    /**
     * 取消用户关注
     * @param int $user_id         用户ID1
     * @param int $friend_id       用户ID2
     * @param int $applicant_id    发起关注的用户
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delFollow(int $uid1,int $uid2,$applicant_id){
        $user_id   = $uid1 > $uid2 ? $uid2 : $uid1;
        $friend_id = $uid1 > $uid2 ? $uid1 : $uid2;
        return Db::name('user_friends')->where('user_id',$user_id)->where('friend_id',$friend_id)->where('applicant_id',$applicant_id)->where('status',3)->update(['status'=>4]);
    }

    /**
     * 获取用户好友列表
     * @param $user_id    用户ID
     * @return mixed
     */
    public function getFriendList($user_id){
        $sql = "SELECT tmp_tab.*,user.portrait,user.nickname,user.`profile`,user.type,auth.username,auth.enterprise_name
                from (
                    SELECT friend_id AS uid, user_group AS my_group FROM wl_user_friends WHERE user_id = {$user_id} AND  status = 2  
                      UNION ALL 
                    SELECT user_id AS uid, friend_group AS my_group FROM wl_user_friends WHERE friend_id ={$user_id} AND  status = 2
                ) tmp_tab
                LEFT JOIN wl_user user on user.id = tmp_tab.uid
                LEFT JOIN wl_auth auth on auth.user_id = tmp_tab.uid";
        $rows =  Db::query($sql);

        return [
            'rows'          =>$rows,
            'page'          =>1,
            'page_total'    =>count($rows)?1:0,
            'total'         =>count($rows)
        ];
    }

    /**
     * 获取用户关注的列表
     * @param $user_id            用户ID
     * @param int $page           当前页
     * @param int $page_size      分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserFollowList($user_id,$page = 1,$page_size = 15){
        $obj = Db::name('user_friends')->alias('friends');
        $obj->leftJoin('wl_user user',"user.id = if(friends.user_id = {$user_id},friends.friend_id,friends.user_id)");
        $obj->leftJoin('wl_auth auth','user.id = auth.user_id');

        $obj->where('friends.applicant_id',$user_id);
        $obj->where('friends.status',3);
        $total = $obj->count();

        $obj->field("user.id as uid,user.portrait,user.nickname,user.profile,user.type,auth.username,auth.enterprise_name");
        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取用户粉丝列表
     * @param $user_id            用户ID
     * @param int $page           当前页
     * @param int $page_size      分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserFansList($user_id,$page = 1,$page_size = 15){
        $obj = Db::name('user_friends')->alias('friends');
        $obj->leftJoin('wl_user user',"user.id = if(friends.user_id = {$user_id},friends.friend_id,friends.user_id)");
        $obj->leftJoin('wl_auth auth','user.id = auth.user_id');

        $obj->where('friends.applicant_id','<>',$user_id);
        $obj->where('friends.status',3);
        $obj->where("friends.user_id = {$user_id} or friends.friend_id = {$user_id}");

        $total = $obj->count();
        $obj->field("user.id as uid,user.portrait,user.nickname,user.profile,user.type,auth.username,auth.enterprise_name");
        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}