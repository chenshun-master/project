<?php
namespace app\api\domain;

use think\Db;

/**
 *  站内信处理
 * @package app\api\domain
 */
class MessageDomain
{

    /**
     * 站内信推送群体消息信息
     * @param $send_id          管理员ID
     * @param $title            标题
     * @param $content          内容
     * @param $type             接收群体类型  (0:所有会员 1:普通用户;2:认证用户;3:认证医生;4:认证医院;5:官方团队)
     * @return bool
     */
    public function pushGroupMsg($send_id,$title,$content,$type){
        $insertId  = Db::name('message')->insertGetId([
            'send_id'       =>$send_id,
            'type'          =>$type,
            'title'         =>$title,
            'content'       =>$content,
            'created_time'  =>date('Y-m-d H:i:s'),
        ]);

        return $insertId ? true : false;
    }

    /**
     * 站内信推送个人信息
     * @param $send_id             管理员ID
     * @param $title               标题
     * @param $content             内容
     * @param $user_id             接收用户
     * @return bool
     */
    public function pushPrivateMsg($send_id,$title,$content,$user_id){
        Db::startTrans();
        try {
            $insertId  = Db::name('message')->insertGetId([
                'send_id'       =>$send_id,
                'type'          =>6,
                'title'         =>$title,
                'content'       =>$content,
                'created_time'  =>date('Y-m-d H:i:s'),
            ]);

            if(!$insertId){
                Db::rollback();
                return false;
            }

            $insertId2  = Db::name('message_read')->insertGetId([
                'message_id'            =>$insertId,
                'receive_user_id'       =>$user_id,
                'is_read'               =>0,
                'created_time'          =>date('Y-m-d H:i:s'),
            ]);
            if(!$insertId2){
                Db::rollback();
                return false;
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    /**
     * 站内信推送网站公告
     * @param $send_id             管理员ID
     * @param $title               标题
     * @param $content             内容
     * @return bool
     */
    public function pushNoticeMsg($send_id,$title,$content){
        $insertId  = Db::name('message')->insertGetId([
            'send_id'       =>$send_id,
            'type'          =>7,
            'title'         =>$title,
            'content'       =>$content,
            'created_time'  =>date('Y-m-d H:i:s'),
        ]);

        return $insertId ? true : false;
    }

    /**
     * 用户读取添加属于自己的站内信(异步读取)
     * @param $user_id                  用户ID
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function readMsg($user_id){
        $user_info = Db::name('user')->where('id',$user_id)->field('id,type,created_time')->find();

        $start_time = date('Y-m-d 00:00:00',strtotime('-6 day'));
        $end_time   = date('Y-m-d H:i:s');

        if(strtotime($user_info['created_time']) > strtotime($start_time)){
            $start_time = $user_info['created_time'];
        }

        $msgArr = Db::name('message')
            ->where('type','in',[0,$user_info['type']])
            ->where('id', 'NOT IN', function ($query) use($user_id) {
                $query->name('message_read')->where('receive_user_id', $user_id)->field('message_id');
            })
            ->where('created_time', 'between time', [$start_time, $end_time])
            ->column('id');

        if($msgArr){
            $data = [];
            foreach ($msgArr as $val){
                $data[] = [
                    'message_id'            =>$val,
                    'receive_user_id'       =>$user_id,
                    'is_read'               =>0,
                    'created_time'          =>date('Y-m-d H:i:s'),
                ];
            }

            if(count($data) > 0){
                Db::name('message_read')->insertAll($data);
            }
        }

        return true;
    }

    /**
     * 获取用户站内列表
     * @param $user_id               用户ID
     * @param int $page              第几页
     * @param int $page_size         分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserMailList($user_id,$page=1,$page_size=15){
        $obj = Db::name('message_read')->alias('msg_read');
        $obj->leftJoin('wl_message msg','msg_read.message_id = msg.id');
        $obj->where('msg_read.receive_user_id',$user_id);
        $obj->order('msg_read.created_time desc');

        $total = $obj->count();
        $obj->field('msg_read.message_id,msg.type,msg.title,msg.content,msg_read.is_read,msg_read.created_time');
        $rows = $obj->page($page,$page_size)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取站内公告
     * @param int $page              第几页
     * @param int $page_size         分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getNoticeMsgList($page=1,$page_size=15){
        $obj = Db::name('message')->alias('msg');
        $obj->where('msg.type',7);
        $obj->order('msg.created_time desc');

        $total = $obj->count();
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }


    /**
     * 获取消息详情
     */
    public function getMsgDetail($msg_id,$user_id){

        $res = Db::name('message')
            ->alias('msg')
            ->where('msg.id',$msg_id)
            ->find();

        if($res && $res['type'] != 7){
            Db::name('message_read')->where('message_id',$res['id'])->where('receive_user_id',$user_id)->update(['is_read'=>1]);
        }

        return $res;
    }

    /**
     * 获取用户未读消息
     * @param $user_id
     * @return array
     */
    public function getUnreadMsg($user_id){
        $sql = "SELECT count(id) as num,'chat_record' as type from wl_chat_record WHERE receive_user_id = {$user_id} and is_read = 1
                UNION all
                SELECT count(id) as num,'message_read' as type from wl_message_read WHERE receive_user_id = {$user_id} and is_read = 0";

        $data = [
            'total' =>0,
            'info'  =>[
                'chat_record'  =>0,
                'message_read' =>0
            ]
        ];

        $rows = Db::query($sql);
        if($rows && count($rows) > 0){
            foreach ($rows as $k=>$v){
                $data['total'] = $v['num'] + $data['total'];
                $data['info'][$v['type']] = $v['num'];
            }
        }

        return $data;
    }
}