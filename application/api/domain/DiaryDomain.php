<?php
namespace app\api\domain;

use app\api\traits\DTrait;
use think\Db;

/**
 * 案例业务处理层
 * Class DiaryDomain
 * @package app\api\domain
 */
class DiaryDomain
{
    use DTrait;

    /**
     * @param $user_id
     * @param $page
     * @param $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDiaryList($user_id,$page,$page_size){
        $obj = Db::name('diary')->where('user_id',$user_id);
        $total       = $obj->count('id');

        $rows        = $obj->order('created_time','desc')->page($page,$page_size)->select();
        return $this->packData($rows,$total,$page,$page_size);
    }

    /**
     * 获取后台案例详情列表
     */
    public function getDiaryDetailList($user_id,$diary_id){
        $rows   = Db::name('diary')->alias('diary')
                ->join('wl_diary_detail detail','detail.diary_id = diary.id')
                ->where('diary.id',$diary_id)
                ->where('diary.user_id',$user_id)
                ->field('detail.*')
                ->order('day','desc')
                ->select();

        if($rows){
            foreach ($rows as $k=>$row){
                if(!empty($row['imgs'])){
                    $rows[$k]['imgs'] = json_decode($row['imgs'],true);

                    $rows[$k]['json'] = json_encode($rows[$k]);
                }
            }
        }

        $diaryInfo = Db::name('diary')->where('id',$diary_id)->where('user_id',$user_id)->find();
        if($diaryInfo){
            $diaryInfo['before_imgs'] = !empty($diaryInfo['before_imgs']) ? json_decode($diaryInfo['before_imgs'],true) : [];
            $diaryInfo['after_imgs']  = !empty($diaryInfo['after_imgs']) ? json_decode($diaryInfo['after_imgs'],true) : [];
        }

        $goodsInfo = Db::name('sp_goods')->where('id','IN',$diaryInfo['goods_ids'])->field('id,name,img,sell_price')->select();

        return $this->packData($rows,count($rows),1,0,['diaryInfo'=>$diaryInfo,'goodsInfo'=>$goodsInfo]);
    }

    /**
     * 添加案例日记
     * @param $diaryId
     * @param $user_id
     * @param $data
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function addDiaryDetail($diaryId,$user_id,$data){
        if(!Db::name('diary')->where('id',$diaryId)->where('user_id',$user_id)->value('id')){
            return [false,'案例不存在',null];
        }

        $days = Db::name('diary_detail')->where('diary_id',$diaryId)->where('user_id',$user_id)->order('day','desc')->column('day');
        if(in_array($data['day'],$days)){
            return [false,'术后时间不能重复',null];
        }

        $data['created_time'] = date('Y-m-d H:i:s');
        if(!$insertId = Db::name('diary_detail')->insertGetId($data)){
            return [false,'添加失败',null];
        }

        if($insertId && current($days) < $data['day']){
            Db::name('diary')->where('id',$diaryId)->where('user_id',$user_id)->update(['after_imgs'=>$data['imgs']]);
        }

        return [true,'添加成功',$insertId];
    }

    /**
     * 编辑案例日记
     * @param $diaryId
     * @param $diaryDetailId
     * @param $user_id
     * @param $data
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editDiaryDetail($diaryId,$diaryDetailId,$user_id,$data){
        $count = Db::name('diary_detail')->where('id',$diaryDetailId)->where('diary_id',$diaryId)->where('user_id',$user_id)->update($data);
        if($count !== false){
            $info = Db::name('diary_detail')->field('id,day')->where('diary_id',$diaryId)->where('user_id',$user_id)->order('day','desc')->find();
            if($info['id'] == $diaryDetailId){
                Db::name('diary')->where('id',$diaryId)->where('user_id',$user_id)->update(['after_imgs'=>$data['imgs']]);
            }
            return [true,'编辑成功',null];
        }

        return [false,'编辑失败',null];
    }

    /**
     * 添加案例
     * @param $data      案例数据
     * @return bool
     */
    public function addDiary($data){
        if(!$insertId = Db::name('diary')->insertGetId($data)){
            return false;
        }

        return true;
    }

    /**
     * 获取微信端列表数据
     */
    public function getListData($page,$page_size){
        $obj = Db::name('diary')->alias('diary');
        $obj->leftJoin('wl_user user','user.id = diary.user_id');
        $rows = $obj->order('diary.created_time','desc')->field([
            'diary.id,diary.title,diary.user_id,diary.before_imgs,diary.after_imgs,user.nickname,user.portrait'
        ])->page($page,$page_size)->select();


        if($rows){
            foreach ($rows as $key=>$row){
                $rows[$key]['before_imgs'] = !empty($row['before_imgs']) ?  json_decode($row['before_imgs'],true) : [];
                $rows[$key]['after_imgs']  = !empty($row['after_imgs']) ?  json_decode($row['after_imgs'],true) : [];
            }
        }

        $total       = $obj->count(1);
        return $this->packData($rows,$total,$page,$page_size);
    }

    /**
     * 获取美丽日记的相关推荐
     * @param $diaryId
     * @param $page
     * @param $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRelevantDiaryList($diaryId,$page,$page_size){
        $obj = Db::name('diary')->alias('diary');
        $obj->leftJoin('wl_user user','user.id = diary.user_id');
        if($ids = Db::name('diary')->where('id',$diaryId)->value('goods_ids')){
            $ids = explode(',',$ids);
            foreach ($ids as $k=>$goods_id){
                if($k <= 1){
                    $obj->whereOrRaw("FIND_IN_SET({$goods_id},diary.goods_ids)");
                }
            }
        }

        $rows = $obj->order('diary.created_time','desc')->field([
            'diary.id,diary.title,diary.user_id,diary.before_imgs,diary.after_imgs,user.nickname,user.portrait'
        ])->page($page,$page_size)->select();

        if($rows){
            foreach ($rows as $key=>$row){
                $rows[$key]['before_imgs'] = !empty($row['before_imgs']) ?  json_decode($row['before_imgs'],true) : [];
                $rows[$key]['after_imgs']  = !empty($row['after_imgs']) ?  json_decode($row['after_imgs'],true) : [];
            }
        }

        $total       = $obj->count(1);
        return $this->packData($rows,$total,$page,$page_size);
    }

    /**
     * 获取日记信息
     */
    public function getDiaryInfo($diaryId,$user_id =0){
        $data = [
            'info'=>[],
            'goods_infos'=>[],
            'diaryList'=>[],
            'commentList'=>[],
        ];

        $data['info'] = Db::name('diary')->alias('diary')
            ->leftJoin('wl_user user','user.id = diary.user_id')
            ->leftJoin('wl_user_like like',"like.object_id = diary.id and like.table_name = 'diary' and like.user_id = {$user_id} and like.status = 0")
            ->where('diary.id',$diaryId)
            ->field('diary.id,diary.user_id,diary.goods_ids,diary.before_imgs,diary.after_imgs,diary.like,user.nickname,user.portrait,IF(like.id > 0,1,0) as isZan')
            ->find();

        if($data['info']){
            $data['info']['comment'] = Db::name('comment')->where('table_name','diary')->where('object_id',$diaryId)->count('id');
            $data['info']['before_imgs'] = !empty($data['info']['before_imgs']) ?  json_decode($data['info']['before_imgs'],true) : [];
            $data['info']['after_imgs']  = !empty($data['info']['after_imgs']) ?  json_decode($data['info']['after_imgs'],true) : [];

            $data['goods_infos'] = Db::name('sp_goods')->where('id','in',$data['info']['goods_ids'])->field(['id','name','sell_price','img'])->select();
            $data['diaryList'] = Db::name('diary_detail')->where('diary_id',$diaryId)->order('day','desc')->select();
            if($data['diaryList']){
                foreach ($data['diaryList'] as $key=>$row){
                    $data['diaryList'][$key]['imgs'] = !empty($row['imgs']) ?  json_decode($row['imgs'],true) : [];
                }
            }

            $data['commentList'] = $this->getDiaryCommentList($diaryId,$user_id,1,5)['rows'];
        }

        return $data;
    }

    public function getDiaryDetail($diaryId,$diaryDetailId){
        $data = [
            'info'=>[],
            'goods_infos'=>[],
            'diaryDetail'=>[],
            'commentList'=>[],
        ];

        $data['info'] = Db::name('diary')->alias('diary')
            ->leftJoin('wl_user user','user.id = diary.user_id')
            ->where('diary.id',$diaryId)
            ->field('diary.id,diary.user_id,diary.goods_ids,diary.before_imgs,diary.after_imgs,user.nickname,user.portrait')
            ->find();

        if($data['info']){
            $data['info']['before_imgs'] = !empty($data['info']['before_imgs']) ?  json_decode($data['info']['before_imgs'],true) : [];
            $data['info']['after_imgs']  = !empty($data['info']['after_imgs']) ?  json_decode($data['info']['after_imgs'],true) : [];

            $data['goods_infos'] = Db::name('sp_goods')->where('id','in',$data['info']['goods_ids'])->field(['id','name','sell_price','img'])->select();

            $data['diaryDetail'] = Db::name('diary_detail')->where('id',$diaryDetailId)->find();
            if($data['diaryDetail']){
                $data['diaryDetail']['imgs'] = !empty($data['diaryDetail']['imgs']) ?  json_decode($data['diaryDetail']['imgs'],true) : [];
            }

            $data['commentList'] = Db::name('comment')->where('table_name','diary_detail')->where('parent_id',0)->where('object_id',$diaryId)->limit(5)->select();
        }

        return $data;
    }

    /**
     * 更新日记阅读量
     * @param $id
     * @throws \think\Exception
     */
    public function updateDiaryVisit($id){
        Db::name('diary')->where('id',$id)->setInc('visit');
    }

    public function getDiaryCommentList($diaryId,$user_id=0,$page=1,$page_size=15){
        $field = [
            'comment.id','comment.user_id','comment.like_count','comment.content','comment.created_time','user.nickname',
            'user.portrait',
            'IF(like.id > 0,1,0)'=>'islike',
        ];

        $obj = Db::name('comment')->alias('comment');
        $obj->leftJoin('wl_user user','comment.user_id = user.id');
        $obj->leftJoin('wl_user_like like',"like.object_id = comment.id and like.table_name = 'diary' and like.user_id = {$user_id} and like.status = 0");
        $obj->where('comment.object_id',$diaryId);
        $obj->where('comment.table_name','diary');
        $obj->order('comment.created_time', 'desc');

        $total = $obj->count();
        $rows = $obj->field($field)->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}