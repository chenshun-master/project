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
    private $_userFavoriteDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_userDomain = new \app\api\domain\UserDomain();

        $this->_articleDomain = new \app\api\domain\ArticleDomain();

        $this->_userModel = new \app\api\model\UserModel();

        $this->_userFriendDomain = new \app\api\domain\UserFriendDomain();

        $this->_authDomain = new \app\api\domain\AuthDomain();


        $this->_userFavoriteDomain = new \app\api\domain\UserFavoriteDomain();
    }

    /**
     * 用户中心主页
     * @return mixed
     */
    public function main()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->_publishTotal($this->getUserId());

        $isSignOut = is_weixin() && config('conf.weixin_automatic_logon') ? false : true;
        $this->assign([
            'user_info' => $user_info,
            'contactMobile' => config('conf.website.mobile'),
            'isSignOut' => $isSignOut,
        ]);
        return $this->fetch('user/main2');
    }

    /**
     * 修改资料页面
     * @return mixed
     */
    public function modify()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());

        $this->assign('user_info', $user_info);
        return $this->fetch('user/modify');
    }

    /**
     * 移动端个人认证
     * @return mixed
     */
    public function userCertification()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $authDomain = new \app\api\domain\AuthDomain();
        $authRes = $authDomain->findAuthResult($this->getUserId());


        if ($authRes) {
            if ($authRes['status'] == 1 || $authRes['status'] == 3) {
                return redirect('/weixin/user/certification');
            }
        }

        $this->assign('type', $authRes ? $authRes['type'] : 0);

        return $this->fetch('user/user_certification');
    }

    /**
     * 我的好友粉絲頁面
     * @return mixed
     */
    public function friends()
    {
        if (!$this->checkLogin()) {
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
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }
        return $this->fetch('user/collection');
    }

    /**
     * 我的对话页面
     * @return mixed
     */
    public function userDialogue(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $uid = $request->param('uid/d', 0);

        $isFriend = $this->_userFriendDomain->checkFollowOrFriend($uid, $this->getUserId());

        $userInfo = $this->_userDomain->getUserInfo($uid);

        if ($userInfo['type'] == 3 || $userInfo['type'] == 4 || $userInfo['type'] == 5) {
            $model = new \app\api\model\AuthModel();
            $res = $model->findUserId($uid);
            if ($res) {
                if ($userInfo['type'] == 3) {
                    $userInfo['nickname'] = $res['username'];
                } else if ($userInfo['type'] == 4 || $userInfo['type'] == 5) {
                    $userInfo['nickname'] = $res['enterprise_name'];
                }
            }
        }

        $this->assign('isFriend', $isFriend ? 1 : 2);
        $this->assign('uid', $uid);
        $this->assign('uInfo', $userInfo);
        $this->assign('portrait', $this->_userDomain->getUserInfo($this->getUserId())['portrait']);

        return $this->fetch('user/user_dialogue');
    }


    /**
     * 消息通知页面
     * @return mixed
     */
    public function dialogue(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $id = $request->param('id', 0);
        $messageDomain = new \app\api\domain\MessageDomain();
        $data = $messageDomain->getMsgDetail($id, $this->getUserId());

        if (!$data) {
            return redirect('index/error404');
        }

        $this->assign('msg', $data);

        return $this->fetch('user/dialogue');
    }

    /**
     * 申请认证页面
     * @return mixed|\think\response\Redirect
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function certification()
    {
        if (!$this->checkLogin()) {
            return redirect('index/login');
        }

        $authDomain = new \app\api\domain\AuthDomain();
        $authRes = $authDomain->findAuthResult($this->getUserId());
        if (!$authRes) {
            return redirect('/weixin/user/userCertification');
        }

        $this->assign('authRes', $authRes);
        return $this->fetch('user/certification');
    }

    /**
     * 消息通知页面
     * @return mixed
     */
    public function notice()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $model = new \app\api\domain\UserFriendDomain();
        $applyList = $model->getFriendsApplyList($this->getUserId());
        $this->assign('applyList', $applyList);

        return $this->fetch('user/notice');
    }

    /**
     * 修改手机号
     */
    public function replacephone()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $mobile = $this->_userModel->getMobile($this->getUserId());

        $this->assign('mobile', $mobile);
        return $this->fetch('user/replace_phone');
    }

    /**
     * 手机号修改提交处理页面
     */
    public function changeMobile(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $mobile = $request->post('mobile', '');
        $sms_code = $request->post('sms_code', '');
        if (empty($mobile) || !checkMobile($mobile) || empty($sms_code)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $oldMobile = $this->_userModel->getMobile($this->getUserId());
        $result = $this->_userDomain->changeMobile($this->getUserId(), $oldMobile, $mobile, $sms_code);
        if ($result === 1) {
            return $this->returnData([], '验证码错误', 302);
        } else if ($result === 2) {
            return $this->returnData([], '验证码已过期', 303);
        } else if (!$result) {
            return $this->returnData([], '修改手机号失败', 305);
        }

        return $this->returnData([], '修改手机号成功', 200);
    }

    /**
     * 用户头像修改
     */
    public function uploadHead(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $img = $request->post('img');
        $data = base64_decode(str_replace(['data:image/jpeg;base64,', ' '], ['', '+'], $img));

        $img = $this->_userDomain->uploadHead($this->getUserId(), $data);
        if ($img === false) {
            return $this->returnData([], '上传失败', 305);
        }

        return $this->returnData(['imgUrl' => $img], '上传成功', 200);
    }

    /**
     * 修改用户密码
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function changePassword(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $old_password = $request->param('old_password', '');
        $new_password = $request->param('new_password', '');

        if (empty($old_password) || empty($new_password)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        if ($old_password == $new_password) {
            return $this->returnData([], '新密码不能与旧密码一致', 302);
        }

        $user_info = $this->getUserInfo();
        $isTrue = $this->_userDomain->editPwd($user_info['id'], $old_password, $new_password);
        if ($isTrue) {
            return $this->returnData([], '密码修改成功', 200);
        }
        return $this->returnData([], '密码修改失败', 305);
    }

    /**
     * 修改密码页面
     * @return mixed|\think\response\Redirect
     */
    public function modifypwd()
    {
        if (!$this->checkLogin()) {
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
    public function addFriend(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $friend_id = $request->post('friend_id', 0);
        $remarks = $request->post('remarks', '');
        $isTrue = \Validate::checkRule($friend_id, 'number');

        if (!$isTrue || $friend_id == 0) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $res = $this->_userFriendDomain->createFriend($this->getUserId(), $friend_id, $remarks);
        if (!$res) {
            return $this->returnData([], '添加好友申请失败', 305);
        }

        return $this->returnData([], '添加好友申请成功', 200);
    }

    /**
     * 解除好友关系
     */
    public function agreeFriend()
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $id = $request->param('id', 0);
        $isTrue = \Validate::checkRule($id, 'number');
        if ($isTrue) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $user_info = $this->getUserInfo();
        $res = $this->_userDomain->delFriend($user_info['id'], $friend_id);
        if (!$res) {
            return $this->returnData([], '解除好友关系失败', 305);
        }

        return $this->returnData([], '解除好友关系成功', 200);
    }

    /**
     * 退出登录
     */
    public function signOut()
    {
        $this->clearUserLogin();
        return redirect('/weixin/index/login');
    }

    /**
     * 用户文章列表页面
     */
    public function userArticleList()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $user_info = $this->_userDomain->getUserInfo($this->getUserId());
        $this->_publishTotal($this->getUserId());

        $this->assign('user_info', $user_info);

        return $this->fetch('user/userArticleList');
    }

    /**
     * 用户视频列表页面
     */
    public function userVideoList()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $user_info = $this->getUserInfo();

        $this->_publishTotal($this->getUserId());
    }

    /**
     * 用户案例列表页面
     */
    public function userCaseList()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $this->_publishTotal($this->getUserId());
    }

    /**
     * 用户问答列表页面
     */
    public function userProblemList()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $this->_publishTotal($this->getUserId());
    }

    /**
     * 获取用户统计数据
     * @param $user_id
     */
    private function _publishTotal($user_id)
    {
        $res = $this->_articleDomain->getArticleStatisticsData($user_id);

        $data = [
            'type_1' => ['type' => 1, 'total' => 0],
            'type_2' => ['type' => 2, 'total' => 0],
            'type_3' => ['type' => 3, 'total' => 0],
            'type_4' => ['type' => 4, 'total' => 0]
        ];

        if ($res) {
            foreach ($res as $val) {
                $type = 'type_' . $val['type'];
                $data[$type] = $val;
            }
        }

        $this->assign('publishStatistics', $data);
    }

    /**
     * 获取用户发布列表信息
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPublishList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $type = (int)$request->param('type', 1);
        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 10);

        if (empty($type) || empty($page) || empty($page_size)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $data = $this->_articleDomain->getUserPublishArticle($this->getUserId(), $type, $page, $page_size, true, $this->getUserId());

        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $v) {
                if ($v['user_type'] == 3) {
                    $data['rows'][$k]['nickname'] = $v['username'];
                } else if ($v['user_type'] == 4 || $v['user_type'] == 5) {
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }


        $this->assign($data);

        $data['htmlContent'] = $this->fetch('user/userArticleList_tpl');

        return $this->returnData($data, '', 200);
    }

    /**
     * 提交修改信息页面
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editProfile(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $nickname = $request->post('nickname', '');
        $sex = (int)$request->post('sex', 0);
        $profile = $request->post('profile', '');
        $birthday_date = $request->post('birthday_date', '0000-00-00');

        if (empty($nickname)) {
            return $this->returnData([], '请求参数不符合规范', 301);
        }

        $res = $this->_userDomain->editProfile($this->getUserId(), [
            'nickname' => $nickname,
            'sex' => (int)$sex,
            'profile' => $profile,
            'birthday_date' => $birthday_date
        ]);

        if (!$res) {
            return $this->returnData([], '修改失败', 305);
        }

        return $this->returnData([], '修改成功', 200);
    }

    /**
     * 用户用户评论过的文章列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCommentArticleList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $data = $this->_articleDomain->getCommentArticle($this->getUserId(), $page, $page_size);
        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $v) {
                if ($v['user_type'] == 3) {
                    $data['rows'][$k]['nickname'] = $v['username'];
                } else if ($v['user_type'] == 4 || $v['user_type'] == 5) {
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }

        $this->assign($data);
        $data['html'] = $this->fetch('user/collection/comment_tpl');

        return $this->returnData($data, '', 200);
    }

    /**
     * 获取用户收藏列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFavoriteArticleList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $data = $this->_userFavoriteDomain->getFavoriteArticleList($this->getUserId(), $page, $page_size);
        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $v) {
                if ($v['user_type'] == 3) {
                    $data['rows'][$k]['nickname'] = $v['username'];
                } else if ($v['user_type'] == 4 || $v['user_type'] == 5) {
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }

        $this->assign($data);
        $data['html'] = $this->fetch('user/collection/favorite_tpl');


        return $this->returnData($data, '', 200);
    }

    /**
     * 获取用户点赞列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getLikeArticleList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $data = $this->_articleDomain->getArticleLikeData($this->getUserId(), $page, $page_size);
        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $v) {
                if ($v['user_type'] == 3) {
                    $data['rows'][$k]['nickname'] = $v['username'];
                } else if ($v['user_type'] == 4 || $v['user_type'] == 5) {
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }

        $this->assign($data);
        $data['html'] = $this->fetch('user/collection/like_tpl');

        return $this->returnData($data, '', 200);
    }

    /**
     * 获取网站通知列表
     */
    public function getNoticeList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $messageDomain = new \app\api\domain\MessageDomain();
        $data = $messageDomain->getNoticeMsgList($page, $page_size);

        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $val) {
                $data['rows'][$k]['created_time'] = date('Y-m-d', strtotime($val['created_time']));
            }
        }

        return $this->returnData($data, '', 200);
    }

    /**
     * 获取网站通知列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserMailList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $messageDomain = new \app\api\domain\MessageDomain();
        $data = $messageDomain->getUserMailList($this->getUserId(), $page, $page_size);

        if (count($data['rows']) > 0) {
            foreach ($data['rows'] as $k => $val) {
                $data['rows'][$k]['created_time'] = date('Y-m-d', strtotime($val['created_time']));
            }
        }

        return $this->returnData($data, '', 200);
    }

    /**
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function agreeFriendsApply(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $id = (int)$request->param('id', 0);
        $userFriendDomain = new \app\api\domain\UserFriendDomain();
        $isTrue = $userFriendDomain->handleFriendsApply($this->getUserId(), $id, 2);

        if (!$isTrue) {
            return $this->returnData([], '操作失败', 305);
        }
        return $this->returnData([], '操作成功', 200);
    }

    /**
     * 获取用户私信列表
     * @param Request $request
     * @return false|string
     */
    public function getPrivateLetterList(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $page = (int)$request->param('page', 1);
        $page_size = (int)$request->param('page_size', 15);

        $userFriendDomain = new \app\api\domain\UserFriendDomain();
        $data = $userFriendDomain->getMessageListData($this->getUserId());

        if ($data['rows']) {
            foreach ($data['rows'] as $k => $val) {
                $data['rows'][$k]['created_time'] = formatTime(strtotime($val['created_time']));
                if ($val['type'] == 3) {
                    $data['rows'][$k]['nickname'] = $val['username'];
                } else if ($val['type'] == 4 || $val['type'] == 5) {
                    $data['rows'][$k]['nickname'] = $val['enterprise_name'];
                }
            }
        }

        return $this->returnData($data, '', 200);
    }

    /**
     * 账号申请认证接口
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function applyAuth(Request $request)
    {
        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        }

        $data = \Request::only([
            'username' => '', 'idcard' => '',
            'card_img1' => '', 'card_img2' => '',
            'qualification' => '', 'practice_certificate' => '',
            'enterprise_name' => '', 'business_licence' => '',
            'mobile' => '', 'sms_code' => '',
            'hospital_type' => '',
            'founding_time' => '', 'speciality' => '',
            'profile' => '', 'scale' => '', 'duties' => '',

            'province' => '',
            'city' => '',
            'area' => '',
            'address' => '',
        ], 'post');


        $type = $request->post('type', 0);
        if (!in_array($type, [1, 2, 3, 4])) {
            return $this->returnData([], '参数不符合规范', 301);
        }

        $data['type'] = $type;
        $data['user_id'] = $this->getUserId();
        $validate = new \app\index\validate\addAuth();
        if (!$validate->scene('auth' . $type)->check($data)) {
            return $this->returnData([], $validate->getError(), 301);
        }

        if ($type == 3 || $type == 4) {
            $smsObj = new \app\api\domain\SendSms();
            $res = $smsObj->checkSmsCode($data['mobile'], 7, $data['sms_code']);
            if ($res === 0 || $res === 2) {
                return $this->returnData([], '验证码错误', 302);
            }
        }

        $data['phone'] = $data['mobile'];
        unset($data['mobile']);
        unset($data['sms_code']);

        $isTrue = $this->_authDomain->addAuthentication($data);
        if ($isTrue === true) {
            return $this->returnData([], '认证申请提交成功', 200);
        } else if ($isTrue === 1) {
            return $this->returnData([], '身份证号已被使用', 303);
        } else {
            return $this->returnData([], '认证申请提交失败', 305);
        }
    }

    /**
     * 用户点赞操作
     * @param  obj_id        点赞的对象id
     * @param  flag          点赞对象的标识   1:文章点赞  2:评论点赞   3:分销商品点赞 4:日记点赞
     * @param  type          点赞操作方式  1:点赞  2:取消点赞
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function giveFabulous()
    {
        $object_id = $this->request->param('obj_id/d', 0);
        $flag = $this->request->param('flag/d', '');
        $type = $this->request->param('type/d', 0);

        $result = false;
        $linkDomain = new \app\api\domain\UserLikeDomain();
        $flag = $linkDomain::getTypeName($flag);

        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        } else if (empty($object_id) || empty($flag)) {
            return $this->returnData([], '参数不符合规范', 301);
        } elseif ($type == 1) {
            $result = $linkDomain->createLike($this->getUserId(), $object_id, $flag);
        } else if ($type == 2) {
            $result = $linkDomain->cancelLike($object_id, $this->getUserId(), $flag);
        }

        if ($result) {
            return $this->returnData([], '操作成功', 200);
        } else {
            return $this->returnData([], '操作失败', 305);
        }
    }

    /**
     * 用户收藏操作
     * @param  obj_id        收藏的对象id
     * @param  flag          收藏对象的标识   1:文章收藏  2:商品收藏 3:分销商品收藏
     * @param  type          收藏操作方式  1:收藏  2:取消收藏
     * @return false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function giveFavorite()
    {
        $object_id = $this->request->param('obj_id/d', 0);
        $flag = $this->request->param('flag/d', '');
        $type = $this->request->param('type/d', 0);

        $result = false;
        $favoriteDomain = new \app\api\domain\UserFavoriteDomain();
        $flag = $favoriteDomain::getTypeName($flag);

        if (!$this->checkLogin()) {
            return $this->returnData([], '用户未登录', 401);
        } else if (empty($object_id) || empty($flag)) {
            return $this->returnData([], '参数不符合规范', 301);
        } elseif ($type == 1) {
            $result = $favoriteDomain->createFavorite($this->getUserId(), $object_id, $flag);
        } else if ($type == 2) {
            $result = $favoriteDomain->cancelFavorite($object_id, $this->getUserId(), $flag);
        }

        if ($result) {
            return $this->returnData([], '操作成功', 200);
        } else {
            return $this->returnData([], '操作失败', 305);
        }
    }

    /**
     *我的积分页面
     */
    public function scoreRecord()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $uinfo = $this->_userDomain->getUserInfo($this->getUserId());
        $this->assign('uinfo',$uinfo);
        return $this->fetch('user/score_record');
    }

    /**
     *我的余额页面
     */
    public function balanceOf()
    {
        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        if (!$this->checkLogin()) {
            return redirect('/weixin/index/login');
        }

        $uinfo = $this->_userDomain->getUserInfo($this->getUserId());
        $this->assign('uinfo',$uinfo);
        return $this->fetch('user/balance_of');
    }
}