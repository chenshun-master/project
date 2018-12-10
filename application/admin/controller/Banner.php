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

    public function index($page_size = 10)
    {
        $res = Db::name('sp_banner')->where('is_del',0)->order('id desc')->paginate($page_size);
        $page = $res->render();
        $this->assign('page',$page);
        $this->assign('res',$res);
        return $this->fetch('/banner/index');
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
        $result = Db::name('sp_banner')->where('id', $data['id'])->update(['visibility' => $data['visibility']]);
        if($result){
            $this->redirect('/admin/banner/index');
        }else{
            $this->error('修改失败', cookie("prevUrl"));
        }
    }
    /**
     * 删除banner
     */
    public function del()
    {
        $id = input('param.id');
        $result = $this->BannerDomain->delete($id);
        if($result){
            $this->redirect('/admin/banner/index');
        }else{
            $this->error('删除失败', cookie("prevUrl"));
        }
    }
}
