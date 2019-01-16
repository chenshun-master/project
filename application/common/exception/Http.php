<?php
namespace app\common\exception;

use Exception;
use think\exception\Handle;

class Http extends Handle
{

    public function render(Exception $e){
        if(config('app_debug')){
            return parent::render($e);
        }else{
            $module = request()->module();

            if($module == 'api'){
//                return parent::render($e);
                $module = 'index';
            }

//            //错误码 $e->getStatusCode()
            header("Location:".url($module.'/index/error404'));
        }
    }
}