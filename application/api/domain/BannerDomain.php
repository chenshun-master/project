<?php
namespace app\api\domain;
use app\api\model\BannerModel;

class BannerDomain
{

    /**
     * 添加banner图
     * @param array $data
     * @return bool
     */
    public function create(array $data){
        if(empty($data['order'])){
            $data['order'] = BannerModel::getMaxOrder($data['platform']) + 1;
        }

        $user = new BannerModel();
        return $user->allowField(['platform','name','url','img','order','visibility'])->save($data);
    }

    /**
     * 修改banner图
     * @param $id
     * @param $data
     * @return bool
     */
    public function edit($id,$data){
        $bannerModel = new BannerModel();
        return $bannerModel->allowField(['platform','name','url','img','order','visibility'])->save($data, ['id' => $id]);
    }

    /**
     * 修改banner图
     * @param $id                banner id
     * @return BannerModel
     */
    public function delete($id){
        return BannerModel::where('id', $id)->update(['is_del' => 1]);
    }
}