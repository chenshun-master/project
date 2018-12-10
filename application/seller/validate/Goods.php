<?php
namespace app\seller\validate;
use think\Validate;

class Goods extends Validate
{
    protected $rule =   [
        'name'            =>'require',
        'market_price'    =>'require|float|>:0',
        'sell_price'      =>'require|float|>:0',
        'prepay_price'    =>'require|float|>:0',
        'topay_price'     =>'require|float|>:0',
        'store_nums'      =>'require|integer|>:0',
        'img_ids'         =>'require',
        'status'          =>'require|integer',


        'doctor_id'      =>'require|integer|>:0',
        'hospital_id'    =>'require|integer|>:0',
    ];

    protected $message  =   [

    ];

    protected $scene = [
        'releaseGoods'=>['name','market_price','sell_price','prepay_price','topay_price','store_nums','img_ids','status','doctor_id','hospital_id'],
    ];
}