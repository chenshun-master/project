<?php
namespace app\api\model;
use think\Model;

class InquiryModel extends Model
{

    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_inquiry';

    public function answers()
    {
        return $this->hasMany('AnswerModel','inquiry_id');
    }


    public static  function inquiryInfo($id){
        $info = InquiryModel::get($id);
        if($info){
            $info['answer_num'] = $info->answers()->fetchSql(false)->count('id');
        }

        return $info?:[];
    }

    public static function census($uid){
        $inquiry_info = self::where('user_id',$uid)->field([
            'count(id)'      =>'inquiry_num',
            'sum(visit)'     =>"inquiry_visit_num",
        ])->find();

        $answer_info = AnswerModel::where('user_id',$uid)->field([
            'count(id)'      =>'answer_num',
            'sum(visit)'     =>"answer_visit_num",
        ])->find();

        return [
            'inquiry_num'       =>$inquiry_info?(int)$inquiry_info['inquiry_num']:0,
            'inquiry_visit_num' =>$inquiry_info?(int)$inquiry_info['inquiry_visit_num']:0,
            'answer_num'        =>$answer_info?(int)$answer_info['answer_num']:0,
            'answer_visit_num'  =>$answer_info?(int)$answer_info['answer_visit_num']:0,
        ];
    }
}