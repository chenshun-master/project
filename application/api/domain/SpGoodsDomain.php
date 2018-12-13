<?php
namespace app\api\domain;

use think\Db;

class SpGoodsDomain
{
    /**
     * 创建商品
     * @param $seller_id    商家ID
     * @param $data         商品数据
     * @return bool
     */
    public function addGoods($seller_id,$data){
        $imgs           = explode(',',$data['img_ids']);
        $category_ids   = explode(',',$data['category_ids']);

        $img = Db::name('sp_goods_photo')->where('id',$imgs[0])->value('img');
        Db::startTrans();
        try {
            $goods_id = Db::name('sp_goods')->insertGetId([
                'goods_no'      =>getOrderNo(),
                'name'          =>$data['name'],
                'market_price'  =>$data['market_price'],
                'sell_price'    =>$data['sell_price'],
                'prepay_price'  =>$data['prepay_price'],
                'topay_price'   =>$data['topay_price'],
                'store_nums'    =>$data['store_nums'],
                'img'           =>$img,
                'status'        =>3,
                'content'       =>$data['content'],
                'keywords'      =>$data['keywords'],
                'description'   =>$data['description'],
                'search_words'  =>$data['search_words'],
                'create_time'   =>date('Y-m-d H:i:s'),
                'seller_id'     =>$seller_id
            ]);

            if(!$goods_id){
                Db::rollback();
                return false;
            }

            $category_data = [];
            foreach ($category_ids as $val){
                $category_data[] = ['category_id' => $val,'goods_id' => $goods_id];
            }
            $res = Db::name('sp_category_extend')->data($category_data)->insertAll();
            if(!$res){
                Db::rollback();
                return false;
            }

            $datas = [];
            foreach ($imgs as $v){
                $datas[] = ['photo_id' => $v,'goods_id' => $goods_id];
            }
            $res1 = Db::name('sp_goods_photo_relation')->data($datas)->insertAll();
            if(!$res1){
                Db::rollback();
                return false;
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    /**
     * 编辑商品
     * @param $good_id
     * @param $seller_id
     * @param $data
     * @return bool
     */
    public function editGoods($good_id,$seller_id,$data){
        $good_id = Db::name('sp_goods')->where('id',$good_id)->where('seller_id',$seller_id)->value('id');
        if(!$good_id){
            return false;
        }

        $imgs           = explode(',',$data['img_ids']);
        $category_ids   = explode(',',$data['category_ids']);

        Db::startTrans();
        try {
            $isTrue = Db::name('sp_goods')->where('id',$good_id)->where('seller_id',$seller_id)->update([
                'name'          =>$data['name'],
                'market_price'  =>$data['market_price'],
                'sell_price'    =>$data['sell_price'],
                'prepay_price'  =>$data['prepay_price'],
                'topay_price'   =>$data['topay_price'],
                'store_nums'    =>$data['store_nums'],
                'img'           =>Db::name('sp_goods_photo')->where('id',$imgs[0])->value('img'),
                'status'        =>$data['status'],
                'content'       =>$data['content'],
                'keywords'      =>$data['keywords'],
                'description'   =>$data['description'],
                'search_words'  =>$data['search_words'],
            ]);

            if($isTrue === false){
                return false;
            }

            if($data['category_ids'] !== implode(',',Db::name('sp_category_extend')->where('goods_id',$good_id)->column('category_id'))){
                $datas = [];
                foreach ($category_ids as $id){
                    $datas[] = ['category_id' => $id,'goods_id' => $good_id];
                }

                $res1 = Db::name('sp_category_extend')->where('goods_id',$good_id)->delete();
                if(!$res1){
                    Db::rollback();return false;
                }

                $res2 = Db::name('sp_category_extend')->data($datas)->insertAll();
                if(!$res2){
                    Db::rollback();
                    return false;
                }
            }

            if($data['img_ids'] !== implode(',',Db::name('sp_goods_photo_relation')->where('goods_id',$good_id)->column('photo_id'))){
                $datas = [];
                foreach ($imgs as $v){
                    $datas[] = ['photo_id' => $v,'goods_id' => $good_id];
                }


                $res3 = Db::name('sp_goods_photo_relation')->where('goods_id',$good_id)->delete();
                if(!$res3){
                    Db::rollback();return false;
                }

                $res4 = Db::name('sp_goods_photo_relation')->data($datas)->insertAll();
                if(!$res4){
                    Db::rollback();
                    return false;
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
     * 商品状态审核审核接口
     * @param int $good_id
     * @param int $status
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function examineGoods(int $good_id,int $status){
        $data = [];

        $data['status'] = $status;
        if($status == 0){
            $data['up_time'] = date('Y-m-d H:i:s');
        }else if($status == 1 || $status == 2){
            $data['down_time'] = date('Y-m-d H:i:s');
        }

        if(!Db::name('sp_goods')->where('id',$good_id)->update($data)){
            return false;
        }

        return true;
    }

    /**
     * 不通过购物车直接购买商品
     * @param int $goods_id    商品ID
     * @param int $goods_num   购买商品的数量
     * @param int $user_id     用户数量
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function directBuyGoods(int $goods_id,int $goods_num,int $user_id){
        $goods_info = Db::name('sp_goods')->where('id',$goods_id)->where('status',0)->where('store_nums','>',$goods_num)->field('id,market_price,sell_price,prepay_price,topay_price,img,seller_id')->find();
        if(!$goods_info){
            return false;
        }

        //准备订单数据
        $orderData = [];
        $orderData['order_no']          = getOrderNo();
        $orderData['goods_id']          = $goods_id;
        $orderData['user_id']           = $user_id;
        $orderData['seller_id']         = $goods_info['seller_id'];
        $orderData['goods_nums']        = $goods_num;
        $orderData['img']               = $goods_info['img'];
        $orderData['img']               = $goods_info['img'];

        //优惠价格
        $orderData['discount_price']    = 0.00;
        //应付商品总金额
        $orderData['payable_amount']    = $goods_info['sell_price'] * $goods_num;
        //预付总金额
        $orderData['prepay_price']      = $goods_info['prepay_price'] * $goods_num;
        //到付总金额
        $orderData['topay_price']       = $goods_info['topay_price'] * $goods_num;
        //实付商品总金额
        $orderData['real_amount']       = 0.00;

        $orderData['status']            = 1;
        $orderData['is_checkout']       = 0;
        $orderData['create_time']       = date('Y-m-d H:i:s');

        return  Db::name('sh_order')->insertGetId($orderData);
    }



    public function getSearchGoods($searchParams = []){

    }

    /**
     * 商品信息列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsList()
    {
        $goodsList = Db::name('sp_goods')->alias('sp')
            ->leftJoin('wl_doctor doctor','doctor.id = sp.doctor_id')
            ->leftJoin('wl_hospital hospital','hospital.id = sp.hospital_id')
            ->leftJoin('wl_sp_seller seller','seller.id = sp.seller_id')
            ->leftJoin('wl_user user','hospital.user_id = user.id')
            ->leftJoin('wl_auth auth','auth.user_id = user.id')
            ->paginate();
        return $goodsList;
    }
}