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
    add:function(){
        window.location.href = '/seller/shop/addGood';
    }
};


$('#my-tab-status li').on('click',function(){
    objClass.where.status = $(this).data('status');
    objClass.reload();
});

layui.table.render({
    elem: '#cus-data-table'
    ,id:'tab-reload'
    ,url:'/seller/shopapi/getSellerOrderList'
    ,toolbar: '#toolbarDemo'
    ,title: '用户数据表'
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "count": res.data.total, //解析数据长度
            "data": res.data.rows //解析数据列表
        };
    }
    ,cols: [[
        {type: 'checkbox', fixed: 'left'},
        {field: 'mobile', title: '手机号',width:150},
        {field: 'username', title: '用户名',width:100},

        {field: 'name', title: '商品名',width:300},
        {field: 'img', title: '商品图片',width:150,templet:function(row){
                return '<img src="'+row.img+'" width="100" >';
            }},
        {field: 'goods_nums', title: '购买数量',width:100},
        {field: 'goods_price', title: '销售价格',width:100},
        {field: 'discount_price', title: '优惠价格',width:100},
        {field: 'payable_amount', title: '应付商品总金额',width:100},
        {field: 'prepay_price', title: '预付价格',width:100},
        {field: 'topay_price', title: '到付价格',width:100},
        {field: 'real_amount', title: '实付金额',width:100},
        {field: 'pay_status', title: '支付状态',width:100,templet:function(row){
                if(row.status == 0){
                    return '<span class="label label-danger">未支付</span>';
                }else if(row.status == 1){
                    return '<span class="label label-success">已支付</span>';
                }
        }},
        {field: 'pay_time', title: '付款时间',width:200},
        {field: 'status', title: '订单状态',width:100,templet:function(row){
                if(row.status == 1){
                    return '<span class="label label-danger">待支付</span>';
                }else if(row.status == 3){
                    return '<span class="label label-success">已支付</span>';
                }else if(row.status == 5){
                    return '<span class="label label-warning">已完成</span>';
                }else if(row.status == 6){
                    return '<span class="label label-warning">退款订单</span>';
                }
            }},
        {field: 'order_no', title: '商品编号',width:300},
        {field: 'distribution_id', title: '分销产品',width:100,templet:function(row){
                if(row.distribution_id == 0){
                    return '<span class="label label-danger">否</span>';
                }else{
                    return '<span class="label label-success">是</span>';
                }
            }},

        {fixed: 'right', title:'操作', toolbar: '#barDemo', width:150}
    ]]
    ,page: true,
});