layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,toolbar: '#toolbarDemo'
    ,url: '/admin/user/getAdminList' //数据接口
    ,page: true
    ,request: {
        pageName: 'page' //页码的参数名称，默认：page
        ,limitName: 'page_size' //每页数据量的参数名，默认：limit
    }
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code==200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "count": res.data.total, //解析数据长度
            "data": res.data.rows //解析数据列表
        };
    }
    ,cols: [[ //表头
        {field: 'id', title: 'ID', fixed: 'left',width:120},
        {field: 'username', title: '管理员姓名'},
        {field: 'status', title: '管理员状态',templet:function (res) {
                if(res.status == 0){
                    return '<span class="label label-danger" lay-event="end">已禁用</span>';
                }else if(res.status == 10){
                    return '<span class="label label-success" lay-event="show">已启用</span>';
                }
            }},
        {field: 'created_at', title: '添加时间',sort:true},
        {field: 'updated_at', title: '修改时间'},
        {field: '', title: '操作',width:100,templet:function(row){
                return '<a href="/admin/user/updateAdmin/id/'+ row.id +'">编辑</a>';
            }},
    ]]
});
layui.table.on('tool(admin)',function (obj) {
    var data = obj.data;
    var id = data.id;
    if (obj.event === 'show'){
        $.ajax({
            url:'/admin/user/update',
            data:{id:id,status:data.status},
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
    }else if(obj.event === 'end'){
        $.ajax({
            url:'/admin/user/update',
            data:{id:id,status:data.status},
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
        window.location.href = '/admin/user/newAdmin';
    }
};