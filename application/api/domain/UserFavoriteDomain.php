<?php
namespace app\api\domain;
use think\Db;

/**
 * 用户收藏处理业务层
 * @package app\api\domain
 */
class UserFavoriteDomain
{

    public static function getTypeName($val){
        $config = [
            1=>'article',
            2=>'goods',
            3=>'sp_good_goods',
        ];

        return isset($config[$val]) ? $config[$val] :'';
    }

    /**
     * 添加用户收藏
     * @param int $user_id               用户ID
     * @param int $object_id             收藏内容原来的主键id
     * @param string $table_name         收藏实体以前所在表,不带前缀  (例如: article 文章收藏,goods 商品收藏 ,good_goods 分销商品收藏)
     * @return bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function createFavorite($user_id,$object_id,$table_name = 'article'){
        //判断收藏记录是否存在
        $favoriteRes = Db::name('user_favorite')->where('user_id',$user_id)->where('table_name',$table_name)->where('object_id',$object_id)->field('id,table_name,object_id,status')->find();
        if($favoriteRes){
            if($favoriteRes['status'] == 2){
                Db::startTrans();
                try {
                    $isTrue = Db::name('user_favorite')->where('id',$favoriteRes['id'])->update(['status'=>0]);
                    if(!$isTrue){
                        throw new \think\Exception('异常消息');
                    }

                    if($favoriteRes['table_name'] == 'article'){
                        $res2 = Db::name('article')->where('id',$favoriteRes['object_id'])->inc('favorites',1)->update();
                        if(!$res2){
                            throw new \think\Exception('异常消息');
                        }
                    }else if($favoriteRes['table_name'] == 'goods'){
                        $res2 = Db::name('sp_goods')->where('id',$favoriteRes['object_id'])->inc('favorites',1)->update();
                        if(!$res2){
                            throw new \think\Exception('异常消息');
                        }
                    }else  if($favoriteRes['table_name'] == 'sp_good_goods'){
                        $res2 = Db::name('sp_good_goods')->where('id',$favoriteRes['object_id'])->inc('favorites',1)->update();
                        if(!$res2){
                            throw new \think\Exception('异常消息');
                        }
                    }

                    Db::commit();return true;
                } catch (\Exception $e) {
                    Db::rollback();return false;
                }
            }else{
                return false;
            }
        }

        Db::startTrans();
        try {
            $res = Db::name('user_favorite')->insertGetId(['user_id' => $user_id, 'table_name' => $table_name, 'object_id' => $object_id,'created_time'=>date('Y-m-d H:i:s')]);
            if(!$res){
                throw new \think\Exception('异常消息');
            }

            if($table_name == 'article'){
                if(!Db::name('article')->where('id',$object_id)->setInc('favorites')){
                    throw new \think\Exception('异常消息');
                }
            }else if($table_name == 'goods'){
                if(!Db::name('sp_goods')->where('id',$object_id)->setInc('favorites')){
                    throw new \think\Exception('异常消息');
                }
            }else if($table_name == 'sp_good_goods'){
                if(!Db::name('sp_good_goods')->where('id',$object_id)->setInc('favorites')){
                    throw new \think\Exception('异常消息');
                }
            }

            Db::commit();return true;
        } catch (\Exception $e) {
            Db::rollback();return false;
        }
    }

    /**
     * 用户取消收藏处理
     * @param int $favorite_id       收藏ID
     * @param int $user_id           用户ID
     * @param $tablename
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cancelFavorite($object_id,$user_id,$tablename){
        $favoriteRes = Db::name('user_favorite')->where('object_id',$object_id)->where('user_id',$user_id)->where('status',0)->field('id,object_id,table_name')->find();

        if(!$favoriteRes || $favoriteRes['table_name'] !=$tablename){
            return false;
        }

        Db::startTrans();
        try {
            $res = Db::name('user_favorite')->where('id',$favoriteRes['id'])->update(['status'=>2]);
            if(!$res){
                throw new \think\Exception('异常消息');
            }

            if($favoriteRes['table_name'] == 'article'){
                $res2 = Db::name('article')->where('id',$favoriteRes['object_id'])->dec('favorites',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
                }
            }else if($favoriteRes['table_name'] == 'goods'){
                $res2 = Db::name('sp_goods')->where('id',$favoriteRes['object_id'])->dec('favorites',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
                }
            }else  if($favoriteRes['table_name'] == 'sp_good_goods'){
                $res2 = Db::name('sp_good_goods')->where('id',$favoriteRes['object_id'])->dec('favorites',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
                }
            }

            Db::commit();return true;
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    /**
     * 获取用户收藏的分销商品列表(后期添加)
     * @param $user_id
     * @param int $page
     * @param int $page_size
     */
    public function getUserFavoriteGoodGoodsList($user_id,$page=1,$page_size=15){

    }

    /**
     * 获取用户收藏文章列表
     * @param $user_id          用户id
     * @param int $page         当前分页
     * @param int $page_size    分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFavoriteArticleList($user_id,$page=1,$page_size=15){
        $obj = Db::name('user_favorite')->alias('favorite');
        $obj->where('favorite.table_name','article');


        $obj->join('wl_article article','favorite.object_id = article.id');
        $obj->leftJoin('wl_user user','article.user_id = user.id');
        $obj->leftJoin('wl_auth auth','article.user_id = auth.user_id');

        $obj->where('article.type','in',[1,2]);
        $obj->where('article.status',1);
        $obj->where('favorite.user_id',$user_id);
        $obj->order('favorite.created_time desc');


        $total = $obj->count();

        $obj->field("article.id,article.type,article.title,article.thumbnail,article.video_url,article.comment_count,article.hits,article.like,article.favorites,article.published_time,user.id as user_id,user.nickname,user.portrait,(SELECT count(1) from wl_user_like where wl_user_like.table_name ='article' AND wl_user_like.user_id ={$user_id} and wl_user_like.status=0 AND wl_user_like.object_id = article.id) as isZan,user.type as user_type,auth.username,auth.enterprise_name");
        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}