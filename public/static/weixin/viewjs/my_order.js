
$(".wl-deji li").click(function()　　 {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
    $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
    var index = $(this).index();
    $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");

});

var myObj = {
    //全部订单
    goods:{
        listData: {
            sellerid:0,
            status:0,
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 10,
        },
        loadList: function (me) {
            if (myObj.goods.listData.loading) {
                return false;
            }
            myObj.goods.listData.page++;
            if (myObj.goods.listData.ini == true) {
                if (myObj.goods.listData.page > myObj.goods.listData.page_total) {
                    me.resetload();

                    return false;
                }
            }
            var data = $.extend({},{page:myObj.goods.listData.sellerid,page:myObj.goods.listData.status,page: myObj.goods.listData.page, page_size: myObj.goods.listData.page_size});
            $.ajax({
                url: "/weixin/shopapi/getUserOrder",
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    myObj.goods.listData.loading = true;
                },
                complete: function () {
                    myObj.goods.listData.loading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if ( myObj.goods.listData.ini == false) {
                            myObj.goods.listData.ini = true;
                            myObj.goods.listData.page_total = res.data.page_total;
                            $('#container-list').html('');
                        }
                        layui.laytpl(orderList.innerHTML).render(res.data.rows, function(html){
                            $('#container-list').append(html);
                        });
                        if(myObj.goods.listData.page >= myObj.goods.listData.page_total){
                            me.noData();
                        }
                    }
                    me.resetload();
                }
            })
        }
    },
    //待支付订单
    paid:{
        listData: {
            sellerid:0,
            status:1,
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 10,
        },
        loadList: function (me) {
            if (myObj.paid.listData.loading) {
                return false;
            }
            myObj.paid.listData.page++;
            if (myObj.paid.listData.ini == true) {
                if (myObj.paid.listData.page > myObj.paid.listData.page_total) {
                    me.resetload();

                    return false;
                }
            }
            var data = $.extend({},{page:myObj.paid.listData.sellerid,page:myObj.paid.listData.status,page: myObj.paid.listData.page, page_size: myObj.paid.listData.page_size});
            $.ajax({
                url: "/weixin/shopapi/getUserOrder",
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    myObj.paid.listData.loading = true;
                },
                complete: function () {
                    myObj.paid.listData.loading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if ( myObj.paid.listData.ini == false) {
                            myObj.paid.listData.ini = true;
                            myObj.paid.listData.page_total = res.data.page_total;
                            $('#paid-list').html('');
                        }
                        layui.laytpl(paidList.innerHTML).render(res.data.rows, function(html){
                            $('#paid-list').append(html);
                        });
                        if(myObj.paid.listData.page >= myObj.paid.listData.page_total){
                            me.noData();
                        }
                    }else if (res.code == 401) {
                        redream.showTip('请先进行登录');
                    }
                    me.resetload();
                }
            })
        }
    },
    //待消费订单
    consumption:{
        listData: {
            sellerid:0,
            status:2,
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 15,
        },
        loadList: function (me) {
            if (myObj.consumption.listData.loading) {
                return false;
            }
            myObj.consumption.listData.page++;
            if (myObj.consumption.listData.ini == true) {
                if (myObj.consumption.listData.page > myObj.consumption.listData.page_total) {
                    me.resetload();

                    return false;
                }
            }
            var data = $.extend({},{page:myObj.consumption.listData.sellerid,page:myObj.consumption.listData.status,page: myObj.consumption.listData.page, page_size: myObj.consumption.listData.page_size});
            $.ajax({
                url: "/weixin/shopapi/getUserOrder",
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    myObj.consumption.listData.loading = true;
                },
                complete: function () {
                    myObj.consumption.listData.loading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if ( myObj.consumption.listData.ini == false) {
                            myObj.consumption.listData.ini = true;
                            myObj.consumption.listData.page_total = res.data.page_total;
                            $('#consumption-list').html('');
                        }
                        layui.laytpl(consumptionList.innerHTML).render(res.data.rows, function(html){
                            $('#consumption-list').append(html);
                        });
                        if(myObj.consumption.listData.page >= myObj.consumption.listData.page_total){
                            me.noData();
                        }

                    }
                    me.resetload();
                }
            })
        }
    },
    //已完成订单
    complete:{
        listData: {
            sellerid:0,
            status:3,
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 15,
        },
        loadList: function (me) {
            if (myObj.complete.listData.loading) {
                return false;
            }
            myObj.complete.listData.page++;
            if (myObj.complete.listData.ini == true) {
                if (myObj.complete.listData.page > myObj.complete.listData.page_total) {
                    me.resetload();

                    return false;
                }
            }
            var data = $.extend({},{page:myObj.complete.listData.sellerid,page:myObj.complete.listData.status,page: myObj.complete.listData.page, page_size: myObj.complete.listData.page_size});
            $.ajax({
                url: "/weixin/shopapi/getUserOrder",
                type: 'post',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    myObj.complete.listData.loading = true;
                },
                complete: function () {
                    myObj.complete.listData.loading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if ( myObj.complete.listData.ini == false) {
                            myObj.complete.listData.ini = true;
                            myObj.complete.listData.page_total = res.data.page_total;
                            $('#complete-list').html('');
                        }
                        layui.laytpl(completeList.innerHTML).render(res.data.rows, function(html){
                            $('#complete-list').append(html);
                        });
                        if(myObj.complete.listData.page >= myObj.complete.listData.page_total){
                            me.noData();
                        }
                    }
                    me.resetload();
                }
            })
        }
    },
};
var dropload = $('#container').dropload({
    scrollArea : window,
    loadUpFn:function(me){
        myObj.goods.listData.loading = false;
        myObj.goods.listData.ini = false;
        myObj.goods.listData.page = 0;
        myObj.goods.listData.page_total = 1;
        myObj.goods.loadList(me);
    },
    loadDownFn : function(me){
        myObj.goods.loadList(me);
    }
});
var dropload = $('#container-one').dropload({
    scrollArea : window,
    loadUpFn:function(me){
        myObj.paid.listData.loading = false;
        myObj.paid.listData.ini = false;
        myObj.paid.listData.page = 0;
        myObj.paid.listData.page_total = 1;
        myObj.paid.loadList(me);
    },
    loadDownFn : function(me){
        myObj.paid.loadList(me);
    }
});
var dropload = $('#container-two').dropload({
    scrollArea : window,
    loadUpFn:function(me){
        myObj.consumption.listData.loading = false;
        myObj.consumption.listData.ini = false;
        myObj.consumption.listData.page = 0;
        myObj.consumption.listData.page_total = 1;
        myObj.consumption.loadList(me);
    },
    loadDownFn : function(me){
        myObj.consumption.loadList(me);
    }
});
var dropload = $('#container-three').dropload({
    scrollArea : window,
    loadUpFn:function(me){
        myObj.complete.listData.loading = false;
        myObj.complete.listData.ini = false;
        myObj.complete.listData.page = 0;
        myObj.complete.listData.page_total = 1;
        myObj.complete.loadList(me);
    },
    loadDownFn : function(me){
        myObj.complete.loadList(me);
    }
});
