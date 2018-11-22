<?php
namespace app\weixin\controller;

use think\App;
use think\Request;

/**
 * ajax 请求接口
 * @package app\weixin\controller
 */
class Api extends BaseController
{
    private  $_uDomain;
    private $_userFriendDomain;
    private  $_userDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_uDomain = new \app\api\domain\UDomain();

        $this->_userFriendDomain = new \app\api\domain\UserFriendDomain();


        $this->_userDomain = new \app\api\domain\UserDomain();
    }

    /**
     * 获取医生列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDoctorList(Request $request){
        $page      = $request->get('page/d',1);
        $page_size = $request->get('page_size/d',15);

        $data = $this->_uDomain->getDoctorListData($page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 获取医院机构列表
     */
    public function getHospitalList(Request $request){
        $page      = $request->get('page/d',1);
        $page_size = $request->get('page_size/d',15);

        $data = $this->_uDomain->getHospitalListData($page,$page_size);

        return $this->returnData($data,'',200);
    }

    /**
     * 获取用户对话记录
     */
    public function getDialogueList(Request $request){

        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $uid      = $request->param('uid',0);
        $record   = $request->param('record_id',0);
        $data = $this->_userFriendDomain->getPrivateLetterList(39,43,$record);
        $user_id = $this->getUserId();
        if($data['rows']){
            $ids = [];
            foreach ($data['rows'] as $val){
                if($val['receive_user_id'] == $user_id && $val['is_read'] == 1){
                    $ids[] = $val['id'];
                }
            }

            if($ids){
                $this->_userFriendDomain->uploadPrivateLetterStatus($user_id,$ids);
            }
        }

        return $this->returnData($data,'',200);
    }

    public function sendDialogueContent(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $uid      = $request->param('uid',0);
        $record   = $request->param('record_id',0);
        $content   = $request->param('content','');

        $data = $this->_userFriendDomain->createFriendMsg($this->getUserId(),$uid,$content);

        if(!$data){
            return $this->returnData([],'',305);
        }

        return $this->returnData($data,'',200);
    }

    /**
     * 手动审核认证
     * @param Request $request
     * @return false|string
     */
    public function authVerify(Request $request){
        $username = $request->param('username','');
        $password = $request->param('password','');
        $authId   = $request->param('auth_id/d',0);
        $status   = $request->param('status/d',0);
        if($username == 'xiaorao' && $password == 'wlxiaorao'){
            $domain = new \app\api\domain\AuthDomain();
            $isTrue = $domain->authVerify($authId,$status,'手动审核');
            if(!$isTrue){
                return $this->returnData([],'审核失败',305);
            }
            return $this->returnData([],'审核成功',200);
        }else{
            return $this->returnData([],'用户未授权',305);
        }
    }
}