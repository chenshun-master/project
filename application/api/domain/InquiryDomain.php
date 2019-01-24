<?php
namespace app\api\domain;

use think\Db;
use app\api\model\AnswerModel;
use app\api\traits\DTrait;

use app\api\model\CommentModel;

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
            'visit'         =>mt_rand(1,20),
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

        if(Db::name('inquiry_answer')->where('inquiry_id',$inquiry_id)->where('user_id',$user_id)->value('id')){
            return [false,'不能重复回答问题'];
        }

        $insertId = Db::name('inquiry_answer')->insertGetId([
            'inquiry_id'   =>$inquiry_id,
            'user_id'       =>$user_id,
            'content'       =>$content,
            'created_time'  =>date('Y-m-d H:i:s'),
        ]);

        if($insertId){
            return [true,'发表问答成功...'];
        }

        return [false,'发表问答失败...'];
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
            'inquiry.id',
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
            'inquiry.visit',
            'inquiry.created_time'=>'ask_time',
            'user.nickname',
            'user.portrait',
            'user.type'=>'userType',
            '(select count(1) from wl_inquiry_answer a where a.inquiry_id = inquiry.id)'=>'answer_num',
        ];
        $obj->where('inquiry.id',$id);
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
            'auth.duties'
        ];

        $obj->where('answer.inquiry_id',$inquiry_id);

        $obj->leftJoin('wl_user user','user.id = answer.user_id');
        $obj->leftJoin('wl_auth auth','user.id = auth.user_id');

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
     * 获取用户发布的提问列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserInquiryList($uid,$page=1,$page_size=15){
        $obj = Db::name('inquiry')->alias('inquiry')->where('inquiry.user_id',$uid);

        $field = [
            'inquiry.id',
            'inquiry.user_id',
            'inquiry.title',
            'inquiry.visit',
            'inquiry.created_time'=>'ask_time',
            '(select count(1) from wl_inquiry_answer a where a.inquiry_id = inquiry.id)'=>'answer_num',
        ];

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
     * 获取用户回答列表数据
     */
    public function getUserAnswerList($uid,$page=1,$page_size=15){
        $field = [
            'answer.id',
            'inquiry.title',
            'answer.content',
            'answer.visit',
            'answer.created_time'=>'answer_time',
        ];

        $obj = Db::name('inquiry_answer')->alias('answer')->where('answer.user_id',$uid);
        $obj->leftJoin('wl_inquiry inquiry','inquiry.id = answer.inquiry_id');
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
    public function getAnswerDetail(int $answer_id){
        $field = [
            'answer.id'             =>'answer_id',
            'answer.inquiry_id',
            'answer.visit',
            'answer.content'        =>'answer_content',
            'answer.created_time'   =>'answer_time',
            'inquiry.title'         =>'title',
            'user.nickname',
            'user.type'             =>'user_type',
            'user.portrait',
            '(select count(id) from wl_inquiry_answer where inquiry_id = answer.inquiry_id )'=>'answer_num',
        ];

        $row = Db::name('inquiry_answer')->alias('answer')
            ->leftJoin('wl_inquiry inquiry','inquiry.id = answer.inquiry_id')
            ->leftJoin('wl_user user','user.id = answer.user_id')
            ->where('answer.id',$answer_id)
            ->field($field)->find();


        if($row){
            Db::name('inquiry_answer')->where('id',$answer_id)->setInc('visit');
            $row['comment_num'] = (int)CommentModel::getCommentNum($answer_id,'inquiry_answer');
        }

        return $row?:[];
    }
}