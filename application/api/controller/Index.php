<?php
namespace app\api\controller;

use think\Request;

class Index extends BaseController
{
    /**
     * 微信公众号消息推送接口
     * @return mixed
     */
    public function message(){
        $this->weChatApiClass 	= new \wechat\WeChatApi();

        if(isset($_GET["echostr"])){
            $this->weChatApiClass->valid();
        }else if($this->weChatApiClass->checkSignature()){
            $content = Request::getContent();
            return $this->weChatApiClass->responseMsg();
        }
    }
}
