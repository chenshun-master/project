<?php

namespace app\index\controller;

use think\App;
use think\Request;
use app\api\model\ArticleModel;

class Article extends CController
{
    private $_articleDomain;
    private $_userDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_articleDomain = new \app\api\domain\ArticleDomain();
        $this->_userDomain = new \app\api\domain\UserDomain();
    }

    /**
     * 发布文章接口
     */
    public function releaseArticle()
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '请先进行登录', 401);
        }

        $article_id = $this->request->post('article_id/d',0);
        $data = \Request::only(['title'=>'','tag'=>'','excerpt'=>'','content'=>''], 'post');
        $data['thumbnail'] = $this->request->post('thumbnail_img/a',[]);

        if (empty($data['title']) || empty($data['tag']) || empty($data['content'])) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $data['type']          = 1;
        $data['user_id']       = $this->getUserId();
        $data['thumbnail']     = array_unique(array_slice(array_merge($data['thumbnail'], get_html_images($data['content'])), 0, 3));
        if($this->request->post('flag/d',0) == 2){
            if ($this->_articleDomain->saveArticleDraft($this->getUserId(),1,$data)) {
                return $this->returnData([], '保存草稿成功', 200);
            }
        }else if (!checkUserAuth($this->_userDomain->getUserType($data['user_id']), 7)) {
            return $this->returnData([], '未授权操作', 403);
        }else if($article_id){
            $isdraft = $this->request->post('isdraft/d',0) == 1? 1 : 0 ;
            if($this->_articleDomain->edit($data['user_id'],$article_id,$data,$isdraft)){
                return $this->returnData([], '操作成功', 200);
            }
        }else if ($this->_articleDomain->createArticle($data)) {
            //添加并发表文章
            return $this->returnData([], '操作成功', 200);
        }

        return $this->returnData([], '操作失败', 305);
    }

    /**
     * 文章编辑页面
     * @return mixed|\think\response\Redirect
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function article()
    {

        if (!$this->checkLogin()) {
            return redirect('/login');
        }

        $articleId = $this->request->param('id/d',0);
        $articleInfo = [];
        if($articleId){
            $articleInfo = $this->_articleDomain->findArticleDetail($this->getUserId(),$articleId);
            if($articleInfo && !empty($articleInfo['thumbnail'])){
                $articleInfo['thumbnail'] = json_decode($articleInfo['thumbnail'],true);
            }else{
                $articleInfo['thumbnail'] = [];
            }
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());
        $this->assign('user_info', $user_info);
        $this->assign('articleInfo', $articleInfo);
        return $this->fetch('article/published_article');
    }

    /**
     * 用户发表文章列表页面
     * @return mixed|\think\response\Redirect
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function graphic()
    {

        if (!$this->checkLogin()) {
            return redirect('/login');
        }

        $page = $this->request->param('page/d', 1);
        $data = $this->_articleDomain->getPcUserPublishArticle($this->getUserId(), $page, 15);

        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $v) {
                if ($v['thumbnail']) {
                    $data['rows'][$k]['thumbnail'] = json_decode($v['thumbnail'], true);
                } else {
                    $data['rows'][$k]['thumbnail'] = [];
                }
            }
        }

        $draftId = ArticleModel::findArticleDraft($this->getUserId(),1);
        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign($data);
        $this->assign('user_info', $user_info);
        $this->assign('draftId', $draftId);
        return $this->fetch('article/my_article');
    }
}