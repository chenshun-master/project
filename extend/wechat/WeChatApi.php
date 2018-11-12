<?php
namespace wechat;

/**
 * Class WeChatApi  微信接口Api
 */
class WeChatApi{

    public $appId;
    public $appsecret;
    public $token;
    protected $wxTokenModel;

    use WxTrait;

    public function __construct(){
        $config             = config('conf.sns_login.weixin');
        $this->appId        = $config['app_id'];
        $this->appsecret    = $config['app_secret'];
        $this->token        = $config['token'];

        $this->wxTokenModel = new \app\api\model\WxTokenModel();
    }

    /**
     * 验证微信签名
     */
    public function checkSignature()
    {
        $signature      = isset($_REQUEST["signature"])?$_REQUEST["signature"]:'';
        $timestamp      = isset($_REQUEST["timestamp"])?$_REQUEST["timestamp"]:'';
        $nonce          = isset($_REQUEST["nonce"])?$_REQUEST["nonce"]:'';
        
        $tmpArr = array($this->token, $timestamp, $nonce);

        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        return ( $tmpStr == $signature ) ? true : false;
    }

    /**
     * 微信服务器消息验证
     */
    public function valid()
    {
        $echoStr = isset($_GET["echostr"])?$_GET["echostr"]:'';

        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    /**
     * 获取微信 普通access_token
     * @return string access_token
     */
    public function getAccessToken() {
        $access_token = '';
        $res = $this->wxTokenModel->findAccessToekn($this->appId);
        if($res && $res['expiry_time'] > date('Y-m-d H:i:s')){
            $access_token = $res['access_token'];
        }else{
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appId . '&secret=' . $this->appsecret;
            $res = $this->httpGet($url);
            $resarr = json_decode($res, true);
            if(!$this->CheckError($resarr)){
                $time = time();
                $expiry_time = date('Y-m-d H:i:s',(time() + $resarr['expires_in'] - 100));
                $createRes = $this->wxTokenModel->createToken([
                    'app_id'        =>  $this->appId,
                    'access_token'  =>  $resarr['access_token'],
                    'expiry_time'   =>  $expiry_time,
                    'created_at'    =>  date('Y-m-d H:i:s')
                ]);

                $access_token = $resarr['access_token'];
            }else{
                return $resarr;
            }
        }

        return $access_token;
    }

    /**
    *  重定向到用户的授权路径获取code 地址
    * @param $redir                 授权url
    * @param null $state
    * @param bool $snsapi_userinfo  授权方式（true:用户点击的方式授权，false:静默授权不需要用户的同意）
    */
    public function getWeChatAuthCode($redir, $state = null, $snsapi_userinfo = true){

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize";
        $scope = $snsapi_userinfo ? 'snsapi_userinfo' : 'snsapi_base';
        $paramArr = array(
            'appid' => $this->appId,
            'redirect_uri' => $redir,
            'response_type' => 'code',
            'scope' => $scope,
            'state' => isset($state) ? $state : '',
        );

        $param = http_build_query($paramArr);

        $fullURL = "$url?$param#wechat_redirect";

        return $fullURL;
    }

    /**
     * 通过授权的code获取网页授权access_token
     * @param $code
     * @return bool|mixed
     */
    public function getUserAuthorizeAccessToken($code) {
        if($code) {
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token";

            $paramArr = array(
                'appid' => $this->appId,
                'secret' => $this->appsecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
            );

            $param = http_build_query($paramArr);

            $fullURL = "$url?$param";
            $result = $this->httpGet($fullURL);
            $resultJSON = json_decode($result, TRUE);
            return $resultJSON;
        }

        return false;
    }

    /**
     * 刷新用户网页授权access token
     * @param type $refresh_token
     * @return boolean
     */
    public function refreshUserAuthorizeAccessToken($refresh_token) {
        $appid = $this->appId;
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$appid&grant_type=refresh_token&refresh_token=$refresh_token";
        $result = $this->httpGet($url);
        $resultJSON = json_decode($result, true);

        return $resultJSON;
    }

    /**
     * 通过用户授权网页access_token和用户的公众号openid 获取用户微信信息
     * @param $authAccessToken  网页用户授权access_token
     * @param $openid
     * @return mixed
     */
    public function getUserAuthorizedUserInfo($authAccessToken, $openid) {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$authAccessToken&openid=$openid&lang=zh_CN";
        $result = $this->httpGet($url);
        $resultJSON = json_decode($result, true);

        return $resultJSON;
    }

    /**
     * 检验用户网页授权凭证（access_token）是否有效
     * @param type $authAccessToken
     * @param type $openid
     * @return type
     */
    public function getUserAuthorizeAccessTokenValid($authAccessToken, $openid) {
        $url = "https://api.weixin.qq.com/sns/auth?access_token=$authAccessToken&openid=$openid";
        $result = $this->httpGet($url);
        $resultJSON = json_decode($result, true);
        if($resultJSON && !empty($resultJSON) && $resultJSON['errcode'] === 0){
            return true;
        }

        return false;
    }
    
    /**
     * 通过用户关注的openid获取用户微信信息
     * @param [string] $[access_token] [微信公众号接口凭证]
     * @param [string] $[openid]       [关注公众号的openid]
     */
    public function getPublicNumberUserInfo($access_token,$openid){
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $result = $this->httpGet($url);
        $resultJSON = json_decode($result, true);

        return $resultJSON;
    }

    /**
     * 获取微信服务器IP地址
     */
    public function getWeChatIp(){
        $access_token = $this->asdf;
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token='.$access_token;
        $rs = $this->httpGet($url);
        return json_decode($rs, true);
    }
    
    /**
     * 自定义菜单查询接口
     * @return type
     */
    public function getMenu(){
        $access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=' . $access_token;
        $rs = $this->httpGet($url);

        #正确时的返回JSON数据包如下： {"errcode":0,"errmsg":"ok"}
        #错误时的返回JSON数据包如下（示例为无效菜单名长度）：  {"errcode":40018,"errmsg":"invalid button name size"}
        return $rs;
    }
    
    /**
     * 更新微信公众号菜单方法
     * @param null $menuJsonStr  微信菜单数据
     * @return mixed
     */
    public function updateMenu($menuJsonStr = null) {
        $access_token = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token;
        $rs = $this->httpGet($url, $menuJsonStr);
        #正确时的返回JSON数据包如下： {"errcode":0,"errmsg":"ok"}
        #错误时的返回JSON数据包如下（示例为无效菜单名长度）：  {"errcode":40018,"errmsg":"invalid button name size"}
        return json_decode($rs, true);
    }

    /**
     * 微信 自定义菜单删除接口
     */
    public function delWeChatMenu(){
        $access_token = $this->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$access_token;
        $rs = $this->httpGet($url);
        return json_decode($rs, true);
    }

    /**
     * 微信用户反馈信息方法
     */
    public function responseMsg(){
        $rs = 'success';
        $weiChatNews_model = new WeChatNews();
        $obj = $weiChatNews_model->getXmlMsg();
        if($obj){
            # 获取消息类型
            # text:文本,image:图片,news:图文消息,voice:语音,video:视频,music:背景音乐,link:链接
            # event:事件[包括 subscribe:订阅,unsubscribe:取消订阅,click:点击事件,view:跳转网址],location:地理位置,
            $msgType = trim($obj->MsgType);

            $tip = '|||事件类型：'.$msgType;
            if(strcasecmp($msgType, 'event') == 0){
                $event = isset($obj->Event) ? $obj->Event : '';
                if (isset($event) && !empty($event)) {
                    $tip .= " 事件名称：「${event}」\r\n";
                }
                $eventKey = isset($obj->EventKey) ? $obj->EventKey : '';
                if (isset($eventKey) && !empty($eventKey)) {
                    $tip .= " 事件键名：「${eventKey}」\r\n";
                }
            }

            recordLog(1,$tip);

            $function = 'send'.ucfirst($msgType);

            $rs = $weiChatNews_model->$function($obj);
        }
        
        return $rs;
        $weiChatNews_model->printContent($rs);
    }

    /**
     * 添加微信客服帐号
     * POST数据示例如下： {"kf_account" : "test1@test","nickname" : "客服1","password" : "pswmd5"}
     */
    public function setWeChatCustomService($data){
        $accessToken = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token='.$accessToken;
        $rs = $this->httpGet($url,json_encode($data));
        return json_decode($rs, true);
    }

    /**
     * 修改微信客服帐号
     * POST数据示例如下： {"kf_account" : "test1@test","nickname" : "客服1","password" : "pswmd5"}
     */
    public function changeWeChatCustomService($data){
        $accessToken = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token='.$accessToken;
        $rs = $this->httpGet($url,json_encode($data));
        return json_decode($rs, true);
    }

    /**
     * 删除指定微信客服帐号
     */
    public function delWeChatCustomService(){
        $accessToken = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token='.$accessToken;
        $rs = $this->httpGet($url,json_encode($data));
        return json_decode($rs, true);
    }

    /**
     * 设置指定微信客服帐号的头像
     */
    public function setWeChatCustomServicePortrait($kf_account,$file_path){
        if (file_exists($file_path)) {
            $accessToken = $this->getAccessToken();
            $url = "http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token={$accessToken}&kf_account={$kf_account}";
            $data = array('media' => new CURLFile($file_path));
            $result = $this->httpGet($url,$data);
            $resultJSON = json_decode($result, true);
            return $resultJSON;
        } else {
            return false;
        }
    }

    /**
     * 获取所有客服账号列表
     */
    public function getWeChatCustomServiceList(){
        $accessToken = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token='.$accessToken;
        $rs = $this->httpGet($url,json_encode($data));
        return json_decode($rs, true);
    }

    /**
     * 获取关注公众号的openid列表
     * @param string $next_openid  第一个拉取的OPENID，不填默认从头开始拉取
     * (附：关注者数量超过10000时
     *  当公众号关注者数量超过10000时，可通过填写next_openid的值，从而多次拉取列表的方式来满足需求。
     *  具体而言，就是在调用接口时，将上一次调用得到的返回中的next_openid值，作为下一次调用中的next_openid值。
     * )
     * @return boolean
     */
    public function getUserAuthList($next_openid){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$next_openid";
        $result = $this->httpGet($url);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 创建公众号标签
     * @param string 标签数据包 例如：{"tag" : {"name" : "广东"}}
     * @return mixed
     */
    public function createPublicSignTag($data){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token=$access_token";
        $result = $this->httpGet($url,$data);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 编辑公众号标签
     * @param string 标签数据包 例如：{"tag" : {"id" : 134,"name" : "广东人"}}
     * @return mixed
     */
    public function editPublicSignTag($data){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/update?access_token=$access_token";
        $result = $this->httpGet($url,$data);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 删除公众号标签
     * @param string 标签数据包 例如：{"tag":{"id" : 134}}
     * @return mixed
     */
    public function deletePublicSignTag($data){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=$access_token";
        $result = $this->httpGet($url,$data);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 获取公众号标签
     * @return mixed
     */
    public function getPublicSignTagList(){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$access_token";
        $result = $this->httpGet($url);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 上传永久的图文消息的图片/音频/视频等到微信公众平台服务器后返回的URL地址
     * @param string $file_path   待上传的文件绝对路径(包括文件名及扩展名)
     * @return string   获取上传到微信公众平台服务器上文件的URL地址
     */
    public function uploadFileToWechatServer($file_path) {
        if (file_exists($file_path)) {
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token={$access_token}";
            $data = array('media' => new CURLFile($file_path));
            $result = $this->httpGet($url,$data);
            $resultJSON = json_decode($result, true);
            return $resultJSON;
        } else {
            return false;
        }
    }

    /**
     * 微信 新增临时素材
     * @param string $file_path   待上传的文件绝对路径(包括文件名及扩展名)
     * @return array 请求返回结果
     */
    public function uploadTemporaryMaterial($file_path,$type = 'image') {
        if (file_exists($file_path)) {
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$type}";
            $data = array('media' => new CURLFile($file_path));
            $result = $this->httpGet($url,$data);
            $resultJSON = json_decode($result, true);
            return $resultJSON;
        } else {
            return false;
        }
    }

    /**
     * 上传图文消息素材
     */
    public function uploadTuwenMaterial(){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token={$access_token}";
        $data = '{
            "articles": [
                 {
                     "thumb_media_id":"wE56cBChXspzKU1hIGCdtiqqC8rZCevbXnP0AldLb7vUU8rSAWDK9F-nZ3bMox8y",
                     "author":"xxx",
                     "title":"Happy Day",
                     "content_source_url":"www.qq.com",
                     "content":"content",
                     "digest":"digest",
                     "show_cover_pic":1
                 },
                 {
                     "thumb_media_id":"wE56cBChXspzKU1hIGCdtiqqC8rZCevbXnP0AldLb7vUU8rSAWDK9F-nZ3bMox8y",
                     "author":"xxx",
                     "title":"Happy Day",
                     "content_source_url":"www.qq.com",
                     "content":"content",
                     "digest":"digest",
                     "show_cover_pic":0
                 }
            ]
        }';
        $result = $this->httpGet($url,$data);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 图文消息群发接口
     */
    public function massblog(){
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$access_token";
        $data = '{
           "touser":[
            "oeVqlwqkUGk0tFCn9NWqQHbqm7SQ",
            "oeVqlwrfIpOkXXZqT4XuEz-dHWMQ",
           ],
           "mpnews":{
              "media_id":"yjsZg5TdgTppbith_ptlYdqtJ4aQBhDOACQuJYwicQ_wpUbaFh5IyG_BY7NqGN2-"
           },
           "msgtype":"image",
        }';

        $result = $this->httpGet($url,$data);
        $resultJSON = json_decode($result, true);
        return $resultJSON;
    }

    /**
     * 发送模版消息
     * @param type $openid  用户的openid
     * @param type $template_id e.g. zlXt5_zDAIrjzLdHLSXG9o3MiqdENB6juZUpo67RvhI  模板id
     * @param type $data e.g. ['first' => ['value' => '恭喜你购买成功!', 'color' => '#173177'] 'keynote1' => ['value' => '巧克力', 'color' => '#173177'], 'keynote1' => ..., 'remark' => ['value'=> '欢迎再次购买！', 'color'=>'#173177']]
     * @param type $clickurl e.g. http://weixin.haolyy.com/User
     * @return type
     */
    public function sendTemplateMsg($openid, $template_id, $data, $clickurl) {
        if($openid && $template_id && $data) {
            $access_token = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
            $postData = array(
                'touser' => $openid,
                'template_id' => $template_id,
                'url' => $clickurl,
                'data' => $data,
            );
            $result = $this->httpGet($url, json_encode($postData, JSON_UNESCAPED_UNICODE));
            $resultJSON = json_decode($result, true);
            return $resultJSON;
        }
    }

    /**
     * 请求微信服务器方法
     * @param $url 请求地址
     * @param null $postData 请求参数
     * @return mixed
     */
    public function httpGet($url, $postData = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, $url);

        if($postData !== null) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * URL重定向
     * @param string $url 重定向的URL地址
     * @param integer $time 重定向的等待时间（秒）
     * @param string $msg 重定向前的提示信息
     * @return void
     */
    public function redirect($url, $time=0, $msg='') {
        //多行URL地址支持
        $url        = str_replace(array("\n", "\r"), '', $url);
        if (empty($msg))
            $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
        if (!headers_sent()) {
            // redirect
            if (0 === $time) {
                header('Location: ' . $url);
            } else {
                header("refresh:{$time};url={$url}");
                echo($msg);
            }
            exit();
        } else {
            $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
            if ($time != 0)
                $str .= $msg;
            exit($str);
        }
    }
}