<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/12/24
 * Time: 13:32
 */

namespace app\admin\controller;


use app\api\domain\AuthDomain;
use think\App;
class Auth extends BaseController
{
    private $_authDomain;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->_authDomain = new AuthDomain();
    }

    public function index(){
        return $this->fetch('/auth/index');
    }
    /**
     * 认证列表
     * @param int $page
     * @param int $page_size
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthList($page=1,$page_size=10){
        $status = $this->request->param('status/d',0);
        $data = $this->_authDomain->getAuthList($status,$page,$page_size);
        return $this->returnData($data,'',0);
    }

    public function updateAuthStatus(){
        $id = $this->request->post('id','');
        $flag = $this->request->post('flag','');
        $audit_remark = $this->request->post('audit_remark','');


        if(empty($id) || empty($status) || empty($audit_remark)){
            $this->returnData([],'参数不符合规范',301);
        }

        if($flag == 'fail'){
            $status = 2;
        }else if($flag == 'success'){
            $status = 3;
        }else{
            return $this->returnData([],'参数不符合规范',301);
        }

        $isTrue = $this->_authDomain->authVerify($id,$status,$audit_remark);

        if($isTrue){
            return $this->returnData([],'更新成功',200);
        }

        return $this->returnData([],'',305);
    }
}