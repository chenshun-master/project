<?php
namespace app\api\domain;

use think\Db;
use sms\ChuangRuiSms;

/**
 * 发送短信验证码处理类
 * Class SendSms
 * @package app\api\domain
 */
class SendSms
{

    /**
     * 创建短信发送记录
     * @param $mobile          手机号
     * @param $type            创建验证码类型
     * @return array|bool
     */
    public function createSmsLog($mobile,$type){
        $data = [
            'type'          =>$type,
            'mobile'        =>$mobile,
            'expire_time'   =>date('Y-m-d H:i:s',time() + config('conf.sms.code.expire_time')),
            'code'          =>getRand(6),
            'created_time'  =>date('Y-m-d H:i:s')
        ];
        $id = Db::table('wl_verification_code')->insertGetId($data);
        if($id){
            $data['id'] =  $id;
            return $data;
        }

        return false;
    }

    /**
     * 发送短信验证码
     * @param $mobile    手机号
     * @param $type      验证码类型
     * @return bool
     */
    public function sendCode($mobile,$type,$sign,$template_id){
        #注册短信白名单检测(防止恶意发送短信)
        $isTrue = $this->_whiteList($mobile,$type);
        if($isTrue){
            return false;
        }

        $result = $this->createSmsLog($mobile,$type);

        if(!$result){
            return false;
        }

        $smsObj = new ChuangRuiSms();

        $data = [
            $result['code'],config('conf.sms.code.code_msg')
        ];

        $isTrue = $smsObj->SendSms($sign,$template_id,$result['mobile'],getSmsContent($data));

        return $isTrue;
    }

    /**
     * 短信验证码验证
     * @param $mobile      手机号
     * @param $type        验证码类型
     * @param $code        短信验证码
     * @return int         (0:验证失败; 1:验证成功 ;2:验证码已过期;)
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkSmsCode($mobile,$type,$code){
        $res = Db::table('wl_verification_code')
            ->where('mobile',$mobile)
            ->where('type',$type)
            ->where('code',$code)
            ->order('id', 'desc')
            ->find();

        if(!$res){
            return 0;
        }else if($res['expire_time'] < date('Y-m-d H:i:s')){
            return 2;
        }else{
            return 1;
        }
    }


    /**
     * 发送其它消息类短信
     * @param $mobile           手机号
     * @param $sign             签名
     * @param $template_id      模板id
     * @param $data             数据
     */
    public function send($mobile,$sign,$template_id,$data){
        $smsObj = new ChuangRuiSms();
        $content = $result['code'].'##'.config('conf.sms.code.code_msg');
        $isTrue = $smsObj->SendSms($sign,$template_id,$result['mobile'],$content);
    }

    /**
     * 白名单
     */
    private function _whiteList($mobile,$type){
        $ip = request()->ip();

        $count = Db::name('sms_whitelist')
            ->where('ip',$ip)
            ->where('type',1)
            ->whereBetweenTime('created_time', date('Y-m-d'))
            ->count();


        dump($count);exit;


        return false;
    }
}