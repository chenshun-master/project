<?php
namespace app\api\domain;

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

        $obj->where('user.type', 3);
        $obj->where('dh.status', 1);
        $obj->group('user.id');
        $obj->order('user.created_time', 'desc');

        $total = $obj->count();
        $obj->field("user.id,user.portrait,doctor.*,hospital.hospital_name,(SELECT count(1) from wl_article  where user.id = wl_article.user_id and wl_article.type = 1) as article_num,0 as case_num");
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
        $obj->where('user.type', 4);
        $obj->order('user.created_time', 'desc');
        $obj->leftJoin('wl_hospital hospital','user.id = hospital.user_id');
        $total = $obj->count();
        $obj->field("user.id,INSERT(user.mobile,4,4,'****') as mobile,user.nickname,user.profile,user.portrait,hospital.*");
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}