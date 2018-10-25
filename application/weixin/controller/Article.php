<?php
namespace app\weixin\controller;

use think\App;
use think\Request;

/**
 * 文章处理控制器
 * Class Article
 * @package app\weixin\controller
 */
class Article extends BaseController
{
    private $articleDomain;
    private $userDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->articleDomain = new \app\api\domain\ArticleDomain();
        $this->userDomain    = new \app\api\domain\UserDomain();
    }

    /**
     * 文章点赞处理
     */
    public function clickZan(){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        $id = $request->param('id','');
        $type = $request->param('type',1);
        $user_id = $this->getUserInfo()['id'];

        $res = $this->articleDomain->addFabulous($user_id,$id,1,$type);

        if(!$res){
            return $this->returnData([],'点赞失败',305);
        }

        return $this->returnData([],'点赞成功',200);
    }

    /**
     * 文章评论处理
     */
    public function comment(){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        $user_info  = $this->getUserInfo();
        if(!checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }

        $parent_id              = (int)$request->param('pid','');
        $object_id              = (int)$request->param('object_id','');
        $content                = $request->param('content','');

        if(empty($object_id) || empty($content)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $data = [
            'user_id'      =>$user_info['id'],
            'parent_id'    =>$parent_id,
            'object_id'    =>$object_id,
            'content'      =>$content,
            'created_time' =>date('Y-m-d H:i:s')
        ];

        $res = $this->articleDomain->createComment($data,'article');
        if(!$res){
            return $this->returnData([],'评论失败',305);
        }
        return $this->returnData([],'评论成功',200);
    }

    /**
     * 获取首页文章列表
     */
    public function getArticleList(Request $request){
        $type = $request->param('type',0);
        $page = $request->param('page',1);
        $page_size = $request->param('page_size',15);

        $data = $this->articleDomain->getHomeList($page,$page_size,$type);
        return $this->returnData($data,'',200);
    }

    /**
     * 获取手机端文章详情页
     */
    public function getArticleInfo(Request $request){
        $id = $request->param('id',0);
        $data = $this->articleDomain->getArticleInfo($id);

        return $this->returnData($data,'',200);
    }

    /**
     * 根据发表文章的相关文章
     */
    public function getRelevantList(Request $request){
        $id = $request->param('id',0);
        $page = $request->param('page',1);
        $page_size = $request->param('page_size',10);

        $data = $this->articleDomain->getRelevantList($id,$page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 获取指定用户发布文章
     */
    public function getUserPublishArticle(Request $request){
        $user_id = (int)$request->param('user_id',0);
        $type = (int)$request->param('type',1);
        $page = (int)$request->param('page',1);
        $page_size = (int)$request->param('page_size',10);

        if(empty($user_id) || empty($type) || empty($page) || empty($page_size)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $data = $this->articleDomain->getUserPublishArticle($user_id,$type,$page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 个人中心（游客查看）
     * @param Request $request
     * @return mixed
     */
    public function userMain(Request $request)
    {
        $user_id = (int)$request->param('id',0);
        $res = $this->articleDomain->getArticleStatisticsData($user_id);

        $data = [
            'type_1'=>['type'=>1,'total'=>0],
            'type_2'=>['type'=>2,'total'=>0],
            'type_3'=>['type'=>3,'total'=>0],
            'type_4'=>['type'=>4,'total'=>0]
        ];

        if($res){
            foreach ($res as $val){
                $type = 'type_'.$val['type'];
                $data[$type] = $val;
            }
        }

        $user_info = $this->userDomain->getArticleUserInfo($user_id);

        $is_friend = false;
        if($this->checkLogin()){
            $user_info = $this->getUserInfo();
            $is_friend = $this->userDomain->checkFriend($user_info['id'],$user_id);
        }

        $this->assign([
            'statistics'=>$data,
            'user_info' =>$user_info,
            'is_friend' =>$is_friend,
        ]);
        return $this->fetch('article/userMain');
    }

    /**
     * 获取用户点赞过的文章列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserLikeData(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        $page = (int)$request->param('page',1);
        $page_size = (int)$request->param('page_size',10);

        if(empty($page) || empty($page_size)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $user_info  = $this->getUserInfo();
        $data = $this->articleDomain->getArticleLikeData($user_info['id'],$type,$page,$page_size);
        return $this->returnData($data,'',200);
}

   /**
     * 文章详情页
     */
    public function articleDetails(){
        return $this->fetch('article/article_details');
    }

       /**
     * 文章视频页
     */
    public function articleVideo(){
        return $this->fetch('article/article_video');
    }
           /**
     * 文章视频页
     */
    public function personal(){
        return $this->fetch('article/personal');

}
    public function test(){
        $data = [
            'user_id'      =>4,
            'parent_id'    =>25,
            'object_id'    =>1,
            'content'      =>'asdfasdfasdf11111111222222222223333333',
            'created_time' =>date('Y-m-d H:i:s')
        ];

        $res = $this->articleDomain->createComment($data,'interlocution');
        dump($res);
    }
}