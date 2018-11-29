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
        $this->_uDomain             = new \app\api\domain\UDomain();
        $this->_userFriendDomain    = new \app\api\domain\UserFriendDomain();
        $this->_userDomain          = new \app\api\domain\UserDomain();
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
        $data = $this->_userFriendDomain->getPrivateLetterList($this->getUserId(),$uid,$record);
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

        $data['unread_num'] = $this->_userFriendDomain->getUnreadNum($uid,$this->getUserId(),$record);

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
     * 医生医院用户关注
     * @param Request $request
     * @return false|string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function followUser(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'请登录后操作...',401);
        }

        $type  = $request->param('type/d',0);
        $uid   = $request->param('uid/d',0);
        $myUid = $this->getUserId();
        if(empty($type) || empty($uid)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        if($type == 1){
            $isTrue = $this->_userFriendDomain->createFollow($uid,$myUid,$myUid);
        }else{
            $isTrue = $this->_userFriendDomain->delFollow($uid,$myUid,$myUid);
        }

        if(!$isTrue){
            return $this->returnData([],'操作失败',305);
        }

        return $this->returnData([],'操作成功',200);
    }


    /**
     * 获取用户关注列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserFollowList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page      = $request->param('page/d',1);
        $page_size = $request->param('page_size/d',15);

        $data = $this->_userFriendDomain->getUserFollowList($this->getUserId(),$page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 获取用户粉丝列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserFansList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page      = $request->param('page/d',1);
        $page_size = $request->param('page_size/d',15);

        $data = $this->_userFriendDomain->getUserFansList($this->getUserId(),$page,$page_size);
        return $this->returnData($data,'',200);
    }

    /**
     * 获取用户好友列表
     * @param Request $request
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getFriendList(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page      = $request->param('page/d',1);
        $page_size = $request->param('page_size/d',15);

        $data = $this->_userFriendDomain->getFriendList($this->getUserId());
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

    /**
     * 获取用户未读消息统计
     * @return false|string
     */
    public function getUnreadMsg(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $msgDomain = new \app\api\domain\MessageDomain();
        $msgInfo = $msgDomain->getUnreadMsg($this->getUserId());

        return $this->returnData($msgInfo,'',200);
    }

    /**
     * 获取地址列表
     */
    public function getAddress(Request $request){
        $region_path  = $request->param('region_path',',');
        $region_grade = $request->param('region_grade/d',1);
        $model = new \app\api\model\RegionsModel();
        $list = $model->getListData(addslashes($region_path),$region_grade);

        if($list){
            foreach ($list as $k=>$val){
                $list[$k]['find_next_region_grade'] = $val['region_grade'] + 1;
            }
        }

        return $this->returnData([
            'infos'=>$list,
            'region_grade'=>$region_grade,
            'request_params'=>[
                'region_path'=>$region_path,
                'region_grade'=>$region_grade
            ]
        ],'',200);
    }


    /**
     * 图片统一上传文件接口
     */
    public function uploadAuthFile(Request $request){
        $file = $request->file("imgFile");
        $type = (int)$request->param('type');

        $img_domain = config('conf.file_save_domain');
        if(!$this->checkLogin()){
            return $this->returnData([],'未授予上传权限',401);
        }

        if($type == 0){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];
        if($file){
            $size = 1024*1024*5;              #单位字节
            if(!$file->checkSize($size)){
                return $this->returnData([],'上传图片大小不能超过5M',305);
            }

            if(!$file->checkExt($fileExt)){
                return $this->returnData([],'文件格式错误只支持gif,jpg,jpeg及png格式的图片',305);
            }

            try {
                $image = \think\Image::open($file);
                $path = '../uploads/auth/'.date('Ymd');
                $save_path = 'auth/'.date('Ymd');
                $filename = date('His').uniqid().uniqid().'.jpeg';
                @mkdir($path, 0755, true);
                $image->save("{$path}/{$filename}");
                $url = "{$img_domain}/{$save_path}/{$filename}";
                $id = (new \app\api\domain\PictureLibraryDomain())->create($type,$url);
                if($id){
                    return $this->returnData(['url'=>$url],'',200);
                }else{
                    return $this->returnData([],'上传失败',305);
                }
            } catch (\Exception $e) {
                return $this->returnData([],'文件上传失败',305);
            }
        }
    }
}