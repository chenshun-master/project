<?php
namespace app\api\domain;

use think\Db;
use app\api\traits\DTrait;

/**
 * 问答内容处理操作类
 * Class InquiryDomain
 * @package app\api\domain
 */
class InquiryDomain
{
    use DTrait;

    /**
     * 创建提问内容
     * @param string   $category_id   分类ID
     * @param int      $user_id       提问者ID
     * @param string   $title         问题标题
     * @param string   $describe       问题详情内容
     * @return bool
     */
    public function create($user_id,$title,$describe,$category_id=''){
        $insertId = Db::name('inquiry')->insertGetId([
            'category_id'   =>$category_id,
            'user_id'       =>$user_id,
            'title'         =>$title,
            'describe'       =>$describe,
            'created_time'  =>date('Y-m-d H:i:s'),
        ]);

        return $insertId ? true : false;
    }

    /**
     * 回答提问者问题
     * @param int    $inquiry_id   问题ID
     * @param int    $user_id      回答者用户ID
     * @param string $content      回答内容
     * @return bool
     */
    public function answer($inquiry_id,$user_id,$content){
        $insertId = Db::name('inquiry_answer')->insertGetId([
            'inquiry_id'   =>$inquiry_id,
            'user_id'       =>$user_id,
            'content'       =>$content,
            'created_time'  =>date('Y-m-d H:i:s'),
        ]);

        return $insertId ? true : false;
    }


    public function getUserInquiryNum($uid){


        if($uid == 0){
            return [
                'inquiry_num'  =>0,
                'answer_num'   =>0,
            ];
        }
        $inquiry_num = Db::table('wl_inquiry')->where('user_id',$uid)->count('id');
        $answer_num = Db::table('wl_inquiry_answer')->where('user_id',$uid)->count('id');

        return [
          'inquiry_num'  =>$inquiry_num,
          'answer_num'   =>$answer_num,
        ];
    }

    /**
     * 获取站内问答列表
     */
    public function getInquiryList($page,$page_size){
        $obj = Db::name('inquiry')->alias('inquiry');

        $field = [
            'inquiry.title',
            'inquiry.created_time'=>'ask_time',
            'user.nickname',
            'user.portrait',
            'user.type'=>'userType',
            '(select count(1) from wl_inquiry_answer a where a.inquiry_id = inquiry.id)'=>'answer_num',
        ];

        $obj->leftJoin('wl_user user','user.id = inquiry.user_id');

        $rows = $obj->field($field)->order('inquiry.created_time','desc')->page($page,$page_size)->select();
        if($rows){
            foreach ($rows as $key=>$val){
                $rows[$key]['ask_time'] = formatTime(strtotime($val['ask_time']));
            }
        }

        $total = $obj->count(1);
        return $this->packData($rows,$total,$page,$page_size);
    }

    /**
     * 获取问答详情页
     */
    public function getInquiryDetail($id){
        $obj = Db::name('inquiry')->alias('inquiry');
        $field = [
            'inquiry.id',
            'inquiry.title',
            'inquiry.describe',
            'inquiry.created_time'=>'ask_time',
            'user.nickname',
            'user.portrait',
            'user.type'=>'userType',
            '(select count(1) from wl_inquiry_answer a where a.inquiry_id = inquiry.id)'=>'answer_num',
        ];

        $obj->leftJoin('wl_user user','user.id = inquiry.user_id');
        return $obj->field($field)->find();
    }

    /**
     * 获取回答列表数据
     */
    public function getAnswerList($inquiry_id,$page=1,$page_size=15){
        $obj = Db::name('inquiry_answer')->alias('answer');

        $field = [
            'answer.id',
            'answer.content',
            'answer.created_time'=>'answer_time',
            'user.nickname',
            'user.portrait',
            'user.type'=>'userType',
        ];

        $obj->where('answer.inquiry_id',$inquiry_id);

        $obj->leftJoin('wl_user user','user.id = answer.user_id');

        $rows = $obj->field($field)->order('answer.created_time','desc')->page($page,$page_size)->select();
        if($rows){
            foreach ($rows as $key=>$val){
                $rows[$key]['answer_time'] = formatTime(strtotime($val['answer_time']));
            }
        }

        $total = $obj->count(1);
        return $this->packData($rows,$total,$page,$page_size);
    }

    /**
     * 获取问答详情信息
     */
    public function getAnswerDetail($answer_id){

    }
}