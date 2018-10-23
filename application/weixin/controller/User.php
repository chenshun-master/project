<?php
namespace app\weixin\controller;
use think\App;
use think\Request;


/**
 * 用户中心控制器
 * Class user
 * @package app\weixin\controller
 */
class User extends BaseController
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $request = new Request();
        if(!$this->checkLogin()){
            if($request->isAjax()){
                returnData([],'用户未登录',401);
            }
        }
    }

    /**
     * 用户个人中心主页
     */
/*    public function main(){


        dump($this->getUserInfo());
   }*/
	 public function main(){
	        if($this->checkLogin()){
	            return redirect('/weixin/user/main');
	        }
	
	        return $this->fetch('user/main');
	        
	    }
}