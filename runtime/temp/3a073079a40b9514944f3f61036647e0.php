<?php /*a:3:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\shop\index.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\footer.html";i:1549940378;}*/ ?>
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
    
<link rel="stylesheet" href="/static/weixin/shop/css/index.css">
<link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">

</head>

<body id="main-body">
    
<header style="z-index: 99999 !important;">
    <div class="wl-head">
        <div class="wl-top">
            <a href="/weixin/shop/searchGoods">
                <input type="text" placeholder="搜索您感兴趣的项目"><i class="iconfont icon-sousuo"></i></a>
        </div>
        <div class="wl-daohang">
            <ul>
                <li id="wl-quanbu">
                    全部项目 <i class="iconfont icon-shangsanjiaoxiangshangmianxing-copy qiehuan"
                            style="font-size: 10px;color: #888888;margin-left: 2px"></i>
                </li>
                <li>
                    全部城市<i class="iconfont icon-shangsanjiaoxiangshangmianxing-copy"
                         style="font-size: 10px;color: #888888;margin-left: 4px"></i>
                </li>
                <li style="border: none;" id="wl-zhineng">
                    智能排序<i class="iconfont icon-shangsanjiaoxiangshangmianxing-copy qiehuan2"
                           style="font-size: 10px;color: #888888;margin-left: 5px"></i>
                </li>
            </ul>
        </div>
    </div>
</header>

<main style="background:white;">
    <div id="container" class="mescroll">
        <div id="container-list">

        </div>
    </div>
</main>

<div class="marsk-container">
    <div class="tkyy_con">
        <div class="tabbox">
            <ul class="wl-deji">
                <li data-path="" class="click-select-category href">全部项目</li>
                <?php foreach($categoryNav as $key=>$vo): ?>
                <li data-path="<?php echo htmlentities($vo['id']); ?>" class="click-select-category href"><?php echo htmlentities($vo['name']); ?></li>
                <?php endforeach; ?>
            </ul>

            <div class="content">
                <div class="wl-d"></div>
                <?php foreach($categoryNav as $k=>$v): ?>
                <div class="wl-d">
                    <div>
                        <span data-path="<?php echo htmlentities($v['path']); ?>" class="click-select-category href">查看全部 <i
                                class="iconfont icon-back_left-copy" style="font-size: 13px"></i></span>
                    </div>
                    <?php foreach($v['subclass'] as $k2=>$v2): ?>
                    <!--<div>-->
                    <!--<span class="click-select-category href" data-path="<?php echo htmlentities($v2['path']); ?>">-->
                    <!--<?php echo htmlentities($v2['name']); ?>-->
                    <!--<i class="iconfont icon-back_left-copy" style="font-size: 13px"></i>-->
                    <!--</span>-->
                    <!--<dl style="clear: both"></dl>-->
                    <!--<div class="wl-das">-->
                    <!--<?php foreach($v2['subclass'] as $k3=>$v3): ?>-->
                    <!--<div class="wl-maixian click-select-category href" data-path="<?php echo htmlentities($v3['path']); ?>"><?php echo htmlentities($v3['name']); ?>-->
                    <!--</div>-->
                    <!--<?php endforeach; ?>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--<dl style="clear: both"></dl>-->
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<div class="marsk-container1">
    <div class="tkyy_con1 click-select-sort">
        <p class="wl-xiao" data-sort="0">默认排序</p>
        <p class="wl-xiao" data-sort="1">销量最高</p>
        <p class="wl-xiao" data-sort="2">日记最多</p>
        <p class="wl-xiao" data-sort="3">最新上架</p>
        <p class="wl-xiao" style="border: none;" data-sort="4">价格从高到低</p>
    </div>
</div>
<div class="marsk-container2" style="display: none">

    <div class="tkyy_con2">
        <div style="text-align: center;margin-top: 10px">
            <i class="layui-icon layui-icon-loading-1 layui-icon layui-anim layui-anim-rotate layui-anim-loop"
               style="color: white;font-size: 28px;"></i>
        </div>
        <div class="wl-jiazai">加载中...</div>
    </div>
</div>
<div class="wl-dingwei">
    <!--<span class="iconfont icon-shuaxin wl-shuaxin"></span>-->
    <span class="wl-haohuo" onclick="redream.href('/weixin/shop/haveGood')">有好货</span>
    <div class="wl-good">
        <ul>
            <li class="iconfont icon-shangpin4 goods" onclick="redream.href('/weixin/shop/haveGood')"></li>
            <li class="iconfont icon-shuaxin wl-shuaxin icon-shangpin4 "></li>
            <li class="iconfont icon-xiangshang1 href tiaozhaun" id="wl-tingbu"></li>
        </ul>
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
<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-shangping href to-goods-detail" data-goodsid="{{ item.id }}">
        <div class="wl-sp-img">
            <img src="{{item.img}}"/>
        </div>
        <div class="wl-xiang href">
            <div class="wl-title">{{item.name}}</div>
            <div class="wl-yiyuan"><span class="wl-name1">{{item.doctor_name}}</span><span class="wl-meirong">{{item.hospital_name}}</span>
            </div>
            <div class="wl-yiyuan">{{item.sale_num}}人预订</div>
            <div class="wl-jiage">
                <span class="wl-jiage"><sub style="font-size: 8px">￥</sub><span>{{item.sell_price}}</span></span>
                <span class="wl-quchu">￥{{item.market_price}}</span>
            </div>
        </div>
        <dl style="clear: both"></dl>
    </div>
    {{#  }); }}
</script>
<script src="/static/weixin/viewjs/shop_index.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>