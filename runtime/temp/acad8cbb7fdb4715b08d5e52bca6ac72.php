<?php /*a:2:{s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\shop\my_order.html";i:1547805519;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1548216047;}*/ ?>
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
    
    <link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">
    <link rel="stylesheet" href="/static/weixin/shop/css/my_order.css">
    <link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
<style type="text/css">

</style>

</head>

<body id="main-body">
    


<div class="header">
    <div class="wl-top">
        <a href="/weixin/shop/index"><i class="iconfont icon-back_light top-left" style="font-size: 25px;color: #333333"></i></a>
        <span>我的订单</span>
    </div>
    <!--菜单-->
    <div class="nav">
        <p class="active" i="0">全部</p>
        <p i="1">待支付</p>
        <p i="2">待消费</p>
        <p i="3">已完成</p>
    </div>
</div>


<div id="mescroll0" class="mescroll">
    <ul id="dataList0" class="data-list">
    </ul>
</div>
<div id="mescroll1" class="mescroll hide">
    <ul id="dataList1" class="data-list">
    </ul>
</div>

<div id="mescroll2" class="mescroll hide">
    <ul id="dataList2" class="data-list">
    </ul>
</div>
<div id="mescroll3" class="mescroll hide">
    <ul id="dataList3" class="data-list">
    </ul>
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
<script src="/static/weixin/viewjs/my_order.js"></script>
<script id="orderList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}

    {{#  if(item.status == 5){ }}
    <div class="wl-dingdan">
        <div class="wl-zonghe1">
            <span class="wl-xiannv">订单号：{{item.order_no}}</span>
            <span class="wl-jiage1" style="color: #F24F4F">待支付</span>
        </div>
        <div class="wl-remen">
            <div class="wl-remen-img">
                <img src="{{item.img}}"/>
            </div>
            <div class="wl-remen-right">
                <dl>{{item.goods_name}}</dl>
                <dt>{{item.hospital_name}}</dt>
                <dd>
                    <span class="wl-quchu">￥{{item.goods_price}}</span>
                    <span class="wl-jiage1"><span style="margin-right: 10px">数量：{{item.goods_nums}}</span><span>支付定金：￥{{item.real_amount}}</span></span>
                </dd>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    {{#  } }}

    {{#  if(item.status == 1){ }}
    <div class="wl-dingdan href click-to-orderpaydetail" data-oid="{{ item.id }}">
        <div class="wl-zonghe1">
            <span class="wl-xiannv">订单号：{{item.order_no}}</span>
            <span class="wl-jiage1" style="color: #F24F4F">待支付</span>
        </div>
        <div class="wl-remen">
            <div class="wl-remen-img">
                <img src="{{item.img}}" alt="">
            </div>
            <div class="wl-remen-right">
                <dl>{{item.goods_name}}</dl>
                <dt>{{item.hospital_name}}</dt>
                <dd>
                    <span class="wl-quchu">￥{{item.goods_price}}</span>
                    <span class="wl-jiage1"><span style="margin-right: 10px">数量：{{item.goods_nums}}</span><span>支付定金：￥{{item.real_amount}}</span></span>
                </dd>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="wl-xiangqing">
            <div class="wl-zhifu href click-to-paydetail" data-oid="{{ item.id }}">去支付</div>
            <div class="wl-chakan href click-to-orderpaydetail" data-oid="{{ item.id }}">查看详情</div>
        </div>
    </div>
    {{#  } }}

    {{#  if(item.status == 3){ }}
    <div class="wl-dingdan to-myorder href"  data-oid="{{ item.id }}">
        <div class="wl-zonghe1">
            <span class="wl-xiannv">订单号：{{ item.order_no }}</span>
            <span class="wl-jiage1" style="color: #F24F4F">已支付</span>
        </div>
        <div class="wl-remen">
            <div class="wl-remen-img">
                <img src="{{ item.img }}">
            </div>
            <div class="wl-remen-right">
                <dl>{{item.goods_name}}</dl>
                <dt>{{item.hospital_name}}</dt>
                <dd>
                    <span class="wl-quchu">￥{{ item.goods_price }}</span>
                    <span class="wl-jiage1"><span style="margin-right: 10px">数量：{{item.goods_nums}}</span><span>支付定金：￥{{item.real_amount}}</span></span>
                </dd>
            </div>

        </div>
        <!--<span class="wl-zhifu1">确认完成</span>-->
        <div style="clear: both"></div>
    </div>
    {{#  } }}

    {{#  if(item.status == 5){ }}
    <div class="wl-dingdan to-myorder href"  data-oid="{{ item.id }}">
        <div class="wl-zonghe1">
            <span class="wl-xiannv">订单号：{{ item.order_no }}</span>
            <span class="wl-jiage1" style="color: #F24F4F">已完成</span>
        </div>
        <div class="wl-remen">
            <div class="wl-remen-img">
                <img src="{{ item.img }}">
            </div>
            <div class="wl-remen-right">
                <dl>{{item.goods_name}}</dl>
                <dt>数量：{{ item.goods_nums }}</dt>
                <dd>
                    <span class="wl-quchu">￥{{ item.goods_price }}</span>
                    <span class="wl-jiage1"><span style="margin-right: 10px">数量：{{item.goods_nums}}</span><span>支付定金：￥{{item.real_amount}}</span></span>
                </dd>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    {{#  } }}

    {{#  }); }}
</script>


</body>
</html>