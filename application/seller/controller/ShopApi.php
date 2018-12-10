<?php
namespace app\seller\controller;


use think\App;
use think\Request;

class ShopApi extends BaseController
{

    private $_goodsDomain;


    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_goodsDomain = new \app\api\domain\SpGoodsDomain();

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
            $size = 1024*1024*2;              #单位字节
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
            'category_ids'  =>'',
            'doctor_id'     =>0,
            'hospital_id'   =>0,
        ], 'post');

        $data['img_ids'] = trim($data['img_ids'],',');

        $goods_id = (int) $request->post('goods_id',0);

        if((new \app\seller\validate\Goods())->scene('releaseGoods')->check($data) == false){
            return $this->returnData([],'参数不符合规范',301);
        }

        $domain = new \app\api\domain\SpGoodsDomain();
        if($goods_id > 0){
            $res = $domain->editGoods($goods_id,0,$data);
        }else{
            $res = $domain->addGoods(0,$data);
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
        $data = $this->_goodsDomain->getSellerGoodsList(0,1,15);

        return $this->returnData($data,'',0);
    }
}