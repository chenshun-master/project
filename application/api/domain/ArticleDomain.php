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
        if(isset($data['thumbnail']) && count($data['thumbnail']) > 0){
            $data['thumbnail'] = handleThumbnailData($data['thumbnail']);
        }

        $data['status']             = 1;
        $data['comment_status']     = 1;
        $data['updated_time'] = $data['created_time'] = $data['published_time'] = date('Y-m-d H:i:s');

        $res = ArticleModel::create($data);

        #处理其它业务逻辑(后期的等级积分处理)

        return $res ? true : false;
    }

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
            if(!$commentRes || $commentRes['object_id'] != $data['object_id'] || $data['table_name'] != $commentRes['table_name']){
                return false;
            }
        }

        Db::startTrans();
        try {
            $id = Db::name('comment')->insertGetId($data);
            if(!$id){
                return false;
            }

            $path = ($data['parent_id'] == 0) ? ",{$id}," : "{$commentRes['path']}{$id}," ;

            $res1 = Db::name('comment')->where('id',$id)->update(['path'=>$path]);
            if(!$res1){
                Db::rollback();return false;
            }

            if($tablename == 'article'){
                $res4 = Db::name('article')->where('id',$data['object_id'])->inc('comment_count')->update();
                if(!$res4){
                    Db::rollback();return false;
                }
            }
            Db::commit();return true;
        } catch (\Exception $e) {
            Db::rollback();return false;
        }
    }


    /**
     * @param $id
     * @param int $user_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArticleInfo($id,$user_id=0){
        $data = ['article_info'=>[]];

        $obj = Db::name('article')->alias('article');
        $obj->where('article.id',$id);
        $obj->join('wl_user user','article.user_id = user.id');

        if($user_id > 0){
            $obj->field("article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='article' AND wl_user_like.user_id ={$user_id} AND wl_user_like.object_id = article.id) as isZan,(SELECT count(1) from wl_user_favorite where wl_user_favorite.table_name ='article' AND wl_user_favorite.user_id ={$user_id} AND wl_user_favorite.object_id = article.id) as isFavorites");
        }else{
            $obj->field("article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,0 as isZan,0 as isFavorites");
        }

        $articleRes = $obj->find();
        if($articleRes){
            $data['article_info'] = $articleRes;
            Db::name('article')->where('id',$id)->inc('hits');
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
            if($flag == 1){return false;}
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
        $obj->order('article.is_top', 'desc');
        $obj->order('article.published_time', 'desc');
        $obj->leftJoin('wl_user user','article.user_id = user.id');
        $total = $obj->count();


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
        if(!$articleRes || $articleRes['tag'] ==''){
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
                'page_total'    =>(int)getPageTotal($count[0]['total'],$page_size),
                'total'         =>$count[0]['total']
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
     * @param bool $flag            是否是用户中心调用
     * @param int $uid            是否是用户中心调用
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserPublishArticle($user_id,$type,$page,$page_size,$flag = false,$uid=0){
        $obj = Db::table('wl_article')->alias('article');

        if($type != 0){
            $obj->where('article.type', $type);
        }

        $obj->where('article.user_id', $user_id);

        if(!$flag){
            $obj->where('article.status', 1);
            $obj->where('article.published_time', '<= time', date('Y-m-d H:i:s'));
        }

        $obj->order('article.published_time', 'desc');


        $obj->join('wl_user user','article.user_id = user.id');
        $total = $obj->count();

        if($uid){
            $obj->field("article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='article' AND wl_user_like.user_id ={$uid} AND wl_user_like.object_id = article.id) as isZan");
        }else{
            $obj->field("article.*,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,'0' as isZan");
        }


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
     * 判断文章是否点赞过
     * @param $user_id         用户ID
     * @param $article_id      文章ID
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkFabulous($user_id,$article_id){
        $res = Db::name('user_like')
            ->where('user_id',$user_id)
            ->where('object_id',$article_id)
            ->where('table_name','article')
            ->field(['id'])
            ->find();

        return $res ? true :false;
    }


    /**
     * 获取一级评论列表
     */
    public function getFirstComment($article_id,$page,$page_size,$user_id=0){
        $obj = Db::name('comment');
        $obj->alias('comment');
        $obj->where('comment.object_id',$article_id);
        $obj->where('comment.parent_id',0);
        $obj->where('comment.table_name','article');
        $obj->leftJoin('wl_user user','comment.user_id = user.id');
        $obj->order('comment.created_time', 'desc');
        $total = $obj->count();

        if($user_id == 0){
            $obj->field("comment.id,comment.user_id,comment.object_id,comment.like_count,comment.content,comment.created_time,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,'0' as isZan,(SELECT count(1) from wl_comment where path like CONCAT(comment.path,'%') and wl_comment.id <> comment.id) AS reply_count");
        }else{
            $obj->field("comment.id,comment.user_id,comment.object_id,comment.like_count,comment.content,comment.created_time,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='comment' AND wl_user_like.user_id ={$user_id} AND wl_user_like.object_id = comment.id) as isZan,(SELECT count(1) from wl_comment where path like CONCAT(comment.path,'%') and wl_comment.id <> comment.id) AS reply_count");
        }

        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取二级以上评论
     */
    public function getSecondComment($object_id,$comment_id,$page,$page_size,$user_id=0){
        $obj = Db::name('comment');
        $obj->alias('comment');
        $obj->where('comment.object_id',$object_id);
        $obj->where('comment.parent_id','>',0);
        $obj->where('comment.table_name','article');
        $obj->where('comment.path','like',",{$comment_id},%");
        $obj->leftJoin('wl_user user','comment.user_id = user.id');
        $obj->order('comment.created_time', 'desc');
        $total = $obj->count();
        if($user_id == 0){
            $obj->field("comment.id,comment.path,comment.user_id,comment.object_id,comment.parent_id,comment.like_count,comment.content,comment.created_time,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,'0' as isZan");
        }else{
            $obj->field("comment.id,comment.path,comment.user_id,comment.object_id,comment.parent_id,comment.like_count,comment.content,comment.created_time,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='comment' AND wl_user_like.user_id ={$user_id} AND wl_user_like.object_id = comment.id) as isZan");
        }

        $rows = $obj->page($page,$page_size)->select();

        if($rows){
            //获取子评论
            $ids = [];
            foreach($rows as $val){
                $ids[]  = $val['parent_id'];
            }

            $rows2 = Db::table('wl_comment')
                ->where('wl_comment.id', 'in', $ids)
                ->leftJoin('wl_user user','wl_comment.user_id = user.id')
                ->column("wl_comment.id,wl_comment.content,wl_comment.created_time,user.portrait,user.nickname,user.mobile",'wl_comment.id');

            foreach($rows as $_key => $_val){
                $rows[$_key]['parent'] = $rows2[$_val['parent_id']];
                if(!empty($rows[$_key]['parent']['mobile'])){
                    $rows[$_key]['parent']['mobile'] = mobileFilter($rows[$_key]['parent']['mobile']);
                }
            }
        }

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
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

        $obj->where('article.type', 'in', [1,2]);
        $obj->where('article.status',1);

        $obj->leftJoin('wl_user user','article.user_id = user.id');
        $total = $obj->count();
        $obj->field("article.*,user.id as user_id,user.nickname,user.portrait,INSERT(user.mobile,4,4,'****') as mobile,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='article' AND wl_user_like.user_id ={$user_id} AND wl_user_like.object_id = article.id) as isZan");

        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取用户评论过的文章
     * @param $user_id          用户id
     * @param int $page         当前分页
     * @param int $page_size    分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCommentArticle($user_id,$page=1,$page_size=15){
        $obj = Db::name('comment')->alias('comment');
        $obj->where('comment.user_id',$user_id);

        $obj->leftJoin('wl_article article','comment.object_id = article.id');
        $obj->leftJoin('wl_user user','article.user_id = user.id');
        $obj->leftJoin('wl_comment comment2','comment2.id = comment.parent_id');
        $obj->leftJoin('wl_user user2','comment2.user_id = user2.id');

        $obj->where('article.type','in',[1,2]);
        $obj->where('article.status',1);

        $obj->group('comment.object_id');
        $obj->order('comment.created_time desc');

        $total = $obj->count();
        $obj->field("article.id,article.type,article.title,article.like,article.video_url,article.comment_count,article.favorites,article.published_time,article.thumbnail,user.id as user_id,user.nickname,user.portrait,comment.content as comment_content,user2.nickname as huifu_nickname,user2.id as huifu_user_id,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='article' AND wl_user_like.user_id ={$user_id} AND wl_user_like.object_id = article.id) as isZan");

        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取用户收藏文章
     * @param $user_id          用户id
     * @param int $page         当前分页
     * @param int $page_size    分页大小
     */
    public function getFavoriteArticle($user_id,$page=1,$page_size=15){
        $obj = Db::name('user_favorite')->alias('favorite');
        $obj->where('table_name','article');


        $obj->join('wl_article article','favorite.object_id = article.id');
        $obj->leftJoin('wl_user user','article.user_id = user.id');


        $obj->where('article.type','in',[1,2]);
        $obj->where('article.status',1);

        $obj->order('favorite.created_time desc');


        $total = $obj->count();

        $obj->field("article.id,article.type,article.title,article.thumbnail,article.video_url,article.comment_count,article.hits,article.like,article.favorites,article.published_time,user.id as user_id,user.nickname,user.portrait,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='article' AND wl_user_like.user_id ={$user_id} AND wl_user_like.object_id = article.id) as isZan");
        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}