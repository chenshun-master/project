<?php /*a:4:{s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\index2.html";i:1547113840;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1546521460;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\header.html";i:1545451098;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\footer.html";i:1544520347;}*/ ?>
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
    
<link rel="stylesheet" href="/static/weixin/css/index2.css">
<link rel="stylesheet" type="text/css" href="/static/weixin/css/dropload.css"/>

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
    <div class="wl-body" style="padding:37px 0  100px 0;background: white">
        <div class="wl-liebiao">
            <ul>
                <li class="actice" onclick="redream.href('/weixin/index/index')">推荐</li>
                <li onclick="redream.href('/weixin/shop/haveGood')">有好货</li>
                <li onclick="redream.href('/weixin/index/diaryUser')" >日记</li>
            </ul>
        </div>

        <div id="container" >
            <div id="container-list" ></div>
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
<script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
<script id="demo" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
        {{#  if(getImgNum(item) == 1){ }}
            <div  class="wl-neirong  to-datail-href"  data-id="{{  item.id }}"  data-type="{{  item.type }}">
                <div class="wl-nei1">{{  item.title }}</div>
                <div class="wl-nei2">
                    <ul>
                        {{#  if(item.is_top == 1){ }}
                            <li class="wl-zhiding">置顶</li>
                        {{#  } }}
                        <li  data-uid="{{item.user_id}}">{{ item.nickname }}</li>
                        <li><span class="iconfont icon-attention wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.hits }}</span></li>
                        <li><span class="iconfont icon-comment_light wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.comment_count }}</span></li>
                    </ul>
                </div>
            </div>
        {{#  } }}

        {{#  if(getImgNum(item) == 2){ }}
            <div  class="wl-neirong  to-datail-href"  data-id="{{  item.id }}"  data-type="{{  item.type }}" >
                <div class="wl-nei1">
                    {{  item.title }}
                </div>
                <div class="wl-nei6">
                    {{ showImg(item.thumbnail,getImgNum(item))}}
                </div>
                <div class="wl-nei2">
                    <ul>
                        {{#  if(item.is_top == 1){ }}
                        <li class="wl-zhiding">置顶</li>
                        {{#  } }}
                        <li  data-uid="{{item.user_id}}">{{ item.nickname }}</li>
                        <li><span class="iconfont icon-attention wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.hits }}</span></li>
                        <li><span class="iconfont icon-comment_light wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.comment_count }}</span></li>
                    </ul>
                </div>
            </div>
        {{#  } }}

        {{#  if(getImgNum(item) == 3){ }}
            <div  class="wl-neirong  to-datail-href"  data-id="{{  item.id }}"  data-type="{{  item.type }}">
                <div class="wl-nei5">
                    {{  item.title }}
                </div>
                <div class="wl-left-img">
                    {{ showImg(item.thumbnail,getImgNum(item))}}
                </div>
                <div class="wl-nei2">
                    <ul>
                        {{#  if(item.is_top == 1){ }}
                        <li class="wl-zhiding">置顶</li>
                        {{#  } }}
                        <li  data-uid="{{item.user_id}}">{{ item.nickname }}</li>
                        <li><span class="iconfont icon-attention wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.hits }}</span></li>
                        <li><span class="iconfont icon-comment_light wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.comment_count }}</span></li>
                    </ul>
                </div>
            </div>
        {{#  } }}

        {{#  if(getImgNum(item) == 4){ }}
            <div  class="wl-neirong  to-datail-href"  data-id="{{  item.id }}"  data-type="{{  item.type }}" >
                <div class="wl-nei1">
                    {{  item.title }}
                </div>
                <div class="wl-nei3">
                    {{ showImg(item.thumbnail,getImgNum(item))}}
                </div>
                <div class="wl-nei2">
                    <ul>
                        {{#  if(item.is_top == 1){ }}
                        <li class="wl-zhiding">置顶</li>
                        {{#  } }}
                        <li  data-uid="{{item.user_id}}">{{ item.nickname }}</li>
                        <li><span class="iconfont icon-attention wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.hits }}</span></li>
                        <li><span class="iconfont icon-comment_light wl-jri" style="font-size: 17px;color: #b1b1b1"></span><span class="wl-jleft">{{ item.comment_count }}</span></li>
                    </ul>
                </div>
            </div>
        {{#  } }}
    {{#  }); }}
</script>
<script src="/static/weixin/viewjs/index/index.js"></script>

</body>
</html>