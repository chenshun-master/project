$(".wl-deji li").click(function () {
    $(this).addClass("active").siblings().removeClass("active");
    var index = $(this).index();
    $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
});




var listObj = {

};



var mescroll = new MeScroll("mescroll", {
    down:{auto:false},
    up: {
        page: {
            num: 0,
            size: 10
        },
        callback: getListData, //上拉回调,此处可简写; 相当于 callback: function (page) { getListData(page); }
        clearEmptyId: "dataList", //1.下拉刷新时会自动先清空此列表,再加入数据; 2.无任何数据时会在此列表自动提示空
        isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
        noMoreSize: 3, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看
        empty: {
            icon: "../res/img/mescroll-empty.png", //图标,默认null
            tip: "亲,没有您要找的商品~", //提示
        }
    }
});