<?php
namespace app\admin\controller;

use app\api\domain\BannerDomain;
use app\api\model\BannerModel;
use think\App;
use think\Db;
use think\Request;

class Banner extends BaseController{

    private $BannerDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->BannerDomain = new BannerDomain();
    }

    public function index()
    {
        return $this->fetch('/banner/index');
    }

    public function getBannerList()
    {
        $banner = new BannerModel();
        $data = $banner->getList(1,10);
        return $this->returnData($data,'',0);
    }
    /**
     * 发布/修改banner
     */
    public function addBanner(Request $request)
    {
        if(request()->isPost()){
            $id = $request->post('id');
            $name = $request->post('name');
            $url  = $request->post('url');
            $order  = $request->post('order');
            $platform  = $request->post('platform');
            $img    = $request->file('img');
            $img_domain = config('conf.file_save_domain');
            if (empty($img)) {
                $this->error('请选择上传文件');
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
                return $this->returnData([],'请上传文件',302);
            }
        }else{
            $id = input('param.id');
            $res = BannerModel::findOne($id);
            $this->assign('res',$res);
            return $this->fetch('/banner/add');
        }
    }
    /**
     * 是否推送到首页
     */
    public function update()
    {
        $data = input('param.');
        if($data['visibility'] == 0){
            $result = Db::name('sp_banner')->where('id', $data['id'])->update(['visibility' => 1]);
        }else{
            $result = Db::name('sp_banner')->where('id', $data['id'])->update(['visibility' => 0]);
        }
        if($result){
            return $this->returnData([],'修改成功','200');
        }else{
            return $this->returnData([],'修改失败','301');
        }
    }
    /**
     * 删除banner
     */
    public function del()
    {
        $id = $this->request->post('id');
        $result = $this->BannerDomain->delete($id);
        if($result){
            return $this->returnData([],'删除成功',200);
        }else{
            return $this->returnData([],'删除失败',301);
        }
    }
}
