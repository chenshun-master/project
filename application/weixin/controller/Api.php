<?php
namespace app\weixin\controller;

use think\App;
use think\Request;
use app\api\domain\Singleton;

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

        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                if($v['type'] == 3){
                    $data['rows'][$k]['nickname'] = $v['username'];
                }else if($v['type'] == 4 || $v['type'] == 5){
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }
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
        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                if($v['type'] == 3){
                    $data['rows'][$k]['nickname'] = $v['username'];
                }else if($v['type'] == 4 || $v['type'] == 5){
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
        }

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
        if(count($data['rows']) > 0){
            foreach ($data['rows'] as  $k=>$v){
                if($v['type'] == 3){
                    $data['rows'][$k]['nickname'] = $v['username'];
                }else if($v['type'] == 4 || $v['type'] == 5){
                    $data['rows'][$k]['nickname'] = $v['enterprise_name'];
                }
            }
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

    /**
     * 获取分类列表
     */
    public function getCategoryInfo(Request $request){
        $category_id = $request->post('category_id',0);

        $domain = new \app\api\domain\SpCategory();
        $domain->getCategoryList($category_id);
    }

    /**
     * 获取用户积分记录列表
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getScoreRecord(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page      = $this->request->param('page',1);
        $page_size = $this->request->param('page_size',15);

        $data = $this->_userDomain->getUserScoreRecord($this->getUserId(),$page,$page_size);
        if(count($data['rows']) > 0){
            foreach ($data['rows'] as $k=>$row){
                if($row['style'] == 2){
                    $data['rows'][$k]['score'] = '-'.abs($row['score']);
                }else if($row['style'] == 1){
                    $data['rows'][$k]['score'] = '+'.abs($row['score']);
                }
            }
        }

        return $this->returnData($data);
    }

    /**
     * 获取用户资金记录列表
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAccountRecord(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $page      = $this->request->param('page',1);
        $page_size = $this->request->param('page_size',15);
        $data = $this->_userDomain->getUserAccountRecord($this->getUserId(),$page,$page_size);
        if(count($data['rows']) > 0){
            foreach ($data['rows'] as $k=>$row){
                if($row['status'] == 2){
                    $data['rows'][$k]['amount'] = '-'.abs($row['amount']);
                }else if($row['status'] == 1){
                    $data['rows'][$k]['amount'] = '+'.abs($row['amount']);
                }
            }
        }

        return $this->returnData($data);
    }

    /**
     * 获取美丽日记列表
     */
    public function getDiaryList(){
        $page      = $this->request->param('page',1);
        $page_size = $this->request->param('page_size',15);

        $data = (new \app\api\domain\DiaryDomain())->getListData($page,$page_size);
        return $this->returnData($data);
    }

    /**
     * 获取日记推荐
     * @param  int diary_id   日记id
     * @return false|string
     * @throws \think\Exception
     */
    public function getRelevantDiaryList(){
        $id      = $this->request->param('diary_id/d',0);

        if($id == 0){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        $page      = $this->request->param('page',1);
        $page_size = $this->request->param('page_size',15);
        $data = Singleton::getDomain('diarydomain')->getRelevantDiaryList($id,$page,$page_size);
        return $this->returnData($data);
    }

    /**
     * 获取日记评论列表
     * @param  int diary_id   日记id
     * @return false|string
     * @throws \think\Exception
     */
    public function getDiaryComment()
    {
        $id = $this->request->param('diary_id/d', 0);
        $page = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = Singleton::getDomain('diarydomain')->getDiaryCommentList($id,$this->getUserId(),$page,$page_size,$this->getUserId());
        return $this->returnData($data);
    }

    /**
     * 获取分销商品评论
     */
    public function addDiaryComment()
    {
        $data  = [
            'parent_id'=>$this->request->post('pid/d', 0),
            'user_id'=>$this->getUserId(),
            'object_id'=>$this->request->post('obj_id/d', 0),
            'content'=>$this->request->post('content', ''),
        ];

        if(!$this->checkLogin()){
            return $this->returnData([], '用户未登录', 401);
        }else if(empty($data['object_id']) || empty($data['content'])){
            return $this->returnData([], '参数不符合规范', 301);
        }else if(Singleton::getDomain('CommentDomain')->createComment($data,'diary')){
            return $this->returnData([], '评论成功...', 200);
        }

        return $this->returnData([], '评论失败...', 305);
    }

    /**
     * 获取用户发布的项目
     */
    public function getUserGoods(){
        $uid       = $this->request->param('uid/d', 0);
        $page      = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = Singleton::getDomain('spgoodsdomain')->getUserGoods($uid,$page,$page_size);
        return $this->returnData($data);
    }

    /**
     * 获取用户发布的项目
     */
    public function getUserDiary(){
        $uid       = $this->request->param('uid/d', 0);
        $goodsid   = $this->request->param('goodsid/d', 0);

        $page      = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $searchParams = [];
        if(empty($goodsid)){
            $searchParams['goods_id'] = $goodsid;
        }

        $data = Singleton::getDomain('DiaryDomain')->getUserDiary($uid,$page,$page_size,$searchParams);
        return $this->returnData($data);
    }

    /**
     * 获取用户分销商品列表
     */
    public function getUserGoodGoods()
    {
        $uid       = $this->request->param('uid/d', 0);
        $page = $this->request->param('page/d',1);
        $page_size = $this->request->param('page_size',15);
        $data = (new \app\api\domain\SpGoodGoodsDomain())->getUserGoodGoodsList($uid,$page,$page_size);
        return $this->returnData($data);
    }

    /**
     * 获取问答题目列表数据
     */
    public function getInquiryList(){
        $page      = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = Singleton::getDomain('InquiryDomain')->getInquiryList($page,$page_size);
        return $this->returnData($data);
    }

    /**
     * 获取问答题目列表数据
     */
    public function getAnswerList(){
        $id       = $this->request->param('id/d', 0);
        $page      = $this->request->param('page/d', 1);
        $page_size = $this->request->param('page_size/d', 15);

        $data = Singleton::getDomain('InquiryDomain')->getAnswerList($id,$page,$page_size);
        return $this->returnData($data);
    }
}