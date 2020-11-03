<?php /*a:2:{s:79:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\shop\have_good.html";i:1545470498;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1544697367;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="applicable-device" content="pc,mobile">
    <title><?php echo config('conf.title'); ?></title>
    <!--这里引入框架 需要的 css script-->
    <link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/dropload.css"/>
    <link rel="stylesheet" href="/static/css/function.css">
    
<link rel="stylesheet" href="/static/weixin/shop/css/have_good.css">
<style>

</style>

</head>

<body style="width:100%;max-width: 640px;margin:0 auto;background: white">
    

<!--这里编写主体内容-->
<div style="width: 100%;min-height: 500px;">
    <header>
        <div class="wl-top">
            <a href="/weixin/shop/index"><i class="iconfont icon-back_light top-left" style="font-size: 25px;color: #333333"></i></a>
            <span>有好货</span>
        </div>
    </header>
    <main>
        <div class="wl-jieshao"> 爱美的仙女都在买</div>
        <div id="container">
            <div id="container-list">

            </div>
        </div>
    </main>
</div>

    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>
<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-shangping href click-to-havegoodDetails" data-id="{{item.id}}">
        <div class="wl-sp-img">
            <img src="{{item.img}}" />
        </div>
        <div class="wl-xiang href">
            <div class="wl-top-title">{{item.name}}</div>
            <div class="wl-title">{{item.title}}</div>
            <div class="wl-yuding">
                <div class="wl-yiyuan">{{item.like}}人喜欢</div>
                <div class="wl-jiage">
                    <span class="wl-jiage1"><sub style="font-size: 8px">￥</sub><span>{{item.sell_price}}</span></span>
                    <span class="wl-quchu">￥{{item.market_price}}</span>
                </div>
            </div>
        </div>
        <dl style="clear: both"></dl>
    </div>
    {{#  }); }}
</script>
<script>
    var myObj = {
        goods: {
            listData: {
                loading: false,
                ini: false,
                page: 0,
                page_total: 1,
                page_size: 3,
            },
            loadList: function (me) {

                if (myObj.goods.listData.loading) {
                    return false;
                }
                myObj.goods.listData.page++;
                if (myObj.goods.listData.ini == true) {
                    if (myObj.goods.listData.page > myObj.goods.listData.page_total) {
                        me.resetload();
                        return false;
                    }
                }
                $.ajax({
                    url: "/weixin/shopapi/getGoodGoodsList",
                    type: 'post',
                    data: {page: myObj.goods.listData.page, page_size: myObj.goods.listData.page_size},
                    dataType: 'json',
                    beforeSend: function () {
                        myObj.goods.listData.loading = true;
                    },
                    complete: function () {
                        myObj.goods.listData.loading = false;
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            if (myObj.goods.listData.ini == false) {
                                myObj.goods.listData.ini = true;
                                myObj.goods.listData.page_total = res.data.page_total;
                                $('#container-list').html('');
                                if(res.data.page_total == 0){
                                    $('#container-list').html('<div class="wl-no-shuju" style="margin-top: 40px"><dl class="iconfont icon-tianxierenzhengxinxi" style="font-size: 30px"></dl><dt style="margin: 0">暂无商品</dt></div>');
                                    $(".dropload-down").hide();
                                }
                            }

                            layui.laytpl(templateList.innerHTML).render(res.data.rows, function (html) {
                                $('#container-list').append(html);
                            });

                            if(myObj.goods.listData.page >= myObj.goods.listData.page_total){
                                me.noData();
                            }
                        }
                        me.resetload();
                    }
                });
            }
        }
    };
    var dropload = $('#container').dropload({
        scrollArea: window,
        loadUpFn: function (me) {
            myObj.goods.listData.loading = false;
            myObj.goods.listData.ini = false;
            myObj.goods.listData.page = 0;
            myObj.goods.listData.page_total = 1;
            myObj.goods.listData.path = '';
            myObj.goods.loadList(me);
        },
        loadDownFn: function (me) {
            myObj.goods.loadList(me);
        }
    });
    $(document).on('click','.click-to-havegoodDetails',function(){
        window.location.href = '/weixin/shop/havegoodDetails?gid='+$(this).data('id');
    })
</script>

</body>
</html>