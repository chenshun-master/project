<?php
namespace app\index\validate;
use think\Validate;

class addAuth extends Validate
{
    protected $rule =   [
        'username'              =>'require|max:25',
        'idcard'                =>'require|idCard',
        'card_img1'             =>'require|url',
        'card_img2'             =>'require|url',
        'qualification'         =>'require|url',
        'practice_certificate'  =>'require|url',
        'enterprise_name'       =>'require|max:100',
        'business_licence'      =>'require|url',
        'mobile'                =>'require|mobile',
        'sms_code'              =>'require|min:6|max:6',

        'hospital_type'         =>'require',
        'founding_time'         =>'require',
        'duties'                =>'require',
        'scale'                 =>'require',
        'profile'               =>'require',
        'speciality'            =>'require',


        'province'              =>'require|integer',
        'city'                  =>'require|integer',
        'area'                  =>'require|integer',
        'address'               =>'require',
    ];

    protected $message  =   [
        'hospital_type.require'            => '医院类型不能为空',

        'founding_time.require'            => '成立时间不能为空',


        'enterprise_name.require'          => '企业或医院名称不能为空',
        'enterprise_name.max'              => '企业或医院名称不合法',

        'username.require'                 => '身份证名不能为空',
        'username.max'                     => '身份证名不能合法',

        'idcard.require'                   => '身份证号不能为空',
        'idcard.idCard'                    => '身份证号格式错误',

        'card_img1.require'                => '身份证正面照图片不能为空',
        'card_img1.url'                    => '身份证图片格式错误',

        'card_img2.require'                => '身份证背面照图片不能为空',
        'card_img2.url'                    => '身份证图片格式错误',

        'qualification.require'            => '请上传医师资格证书',
        'qualification.url'                => '医师资格证书格式错误',

        'practice_certificate.require'     => '请上传医师执业证书',
        'practice_certificate.url'         => '医师执业证书格式错误',

        'mobile.require'                   => '手机号不能为空',
        'mobile.mobile'                    => '手机号格式错误',

        'sms_code.require'                 => '验证码不能为空',
        'sms_code.mobile'                  => '验证码格式错误',
    ];

    protected $scene = [
        'auth1'  =>  ['username','idcard','card_img1','card_img2'],
        'auth2'  =>  ['username','idcard','card_img1','card_img2','qualification','practice_certificate','profile','speciality','duties'],
        'auth3'  =>  ['username','idcard','card_img1','card_img2','enterprise_name','business_licence','mobile','sms_code','hospital_type','founding_time','profile','speciality','scale','province','city','area','address'],
        'auth4'  =>  ['username','idcard','card_img1','card_img2','enterprise_name','business_licence','mobile','sms_code','province','city','area','address'],
    ];
}