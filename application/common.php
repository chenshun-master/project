<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
* 返回接口数据
* @param array $data    接口数据
* @param string $msg    信息提示
* @param int $code      状态码
* @return false|string
*/
function returnData($data=[],$msg='',$code = 200){
    exit(json_encode([
        'code' =>$code,
        'msg'  =>$msg,
        'data' =>$data
    ]));
}

/**
 * 生成随机数字
 * @param Int $length [default is 6]
 * @return String
 */
function getRand($length = 6) {
    $arr = array();
    while (count($arr) < $length) {
        $arr[] = rand(1, 9);
        $arr = array_unique($arr);
    }
    $randString = implode('', $arr);
    return $randString;
}

/**
 * 加密与解决算法
 * @param $str                  待加密的字符串内容
 * @param string $operation     操作方式(E:加密,D:解密，默认为D)
 * @param string $str_key       密钥
 * @return bool|mixed|string    加密/解密后的字符串内容
 */
function encryptStr($str, $operation = 'D', $str_key = 'token') {
    $key = md5($str_key);
    $key_length = strlen($key);
    $string = strtoupper($operation) == 'D' ? base64_decode($str) : substr(md5($str . $key), 0, 8) . $str;
    $string_length = strlen($string);
    $rndkey = $box = array();
    $result = '';
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($key[$i % $key_length]);
        $box[$i] = $i;
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result.=chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'D') {
        if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
            return substr($result, 8);
        } else {
            return'';
        }
    } else {
        return str_replace('=', '', base64_encode($result));
    }
}

/**
 * 密码加密方式
 * @param $password   用户输入密码
 * @return string     加密后的密码
 */
function encryptPwd($password){
    return md5(md5($password));
}

/**
 * 密码加密方式(改进)
 * @param $password   用户输入密码
 * @return string     加密后的密码
 */
function encryptPwd2($password){
    $password = md5($password);
    $password = sha1($password);
    $password = substr($password,0,5).md5($password).substr($password,-5).'wl';
    return md5($password);
}

/**
 * 验证手机号是否正确
 * @param $mobile    待验证手机号
 * @return bool
 */
function checkMobile($mobile){
    $preg_phone='/^1[3-9][0-9]\d{8}$/';
    if(preg_match($preg_phone,$mobile)){
        return true;
    }

    return false;
}

/**
 * 身份证号验证
 * @param $idCard
 * @return bool
 */
function checkIdCard($idCard){
    $preg = '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/';

    if(preg_match($preg,$idCard)){
        return true;
    }

    return false;
}



/**
 * 处理创瑞短信发送信息方法
 * @param $data  待处理数组
 */
function getSmsContent($data){
    return implode('##',$data);
}

/**
 * 获取分页总数
 * @param $total
 * @param $page_size
 * @return int
 */
function getPageTotal(int $total,int $page_size){
    if($total === 0){
        return 0;
    }

    return (int)ceil((int)$total/(int)$page_size);
}


/**
 * 验证用户权限
 * @param $type        用户类型; 1:普通用户;2:认证用户;3:认证医生;4:认证医院;5:官方团队
 * @param $authType    授权类型: 1:发表评论 2:购买商品 3:关注用户 4:发送私信 5:发表说说 6:发布提问 7:发表内容 8:发表案例 9:开设店铺 10:入驻医院 11:关联认证医生
 * @return bool
 */
function checkUserAuth($type,$authType){
    $authGroup = [
        '1'=>'1,2,3,4,5,6',                         #普通用户组
        '2'=>'1,2,3,4,5,6,7,9',                     #认证用户组
        '3'=>'1,2,3,4,5,6,7,8,9,10',                #认证医生组
        '4'=>'1,2,3,4,5,6,7,8,9,11',                #认证医院组
        '5'=>'1,3,4,5,6'                            #官方团队组
    ];

    if(!isset($authGroup[$type])){
        return false;
    }
    $arr = explode(',',$authGroup[$type]);
    return in_array($authType,$arr) ? true :false;
}


/**
 * 人性化时间显示
 * @param $time
 * @return false|string
 */
function formatTime($time){
    $current_day = date('d');
    $day = date('d',$time);
    $str = '';
    if($current_day == $day){
        $htime = date("H:i",$time);
        $time = time() - $time;
        if ($time < 60){
            $str = '刚刚';
        }elseif($time < 60 * 60){
            $min = floor($time/60);
            $str = $min.'分钟前';
        }elseif($time < 60 * 60 * 4) {
            $h = floor($time / (60 * 60));
            $str = $h . '小时前';
        }else{
            $str = '今天 '.$htime.'分';
        }
    }else{
        if(date('Y-m-d',strtotime('-1 day')) == date('Y-m-d',$time)){
            $str = '昨天 '.date("H:i",$time).'分';
        }else if(date('Y-m-d',strtotime('-2 day')) == date('Y-m-d',$time)){
            $str = '前天 '.date("H:i",$time).'分';
        }else{
            $str =date('Y年m月d日',$time);
        }
    }

    return $str;
}

/**
 * 获取列表分页信息
 * @param type $total
 * @param type $pageindex
 * @param type $pagesize
 * @return type
 */
function getPagingInfo($total,$pageindex=1,$pagesize=20){
    $pagesize = ((int)$pagesize == 0?1:(int)$pagesize);
    $offset = (intval($pageindex) - 1) * intval($pagesize);
    return [
        'offset'=>$offset,
        'pagesize'=>$pagesize,
        'total'=>$total,
        'page_index'=>$pageindex,
        'page_total'=>ceil((int)$total/(int)$pagesize),
        'limit'=>" limit {$offset},{$pagesize}"
    ];
}

/**
 *
 * 处理文章缩略图数据
 * @param $data            缩略图数组
 * @return false|string
 */
function handleThumbnailData($data){
    $tmp_arr = [];
    $i = 1;

    foreach ($data as $val){
        $key = 'img_'.$i;
        $tmp_arr[$key] = $val;
        $i++;
    }
    return json_encode($tmp_arr);
}


/**
 * 判断是否为微信浏览器
 * @return bool
 */
function is_weixin(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}

/**
 * 手机号脱敏
 * @param $mobile     手机号
 * @return mixed
 */
function mobileFilter($mobile){
    return substr_replace($mobile,'****',3,4);
}

/**
 * 从HTML文本中提取所有图片
 * @param $content
 * @return array
 */
function get_html_images($content){
    $pattern="/<img.*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/";
    preg_match_all($pattern,htmlspecialchars_decode($content),$match);
    $data = [];
    if(!empty($match[1])){
        foreach ($match[1] as $img){
            if(!empty($img)){
                $data[] = $img;
            }
        }
        return $data;
    }

    return $data;
}

/**
 * 用户名脱敏
 */
function userNameTuoming($username){
    $str = mb_substr($username, 0, 1, 'utf-8');
    for ($i = 1;$i < mb_strlen($username);$i++ ){
        $str .= '*';
    }
    return $str;
}

/**
 * 身份证脱敏
 */
function idcardTuoming($iccrad){
    return substr($iccrad,0,6).'******'.substr($iccrad,-4);
}

/**
 * 求两个日期之间相差的天数
 * (针对1970年1月1日之后，求之前可以采用泰勒公式)
 * @param string $day1
 * @param string $day2
 * @return number
 */
function diffBetweenTwoDays ($day1, $day2){

    $second1 = strtotime(date('Y-m-d',strtotime($day1)));
    $second2 = strtotime(date('Y-m-d',strtotime($day2)));

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }

    return round(($second1 - $second2) / 86400);
}

/**
 * 获取唯一订单编号
 * @param int $n         必须大于14
 * @return string
 */
function getOrderNo($n=20){
    $m=$n-13;
    if($m<=0) $m=1;
    $rand_num_min=0;
    $rand_num_max=str_repeat(9,$m);
    $seconds=sprintf("%05d", (time() - mktime(0,0,0)) );
    return date("Ymd",time()).$seconds. sprintf("%0".$m."d", rand($rand_num_min, $rand_num_max));
}


function checkFooter($url){
    $u = request()->url();

    if($u == '/weixin'){
        $u = '/weixin/index/index';
    }

    return strtolower($u) == strtolower($url) ? true : false;
}


/**
 * 获取加密解密的url
 * @param $str
 * @param string $flag   E:加密   D:解密
 * @return bool|string
 */
function getRedirUrl($str,$flag='E'){
    if($flag == 'E'){
        return base64_encode($str);
    }else{
        return base64_decode($str);
    }
}


//对emoji表情转义
function emoji_encode($str){
    $strEncode = '';
    $length = mb_strlen($str,'utf-8');
    for ($i=0; $i < $length; $i++) {
        $_tmpStr = mb_substr($str,$i,1,'utf-8');
        if(strlen($_tmpStr) >= 4){
            $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
        }else{
            $strEncode .= $_tmpStr;
        }
    }
    return $strEncode;
}

function emoji_decode($str){
    $strDecode = preg_replace_callback('|\[\[EMOJI:(.*?)\]\]|', function($matches){return rawurldecode($matches[1]);}, $str);
    return $strDecode;
}

/**
 * 格式化金额 保留两位小数(不四舍五入)
 * @param $amount
 * @return float|int
 */
function formatMoney($amount){
    return (float)sprintf("%1.2f",(explode('.',$amount * 100)[0] / 100));
}


/**
 * 获取随机字符串
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string 随机字符串
 */
function random($length = 6, $type = 'string', $convert = 0)
{
    $config = array(
        'number' => '1234567890',
        'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );

    if (!isset($config[$type]))
        $type = 'string';
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $string{mt_rand(0, $strlen)};
    }
    if (!empty($convert)) {
        $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
    }
    return $code;
}
