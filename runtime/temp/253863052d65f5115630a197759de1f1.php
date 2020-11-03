<?php /*a:1:{s:74:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\index\main.html";i:1550284527;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title> <?php echo config('conf.title'); ?> - 商城后台</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/plugin/hAdmin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/animate.css" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/style.css?v=4.1.0" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/iconfont.css" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <style type="text/css">
        .cus-nav > li{
            border-left: 1px solid #f1e9e9;
            border-right: 1px solid #f1e9e9;
            margin-right: 0 !important;
        }
        .cus-nav > li > a {
            font-weight: none !important;
        }
        .nav > li > a {
            color: #869fb1;
            font-weight: 300;
            padding: 14px 20px 14px 25px;
        }
        .to-web-home{
            height: 50px;width: 45px;font-size: 22px;margin:0;line-height: 43px;border-left: 1px solid #e2e2e2;border-right:1px solid #e2e2e2;
        }
        .to-web-home > i{
            color: #7DB0E8
        }
    </style>
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header" style="background: #414163 !important">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs" style="font-size:20px;color: #ffffff;text-align: center">
                                    <strong class="font-bold"><?php echo config('conf.title'); ?></strong>
                                </span>
                            </span>
                        </a>
                    </div>
                    <div class="logo-element">管理</div>
                </li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope" >控制台</span>
                </li>
                <li>
                    <a class="J_menuItem" href="/admin/index/index2"><i class="fa fa-home"></i><span class="nav-label">商城主页</span></a>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope" >轮播图管理</span>
                </li>
                <li>
                    <a href="/admin/banner/index" class="J_menuItem" ><i class="glyphicon glyphicon-check"></i> <span class="nav-label">轮播图列表</span></a>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope" >分类管理</span>
                </li>
                <li>
                    <a href="/admin/category/index" class="J_menuItem" ><i class="glyphicon glyphicon-check"></i> <span class="nav-label">分类列表</span></a>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope" >用户管理</span>
                </li>
                <li>
                    <a href="/admin/user/index" class="J_menuItem" ><i class="glyphicon glyphicon-user"></i> <span class="nav-label">用户列表</span></a>
                    <a href="/admin/user/adminList" class="J_menuItem" ><i class="glyphicon glyphicon-user"></i> <span class="nav-label">管理员列表</span></a>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">商户管理</span>
                </li>
                <li>
                    <a href="/admin/seller/index" class="J_menuItem" ><i class="glyphicon glyphicon-credit-card"></i> <span class="nav-label">商户列表</span></a>
                    <a href="/admin/seller/goodsIndex" class="J_menuItem" ><i class="glyphicon glyphicon-credit-card"></i> <span class="nav-label">商品列表</span></a>
                    <a href="/admin/seller/authIndex" class="J_menuItem" ><i class="glyphicon glyphicon-credit-card"></i> <span class="nav-label">认证列表</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header" style="width: 100% !important">
                    <a class="navbar-minimalize minimalize-styl-2 " style="height: 50px;width: 45px;font-size: 22px;margin:0;line-height: 43px;" href="#"><i class="fa fa-bars" ></i> </a>
                    <a class="minimalize-styl-2 to-web-home"  href=""  ><i class="fa fa-home"></i></a>
                    <ul class="nav navbar-top-links cus-nav" style="float: right;">
                        <li >
                            <a href="/admin/index/loginOut"><i class="glyphicon glyphicon-log-out"></i> 退出</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe id="J_iframe" width="100%" height="100%" src="/admin/index/index2" frameborder="0" data-id="/admin/index/index2" seamless ></iframe>
        </div>
    </div>
</div>

<!-- 全局js -->
<script src="/static/plugin/hAdmin/js/jquery.min.js?v=2.1.4"></script>
<script src="/static/plugin/hAdmin/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/static/plugin/hAdmin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/static/plugin/hAdmin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/static/plugin/hAdmin/js/plugins/layer/layer.min.js"></script>

<!-- 自定义js -->
<script src="/static/plugin/hAdmin/js/hAdmin.js?v=4.1.0"></script>
<script src="/static/plugin/hAdmin/js/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript" src="/static/plugin/hAdmin/js/index.js"></script>

<!-- 第三方插件 -->
<script src="/static/plugin/hAdmin/js/plugins/pace/pace.min.js"></script>

</body>
</html>