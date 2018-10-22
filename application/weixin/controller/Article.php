<?php
namespace app\weixin\controller;

use think\App;

/**
 * 文章处理控制器
 * Class Article
 * @package app\weixin\controller
 */
class Article extends BaseController
{

    private $articleDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->articleDomain = new \app\api\domain\ArticleDomain();
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

        $res = $this->articleDomain->createComment($data);
        if(!$res){
            return $this->returnData([],'评论失败',305);
        }
        return $this->returnData([],'评论成功',200);
    }
}