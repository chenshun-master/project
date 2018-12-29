<?php
namespace app\seller\controller;

use app\api\domain\UDomain;
use app\api\model\DoctorModel;
use think\App;

class User extends BaseController
{
    private $_uDomain;
    private $_doctorModel;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->_uDomain = new UDomain();
        $this->_doctorModel = new DoctorModel();
    }

    /**
     * 我的医生列表
     */
    public function myDoctor(){
        return $this->fetch('user/my-doctor');
    }

    /**
     * 获取我的医生列表
     */
    public function getMyDoctorList(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $data = $this->_uDomain->getMyDoctorList($this->getUserId());
        return $this->returnData($data,'',200);
    }

    public function doctorApply(){
        $data = $this->_uDomain->getHospitalList();
        $this->assign('list',$data);
        return $this->fetch('user/doctor-apply');
    }

    public function getDoctorEnterApplyList(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $data = $this->_uDomain->getDoctorEnterApplyList($this->_doctorModel->findId($this->getUserId()));
        return $this->returnData($data,'',200);
    }

    public function getHospitalEnterApplyList(){
        if(!$this->checkLogin()){
            return $this->returnData([],'用户未登录',401);
        }

        $data = $this->_uDomain->getHospitalEnterApplyList(10);
        return $this->returnData($data,'',200);
    }

    /**
     * 添加医院入驻申请
     */
    public function createDoctorApply(){
        $hospital_id = $this->request->post('hospital_id',0);
        $doctor_id = $this->_doctorModel->findId($this->getUserId());
        $applicant = $this->request->post('applicant/d',0);
        $remarks = $this->request->post('remarks','');
        if(empty($hospital_id) || empty($doctor_id) || !in_array($applicant,[1,2])){
            return $this->returnData([],'参数不符合规范',301);
        }

        list($isOk,$msg) = $this->_uDomain->createEnterApply($doctor_id,$hospital_id,$applicant,$remarks);
        if($isOk){
            return $this->returnData([],$msg,200);
        }else{
            return $this->returnData([],$msg,305);
        }
    }


    public function updateEnterStatus(){
        $id = $this->request->post('id',0);
        $status = $this->request->post('status/d',0);
        if(empty($id) || empty($status) || !in_array($status,[2,3])){
            return $this->returnData([],'参数不符合规范',301);
        }

        $res = $this->_uDomain->haospitalEnterApplyExamine($id,$this->getHospitalId(),$status);
        if($res){
            return $this->returnData([],'操作成功',200);
        }else{
            return $this->returnData([],'操作失败',305);
        }
    }

    /**
     * 我的医院列表
     */
    public function myHospital(){
        return $this->fetch('user/my-hospital');
    }

    /**
     * 获取我的医院列表
     */
    public function getMyHospital(){
        $data = $this->_uDomain->getMyHospital($this->getUserId());
        return $this->returnData($data,'',200);
    }
}