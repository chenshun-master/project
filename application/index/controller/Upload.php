<?php
namespace app\index\controller;

class Upload extends CController
{

    /**
     * 编辑器上传文件
     */
    public function uploadFile(){
        $file = request()->file("imgFile");

        $img_domain = config('conf.file_save_domain');
        if(!$this->checkLogin()){
//            return json(array('error' => 1, 'message' =>'未授予上传权限'));
        }

        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png', 'bmp'];
        if($file){
            $size = 1024*1024*5;              #单位字节
            if(!$file->checkSize($size)){
                return json(['error' => 1, 'message' =>'上传图片大小不能超过5M']);
            }

            if(!$file->checkExt($fileExt)){
                return json(['error' => 1, 'message' =>'文件格式错误只支持gif,jpg,jpeg,png及bmp格式的图片']);
            }

            $info = $file->move( 'uploads/article');
            if($info){
                $path_dir = $img_domain.'/uploads/article/'.str_replace("\\","/",$info->getSaveName());
                return json(array('error' => 0, 'url' => $path_dir));
            }else{
                return json(array('error' => 1, 'message' => $file->getError()));
            }
        }
    }

}