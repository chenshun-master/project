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
    private $_userFriendDomain;
    private $wechatJssdk;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->articleDomain = new \app\api\domain\ArticleDomain();
        $this->userDomain    = new \app\api\domain\UserDomain();

        $this->wechatJssdk = new \wechat\WeChatJsSDK;
        $this->_userFriendDomain = new \app\api\domain\UserFriendDomain();

    }

    /**
     * 文章点赞处理
     */
    public function clickZan(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        $id = $request->param('id','');
        $type = $request->param('type',1);
        $user_id = $this->getUserInfo()['id'];

        $res = $this->articleDomain->addFabulous($user_id,$id,$type,'article');

        if(!$res){
            return $this->returnData([],'操作失败',305);
        }

        return $this->returnData(['type'=>$type],'操作成功',200);
    }

    /**
     * 评论点赞处理
     */
    public function commentClickZan(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        $id = $request->param('id','');
        $type = $request->param('type',1);
        $user_id = $this->getUserInfo()['id'];

        $res = $this->articleDomain->addFabulous($user_id,$id,$type, 'comment');

        if(!$res){
            return $this->returnData([],'操作失败',305);
        }

        return $this->returnData(['type'=>$type],'操作成功',200);
    }

    /**
     * 文章评论处理
     */
    public function comment(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        if(!checkUserAuth($this->userDomain->getUserType($this->getUserId()),1)){
            return $this->returnData([],'未授权操作',403);
        }

        $parent_id              = (int)$request->param('pid','');
        $object_id              = (int)$request->param('object_id','');
        $content                = $request->param('content','');

        if(empty($object_id) || empty($content)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $data = [
            'user_id'      =>$this->getUserId(),
            'parent_id'    =>$parent_id,
            'object_id'    =>$object_id,
            'content'      =>htmlspecialchars($content),
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

        foreach ($data['rows'] as $k=>$val){
            if(!empty($val['thumbnail'])){
                $tmp = json_decode($val['thumbnail'],true);
                $data['rows'][$k]['thumbnail'] = $tmp['img_1'];
            }

            if($val['user_type'] == 3){
                $data['rows'][$k]['nickname'] = $val['username'];
            }else if($val['user_type'] == 4 || $val['user_type'] == 5){
                $data['rows'][$k]['nickname'] = $val['enterprise_name'];
            }
        }

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

        $uid = $this->getUserId();

        $data = $this->articleDomain->getUserPublishArticle($user_id,$type,$page,$page_size,false,$uid);
        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                $time = strtotime($v['published_time']);
                $data['rows'][$k]['published_time'] = formatTime($time);
            }
        }

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
        $user_info = $this->userDomain->getArticleUserInfo($user_id);
        if(!$user_info){
            return redirect('index/error404');
        }

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

        $is_friend = false;
        if($this->checkLogin() && $user_info){
            if($user_info['id'] == $this->getUserId()){
                $is_friend = 2;
            }else{
                $is_friend = $this->_userFriendDomain->checkFriend($user_id,$this->getUserId());
            }
        }

        $this->assign([
            'statistics'=>$data,
            'user_info' =>$user_info,
            'is_friend' =>$is_friend,
            'uid'       =>$user_info['id'],
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
    public function articleDetails(Request $request){
        $id = $request->param('id',0);
        $data = $this->articleDomain->getArticleInfo($id,$this->getUserId());
        if(count($data['article_info']) == 0){
            return redirect('index/error404');
        }

        $thumbnail = empty($data['article_info']['thumbnail']) ?[] : json_decode($data['article_info']['thumbnail'],true) ;
        $shareImg = count($thumbnail) > 0 ? $thumbnail['img_1'] : '';
        $isFriend = false;
        if($this->checkLogin()){
            if($data['article_info']['user_id'] == $this->getUserId()){
                $isFriend = 2;
            }else{
                $isFriend = $this->_userFriendDomain->checkFriend($data['article_info']['user_id'],$this->getUserId());
            }
        }


        $this->assign($data);
        $this->assign('isFriend',$isFriend);
        $this->assign('shareImg',$shareImg);
        $this->assign('isFabulous',$data['article_info']['isZan'] == 0 ? 1 :2);

        $is_localhost = config('conf.is_localhost');
        if($is_localhost){
            $weixin_config = ['appId'=>'','timestamp'=>'','nonceStr'=>'','signature'=>''];
        }else{
            $config = config('conf.sns_login.weixin');
            $wechatJsSdk = new \wechat\WeChatJsSDK($config['app_id'],$config['app_secret']);
            $weixin_config = $wechatJsSdk->getSignPackage();
        }

        $this->assign('weixin_config',$weixin_config);
        return $this->fetch('article/article_details2');
    }

    /**
     * 文章视频页
     */
    public function articleVideo(){
        return $this->fetch('article/article_video');
    }
    /**
     * 个人文章详情
     */
    public function userRelease(){
        return $this->fetch('article/user_release');
    }
    /**
     * 获取文章评论信息
     */
    public function getCommentList(Request $request){
        $id = $request->param('id',0);
        $page = $request->param('page',1);
        $page_size = $request->param('page_size',20);
        $user_id = 0;
        if($this->checkLogin()){
            $user_id = $this->getUserInfo()['id'];
        }

        $data = $this->articleDomain->getFirstComment($id,$page,$page_size,$user_id);

        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                $time = strtotime($v['created_time']);
                $data['rows'][$k]['created_time'] = formatTime($time);


                if($v['user_type'] == 3){
                    $data['rows'][$k]['nickname'] = $v['username'];
                }else if($v['user_type'] == 4 || $v['user_type'] == 5){
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }

        return $this->returnData($data,'',200);
    }

    /**
     * 获取文章二级以上评论信息
     */
    public function getSecondCommentList(Request $request){
        $id             = (int)$request->param('id',0);
        $comment_id     = (int)$request->param('comment_id',0);
        $page           = $request->param('page',1);
        $page_size      = $request->param('page_size',20);
        $user_id        = 0;

        if(empty($id) || empty($page_size)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        if($this->checkLogin()){
            $user_id = $this->getUserInfo()['id'];
        }

        $data = $this->articleDomain->getSecondComment($id,$comment_id,$page,$page_size,$user_id);
        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                $time1= strtotime($v['created_time']);
                $data['rows'][$k]['created_time'] = formatTime($time1);

                $time = strtotime($v['parent']['created_time']);
                $data['rows'][$k]['parent']['created_time'] = formatTime($time);
            }
        }
        return $this->returnData($data,'',200);
    }

    /**
     * 添加收藏
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addFavorite(Request $request){
        $id = (int)$request->param('id',0);

        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后再进行操作',401);
        }

        if($id == 0){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $res = (new \app\api\domain\ArticleDomain())->createFavoriteArticle($this->getUserId(),$id);
        if(!$res){
            return $this->returnData([],'操作失败',305);
        }

        return $this->returnData([],'操作成功',200);
    }
}