<?php
namespace app\api\model;
use think\Model;

class ArticleModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'wl_article';


    private $status = [
        0=>'未发布',
        1=>'已发布',
        2=>'文章草稿'
    ];

    /**
     * 查询文章草稿
     * @param $user_id      用户ID
     * @param $type         文章类型
     * @return mixed
     */
    public static function findArticleDraft($user_id,$type){
        return (int)self::where('type',$type)->where('user_id',$user_id)->where('status',2)->value('id');
    }



    /**
     * 获取文章数据
     * @param $user_id           用户ID
     * @param $article_id        文章ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function findArticleDetail($user_id,$article_id){
        $info = self::where('id',$article_id)->where('user_id',$user_id)->find();
        return $info ?:[];
    }
}