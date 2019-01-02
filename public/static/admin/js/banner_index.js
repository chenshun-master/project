layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/admin/banner/getBannerList' //数据接口
    ,page: true
    ,request: {
        pageName: 'page' //页码的参数名称，默认：page
        ,limitName: 'page_size' //每页数据量的参数名，默认：limit
    }
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "count": res.data.total, //解析数据长度
            "data": res.data.rows //解析数据列表
        };
    }
    ,cols: [[ //表头
        {field: 'id', title: 'ID', fixed: 'left',width:120},
        {field: 'platform', title: '类型'},
        {field: 'name', title: 'banner名称'},
        {field: 'url', title: '链接地址',templet:function (row) {
                return '<a href="'+row.url+'" target="_blank">'+row.url+'</a>';
            }},
        {field: 'img', title: '图片地址',width:100,align:"center",templet:function(row){
                return '<img src="'+row.img+'" width="50" >';
            }},
        {field: 'order', title: '排序',sort:true},
        {field: 'visibility', title: '首页是否显示',width:100,templet:function(row){
                if(row.visibility == 0){
                    return '<span class="label label-danger" lay-event="end">不显示</span>';
                }else if(row.visibility == 1){
                    return '<span class="label label-success" lay-event="show">显示</span>';
                }
            }},
        {fixed: 'right', title:'操作', toolbar: '#barDemo', width:150}
    ]]
});

layui.table.on('tool(banner)',function (obj) {
    var data = obj.data;
    var id = data.id;
    if (obj.event === 'del') {
        layer.confirm('真的删除行么', function (index) {
            $.ajax({
                url:"/admin/banner/del",
                data:{id:id},
                type:"POST",
                dataType:"json",
                success:function (data) {
                    if(data.code == 200){
                        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                        layer.close(index);
                        layer.msg('删除成功',{icon:6});
                    }else{
                        layer.msg('删除失败',{icon:5});
                    }
                }
            })
        });
    }else if(obj.event === 'show'){
        $.ajax({
            url:'/admin/banner/update',
            data:{id:id,visibility:data.visibility},
            type:"POST",
            dataType:"json",
            success:function (data) {
                if(data.code == 200){
                    window.location.reload();
                }else{
                    layer.msg('修改失败');
                }
            }
        })
    }else if(obj.event === "end"){
        $.ajax({
            url:'/admin/banner/update',
            data:{id:id,visibility:data.visibility},
            type:"POST",
            dataType:"json",
            success:function (data) {
                if(data.code == 200){
                    window.location.reload();
                }else{
                    layer.msg('修改失败');
                }
            }
        })
    }else if(obj.event === 'edit') {
        window.location.href = "/admin/banner/addBanner/id/"+id;
    }
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