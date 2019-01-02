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
    listObj.params.category = $(this).data('path');
    mescroll.resetUpScroll();
    $('.click-select-category').removeClass('wl-se1');
    $(this).addClass("wl-se1");
    $(".marsk-container").hide();
});
$('.wl-shuaxin').on('click', function () {
    mescroll.resetUpScroll();
    window.scrollTo(0,0);
});
$('.click-select-sort > p').on('click', function () {
    listObj.params.sort = $(this).data('sort');
    listObj.params.type =  parseInt($(this).index()) + 1;
    mescroll.resetUpScroll();
    $(this).addClass("wl-se").siblings().removeClass("wl-se");
    window.scrollTo(0, 0);
    $(".marsk-container1").hide();
});

$(document).on('click','.to-goods-detail',function(){
    window.location.href = '/weixin/shop/goodsDetails/goodsid/'+$(this).data('goodsid');
}).on('click','#wl-tingbu',function(){
    $('#container').animate({scrollTop:0},500);
});

var mescroll = new MeScroll("container", {
    down:{auto:true},
    up: {
        clearEmptyId: "container-list",
        page: {num: 0,size: 15},
        htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
        isBounce: false,
        noMoreSize: 5,
        empty: {
            icon: "/static/weixin/shop/image/tuoian.png",
            tip: "亲,没有您要找的商品~", //提示
        },
        callback: function(page){
            listObj.searchList(page,function(curPageData){
                mescroll.endSuccess(curPageData.length);
                layui.laytpl(templateList.innerHTML).render(curPageData, function(html){
                    $('#container-list').append(html);
                });
            }, function(){
                mescroll.endErr();
            });
        }
    }
});

var listObj = {
    params: { category:'', sort:0, city:'', keywords:'',type:1},
    searchList: function (page, successCallback, errorCallback) {
        var data = $.extend({}, {page: page.num, page_size: page.size}, listObj.params);
        $.ajax({
            url: "/weixin/shopapi/getGoodsList",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (res) {
                successCallback(res.data.rows);
            },
            error: errorCallback
        });
    },
};