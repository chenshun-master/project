function getImgNum(obj){
    if(obj.thumbnail == '' ){
        return 1;
    }
    var thumbnail = $.parseJSON(obj.thumbnail);
    var thumbnailLength = Object.keys(thumbnail).length;
    if(thumbnailLength == 0){
        return 1;
    }else if(thumbnailLength > 0 && thumbnailLength < 3){
        if(obj.is_top != 0 || obj.recommended !=0){
            return 2;
        }else{
            return 3;
        }
    }else{
        return 4;
    }
}

function showImg(obj,type){
    var html ='';
    obj = $.parseJSON(obj);
    if(type == 4){
        $.each(obj,function(k,v){
            html += '<img src="'+ v +'" alt="">';
        });
    }else{
        html += '<img src="'+ obj.img_1 +'" alt="">';
    }
    return html;
}

// var objClass = {
//     listData: {
//         loading: false,
//         ini: false,
//         page: 0,
//         page_total: 1,
//         page_size: 15,
//     },
//
//     //相关推荐数据加载
//     loadList: function (me) {
//         if (this.listData.loading) {
//             return false;
//         }
//
//         this.listData.page++;
//         if (this.listData.ini == true) {
//             if (this.listData.page > this.listData.page_total) {
//                 me.resetload();
//                 return false;
//             }
//         }
//         $.ajax({
//             url: "/weixin/index/getArticleList",
//             type: 'post',
//             data: {type: 0, page: this.listData.page, page_size: this.listData.page_size},
//             dataType: 'json',
//             beforeSend: function () {
//                 objClass.listData.loading = true;
//             },
//             complete: function () {
//                 objClass.listData.loading = false;
//             },
//             success: function (res) {
//                 if (res.code == 200) {
//                     if (objClass.listData.ini == false) {
//                         objClass.listData.ini = true;
//                         objClass.listData.page_total = res.data.page_total;
//                         $('#container-list').html('');
//                     }
//
//                     var rows = res.data.rows;
//
//                     layui.laytpl(demo.innerHTML).render(rows, function(html){
//                         $('#container-list').append(html);
//                     });
//
//                     if (objClass.listData.page >= objClass.listData.page_total) {
//                         me.noData();
//                     }
//                 }
//                 me.resetload();
//             }
//         });
//     },
//
// };

// $('#container').dropload({
//     scrollArea: window,
//     loadUpFn: function (me) {
//         objClass.listData.loading = false;
//         objClass.listData.ini = false;
//         objClass.listData.page = 0;
//         objClass.listData.page_total = 1;
//         objClass.loadList(me);
//     },
//     loadDownFn: function (me) {
//         objClass.loadList(me);
//     }
// });

$(document).on('click','.to-datail-href',function () {
    if($(this).data('type') == 1){
        window.location.href = '/weixin/article/articleDetails/id/' + $(this).data('id');
    }
});

$(".wl-liebiao li").click(function () {
    $(this).addClass("actice").siblings().removeClass("actice");
    var index = $(this).index();
    $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
});

var mescroll = new MeScroll("container", {
    down:{auto:true},
    up: {
        clearEmptyId: "container-list",
        page: {num: 0,size: 20},
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
    searchList: function (page, successCallback, errorCallback) {
        var data = $.extend({}, {page: page.num, page_size: page.size});
        $.ajax({
            url: "/weixin/index/getArticleList",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (res) {
                successCallback(res.data.rows);
            },
        });
    },
};