<?php /*a:5:{s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\shop\myshoplist1.html";i:1547082711;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1547082711;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1547082711;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1547082711;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1545379082;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="applicable-device" content="pc,mobile">
    <title><?php echo config('conf.title'); ?></title>
    <link rel="stylesheet" type="text/css" href="/static/web/css/main.css"/>
    <link rel="stylesheet" href="/static/css/iconfont.css">
    
<!--<link rel="stylesheet" href="/static/web/css1/published_article.css">-->
<link rel="stylesheet" href="/static/web/css1/my_article.css">
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">

</head>

<body>
    
        <header>
    <div class="layui-row">
        <div class="layui-col-xs12 layui-col-md12">
            <div class="web-header">
                <div class="web-header-content">
                    <div class="web-header-logo">
                         欢迎 <?php echo htmlentities($u['nickname']); ?> 来到薇琳医美！
                    </div>
                    <div class="web-head-portrait">
                        <ul class="web-article">
                            <a href="/index/user/certification"><li>实名认证</li></a>
                            <?php if(($u && in_array($u['type'],[3,4]))): ?>
                                <a   id="click-to-merchant"><li>商户管理</li></a>
                            <?php endif; ?>
                            <a href="/index/user/modifyUserInfo"><li>账号设置</li></a>
                            <a href="/index/user/signOut"><li>退出登录</li></a>
                        </ul>

                        <!--<ul class="web-reg">-->
                            <!--<li class="web-top-login">登录</li>-->
                            <!--<li class="web-top-login">注册</li>-->
                        <!--</ul>-->
                        <div style="clear: both"></div>
                    </div>
            </div>
        </div>
            <div style="width: 100%;min-height: 80px;background-color: #7DB0E8;">
                <div class="web-logo">
                    <div class="wl-logo-one">
                        <img src="/static/web/image/logo1.png" alt="">
                    </div>
                    <!--<div class="web-top-input">-->
                        <!--<a href="/index/shop/myshoplist"> <input type="text" placeholder="搜索的商品"></a>-->
                    <!--</div>-->
                    <div class="web-top-rigth">
                        <img src="/static/web/image/bj_logo.png" alt="" width="50" height="50">
                        <div class="web-zhengxing">
                            <dl>中国整形美容协会</dl>
                            <dt>互联网分会理事单位</dt>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
    

    

<div class="web-content">
    <div class="web-content-left">
        <content>
    <div class="web-navigation-title web-bold">个人中心</div>
    <ul class="web-navigation">
        <li class="web-wenzhangliebiao web-bold"> <span></span>文章列表 <span></span></li>
    <ul class="web-daohang">
        <?php if((checkFooter('/index/article/article'))): ?>
        <a href="/index/article/article"> <li class="web-tinjain"><i class="iconfont icon-fabiaowenzhang1" style="color: white"></i>发表文章</li></a>
        <?php else: ?>
        <a href="/index/article/article"> <li><i class="iconfont icon-fabiaowenzhang1" style="color: #FC9E9E"></i>发表文章</li></a>
        <?php endif; if((checkFooter('/index/article/graphic'))): ?>
        <a href="/index/article/graphic"><li class="web-tinjain"><i class="iconfont icon-wodewenzhang" style="color: white"></i>我的文章</li></a>
       <?php else: ?>
        <a href="/index/article/graphic"><li><i class="iconfont icon-wodewenzhang" style="color:#FE9F88"></i>我的文章</li></a>
        <?php endif; ?>

    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>分销商品 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/shop/index'))): ?>
            <a href="/index/shop/index"><li class="web-tinjain"><i class="iconfont icon-shangpinliebiao2" style="color: white"></i>商品列表</li></a>
            <?php else: ?>
            <a href="/index/shop/index"><li><i class="iconfont icon-shangpinliebiao2" style="color: #FFAC9C"></i>商品列表</li></a>
            <?php endif; if((checkFooter('/index/shop/myshoplist'))): ?>
            <a href="/index/shop/myshoplist"><li class="web-tinjain"><i class="iconfont icon-fenxiaoliebiao1" style="color: white"></i>分销列表</li></a>
            <?php else: ?>
            <a href="/index/shop/myshoplist"><li><i class="iconfont icon-fenxiaoliebiao1" style="color:#FF988A"></i>分销列表</li></a>
            <?php endif; ?>

    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>我的认证 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/user/certification'))): ?>
            <a href="/index/user/certification"><li  class="web-tinjain"><i class="iconfont icon-shimingrenzheng2" style="color: white"></i>实名认证</li></a>
            <?php else: ?>
            <a href="/index/user/certification"><li><i class="iconfont icon-shimingrenzheng2" style="color: #FFAC9C"></i>实名认证</li></a>
            <?php endif; ?>
    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>账号设置 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/user/main'))): ?>
            <a href="/index/user/main"><li  class="web-tinjain"><i class="iconfont icon-yonghuxinxi" style="color: white"></i>用户信息</li></a>
            <?php else: ?>
            <a href="/index/user/main"><li><i class="iconfont icon-yonghuxinxi" style="color: #FF917B"></i>用户信息</li></a>
            <?php endif; if((checkFooter('/index/user/modifyUserInfo'))): ?>
            <a href="/index/user/modifyUserInfo"><li  class="web-tinjain"><i class="iconfont icon-xiugaiziliao" style="color: white"></i>修改资料</li></a>
            <?php else: ?>
            <a href="/index/user/modifyUserInfo"><li><i class="iconfont icon-xiugaiziliao" style="color: #FE9F88"></i>修改资料</li></a>
            <?php endif; if((checkFooter('/index/user/security'))): ?>
            <a href="/index/user/security"><li  class="web-tinjain"><i class="iconfont icon-anquanzhongxin" style="color: white"></i>安全中心</li></a>
            <?php else: ?>
            <a href="/index/user/security"><li><i class="iconfont icon-anquanzhongxin" style="color: #FF917B"></i>安全中心</li></a>
            <?php endif; ?>

        </ul>
    </ul>

    </ul>
</content>

    </div>
    <div class="web-content-right">
        <div class="web-content-right-title"><span class="web-top-title">我的分销</span></div>
        <div class="wl-xianshi-neirong">
            <!--<div class="wl-all-title">已显示全部40条内容</div>-->
            <?php if((count($list['rows']) > 0)): foreach($list['rows'] as $val): ?>
            <div class="wl-all-neirong">
                <div class="wl-all-left">
                    <img src="<?php echo htmlentities($val['img']); ?>" alt="">
                </div>
                <div class="wl-all-center">
                    <div class="wl-tuijian-title"><?php echo htmlentities($val['title']); ?> </div>
                    <div class="wl-yiyuan-tuijian"><?php echo htmlentities($val['hospital_name']); ?></div>
                    <div class="wl-jiagewa"><sup style="font-size: 10px">￥</sup><?php echo htmlentities($val['sell_price']); ?></div>
                    <div><span class="wl-tuijian-fabu">已发表</span><span class="wl-tuijian-time"><?php echo htmlentities($val['created_time']); ?></span></div>
                </div>
                <!--<div class="wl-all-right"  id="web-Modify" style="cursor: pointer">-->
                <!--<span class="iconfont icon-xiugai"></span>-->
                <!--<span style="margin-left: 2px">修改</span>-->
                <!--</div>-->
            </div>
            <?php endforeach; else: ?>
            <div class="wl-weifabiao">
                <dl class="iconfont icon-wushuju"></dl>
                <dt>你还没有分销过商品</dt>
            </div>
            <?php endif; ?>
            <div id="wl-fenye" ></div>
        </div>
    </div>

</div>


    
    <footer>
    <div class="web-footer">
        <div class="web-footer-content">
        <dl>
            <span><?php echo config('conf.copyright'); ?></span>
            <span>Wei Lin Medical beauty</span>
            <a href="#"><img src="https://statics.wmnrj.com/images/beian.png" alt="">公安网备 34040302000221号</a>
        </dl>
            <dt><span>客服电话:021-62829999</span><span>医院地址:上海市静安区江宁路818号（江宁路海防路路口）</span></dt>
        </div>
    </div>
</footer>
    

    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $('#click-to-merchant').on('click',function(){
            $.ajax({
                url: "/index/user/getAuthCode",
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if(res.code == 200){
                        window.open(res.data.url,'_blank');
                    }
                }
            });
        });
    </script>
    
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/plugin/layui/layui.js"></script>
<script>
    layui.use(['laypage', 'layer'], function(){
        var laypage = layui.laypage,layer = layui.layer;
        laypage.render({
            elem: 'wl-fenye'
            ,limit:15
            ,count:<?php echo htmlentities($list['total']); ?>
            ,curr:<?php echo htmlentities($list['page']); ?>
            ,jump: function(obj, first){
                if(!first){
                    window.location.href = '/index/shop/myshoplist/page/'+obj.curr;
                }
            }
        });
    });
</script>

</body>
</html>