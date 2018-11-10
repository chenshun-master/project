<?php
namespace app\index\controller;

use app\api\domain\PictureLibraryDomain;
use think\Request;


class Upload extends CController
{

    private $_pictureLibraryDomain;


    public function initialize()
    {
       $this->_pictureLibraryDomain = new PictureLibraryDomain();
    }


    /**
     * 编辑器单文件上传
     */
    public function editUploadImgFile(Request $request){
        $file = $request->file("imgFile");
        $type = 5;

        $img_domain = config('conf.file_save_domain');
        if(!$this->checkLogin()){
            return json(array('error' => 1, 'message' =>'未授予上传权限'));
        }

        if($type == 0){
            return json(array('error' => 1, 'message' =>'请求参数不符合规范'));
        }

        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];
        if($file){
            $size = 1024*1024*5;              #单位字节
            if(!$file->checkSize($size)){
                return json(['error' => 1, 'message' =>'上传图片大小不能超过5M']);
            }

            if(!$file->checkExt($fileExt)){
                return json(['error' => 1, 'message' =>'文件格式错误只支持gif,jpg,jpeg及png格式的图片']);
            }

            $info = $file->move( 'uploads/');
            if($info){
                $path_dir = $img_domain.'/uploads/'.str_replace("\\","/",$info->getSaveName());
                $id = $this->_pictureLibraryDomain->create($type,$path_dir);
                if($id){
                    return json(array('error' => 0, 'url' => $path_dir));
                }else{
                    return json(array('error' => 1, 'message' => '上传失败'));
                }
            }else{
                return json(array('error' => 1, 'message' => $file->getError()));
            }
        }
    }


    /**
     * 图片统一上传文件接口
     */
    public function uploadImgFile(Request $request){
        $file = $request->file("imgFile");
        $type = (int)$request->param('type');

        $img_domain = config('conf.file_save_domain');
        if(!$this->checkLogin()){
            return $this->returnData([],'未授予上传权限',401);
        }

        if($type == 0){
            return $this->returnData([],'请求参数不符合规范',301);
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

            $info = $file->move( 'uploads/');
            if($info){
                $path_dir = $img_domain.'/uploads/'.str_replace("\\","/",$info->getSaveName());
                $id = $this->_pictureLibraryDomain->create($type,$path_dir);
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
     * 上传视频接口
     */
    public function uploadVideo(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $user_info = $this->getUserInfo();

        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }
    }
}