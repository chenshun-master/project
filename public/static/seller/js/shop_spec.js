layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/seller/shop/getSpecData' //数据接口
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
        {field: 'id', title: 'ID',width:50, fixed: 'left'}
        ,{field: 'name', title: '规格名称',width:100}
        ,{field: 'type', title: '规格类型',width:100,templet:function(d){
                if(d.type == 1){
                    return '文本';
                }else{
                    return '图片';
                }
            }}

        ,{field: 'value', title: '规格值',minWidth:100,templet:function(d){
                var html = '';
                $.each($.parseJSON(d.value),function(k,v){
                    html += '【'+  v +'】'
                });
                return html;
            }}
        ,{field: 'remarks', title: '备注说明',width:100}
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
    showBox:function(){
        layer.open({
            type: 2,
            title: '添加规则',
            shadeClose: true,
            shade: false,
            maxmin: true, //开启最大化最小化按钮
            area: ['893px', '600px'],
            content: 'http://172.16.100.85/seller/shop/specBox'
        });
    }
};