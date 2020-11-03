<?php /*a:5:{s:89:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\article\published_article.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1549940378;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1549940378;}*/ ?>
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
    
<link rel="stylesheet" href="/static/web/css1/published_article.css">

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
            <div class="web-content-right-title"><span class="web-top-title">发表文章</span></div>
            <input type="hidden" id="fr-id" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['id']) : 0; ?>">
            <input type="hidden" id="fr-draft" value="<?php echo $articleInfo && $articleInfo['status']==2 ? 1 : 0; ?>">
            <div class="web-fabiao">
                <ul>
                    <li>标题</li>
                    <li>
                        <input type="text" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['title']) : ''; ?>" id="fr-title" placeholder="请输入文章标题" maxlength="50">
                        <span style="color: #FF917B;"><span id="title-lenght">0</span>/50</span>
                    </li>
                </ul>
            </div>
            <div class="web-fabiao">
                <ul>
                    <li>摘要</li>
                    <li><input type="text" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['excerpt']) : ''; ?>" id="fr-zaiyao"
                               placeholder="请输入文章摘要"></li>
                </ul>
            </div>
            <div class="web-fabiao">
                <ul>
                    <li>标签</li>
                    <li><input type="text" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['tag']) : ''; ?>" id="fr-tag"
                               placeholder="文章标签 例如(xxx,xxx,xxx) 请用英文逗号',' 分割,标签有利于文章之间的关联"></li>
                </ul>
            </div>
            <div>
                <div style="width: 95%; margin: 35px auto;height: 500px">
                    <div id="wang-editor" style="">
                        <?php echo $articleInfo?$articleInfo['content']:''; ?>
                    </div>
                </div>
            </div>
            <div class="web-ded">
                  <div class="web-suolue">
                      <div class="web-suoluetu">
                          <form id="infoLogoForm" enctype='multipart/form-data'>
                              <input type="file" name="imgFile" accept="image/*" id="btn-input-file"/>
                          </form>
                          <dl><i class="iconfont icon-xiangji web-xiangji"></i></dl>
                          <dt>添加缩略图</dt>
                      </div>
                  </div>
                <div class="web-tianjiai">
                    <?php if(($articleInfo && count($articleInfo['thumbnail']) > 0)): foreach($articleInfo['thumbnail'] as $src): ?>
                        <div class="cus-remove-img-list">
                            <img src="<?php echo htmlentities($src); ?>" class="cus-fr-images" width="125" height="125">
                            <span class="iconfont icon-roundclosefill cus-remove-img"></span>
                        </div>
                        <?php endforeach; endif; ?>
                 </div>
        </div>
            <div class="web-shangchaun"><span style="color: red">注:</span>缩略图最多只能上传三张</div>
            <div class="web-btn">
                <div class="web-btn-right">
                    <button  class="wl-fabiao1 web-yulan"><i class="iconfont icon-shouji01" style="font-size: 13px"></i>预览文章</button>
                    <button  onclick="objClass.submit(1)" class="wl-fabiao1">发表文章</button>
                    <?php if((!$articleInfo || ($articleInfo && $articleInfo['status'] == 2))): ?>

                    <button onclick="objClass.submit(2)" class="wl-fabiao1">保存草稿</button>

                    <?php endif; ?>

                </div>
            </div>
    </div>
        <div class="wl-zh1" id="wl-loading-box" style="display: none">
            <div class="wl-z1">
                <dl>
                    <img src="/static/image/user/timg.gif" alt="" width="60px" style="margin: 0 auto;position: absolute;left: -10px;right: 0;">
                </dl>
                <dt  class="wl-shangzhong">上传中...</dt>
            </div>
        </div>
    </div>
    <div class="wl-zhez2">
        <div class="web-cancel">
            <i class="iconfont icon-close" style="font-size: 50px;color: white  "></i>
        </div>
        <div class="wl-zl2">
            <div class="web-conter-gundong">
                <div>
                    <div class="web-preview-title href"></div>
                </div>
                <div class="web-preview-main href">
                    <div>
                        <div class="web-preview-img href">
                            <img src="/static/image/user/tou.png" alt=""onerror="this.src=/static/image/user/tou.png;" class="cus-touser-main"></div>
                        <div class="web-preview-user href">
                            <dl>上海xxxxxx</dl>
                            <dt>昨天 15:14分</dt>
                        </div>
                    </div>
                    <div class="web-preview-friends href">
                        <button onclick="objClass.showAddFriend()" id="cus-add-friend">加好友</button>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="web-preview-content" >

                </div>

                <div class="web-preview-end">-&nbsp;THE END&nbsp;-</div>
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
<script type="text/javascript" src="/static/plugin/wangEditor/release/wangEditor.min.js"></script>
<script type="text/javascript" src="/static/web/viewjs/article_release.js"></script>

</body>
</html>