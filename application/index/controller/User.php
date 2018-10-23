<?php
namespace app\index\controller;


class User extends \app\index\controller\CController
{

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
    public function releaseArticle(){
        if(!$this->checkLogin()){
            return $this->returnData([],'请先进行登录',401);
        }

        $user_info = $this->getUserInfo();
        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }

        $title = $request->param('title','');
        $tag = $request->param('tag','');
        $content = $request->param('centet','');
        $published_time = $request->param('published_time','');
        $thumbnailImg = $request->param('thumbnail_img',[]);

        if(empty($title) || empty($tag) || empty($content)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        
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



}