<?php
namespace app\api\controller;

use think\Request;
use think\facade\Log;


class Index extends BaseController
{

    public $weChatApiClass;

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

    public function test1(Request $request){
        return json(['error'=>'测试地址']);
    }
}