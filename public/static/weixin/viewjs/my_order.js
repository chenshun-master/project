

var curNavIndex=0;
var mescrollArr=new Array(4);
var url = window.location.toString();
var maodian = url.split('#')[1];
$('.mescroll').addClass('hide');
if(maodian == 'all'){
    $('#mescroll0').removeClass('hide');
    mescrollArr[0]= initMescroll("mescroll0", "dataList0");
}else if(maodian  == 'paid'){
    curNavIndex = 1;
    $('#mescroll1').removeClass('hide');
    mescrollArr[1]= initMescroll("mescroll1", "dataList1");
}else if(maodian == 'consumption'){
    curNavIndex = 2;
    mescrollArr[2]= initMescroll("mescroll2", "dataList2");
    $('#mescroll2').removeClass('hide');
}else if(maodian == 'complete'){
    curNavIndex = 3;
    mescrollArr[3]= initMescroll("mescroll3", "dataList3");
    $('#mescroll3').removeClass('hide');
}else{
    curNavIndex = 0;
    mescrollArr[0]= initMescroll("mescroll0", "dataList0");
    $('#mescroll0').removeClass('hide');
}

$(".nav > p").eq(curNavIndex).addClass('active').siblings().removeClass('active');


$(".nav p").click(function(){
    var i=Number($(this).attr("i"));
    if(curNavIndex!=i) {
        //更改列表条件
        $(".nav .active").removeClass("active");
        $(this).addClass("active");
        //隐藏当前列表和回到顶部按钮
        $("#mescroll"+curNavIndex).hide();
        mescrollArr[curNavIndex].hideTopBtn();
        //显示对应的列表
        $("#mescroll"+i).show();
        //取出菜单所对应的mescroll对象,如果未初始化则初始化
        if(mescrollArr[i]==null){
            mescrollArr[i]=initMescroll("mescroll"+i, "dataList"+i);
        }
        //更新标记
        curNavIndex=i;
    }
});

function initMescroll(mescrollId,clearEmptyId){
    var mescroll = new MeScroll(mescrollId, {
        down:{auto:true},
        up: {
            clearEmptyId: clearEmptyId,
            page: {num: 0,size: 20},
            htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
            isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
            noMoreSize: 5, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看
            empty: {
                icon: "/static/weixin/image/mescroll/dingdan.png", //图标,默认null
                tip: "亲,您还没有相关的订单~", //提示
                btntext: "去逛逛 >",
                btnClick: function(){
                    window.location.href = "/weixin/shop/index";
                }
            },
            callback: function(page){
                listObj.searchList(page,function(curPageData){
                    mescroll.endSuccess(curPageData.length);
                    var template = orderList.innerHTML;
                    if(curNavIndex==0){
                        layui.laytpl(template).render(curPageData, function(html){
                            $('#dataList0').append(html);
                        });
                    }else if(curNavIndex==1){
                        layui.laytpl(template).render(curPageData, function(html){
                            $('#dataList1').append(html);
                        });
                    }else if(curNavIndex==2){
                        layui.laytpl(template).render(curPageData, function(html){
                            $('#dataList2').append(html);
                        });
                    }else if(curNavIndex==3){
                        layui.laytpl(template).render(curPageData, function(html){
                            $('#dataList3').append(html);
                        });
                    }
                }, function(){
                    mescroll.endErr();
                });
            },
        }
    });

    return mescroll;
}

var listObj = {
    searchList: function (page, successCallback, errorCallback) {
        var data = $.extend({}, {page: page.num, page_size: page.size}, {status:curNavIndex});
        $.ajax({
            url: "/weixin/shopapi/getUserOrder",
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
$(document).on('click','.click-to-orderpaydetail',function(){
    window.location.href = '/weixin/shop/orderDetails?oid='+$(this).data('oid');
}).on('click','.click-to-paydetail',function(){
    window.location.href = '/weixin/shop/methodpayment/?oid='+$(this).data('oid');
}).on('click','.to-myorder',function(){
    window.location.href = '/weixin/shop/paymentOrder/oid/'+$(this).data('oid');
});


