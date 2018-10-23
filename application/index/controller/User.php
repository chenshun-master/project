<?php
namespace app\index\controller;
use think\App;
use think\Request;

class User extends \app\index\controller\CController
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
    public function uploadThumbnailImg(){

    }

    /**
     * 上传视频接口
     */
    public function uploadVideo(){

    }

    /**
     * 发布文章接口
     */
    public function releaseArticle(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'请先进行登录',401);
        }

        $user_info = $this->getUserInfo();
        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }

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
            'user_id'=>$user_info['id'],
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


    }

    /**
     * 发布案例接口
     */
    public function releaseCase(){

    }

    public function test(){
        return $this->fetch('test');
    }



}