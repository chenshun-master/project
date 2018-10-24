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
    }

    public function main()
    {
        return $this->fetch('user/main');
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

}