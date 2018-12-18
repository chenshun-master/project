<?php
namespace app\api\domain;
use think\Db;
use app\api\model\SpGoodsModel;

class SpGoodGoodsDomain
{

    /**
     * 创建用户分销商品
     * @param $user_id             用户ID
     * @param $goods_id            商品ID
     * @param $article_text        分销商品推荐文章内容
     * @return int|string
     */
    public function create($user_id,$goods_id,$article_text){
        return Db::name('sp_good_goods')->insertGetId([
            'user_id'       =>$user_id,
            'goods_id'      =>$goods_id,
            'article_text'  =>$article_text,
            'favorites'     =>0,
            'like'          =>0,
            'comment'       =>0,
            'is_del'        =>0,
            'created_time'  =>date('Y-m-d H:i:s'),
            'updated_time'  =>date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 用户编辑分销商品信息
     * @param $good_goods_id       分销商品ID
     * @param $user_id             用户ID
     * @param $article_text        分销商品推荐文章内容
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function edit($good_goods_id,$user_id,$article_text){
        $isTrue = Db::name('sp_good_goods')->where('id',$good_goods_id)->where('user_id',$user_id)->update(['article_text'=>$article_text,'updated_time'=>date('Y-m-d H:i:s')]);
        if($isTrue === false){
            return false;
        }

        return true;
    }

    /**
     * 用户软删除分销商品
     * @param $good_goods_id      分销商品ID
     * @param $user_id            用户ID
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function del($good_goods_id,$user_id){
        $isTrue = Db::name('sp_good_goods')->where('id',$good_goods_id)->where('user_id',$user_id)->update(['is_del'=>1,'updated_time'=>date('Y-m-d H:i:s')]);
        if($isTrue === false){
            return false;
        }

        return true;
    }

    /**
     * 获取分销商品列表数据
     */
    public function getGoodGoodsList($page=1,$page_size=15){
        $obj = Db::name('sp_good_goods')->alias('good_goods');
        $obj->leftJoin('wl_sp_goods goods','goods.id = good_goods.goods_id and goods.status = 0');
        $field = [
            'good_goods.id',
            'goods.img',
            'good_goods.title',
            'good_goods.favorites',
            'good_goods.like',
            'good_goods.comment',
            'goods.market_price',
            'goods.sell_price',
        ];

        $obj->order('good_goods.created_time desc');
        $total = $obj->count(1);

        $rows = $obj->field($field)->page($page,$page_size)->fetchSql(false)->select();

        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取分销商品详情
     * @param $good_goods_id    分销商品ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodGoodsDetail($good_goods_id){
        $data = [
            'info'=>[],
            'imgs'=>[],
        ];

        $field = [
            'good_goods.id',
            'good_goods.title',
            'good_goods.favorites',
            'good_goods.like',
            'good_goods.comment',
        ];

        $data['info'] = Db::name('sp_good_goods')->alias('good_goods')->field($field)->find();
        if($data['info']){
            $data['imgs'] = SpGoodsModel::getImgs($good_goods_id);
        }

        return $data;
    }

    /**
     * 获取分销商品的评论数据列表
     * @param $good_goods_id
     * @param int $user_id
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodGoodsCommentList($good_goods_id,$user_id=0,$page=1,$page_size=15){
        $field = [
            'comment.id','comment.user_id','comment.like_count','comment.content','comment.created_time','user.nickname','user.portrait',
            'auth.username','auth.enterprise_name',
            'user.type'=>'user_type',
            'IF(like.id > 0,1,0)'=>'islike',
        ];

        $obj = Db::name('comment')->alias('comment');
        $obj->leftJoin('wl_user user','comment.user_id = user.id');
        $obj->leftJoin('wl_auth auth','comment.user_id = auth.user_id');
        $obj->leftJoin('wl_user_like like',"like.object_id = comment.id and like.table_name = 'comment' and like.user_id = {$user_id} and like.status = 0");
        $obj->where('comment.object_id',$good_goods_id);
        $obj->where('comment.table_name','sp_good_goods');
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

    /**
     * 获取分销产品有关的产品
     * @param $goods_id
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodGoodsRelevant($goods_id,$page=1,$page_size=5){
        $obj = Db::name('sp_category_extend')->distinct(true)->alias('ce');
        $obj->where('ce.category_id', 'IN', function ($query) use($goods_id) {
            $query->name('sp_category_extend')->where('goods_id', $goods_id)->field('category_id');
        });

        $obj->join('wl_sp_good_goods good_goods','ce.goods_id = good_goods.goods_id and good_goods.is_del=0');
        $obj->order('good_goods.like desc,good_goods.favorites desc,good_goods.created_time asc');

        $total = $obj->count();
        $rows = $obj->field('good_goods.*')->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}