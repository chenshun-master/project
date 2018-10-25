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
     * 发布文章
     * @param $data  待添加数据
     * @return bool
     */
    public function createArticle($data){
        if(isset($data['thumbnailImg']) && count($data['thumbnailImg']) > 0){
            $data['thumbnailImg'] = handleThumbnailData($data['thumbnailImg']);
        }

        $data['status'] = 1;
        $date['comment_status'] = 1;

        $res = ArticleModel::create($data);

        #处理其它业务逻辑(后期的等级积分处理)

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

    /**
     * 添加文章评论
     * @param $data        待添加数据
     * @param string $tablename    评论所对应的表名
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function createComment($data,$tablename='article'){
        $data['floor']              = 1;
        $data['like_count']         = 0;
        $data['status']             = 1;
        $data['table_name']         = $tablename;

        if($tablename == 'article'){
            $res = Db::name('article')->where('id',$data['object_id'])->field(['id','comment_status'])->find();
            if(!$res || $res['comment_status'] != 1){
                return false;
            }
        }

        if($data['parent_id'] !== 0){
            $commentModel = new CommentModel();
            $commentRes = $commentModel->findId($data['parent_id']);
            if(!$commentRes || $commentRes['object_id'] != $data['object_id'] || $data['table_name'] != $commentRes['table_name'] || $commentRes['user_id'] == $data['user_id']){
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

            if($tablename == 'article'){
                $res4 = Db::name('article')->where('id',$data['object_id'])->inc('comment_count')->update();
                if(!$res4){
                    Db::rollback();
                }
            }
            Db::commit();return true;
        } catch (\Exception $e) {
            Db::rollback();return false;
        }
    }

    /**
     * 获取手机端文章详情页
     * @param $id      文章id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getArticleInfo($id){
        $data = ['article_info'=>[],'comment_infos'=>[]];

        $articleRes = Db::name('article')
            ->alias('article')
            ->where('article.id',$id)
            ->join('wl_user user','article.user_id = user.id')
            ->field('article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,\'****\') as mobile')
            ->find();

        if($articleRes){
            $data['article_info'] = $articleRes;
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
     * @param int        $user_id           用户id
     * @param int        $object_id         内容原来的主键id
     * @param int        $flag              点赞类型    1:点赞    2:取消点赞
     * @param string     $tablename         内容以前所在表,不带前缀(article:文章点赞  ,comment:评论点赞)
     * @return bool      点赞结果
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addFabulous($user_id,$object_id,$flag,$tablename = 'article'){
        $res = Db::name('user_like')
            ->where('user_id',$user_id)
            ->where('object_id',$object_id)
            ->where('table_name',$tablename)
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

                if($tablename == 'article'){
                    $res2 = Db::name('article')->where('id',$object_id)->dec('like',1)->update();
                    if(!$res2){
                        Db::rollback();return false;
                    }
                }else if($tablename == 'comment'){
                    $res2 = Db::name('comment')->where('id',$object_id)->dec('like_count',1)->update();
                    if(!$res2){
                        Db::rollback();return false;
                    }
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
                    'user_id'               =>$user_id,
                    'object_id'             =>$object_id,
                    'table_name'            =>$tablename,
                    'created_time'          =>date('Y-m-d H:i:s')
                ]);
                if(!$res3){
                    Db::rollback();return false;
                }

                if($tablename == 'article'){
                    $res4 = Db::name('article')->where('id',$object_id)->inc('like')->update();
                    if(!$res4){
                        Db::rollback();return false;
                    }
                }else if($tablename == 'comment'){
                    $res4 = Db::name('comment')->where('id',$object_id)->inc('like_count')->update();
                    if(!$res4){
                        Db::rollback();return false;
                    }
                }
                Db::commit();return true;
            } catch (\Exception $e) {
                Db::rollback();return false;
            }
        }
    }

    /**
     * 获取微信端主页列表数据
     * @param int $page              第几页
     * @param int $page_size         分页大小
     * @param int $type              获取数据类型
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHomeList($page,$page_size,$type){
        $obj = Db::table('wl_article')->alias('article');

        if($type != 0){
            $obj->where('article.type', $type);
        }

        $obj->where('article.status', 1);
        $obj->where('article.published_time', '<= time', date('Y-m-d H:i:s'));
        $obj->order('article.published_time', 'desc');
        $total = $obj->count();

        $obj->join('wl_user user','article.user_id = user.id');
        $obj->field('article.*,user.nickname,INSERT(user.mobile,4,4,\'****\') as mobile');

        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取相关文章                    文章id
     * @param int $id
     * @param int $page              第几页
     * @param int $page_size         分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getRelevantList($id,$page,$page_size){
        $data = [
            'rows'          =>[],
            'page'          =>1,
            'page_total'    =>0,
            'total'         =>0
        ];

        $articleRes = Db::name('article')->where('id',$id)->field('tag,type')->find();
        if(!$articleRes){
            return $data;
        }

        $date = date('Y-m-d H:i:s');
        $arr = explode(',',$articleRes['tag']);
        $sql = "SELECT `article`.`id`,`article`.`user_id`,`article`.`title`,`article`.`type`,`article`.`excerpt`,`article`.`thumbnail`,`article`.`is_top`,`article`.`recommended`,`article`.`hits`,`article`.`favorites`,`article`.`like`,`article`.`comment_count`,`article`.`published_time`,`user`.`nickname`,`user`.`mobile` FROM `wl_article` `article` left JOIN `wl_user` `user` ON `article`.`user_id`=`user`.`id` WHERE article.id !={$id} AND article.status =1 AND article.type={$articleRes['type']} AND article.published_time <= '{$date}' AND ";
        $total_sql = "SELECT count(1) as total FROM `wl_article` `article` left JOIN `wl_user` `user` ON `article`.`user_id`=`user`.`id` WHERE article.id !={$id} AND article.status =1 AND article.type={$articleRes['type']} AND article.published_time <= '{$date}' AND ";

        $like_sql = '';
        foreach ($arr as $val){
            if(!empty($val)){
                $like_sql .= "OR `article`.`tag` LIKE '%{$val}%' ";
            }
        }
        $sql .= ' ( '.ltrim($like_sql,'OR').' ) ';
        $total_sql .= ' ( '.ltrim($like_sql,'OR').' ) ';

        $count = Db::query($total_sql.' limit 1');
        if(isset($count) && $count[0]['total'] > 0){
            $page_info = getPagingInfo($count[0]['total'],$page,$page_size);
            $rows = Db::query($sql.' order by article.published_time desc '.$page_info['limit']);
            return [
                'rows'          =>$rows,
                'page'          =>$page,
                'page_total'    =>getPageTotal($count[0]['total'],$page_size),
                'total'         =>$count[0]
            ];
        }
        return $data;
    }

    /**
     * 获取指定用户发布文章
     * @param $user_id         用户ID
     * @param $type            获取文章类型
     * @param $page            获取第几页数据
     * @param $page_size       分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserPublishArticle($user_id,$type,$page,$page_size){
        $obj = Db::table('wl_article')->alias('article');

        if($type != 0){
            $obj->where('article.type', $type);
        }

        $obj->where('article.user_id', $user_id);
        $obj->where('article.status', 1);
        $obj->where('article.published_time', '<= time', date('Y-m-d H:i:s'));
        $obj->order('article.published_time', 'desc');
        $total = $obj->count();

        $obj->join('wl_user user','article.user_id = user.id');
        $obj->field('article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,\'****\') as mobile');

        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取指定用用户的文章统计数据
     * @param $user_id       用户id
     * @return mixed
     */
    public function getArticleStatisticsData($user_id){
        $date = date('Y-m-d H:i:s');
        $sql = "SELECT type,count(1) as total from wl_article where user_id = {$user_id} AND  status=1 and published_time <='{$date}'  GROUP BY type";
        return Db::query($sql);
    }

    /**
     * 获取指定用户点赞过的相关文章列表
     * @param $user_id         用户id
     * @param $page            获取第几页数据
     * @param $page_size       分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticleLikeData($user_id,$page,$page_size){
        $obj = Db::table('wl_article')->alias('article');
        $obj->where('article.status', 1);
        $obj->where('article.published_time', '<= time', date('Y-m-d H:i:s'));
        $obj->order('article.published_time', 'desc');
        $obj->where('article.id', 'IN', function ($query) use ($user_id)  {
            $query->table('wl_user_like')->where('user_id', $user_id)->where('table_name','article')->field('object_id');
        });
        $obj->where('article.type', 'in', [1,2,3]);

        $total = $obj->count();

        $obj->join('wl_user user','article.user_id = user.id');
        $obj->field('article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,\'****\') as mobile');

        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

}