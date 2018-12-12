<?php
namespace app\api\domain;

use think\Db;
use app\api\model\RegionsModel;

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
     * 商品下单
     * @param int $goods_id    商品ID
     * @param int $goods_num   下单商品的数量
     * @param int $user_id     用户数量
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function placeOrder(int $goods_id,int $goods_num,int $user_id){
        $goods_info = Db::name('sp_goods')->where('id',$goods_id)->where('status',0)->where('store_nums','>',$goods_num)->field('id,market_price,sell_price,prepay_price,topay_price,img,seller_id,doctor_id,hospital_id')->find();
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
        $orderData['hospital_id']       = $goods_info['hospital_id'];
        $orderData['doctor_id']         = $goods_info['doctor_id'];

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

    /**
     * 查询获取产品列表页(移动端)
     * @param array $searchParams        查询参数
     * @param int $page                  分页
     * @param int $page_size             分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSearchGoods($searchParams = [],$page=1,$page_size=15){
        $obj = Db::name('sp_goods')->alias('goods');

        if(isset($searchParams['category']) && !empty($searchParams['category'])){
            $obj->where('goods.id', 'IN', function ($query) use($searchParams) {
                $query->table('wl_sp_category')->alias('category')->distinct(true)
                ->leftJoin('wl_sp_category_extend c_extend','c_extend.category_id = category.id')
                ->where('category.path','like',"{$searchParams['category']}%")
                ->field('c_extend.goods_id');
            });
        }

        if(isset($searchParams['sort']) && !empty($searchParams['sort'])){
            if($searchParams['sort'] == 1){
                $obj->order('goods.sale_num desc');
            }else if($searchParams['sort'] == 2){
                $obj->order('goods.case_num desc');
            }else if($searchParams['sort'] == 3){
                $obj->order('goods.create_time desc');
            }else if($searchParams['sort'] == 4){
                $obj->order('goods.sell_price desc');
            }else{
                $obj->order('goods.sale_num desc');
            }
        }

        if(isset($searchParams['city']) && !empty($searchParams['city'])){

        }

        if(isset($searchParams['keywords']) && !empty($searchParams['keywords'])){
            $obj->where('goods.name|goods.keywords','like',"%{$searchParams['keywords']}%");
        }

        $obj->where('goods.status',0);
        $obj->leftJoin('wl_doctor doctor','doctor.id = goods.doctor_id');
        $obj->leftJoin('wl_hospital hospital','hospital.id = goods.hospital_id');

        $total = $obj->count('goods.id');

        $field = [
            'goods.id',
            'goods.name',
            'goods.market_price',
            'goods.sell_price',
            'goods.prepay_price',
            'goods.img',
            'goods.visit',
            'goods.favorite',
            'goods.sale_num',
            'goods.case_num',
            'goods.grade',
            'doctor.real_name'=>'doctor_name',
            'hospital.hospital_name'
        ];

        $rows = $obj->fetchSql(false)->field($field)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取商户商品列表
     */
    public function getSellerGoodsList($seller_id,$page = 1,$page_size = 15){
        $obj = Db::name('sp_goods')->alias('goods');

        $obj->where('goods.seller_id',$seller_id);

        $total = $obj->count(1);
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取手机端商品详情
     */
    public function getGoodsDetail(int $goods_id){
        $data = [
            'goods_info' =>[],
            'imgs'=>[],
            'hospital_info'=>[],
        ];

        //查询商品信息
        $goodsInfo = Db::name('sp_goods')->where('id',$goods_id)->where('status',0)->field('id,name,market_price,sell_price,prepay_price,topay_price,img,content,visit,favorite,comments,sale_num,case_num,doctor_id,hospital_id,seller_id')->find();
        $data['goods_info'] = $goodsInfo;

        if($goodsInfo){
            //查询商品图片
            $data['imgs'] = Db::name('sp_goods_photo_relation')->alias('goods_pr')->leftJoin('wl_sp_goods_photo goods_photo','goods_pr.photo_id = goods_photo.id')->where('goods_pr.goods_id',$goods_id)->column('goods_photo.img');

            //查询医院信息
            $hospitalInfo = Db::name('hospital')->alias('hospital')->leftJoin('wl_auth auth','auth.user_id = hospital.user_id')->where('hospital.id',$goodsInfo['hospital_id'])->field('hospital.hospital_name,auth.phone,auth.province,auth.city,auth.area,auth.address')->find();
            $data['hospital_info'] = $hospitalInfo;

            $regionsModel = new RegionsModel();
            $data['hospital_info']['address_dateil'] = $regionsModel->getAddress([$hospitalInfo['province'],$hospitalInfo['city'],$hospitalInfo['area']],$hospitalInfo['address']);
        }



        return $data;
    }


    /**
     * 获取商品下单的相关信息
     */
    public function getPlaceOrderPayInfo($goods_id,int $goods_num){
        $info = Db::name('sp_goods')->where('id',$goods_id)->where('status',0)->field('id,name,market_price,sell_price,prepay_price,topay_price')->find();
        $data = [];
        if(!$info){
            return [];
        }
        $info['num'] = $goods_num;
        $data['info'] = $info;
        $data['calculation'] = [
            'prepay_price'=>number_format($info['prepay_price'] * $goods_num, 2, '.', ''),
            'topay_price' =>number_format($info['topay_price'] * $goods_num, 2, '.', ''),
            'discount_price'=>'0.00'
        ];

        return $data;
    }

    /**
     * 获取待支付订单信息
     */
    public function getPayOrderInfo($order_id){
        return Db::name('sp_order')->where('id',$order_id)->where('status',1)->find();
    }

    /**
     * 获取商家热门商品列表
     * @param $seller_id           商家ID
     * @param int $page            当前分页
     * @param int $page_size       分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSellerHotGoods($seller_id,$page=1,$page_size=15){
        $obj = Db::name('sp_goods')->alias('goods');
        $obj->leftJoin('wl_doctor doctor','doctor.id = goods.doctor_id');
        $obj->leftJoin('wl_hospital hospital','hospital.id = goods.hospital_id');

        $obj->where('goods.seller_id',$seller_id);
        $obj->where('goods.status',0);
        $obj->order('goods.sale_num desc,goods.favorite desc,goods.visit desc');

        $field = [
            'goods.id',
            'goods.name',
            'goods.market_price',
            'goods.sell_price',
            'goods.prepay_price',
            'goods.img',
            'goods.visit',
            'goods.favorite',
            'goods.sale_num',
            'goods.case_num',
            'goods.grade',
            'doctor.real_name'=>'doctor_name',
            'hospital.hospital_name'
        ];

        $total = $obj->count(1);
        $rows = $obj->field($field)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}