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

var objClass = {
    listData: {
        loading: false,
        ini: false,
        page: 0,
        page_total: 1,
        page_size: 15,
    },

    //相关推荐数据加载
    loadList: function (me) {
        if (this.listData.loading) {
            return false;
        }

        this.listData.page++;
        if (this.listData.ini == true) {
            if (this.listData.page > this.listData.page_total) {
                me.resetload();
                return false;
            }
        }
        $.ajax({
            url: "/weixin/index/getArticleList",
            type: 'post',
            data: {type: 0, page: this.listData.page, page_size: this.listData.page_size},
            dataType: 'json',
            beforeSend: function () {
                objClass.listData.loading = true;
            },
            complete: function () {
                objClass.listData.loading = false;
            },
            success: function (res) {
                if (res.code == 200) {
                    if (objClass.listData.ini == false) {
                        objClass.listData.ini = true;
                        objClass.listData.page_total = res.data.page_total;
                        $('#container-list').html('');
                    }

                    var rows = res.data.rows;

                    layui.laytpl(demo.innerHTML).render(rows, function(html){
                        $('#container-list').append(html);
                    });

                    if (objClass.listData.page >= objClass.listData.page_total) {
                        me.noData();
                    }
                }
                me.resetload();
            }
        });
    },

};

$('#container').dropload({
    scrollArea: window,
    loadUpFn: function (me) {
        objClass.listData.loading = false;
        objClass.listData.ini = false;
        objClass.listData.page = 0;
        objClass.listData.page_total = 1;
        objClass.loadList(me);
    },
    loadDownFn: function (me) {
        objClass.loadList(me);
    }
});

$(document).on('click','.to-datail-href',function () {
    if($(this).data('type') == 1){
        window.location.href = '/weixin/article/articleDetails/id/' + $(this).data('id');
    }
});
$(".wl-liebiao li").click(function () {
    var index=$(this).index();
    $(".wl-liebiao li").eq(index).addClass("xian").siblings().removeClass("xian")
});