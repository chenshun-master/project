<?php
namespace app\api\domain;
use think\Db;
use app\api\model\SpGoodsModel;

class SpGoodGoodsDomain
{

    /**
     * 查询分销产品是否存在
     */
    public function findGoodGoods($user_id,$goods_id){
        $isTrue = Db::name('sp_good_goods')->where('goods_id',$goods_id)->where('user_id',$user_id)->value('id');

        return $isTrue ?:0;
    }

    /**
     * 创建用户分销商品
     * @param $user_id             用户ID
     * @param $goods_id            商品ID
     * @param $article_text        分销商品推荐文章内容
     * @return int|string
     */
    public function create($data){
        return Db::name('sp_good_goods')->insertGetId([
            'user_id'       =>$data['user_id'],
            'goods_id'      =>$data['goods_id'],
            'title'         =>$data['title'],
            'article_text'  =>$data['article_text'],
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
        $obj->join('wl_sp_goods goods','goods.id = good_goods.goods_id and goods.status = 0');
        $field = [
            'good_goods.id',
            'goods.img',
            'good_goods.title',
            'good_goods.favorites',
            'good_goods.like',
            'good_goods.comment',
            'goods.market_price',
            'goods.sell_price',
            'goods.name'
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
    public function getGoodGoodsDetail($good_goods_id,$user_id = 0){
        $data = [
            'info'=>[],
            'imgs'=>[],
        ];

        $field = [
            'good_goods.id',
            'good_goods.user_id',
            'good_goods.goods_id',
            'good_goods.title',
            'good_goods.favorites',
            'good_goods.like',
            'good_goods.comment',
            'good_goods.article_text',
            'goods.sale_num',
            'goods.sell_price',
            'good_goods.created_time',
            'user.portrait',
            'user.nickname',
            'user.type',
            'goods.name',
            'goods.img',
            'IF(like.id > 0,1,0)'=>'islike',
            'IF(favorite.id > 0,1,0)'=>'isfavorite',
        ];

        $data['info'] = Db::name('sp_good_goods')->alias('good_goods')
            ->leftJoin('wl_sp_goods goods','goods.id = good_goods.goods_id')
            ->leftJoin('wl_user user','user.id = good_goods.user_id')
            ->leftJoin('wl_user_like like',"like.user_id = {$user_id} and like.table_name='sp_good_goods' and like.status=0 and like.object_id = good_goods.id")
            ->leftJoin('wl_user_favorite favorite',"favorite.user_id = {$user_id} and favorite.table_name='sp_good_goods' and favorite.status=0 and favorite.object_id = good_goods.id")
            ->where('good_goods.id',$good_goods_id)->field($field)->find();


        if($data['info']){
            $data['imgs'] = SpGoodsModel::getImgs($data['info']['goods_id']);
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
        $obj = Db::name('sp_good_goods')->alias('good_goods');
        $obj->join('wl_sp_goods goods','goods.id = good_goods.goods_id and goods.status=0');
        $obj->where('goods.category_id','IN', function ($query) use($goods_id) {
            $query->name('sp_good_goods')->where('id', $goods_id)->field('category_id');
        });

        $total = $obj->count();
        $field = [
            'goods.id as goods_id',
            'goods.name',
            'good_goods.title',
            'goods.sell_price',
            'goods.sale_num',
            'goods.market_price',
            'good_goods.id as goods_good_id',
            'goods.img'
        ];

        $rows = $obj->field($field)->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取分销商品列表数据
     */
    public function getUserGoodGoodsList($user_id,$page=1,$page_size=15){
        $obj = Db::name('sp_good_goods')->alias('good_goods');
        $obj->join('wl_sp_goods goods','goods.id = good_goods.goods_id and goods.status = 0');
        $obj->leftJoin('wl_hospital hospital','hospital.id = goods.hospital_id');

        $obj->where('good_goods.user_id',$user_id);
        $field = [
            'good_goods.id',
            'goods.img',
            'good_goods.title',
            'good_goods.favorites',
            'good_goods.like',
            'good_goods.comment',
            'goods.market_price',
            'goods.sell_price',
            'good_goods.created_time',
            'hospital.hospital_name'
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
}