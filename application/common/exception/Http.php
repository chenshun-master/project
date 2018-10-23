<?php
namespace app\common\exception;

use Exception;
use think\exception\Handle;
class Http extends Handle
{

    public function render(Exception $e){
        if(config('app_debug')){
            //如果开启debug则正常报错
            return parent::render($e);
        }else{
            $module = request()->module();
            dump($e->getStatusCode());exit;
            if($e->getStatusCode() == 404){
                header("Location:".url($module.'/index/error404'));
            }else{




                header("Location:".url($module.'/index/error500'));
            }
        }
    }

}