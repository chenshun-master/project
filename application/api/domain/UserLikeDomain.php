<?php
namespace app\api\domain;
use think\Db;

/**
 * 用户点赞业务处理层
 * @package app\api\domain
 */
class UserLikeDomain
{




    public static function getTypeName($val){
        $config = [
            1=>'article',
            2=>'comment',
            3=>'sp_good_goods',
        ];

        return isset($config[$val]) ? $config[$val] :'';
    }

    /**
     * 用户点赞操作
     * @param int        $user_id           用户id
     * @param int        $object_id         内容原来的主键id
     * @param string     $tablename         内容以前所在表,不带前缀(article:文章点赞  ,comment:评论点赞 ,sp_good_goods:分销商品点赞)
     * @return bool      点赞结果
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function createLike($user_id,$object_id,$tablename = 'article'){
        //判断点赞记录是否存在
        $likeRes = Db::name('user_like')->where('user_id',$user_id)->where('table_name',$tablename)->where('object_id',$object_id)->field('id,table_name,object_id,status')->find();
        if($likeRes){
            if($likeRes['status'] == 2){
                Db::startTrans();
                try {
                    $isTrue = Db::name('user_like')->where('id',$likeRes['id'])->update(['status'=>0]);
                    if(!$isTrue){
                        throw new \think\Exception('异常消息');
                    }else if($likeRes['table_name'] == 'article'){
                        $res2 = Db::name('article')->where('id',$likeRes['object_id'])->inc('like',1)->update();
                        if(!$res2){
                            throw new \think\Exception('异常消息');
                        }
                    }else  if($likeRes['table_name'] == 'sp_good_goods'){
                        $res2 = Db::name('sp_good_goods')->where('id',$likeRes['object_id'])->inc('like',1)->update();
                        if(!$res2){
                            throw new \think\Exception('异常消息');
                        }
                    }else  if($likeRes['table_name'] == 'comment'){
                        $res2 = Db::name('comment')->where('id',$likeRes['object_id'])->inc('like',1)->update();
                        if(!$res2){
                            throw new \think\Exception('异常消息');
                        }
                    }

                    Db::commit();
                    return true;
                } catch (\Exception $e) {
                    Db::rollback();
                    return false;
                }
            }else{
                return false;
            }
        }

        Db::startTrans();
        try {
            $res = Db::name('user_like')->insertGetId(['user_id' => $user_id, 'table_name' => $tablename, 'object_id' => $object_id,'created_time'=>date('Y-m-d H:i:s')]);
            if($tablename == 'article'){
                Db::name('article')->where('id',$object_id)->inc('like')->update();
                if(!$res){
                    throw new \think\Exception('异常消息');
                }
            }else if($tablename == 'sp_good_goods'){
                Db::name('sp_good_goods')->where('id',$object_id)->inc('like')->update();
                if(!$res){
                    throw new \think\Exception('异常消息');
                }
            }else  if($tablename == 'comment'){
                $res2 = Db::name('comment')->where('id',$likeRes['object_id'])->inc('like_count',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
                }
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    /**
     * 用户取消点赞处理
     * @param $object_id         点赞ID
     * @param $user_id         用户ID
     * @param $tablename
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cancelLike($object_id,$user_id,$tablename){
        $likeRes = Db::name('user_like')->where('object_id',$object_id)->where('user_id',$user_id)->field('id,object_id,table_name')->find();
        if(!$likeRes || $likeRes['table_name'] !=$tablename){
            return false;
        }

        Db::startTrans();
        try {
            $res = Db::name('user_like')->where('id',$likeRes['id'])->update(['status'=>2]);
            if(!$res){
                throw new \think\Exception('异常消息');
            }else if($likeRes['table_name'] == 'article'){
                $res2 = Db::name('article')->where('id',$likeRes['object_id'])->dec('like',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
                }
            }else if($likeRes['table_name'] == 'comment'){
                $res2 = Db::name('comment')->where('id',$likeRes['object_id'])->dec('like_count',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
                }
            }else  if($likeRes['table_name'] == 'sp_good_goods'){
                $res2 = Db::name('sp_good_goods')->where('id',$likeRes['object_id'])->dec('like',1)->update();
                if(!$res2){
                    throw new \think\Exception('异常消息');
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