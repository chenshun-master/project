layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/admin/banner/getBannerList' //数据接口
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
        {field: 'id', title: 'ID', fixed: 'left',width:120},
        {field: 'platform', title: '类型'},
        {field: 'name', title: 'banner名称'},
        {field: 'url', title: '链接地址'},
        {field: 'img', title: '图片地址'},
        {field: 'order', title: '排序'},
        {field: 'visibility', title: '首页是否显示'},
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
    add:function(){
        window.location.href = '/admin/banner/addBanner';
    }
};