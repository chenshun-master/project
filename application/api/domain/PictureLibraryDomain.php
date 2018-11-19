<?php
namespace app\api\domain;
use think\Db;


class PictureLibraryDomain
{

    /**
     * 已上传图片入库
     */
    public function create($type,$img_url){
        return Db::name('picturelibrary')->insertGetId([
            'type'    =>$type,
            'img_url' =>$img_url,
            'status'  =>1,
            'created_time'=>date('Y-m-d H:i:s')
        ]);
    }
}