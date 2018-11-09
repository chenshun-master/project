<?php
namespace app\weixin\controller;

use think\Controller;

use app\api\domain\UserFriendDomain;
use app\api\domain\FavoriteDomain;
use app\api\domain\ArticleDomain;
use app\api\domain\MessageDomain;
class Test  extends Controller
{
    public function test(){
        /**$res = new UserFriendDomain();
        halt($res->createFriend(6,5));**/



//        $model = new FavoriteDomain();
////        $ss = $model->create([
////            'user_id'     =>4,
////            'table_name'  =>'article',
////            'title'       =>'重庆22路公交坠江前为何没有减速？｜深度聚焦555',
////            'object_id'   =>38,
////            'thumbnail'   =>'',
////        ]);
//
//        halt($model->getFavoriteList(4,1,15));


//        $model = new ArticleDomain();
//        $res = $model->getCommentArticle(4);
//
//        halt($res);




//        $model =  new MessageDomain();
//        $res = $model->pushGroupMsg(0,'各家医院你好？','罚款羧甲asdasdff淀粉钠fa sdfasdf你卡就是你，那就看你卡就sdfasd是当年按揭房你是客服金卡是的呢',3);
//        halt($res);


//        $list = $model->getUserMailList(10);
//        halt($list);


//        $model = new UserFriendDomain();
//        $model->checkFriend(4,5);

    }
}