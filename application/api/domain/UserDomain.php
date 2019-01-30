<?php
namespace app\api\domain;
use app\api\model\UserModel;
use think\Db;
use app\api\traits\DTrait;

/**
 * 用户数据业务处理层
 * @package app\api\domain
 */
class UserDomain
{
    use DTrait;

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * 创建用户
     */
    public function createUser($params){
        $isTrue = $this->userModel->findMobileExists($params['mobile']);
        if($isTrue){
            return 3;
        }

        $data = [
            'mobile'        =>$params['mobile'],
            'nickname'      =>mobileFilter($params['mobile']),
            'password'      =>encryptPwd($params['password']),
            'type'          =>1,
            'created_time'  =>date('Y-m-d H:i:s')
        ];

        $id = Db::table('wl_user')->insertGetId($data);
        if(!$id){
            return false;
        }

        return true;
    }

    /**
     * 获取用户信息
     * @param $user_id     用户id
     * @return array|null|\PDOStatement|string|\think\Model
     */
    public function getUserInfo($user_id){
        return $this->userModel->findUserId($user_id);
    }
    /**
     * 获取用户所有信息
     */
    public function userInfo($page,$page_size)
    {
        return $this->userModel->info($page,$page_size);
    }

    /**
     * 获取用户类型
     * @param $user_id
     * @return int
     */
    public function getUserType($user_id){
        $res = $this->userModel->where('id',$user_id)->value('type');
        return $res?:0;
    }

    /**
     * 获取用户认证信息
     */
    public function getAuthInfo($user_id){
        $authInfo = Db::name('auth')->where('user_id',$user_id)->find();

        return $authInfo ?: [];
    }

    /**
     * 登录操作
     * @param $mobile
     * @param $password
     * @param bool $quickLogin   是否需要验证密码
     * @return array|int|null|\PDOStatement|string|\think\Model     2:用户不存在   3:密码错误
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($mobile,$password,$quickLogin=false){
        $info = $this->userModel->findMobile($mobile);
        if(!$info){
            return 2;
        }

        #判断是否需要验证登录密码
        if(!$quickLogin){
            if($info['password'] !== encryptPwd($password)){
                return 3;
            }
        }

        //登录用户读取属于自己的消息通知(后期会加入异步队列处理)
        (new \app\api\domain\MessageDomain())->readMsg($info['id']);
        return $info;
    }

    /**
     * 修改用户登录密码
     * @param $user_id           用户id
     * @param $old_password      用户旧密码
     * @param $new_password      用户新密码
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editPwd($user_id,$old_password,$new_password){
        $password = Db::name('user')->where('id',$user_id)->value('password');
        if(!$password){
            return false;
        }

        if($password !== encryptPwd($old_password)){
            return false;
        }

        if(!Db::table('wl_user') ->where('id', $user_id)->update(['password' => encryptPwd($new_password)])){
            return false;
        }

        return true;
    }

    /**
     * 通过手机号修改密码
     * @param $mobile
     * @param $password
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resetPassword($mobile,$password){
        $res = Db::table('wl_user')
            ->where('mobile', $mobile)
            ->update(['password' => encryptPwd($password)]);

        if($res === false){
            return false;
        }

        return true;
    }

    /**
     * 第三方登录绑定手机号
     * @param $mobile
     * @param $authToken
     * @param $authType
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function bindingMobile($mobile,$authToken,$authType,$openid=''){
        $domain = new \app\api\domain\RhirdPartyUserDomain();
        $res = $domain->getBindingInfo($mobile,$authToken,$authType);
        if($res){return false;}

        $pwd = random(8);
        $data = [
            'mobile'        =>$mobile,
            'nickname'      =>mobileFilter($mobile),
            'password'      =>encryptPwd($pwd),
            'type'          =>1,
            'created_time'  =>date('Y-m-d H:i:s')
        ];

        $user_info = Db::name('user')->where('mobile',$mobile)->field('id')->find();

        $arr = [];
        if($authType == 1){
            $arr = ['wx_unionid'=>$authToken,'wx_openid'=>$openid];
        }else if($authType == 2){
            $arr = ['qq_openid'=>$authToken];
        }else if($authType == 3){
            $arr = ['wb_openid'=>$authToken];
        }else if($authType == 4){
            $arr = ['zfb_openid'=>$authToken];
        }

        Db::startTrans();
        try {
            if($user_info){
                $user_id = $user_info['id'];
            }else{
                $user_id = Db::name('user')->insertGetId($data);
                if(!$user_id){
                    throw new \think\Exception('创建用户信息失败');
                }
            }

            $otherInfo = Db::name('third_party_user')->where('user_id',$user_id)->find();
            if($otherInfo){
                $isTrue = Db::name('third_party_user')->where('id', $otherInfo['id'])->update($arr);
                if(!$isTrue){
                    throw new \think\Exception('更新异常');
                }
            }else{
                $arr['user_id'] = $user_id;
                if(!Db::name('third_party_user')->insertGetId($arr)){
                    throw new \think\Exception('更新异常');
                }
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();return false;
        }
    }

    /**
     * 修改用户信息
     * @param $user_id          用户id
     * @param $data             修改数据
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function editProfile($user_id,$data){
        $res = Db::name('user')
            ->where('id', $user_id)
            ->update($data);

        if($res === false){
            return false;
        }

        return true;
    }

    /**
     * 修改用户手机号
     * @param $user_id         用户ID
     * @param $old_mobile      用户旧手机号
     * @param $new_mobile      用户新手机号
     * @param $sms_code        用户手机号验证码
     * @return bool|int
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function changeMobile($user_id,$old_mobile,$new_mobile,$sms_code){
        $smsObj = new \app\api\domain\SendSms();
        $res = $smsObj->checkSmsCode($new_mobile,6,$sms_code);
        if($res == 0){
            return 1;
        }else if($res == 2){
            return 2;
        }

        $isTrue = Db::name('user')->where('id',$user_id)->where('mobile',$old_mobile)->update(['mobile'=>$new_mobile]);
        if($isTrue === false){
            return false;
        }

        return true;
    }

    /**
     * 获取文章发布者信息
     */
    public function getArticleUserInfo($user_id){
        return  Db::name('user')->where('id',$user_id)->field('id,type,mobile,nickname,portrait,profile')->find();
    }

    /**
     * 上传用户头像
     * @param $user_id    用户ID
     * @param $imgText    图片流内容
     * @return bool|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function uploadHead($user_id,$imgText){
        $save_path = 'head';
        $dir = "/../uploads/{$save_path}";
        $path = $_SERVER['DOCUMENT_ROOT'] .$dir;

        if (!is_dir($path)) {
            @mkdir($path, 0755, true);
        }

        $filename = encryptPwd2($user_id).'.png';

        $file_res = file_put_contents($path.'/'.$filename, $imgText);
        if(!$file_res){
            return false;
        }

        $img_url = config('conf.file_save_domain').'/'.$save_path.'/'.$filename;
        $isTrue2 = Db::name('user')->where('id',$user_id)->update(['portrait'=>$img_url]);
        if($isTrue2 === false){
            return false;
        }

        return $img_url.'?v='.getRand(8);
    }

    /**
     * 获取用户积分记录
     * @param $user_id           用户ID
     * @param int $page          当前分页
     * @param int $page_size     分页大小     0:代表所有记录
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserScoreRecord($user_id,$page=1,$page_size=15){
        $field = ['id','status','style','score','remarks','created_time'];
        $obj = Db::name('score_record')->where('user_id',$user_id);

        $total       = $obj->count('id');
        $rows        = $obj->order('created_time','desc')->field($field)->page($page,$page_size)->select();
        return $this->packData($rows,$total,$page,$page_size);
    }

    /**
     * 获取用户账户记录
     * @param $user_id           用户ID
     * @param int $page          当前分页
     * @param int $page_size     分页大小     0:代表所有记录
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserAccountRecord($user_id,$page=1,$page_size=15){
        $field = ['id','status','type','amount','remarks','created_time'];
        $obj = Db::name('account_record')->where('user_id',$user_id);

        $total       = $obj->count('id');
        $rows        = $obj->order('created_time','desc')->field($field)->page($page,$page_size)->select();
        return $this->packData($rows,$total,$page,$page_size);
    }
}