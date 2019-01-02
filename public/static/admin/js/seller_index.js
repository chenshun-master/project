layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/admin/seller/getSellerList' //数据接口
    ,toolbar: '#toolbarDemo'
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
        {field: 'mobile', title: '手机号'},
        {field: 'nickname', title: '用户昵称'},
        {field: 'portrait', title: '用户头像',width: 100,align:"center",templet:function (row) {
                return '<img src="'+row.portrait+'" width="30">'
            }},
        {field: 'type', title: '用户类型',templet:function(row){
                if(row.type == 1){
                    return '<span class="label label-success">普通用户</span>';
                }else if(row.type == 2){
                    return '<span class="label label-danger">认证用户</span>';
                }else if(row.type == 3){
                    return '<span class="label label-warning">认证医生</span>';
                }else if(row.type == 4){
                    return '<span class="label label-primary">认证医院</span>';
                }else if(row.type == 5){
                    return '<span class="label label-info">官方团队</span>';
                }
            }},
        {field: 'enterprise_name', title: '医院名称'},
        {field: 'is_lock', title: '是否锁定',templet:function (res) {
                if(res.is_lock ==0){
                    return '<span class="label label-success" lay-event="show">未锁定</span>';
                }else if(res.is_lock == 1){
                    return '<span class="label label-danger" lay-event="end">已锁定</span>';
                }
            }},
        {field: 'account', title: '收款账号信息'},
        {field: 'grade', title: '评分总数',sort:true},
        {field: 'sale', title: '总预约量',sort:true},
        {field: 'comments', title: '评论次数',sort:true},
        {field: 'create_time', title: '申请加入时间',sort:true},
    ]]
});

layui.table.on('tool(seller)',function (obj) {
    var data = obj.data;
    var id = data.id;
    if(obj.event === 'show'){
        $.ajax({
            url:'/admin/seller/update',
            data:{id:id,is_lock:data.is_lock},
            type:"POST",
            dataType:"json",
            success:function (data) {
                if(data.code == 200){
                    window.location.reload();
                }else{
                    layer.msg('修改失败');
                }
            }
        });
    }else if(obj.event === 'end'){
        $.ajax({
            url:'/admin/seller/update',
            data:{id:id,is_lock:data.is_lock},
            type:"POST",
            dataType:"json",
            success:function (data) {
                if(data.code == 200){
                    window.location.reload();
                }else{
                    layer.msg('修改失败');
                }
            }
        });
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
};