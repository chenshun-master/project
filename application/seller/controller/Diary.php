<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/7
 * Time: 11:41
 */

namespace app\seller\controller;


use think\App;
use app\api\domain\DiaryDomain;

class Diary extends BaseController
{

    private $_diaryDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_diaryDomain = new DiaryDomain();
    }

    public function index(){
        return $this->fetch('diary/index');
    }

    /**
     * 获取日记列表
     */
    public function getDiaryList(){
        $data = $this->_diaryDomain->getDiaryList($this->getUserId(),1,15);
        return $this->returnData($data);
    }

    public function createDiary(){
        return $this->fetch('diary/create-diary');
    }

    public function searchGoodsBox(){
        return $this->fetch('diary/search-goods-box');
    }

    /**
     * 日记详情
     */
    public function diaryDetail($id){
        $info = $this->_diaryDomain->getDiaryDetailList($this->getUserId(),$id);
        $this->assign('list',$info['rows']);
        $this->assign('diaryInfo',$info['diaryInfo']);
        $this->assign('goodsInfo',$info['goodsInfo']);
        $this->assign('diary_id',$id);
        return $this->fetch('diary/diary-detail');
    }

    /**
     * 编辑详情
     */
    public function editDiaryDetail(){
        $diaryId = $this->request->post('diary_id/d',0);
        $diaryDetailId      = $this->request->post('id/d',0);
        $day  = $this->request->post('day/d',0);
        $content  = $this->request->post('content','');
        $imgs     = $this->request->post('imgs/a',[]);

        if(empty($diaryId) || empty($content) || empty($imgs)){
            return $this->returnData([],'参数不符合规范',301);
        }

        $imgs = json_encode($imgs);
        if($diaryDetailId){
            list($isTrue,$msg,$data) = $this->_diaryDomain->editDiaryDetail($diaryId,$diaryDetailId,$this->getUserId(),['content'=>$content,'imgs'=>$imgs]);
        }else{
            list($isTrue,$msg,$data) = $this->_diaryDomain->addDiaryDetail($diaryId,$this->getUserId(),['diary_id'=>$diaryId,'user_id'=>$this->getUserId(),'content'=>$content,'imgs'=>$imgs,'day'=>$day]);
        }

        if($isTrue){
            return $this->returnData([],'添加或编辑成功',200);
        }
        return $this->returnData([],'添加或编辑失败',305);
    }

    /**
     * 上传日记图片接口
     */
    public function uploadImgFile(){
        $file = $this->request->file("imgFile");
        $img_domain = config('conf.file_save_domain');
        if(!$this->checkLogin()){
            return $this->returnData([],'未授予上传权限',401);
        }

        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];
        if($file){
            $size = 1024*1024*5;              #单位字节
            if(!$file->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过5M',305);
            }

            if(!$file->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持gif,jpg,jpeg及png格式的图片',305);
            }

            $info = $file->move( '../uploads/case');
            if($info){
                $path_dir = $img_domain.'/case/'.str_replace("\\","/",$info->getSaveName());
                $id = (new \app\api\domain\PictureLibraryDomain())->create(2,$path_dir);
                if($id){
                    return $this->returnData(['url'=>$path_dir],'',200);
                }else{
                    return $this->returnData([],'上传失败',305);
                }
            }else{
                return $this->returnData([],$file->getError(),305);
            }
        }
    }

    /**
     * 添加案例
     */
    public function addDiary(){
        $title  = $this->request->post('title','');
        $ids    = $this->request->post('ids/a',[]);
        $imgs   = $this->request->post('imgs/a',[]);

        if(empty($title) || empty($ids) || empty($imgs)){
            return $this->returnData([],'参数不符合规范',301);
        }

        $isTrue = $this->_diaryDomain->addDiary([
            'user_id'      =>$this->getUserId(),
            'goods_ids'    =>implode(',',$ids),
            'title'        =>$title,
            'before_imgs'  =>json_encode($imgs),
            'created_time' =>date('Y-m-d H:i:s'),
            'updated_time' =>date('Y-m-d H:i:s'),
        ]);

        if($isTrue){
            return $this->returnData([],'添加成功',200);
        }

        return $this->returnData([],'添加失败',305);
    }
}