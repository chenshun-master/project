<?php
namespace app\api\domain;

use think\Db;
use app\api\model\RegionsModel;
use app\api\model\SpGoodsModel;

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
        $category_ids   = explode(',',$data['category']);

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
                'seller_id'     =>$seller_id,
                'doctor_id'     =>$data['doctor_id'],
                'hospital_id'   =>$data['hospital_id'],
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

            $data3 = [
                'goods_id'      =>$goods_id,
                'buy_deadline'  =>(int)$data['buy_deadline'],
                'notice'        =>$data['notice'],
                'time_slot'     =>$data['time_slot'],
                'buyflow'       =>$data['buyflow'],
                'created_time'  =>date('Y-m-d H:i:s'),
            ];

            $res2 = Db::name('sp_goods_buy_notice')->insertGetId($data3);
            if(!$res2){
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
        $category_ids   = explode(',',$data['category']);

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
                'doctor_id'     =>$data['doctor_id'],
                'hospital_id'   =>$data['hospital_id'],
            ]);

            if($isTrue === false){
                throw new \think\Exception('商品信息更新失败');
            }

            if($data['category'] !== implode(',',Db::name('sp_category_extend')->where('goods_id',$good_id)->column('category_id'))){
                $datas = [];
                foreach ($category_ids as $id){
                    $datas[] = ['category_id' => $id,'goods_id' => $good_id];
                }

                $res1 = Db::name('sp_category_extend')->where('goods_id',$good_id)->delete();
                if(!$res1){
                    throw new \think\Exception('商品分类信息更新失败');
                }

                $res2 = Db::name('sp_category_extend')->data($datas)->insertAll();
                if(!$res2){
                    throw new \think\Exception('商品分类信息更新失败');
                }
            }

            if($data['img_ids'] !== implode(',',Db::name('sp_goods_photo_relation')->where('goods_id',$good_id)->column('photo_id'))){
                $datas = [];
                foreach ($imgs as $v){
                    $datas[] = ['photo_id' => $v,'goods_id' => $good_id];
                }


                $res3 = Db::name('sp_goods_photo_relation')->where('goods_id',$good_id)->delete();
                if(!$res3){
                    throw new \think\Exception('商品分类信息更新失败');
                }

                $res4 = Db::name('sp_goods_photo_relation')->data($datas)->insertAll();
                if(!$res4){
                    throw new \think\Exception('商品分类信息更新失败');
                }
            }

            $isTrue2 = Db::name('sp_goods_buy_notice')->where('goods_id',$good_id)->update([
                'buy_deadline'  =>(int)$data['buy_deadline'],
                'notice'        =>$data['notice'],
                'time_slot'     =>$data['time_slot'],
                'buyflow'       =>$data['buyflow'],
                'updated_time'  =>date('Y-m-d H:i:s')
            ]);

            if($isTrue2 === false){
                throw new \think\Exception('商品分类信息更新失败');
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
        if($status == 0 || $status == 3){
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
        $goods_info = Db::name('sp_goods')->where('id',$goods_id)->where('status',0)->where('store_nums','>',$goods_num)->field('id,market_price,sell_price,prepay_price,topay_price,img,seller_id,doctor_id,hospital_id,name')->find();
        if(!$goods_info){
            return false;
        }

        //包装订单数据
        $orderData = [];
        $orderData['order_no']          = getOrderNo();
        $orderData['goods_id']          = $goods_id;
        $orderData['user_id']           = $user_id;
        $orderData['seller_id']         = $goods_info['seller_id'];
        $orderData['img']               = $goods_info['img'];
        $orderData['hospital_id']       = $goods_info['hospital_id'];
        $orderData['doctor_id']         = $goods_info['doctor_id'];
        $orderData['status']            = 1;
        $orderData['is_checkout']       = 0;
        $orderData['create_time']       = date('Y-m-d H:i:s');
        $orderData['goods_name']        = $goods_info['name'];

        //价格处理
        //原销售单价
        $orderData['goods_price']       = $goods_info['sell_price'];
        //购买数量
        $orderData['goods_nums']        = $goods_num;
        //订单优惠价格
        $orderData['discount_price']    = 0.00;
        //应付商品总金额
        $orderData['payable_amount']    = $goods_info['sell_price'] * $goods_num;
        //预付总金额
        $orderData['prepay_price']      = $goods_info['prepay_price'] * $goods_num;
        //到付总金额
        $orderData['topay_price']       = $goods_info['topay_price'] * $goods_num;
        //实付商品总金额
        $orderData['real_amount']       = $orderData['prepay_price'];
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
            'goods.favorites',
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
        $obj = Db::name('sp_goods')->alias('goods');
        $obj->where('goods.status',0);
        $obj->where('goods.id',$goods_id);
        $obj->leftJoin('wl_sp_goods_buy_notice buy_notice','buy_notice.goods_id = goods.id');
        $field = 'goods.id,goods.name,goods.market_price,goods.sell_price,goods.prepay_price,goods.topay_price,goods.img,goods.content,goods.visit,goods.favorites,goods.comments,goods.sale_num,goods.case_num,goods.doctor_id,goods.hospital_id,goods.seller_id,buy_notice.buy_deadline,buy_notice.notice,buy_notice.buyflow,buy_notice.time_slot';
        $goodsInfo = $data['goods_info'] = $obj->field($field)->find();

        if($goodsInfo){
            if(!empty($data['goods_info']['buyflow'])){
                $data['goods_info']['buyflow'] = json_decode($data['goods_info']['buyflow'],true);
            }

            //查询商品图片
            $data['imgs'] = SpGoodsModel::getImgs($goods_id);

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
        $obj->order('goods.sale_num desc,goods.favorites desc,goods.visit desc');

        $field = [
            'goods.id',
            'goods.name',
            'goods.market_price',
            'goods.sell_price',
            'goods.prepay_price',
            'goods.img',
            'goods.visit',
            'goods.favorites',
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

    /**
     * @param $status           状态
     * @param $seller_id        商家ID
     * @param int $page         当前分页
     * @param int $page_size    分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsList($status,$seller_id,$page=1,$page_size=10)
    {
        $obj = Db::name('sp_goods')->alias('sp');
        $obj->join('wl_doctor doctor','doctor.id = sp.doctor_id');
        $obj->join('wl_hospital hospital', 'hospital.id = sp.hospital_id');
//        $obj->join('wl_user user','user.id = hospital.user_id');
//        $obj->join('wl_auth auth','user.id = auth.user_id');
        $obj->where('sp.seller_id',$seller_id);
        $obj->where("sp.status",'like',"%".trim($status)."%");
        $field = [
          'sp.id',
          'sp.name',
          'sp.goods_no',
          'sp.market_price',
          'sp.sell_price',
          'sp.prepay_price',
          'sp.topay_price',
          'sp.up_time',
          'sp.down_time',
          'sp.store_nums',
          'sp.img',
          'sp.status',
          'sp.sale_num',
          'sp.case_num',
          'doctor.real_name',
          'hospital.hospital_name',
          'sp.seller_id',
          'sp.create_time',
        ];
        $total = $obj->count(1);
        $rows  = $obj->field($field)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取待编辑的商品信息
     */
    public function getEditGoodsInfo($goods_id,$seller_id){
        $data = [
            'goods_info'=>[],'goods_imgs'=>[]
        ];

        $field = [
            'goods.id',
            'goods.name',
            'goods.market_price',
            'goods.sell_price',
            'goods.prepay_price',
            'goods.topay_price',
            'goods.royalty',
            'goods.store_nums',
            'goods.status',
            'goods.keywords',
            'goods.description',
            'goods.search_words',
            'goods.doctor_id',
            'goods.hospital_id',
            'goods.content',
            'notice.buy_deadline',
            'notice.notice',
            'notice.buyflow',
            'notice.time_slot',
        ];

        $obj = Db::name('sp_goods')->alias('goods');
        $obj->leftJoin('sp_goods_buy_notice notice','notice.goods_id = goods.id');
        $obj->where('goods.id',$goods_id);
        $obj->where('seller_id',$seller_id);

        $goods_info = $obj->field($field)->find();
        if($goods_info){
            if($goods_info['buyflow']){
                $goods_info['buyflow'] = json_decode($goods_info['buyflow'],true);
            }

            $data['goods_info'] = $goods_info;
            $data['goods_imgs'] = Db::name('sp_goods_photo_relation')
                ->alias('goods_photo')
                ->leftJoin('wl_sp_goods_photo photo','photo.id = goods_photo.photo_id')
                ->where('goods_photo.goods_id',$goods_id)
                ->field('photo.id,photo.img')
                ->select();
            $data['goods_category'] = Db::name('sp_category_extend')
                ->alias('c_extend')
                ->leftJoin('wl_sp_category category','c_extend.category_id = category.id')
                ->where('c_extend.goods_id',$goods_id)
                ->field('category.id,category.name')
                ->select();
        }

        return $data;
    }
}