<?php
namespace app\seller\controller;


use think\App;
use think\Request;

class ShopApi extends BaseController
{
    private $_goodsDomain;
    private $_orderDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_goodsDomain = new \app\api\domain\SpGoodsDomain();

        $this->_orderDomain = new \app\api\domain\ShOrderDomain();

        if(!$this->checkLogin()){
            exit(json_encode(['code' =>401,'msg'  =>'用户未登录','data' =>[]]));
        }
    }

    /**
     * 上传商品图片
     */
    public function uploadGoodImg(Request $request){
        $file = $request->file("goodsFile");
        $img_domain = config('conf.file_save_domain');
        #文件上传类型
        $fileExt   = ['jpg', 'jpeg', 'png'];
        if($file){
            $size = 1024*1024*5;              #单位字节
            if(!$file->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过2M',305);
            }

            if(!$file->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持jpg,jpeg及png格式的图片',305);
            }

            $info = $file->move( '../uploads/goodsimgs');
            if($info){
                $path_dir = $img_domain.'/goodsimgs/'.str_replace("\\","/",$info->getSaveName());
                $id = (new \app\api\model\SpGoodsPhotoModel())->createGoodsPhoto($path_dir);
                if($id){
                    return $this->returnData(['img'=>$path_dir,'img_id'=>$id],'上传成功',200);
                }else{
                    return $this->returnData([],'上传失败',305);
                }
            }else{
                return $this->returnData([],$file->getError(),305);
            }
        }
    }

    /**
     * 发布商品
     * @param Request $request
     * @return false|string
     */
    public function releaseGoods(Request $request){
        if(!$request->isAjax() || !$request->isPost()){
            return $this->returnData([],'参数不符合规范1',301);
        }

        $data = \Request::only([
            'name'          =>'',
            'market_price'  =>0.00,
            'sell_price'    =>0.00,
            'prepay_price'  =>0.00,
            'topay_price'   =>0.00,
            'store_nums'    =>0,
            'status'        =>2,
            'content'       =>'',
            'keywords'      =>'',
            'description'   =>'',
            'search_words'  =>'',
            'img_ids'       =>'',
            'category'      =>'',
            'doctor_id'     =>0,
            'hospital_id'   =>0,
            'buy_deadline'  =>'',
            'notice'        =>'',
            'time_slot'     =>'',
        ], 'post');

        $data['buyflow'] = $request->post('buyflow/a','');

        if(is_array($data['buyflow'])){
            $data['buyflow'] = json_encode($data['buyflow']);
        }

        $data['img_ids'] = trim($data['img_ids'],',');

        $goods_id = (int) $request->post('goods_id',0);

        if((new \app\seller\validate\Goods())->scene('releaseGoods')->check($data) == false){
            return $this->returnData([],'参数不符合规范',301);
        }

        if(($data['sell_price'] - $data['prepay_price']) != $data['topay_price']){
            return $this->returnData([],'销售价格 != 预付金额+到付金额',301);
        }

        $domain = new \app\api\domain\SpGoodsDomain();
        if($goods_id > 0){
            $res = $domain->editGoods($goods_id,$this->getSellerId(),$data);
        }else{
            $res = $domain->addGoods($this->getSellerId(),$data);
        }

        if(!$res){
            return $this->returnData([],'商品发布失败',305);
        }
        return $this->returnData([],'商品发布成功',200);
    }


    /**
     *
     * @param Request $request
     * @return false|string
     */
    public function getCategoryList(Request $request){
        $category_id = $request->post('category_id',0);
        $domain = new \app\api\domain\SpCategory();
        $data = $domain->getCategoryList($category_id);
        return $this->returnData(['rows'=>$data],'',200);
    }

    /**
     * 获取商品列表
     */
    public function getGoodsList(){

        $page = $this->request->param('page',1);
        $page_size = $this->request->param('limit',20);

        $data = $this->_goodsDomain->getSellerGoodsList($this->getSellerId(),$page,$page_size);

        return $this->returnData($data,'',200);
    }

    public function getSellerOrderList(){
        $page = $this->request->param('page',1);
        $page_size = $this->request->param('limit',20);
        $status = $this->request->param('status/d',0);

        $data = $this->_orderDomain->getSellerOrder($this->getSellerId(),$status,$page,$page_size);

        return $this->returnData($data,'',200);
    }

    /**
     * 更新商品状态
     */
    public function updateGoodsStatus(){
        $ids = $this->request->post('ids/a',[]);
        $flag = $this->request->post('flag','');

        if(empty($ids) || empty($flag)){
            return $this->returnData([],'参数不符合规范',301);
        }

        if($flag == 'upper-shelf'){
            $status = 3;
        }else if($flag == 'lower-shelf'){
            $status = 2;
        }else{
            return $this->returnData([],'参数不符合规范',301);
        }

        $isTrue = $this->_goodsDomain->updateStatus($this->getSellerId(),$ids,$status);

        if($isTrue){
            return $this->returnData([],'更新成功',200);
        }

        return $this->returnData([],'',305);
    }
}