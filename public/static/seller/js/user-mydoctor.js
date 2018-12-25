var table = layui.table;

table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,toolbar: '#toolbarDemo'
    ,url: '/seller/user/getMyDoctorList'
    ,loading:true
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "data": res.data.rows //解析数据列表
        };
    }
    ,text: {
        none: '您还没有加入任何医院...'
    }
    ,cols: [[ //表头
        {type:'numbers'},
        {field: 'nickname', title: '医生昵称',minWidth:200},
        {field: 'username', title: '真实姓名',minWidth:200},
        {field: 'mobile', title: '手机号',minWidth:200},
        {field: 'sex', title: '性别',width:100,templet:function(row){
            if(row.sex == 0){
                return '未知';
            }else if(row.sex == 2){
                return '男';
            }else if(row.sex == 3){
                return '女';
            }
        }},
        {field: 'speciality', title: '擅长项目',minWidth:200},
        {field: 'duties', title: '岗位职称',minWidth:200},
        {field: 'created_time', title: '加入时间',width:200},
    ]],
    limits:[10,20,30,50,100]
});

table.render({
    elem: '#table-list2'
    ,id:'tab-reload2'
    ,toolbar: '#toolbarDemo2'
    ,url: '/seller/user/getHospitalEnterApplyList'
    ,loading:true
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "data": res.data.rows //解析数据列表
        };
    }
    ,text: {
        none: '您还没有加入任何医院...'
    }
    ,cols: [[ //表头
        {type: 'radio'},
        {field: 'username', title: '医生姓名',minWidth:200},
        {field: 'mobile', title: '手机号',minWidth:200},
        {field: 'sex', title: '性别',width:100,templet:function(row){
            if(row.sex == 0){
                return '未知';
            }else if(row.sex == 2){
                return '男';
            }else if(row.sex == 3){
                return '女';
            }
        }},
        {field: 'speciality', title: '擅长项目',width:200},
        {field: 'duties', title: '岗位职称',width:200},
        {field: 'status', title: '申请状态',width:100,templet:function(row){
            if(row.status == 1){
                return '<span class="label label-warning">等待审核</span>';
            }else if(row.status == 2){
                return '<span class="label label-success">已同意</span>';
            }else if(row.status == 3){
                return '<span class="label label-danger">已拒绝</span>';
            }
        }},

        {field: 'created_time', title: '申请时间',width:200},
        {field: 'remarks', title: '申请备注'},
    ]],
    limits:[10,20,30,50,100]
});

var objClass = {
    reload:function(tableId){
        layui.table.reload(tableId);
    }
};