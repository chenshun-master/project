<?php
namespace app\weixin\controller;

use think\Controller;

use app\api\domain\UserFriendDomain;
use app\api\domain\FavoriteDomain;
use app\api\domain\ArticleDomain;
use app\api\domain\MessageDomain;

class Test  extends Controller
{

    /**
     * 布局demo
     */
    public function demo(){
        return $this->fetch('test/demo');
    }
}