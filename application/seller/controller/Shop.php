<?php
namespace app\seller\controller;
use think\App;
use think\exception\Handle;
use think\Request;

class Shop extends BaseController
{

    private $_goodsDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_goodsDomain = new \app\api\domain\SpGoodsDomain();
    }

    public function index(){
        return $this->fetch('shop/index');
    }

    /**
     * 规格列表
     * @return mixed
     */
    public function spec(){
        return $this->fetch('shop/spec');
    }

    /**
     * 添加商品页面
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addgood(){
        if(!$this->checkLogin()){
            return $this->redirect('index/login');
        }

        $goodsid = $this->request->param('goodsid/d',0);


        $goods_info = $this->_goodsDomain->getEditGoodsInfo($goodsid,$this->getSellerId());


        $user_info = $this->getUserInfo();
        $type = $user_info['type'];

        $uDomain = new \app\api\domain\UDomain();
        $data = $uDomain->getDoctorOrHospitalList($user_info['user_id'],$type);

        $category = '';

        if(isset($goods_info['goods_category']) && count($goods_info['goods_category']) > 0){
            foreach ($goods_info['goods_category'] as $val){
                $category .= ','.$val['id'];
            }
        }


        $this->assign('doctorOrHospitalList',$data);
        $this->assign('info',$goods_info);
        $this->assign('category',$category);


        return $this->fetch('shop/addgood');
    }

    /**
     * 获取规格数据
     * @param Request $request
     * @return false|string
     */
    public function getGoodsData(Request $request){
        return $this->returnData([
            'rows'          =>0,
            'page'          =>1,
            'page_total'    =>0,
            'total'         =>0
        ],'','');
    }

    /**
     * 获取规格数据
     * @param Request $request
     * @return false|string
     */
    public function getSpecData(Request $request){
        $specDomain = new \app\api\domain\SpSpecDomian();
        $res = $specDomain->getSpecListData(0,1,15);

        return $this->returnData($res,'','');
    }

    /**
     * 规格添加窗口
     */
    public function specBox(){
        return $this->fetch('shop/specbox');
    }

    public function addSpec(Request $request){
        $data = [
            'name'=>$request->post('spec_name'),
            'type'=>$request->post('spec_type'),
            'value'=>$request->post('spec_val'),
            'remarks'=>$request->post('remarks'),
            'seller_id'=>0,
        ];
        $specDomain = new \app\api\domain\SpSpecDomian();
        $res = $specDomain->create($data);
        if($res){
            return $this->returnData([],'添加成功',200);
        }else{
            return $this->returnData([],'添加失败',305);
        }
    }

    /**
     *
     */
    public function goodsOrder(){
        return $this->fetch('shop/goodsorder');
    }
}