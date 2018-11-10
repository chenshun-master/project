<?php
namespace app\api\controller;
use think\Request;

class Article extends BaseController
{
    private $articleDomain;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->articleDomain = new \app\api\domain\ArticleDomain();
    }

    /**
     * 获取文章列表页
     */
    public function getArticleList(Request $request){
        $search         = $request->param('search','');
        $page           = (int)$request->param('page',1);
        $page_size      = (int)$request->param('page_size',20);

        if(!empty($search)){
            $search = addcslashes($search);
        }

        $res = $this->articleDomain->getArticleList($page,$page_size,$search);
        return $this->returnData($res,'',200);
    }

    /**
     * 获取文章详情页
     */
    public function getArticleDetail(Request $request){
        $id      = $request->param('id','');
        $res = $this->articleDomain->getArticleInfo($id);
        return $this->returnData($res,'',200);
    }

    /**
     * 发布文章
     */
    public function releaseArticle(Request $request){
        $user_info = $this->checkUserToken();

        if(!$this->checkUserAuth($user_info['type'],7)){
            return $this->returnData([],'未授权操作',403);
        }

        $title      = $request->param('title','');
        $excerpt    = $request->param('excerpt','');
        $tag        = $request->param('tag','');
        $thumbnail  = $request->param('thumbnail','');
        $content    = $request->param('content','');


        if(empty($title) || empty($excerpt) || empty($content)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $data = [
            'user_id'       =>$user_info['id'],
            'title'         =>htmlspecialchars($title),
            'excerpt'       =>htmlspecialchars($excerpt),
            'tag'           =>htmlspecialchars(strip_tags($tag)),
            'content'       =>$content,
            'thumbnail'     =>$thumbnail,
            'published_time'=>date('Y-m-d H:i:s'),
            'created_time'  =>date('Y-m-d H:i:s'),
            'updated_time'  =>date('Y-m-d H:i:s'),
            'status'        =>2
        ];

        $res = $this->articleDomain->create($data);

        if(!$res){
            return $this->returnData([],'添加失败',305);
        }

        return $this->returnData([],'添加成功',200);
    }

    /**
     * 上传文章缩略图
     */
    public function uploadArticleThumbnail(Request $request){

    }

    /**
     * 编辑器上传文件
     * @param Request $request
     */
    public function editorUploadFile(Request $request){

    }

    /**
     * 添加文章评论
     */
    public function addArticleComment(Request $request){
        $user_info = $this->checkUserToken();
        if(!$this->checkUserAuth($user_info['type'],7)){
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

    /**
     * 点赞处理
     */
    public function articleFabulous(Request $request){
        $user_info = $this->checkUserToken();

        $id = $request->param('id','');

        $type = $request->param('type',1);

        $res = $this->articleDomain->addFabulous($user_info['id'],$id,1,$type);

        if(!$res){
            return $this->returnData([],'点赞失败',305);
        }

        return $this->returnData([],'点赞成功',200);
    }
}