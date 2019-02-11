layui.table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,url: '/admin/goods/getGoodsList' //数据接口
    ,toolbar: '#toolbarDemo'
    ,page: true
    ,request: {
        pageName: 'page' //页码的参数名称，默认：page
        ,limitName: 'page_size' //每页数据量的参数名，默认：limit
        ,seller_id:'seller_id'
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
        {type: 'checkbox', fixed: 'left'},
        {field: 'goods_no', title: '商品的编号',sort:true},
        {field: 'real_name', title: '坐诊医生'},
        {field: 'hospital_name', title: '坐诊医院'},
        {field: 'name', title: '项目名称'},
        {field: 'img', title: '商品图片',width:100,align:"center",templet:function (res) {
                return '<img src="'+res.img+'" width="30" >';
            }},
        {field: 'market_price', title: '市场价格',sort:true},
        {field: 'sell_price', title: '销售价格',sort:true},
        {field: 'prepay_price', title: '预付价格',sort:true},
        {field: 'topay_price', title: '到付价格',sort:true},
        {field: 'up_time', title: '上架时间',sort:true},
        {field: 'down_time', title: '下架时间',sort:true},
        {field: 'store_nums', title: '库存/名额',sort:true},
        {field: 'status', title: '当前状态',sort:true,width:100,templet:function (res) {
                if(res.status == 0){
                    return '<span class="label label-success">审核成功</span>';
                }else if(res.status == 1){
                    return '<span class="label label-primary">已删除</span>';
                }else if(res.status == 2){
                    return '<span class="label label-danger">下架</span>';
                }else if(res.status == 3){
                    return '<span class="label label-warning">等待审核</span>';
                }
            }},
        {field: 'sale_num', title: '项目预约数',sort:true},
        {field: 'case_num', title: '案例数',sort:true},
        {field: 'create_time', title: '创建时间'},
    ]]
});

var $ = layui.$, active = {
    getCheckId: function(){ //获取选中数据
        var checkStatus = layui.table.checkStatus('tab-reload') ,data = checkStatus.data;
        if(data.length > 0){
            var ids = [];
            $.each(data,function(k,v){ids.push(v.id);});
            return ids;
        }else{
            return [];
        }
    },
    getInfo: function(){
        var status = $('#status').val();
        //执行重载
        if($('#status').val()){
            var index = layer.msg('查询中，请稍候...',{icon: 16,time:false,shade:0});
            setTimeout(function() {
                layui.table.reload('tab-reload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , where: {
                        status: status,
                    }
                });
                layer.close(index);
            },800);
        }else{
            table.reload('tab-reload', {
                where: {
                    status:status,
                }
            });
            layui.table.reload('');
        }
    }
};
$('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
});

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
    lower:function(){
        var ids = active.getCheckId();
        if(ids.length == 0){
            layer.alert('请选择需要操作的商品',{title:'温馨提示'});
            return  false;
        }
        var index = layer.confirm('您确定要下架商品吗？', {
            btn: ['立即下架','取消']
        }, function(){
            objClass.updateSatus(ids,'lower',index);
        });
    },
    normal:function(){
        var ids = active.getCheckId();
        if(ids.length == 0){
            layer.alert('请选择需要操作的商品',{title:'温馨提示'});
            return  false;
        }
        var index = layer.confirm('您确定要审核成功商品吗？', {
            btn: ['立即审核成功','取消']
        }, function(){
            objClass.updateSatus(ids,'normal',index);
        });
    },
    updateLoading:true,
    updateSatus:function(ids,flag,index){
        if(objClass.updateLoading == true){
            $.ajax({
                url: '/admin/goods/updateGoodsStatus',
                type: 'POST',
                data:{ids:ids,flag:flag},
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
    }
};