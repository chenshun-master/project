<?php
namespace sms;

class ChuangRuiSms
{
    #短信平台请求地址
    const APIURL = [
        'single_send' =>'http://api.1cloudsp.com/api/v2/single_send',           #验证码短信发送接口
    ];

    #平台分配给用户的accesskey，登录系统首页可点击"我的秘钥"查看
    private $accesskey  ='tc5IGYXbdEVYxiBF';

    #平台分配给用户的secret，登录系统首页可点击"我的秘钥"查看
    private $secret     ='wGHWNHvMrjUGMsSVR324ug8rJ8UdWBAj';

    /**
     * @param $url    请求链接
     * @param $body   post数据
     * @param $method post或get
     * @return mixed|string
     */

    private function request($url, $body,$method)
    {
        if (function_exists("curl_init")) {
            $header = array(
                'Accept:application/json',
                'Content-Type:application/json;charset=utf-8',
            );
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            if($method == 'post'){
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$body);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $opts = array();
            $opts['http'] = array();
            $headers = array(
                "method" => strtoupper($method),
            );
            $headers[]= 'Accept:application/json';
            $headers['header'] = array();
            $headers['header'][]= 'Content-Type:application/json;charset=utf-8';
            if(!empty($body)) {
                $headers['header'][]= 'Content-Length:'.strlen($body);
                $headers['content']= $body;
            }
            $opts['http'] = $headers;
            $result = file_get_contents($url, false, stream_context_create($opts));
        }
        return $result;
    }

    /**
     * 验证码短信发送接口
     * @param $sign             平台上申请的接口短信签名或者签名ID（须审核通过），采用utf8编码
     * @param $templateId       平台上申请的接口短信模板Id（须审核通过）
     * @param $mobile           接收短信的手机号码(只支持单个手机号)
     * @param $content          发送的短信内容是模板变量内容，多个变量中间用##或者$$隔开，采用utf8编码
     * @return mixed|string
     */
    public function SendSms($sign,$templateId,$mobile,$content){
        $body = array(
            'accesskey'         =>$this->accesskey,
            'secret'            =>$this->secret,
            'sign'              =>$sign,
            'templateId'        =>$templateId,
            'mobile'            =>$mobile,
            'content'           =>$content,
            'data'              =>'',
            'scheduleSendTime'  =>''
        );

        $result = $this->request(self::APIURL['single_send'], json_encode($body),'post');
        if(empty($result)){
            return false;
        }

        $arr = json_decode($result,true);

        if($arr['code'] !== 0){
            return false;
        }

        return true;
    }

}