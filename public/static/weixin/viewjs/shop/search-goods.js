$(".wl-deji li").click(function () {
    $(this).addClass("active").siblings().removeClass("active");
    var index = $(this).index();
    $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
});