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
        'name'                  =>'require|max:100',
        'business_licence'      =>'require|url'
    ];

    protected $message  =   [
        'name.require'          => '组织名称不能为空',
        'name.max'              => '组织名称不能合法',

        'username.require'      => '身份证名不能为空',
        'username.max'          => '身份证名不能合法',

        'idcard.require'        => '身份证号不能为空',
        'idcard.idCard'         => '身份证号格式错误',

        'card_img1.require'     => '身份证正面照图片不能为空',
        'card_img1.url'         => '身份证图片格式错误',

        'card_img2.require'     => '身份证背面照图片不能为空',
        'card_img2.url'         => '身份证图片格式错误',

        'qualification.require' => '请上传医师资格证书',
        'qualification.url'     => '医师资格证书格式错误',

        'practice_certificate.require' => '请上传医师执业证书',
        'practice_certificate.url'     => '医师执业证书格式错误',
    ];

    protected $scene = [
        'auth1'  =>  ['username','idcard','card_img1','card_img2'],
        'auth2'  =>  ['username','idcard','card_img1','card_img2','qualification','practice_certificate'],
        'auth3'  =>  ['username','idcard','card_img1','card_img2','name','business_licence'],
        'auth4'  =>  ['username','idcard','card_img1','card_img2','name','business_licence'],
    ];
}