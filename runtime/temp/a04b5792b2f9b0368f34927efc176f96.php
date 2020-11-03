<?php /*a:5:{s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\shop\shoplist.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1549940378;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1549940378;}*/ ?>
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
        <div class="web-content-right-title" style="border: 0"><span class="web-top-title">我的商品</span></div>
        <div class="wl-xianshi-neirong">
            <div class="wl-list" id="category-container">
                <div class="wl-project category-hierarchy" data-hierarchy="1" >
                    <div>项目</div>
                    <div class="wl-liebiao">
                        <span class="se myselecte click-find-category">全部</span>
                        <?php foreach($categoryList as $k=>$val): ?>
                        <span  data-pid="<?php echo htmlentities($val['id']); ?>"  data-id="<?php echo htmlentities($val['id']); ?>" class="click-find-category"><?php echo htmlentities($val['name']); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
            <div style="clear: both"></div>

            <div>
                <ul class="wl-sorting">
                    <li class="active click-find-sort" data-sort="0">智能排序</li>
                    <li data-sort="3" class="click-find-sort">最新上架</li>
                    <li data-sort="1" class="click-find-sort">销量最高</li>
                    <li class="wl-price" data-sort="4">
                        价格排序
                        <ul class="wl-sorting-gao" id="web-jiage">
                            <li data-sort="4" class="click-find-sort">价格最高</li>
                            <li data-sort="5" class="click-find-sort">价格最低</li>
                        </ul>
                    </li>
                </ul>

            </div>
            <div style="clear: both"></div>
            <div id="content">

            </div>
            <div style="clear: both"></div>

            <div class="wl-loading" style="">
                <div class="layui-box layui-laypage layui-laypage-default" id="click-reload-more">
                    <a href="javascript:;" class="layui-laypage-next " data-page="2"  >加载更多</a>
                </div>
            </div>
            <div style="clear: both"></div>
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
<script id="shoptemplateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-shangpin-quan" style="z-index: 1;">
        <dl><img src="{{ item.img }}" alt=""></dl>
        <dt class="wl-shang-title">{{item.name}}</dt>
        <dt class="wl-yiyuan">{{item.hospital_name}}</dt>
        <dd class="wl-jiage"><sup style="font-size: 10px">￥</sup>{{item.sell_price}}</dd>
        <dd class="wl-fenxiao click-to-create" data-goods_id="{{ item.id }}">推荐分销</dd>
    </div>
    {{#  }); }}
</script>
<script>
    const isAuth = <?php echo htmlentities($isAuth); ?>;
</script>
<script>
    $(".wl-sorting li").click(function () {
        $(this).addClass("active").siblings().removeClass("active");//获取选中元素的下标
    });
    $(".wl-price").click(function () {
        $(".wl-sorting-gao").toggle();
    });

    $(document).on('click', '.click-to-create', function () {
        if(isAuth == 0){
            alert('未授权操作');
            return false;
        }
        window.location.href = '/index/shop/shopEditor?gid='+$(this).data('goods_id');
    });

    var listObj = {
        params:{
            ini:true,
            page: 0,
            page_size: 16,
            category:'',
            sort:0,
            city:'',
            keywords:'',
            page_total:0,
        },
        loadlist:function(laypageObj){
            listObj.params.page++;

            if(listObj.params.ini == false && listObj.params.page > listObj.params.page_total){
                listObj.params.page--;
                $('#click-reload-more').find('a').addClass('layui-disabled').text('没有更多了');
                return false;
            }else{
                $('#click-reload-more').find('a').removeClass('layui-disabled').text('加载更多');
            }

            $.ajax({
                url: "/index/shop/getShopList",
                type: 'post',
                data: listObj.params,
                dataType: 'json',
                success: function (res) {
                    if(res.code == 200){
                        listObj.params.page_total = res.data.page_total;

                        layui.laytpl(shoptemplateList.innerHTML).render(res.data.rows, function(html){
                            console.log(listObj.params.ini);
                            if(listObj.params.ini){
                                $('#content').html(html);
                            }else{
                                $('#content').append(html);
                            }
                            listObj.params.ini = false;
                        });
                    }
                }
            });
        }
    };

    listObj.loadlist();

    var objClass = {
        categoryList:[],
        loading:false,
    };

    $(document).on('click','.click-find-category',function(){
        $(this).addClass("se").siblings().removeClass("se");
        listObj.params.ini = true;
        listObj.params.page = 0;
        listObj.params.category = $(this).data('id');
        listObj.loadlist();
    });

    $(document).on('click','.click-find-sort',function(){
        listObj.params.sort = $(this).data('sort');
        listObj.params.ini = true;
        listObj.params.page = 0;
        listObj.loadlist();
        $('#web-jiage').hide();
    });

    $('#click-reload-more').on('click',function(){
        listObj.loadlist();
    });
</script>

</body>
</html>