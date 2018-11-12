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

        Log::record('测试按会计师带你飞 卡十多年放假 开讲啦是的那就发');
        if(isset($_GET["echostr"])){
            $this->weChatApiClass->valid();
        }else if($this->weChatApiClass->checkSignature()){
            $content = \Request::getContent();

            Log::record('公众号推送消息 ====>'.$content);
            return $this->weChatApiClass->responseMsg();
        }
    }
}
