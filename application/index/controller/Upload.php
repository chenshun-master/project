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

            $info = $file->move( '../uploads/article');
            if($info){
                $path_dir = $img_domain.'/article/'.str_replace("\\","/",$info->getSaveName());
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

            $info = $file->move( '../uploads/article');
            if($info){
                $path_dir = $img_domain.'/article/'.str_replace("\\","/",$info->getSaveName());
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
     * 图片统一上传文件接口
     */
    public function uploadAuthFile(Request $request){
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

            try {
                $image = \think\Image::open($file);
                $path = '../uploads/auth/'.date('Ymd');
                $save_path = 'auth/'.date('Ymd');
                $filename = date('His').uniqid().uniqid().'.jpeg';
                @mkdir($path, 0755, true);
                $image->save("{$path}/{$filename}");
                $url = "{$img_domain}/{$save_path}/{$filename}";
                $id = (new \app\api\domain\PictureLibraryDomain())->create($type,$url);
                if($id){
                    return $this->returnData(['url'=>$url],'',200);
                }else{
                    return $this->returnData([],'上传失败',305);
                }
            } catch (\Exception $e) {
                return $this->returnData([],'文件上传失败',305);
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



    public function uploadFile(Request $request){
        if(!$this->checkLogin()){
            return json(array('errno' => 401, 'message' =>'未授予上传权限'));
        }

        $files = $request->file();

        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];

        $img_domain = config('conf.file_save_domain');

        $size = 1024*1024*3;              #单位字节
        $data = [];
        if($files){
            foreach ($files as $fileName=>$file){
                if(!$file->checkSize($size)){
                    return json(['errno' => 301, 'message' =>"{$fileName} 图片大小不能超过3M"]);
                }

                if(!$file->checkExt($fileExt)){
                    return json(['errno' => 302, 'message' =>'文件格式错误只支持gif,jpg,jpeg及png格式的图片']);
                }
            }

            foreach ($files as $fileName=>$file){
                if(!$file->checkSize($size)){
                    return json(['errno' => 301, 'message' =>"{$fileName} 图片大小不能超过3M"]);
                }

                if(!$file->checkExt($fileExt)){
                    return json(['errno' => 302, 'message' =>'文件格式错误只支持gif,jpg,jpeg及png格式的图片']);
                }

                $info = $file->move( '../uploads/article');
                if($info){
                    $path_dir = $img_domain.'/article/'.str_replace("\\","/",$info->getSaveName());
                    $getId = $this->_pictureLibraryDomain->create(5,$path_dir);
                    if($getId){
                        $data[] = $path_dir;
                    }
                }
            }
            return json(['errno' => 0, 'data' =>$data]);
        }
    }
}