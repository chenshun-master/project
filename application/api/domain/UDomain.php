<?php
namespace app\api\domain;

use app\api\controller\User;
use think\Db;

class UDomain
{
    /**
     * 获取医生列表数据
     * @param int $page             当前分页
     * @param int $page_size    分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDoctorListData($page=1,$page_size=15){
        $obj = Db::name('user')->alias('user');
        $obj->leftJoin('wl_doctor doctor','user.id = doctor.user_id');
        $obj->leftJoin('wl_doctor_hospital dh','doctor.id = dh.doctor_id');
        $obj->leftJoin('wl_hospital hospital','hospital.id = dh.hospital_id');

        $obj->where("user.type = '3' and IFNULL(dh.status,0) != 2");
        $obj->group('user.id');
        $obj->order('user.created_time', 'desc');

        $total = $obj->count();
        $field = 'user.portrait,
                  doctor.real_name,
                  doctor.user_id,
                  hospital.id as hospital_id,
                  hospital.hospital_name,
                  ( SELECT count(1) FROM wl_article WHERE user.id = wl_article.user_id AND wl_article.type = 1 ) AS article_num,
                  0 AS case_num';

        $obj->field($field);
        $rows = $obj->page($page,$page_size)->fetchSql(false)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取医院列表
     * @param int $page             当前分页
     * @param int $page_size    分页大小
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHospitalListData($page=1,$page_size=15){
        $obj = Db::name('user')->alias('user');
        $obj->leftJoin('wl_hospital hospital','hospital.user_id = user.id');
        $obj->leftJoin('wl_auth auth','hospital.auth_id = auth.id');
        $obj->where('user.type', 4);
        $total = $obj->count();

        $obj->field("hospital.user_id,hospital.hospital_name,auth.hospital_type as type,user.portrait,( SELECT count(1) FROM wl_article WHERE user.id = wl_article.user_id AND wl_article.type = 1 ) AS article_num,0 AS case_num");
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取医生相关信息
     */
    public function getDoctorInfo($user_id){
        $data = [];

        $obj = Db::name('user')->alias('user')->where('user.type',3)->where('user.id',$user_id);
        $obj->leftJoin('wl_doctor doctor','user.id = doctor.user_id');
        $obj->leftJoin('wl_auth auth','doctor.auth_id = auth.id');
        $obj->field('user.id as uid,user.mobile,user.portrait,doctor.id as doctor_id,doctor.real_name,auth.duties,auth.speciality,auth.profile as doctor_profile,auth.address');
        $info = $obj->find();

        if($info){
            $obj2 = Db::name('hospital')->alias('hospital');
            $obj2->leftJoin('wl_user user','user.id = hospital.user_id' );
            $obj2->leftJoin('wl_doctor_hospital dh','dh.hospital_id = hospital.id' );
            $obj2->leftJoin('wl_auth auth','hospital.auth_id = auth.id');
            $obj2->where('dh.doctor_id',$info['doctor_id']);
            $obj2->where('dh.status',1);
            $obj2->field('hospital.id as hospital_id,user.id as uid,user.portrait,hospital.hospital_name,auth.address,auth.profile');

            $data['doctor_info'] = $info;
            $data['hospital_info'] = $obj2->select();
        }
        return $data;
    }

    /**
     * 获取医院相关信息
     */
    public function getHospitalInfo($user_id){
        $data = [];

        $obj1 = Db::name('hospital')->alias('hospital');
        $obj1->leftJoin('wl_user user','user.id = hospital.user_id' );
        $obj1->leftJoin('wl_auth auth','hospital.auth_id = auth.id');
        $obj1->where('hospital.user_id',$user_id);
        $obj1->field('hospital.id as hospital_id,user.id as uid,user.portrait,hospital.hospital_name,auth.address,auth.profile');

        $data['hospital'] = $obj1->find();
        $data['doctor_list'] = $this->getHospitalDoctorList($user_id,1,100)['rows'];

        return $data;
    }

    public function getHospitalDetail($user_id){
        $obj = Db::name('hospital')->alias('hospital');
        $obj->leftJoin('wl_user user','user.id = hospital.user_id' );
        $obj->leftJoin('wl_auth auth','hospital.auth_id = auth.id');
        $obj->where('hospital.user_id',$user_id);

        $obj->field('user.id as uid,hospital.hospital_name,auth.hospital_type as type,auth.scale as hospital_scale,auth.founding_time,auth.speciality,auth.profile,auth.address');
        return $obj->find();
    }

    /**
     * 获取医院的医生列表
     * @param $user_id
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHospitalDoctorList($user_id,$page=1,$page_size=15){
        $obj = Db::name('doctor_hospital')->alias('dh');
        $obj->leftJoin('wl_doctor doctor','doctor.id = dh.doctor_id');
        $obj->leftJoin('wl_hospital hospital','hospital.id = dh.hospital_id');
        $obj->leftJoin('wl_user user','user.id = doctor.user_id');
        $obj->leftJoin('wl_auth auth','doctor.auth_id = auth.id');
        $obj->where('dh.status',1);
        $obj->where('hospital.user_id',$user_id);

        $total = $obj->count();
        $obj->field('user.id as uid,user.portrait,doctor.real_name,auth.duties,auth.speciality,auth.profile,auth.address,hospital.hospital_name');

        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 获取医生资格证书
     */
    public function getDoctorCertificate($user_id){
        return Db::name('auth')->where('user_id',$user_id)->where('type',2)->field('id as auth_id,qualification,practice_certificate')->find();
    }

    /**
     * 获取医生资格证书
     */
    public function getUserHonorCertificate($user_id){
        return Db::name('honor_certificate')->where('user_id',$user_id)->select();
    }

    /**
     * 获取医院营业执照
     */
    public function getUserLicence($user_id){
        return Db::name('auth')->where('user_id',$user_id)->where('type',3)->field('id as auth_id,business_licence')->find();
    }

    /**
     * 获取医生所在的医院列表
     * @param $user_id    User 表ID
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDoctorHospitalList($user_id){
        $obj = Db::name('doctor')->alias('doctor');
        $obj->where('doctor.user_id',$user_id);
        $obj->leftJoin('wl_doctor_hospital dh','doctor.id = dh.doctor_id');
        $obj->leftJoin('wl_hospital hospital','dh.hospital_id = hospital.id');
        $obj->field('hospital.id as hospital_id,hospital.hospital_name');
        return $obj->select();
    }

    /**
     * 获取用户的
     */
    public function getDoctorOrHospitalList($user_id,$type){
        $data = ['doctor'  => [],'hospital'=>[]];

        if($type == 3){
            $doctorInfo = Db::name('doctor')->where('user_id',$user_id)->field('id as doctor_id,user_id,real_name')->find();
            $data['doctor'][] = $doctorInfo;

            $obj = Db::name('doctor_hospital')->alias('dh');
            $obj->leftJoin('wl_hospital hospital','hospital.id = dh.hospital_id');
            $obj->where('dh.doctor_id',$doctorInfo['doctor_id']);
            $obj->field('hospital.user_id,hospital.id as hospital_id,hospital.hospital_name');

            $data['hospital'] = $obj->select();
        }else if($type == 4){
            $hospitalInfo = Db::name('hospital')->where('user_id',$user_id)->field('id as hospital_id,user_id,hospital_name')->find();
            $data['hospital'][] = $hospitalInfo;

            $obj = Db::name('doctor_hospital')->alias('dh');
            $obj->leftJoin('wl_doctor doctor','doctor.id = dh.doctor_id');
            $obj->where('dh.hospital_id',$hospitalInfo['hospital_id']);
            $obj->field('doctor.id as doctor_id,doctor.user_id,doctor.real_name');

            $data['doctor'] = $obj->select();
        }

        return $data;
    }

    /**
     * 后台获取医院的医生列表
     * @param $user_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMyDoctorList($user_id){
        $obj = Db::name('doctor_hospital')->alias('dh');
        $obj->join('wl_hospital hospital',"dh.hospital_id = hospital.id and hospital.user_id = {$user_id}");
        $obj->join('wl_auth auth','auth.id = hospital.auth_id');
        $obj->join('wl_user user','user.id = hospital.user_id');
        $obj->join('wl_doctor doctor',"doctor.id = dh.doctor_id");

        $field= [
            'user.id as user_id','user.mobile','user.nickname','user.sex','user.portrait',
            'auth.username','auth.duties','auth.speciality',
            'dh.created_time',
            'dh.status relation_status'
        ];

        $rows = $obj->field($field)->select();
        return [
            'rows' => $rows,
            'page' => 1,
            'page_total' => 1,
            'total' => count($rows),
        ];
    }

    /**
     * 后台获取医生的所属医院
     * @param $user_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMyHospital($user_id){
        $obj = Db::name('doctor_hospital')->alias('dh');
        $obj->join('wl_doctor doctor',"dh.doctor_id = doctor.id and doctor.user_id = {$user_id}");
        $obj->join('wl_hospital hospital','dh.hospital_id = hospital.id');
        $obj->join('wl_auth auth','auth.id = hospital.auth_id');


        $field= [
            'auth.enterprise_name',
            'auth.scale','auth.founding_time','auth.province','auth.city','auth.area','auth.address'
        ];

        $rows = $obj->field($field)->select();
        return [
            'rows' => $rows,
            'page' => 1,
            'page_total' => 1,
            'total' => count($rows),
        ];
    }

    /**
     * 添加医院入住申请
     * @param $doctor_id
     * @param $hospital_id
     * @param $applicant
     * @param $remarks
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function createEnterApply($doctor_id,$hospital_id,$applicant,$remarks){
        $result = Db::name('doctor_hospital')->where('doctor_id',$doctor_id)->where('hospital_id',$hospital_id)->find();
        if($result && $result['status'] == 1){
            return [false,'医生医院不能重复关联',null];
        }else if(Db::name('hospital_enter_apply')->where('doctor_id',$doctor_id)->where('hospital_id',$hospital_id)->where('applicant',$applicant)->where('status',1)->order('id desc')->find()){
            return [false,'不能重复添加申请',null];
        }

        if(!Db::name('hospital_enter_apply')->insertGetId(['doctor_id'=>$doctor_id,'hospital_id'=>$hospital_id,'applicant'=>$applicant,'remarks'=>$remarks,'created_time'=>date('Y-m-d H::i:s')])){
            return [false,'申请失败',null];
        }

        return [true,'申请成功，请耐心等待医院处理...'];
    }

    /**
     * 后台获取所有医院信息
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHospitalList(){
        return  Db::name('hospital')->field('id,hospital_name')->select();
    }

    /**
     * 获取医生入驻申请
     */
    public function getDoctorEnterApplyList($doctor_id){
        $obj = Db::name('hospital_enter_apply')->alias('apply');
        $obj->leftJoin('wl_hospital hospital','hospital.id = apply.hospital_id');
        $obj->where('apply.doctor_id',$doctor_id);
        $field= [
            'apply.*','hospital.hospital_name'
        ];

        $rows = $obj->field($field)->select();
        return [
            'rows' => $rows,
            'page' => 1,
            'page_total' => 1,
            'total' => count($rows),
        ];
    }

    /**
     * 获取医院的申请列表
     * @param $hospital_id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHospitalEnterApplyList($hospital_id){
        $obj = Db::name('hospital_enter_apply')->alias('apply');
        $obj->leftJoin('wl_doctor doctor','doctor.id = apply.doctor_id');
        $obj->leftJoin('wl_user user','user.id = doctor.user_id');
        $obj->leftJoin('wl_auth auth','auth.id = doctor.auth_id');

        $obj->where('apply.hospital_id',$hospital_id);
        $field= [
            'apply.*',
            'user.mobile',
            'user.id as user_id','user.mobile','user.nickname','user.sex','user.portrait',
            'auth.username','auth.duties','auth.speciality',
        ];
        $rows = $obj->field($field)->select();

        return [
            'rows' => $rows,
            'page' => 1,
            'page_total' => 1,
            'total' => count($rows),
        ];
    }

    /**
     * 入驻医院审核
     */
    public function haospitalEnterApplyExamine($id,$hospital_id,$status){

        Db::startTrans();
        try {
            $status = (int)$status;
            if(!Db::name('hospital_enter_apply')->where('id', $id)->where('hospital_id',$hospital_id)->where('status',1)->update(['status'=>$status])){
                throw new \think\Exception('更新失败1');
            }

            if($status == 2){
                $info  = Db::name('hospital_enter_apply')->where('id',$id)->field('doctor_id,hospital_id')->find();
                if(!$info){
                    throw new \think\Exception('更新异常');
                }

                $data = [];
                $data['doctor_id'] =  $info['doctor_id'];
                $data['hospital_id'] =  $info['hospital_id'];
                $data['status'] =  1;
                $data['created_time'] =  date('Y-m-d H:i:s');

                if(!Db::name('doctor_hospital')->insertGetId($data)){
                    throw new \think\Exception('更新异常5');
                }
            }

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }
    }

    /**
     * 站内搜索医生
     * @param array $searchParams
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function searchDoctor(array $searchParams,int $page,int $page_size){
        $obj = Db::name('doctor')->alias('doctor');
        $obj->leftJoin('wl_user user','user.id = doctor.user_id');
        $obj->leftJoin('wl_auth auth','doctor.user_id = auth.user_id');

        $obj->where('doctor.real_name','like',"%{$searchParams['keywords']}%");
        $total = $obj->count('doctor.id');
        $field = [
            'user.id as user_id',
            'doctor.id as doctor_id',
            'doctor.real_name',
            'user.portrait',
            'auth.duties',
            'auth.speciality'
        ];

        $rows = $obj->fetchSql(false)->field($field)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }

    /**
     * 站内搜索医院
     * @param array $searchParams
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function searchHospital(array $searchParams,int $page,int $page_size){
        $obj = Db::name('hospital')->alias('hospital');
        $obj->leftJoin('wl_user user','user.id = hospital.user_id');
        $obj->leftJoin('wl_auth auth','hospital.user_id = auth.user_id');

        $obj->where('hospital.hospital_name','like',"%{$searchParams['keywords']}%");
        $total = $obj->count('hospital.id');
        $field = [
            'user.id as user_id',
            'hospital.id as hospital_id',
            'hospital.hospital_name',
            'user.portrait',
            'auth.speciality',
            'auth.hospital_type'
        ];

        $rows = $obj->fetchSql(false)->field($field)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}