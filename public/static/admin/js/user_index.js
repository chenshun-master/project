layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/admin/user/getUserList' //数据接口
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
        {field: 'id', title: 'ID', fixed: 'left',width:120},
        {field: 'mobile', title: '手机号'},
        {field: 'nickname', title: '用户昵称'},
        {field: 'portrait', title: '用户头像',width:100,align:"center",templet:function (res) {
                return '<img src="'+res.portrait+'" width="30" >';
            }},
        {field: 'type', title: '用户类型',width:100,templet:function(row){
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
        {field: 'score', title: '用户积分',sort:true},
        {field: 'account', title: '账户余额',sort:true},
        {field: 'sex', title: '用户性别',width:100,templet:function(row){
                if(row.sex == 0){
                    return '<span class="label label-warning">未知</span>';
                }else if(row.sex == 1){
                    return '<span class="label label-danger">男</span>';
                }else if(row.sex == 2){
                    return '<span class="label label-primary">女</span>';
                }
            }},
        {field: 'birthday_date', title: '出生日期',sort:true},
        {field: 'profile', title: '用户简介'},
        {field: 'last_login_time', title: '最后登陆时间',sort:true},
        {field: 'last_login_ip', title: '最后登陆IP'},
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