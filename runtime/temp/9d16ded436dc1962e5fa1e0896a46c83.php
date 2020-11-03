<?php /*a:5:{s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\shop\good_editor.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1549940378;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1549940378;}*/ ?>
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

<body >
    
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
                          <li>  <a href="/index/user/certification">实名认证</a></li>
                            <?php if(($u && in_array($u['type'],[3,4]))): ?>
                               <li><a id="click-to-merchant">商户管理</a></li>
                            <?php endif; ?>
                           <li> <a href="/index/user/modifyUserInfo">账号设置</a></li>
                            <li><a href="/index/user/signOut">退出登录</a></li>
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
        <div class="wl-fabu1">
            <div class="wl-top-title">
                <div class="wl-top-img">
                    <img src="<?php echo htmlentities($goods_info['img']); ?>" alt="">
                </div>
                <div class="wl-top-right">
                    <dt class="wl-shang-title"><?php echo htmlentities($goods_info['name']); ?></dt>
                    <dt class="wl-yiyuan" style="margin-top: 10px"><?php echo htmlentities($goods_info['hospital_name']); ?></dt>
                    <dd class="wl-jiage"><sup style="font-size: 10px">￥</sup><?php echo htmlentities($goods_info['sell_price']); ?></dd>
                </div>
            </div>
            <div>
                <input type="hidden" id="fr-goods_id" value="<?php echo htmlentities($goods_info['id']); ?>">
                <div class="web-fabiao">
                    <ul>
                        <li>标题</li>
                        <li><input type="text" value=""id="fr-title" placeholder="请输入商品标题"></li>
                    </ul>
                </div>
                <!--<div class="web-fabiao">-->
                    <!--<ul>-->
                        <!--<li>摘要</li>-->
                        <!--<li><input type="text" value="" id="fr-zaiyao" placeholder="请输入商品摘要"></li>-->
                    <!--</ul>-->
                <!--</div>-->

                <div style="clear: both;padding-left: 10px;padding-bottom: 80px">
                    <div style="float: left;width: 90%;margin-top: 35px; margin-left: 44px;height: 500px">
                        <!--<textarea id="editor_id" name="content" style="width:99% !important;height:300px;background: white;"></textarea>-->
                        <div id="wang-editor"></div>
                    </div>
                </div>
                <div style="clear: both;"></div>
                <div class="web-btn">
                    <div class="web-btn-right">
                        <button onclick="objClass.submit()" class="wl-tijiao" style="cursor: pointer">发表</button>
                    </div>
                </div>
            </div>
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
<script src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript" src="/static/plugin/wangEditor/release/wangEditor.min.js"></script>
<script type="text/javascript">
    var E = window.wangEditor;
    var editor = new E('#wang-editor');
    editor.customConfig.uploadImgServer = '/index/upload/uploadFile';
    editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024;
    editor.customConfig.uploadImgMaxLength = 3;
    editor.customConfig.showLinkImg = false;
    editor.customConfig.menus = [
        'head',  // 标题
        'bold',  // 粗体
        'fontSize',  // 字号
        'fontName',  // 字体
        'italic',  // 斜体
        'underline',  // 下划线
        'strikeThrough',  // 删除线
        'foreColor',  // 文字颜色
        'backColor',  // 背景颜色
        'link',  // 插入链接
        'list',  // 列表
        'justify',  // 对齐方式
        'quote',  // 引用
        'image',  // 插入图片
        'table',  // 表格
        'undo',  // 撤销
        'redo'  // 重复
    ];
    editor.create();

    $(".wl-xian").click(function () {
        $(".wl-cang").toggle();
    });
    $('.wl-tabc').click(function () {
        $('.wl-cang').hide();
    });


    $(".wl-yingj").click(function () {
        $(".wl-ding").toggle();
        $(".qiehuan").toggleClass('iconfont  icon-triangledownfill');
        $(".qiehuan").toggleClass('iconfont icon-triangleupfill');
    });


    var objClass ={
        loading:false,
        submit:function(){
            var data = {
                gid:$('#fr-goods_id').val(),
                title:$.trim($('#fr-title').val()),
                content:$.trim(editor.txt.html())
            };

            if(data.title == ''){
                redream.msg('标题不能为空');
            }else if(data.content == ''){
                redream.msg('正文不能为空');
            }else if(objClass.loading == false){
                var index = layer.msg('提交中，请耐心等待...', {icon: 16 ,shade: 0.01,time:0});
                $.ajax({
                    url: "/index/shop/createGoodGoods",
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        objClass.loading = true;
                    },
                    complete: function () {
                        objClass.loading = false;
                        layer.close(index);
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            layer.msg('创建成功...',{icon:1});
                            window.location.href='/index/shop/myshoplist';
                        }else{
                            layer.msg(res.msg,{icon:5});
                        }
                    }
                });
            }
        }
    };
    $('.w-e-toolbar').css('background-color','white');
</script>

</body>
</html>