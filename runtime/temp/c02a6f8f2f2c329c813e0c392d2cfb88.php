<?php /*a:2:{s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\balance_of.html";i:1546521460;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1548216047;}*/ ?>
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
    <link rel="stylesheet" href="/static/weixin/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" href="/static/weixin/css/function.css">
    
<link rel="stylesheet" href="/static/weixin/css/balance_of.css">
<link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
<style>

</style>

</head>

<body id="main-body">
    
<!--这里编写主体内容-->
<div style="width: 100%;min-height: 500px;padding-bottom: 50px">
    <div class="wl-top-dingwei">
        <div class="wl-top">
            <a href="/weixin/user/main"><i class="iconfont icon-back_light top-left" style="font-size: 25px;color: #333333"></i></a>
            <span>账户余额</span>
        </div>
        <div class="wl-top-jifen">
            <dl><i class="iconfont icon-yue"></i>可用余额</dl>
            <dt><?php echo htmlentities($uinfo['account']); ?></dt>
        </div>
        <!--<div class="wl-integral">-->
            <!--<span></span>-->
        <!--</div>-->
        <div class="wl-benyue">
            <div class="wl-month"><span>|</span>账单记录</div>
        </div>
    </div>
    <div class="wl-integral-list mescroll " id="container">
        <div id="container-list">

        </div>

    </div>
</div>



    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>
<script src="/static/plugin/mescroll/mescroll.min.js" type="text/javascript" charset="utf-8"></script>
<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-balance-list">
        <div class="wl-bizhonhe">
            <dl>{{item.remarks}}</dl>
            <dd>{{item.created_time}}</dd>
        </div>
        <div class="wl-qianshu">{{item.amount}}</div>
    </div>
    {{#  }); }}
</script>
<script>
    var listObj = {
        params: {},
        searchList: function (page, successCallback, errorCallback) {
            var data = $.extend({}, {page: page.num, page_size: page.size}, listObj.params);
            $.ajax({
                url: "/weixin/api/getAccountRecord ",
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
    var mescroll = new MeScroll("container", {
        down:{auto:true},
        up: {
            clearEmptyId: "container-list",
            page: {num: 0,size: 20},
            htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
            isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
            noMoreSize: 2, //如果列表已无数据,可设置列表的总数量要大于半页才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看
            empty: {
                icon: "/static/weixin/image/mescroll/yue.png", //图标,默认null
                tip: "您暂时没有余额记录", //提示
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
            },
        }
    });
</script>

</body>
</html>