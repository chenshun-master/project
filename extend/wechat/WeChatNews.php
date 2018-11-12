<?php
namespace wechat;

/**
 * 微信反馈信息处理类
 * Class WeChatNews
 */
class WeChatNews{

    /**
     * 微信端事件推送
     */
    public function sendEvent($obj){
        # event:事件[包括 subscribe:订阅,unsubscribe:取消订阅,click:点击事件,view:跳转网址],location:地理位置,
        $event = trim($obj->MsgType);

        $content = '';
        if(strcasecmp($event, 'event') == 0){
            switch (strtolower($obj->Event)) {
                case "subscribe":
                    $content = "已关注微信";
                    break;
                case "unsubscribe":
                    $content = "取消微信关注";
                    break;
                case "click":
                    switch (strtolower($obj->EventKey)) {
                        case "news":

                            break;

                        default:
                            $content = "点击菜单：" . $obj->EventKey;
                            break;
                    }
                    break;
                case "view":

                    break;
                case "scan":

                    break;
                case "location":
                    $content = "上传位置：纬度 " . $obj->Latitude . ";经度 " . $obj->Longitude;
                    break;
                case "scancode_waitmsg":
                    if ($obj->ScanCodeInfo->ScanType == "qrcode") {
                        $content = "扫码带提示：类型 二维码 结果：" . $obj->ScanCodeInfo->ScanResult;
                    } else if ($obj->ScanCodeInfo->ScanType == "barcode") {
                        $codeinfo = explode(",", strval($obj->ScanCodeInfo->ScanResult));
                        $codeValue = $codeinfo[1];
                        $content = "扫码带提示：类型 条形码 结果：" . $codeValue;
                    } else {
                        $content = "扫码带提示：类型 " . $obj->ScanCodeInfo->ScanType . " 结果：" . $obj->ScanCodeInfo->ScanResult;
                    }
                    break;
                case "scancode_push":
                    $content = "扫码推事件";
                    break;
                case "pic_sysphoto":
                    $content = "系统拍照";
                    break;
                case "pic_weixin":
                    $content = "相册发图：数量 " . $obj->SendPicsInfo->Count;
                    break;
                case "pic_photo_or_album":
                    $content = "拍照或者相册：数量 " . $obj->SendPicsInfo->Count;
                    break;
                case "location_select":
                    $content = "发送位置：标签 " . $obj->SendLocationInfo->Label;
                    break;
                default:
                    $content = "获取一个事件消息类型: " . $obj->Event;
                    break;
            }
        }else if(strcasecmp($event, 'location') == 0){
            $content = "用户发送地址位置信息: 纬度 " . $obj->Latitude . ";经度 " . $obj->Longitude;
        }

        return $content;
    }

    /**
     * 处理文本消息
     */
    public function sendText($obj){
        #用户消息内容
        $keyword = trim($obj->Content);

        $result = '';
        #多客服人工回复模式
        if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")) {
            $result = $this->transmitService($obj);
            return $result;
        }

        #系统自动回复模式
        if (strstr($keyword, "你好") || strstr($keyword, "您好")) {
            $content = "您好,欢迎您！";

        }else if (strstr($keyword, "我的网站") || strstr($keyword, "我的网址") || strstr($keyword, "网址")) {

            $content = '欢迎来到“我的网址” <a href="https://repair.sh-jinger.com">https://repair.sh-jinger.com</a>';
        }
         else if (strstr($keyword, "表情")) {

            $content = "微笑：/::)\n乒乓：/:oo\n中国：";
        } else if (strstr($keyword, "单图文")) {

            $content = array();
            $content[] = array("Title" => "单图文标题", "Description" => "单图文内容", "PicUrl" => "http://www.baidu.com/img/baidu_jgylogo3.gif", "Url" => "http://59.110.168.230/");
        } else if (strstr($keyword, "图文") || strstr($keyword, "多图文")) {

            $content = array();
            $content[] = array("Title" => "多图文1标题", "Description" => "", "PicUrl" => "http://59.110.168.230//html/pc/images/log.png", "Url" => "http://59.110.168.230/");
        } else if (strstr($keyword, "音乐")) {

            $content = array("Title" => "最炫民族风", "Description" => "歌手：凤凰传奇", "MusicUrl" => "http://mascot-music.stor.sinaapp.com/zxmzf.mp3", "HQMusicUrl" => "http://mascot-music.stor.sinaapp.com/zxmzf.mp3");
        } else {

            $content =  "您好, \n         我们的客服系统正处于研发阶段当中，若对您带来不便敬请谅解，谢谢合作/::)/::)/::)";

        }

        if (is_array($content)) {
            if (isset($content[0])) {
                $result = $this->transmitNews($obj, $content);
            } else if (isset($content['MusicUrl'])) {
                $result = $this->transmitMusic($obj, $content);
            }
        } else {
            $result = $this->transmitText($obj, $content);
        }

        return $result;
    }

    /**
     * 处理图片消息
     */
    public function sendImage($obj){
        return $this->transmitImage($obj,$newsArray=[]);
    }

    /**
     * 处理语音消息
     */
    public function sendVoice($obj){
        return $this->transmitVoice($obj,$newsArray=[]);
    }

    /**
     * 处理视频消息
     */
    public function sendVideo($obj){
        return $this->transmitVideo($obj,$newsArray=[]);
    }

    /**
     * 处理音乐消息
     */
    public function sendMusic($obj){
        return $this->transmitMusic($obj,$newsArray=[]);
    }

    /**
     * 处理Location消息
     */
    public function sendLocation ($obj){
        return $this->transmitText($obj,'谢谢您的上传了位置信息');
    }

    /**
     * 处理图文消息
     */
    public function sendPicurl($obj){
        return $this->transmitPicurl($obj,$newsArray=[]);
    }

    /**
     * 获取微信端的XML信息
     */
    public function getXmlMsg(){
        #获取微信平台传过来的POST数据
        //$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
        $postStr = \Request::getContent();
        if (!empty($postStr)) {
            #用SimpleXML解析POST过来的XML数据
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

            return $postObj;
        }

        return false;
    }

    /**
     * 回复文本消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @param string $content
     * @return string
     */
    private function transmitText($object, $content) {
        if (!isset($content) || empty($content)) {
            return "";
        }

        $xmlTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
              </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    /**
     * 回复图文消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @param type $newsArray
     * @return string
     */
    private function transmitPicurl($object, $newsArray) {
        if (!is_array($newsArray)) {
            return "";
        }
        $itemTpl = "<item>
                  <Title><![CDATA[%s]]></Title>
                  <Description><![CDATA[%s]]></Description>
                  <PicUrl><![CDATA[%s]]></PicUrl>
                  <Url><![CDATA[%s]]></Url>
                </item>";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>%s</ArticleCount>
                <Articles>$item_str</Articles>
              </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    /**
     * 回复音乐消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @param type $musicArray
     * @return string
     */
    private function transmitMusic($object, $musicArray) {
        if (!is_array($musicArray)) {
            return "";
        }
        $itemTpl = "<Music>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <MusicUrl><![CDATA[%s]]></MusicUrl>
            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
        </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[music]]></MsgType>
            $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复图片消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @param type $imageArray
     * @return type
     */
    private function transmitImage($object, $imageArray) {
        $itemTpl = "<Image>
            <MediaId><![CDATA[%s]]></MediaId>
        </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[image]]></MsgType>
            $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复语音消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @param type $voiceArray
     * @return type
     */
    private function transmitVoice($object, $voiceArray) {
        $itemTpl = "<Voice>
            <MediaId><![CDATA[%s]]></MediaId>
        </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[voice]]></MsgType>
            $item_str
        </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复视频消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @param type $videoArray
     * @return type
     */
    private function transmitVideo($object, $videoArray) {
        $itemTpl = "<Video>
                  <MediaId><![CDATA[%s]]></MediaId>
                  <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                  <Title><![CDATA[%s]]></Title>
                  <Description><![CDATA[%s]]></Description>
                </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[video]]></MsgType>
                $item_str
              </xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 回复多客服消息
     * @param Object $object  微信服务器传过来的信息对象实例
     * @return string         反馈给微信服务器内容
     */
    private function transmitService($object) {
        $xmlTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[transfer_customer_service]]></MsgType>
              </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /**
     * 输出当前内容信息并终止执行
     */
    public function printContent($content) {
        header('Content-type:text;charset=UTF-8');
        ob_clean();

        echo $content;

        ob_flush();  //把数据从PHP的缓冲中释放出来
        flush();     //把被释放出来的数据发送到浏览器
        exit();
    }
}

