var mySwiper = new Swiper('.swiper-container', {
    autoplay: true,//可选选项，自动滑动
    pagination: {
        el: '.swiper-pagination',
    }
});
$(".wl-deji li").click(function()　　 {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
    $(this).addClass("active").siblings().removeClass("active");//获取选中元素的下标
    var index = $(this).index();
    if(index == 0){
        var top = parseInt($('#wl-xiangqing').offset().top) - 75;
        console.log(top);
    }else if(index == 1){
        var top = parseInt($('#cus-xuzi').offset().top) - 75;
    }else if(index == 2){
        var top = parseInt($('#wl-meili-riji').offset().top) - 75;
    }
    $("html,body").animate({scrollTop:top+'px'}, 500);
});

$(".dianhua-right").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".marsk-container").toggle();
});

//点击空白处隐藏弹出层
$(".marsk-container").click(function (event) {
    var _con = $('.tkyy_con'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.marsk-container').hide(); //淡出消失
    }
});
$(".quxiao").click(function () {
    $('.marsk-container').hide(); //淡出消失
});

$(document).on('click','.dianhua-left',function(){
    window.location.href = '/weixin/index/hospital';
});

$(document).on('click','#click-place-order',function(){
    window.location.href = $(this).data('href')+'?goodsid='+$(this).data('goodsid')+'&gid='+$(this).data('gid');
});

$(window).scroll(function(){
    var scrollTop = parseInt($(this).scrollTop());

    if(scrollTop == 0 || scrollTop > 414){
        $('.wl-top').css('opacity','1');
    }else if(scrollTop < 414){
        if(scrollTop < 50 ){
            $('.wl-top').css('opacity','0.5');
        }else if(scrollTop < 100){
            $('.wl-top').css('opacity','0.45');
        }else if(scrollTop < 120){
            $('.wl-top').css('opacity','0.43');
        }else if(scrollTop < 130){
            $('.wl-top').css('opacity','0.42');
        }else if(scrollTop < 150){
            $('.wl-top').css('opacity','0.41');
        }else if(scrollTop < 170){
            $('.wl-top').css('opacity','0.38');
        }else if(scrollTop < 200){
            $('.wl-top').css('opacity','0.35');
        }else if(scrollTop < 210){
            $('.wl-top').css('opacity','0.32');
        }else if(scrollTop < 220){
            $('.wl-top').css('opacity','0.3');
        }else if(scrollTop < 230){
            $('.wl-top').css('opacity','0.28');
        }else if(scrollTop < 220){
            $('.wl-top').css('opacity','0.25');
        }else if(scrollTop < 250){
            $('.wl-top').css('opacity','0.22');
        }else if(scrollTop < 270){
            $('.wl-top').css('opacity','0.20');
        }else if(scrollTop < 290){
            $('.wl-top').css('opacity','0.18');
        }else if(scrollTop < 310){
            $('.wl-top').css('opacity','0.15');
        }else if(scrollTop < 340){
            $('.wl-top').css('opacity','0.11');
        }else if(scrollTop < 360){
            $('.wl-top').css('opacity','0.08');
        }
    }

    if(scrollTop >= parseInt($('#cus-test-content').offset().top)){
        $(".wl-deji").addClass("wl-deji-show").fadeIn();
    }else{
        $(".wl-deji").removeClass("wl-deji-show").fadeOut('slow');
    }

    if(scrollTop >= parseInt($('#wl-meili-riji').offset().top) -75){
        $(".wl-deji li").eq(2).find('i').show().parent().siblings().find('i').hide();
        $(".wl-deji li").eq(2).addClass("active").siblings().removeClass('active');
    }else if(scrollTop >= parseInt($('#cus-xuzi').offset().top) -75){
        $(".wl-deji li").eq(1).find('i').show().parent().siblings().find('i').hide();
        $(".wl-deji li").eq(1).addClass("active").siblings().removeClass('active');
    }else if(scrollTop >= parseInt($('#wl-xiangqing').offset().top)-75){
        $(".wl-deji li").eq(0).find('i').show().parent().siblings().find('i').hide();
        $(".wl-deji li").eq(0).addClass("active").siblings().removeClass('active');
    }
});

$(document).on('click','.to-goods-detai',function(){
    window.location.href = '/weixin/shop/goodsDetails/goodsid/'+$(this).data('goodsid');
});
$('#click-to-referer').on('click',function(){
    window.location.href = $(this).data('href');
});
$(".wl-zizhi").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".marsk-container1").toggle();
});

//点击空白处隐藏弹出层
$(".marsk-container1").click(function (event) {
    var _con = $('.tkyy_con1'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.marsk-container1').hide(); //淡出消失
    }
});

$(".wl-quxiao").click(function () {
    $(".marsk-container1").hide();
});

$(".top-right").click(function () {
    $("#cus-myshare-box").show();
});

$("#cus-myshare-box").click(function () {
    $("#cus-myshare-box").hide();
});

var myObj = {
    goods:{
        listData: {
            sellerid:0,
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 3,
        },
        loadList: function () {
            if (myObj.goods.listData.loading) {
                return false;
            }
            myObj.goods.listData.page++;
            if (myObj.goods.listData.ini == true) {
                if (myObj.goods.listData.page > myObj.goods.listData.page_total) {
                    $('#cus-recommend-loading-btn').text('没有了');
                    return false;
                }
            }
            $.ajax({
                url: "/weixin/shopapi/getSellerHotGoods",
                type: 'post',
                data: {page:myObj.goods.listData.sellerid,page: myObj.goods.listData.page, page_size: myObj.goods.listData.page_size},
                dataType: 'json',
                beforeSend: function () {
                    myObj.goods.listData.loading = true;
                    $('#cus-recommend-loading-btn').text('加载中...');
                },
                complete: function () {
                    myObj.goods.listData.loading = false;
                    // $(".marsk-container2").hide();
                    $('#cus-recommend-loading-btn').text('查看更多');
                },
                success: function (res) {
                    if (res.code == 200) {
                        if ( myObj.goods.listData.ini == false) {
                            $('#container-list').html('');
                            myObj.goods.listData.ini = true;
                            myObj.goods.listData.page_total = res.data.page_total;
                            if ( res.data.page_total == 0) {
                                $('.wl-gengduo').hide();
                            } else {
                                $('.wl-gengduo').show();
                            }
                        }
                        layui.laytpl(templateList.innerHTML).render(res.data.rows, function(html){
                            $('#container-list').append(html);
                        });
                    }
                }
            });
        },

        collectionLoading: false,
        collection: function (o, dataObj) {
            if (myObj.goods.collectionLoading == false) {
                $.ajax({
                    url: "/weixin/user/giveFavorite",
                    type: 'post',
                    data: dataObj,
                    dataType: 'json',
                    beforeSend: function () {
                        myObj.collectionLoading = true;
                    },
                    complete: function () {
                        myObj.collectionLoading = false;
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            if (dataObj.flag == 2) {
                                if (dataObj.type == 1) {
                                    o.data('type', 1).removeClass('icon-favor_light').addClass("icon-favor_fill_light").addClass('cus-sou');
                                } else {
                                    o.data('type', 0).removeClass('icon-favor_fill_light').removeClass('cus-sou').addClass("icon-favor_light");
                                }
                            }
                        } else if (res.code == 401) {
                            redream.showTip('请登录后操作...');
                        }
                    }
                });
            }
        },
    },

};
myObj.goods.loadList();

$(document).on('click', '#cus-click-collection', function () {
    var type = $(this).data('type');
    if (type == 0) {
        type = 1;
    } else {
        type = 2;
    }
    myObj.goods.collection($(this), {type: type, obj_id:$(this).data('gid'), flag: 2});

});

$('#wl-goods-detail').find('img').removeAttr('width').removeAttr('height');
$('#wl-goods-detail').find('table').removeAttr('width').removeAttr('height');