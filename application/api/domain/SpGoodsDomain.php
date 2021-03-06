<?php
namespace app\api\domain;

use think\Db;
use app\api\model\RegionsModel;
use app\api\model\SpGoodsModel;
use app\api\traits\DTrait;

class SpGoodsDomain
{

    use DTrait;

    /**
     * 更新商品浏览量
     * @param $goods_id
     * @throws \think\Exception
     */
    public function updateBrowseVolume($goods_id){
        Db::name('sp_goods')->where('id',$goods_id)->setInc('visit');
    }

    /**
     * 创建商品
     * @param $seller_id    商家ID
     * @param $data         商品数据
     * @return bool
     */
    public function addGoods($seller_id,$data){
        $imgs           = explode(',',$data['img_ids']);

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
                'category_id'   =>$data['category']
            ]);

            if(!$goods_id){
                Db::rollback();return false;
            }

            $datas = [];
            foreach ($imgs as $v){
                $datas[] = ['photo_id' => $v,'goods_id' => $goods_id];
            }

            $res1 = Db::name('sp_goods_photo_relation')->data($datas)->insertAll();
            if(!$res1){
                Db::rollback();return false;
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
                Db::rollback();return false;
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
                'category_id'   =>$data['category']
            ]);

            if($isTrue === false){
                throw new \think\Exception('商品信息更新失败');
            }

            if($data['img_ids'] !== implode(',',Db::name('sp_goods_photo_relation')->where('goods_id',$good_id)->column('photo_id'))){
                $datas = [];
                foreach ($imgs as $v){
                    $datas[] = ['photo_id' => $v,'goods_id' => $good_id];
                }

                $res3 = Db::name('sp_goods_photo_relation')->where('goods_id',$good_id)->delete();
                if(!$res3){
                    throw new \think\Exception('商品图片信息更新失败');
                }

                $res4 = Db::name('sp_goods_photo_relation')->data($datas)->insertAll();
                if(!$res4){
                    throw new \think\Exception('商品图片信息更新失败');
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
            Db::rollback();return false;
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
    public function examineGoods($good_id,int $status){
        $data = [];

        $data['status'] = $status;
        if($status == 0 || $status == 3){
            $data['up_time'] = date('Y-m-d H:i:s');
        }else if($status == 1 || $status == 2){
            $data['down_time'] = date('Y-m-d H:i:s');
        }

        if(!Db::name('sp_goods')->where('id','IN',$good_id)->update($data)){
            return false;
        }

        return true;
    }

    /**
     * 商品下单
     * @param int $goods_id    商品ID
     * @param int $goods_num   下单商品的数量
     * @param int $user_id     用户数量
     * @param int $gid     用户数量
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function placeOrder(int $goods_id,int $goods_num,int $user_id,$gid=0){
        $goods_info = Db::name('sp_goods')
            ->where('id',$goods_id)
            ->where('status',0)
            ->where('store_nums','>',$goods_num)
            ->field('id,market_price,sell_price,prepay_price,topay_price,img,seller_id,doctor_id,hospital_id,name')->find();
        if(!$goods_info){
            return false;
        }


        if($gid > 0){
            if(!Db::name('sp_good_goods')->where('id',$gid)->where('goods_id',$goods_id)->where('is_del',0)->value('id')){
                return false;
            }
        }

        //包装订单数据
        $orderData = [];
        $orderData['order_no']          = getOrderNo();
        $orderData['goods_id']          = $goods_id;
        $orderData['user_id']           = $user_id;
        $orderData['seller_id']         = $goods_info['seller_id'];
        $orderData['hospital_id']       = $goods_info['hospital_id'];
        $orderData['doctor_id']         = $goods_info['doctor_id'];
        $orderData['good_goods_id']     = $gid;
        $orderData['img']               = $goods_info['img'];
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
//        $orderData['real_amount']       = 0.02;
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

        //分类筛选
        if(isset($searchParams['category']) && !empty($searchParams['category'])){
            $obj->where('goods.category_id', $searchParams['category']);
        }

        //城市筛选
        if(isset($searchParams['city']) && !empty($searchParams['city'])){

        }

        //关键词筛选
        if(isset($searchParams['keywords']) && !empty($searchParams['keywords'])){
            $obj->where('goods.name|goods.keywords','like',"%{$searchParams['keywords']}%");
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
            }else if($searchParams['sort'] == 5){
                $obj->order('goods.sell_price asc');
            }else{
                $obj->order('goods.sale_num desc');
            }
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
    public function getSellerGoodsList($seller_id,$page = 1,$page_size = 15,$searchParams=[]){
        $obj = Db::name('sp_goods')->alias('goods');

        $obj->where('goods.seller_id',$seller_id);

        if(!empty($searchParams) && is_array($searchParams)){
            //关键词筛选
            if(isset($searchParams['keywords']) && !empty($searchParams['keywords'])){
                $obj->where('goods.name|goods.keywords','like',"%{$searchParams['keywords']}%");
            }

            if(isset($searchParams['status'])){
                $obj->where('goods.status',$searchParams['status']);
            }
        }

        $obj->order('goods.create_time','desc');
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
     * @param int $goods_id     商品ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsDetail(int $goods_id,$user_id=0){
        $data = [
            'goods_info' =>[],
            'imgs'=>[],
            'hospital_info'=>[],
        ];

        //查询商品信息
        $obj = Db::name('sp_goods')->alias('goods');
        $obj->where('goods.id',$goods_id);
        $obj->leftJoin('wl_sp_goods_buy_notice buy_notice','buy_notice.goods_id = goods.id');
        $obj->leftJoin('wl_user_favorite favorite',"favorite.user_id = {$user_id} and favorite.table_name='goods' and favorite.status=0 and favorite.object_id = goods.id");
        $obj->leftJoin('wl_user user','user.id = goods.seller_id');
        $field = [
            'goods.id','goods.name','goods.status','goods.market_price','goods.sell_price','goods.prepay_price','goods.topay_price','goods.img','goods.content','goods.visit','goods.favorites','goods.comments','goods.sale_num',
            'goods.case_num','goods.doctor_id','goods.hospital_id','goods.seller_id','buy_notice.buy_deadline','buy_notice.notice','buy_notice.buyflow','buy_notice.time_slot','IF(favorite.id > 0,1,0) as isfavorite',
            'user.id as uid','user.type as user_type'
        ];

        $goodsInfo = $data['goods_info'] = $obj->field($field)->find();
        if($goodsInfo){
            if(!empty($data['goods_info']['buyflow'])){
                $data['goods_info']['buyflow'] = json_decode($data['goods_info']['buyflow'],true);
            }

            //查询商品图片
            $data['imgs'] = SpGoodsModel::getImgs($goods_id);

            //查询医院信息
            $hospitalInfo = Db::name('hospital')->alias('hospital')->leftJoin('wl_auth auth','auth.user_id = hospital.user_id')->where('hospital.id',$goodsInfo['hospital_id'])->field('hospital.user_id,hospital.hospital_name,auth.phone,auth.province,auth.city,auth.area,auth.address')->find();
            $data['hospital_info'] = $hospitalInfo;

            $regionsModel = new RegionsModel();
            $data['hospital_info']['address_dateil'] = $regionsModel->getAddress([$hospitalInfo['province'],$hospitalInfo['city'],$hospitalInfo['area']],$hospitalInfo['address']);
        }

        return $data;
    }

    /***
     * 获取商品下单的相关信息
     * @param $goods_id         商品ID
     * @param int $goods_num    商品数量
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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
     * 获取商品列表
     * @param $status
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsList($status=0,$page=1,$page_size=10)
    {
        if($status == 1) {
            $status = 3;
        }else if($status == 2) {
            $status = 2;
        }else if($status == 3){
            $status =0;
        }

        $obj = Db::name('sp_goods')->alias('sp');
        $obj->leftJoin('wl_doctor doctor','doctor.id = sp.doctor_id');
        $obj->leftJoin('wl_hospital hospital', 'hospital.id = sp.hospital_id');
        if($status != 0){
            $obj->where("sp.status",$status);
        }

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
            'goods.category_id',
            'category.name as category_name'
        ];

        $obj = Db::name('sp_goods')->alias('goods');
        $obj->leftJoin('wl_sp_category category','category.id = goods.category_id');
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
        }

        return $data;
    }

    /**
     * 商家更新产品状态
     * @param int $seller_id
     * @param int $good_id
     * @param int $status
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateStatus($seller_id,array $ids,int $status){
        $data = [];

        $data['status'] = $status;
        if($status == 0 || $status == 3){
            $data['up_time'] = date('Y-m-d H:i:s');
        }else if($status == 1 || $status == 2){
            $data['down_time'] = date('Y-m-d H:i:s');
        }

        if(!Db::name('sp_goods')->where('id','IN',$ids)->where('seller_id',$seller_id)->update($data)){
            return false;
        }

        return true;
    }

    /**
     * 获取前端用户发布的商品列表
     * @param int $user_id
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserGoods($user_id=0,$page=1,$page_size=10){
        $obj = Db::name('sp_goods')->alias('goods');
        $obj->where('goods.seller_id',$user_id);
        $obj->where('goods.status',0);
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
            'goods.grade'
        ];

        $rows = $obj->fetchSql(false)->field($field)->page($page,$page_size)->select();
        return $this->packData($rows,$total,$page,$page_size);
    }
}