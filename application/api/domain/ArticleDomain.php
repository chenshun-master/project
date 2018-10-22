<?php
namespace app\api\domain;

use app\api\model\ArticleModel;
use app\api\model\CommentModel;
use think\Db;

/**
 * 文章业务处理层
 * Class ArticleDomain
 * @package app\api\domain
 */
class ArticleDomain
{
    /**
     * 添加文章
     * @param $data  待添加数据
     * @return bool
     */
    public function create($data){
        $res = ArticleModel::create($data);

        return $res ? true : false;
    }

    /**
     * 添加文章评论
     * @param $data    待添加数据
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function createComment($data){
        $data['floor']              = 1;
        $data['like_count']         = 0;
        $data['status']             = 1;

        $res = Db::name('article')->where('id',$data['object_id'])->field(['id','comment_status'])->find();
        if(!$res || $res['comment_status'] != 1){
            return false;
        }

        if($data['parent_id'] !== 0){
            $commentModel = new CommentModel();
            $commentRes = $commentModel->findId($data['parent_id']);
            if(!$commentRes || $commentRes['object_id'] != $data['object_id'] || $commentRes['user_id'] == $data['user_id']){
                return false;
            }

            $data['floor'] = $commentRes['floor'] + 1;
        }

        Db::startTrans();
        try {
            $res3 = Db::name('comment')->insert($data);
            if(!$res3){
                return false;
            }

            $res4 = Db::name('article')->where('id',$data['object_id'])->inc('comment_count')->update();
            if(!$res4){
                Db::rollback();
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }

    /**
     * 根据文章id获取文章详细信息
     * @param $id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getArticleInfo($id){
        $data = [
            'info'=>[],
            'comment_infos'=>[]
        ];

        $articleRes = Db::name('article')->where('id',$id)->find();
        if($articleRes){
            $data['info'] = $articleRes;
            Db::name('article')->where('id',$id)->inc('hits')->update();

            $commentRes = Db::name('comment')->where('object_id',$id)->order('created_time', 'asc')->column('*','id');

            $array = [];
            foreach ($commentRes as $k => $val){
                $tmp_array = $val;
                $tmp_array['parent_info'] = isset($commentRes[$val['parent_id']]) ? $commentRes[$val['parent_id']] :[];

                $array[] = $tmp_array;
            }

            $data['comment_infos'] = $array;
        }

        return $data;
    }

    /**
     * 用户点赞操作
     * @param $user_id         用户id
     * @param $object_id       内容原来的主键id
     * @param $type            点赞来源及类型  1:文章  2:案例 3:视频
     * @param $flag            1:点赞  2:取消点赞
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addFabulous($user_id,$object_id,$type,$flag){
        $res = Db::name('user_like')
            ->where('user_id',$user_id)
            ->where('type',$type)
            ->where('object_id',$object_id)
            ->field(['id'])
            ->find();

        if($res){
            if($flag == 1){return true;}
            Db::startTrans();
            try {
                $res1 = Db::name('user_like')->where('id',$res['id'])->delete();
                if(!$res1){
                    Db::rollback();return false;
                }
                $res2 = Db::name('article')->where('id',$object_id)->dec('like',1)->update();
                if(!$res2){
                    Db::rollback();return false;
                }
                Db::commit();return true;
            } catch (\Exception $e) {
                Db::rollback();return false;
            }
        }else{
            if($flag == 2){return false;}
            Db::startTrans();
            try {
                $res3 = Db::name('user_like')->insert([
                    'user_id'      =>$user_id,
                    'object_id'    =>$object_id,
                    'type'         =>$type,
                    'created_time' =>date('Y-m-d H:i:s')
                ]);

                if(!$res3){
                    Db::rollback();return false;
                }

                $res4 = Db::name('article')->where('id',$object_id)->inc('like')->update();
                if(!$res4){
                    Db::rollback();return false;
                }
                Db::commit();return true;
            } catch (\Exception $e) {
                Db::rollback();return false;
            }
        }
    }

    /**
     * 获取文章列表
     * @param $page                  第几页
     * @param $page_size             分页大小
     * @param string $search         搜索关键词
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticleList($page,$page_size,$search=''){
        $obj = Db::name('article');
        if(!empty($search)){
            $obj->where('title|tag','like',"%{$search}%");
        }

        $total = $obj->count();
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}