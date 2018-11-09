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
    private $_userDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_userDomain = new \app\api\domain\UserDomain();
        $this->_articleDomain = new \app\api\domain\ArticleDomain();
    }

    /**
     * 用户中心主页
     * @return mixed
     */
    public function main()
    {
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());
        $this->_publishTotal($user_info['id']);

        $this->assign([
            'user_info'=>$user_info,
            'contactMobile'=>config('conf.website.mobile')
        ]);
        return $this->fetch('user/main');
    }
    
   /**
     * 修改资料页面
     * @return mixed
     */
    public function modify()
    {
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign('user_info',$user_info);
        return $this->fetch('user/modify');
    }
   /**
     * 我的收藏页面
     * @return mixed
     */
    public function collection()
    {
        return $this->fetch('user/collection');
    }

    /**
     * 上传用户头像接口
     */
    public function uploadHeadImg(Request $request){
        $file = request()->file("image");
        $img_domain = config('conf.file_save_domain');

        #文件上传类型
        $fileExt   = ['jpg','jpeg','png'];
        if($file){
            $size = 1024*1024*3;              #单位字节
            if(!$file->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过3M',302);
            }

            if(!$file->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持jpg,jpeg及png格式的图片',303);
            }

            $info = $file->move( 'uploads/head');
            if($info){
                $path_dir = $img_domain.'/uploads/head/'.str_replace("\\","/",$info->getSaveName());
                return $this->returnData([
                    'image_url'=>$path_dir
                ],'图片上传成功',200);
            }else{
                return $this->returnData([],$file->getError(),305);
            }
        }
    }

    /**
     * 修改用户密码
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function changePassword(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $old_password  = $request->param('old_password','');
        $new_password  = $request->param('new_password','');

        if(empty($old_password) || empty($new_password)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        if($old_password == $new_password){
            return $this->returnData([],'新密码不能与旧密码一致',302);
        }

        $user_info = $this->getUserInfo();
        $isTrue = $this->_userDomain->editPwd($user_info['id'],$old_password,$new_password);
        if($isTrue){
            return $this->returnData([],'密码修改成功',200);
        }
        return $this->returnData([],'密码修改失败',305);
    }

    public function modifypwd(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        return $this->fetch('user/modify_pwd');
    }


    /**
     * 添加好友申请
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function addFriend(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $friend_id  = $request->param('friend_id',0);
        $isTrue = \Validate::checkRule($friend_id,'number');
        if($isTrue || $friend_id == ''){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $user_info = $this->getUserInfo();
        $res = $this->_userDomain->addFriend($user_info['id'],$friend_id);
        if(!$res){
            return $this->returnData([],'添加好友申请失败',305);
        }

        return $this->returnData([],'添加好友申请成功',200);
    }

    /**
     * 解除好友关系
     */
    public function agreeFriend(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $id  = $request->param('id',0);
        $isTrue = \Validate::checkRule($id,'number');
        if($isTrue || $friend_id == 0){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $user_info = $this->getUserInfo();
        $res = $this->_userDomain->delFriend($user_info['id'],$friend_id);
        if(!$res){
            return $this->returnData([],'解除好友关系失败',305);
        }

        return $this->returnData([],'解除好友关系成功',200);
    }

    /**
     * 退出登录
     */
    public function signOut(){
        $this->clearUserLogin();
        return redirect('/weixin/index/login');
    }

    /**
     * 用户文章列表页面
     */
    public function userArticleList(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $user_info = $this->getUserInfo();
        $this->_publishTotal($user_info['id']);

        $this->assign('user_info',$user_info);

        return $this->fetch('user/userArticleList');
    }

    /**
     * 用户视频列表页面
     */
    public function userVideoList(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $user_info = $this->getUserInfo();

        $this->_publishTotal($user_info['id']);
    }

    /**
     * 用户案例列表页面
     */
    public function userCaseList(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $user_info = $this->getUserInfo();

        $this->_publishTotal($user_info['id']);
    }

    /**
     * 用户问答列表页面
     */
    public function userProblemList(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $user_info = $this->getUserInfo();

        $this->_publishTotal($user_info['id']);
    }

    private function _publishTotal($user_id){
        $res = $this->_articleDomain->getArticleStatisticsData($user_id);

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

        $this->assign('publishStatistics',$data);
    }

    /**
     * 获取用户发布列表信息
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPublishList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $type = (int)$request->param('type',1);
        $page = (int)$request->param('page',1);
        $page_size = (int)$request->param('page_size',10);

        if(empty($type) || empty($page) || empty($page_size)){
            return $this->returnData([],'请求参数不符合规范',301);
        }


        $data = $this->_articleDomain->getUserPublishArticle($this->getUserId(),$type,$page,$page_size,true,$this->getUserId());

        $this->assign($data);

        $data['htmlContent'] = $this->fetch('user/userArticleList_tpl');

        return $this->returnData($data,'',200);
    }

    /**
     * 提交修改信息页面
     */
    public function editProfile(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $nickname   = $request->post('nickname','');
        $sex        = (int)$request->post('sex',0);
        $profile    = $request->post('profile','');
        $birthday_date    = $request->post('birthday_date','0000-00-00');

        if(empty($nickname)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $res = $this->_userDomain->editProfile($this->getUserId(),[
            'nickname'      =>$nickname,
            'sex'           =>$sex,
            'profile'       =>$profile,
            'birthday_date' =>$birthday_date
        ]);

        if(!$res){
            return $this->returnData([],'修改失败',305);
        }

        return $this->returnData([],'修改成功',200);
    }

    public function getCommentArticle(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);


        $data = $this->_articleDomain->getCommentArticle($this->getUserId(),$page,$page_size);
    }

}