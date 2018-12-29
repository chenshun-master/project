$(".wl-deji li").click(function () {
    $(this).addClass("active").siblings().removeClass("active");
    listObj.params.type =  parseInt($(this).index()) + 1;
    mescroll.resetUpScroll();
});

$('#click-commodity-search').click(function(){
    listObj.params.keywords = $('#fr-keywords').val();
    mescroll.resetUpScroll();
});

var mescroll = new MeScroll("container", {
    down:{auto:true},
    up: {
        clearEmptyId: "container-list",
        page: {num: 0,size: 15},
        isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
        noMoreSize: 3, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看
        empty: {
            icon: "/static/plugin/mescroll/img/mescroll-empty.png", //图标,默认null
            tip: "亲,没有您要找的商品~", //提示
        },
        callback: function(page){
            listObj.searchList(page,function(curPageData){
                mescroll.endSuccess(curPageData.length);

                layui.laytpl(goodsTemplateList.innerHTML).render(curPageData, function(html){
                    console.log(html);
                    $('#container-list').append(html);
                });
            }, function(){
                mescroll.endErr();
            });
        },
    }
});

var listObj = {
    params:{keywords:'',type:1},
    searchList:function(page,successCallback,errorCallback){
        var data = $.extend({},{page: page.num, page_size: page.size}, listObj.params);
        $.ajax({
            url: "/weixin/shopapi/search",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (res) {


                successCallback(res.data.rows);
            },
            error:errorCallback
        });
    }
};