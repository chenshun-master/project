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


    /**
     * 图片动态加载处理
     */
    public function imgLoading(){
//        $img = 'http://172.16.100.85/uploads/20181115/0877abd1182aade65258c892a8f2f4b7.jpg';
//
//        $image = \think\Image::open('D:\phpStudy\PHPTutorial\WWW\wl_project\public\uploads\20181116\2adbe7e8c1e572e80dbc1fd68201c969.jpg');
//        $image->thumb(300,148,1);
//        response()->data($image->save(null,null,90));

    }

    function showImg($img){
        $info = getimagesize($img);
        list($fw, $fh, $tmp) = getimagesize($img);

        $imgExt = image_type_to_extension($info[2], false); //获取文件后缀

        $fun = "imagecreatefrom{$imgExt}";

        $imgInfo = $fun($img);         //1.由文件或 URL 创建一个新图象。如:imagecreatefrompng ( string $filename )
//
//        header("Content-type: {$info['mime']}");
//
//        $quality = 100;
//        if($imgExt == 'png') $quality = 9;   //输出质量,JPEG格式(0-100),PNG格式(0-9)
//
//        $getImgInfo = "image{$imgExt}";
//
//
//        $timg = imagecreatetruecolor(50, 50);
//
//        imagecopyresampled($timg, $imgInfo, 0,0, 0,0, 50,50, $fw,$fh);
//
//
//        $getImgInfo($imgInfo, null, $quality);
//        imagedestroy($imgInfo);


//        $targ_w = $targ_h = 150; // 设置目标宽度与高度
//        $jpeg_quality = 100;  // 图片质量90，满分为100
//
//        $src = $img; // 被处理的图片
//        $img_r = imagecreatefromjpeg($src); // 获取原图
//        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h ); // 获取新图
//
//        imagecopyresampled($imgInfo,$img_r,0,0,100,50,$targ_w,$targ_h,100,50);
//        // 目标图 源图 目标X坐标点 目标Y坐标点 源的X坐标点 源的Y坐标点 目标宽度 目标高度 源图宽度 源图高度
//        header('Content-type: image/jpeg');
//        imagejpeg($imgInfo,null,$jpeg_quality); // 输出图象到浏览器或文件


    }

}