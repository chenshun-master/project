<?php /*a:4:{s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\diary_user.html";i:1547113840;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1546521460;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\header.html";i:1545451098;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\footer.html";i:1544520347;}*/ ?>
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
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" href="/static/css/function.css">
    
<!--<link rel="stylesheet" href="/main.css">-->
<link rel="stylesheet" href="/static/weixin/css/diary_user.css">
<link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
<style>

</style>

</head>

<body style="width:100%;max-width: 640px;margin:0 auto;background: white">
    

<header style="width:100%;height: 40px;background: #7DB0E8;max-width: 640px;margin:0 auto;position: fixed;top: 0;left:0;right:0;text-align: center;line-height: 40px">
<div class="wl-header">
    <div class="wl-header-left">

    </div>
<div class="wl-header-right">
    <a href="/weixin/user/main"><i class="iconfont icon-my" style="font-size: 25px ;color: white"></i></a>
</div>
</div>
</header>
<div class="wl-body">
    <header>
        <div class="wl-liebiao">
            <ul>
                <a href="/weixin/index/index"><li>推荐</li></a>
                <a href=/weixin/shop/haveGood""><li>有好货</li></a>
                <a href="/weixin/index/diaryUser"> <li class="actice" >日记</li></a>
            </ul>
        </div>
    </header>
    <!--这里编写主体内容-->
    <div class="wl-diary-center  mescroll" id="container">
        <div id="container-list">

        </div>
        <div style="clear: both"></div>
    </div>

</div>

<footer class="wl-footer">
    <a href="/weixin/index/index">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/index/index'))): ?>
                <dl class="iconfont icon-home_fill_light xian" style="font-size: 25px;"></dl>
                <dd class="xian">首页</dd>
            <?php else: ?>
                <dl class="iconfont icon-home_light" style="font-size: 25px;"></dl>
                <dd >首页</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/index/doctor">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/index/doctor'))): ?>
            <dl class="iconfont icon-yishengsshixin xian" style="font-size: 25px;"></dl>
            <dd class="xian">医生</dd>
            <?php else: ?>
            <dl class="iconfont icon-yishengkkongxin" style="font-size: 25px;"></dl>
            <dd >医生</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/shop/index">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/shop/index'))): ?>
            <dl class="iconfont icon-shopfill xian" style="font-size: 25px;"></dl>
            <dd class="xian">商城</dd>
            <?php else: ?>
            <dl class="iconfont icon-shoplight" style="font-size: 25px;"></dl>
            <dd >商城</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/index/hospital">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/index/hospital'))): ?>
            <dl class="iconfont icon-yiyuan3 xian" style="font-size: 25px;"></dl>
            <dd class="xian">医院</dd>
            <?php else: ?>
            <dl class="iconfont icon-chakanyiyuan" style="font-size: 25px;"></dl>
            <dd >医院</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/user/main">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/user/main'))): ?>
            <dl class="iconfont icon-my_fill_light xian" style="font-size: 25px;"></dl>
            <dd class="xian">我的</dd>
            <?php else: ?>
            <dl class="iconfont icon-my_light" style="font-size: 25px;"></dl>
            <dd >我的</dd>
            <?php endif; ?>
        </div>
    </a>
</footer>

    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>
<script src="/static/plugin/mescroll/mescroll.min.js" charset="utf-8"></script>
<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-diary-top">

        <dl>
            {{#if(item.after_imgs.length > 0){ }}
                <img src="{{item.after_imgs[0]}}" alt=""  class="wl-diary-img">
            {{# } }}

            {{#if(item.after_imgs.length == 0){ }}
                <img src="{{item.before_imgs[0]}}" alt=""  class="wl-diary-img">
            {{# } }}
        </dl>
        <dt>{{item.title}}</dt>
        <dd>
            <img src="{{item.portrait}}" alt=""  onerror='this.src="/static/image/user/tou.png"'>
            <span><span class="wl-diary-name">{{item.nickname}}</span> <span class="wl-diary-like"><i class="iconfont icon-like"></i>66</span></span>
        </dd>
        <div style="clear: both"></div>
    </div>

    {{#  }); }}
</script>
<script>
    var listObj = {
        searchList: function (page, successCallback, errorCallback) {
            $.ajax({
                url: '/weixin/api/getDiaryList',
                type: 'post',
                data: {page: page.num, page_size: page.size},
                dataType: 'json',
                success: function (res) {
                    successCallback(res.data.rows);
                }
            });
        },
    };
    var mescroll = new MeScroll("container", {
        down:{auto:true},
        up: {
            clearEmptyId: "container-list",
            page: {num: 0,size: 20},
            htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
            isBounce: false,
            noMoreSize: 16,
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
</script>

</body>
</html>