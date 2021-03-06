<?php /*a:1:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\layout.html";i:1542793065;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--  <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport" />-->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection"/>
    <link rel="stylesheet" type="text/css" href="/static/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/static/css/dropload.css"/>
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <title>薇琳医美</title>
    <meta content="telephone=no" name="format-detection" />
    <style>
        .wkf {
            display: none;
            position: fixed;
            top: 565px;
            left: 256px;
            width: 240px;
            height: 56px;
            line-height: 56px;
            text-align: center;
            background: #0FD6DD;
            color: #FFFFFF;
            font-size: 0.28rem;
            border-radius: 10px;
        }
        .se{
            color: #7DB0E8;
        }
        .xian{
            color: #7DB0E8 ;
        }
        .zd{margin-right: 5px;}
    </style>
</head>
<body style="background: #ffffff;width: 100%">
<div class="con">

    <?php if(!is_weixin()):?>
    <div class="wx-top">
        <a href="/weixin/user/main" class="topa"></a>
    </div>
    <?php endif;?>

    <ul class="biao">
        <li style="margin-left: 50px;" >推荐</li>
        <li >文章</li>
        <li>视频</li>
        <li>案例</li>
        <li>问答</li>
        <li style="margin-right: 36px;" >其它</li>
    </ul>

    <div id="cus-container" style="min-height: 500px;">
        <div id="wx-wz" style="padding-bottom: 20px">

        </div>
    </div>
    <div style="height: 100px"></div>
    <div class="wl-foot">
        <dl onclick="redream.href('/weixin/index/index')" class="dianji">
            <dd> <i class="iconfont icon-home_fill_light" style="font-size: 50px;color:#7DB0E8"></i></dd>
            <dt style="color:#7DB0E8">首页</dt>
        </dl>
        <dl class="dianji">
            <dd><i class="iconfont icon-news_hot_light" style="font-size: 50px"></i></dd>
            <dt>文章</dt>
        </dl>
        <dl class="dianji">
            <dd><i class="iconfont icon-video_light" style="font-size: 50px"></i></dd>
            <dt>视频</dt>
        </dl>
        <dl onclick="redream.href('/weixin/user/main')" class="dianji">
            <dd><i class="iconfont icon-my_light" style="font-size: 50px"></i></dd>
            <dt>我的</dt>
        </dl>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/rem.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
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
                            $('#wx-wz').html('');
                        }
                        $('#wx-wz').append(res.data.conetnt);
                        if (objClass.listData.page >= objClass.listData.page_total) {
                            me.noData();
                        }
                    }
                    me.resetload();
                }
            });
        },

    };


    $('#cus-container').dropload({
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

    function clickHref(id) {
        window.location.href = '/weixin/article/articleDetails/id/' + id;
    }
</script>
<script>
    $(function(){
        $(".biao li").eq(0).addClass("se");
        $(".biao li").click(function(){
            index=$(this).index();
            $(".biao li").eq(index).addClass("se").siblings().removeClass("se");
        })
    });
    $(".biao li").click(function () {
        var index=$(this).index();
        $(".biao li").eq(index).addClass("xian").siblings().removeClass("xian")
    })
</script>
</html>
