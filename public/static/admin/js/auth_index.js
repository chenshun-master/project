layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/admin/seller/getAuthList' //数据接口
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
        {type: 'radio', fixed: 'left'},
        {field: 'id', title: 'ID', fixed: 'left',width:60},
        {field: 'mobile', title: '用户手机号'},
        {field: 'nickname', title: '用户昵称'},
        {field: 'type', title: '认证类型',width:95,sort:true,templet:function (res) {
                if(res.type == 1){
                    return '<span class="label label-success">个人认证</span>';
                }else if(res.type == 2){
                    return '<span class="label label-primary">医生认证</span>';
                }else if(res.type == 3){
                    return '<span class="label label-danger">医院认证</span>';
                }else if(res.type == 4){
                    return '<span class="label label-warning">官方认证</span>';
                }
            }},
        {field: 'username', title: '运营者姓名'},
        {field: 'enterprise_name', title: '医院/组织名称'},
        {field: 'card_img1',title:'身份证照正面照',width:100,align:"center",templet:function (res) {
                if(res.type == 1|| res.type == 2 || res.type == 3 || res.type == 4){
                    return '<img src="'+res.card_img1+'" width="50" >'
                }else{
                    return '';
                }
            }},
        {field: 'card_img2',title:'身份证照背面照',width:100,align:"center",templet:function (res) {
                if(res.type == 1|| res.type == 2 || res.type == 3 || res.type == 4){
                    return '<img src="'+res.card_img2+'" width="50" >'
                }else{
                    return '';
                }
            }},
        {field: 'qualification',title:'医师资格证书',width:100,align:"center",templet:function (res) {
                if(res.type == 2){
                    return '<img src="'+res.qualification+'" width="50" >'
                }else{
                    return '';
                }
            }},
        {field: 'practice_certificate',title:'医师执业证书',width:100,align:"center",templet:function (res) {
                if(res.type == 2){
                    return '<img src="'+res.practice_certificate+'" width="50" >'
                }else{
                    return '';
                }
            }},
        {field: 'business_licence',title:'组织机构代码证/营业执照',width:100,align:"center",templet:function (res) {
                if(res.type == 3 || res.type == 4){
                    return '<img src="'+res.business_licence+'" width="50" >'
                }else{
                    return '';
                }
            }},
        {field: 'status', title: '审核状态',width:92,templet:function (res) {
                if(res.status == 1){
                    return '<span class="label label-primary">待审核</span>';
                }else if(res.status == 2){
                    return '<span class="label label-danger">审核失败</span>';
                }else if(res.status == 3){
                    return '<span class="label label-success" lay-event="success">已审核</span>';
                }
            }},
        {field: 'audit_time', title: '审核时间',sort:true},
        {field: 'audit_remark', title: '审核备注'},
        {field: 'created_time', title: '申请时间',sort:true},
        {fixed: 'right', title:'操作', toolbar: '#barDemo', width:100},
    ]]
});

layui.table.on('tool(auth)', function(obj){
    var data = obj.data;
    if(obj.event === 'detail'){
        layer.alert('用户手机号：'+data.mobile+'<br>用户昵称：'+data.nickname+'<br/>运营者姓名：'+data.username+'<br/>运营者身份证号：'+data.idcard+'<br/>' +
            '身份证照正面照：<img src="'+data.card_img1+'" width="200px" height="120px"><br/><br/>身份证照背面照：<img src="'+data.card_img2+'" width="200px" height="120px"><br/><br/>' +
            '医师资格证书：<img src="'+data.qualification+'" width="200px" height="120px"><br/><br/>医师执业证书：<img src="'+data.practice_certificate+'" width="200px" height="120px"><br/><br/>' +
            '组织机构代码证/营业执照：<img src="'+data.business_licence+'" width="200px" height="120px"><br/>医院/组织名称：'+data.enterprise_name+'<br/>简介：'+data.profile+'<br>' +
            '联系手机号：'+data.phone+'<br/>详细地址：'+data.address+'<br/>岗位职称：'+data.duties+'<br/>擅长项目：'+data.speciality+'<br/>医院类型：'+data.hospital_type+'<br/>' +
            '医院/企业规模：'+data.scale+'<br/>医院机构成立时间：'+data.founding_time+'<br/>审核时间：'+data.audit_time+'<br/>审核备注：'+data.audit_remark+'<br/>' +
            '申请时间：'+data.created_time,{title:'详细信息',area:['500px','900px']});
    }
});

var $ = layui.$, active = {
    getCheckId: function () { //获取选中数据
        var checkStatus = layui.table.checkStatus('tab-reload'),data = checkStatus.data;
        if(data.length > 0){
            var ids = data[0].id;
            return ids;
        }else {
            return '';
        }
    },
};

$('#my-tab-status li').on('click',function(){
    objClass.where.status = $(this).data('status');
    objClass.reload();
});
var objClass = {
    where:{
        status:0
    },
    reload:function(){
        layui.table.reload('tab-reload', {
            page: {curr: 1},
            where:objClass.where
        });
    },
    fail:function(){
        var ids = active.getCheckId();
        if(ids.length == 0){
            layer.alert('请选择需要操作的商品',{title:'温馨提示'});
            return  false;
        }
        var index = layer.confirm('您确定要审核失败吗？', {
            btn: ['立即审核失败','取消']
        }, function(){
            objClass.updateSatus(ids,'fail','手动审核',index);
        });
    },
    success:function(){
        var ids = active.getCheckId();
        if(ids.length == 0){
            layer.alert('请选择需要操作的商品',{title:'温馨提示'});
            return  false;
        }
        var index = layer.confirm('您确定要审核成功吗？', {
            btn: ['立即审核成功','取消']
        }, function(){
            objClass.updateSatus(ids,'success','手动审核',index);
        });
    },
    updateLoading:true,
    updateSatus:function(ids,flag,audit_remark,index){
        if(objClass.updateLoading == true){
            $.ajax({
                url: '/admin/seller/updateAuthStatus',
                type: 'POST',
                data:{id:ids,flag:flag,audit_remark:audit_remark},
                dataType: "json",
                success: function (res) {
                    layer.close(index);
                    if(res.code == 200){
                        layer.msg('操作成功。。。', {icon: 1});
                        layui.table.reload('tab-reload', {page: {curr: objClass.currentpage}});
                    }else{
                        layer.msg('操作失败。。。', {icon: 2});
                    }
                }
            });
        }
    },
};