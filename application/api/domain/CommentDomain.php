<?php
namespace app\api\domain;

use think\Db;
use app\api\model\CommentModel;
use app\api\traits\DTrait;

/**
 * 评论管理处理类
 * @package app\api\domain
 */
class CommentDomain
{
    use DTrait;

    private $tableName = [
        'article',
        'sp_good_goods',
        'diary',
        'inquiry_answer'
    ];

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

            Db::commit();return true;
        } catch (\Exception $e) {
            Db::rollback();return false;
        }
    }

    /**
     * 获取评论列表
     * @param $table_name       评论内容所在表，不带表前缀
     * @param $object_id        评论ID,评论内容所在表的主键ID
     * @param int $user_id      获取数据列表的用户ID
     * @param int $page         当前分页
     * @param int $page_size    分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCommentList($table_name,$object_id,$user_id=0,$page=1,$page_size=15){
        if(!in_array($table_name,$this->tableName)){
            return $this->packData([],0,$page,$page_size);
        }

        $field = [
            'comment.id','comment.user_id','comment.like_count','comment.content','comment.created_time','user.nickname','user.portrait','IF(like.id > 0,1,0)'=>'islike',
        ];

        $obj = Db::name('comment')->alias('comment');
        $obj->leftJoin('wl_user user','comment.user_id = user.id');
        $obj->leftJoin('wl_user_like like',"like.object_id = comment.id and like.table_name = 'comment' and like.user_id = {$user_id} and like.status = 0");
        $obj->where('comment.object_id',$object_id);
        $obj->where('comment.table_name',$table_name);
        $obj->order('comment.created_time', 'desc');

        $rows = $obj->field($field)->page($page,$page_size)->fetchSql(false)->select();
        return $this->packData($rows,$obj->count(1),$page,$page_size);
    }
}