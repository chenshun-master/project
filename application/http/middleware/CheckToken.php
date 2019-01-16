<?php
namespace app\http\middleware;

use app\common\helpers\Jwt;

/**
 * Api 接口token 验证中间件
 * Class CheckToken
 * @package app\http\middleware
 */
class CheckToken
{

    public function handle($request, \Closure $next)
    {

        list($isOk,$msg,$data) = $this->chencToken($request);

        if(!$isOk){
            return json(['code'=>401,'msg'=>$msg]);
        }

        return $next($request);
    }

    /**
     * 验证token
     * @param $request
     * @return array
     */
    private function chencToken($request){
        $jwt = new Jwt();

//        $token = $request->header('token','');
        $token = $request->param('token','');
        if(empty($token)){
            return [false,'token 参数验证失败',null];
        }

        $verifyResult = $jwt->verifyToken($token);

        if($verifyResult === false){
            return [false,'token 参数验证无效',null];
        }

        return [true,'token 参数验证通过',null];
    }
}
