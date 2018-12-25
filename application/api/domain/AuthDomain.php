<?php
namespace app\api\domain;

use app\api\model\AuthModel;
use think\Db;

/**
 * 账号认证处理业务层
 * @package app\api\domain
 */
class AuthDomain
{

    /**
     * 提交认证申请记录
     * @param $params
     * @return bool|int  (true : 提交成功  false:提交失败  1:身份证号已被使用 2:认证类型与上次申请类型不符)
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addAuthentication($params){
        $params['status'] =  1;
        $params['created_time'] =  date('Y-m-d H:i:s');

        $authModel = new AuthModel();
        $res = Db::name('auth')->where('user_id',$params['user_id'])->field('id,user_id,status,idcard,type')->find();
        $res1 = $authModel->findIdCard($params['idcard']);

        try {
            $isTrue = false;
            if(!$res){
                if($res1){
                    return 1;
                }
                $isTrue  = Db::name('auth')->insert($params);
            }else if($res['status'] != 3){
                if($res1 !== false && $res1 !== $res['user_id']){
                    return 1;
                }else if(intval($params['type']) != intval($res['type'])){
                    return 2;
                }

                $isTrue  = Db::name('auth')->where('id', $res['id'])->data($params)->update();
            }

            return $isTrue ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 后台认证审核接口
     * @param $id               认证ID
     * @param $status           审核状态(2:审核失败 3:审核成功)
     * @param $audit_remark     审核备注
     * @return bool
     */
    public function authVerify($id,$status,$audit_remark){
        Db::startTrans();
        try {
            $status = (int)$status;
            if(!Db::name('auth')->where('id', $id)->data(['status'=>$status,'audit_time'=>date('Y-m-d H:i:s'),'audit_remark'=>htmlspecialchars($audit_remark)])->update()){
                Db::rollback();return false;
            }

            if($status === 3){#审核成功更新用户类型
                $auth_info = Db::name('auth')->find($id);
                $type = 1;
                if($auth_info['type'] == 1){
                    $type = 2;
                }else if($auth_info['type'] == 2){
                    $type = 3;
                }else if($auth_info['type'] == 3){
                    $type = 4;
                }else if($auth_info['type'] == 4){
                    $type = 5;
                }

                if(!Db::name('user')->where('id', $auth_info['user_id'])->data(['type'=>$type])->update()){
                    Db::rollback();return false;
                }else if($type == 3){
                    $isTrue3  = Db::name('doctor')->insert([
                        'auth_id'=>$auth_info['id'],'user_id'=>$auth_info['user_id'],'real_name'=>$auth_info['username'],'created_time'=>date('Y-m-d H:i:s')
                    ]);
                    if(!$isTrue3){
                        Db::rollback();return false;
                    }
                }else if($type == 4){
                    $isTrue4  = Db::name('hospital')->insert([
                        'auth_id'=>$auth_info['id'],'user_id'=>$auth_info['user_id'],'hospital_name'=>$auth_info['enterprise_name'],'created_time'=>date('Y-m-d H:i:s')
                    ]);
                    if(!$isTrue4){
                        Db::rollback();return false;
                    }
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
     * 获取用户申请记录
     * @param $user_id        用户ID
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function findAuthResult($user_id){
        $res = Db::name('auth')->where('user_id',$user_id)->find();
        return $res ? :[];
    }

    /**
     * 认证列表
     * @param int $status 1-待审核 2-审核成功 3-审核失败
     * @param int $page
     * @param int $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthList($status=0,$page=1,$page_size=10){
        if($status == 0){
            $status = [1,2,3];
        }else if($status == 1){
            $status = [1];
        }else if($status == 2){
            $status = [2];
        }else if($status == 3) {
            $status = [3];
        }
        $auth = Db::name('auth')->alias('auth');
        $auth->leftJoin('wl_user user','user.id = auth.user_id');
        $auth->where('auth.status','in',$status);
        $filed = [
            'auth.id',
            'user.mobile',
            'user.nickname',
            'auth.type',
            'auth.username',
            'auth.idcard',
            'auth.card_img1',
            'auth.card_img2',
            'auth.qualification',
            'auth.practice_certificate',
            'auth.business_licence',
            'auth.enterprise_name',
            'auth.profile',
            'auth.phone',
            'auth.province',
            'auth.city',
            'auth.area',
            'auth.address',
            'auth.duties',
            'auth.speciality',
            'auth.hospital_type',
            'auth.scale',
            'auth.founding_time',
            'auth.status',
            'auth.audit_time',
            'auth.audit_remark',
            'auth.created_time',
        ];
        $total = $auth->count(1);

        $rows = $auth->field($filed)->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}