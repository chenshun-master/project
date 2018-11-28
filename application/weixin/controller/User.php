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
    private $_articleDomain;
    private $_userModel;
    private $_userFriendDomain;
    private $_authDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_userDomain = new \app\api\domain\UserDomain();

        $this->_articleDomain = new \app\api\domain\ArticleDomain();

        $this->_userModel = new \app\api\model\UserModel();

        $this->_userFriendDomain = new \app\api\domain\UserFriendDomain();

        $this->_authDomain = new \app\api\domain\AuthDomain();
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

        $this->_publishTotal($this->getUserId());

        $isSignOut = is_weixin() && config('conf.weixin_automatic_logon')  ? false : true;
        $this->assign([
            'user_info'=>$user_info,
            'contactMobile'=>config('conf.website.mobile'),
            'isSignOut' =>$isSignOut,
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
     * 移动端个人认证
     * @return mixed
     */
    public function userCertification()
    {
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $authDomain = new \app\api\domain\AuthDomain();
        $authRes = $authDomain->findAuthResult($this->getUserId());


        if($authRes){
            if($authRes['status'] == 1 || $authRes['status'] == 3){
                return redirect('/weixin/user/certification');
            }
        }

        $this->assign('type',$authRes ?$authRes['type']:0);

        return $this->fetch('user/user_certification');
    }
    /**
     * 我的好友粉絲頁面
     * @return mixed
     */
    public function friends()
    {
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        return $this->fetch('user/friends');
    }

    /**
     * 我的收藏页面
     * @return mixed
     */
    public function collection()
    {
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }
        return $this->fetch('user/collection');
    }
    /**
     * 我的对话页面
     * @return mixed
     */
    public function userDialogue(Request $request){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $uid =  $request->param('uid/d',0);

        $isFriend = $this->_userFriendDomain->checkFollowOrFriend($uid,$this->getUserId());

        $this->assign('isFriend',$isFriend ? 1 : 2);
        $this->assign('uid',$uid);
        $this->assign('uInfo',$this->_userDomain->getUserInfo($uid));
        $this->assign('portrait',$this->_userDomain->getUserInfo($this->getUserId())['portrait']);

        return $this->fetch('user/user_dialogue');
    }


    /**
     * 消息通知页面
     * @return mixed
     */
    public function dialogue(Request $request){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $id =  $request->param('id',0);
        $messageDomain = new \app\api\domain\MessageDomain();
        $data = $messageDomain->getMsgDetail($id,$this->getUserId());

        if(!$data){
            return redirect('index/error404');
        }

        $this->assign('msg',$data);

        return $this->fetch('user/dialogue');
    }

    /**
     * 申请认证页面
     * @return mixed|\think\response\Redirect
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function certification(){
        if(!$this->checkLogin()){
            return redirect('index/login');
        }

        $authDomain = new \app\api\domain\AuthDomain();
        $authRes = $authDomain->findAuthResult($this->getUserId());
        if(!$authRes){
            return redirect('/weixin/user/userCertification');
        }

        $this->assign('authRes',$authRes);
        return $this->fetch('user/certification');
    }

    /**
     * 消息通知页面
     * @return mixed
     */
    public function notice(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $model = new \app\api\domain\UserFriendDomain();
        $applyList = $model->getFriendsApplyList($this->getUserId());
        $this->assign('applyList',$applyList);

        return $this->fetch('user/notice');
    }

    /**
     * 修改手机号
     */
    public function replacephone(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $mobile = $this->_userModel->getMobile($this->getUserId());

        $this->assign('mobile',$mobile);
        return $this->fetch('user/replace_phone');
    }

    /**
     * 手机号修改提交处理页面
     */
    public function changeMobile(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $mobile    = $request->post('mobile','');
        $sms_code  = $request->post('sms_code','');
        if(empty($mobile) || !checkMobile($mobile) || empty($sms_code)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $oldMobile = $this->_userModel->getMobile($this->getUserId());
        $result = $this->_userDomain->changeMobile($this->getUserId(),$oldMobile,$mobile,$sms_code);
        if($result === 1){
            return $this->returnData([],'验证码错误',302);
        }else if($result === 2){
            return $this->returnData([],'验证码已过期',303);
        }else if(!$result){
            return $this->returnData([],'修改手机号失败',305);
        }

        return $this->returnData([],'修改手机号成功',200);
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

    /**
     * 修改密码页面
     * @return mixed|\think\response\Redirect
     */
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
    public function addFriend(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $friend_id  = $request->post('friend_id',0);
        $remarks  = $request->post('remarks','');
        $isTrue = \Validate::checkRule($friend_id,'number');

        if(!$isTrue || $friend_id == 0){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $res = $this->_userFriendDomain->createFriend($this->getUserId(),$friend_id,$remarks);
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
        $this->_publishTotal($this->getUserId());

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

        $this->_publishTotal($this->getUserId());
    }

    /**
     * 用户案例列表页面
     */
    public function userCaseList(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $this->_publishTotal($this->getUserId());
    }

    /**
     * 用户问答列表页面
     */
    public function userProblemList(){
        if(!$this->checkLogin()){
            return redirect('/weixin/index/login');
        }

        $this->_publishTotal($this->getUserId());
    }

    /**
     * 获取用户统计数据
     * @param $user_id
     */
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
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
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
            'sex'           =>(int)$sex,
            'profile'       =>$profile,
            'birthday_date' =>$birthday_date
        ]);

        if(!$res){
            return $this->returnData([],'修改失败',305);
        }

        return $this->returnData([],'修改成功',200);
    }

    /**
     * 用户用户评论过的文章列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCommentArticleList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);


        $data = $this->_articleDomain->getCommentArticle($this->getUserId(),$page,$page_size);


        $this->assign($data);
        $data['html'] = $this->fetch('user/collection/comment_tpl');

        return $this->returnData($data,'',200);
    }

    /**
     * 获取用户收藏列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFavoriteArticleList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);

        $data = $this->_articleDomain->getFavoriteArticle($this->getUserId(),$page,$page_size);

        $this->assign($data);
        $data['html'] = $this->fetch('user/collection/favorite_tpl');


        return $this->returnData($data,'',200);
    }

    /**
     * 获取用户点赞列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getLikeArticleList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);

        $data = $this->_articleDomain->getArticleLikeData($this->getUserId(),$page,$page_size);

        $this->assign($data);
        $data['html'] = $this->fetch('user/collection/like_tpl');

        return $this->returnData($data,'',200);
    }

    /**
     * 获取网站通知列表
     */
    public function getNoticeList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);

        $messageDomain = new \app\api\domain\MessageDomain();
        $data = $messageDomain->getNoticeMsgList($page,$page_size);

        if(count($data['rows']) > 0){
            foreach ($data['rows'] as $k=>$val){
                $data['rows'][$k]['created_time']  = date('Y-m-d',strtotime($val['created_time']));
            }
        }

        return $this->returnData($data,'',200);
    }

    /**
     * 获取网站通知列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserMailList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);

        $messageDomain = new \app\api\domain\MessageDomain();
        $data = $messageDomain->getUserMailList($this->getUserId(),$page,$page_size);

        if(count($data['rows']) > 0){
            foreach ($data['rows'] as $k=>$val){
                $data['rows'][$k]['created_time']  = date('Y-m-d',strtotime($val['created_time']));
            }
        }

        return $this->returnData($data,'',200);
    }

    /**
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function agreeFriendsApply(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $id = (int)$request->param('id',0);
        $userFriendDomain = new \app\api\domain\UserFriendDomain();
        $isTrue = $userFriendDomain->handleFriendsApply($this->getUserId(),$id,2);

        if(!$isTrue){
            return $this->returnData([],'操作失败',305);
        }
        return $this->returnData([],'操作成功',200);
    }

    /**
     * 获取用户私信列表
     * @param Request $request
     * @return false|string
     */
    public function getPrivateLetterList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page       = (int)$request->param('page',1);
        $page_size  = (int)$request->param('page_size',15);

        $userFriendDomain = new \app\api\domain\UserFriendDomain();
        $data = $userFriendDomain->getMessageListData($this->getUserId());

        if($data['rows']){
            foreach ($data['rows'] as $k=>$val){
                $data['rows'][$k]['created_time'] = formatTime(strtotime($val['created_time']));
            }
        }

        return $this->returnData($data,'',200);
    }

    /**
     * 账号申请认证接口
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function applyAuth(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $files = $request->file();

        $data = \Request::only([
            'username'=>'','idcard'=>'',
            'card_img1'=>'','card_img2'=>'',
            'qualification'=>'','practice_certificate'=>'',
            'enterprise_name'=>'','business_licence'=>'',
            'mobile'=>'','sms_code'=>'',
            'address'=>'','hospital_type'=>'',
            'founding_time'=>'','speciality'=>'',
            'profile'=>'','scale'=>'','duties'=>'',
        ], 'post');

        $type = $request->post('type',0);
        if(!in_array($type,[1,2,3,4]) || empty($data['username']) || !checkIdCard($data['idcard']) || !isset($files['card_img1']) || !isset($files['card_img2'])){
            return $this->returnData([],'参数不符合规范',301);
        }

        $data['type']       =  $type;
        $data['user_id']    =  $this->getUserId();
        if($type == 2){
            if(!isset($files['qualification']) || !isset($files['practice_certificate']) || empty($data['speciality']) || empty($data['duties']) || empty($data['profile'])){
                return $this->returnData([],'参数不符合规范',301);
            }
        }else if($type == 3){
            if(empty($data['enterprise_name']) || empty($data['hospital_type']) || empty($data['founding_time']) || empty($data['scale']) || empty($data['speciality']) || empty($data['mobile']) || empty($data['sms_code']) || empty($data['address']) || empty($data['profile'])){
                return $this->returnData([],'参数不符合规范',301);
            }
        }else if($type == 4){
            if(empty($data['enterprise_name']) || empty($data['mobile']) || empty($data['sms_code']) || empty($data['address']) || !isset($files['business_licence'])){
                return $this->returnData([],'参数不符合规范',301);
            }
        }

        if($type == 3 || $type == 4){
            $smsObj = new \app\api\domain\SendSms();
            $res = $smsObj->checkSmsCode($data['mobile'],7,$data['sms_code']);
            if($res === 0 || $res === 2){
                return $this->returnData([],'验证码错误',302);
            }
        }

        $data['phone']       =  $data['mobile'];
        unset($data['mobile']);
        unset($data['sms_code']);

        $img_domain = config('conf.file_save_domain');
        $tmp_arr = [];

        try {
            foreach ($files as $k => $file){
                if(in_array($k,['card_img1','card_img2','qualification','practice_certificate','business_licence'])){
                    /**
                    $info = $file->move( 'uploads/');
                    if($info){
                    $url = $img_domain.'/uploads/'.str_replace("\\","/",$info->getSaveName());
                    $data[$k] = $url;
                    if($k == 'card_img1' || $k == 'card_img2'){
                    $tmp_arr[] = ['type'=>2,'img_url' =>$url,'status'=>1,'created_time'=>date('Y-m-d H:i:s')];
                    }else if($k == 'qualification' || $k == 'practice_certificate'){
                    $tmp_arr[] = ['type'=>3,'img_url' =>$url,'status'=>1,'created_time'=>date('Y-m-d H:i:s')];
                    }else{
                    $tmp_arr[] = ['type'=>4,'img_url' =>$url,'status'=>1,'created_time'=>date('Y-m-d H:i:s')];
                    }
                    }else{
                    return $this->returnData([],'文件上传失败',305);
                    }**/
                    $image = \think\Image::open($file);
                    $path = 'uploads/'.date('Ymd');
                    $filename = date('His').uniqid().uniqid().'.png';
                    @mkdir($path, 0755, true);
                    $image->save("{$path}/{$filename}");

                    $url = "{$img_domain}/{$path}/{$filename}";
                    if($k == 'card_img1' || $k == 'card_img2'){
                        $tmp_arr[] = ['type'=>2,'img_url' =>$url,'status'=>1,'created_time'=>date('Y-m-d H:i:s')];
                    }else if($k == 'qualification' || $k == 'practice_certificate'){
                        $tmp_arr[] = ['type'=>3,'img_url' =>$url,'status'=>1,'created_time'=>date('Y-m-d H:i:s')];
                    }else{
                        $tmp_arr[] = ['type'=>4,'img_url' =>$url,'status'=>1,'created_time'=>date('Y-m-d H:i:s')];
                    }

                    $data[$k] = "{$img_domain}/{$path}/{$filename}";
                }
            }
        } catch (\Exception $e) {
            return $this->returnData([],'文件上传失败',305);
        }

        if((new \app\api\domain\PictureLibraryDomain())->createAll($tmp_arr)){
            $isTrue = $this->_authDomain->addAuthentication($data);
            if($isTrue === true){
                return $this->returnData([],'认证申请提交成功',200);
            }else if($isTrue === 1){
                return $this->returnData([],'身份证号已被使用',303);
            }else{
                return $this->returnData([],'认证申请提交失败',305);
            }
        }

        return $this->returnData([],'文件上传失败',305);
    }
}