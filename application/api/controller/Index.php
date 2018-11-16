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

//        $image = \think\Image::open($img);

        $this->showImg($img);
    }

    function showImg($img){
        $info = getimagesize($img);
        $imgExt = image_type_to_extension($info[2], false); //获取文件后缀
        $fun = "imagecreatefrom{$imgExt}";
        $imgInfo = $fun($img);         //1.由文件或 URL 创建一个新图象。如:imagecreatefrompng ( string $filename )
        //$mime = $info['mime'];
//        $mime = image_type_to_mime_type(exif_imagetype($img)); //获取图片的 MIME 类型
        header("Content-type: image/jpeg");
        $quality = 100;
        if($imgExt == 'png') $quality = 9;   //输出质量,JPEG格式(0-100),PNG格式(0-9)
        $getImgInfo = "image{$imgExt}";
        $getImgInfo($imgInfo, null, $quality); //2.将图像输出到浏览器或文件。如: imagepng ( resource $image )
        imagedestroy($imgInfo);
    }



}