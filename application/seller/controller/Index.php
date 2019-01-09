<?php
namespace app\seller\controller;

use think\Request;
use app\api\domain\PictureLibraryDomain;

class Index extends BaseController
{
    public function index(){
        return $this->fetch('index/index');
    }

    /**
     * 商家登录页面
     */
    public function login(){
        return $this->fetch('index/login');
    }

    /**
     * 商家登录处理页面
     */
    public function postLogin(Request $request){
        $mobile   = $request->post('mobile','');
        $password = $request->post('password','');

        if(empty($mobile) || empty($password)){
            return $this->returnData([],'参数不符合规范',301);
        }

        $domain = new \app\api\domain\SellerDomain();
        $loginRes = $domain->login($mobile,$password);

        if(is_array($loginRes) && count($loginRes)){
            $this->saveUserLogin($loginRes);
            return $this->returnData([],'登录成功',200);
        }else{
            return $this->returnData([],'登录失败',305);
        }
    }

    /**
     * 退出登录
     */
    public function signOut(){
        $this->clearUserLogin();
        return redirect('/seller/index/login');
    }


    /**
     * 编辑器单文件上传
     */
    public function editUploadImgFile(Request $request){
        $file = $request->file("imgFile");
        $type = 6;

        $pictureLibraryDomain = new PictureLibraryDomain();

        $img_domain = config('conf.file_save_domain');
        if(!$this->checkLogin()){
            return json(array('error' => 1, 'message' =>'未授予上传权限'));
        }

        if($type == 0){
            return json(array('error' => 1, 'message' =>'请求参数不符合规范'));
        }

        #文件上传类型
        $fileExt   = ['gif', 'jpg', 'jpeg', 'png'];
        if($file){
            $size = 1024*1024*5;              #单位字节
            if(!$file->checkSize($size)){
                return json(['error' => 1, 'message' =>'上传图片大小不能超过5M']);
            }

            if(!$file->checkExt($fileExt)){
                return json(['error' => 1, 'message' =>'文件格式错误只支持gif,jpg,jpeg及png格式的图片']);
            }

            $info = $file->move( '../uploads/goods_article');
            if($info){
                $path_dir = $img_domain.'/goods_article/'.str_replace("\\","/",$info->getSaveName());
                $id = $pictureLibraryDomain->create($type,$path_dir);
                if($id){
                    return json(array('error' => 0, 'url' => $path_dir));
                }else{
                    return json(array('error' => 1, 'message' => '上传失败'));
                }
            }else{
                return json(array('error' => 1, 'message' => $file->getError()));
            }
        }
    }

    /**
     * 一键登录
     */
    public function onekeyLogin(){
        if($this->checkLogin()){
            return $this->redirect('/seller');
        }

        $token = $this->request->param('c','');
        $token = json_decode(encryptStr(urldecode($token),'D',config('conf.secret_key')),true);
        if(!empty($token) && ($token['time'] + 60 * 2) >= time()){
            $model = new \app\api\model\UserModel();
            $mobile = $model->getMobile($token['uid']);
            if($mobile){
                $domain = new \app\api\domain\SellerDomain();
                $loginRes = $domain->login($mobile,'',true);
                if(is_array($loginRes) && count($loginRes)){
                    $this->saveUserLogin($loginRes);
                    return $this->redirect('/seller');
                }
            }
        }

        return $this->redirect('/seller/index/login');
    }
}
