<?php
namespace app\api\controller;


class Test
{
    public function test(){
        $domain = new \app\api\domain\AuthDomain();
        $res = $domain->authVerify(16,3,'审核成功');
        halt($res);
    }
}