var table = layui.table
table.render({
    elem: '#table-list'
    ,id:'tab-reload'
    ,toolbar: '#toolbarDemo'
    ,url: '/seller/shopapi/getGoodsList' //数据接口
    ,page: true
    ,loading:true
    ,parseData: function(res){ //res 即为原始返回的数据
        return {
            "code": res.code == 200?0:res.code, //解析接口状态
            "msg": res.msg, //解析提示文本
            "count": res.data.total, //解析数据长度
            "data": res.data.rows //解析数据列表
        };
    }
    ,text: {
        none: '暂无相关数据'
    }
    ,cols: [[ //表头
        {field: 'id', title: 'ID', fixed: 'left',width:100},
        {field: 'name', title: '商品名',minWidth:200},
        {field: 'goods_no', title: '商品编号',width:200},
        {field: 'store_nums', title: '库存/名额',width:100,align:'center'},
        {field: 'status', title: '商品状态',width:100,align:'center',templet:function(row){
            if(row.status == 0){
                return '<span class="label label-success">正常</span>';
            }else if(row.status == 1){
                return '<span class="label label-danger">已删除</span>';
            }else if(row.status == 2){
                return '<span class="label label-warning">下架</span>';
            }else if(row.status == 3){
                return '<span class="label label-info">申请上架</span>';
            }
        }},
        {field: 'market_price', title: '市场价格',width:100},
        {field: 'sell_price', title: '销售价格',width:100},
        {field: 'prepay_price', title: '预付价格',width:100},
        {field: 'topay_price', title: '到付价格',width:100},

        {field: 'visit', title: '浏览次数',width:100},
        {field: 'favorite', title: '收藏次数',width:100},
        // {field: 'comments', title: '预付价格',width:100},
        {field: 'sale_num', title: '预约数',width:100},
        {field: 'case_num', title: '案例数',width:100},

        {field: '', title: '操作',width:100,templet:function(row){
            return '<a href="/seller/shop/addGood/goodsid/'+ row.id +'">编辑</a>';
        }},
    ]],
    limits:[10,20,30,50,100]
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