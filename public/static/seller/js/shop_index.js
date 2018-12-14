var table = layui.table
table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,toolbar: '#toolbarDemo'
    ,url: '/seller/shopapi/getGoodsList' //数据接口
    ,page: true
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
        {field: 'name', title: '商品名'},
        {field: 'goods_no', title: '商品编号'},
        {field: 'store_nums', title: '库存/名额'},
        {field: 'status', title: '商品状态',width:100,templet:function(row){
            if(row.status == 0){
                return '<span class="label label-success">正常</span>';
            }else if(row.status == 1){
                return '<span class="label label-danger">已删除</span>';
            }else if(row.status == 2){
                return '<span class="label label-info">下架</span>';
            }else if(row.status == 3){
                return '<span class="label label-warning">申请上架</span>';
            }
        }},
        {field: 'market_price', title: '市场价格'},
        {field: 'sell_price', title: '销售价格'},
        {field: 'prepay_price', title: '预付价格'},
        {field: 'topay_price', title: '到付价格'},
        {field: '', title: '操作',width:100,templet:function(row){
            return '<a href="/seller/shop/addGood/goodsid/'+ row.id +'">编辑</a>';
        }},
    ]],
});

var objClass = {
    params:function(){
        return {status:0};
    },
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
        window.location.href = '/seller/shop/addGood';
    }
};