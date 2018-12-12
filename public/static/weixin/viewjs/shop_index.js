$("#wl-quanbu").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".marsk-container").toggle();
    $(".marsk-container1").hide();
    $(".qiehuan").toggleClass('iconfont icon-shangsanjiaoxiangshangmianxing-copy');
    $(".qiehuan").toggleClass('iconfont icon-shangsanjiaoxiangshangmianxing');
});

//点击空白处隐藏弹出层
$(".marsk-container").click(function (event) {
    var _con = $('.tkyy_con'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.marsk-container').hide(); //淡出消失
    }
});

$("#wl-zhineng").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".marsk-container1").toggle();
    $(".marsk-container").hide();
    $(".qiehuan2").toggleClass('iconfont icon-shangsanjiaoxiangshangmianxing-copy');
    $(".qiehuan2").toggleClass('iconfont icon-shangsanjiaoxiangshangmianxing');
});

//点击空白处隐藏弹出层
$(".marsk-container1").click(function (event) {
    var _con = $('.tkyy_con1'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.marsk-container1').hide(); //淡出消失
    }
});

$(".wl-deji li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
    $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
    var index = $(this).index();
    $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
});

$('.click-select-category').on('click', function () {
    myObj.goods.listData.path = $(this).data('path');
    myObj.goods.dropReloadList();
});

var myObj = {
    goods:{
        listData: {
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 15,
            path:'',
        },
        dropReloadList:function(){
            $('.marsk-container,.marsk-container1').hide();
            $(".marsk-container2").show();

            myObj.goods.listData.loading = false;
            myObj.goods.listData.ini = false;
            myObj.goods.listData.page = 0;
            myObj.goods.listData.page_total = 1;

            this.loadList(null);
        },
        loadList: function (me) {
            if (myObj.goods.listData.loading) {
                return false;
            }

            myObj.goods.listData.page++;
            if (myObj.goods.listData.ini == true) {
                if (myObj.goods.listData.page > myObj.goods.listData.page_total) {
                    if(me !== null){
                        me.resetload();
                    }
                    return false;
                }
            }

            $.ajax({
                url: "/weixin/shopapi/getGoodsList",
                type: 'post',
                data: {page: myObj.goods.listData.page, page_size: myObj.goods.listData.page_size,path:myObj.goods.listData.path},
                dataType: 'json',
                beforeSend: function () {
                    myObj.goods.listData.loading = true;
                },
                complete: function () {
                    myObj.goods.listData.loading = false;
                    $(".marsk-container2").hide();
                },
                success: function (res) {
                    if (res.code == 200) {
                        if ( myObj.goods.listData.ini == false) {
                            myObj.goods.listData.ini = true;
                            myObj.goods.listData.page_total = res.data.page_total;
                            $('#container-list').html('');
                        }

                        layui.laytpl(templateList.innerHTML).render(res.data.rows, function(html){
                            $('#container-list').append(html);
                        });

                        if ( myObj.goods.listData.page >=  myObj.goods.listData.page_total) {
                            if(me !== null){
                                me.noData();
                            }
                        }
                    }

                    if(me !== null){
                        me.resetload();
                    }
                },
                error:function(){
                    if(me !== null){
                        me.resetload();
                    }
                }
            });
        }
    }
};

// var dropload = $('#container').dropload({
//     scrollArea: window,
//     loadUpFn: function (me) {
//         myObj.goods.listData.loading = false;
//         myObj.goods.listData.ini = false;
//         myObj.goods.listData.page = 0;
//         myObj.goods.listData.page_total = 1;
//         myObj.goods.listData.path = '';
//         myObj.goods.loadList(me);
//     },
//     loadDownFn: function (me) {
//         myObj.goods.loadList(me);
//     }
// });