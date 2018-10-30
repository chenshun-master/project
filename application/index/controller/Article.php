<?php
namespace app\index\controller;
use think\App;
use think\Request;

class Article extends CController
{
    private $_articleDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_articleDomain = new \app\api\domain\ArticleDomain();
    }

    /**
     * 上传文章缩略图
     */
    public function uploadThumbnailImg(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $user_info = $this->getUserInfo();

        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }

        $file = request()->file("img");
        $img_domain = config('conf.file_save_domain');

        #文件上传类型
        $fileExt   = ['jpg','jpeg','png'];
        if($file){
            $size = 1024*1024*3;                                                    #单位字节
            if(!$file->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过3M',302);
            }

            if(!$file->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持jpg,jpeg及png格式的图片',303);
            }

            $info = $file->move( 'uploads/article');
            if($info){
                $path_dir = $img_domain.'/uploads/article/'.str_replace("\\","/",$info->getSaveName());
                return $this->returnData([
                    'image_url'=>$path_dir
                ],'图片上传成功',200);
            }else{
                return $this->returnData([],$file->getError(),305);
            }
        }
    }

    /**
     * 编辑器上传接口
     */
    public function editUpload(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $user_info = $this->getUserInfo();

        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
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

    /**
     * 发布文章接口
     */
    public function releaseArticle(Request $request){
//        if(!$this->checkLogin()){
//            return $this->returnData([],'请先进行登录',401);
//        }

//        $user_info = $this->getUserInfo();
//        if(!checkUserAuth($user_info['type'],7)){
//            return $this->returnData([],'未授权操作',403);
//        }

        $title = $request->param('title','');
        $tag = $request->param('tag','');
        $excerpt = $request->param('excerpt','');
        $content = $request->param('centent','');
        $published_time = $request->param('published_time','');
        $thumbnailImg = $request->param('thumbnail_img',[]);

        if(empty($title) || empty($tag) || empty($content)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $data = [
//            'user_id'=>$user_info['id'],
            'user_id'=>8,
            'type'=>1,
            'title'=>$title,
            'tag'=>$tag,
            'excerpt'=>'',
            'content'=>$content,
            'published_time'=>$published_time,
            'thumbnailImg'=>$thumbnailImg
        ];

        $isTrue = $this->_articleDomain->createArticle($data);
        if(!$isTrue){
            return $this->returnData([],'发布失败',305);
        }
        return $this->returnData([],'发布成功',200);
    }

    /**
     * 发布视频接口
     */
    public function releaseVideo(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $user_info = $this->getUserInfo();

        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }
    }

    /**
     * 发布案例接口
     */
    public function releaseCase(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }
        $user_info = $this->getUserInfo();

        if(!checkUserAuth($user_info['type'],8)){
            return $this->returnData([],'未授权操作',403);
        }
    }

    public function test(){
        return $this->fetch('article/test');
    }

}