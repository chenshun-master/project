<?php
namespace app\api\domain;

class Singleton
{

    public static $list = [
        'diarydomain'           =>'app\\api\\domain\\DiaryDomain',
        'commentdomain'         =>'app\\api\\domain\\CommentDomain',
        'userfrienddomain'      =>'app\\api\\domain\\UserFriendDomain',
        'spgoodsdomain'         =>'app\\api\\domain\\SpGoodsDomain',
    ];

    static private $instance = [];

    public static function getDomain($domainName){
        if(!isset(self::$instance[strtolower($domainName)])){
            if(!isset(self::$list[strtolower($domainName)])){
                throw new \think\Exception('实例化类不存在');
            }

            return self::$instance[strtolower($domainName)]  = new self::$list[strtolower($domainName)];
        }else{
            return self::$instance[strtolower($domainName)];
        }
    }
}