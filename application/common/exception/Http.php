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
            if($module == 'api'){
               return json(['code'=>$e->getStatusCode(),'msg'=>'','http_code'=>$e->getStatusCode()]);
            }

            //错误码 $e->getStatusCode()
            header("Location:".url($module.'/index/error404'));
        }
    }
}