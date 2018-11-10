<?php
namespace app\index\controller;
use think\App;
use think\Request;

class User extends CController
{
    private $userDomain;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->userDomain  = new \app\api\domain\UserDomain();
    }

    /**
     * 用户个人中心主页
     */
    public function main(){
        if(!$this->checkLogin()){
            return redirect('/login');
        }

        return $this->fetch('user/main');
    }

    /**
     * 用户上传认证图片接口
     */
    public function uploadAuthImg(Request $request){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

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

            $info = $file->move( 'uploads/auth');
            if($info){
                $path_dir = $img_domain.'/uploads/auth/'.str_replace("\\","/",$info->getSaveName());
                return $this->returnData([
                    'image_url'=>$path_dir
                ],'图片上传成功',200);
            }else{
                return $this->returnData([],$file->getError(),305);
            }
        }
    }

    /**
     * 用户添加认证申请接口
     */
    public function addAuth(Request $request){
        $type                                   = $request->param('type','');
        $username                               = $request->param('username','');
        $idcard                                 = $request->param('idcard','');
        $p_qualification                        = $request->param('p_qualification','');
        $p_practice_certificate                 = $request->param('p_practice_certificate','');
        $business_licence                       = $request->param('business_licence','');

        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        if(empty($username) || empty($idcard)){
            return $this->returnData([],'请求参数不符合规范',301);
        }

        if(!checkIdCard($idcard)){
            return $this->returnData([],'身份证号不合法',301);
        }

        $user_info = $this->getUserInfo();

        $data = [];
        $data['user_id'] = $user_info['id'];
        $data['username'] = $username;
        $data['idcard']   = $idcard;

        if($type == 1){             #个人认证
            $data['type']     = 1;
        }else if($type == 2){      #医生认证
            $data['type']     = 2;
            if(empty($p_qualification)){
                return $this->returnData([],'医师资格证书不能为空',301);
            }
            if(empty($p_practice_certificate)){
                return $this->returnData([],'医师执业证书不能为空',301);
            }

            $data['physician_qualification']            = $p_qualification;
            $data['physician_practice_certificate']     = $p_practice_certificate;
        }else if($type == 3){      #医院认证
            $data['type']     = 3;
            if(empty($business_licence)){
                return $this->returnData([],'医院营业执照不能为空',301);
            }
            $data['business_licence']     = $business_licence;

        }else if($type == 4){      #官方认证
            $data['type']     = 4;
        }

        $isTrue = $this->userDomain->addAuthentication($data);
        if(!$isTrue){
            return $this->returnData([],'认证申请提交失败',305);
        }

        return $this->returnData([],'认证申请提交成功',200);
    }
}