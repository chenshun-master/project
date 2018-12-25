<?php
namespace app\api\domain;

use think\Db;
use app\api\model\CommentModel;

/**
 * 评论管理处理类
 * @package app\api\domain
 */
class CommentDomain
{

    /**
     * 创建评论
     * @param $data        待添加数据
     * @param string $tablename    评论所对应的表名
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function createComment($data,$tablename ='article'){
        $data['like_count']         = 0;
        $data['status']             = 1;
        $data['created_time']       = date('Y-m-d H:i:s');
        $data['table_name']         = $tablename;

        if($data['parent_id'] !== 0){
            $commentModel = new CommentModel();
            $commentRes = $commentModel->findId($data['parent_id']);
            if(!$commentRes || $commentRes['object_id'] != $data['object_id'] || $data['table_name'] != $commentRes['table_name']){
                return false;
            }
        }

        Db::startTrans();
        try {
            $id = Db::name('comment')->insertGetId($data);
            if(!$id){
                throw new \think\Exception('插入评论信息失败');
            }

            $path = ($data['parent_id'] == 0) ? ",{$id}," : "{$commentRes['path']}{$id}," ;

            $res1 = Db::name('comment')->where('id',$id)->update(['path'=>$path]);
            if(!$res1){
                throw new \think\Exception('更新评论信息失败');
            }

            if($tablename == 'article'){
                $res4 = Db::name('article')->where('id',$data['object_id'])->inc('comment_count')->update();
                if(!$res4){
                    throw new \think\Exception('更新评论数量失败');
                }
            }else if($tablename == 'sp_good_goods'){
                $res4 = Db::name('sp_good_goods')->where('id',$data['object_id'])->inc('comment')->update();
                if(!$res4){
                    throw new \think\Exception('更新评论数量失败');
                }
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }
}