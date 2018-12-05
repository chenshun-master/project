<?php
namespace app\api\domain;

use think\Db;

class SpSpecDomian
{

    /**
     * 添加规格
     */
    public function create($data){

        $data['value'] = json_encode($data['value']);
        return Db::name('sp_spec')->insertGetId($data);
    }

    /**
     * 获取规格图片列表
     */
    public function getSpecListData($seller_id,$page,$page_size){
        $obj = Db::name('sp_spec')->alias('sp_spec');
        $obj->where('is_del',0);

        $total = $obj->count();
        $rows = $obj->page($page,$page_size)->select();
        return [
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>getPageTotal($total,$page_size),
            'total'         =>$total
        ];
    }
}