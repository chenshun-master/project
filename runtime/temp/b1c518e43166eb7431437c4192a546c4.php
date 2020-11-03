<?php /*a:5:{s:74:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\user\index.html";i:1545903431;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout.html";i:1545963578;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\header.html";i:1545894446;s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\left.html";i:1545893987;s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\right.html";i:1545893391;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/static/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/static/admin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/static/admin/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/static/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/static/admin/dist/css/skins/_all-skins.min.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>商城后台</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/static/admin/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo htmlentities(app('session')->get('user_auth.username')); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/static/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">个人信息</a>
                            </div>
                            <div class="pull-right">
                                <a href="/admin/login/loginOut" class="btn btn-default btn-flat">退出登陆</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
    <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/static/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo htmlentities(app('session')->get('user_auth.username')); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i>管理员</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>轮播图</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu active">
                    <li class="active"><a href="/admin/banner/index"><i class="fa fa-circle-o"></i>轮播图列表</a></li>
                </ul>
            </li>
            <li>
                <a href="/admin/category/index">
                    <i class="fa fa-th"></i> <span>分类管理</span>
                    <span class="pull-right-container"></span>
                </a>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>用户管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu active">
                    <li class="active"><a href="/admin/user/index"><i class="fa fa-user"></i>会员管理</a></li>
                    <li class="active"><a href="/admin/admin/index"><i class="fa fa-users"></i>管理员列表</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span>商户管理</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu active">
                    <li class="active"><a href="/admin/seller/index"><i class="fa fa-circle-o"></i>商户列表</a></li>
                    <li class="active"><a href="/admin/goods/index"><i class="fa fa-circle-o"></i>商品列表</a></li>
                    <li class="active"><a href="/admin/auth/index"><i class="fa fa-circle-o"></i>认证管理</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
    <div class="content-wrapper">
         <!--Content Header (Page header)-->
        <section class="content-header">
        </section>
        
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css"  media="all">

<div id="breadcrumb">
    <ul class="breadcrumb">
        <li><i class="home-icon fa fa-home"></i> <a href="/admin/index/index">主页</a></li>
        <li><a href="#">用户模块</a></li>
        <li class="active">用户列表</li>
    </ul>
</div>

<section class="content" >
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="nav-tabs-custom" >
                    <ul class="nav nav-tabs" id="my-tab-status">
                        <li class="active" data-status="0"><a href="#tab-box1" data-toggle="tab">用户信息</a></li>
                    </ul>
                    <div class="tab-content" style="min-height: 500px;">
                        <div class="tab-pane active" id="tab-box1">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="layui-hide" id="table-list" lay-filter="user"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.reload()" ><i class="layui-icon layui-icon-refresh-3"></i></button>
    </div>
</script>
<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript">
    layui.table.render({
        elem: '#table-list'
        ,id:'tab-reload'
        ,url: '/admin/user/getUserList' //数据接口
        ,toolbar: '#toolbarDemo'
        ,page: true
        ,request: {
            pageName: 'page' //页码的参数名称，默认：page
            ,limitName: 'page_size' //每页数据量的参数名，默认：limit
        }
        ,parseData: function(res){ //res 即为原始返回的数据
            return {
                "code": res.code == 200?0:res.code, //解析接口状态
                "msg": res.msg, //解析提示文本
                "count": res.data.total, //解析数据长度
                "data": res.data.rows //解析数据列表
            };
        }
        ,cols: [[ //表头
            {field: 'id', title: 'ID', fixed: 'left',width:120},
            {field: 'mobile', title: '手机号'},
            {field: 'nickname', title: '用户昵称'},
            {field: 'portrait', title: '用户头像',width:100,align:"center",templet:function (res) {
                    return '<img src="'+res.portrait+'" width="30" >';
                }},
            {field: 'type', title: '用户类型',width:100,templet:function(row){
                    if(row.type == 1){
                        return '<span class="label label-success">普通用户</span>';
                    }else if(row.type == 2){
                        return '<span class="label label-danger">认证用户</span>';
                    }else if(row.type == 3){
                        return '<span class="label label-warning">认证医生</span>';
                    }else if(row.type == 4){
                        return '<span class="label label-primary">认证医院</span>';
                    }else if(row.type == 5){
                        return '<span class="label label-info">官方团队</span>';
                    }
                }},
            {field: 'score', title: '用户积分',sort:true},
            {field: 'account', title: '账户余额',sort:true},
            {field: 'sex', title: '用户性别',width:100,templet:function(row){
                    if(row.sex == 0){
                        return '<span class="label label-warning">未知</span>';
                    }else if(row.sex == 1){
                        return '<span class="label label-danger">男</span>';
                    }else if(row.sex == 2){
                        return '<span class="label label-primary">女</span>';
                    }
                }},
            {field: 'birthday_date', title: '出生日期',sort:true},
            {field: 'profile', title: '用户简介'},
            {field: 'last_login_time', title: '最后登陆时间',sort:true},
            {field: 'last_login_ip', title: '最后登陆IP'},
        ]]
    });


    var objClass = {
        reload:function(){
            layui.table.reload('tab-reload', {
                page: {
                    curr: 1
                }
                ,where: {
                    key: {

                    }
                }
            });
        },
    };
</script>

    </div>

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
    <div class="control-sidebar-bg"></div>
</div>
 <!--./wrapper-->
<!-- jQuery 3 -->
<script src="/static/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/static/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/static/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/static/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/static/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/static/admin/dist/js/demo.js"></script>
<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>
</body>
</html>


