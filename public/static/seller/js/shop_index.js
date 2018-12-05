layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/seller/shop/getGoodsData' //数据接口
    ,page: true
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "count": res.data.total, //解析数据长度
            "data": res.data.rows //解析数据列表
        };
    }
    ,cols: [[ //表头
        {field: 'id', title: 'ID',width:50,unresize: true, fixed: 'left'}
        ,{field: 'name', title: '商品/项目名称',cellMinWidth:50}
        ,{field: '原图', title: 'img',width:100,unresize: true,templet:function(d){
            return '<img src="'+d.img+'" alt="">';
        }}
        ,{field: 'status', title: '商品状态',width:100,unresize: true}
        ,{field: 'store_nums', title: '项目名额'}
        ,{field: 'category', title: '分类'}
        ,{field: '', title: '操作',width:150,unresize: true}
    ]]
});

var objClass = {
    reload:function(){
        layui.table.reload('tab-reload', {
            page: {
                curr: 1
            }
            ,where: {
                key: {

                }
            }
        });
    },
};