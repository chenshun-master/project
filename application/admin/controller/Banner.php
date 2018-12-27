<?php
namespace app\admin\controller;

use app\api\domain\BannerDomain;
use app\api\model\BannerModel;
use think\App;
use think\Db;
use think\Request;

class Banner extends BaseController{

    private $_bannerDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_bannerDomain = new BannerDomain();
    }

    public function index()
    {
        return $this->fetch('/banner/index');
    }

    /**
     * 轮播图 列表
     * @param $page
     * @param $page_size
     * @return false|string
     */
    public function getBannerList($page=1,$page_size=10)
    {
        $data = $this->_bannerDomain->getBannerList($page,$page_size);
        return $this->returnData($data,'',200);
    }
    /**
     * 新增轮播图页面
     */
    public function addBanner(){
        $id = input('param.id');
        $res = BannerModel::findOne($id);
        $this->assign('res',$res);
        return $this->fetch('/banner/add');
    }

    /**
     * 发布/修改轮播图
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function releaseBanner(Request $request)
    {
        $id = $request->post('id');
        $name = $request->post('name');
        $url  = $request->post('url');
        $order  = $request->post('order');
        $platform  = $request->post('platform');
        $img    = $request->file('img');
        $img_domain = config('conf.file_save_domain');
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];
        if($img){
            $size = 1024*1024*5;              #单位字节
            if(!$img->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过5M',305);
            }
            if(!$img->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持gif,jpg,jpeg及png格式的图片',305);
            }
            $info = $img->move( '../uploads/');
            if($info){
                $path_dir =$img_domain.'/uploads/'.str_replace("\\","/",$info->getSaveName());
                $data = [
                    'name' => $name,
                    'url'  => $url,
                    'img'  => $path_dir,
                    'order'=> $order,
                    'platform'=>$platform
                ];
                if($id) {
                    $result = Db::name('sp_banner')->where('id',$id)->update($data);
                }else{
                    $result = Db::name('sp_banner')->insert($data);
                }
                if($result){
                    return $this->returnData([],'添加成功',200);
                }else{
                    return $this->returnData([],'添加失败',301);
                }
            }else{
                return $this->returnData([],$img->getError(),302);
            }
        }
    }
    /**
     * 是否推送到首页
     */
    public function update()
    {
        $id  = $this->request->post('id');
        $visibility = $this->request->post('visibility');
        if($visibility == 0){
            $result = Db::name('sp_banner')->where('id', $id)->update(['visibility' => 1]);
        }else{
            $result = Db::name('sp_banner')->where('id', $id)->update(['visibility' => 0]);
        }
        if($result){
            return $this->returnData([],'修改成功','200');
        }else{
            return $this->returnData([],'修改失败','301');
        }
    }
    /**
     * 删除轮播图
     */
    public function del()
    {
        $id = $this->request->post('id');
        $result = $this->_bannerDomain->delete($id);
        if($result){
            return $this->returnData([],'删除成功',200);
        }else{
            return $this->returnData([],'删除失败',301);
        }
    }
}
