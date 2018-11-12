<?php
namespace wechat;

/**
 * 微信网页jssdk配置类
 * Class WeChatJsSDK
 */
class WeChatJsSDK {

    private $appId;
    private $appSecret;

    public function __construct($appId='', $appSecret='') {
        if(!empty($appId) && !empty($appSecret)){
            $this->appId = $appId;
            $this->appSecret = $appSecret;
        }
    }

    /**
     * 生成微信jssdk配置信息
     * @return array
     */
    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        //签名
        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    /**
     * 生成签名的随机串
     * @param int $length
     * @return string
     */
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        $accessToken = $this->getAccessToken();
        // 如果是企业号用以下 URL 获取 ticket
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$accessToken}";
        $res = json_decode($this->httpGet($url),true);

        if($res && $res['errcode'] == 0){
            return $res['ticket'];
        }else{
            return '';
        }
    }

    /**
     * 获取微信
     * @return mixed
     */
    private function getAccessToken() {
        $weChatApi_model = new WeChatApi();
        $accessToken = $weChatApi_model->getAccessToken();
        return $accessToken;
    }

    /**
     * 微信请求
     * @param $url
     * @return mixed
     */
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);

        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * 获取缓存的JsApiTicket数据
     */
    private function getCaCheJsApiTicket(){

    }

    /**
     * 设置缓存的JsApiTicket数据
     */
    private function setCaCheJsApiTicket(){

    }
}
