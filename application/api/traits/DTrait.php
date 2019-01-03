<?php

namespace app\api\traits;

trait DTrait
{

    /**
     * 包装分页数据
     * @param array $rows        列表数据
     * @param int $total         数据总记录数
     * @param int $page          当前分页
     * @param int $page_size     分页大小
     * @param array $params      额外参数
     * @return array
     */
    public function packData(array $rows,int $total,int $page,int $page_size,array $params=[])
    {
        return array_merge([
            'rows'          =>$rows,
            'page'          =>$page,
            'page_total'    =>($page_size == 0?1:getPageTotal($total,$page_size)),
            'total'         =>$total,
        ],$params);
    }
}