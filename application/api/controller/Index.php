<?php
namespace app\api\controller;

use think\Request;
use think\facade\Log;


class Index extends BaseController
{

    /**
     * 微信公众号消息推送接口
     * @return mixed
     */
    public function message(){
        $this->weChatApiClass   = new \wechat\WeChatApi();

        if(isset($_GET["echostr"])){
            $this->weChatApiClass->valid();
        }else if($this->weChatApiClass->checkSignature()){
            $content = \Request::getContent();

            Log::record('公众号推送消息 ====>'.$content);
            return $this->weChatApiClass->responseMsg();
        }
    }


    /**
     * 图片动态加载处理
     */
    public function imgLoading(){
        $img = 'http://172.16.100.85/uploads/20181115/0877abd1182aade65258c892a8f2f4b7.jpg';

        $image = \think\Image::open($img);
    }



}