<?php
namespace app\api\validate;
use think\Validate;

class CreateCommentValidate
{

    protected $rule = [
        'name'  =>  'require|max:25',
        'email' =>  'email',
    ];


}