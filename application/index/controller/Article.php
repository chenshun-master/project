<?php
namespace app\index\controller;

use think\App;
use think\Request;

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
    public function releaseArticle(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '请先进行登录', 401);
        }

        $user_info = $this->getUserInfo();
        if (!checkUserAuth($this->_userDomain->getUserType($this->getUserId()), 7)) {
            return $this->returnData([], '未授权操作', 403);
        }

        $title = $request->param('title', '');
        $tag = $request->param('tag', '');
        $excerpt = $request->param('excerpt', '');
        $content = $request->param('centent', '');
        $published_time = $request->param('published_time', '');
        $thumbnailImg = $request->param('thumbnail_img', []);

        if (empty($title) || empty($tag) || empty($content)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $imgs = get_html_images($content);
        $thumbnailImg = array_slice(array_merge($thumbnailImg, $imgs), 0, 3);

        $data = [
            'user_id' => $user_info['id'],
            'type' => 1,
            'title' => $title,
            'tag' => $tag,
            'excerpt' => '',
            'content' => $content,
            'published_time' => $published_time,
            'thumbnail' => $thumbnailImg
        ];

        $isTrue = $this->_articleDomain->createArticle($data);
        if (!$isTrue) {
            return $this->returnData([], '发布失败', 305);
        }
        return $this->returnData([], '发布成功', 200);
    }

    /**
     * 发布视频接口
     */
    public function releaseVideo()
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $user_info = $this->getUserInfo();
        if (!checkUserAuth($user_info['type'], 7)) {
            return $this->returnData([], '未授权操作', 403);
        }
    }

    /**
     * 发布案例接口
     */
    public function releaseCase()
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }
        $user_info = $this->getUserInfo();

        if (!checkUserAuth($user_info['type'], 8)) {
            return $this->returnData([], '未授权操作', 403);
        }


    }

    /**
     * 文章发布页面
     * @return mixed
     */
    public function article()
    {

        if (!$this->checkLogin()) {
            return redirect('/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign('user_info', $user_info);
        return $this->fetch('article/article_release');
    }

    /**
     * 全部图文页面
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

        $page       = $this->request->param('page/d',1);
        $data = $this->_articleDomain->getPcUserPublishArticle($this->getUserId(),$page,15);

        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                if($v['thumbnail']){
                    $data['rows'][$k]['thumbnail'] = json_decode($v['thumbnail'],true);
                }else{
                    $data['rows'][$k]['thumbnail'] = [];
                }
            }
        }

        $this->assign($data);

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());
        $this->assign('user_info',$user_info);



        return $this->fetch('article/graphic');
    }

    public function test(){
        halt(['asdf','asdfdasadf']);
    }
}