<?php /*a:3:{s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\doctor.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\footer.html";i:1549940378;}*/ ?>
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
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" href="/static/weixin/css/function.css">
    
    <link rel="stylesheet" href="/static/weixin/css/doctor.css">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_890503_haekiko2b0f.css">
    <link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">
<style>
    body{
        background: #f8f8f8;
    }
</style>

</head>

<body id="main-body">
    

<!--这里编写主体内容-->
<div id="container"  class="mescroll">
    <div id="container-list" ></div>
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


    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>
<script src="/static/plugin/mescroll/mescroll.min.js" charset="utf-8"></script>
<script id="demo" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
            <div class="wl-conter href cus-to-doctor-details" data-uid="{{item.user_id}}">
                <div class="wl-toux"><img src="{{item.portrait}}" onerror="this.src ='/static/image/user/tou.png'" width="41" height="41"></div>
                <div style="position: relative"><span class="wl-biao"></span></div>
                <div class="wl-pingjia">
                    <dl>{{item.real_name}} <span class="wl-the-title">{{ item.duties}}</span></dl>
                    <dd>
                        擅长项目:
                        {{#  layui.each(item.speciality, function(index2, item2){ }}
                            <span>{{ item2 }}&nbsp;&nbsp;</span>
                        {{#  }); }}
                    </dd>
                    <dt><i class="iconfont icon-xingji"></i>
                        <i class="iconfont icon-xingji"></i>
                        <i class="iconfont icon-xingji"></i>
                        <i class="iconfont icon-xingji"></i>
                        <i class="iconfont icon-xingji"></i>
                        <span style="margin-left: 8px">评价 </span><span style="padding: 0 3px 0 0px">|</span>
                        <span>{{item.case_num}}案例</span><span style="padding: 0 3px 0 3px;">|</span>
                        <span style="margin-top: 1px">{{item.article_num}}文章</span>
                    </dt>
                    <span class="iconfont icon-back_left-copy wl-renzheng" style="font-size: 25px;color: #AAAAAA"></span>
                </div>
                <div style="clear: both"></div>
            </div>
    {{#  }); }}
</script>

<script type="text/javascript">
    $(document).on('click','.cus-to-doctor-details',function(){
        window.location.href = '/weixin/index/doctorDetails/uid/'+$(this).data('uid');
    });
    var mescroll = new MeScroll("container", {
        down:{auto:true},
        up: {
            clearEmptyId: "container-list",
            page: {num: 0,size: 20},
            htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
            isBounce: false,
            noMoreSize: 10,
            // empty: {
            //     icon: "/static/weixin/shop/image/tuoian.png",
            //     tip: "亲,没有您要找的商品~", //提示
            // },
            callback: function(page){
                listObj.searchList(page,function(curPageData){
                    mescroll.endSuccess(curPageData.length);
                    layui.laytpl(demo.innerHTML).render(curPageData, function(html){
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
                url: "/weixin/api/getDoctorList",
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (res) {
                    successCallback(res.data.rows);
                },
            });
        },
    };
</script>

</body>
</html>