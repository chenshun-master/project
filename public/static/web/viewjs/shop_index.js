$(".wl-xian").click(function () {
    $(".wl-cang").toggle();
});
$(".wl-price").click(function () {
    $(".wl-sorting-gao").toggle();
});

$(".wl-sorting li").click(function () {
    $(this).addClass("active").siblings().removeClass("active");//获取选中元素的下标
});

$(".wl-yingj").click(function () {
    $(".wl-ding").toggle();
    $(".qiehuan").toggleClass('iconfont  icon-triangledownfill');
    $(".qiehuan").toggleClass('iconfont icon-triangleupfill');
});

$(document).on('click', '.click-to-create', function () {
    window.location.href = '/index/shop/shopEditor?gid='+$(this).data('goods_id');
});

var listObj = {
    params:{
        ini:true,
        page: 0,
        page_size: 14,
        category:'',
        sort:0,
        city:'',
        keywords:'',
        page_total:0,
    },
    loadlist:function(laypageObj){
        listObj.params.page++;

        if(listObj.params.ini == false && listObj.params.page > listObj.params.page_total){
            listObj.params.page--;
            $('#click-reload-more').find('a').addClass('layui-disabled').text('没有更多了');
            return false;
        }else{
            $('#click-reload-more').find('a').removeClass('layui-disabled').text('加载更多');
        }

        $.ajax({
            url: "/index/shop/getShopList",
            type: 'post',
            data: listObj.params,
            dataType: 'json',
            success: function (res) {
                if(res.code == 200){
                    listObj.params.page_total = res.data.page_total;

                    layui.laytpl(shoptemplateList.innerHTML).render(res.data.rows, function(html){
                        console.log(listObj.params.ini);
                        if(listObj.params.ini){
                            $('#content').html(html);
                        }else{
                            $('#content').append(html);
                        }
                        listObj.params.ini = false;
                    });
                }
            }
        });
    }
};

listObj.loadlist();

var objClass = {
    categoryList:[],
    loading:false,
};

$(document).on('click','.click-find-category',function(){
    $(this).addClass("se").siblings().removeClass("se");
    listObj.params.ini = true;
    listObj.params.page = 0;
    listObj.params.category = $(this).data('id');
    listObj.loadlist();
});

$(document).on('click','.click-find-sort',function(){
    listObj.params.sort = $(this).data('sort');
    listObj.params.ini = true;
    listObj.params.page = 0;
    listObj.loadlist();
    $('#web-jiage').hide();
});

$('#click-reload-more').on('click',function(){
    listObj.loadlist();
});