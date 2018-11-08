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
//            return redirect('/login');
        }

        return $this->fetch('user/main');
    }

    /**
     * 用户认证页面
     */
    public function certification(){
//        if(!$this->checkLogin()){
//            return redirect('/login');
//        }

        return $this->fetch('user/certification');
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
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $type = $request->post('type',0);
        if(!in_array($type,[1,2,3,4])){
            return $this->returnData([],'参数不符合规范',301);
        }

        $validate = new \app\index\validate\addAuth();
        if(!$validate->scene('auth'.$type)->check($request->get())){
            return $this->returnData([],$validate->getError(),301);
        }

        $username           = $request->post('username');
        $idcard             = $request->post('idcard');
        $card_img1          = $request->post('card_img1');
        $card_img2          = $request->post('card_img2');
        $qualification      = $request->post('qualification');
        $practice_certificate = $request->post('practice_certificate');
        $name               = $request->post('name');
        $business_licence   = $request->post('business_licence');

        $data = [];
        $data['type']       =  $type;
        $data['user_id']    =  $this->getUserInfo()['id'];
        $data['user_id']    = 4;
        $data['username']   =  $username;
        $data['idcard']     =  $idcard;
        $data['card_img1']  =  $card_img1;
        $data['card_img2']  =  $card_img2;
        if($type == 2){
            $data['qualification']          = $qualification;
            $data['practice_certificate']   = $practice_certificate;
        }else if($type == 3 || $type == 4){
            $data['name']               = $name;
            $data['business_licence']   = $business_licence;
        }

        $isTrue = (new \app\api\domain\AuthDomain())->addAuthentication($data);
        if(!$isTrue){
            return $this->returnData([],'认证申请提交失败',305);
        }
        return $this->returnData([],'认证申请提交成功',200);
    }
}