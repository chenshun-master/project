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
    }else if(index == 1){
        var top = parseInt($('#cus-xuzi').offset().top) -75;
    }else if(index == 2){
        var top = parseInt($('#wl-meili-riji').offset().top) -75;
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

// $('#click-place-order').on('click',function(){
//     // window.location.href =$(this).data('href');
//     alert('asd');
//     window.location.href = $(this).data('href')+'?goodsid='+$(this).data('goodsid');
// });

$(document).on('click','#click-place-order',function(){
    window.location.href = $(this).data('href')+'?goodsid='+$(this).data('goodsid');
});

$(window).scroll(function(){
    var scrollTop = parseInt($(this).scrollTop());

    if(scrollTop == 0 || scrollTop > 240){
        $('.wl-top').css('opacity','1');
    }else if(scrollTop < 240){
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
            $('.wl-top').css('opacity','0.3');
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
    }else if(scrollTop >= parseInt($('#wl-xiangqing').offset().top) - 75){
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
    },

};
myObj.goods.loadList();