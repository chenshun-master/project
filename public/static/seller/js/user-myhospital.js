var table = layui.table;

table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,toolbar: '#toolbarDemo'
    ,url: '/seller/user/getmyhospital'
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
        {field: 'enterprise_name', title: '医院名称',minWidth:200},
        {field: 'scale', title: '医院规模',width:100},
        {field: 'province', title: '省份',width:100},
        {field: 'city', title: '城市',width:100},
        {field: 'area', title: '地区',width:100},
        {field: 'address', title: '详细地址',width:100},
        {field: 'founding_time', title: '成立时间',width:100},
    ]],
    limits:[10,20,30,50,100]
});



table.render({
    elem: '#table-list2'
    ,id:'tab-reload2'
    ,toolbar: '#toolbarDemo2'
    ,url: '/seller/user/getDoctorEnterApplyList'
    ,loading:true
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "data": res.data.rows //解析数据列表
        };
    }
    ,text:{none:'您还没有添加任何盛申请...'}
    ,cols: [[ //表头
        {type:'numbers'},
        {field: 'hospital_name', title: '医院名称',width:300},
        {field: 'status', title: '申请状态',width:100},
        {field: 'remarks', title: '申请备注',minWidth:300},
        {field: 'created_time', title: '成立时间',width:200},
    ]],
    limits:[10,20,30,50,100]
});

// table.render({
//     elem: '#table-list3'
//     ,id:'tab-reload3'
//     ,toolbar: '#toolbarDemo3'
//     ,url: '/seller/user/getmyhospital'
//     ,loading:true
//     ,parseData: function(res){ //res 即为原始返回的数据
//         return {
//             "code": res.code == 200?0:res.code, //解析接口状态
//             "msg": res.msg, //解析提示文本
//             "data": res.data.rows //解析数据列表
//         };
//     }
//     ,text: {
//         none: '您还没有加入任何医院...'
//     }
//     ,cols: [[ //表头
//         {type:'numbers'},
//         {field: 'enterprise_name', title: '医院名称',minWidth:200},
//         {field: 'scale', title: '医院规模',width:100},
//         {field: 'province', title: '省份',width:100},
//         {field: 'city', title: '城市',width:100},
//         {field: 'area', title: '地区',width:100},
//         {field: 'address', title: '详细地址',width:100},
//         {field: 'founding_time', title: '成立时间',width:100},
//     ]],
//     limits:[10,20,30,50,100]
// });

var objClass = {
    reload:function(tableID){
        layui.table.reload(tableID);
    }
};