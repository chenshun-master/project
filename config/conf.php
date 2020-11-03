<?php

/**
 * 自定义配置文件
 */
return [
    #微信浏览其中是否开启微信公众号自动登录
    'weixin_automatic_logon'=>false,

    #测试环境 false 生产环境 true
    'send_sms'  =>false,
    'sms_config'=>[
        //短信签名
        'yzm'=>[
            'sign'          =>9175,
            'template_id'   =>12318,
        ]
    ],

    #是否是本地开发环境
    'is_localhost' =>true,

    #网站版权
    'copyright'=>'Copyright © 2018 薇琳医美 - 沪ICP备18005435号',

    'secret_key'=>'KNJFDBBJHA',             #网站加密解密秘钥
    'sms'=>[
        'code'=>[
            'expire_time'  =>60*15,
            'code_msg'     =>'15分钟'
        ],
        'asdfasd'=>"asdfasd",
    ],

    'title'=>'上海微琳医疗美容',

    'file_save_domain'=>'http://172.16.100.85:81',               #上传图片的二级域名

    #第三方登录配置  git地址： https://github.com/anerg2046/sns_auth
    'sns_login'=>[
        'weixin'            =>[
            'app_id'        => 'wxf8c7fa2d80e2651c',
            'app_secret'    => 'bea2a9eb7a54a405d361c9f81dab51e1',
            'token'         =>'xiaoxiaorao',
            'EncodingAESKey'=>'GHJKLZPOGADf3f230f615bca3443581cfb96dbf289P',

            //如果需要静默授权，这里改成snsapi_base，扫码登录系统会自动改为snsapi_login
            'scope'      => 'snsapi_userinfo',
        ],
        'qq'                =>[
            'app_id'        => '1013****',
            'app_secret'    => '67c52bc284b32e7**********',
            'scope'         => 'get_user_info',
        ],
        'weibo'             =>[
            'app_id'     => '78734****',
            'app_secret' => 'd8a00617469018d61c**********',
            'scope'      => 'all',
        ],
        'alipay'            =>[
            'app_id'      => '2016052*******',
            'scope'       => 'auth_user',
            'pem_private' => Env::get('ROOT_PATH') . 'pem/private.pem', // 你的私钥
            'pem_public'  => Env::get('ROOT_PATH') . 'pem/public.pem', // 支付宝公钥
        ],
    ],

    'website'=>[
        'mobile' =>'18798276809'
    ],
];