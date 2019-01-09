var table = layui.table;

$('#my-tab > li').on('click',function(){
    if($(this).data('id') != ''){
        objClass.reload($(this).data('id'));
    }
});

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
        {field: 'address', title: '医院地址',templet:function(row){
                return row.province + ' ' +row.city + ' '+ row.area + ' ' + row.address;
         }},
        {field: 'scale', title: '医院规模',width:100},
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
        {type:'checkbox'},
        {field: 'hospital_name', title: '医院名称',width:300},
        {field: 'status', title: '申请状态',width:100,templet:function(row){
                if(row.status == 1){
                    return '<span class="label label-warning">等待审核</span>';
                }else if(row.status == 2){
                    return '<span class="label label-success">已同意</span>';
                }else if(row.status == 3){
                    return '<span class="label label-danger">已拒绝</span>';
                }
        }},
        {field: 'remarks', title: '申请备注',minWidth:300},
        {field: 'created_time', title: '成立时间',width:200},
    ]],
    limits:[10,20,30,50,100]
});

var objClass = {
    reload:function(tableID){
        layui.table.reload(tableID);
    },
    confirmDel:function(){
        var ids = layuiTable.getCheckId('tab-reload2','hospital_id');
        if(ids.length == 0){
            layer.alert('请选择需要操作的数据',{title:'温馨提示'});return  false;
        }

        var index = layer.confirm('删除您确定要删除这些数据吗？', {
            btn: ['立即删除','取消']
        }, function(){
        });
    },
};

var operationObj = {
    loading:false,
    boxIndex:null,
    showBox:function(){
        this.boxIndex = layer.open({type: 1,shade: false,title: '入驻医院申请',area: ['800px', '280px'],content: box.innerHTML});
    },
    submit:function(){
        var data = {
            hospital_id:$('#fr-select').val(),
            remarks:$('#fr-textarea').val(),
            applicant:1
        };

        if(data.remarks == ''){
            layer.msg('申请备注不能为空');
        }else if(this.loading == false){
            $.ajax({
                url: '/seller/user/createDoctorApply',
                type: 'POST',
                data:data,
                dataType: "json",
                success: function (res) {
                    operationObj.loading = false;
                    if(res.code == 200){
                        layer.msg(res.msg, {icon: 1});
                        setTimeout(function(){
                            layer.close(operationObj.boxIndex);
                        },2000);
                    }else{
                        layer.msg(res.msg, {icon: 2});
                    }
                },
                error:function(){
                    operationObj.loading = false;
                }
            });
        }
    }
};