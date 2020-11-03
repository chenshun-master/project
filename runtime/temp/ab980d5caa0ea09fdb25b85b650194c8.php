<?php /*a:5:{s:74:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\shop\spec.html";i:1544419842;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\layout.html";i:1544419842;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\header.html";i:1544419842;s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\left-nav.html";i:1544419842;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\right-nav.html";i:1544419842;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商户后台管理系统</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/static/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/admin/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/admin/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/static/admin/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/static/admin/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="/static/admin/bower_components/jquery/dist/jquery.min.js"></script>
    <style type="text/css">
        .breadcrumb{border-bottom: 1px solid #cfc5c5 !important; margin-bottom: 3px !important;}
    </style>
    
<link rel="stylesheet" href="/pc/layui/css/layui.css"  media="all">

    
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
    <a href="/static/admin/index2.html" class="logo">
        <span class="logo-mini"><b>后台</b></span>
        <span class="logo-lg"><b>商户后台</b></span>
    </a>

    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/static/admin/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $user_info['type']==3 ? htmlentities($user_info['real_name']) : htmlentities($user_info['hospital_name']); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="/static/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            <p>
                                Alexander Pierce - Web Developer
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">项目量</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">预约量</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">团队</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">个人信息</a>
                            </div>
                            <div class="pull-right">
                                <a href="/seller/index/signOut" class="btn btn-default btn-flat">退出登录</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!--<li>-->
                    <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                <!--</li>-->
            </ul>
        </div>
    </nav>
</header>

    <aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/static/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $user_info['type']==3 ? htmlentities($user_info['real_name']) : htmlentities($user_info['hospital_name']); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i>
                    商户类型：<?php echo $user_info['type']==3 ? '医生'  :  ($user_info['type'] ==4 ? '医院' : '个人'); ?>
                </a>
            </div>

        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview menu-open">
                <a href="#">
                    <i class="fa fa-reorder"></i> <span>商品模块</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li><a href="/seller/shop/addGood"><i class="fa fa-circle-o"></i> 添加商品</a></li>
                    <li><a href="/seller/shop/index"><i class="fa fa-circle-o"></i> 商品列表</a></li>
                    <li><a href="/seller/shop/spec"><i class="fa fa-circle-o"></i> 规格列表</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-reorder"></i> <span>共享模块</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" >
                    <li><a href="/seller/shop/index"><i class="fa fa-shopping-cart"></i>共享商品</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>

    <div class="content-wrapper">
        
<div id="breadcrumb">
    <ul class="breadcrumb">
        <li><i class="home-icon fa fa-home"></i> <a href="#">主页</a></li>
        <li><a href="#">商品模块</a></li>
        <li class="active">商品列表</li>
    </ul>
</div>

<section class="content" >
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">商品列表</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="">
                            <button type="button" class="btn  btn-flat" onclick="objClass.reload()"><i class="layui-icon layui-icon-refresh-3" ></i>刷新</button>&nbsp;
                            <button type="button" class="btn  btn-flat" onclick="objClass.showBox()"><i class="layui-icon layui-icon-add-1" ></i>添加规格</button>
                        </div>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table id="table-list" ></table>
                </div>
            </div>
        </div>
    </div>
</section>

    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">微琳医美</a></strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
        </div>

        <div class="tab-pane" id="control-sidebar-stats-tab" style=""></div>

        <div class="tab-pane" id="control-sidebar-settings-tab">

        </div>
    </div>
</aside>
<div class="control-sidebar-bg"></div>
</div>

<script src="/static/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/static/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/static/admin/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/static/admin/dist/js/adminlte.min.js"></script>
<script src="/static/admin/dist/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function () {$('.sidebar-menu').tree()});
</script>


<script type="text/javascript" src="/pc/layui/layui.all.js"></script>
<script type="text/javascript" src="/static/seller/js/shop_spec.js"></script>
<script type="text/javascript">
</script>

</body>
</html>