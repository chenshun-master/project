<?php /*a:5:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\banner\index.html";i:1545892235;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout.html";i:1545963578;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\header.html";i:1545894446;s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\left.html";i:1545893987;s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\right.html";i:1545893391;}*/ ?>
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
        <li><a href="#">轮播图模块</a></li>
        <li class="active">轮播图列表</li>
    </ul>
</div>

<section class="content" >
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="nav-tabs-custom" >
                    <ul class="nav nav-tabs" id="my-tab-status">
                        <li class="active" data-status="0"><a href="#tab-box1" data-toggle="tab">轮播图信息</a></li>
                    </ul>
                    <div class="box-header">
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="">
                                <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.reload()" ><i class="layui-icon layui-icon-refresh-3"></i></button>
                                <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.add()"><i class="layui-icon layui-icon-add-1" ></i>添加轮播图</button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" style="min-height: 500px;">
                        <div class="tab-pane active" id="tab-box1">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="layui-hide" id="table-list" lay-filter="banner"></table>
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
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript">
    layui.table.render({
        elem: '#table-list'
        ,id:'tab-reload'
        ,url: '/admin/banner/getBannerList' //数据接口
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
            {field: 'platform', title: '类型'},
            {field: 'name', title: 'banner名称'},
            {field: 'url', title: '链接地址'},
            {field: 'img', title: '图片地址',width:100,align:"center",templet:function(row){
                    return '<img src="'+row.img+'" width="50" >';
                }},
            {field: 'order', title: '排序',sort:true},
            {field: 'visibility', title: '首页是否显示',width:100,templet:function(row){
                    if(row.visibility == 0){
                        return '<span class="label label-danger" lay-event="end">不显示</span>';
                    }else if(row.visibility == 1){
                        return '<span class="label label-success" lay-event="show">显示</span>';
                    }
            }},
            {fixed: 'right', title:'操作', toolbar: '#barDemo', width:150}
        ]]
        ,limits:[10,20,30,50,100]
    });

    layui.table.on('tool(banner)',function (obj) {
        var data = obj.data;
        var id = data.id;
        if (obj.event === 'del') {
            layer.confirm('真的删除行么', function (index) {
                $.ajax({
                    url:"/admin/banner/del",
                    data:{id:id},
                    type:"POST",
                    dataType:"json",
                    success:function (data) {
                        if(data.code == 200){
                            obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                            layer.close(index);
                            layer.msg('删除成功',{icon:6});
                        }else{
                            layer.msg('删除失败',{icon:5});
                        }
                    }
                })
            });
        }else if(obj.event === 'show'){
            $.ajax({
                url:'/admin/banner/update',
                data:{id:id,visibility:data.visibility},
                type:"POST",
                dataType:"json",
                success:function (data) {
                    if(data.code == 200){
                        window.location.reload();
                    }else{
                        layer.msg('修改失败');
                    }
                }
            })
        }else if(obj.event === "end"){
            $.ajax({
                url:'/admin/banner/update',
                data:{id:id,visibility:data.visibility},
                type:"POST",
                dataType:"json",
                success:function (data) {
                    if(data.code == 200){
                        window.location.reload();
                    }else{
                        layer.msg('修改失败');
                    }
                }
            })
        }else if(obj.event === 'edit') {
            window.location.href = "/admin/banner/addBanner/id/"+id;
        }
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
        add:function(){
            window.location.href = '/admin/banner/addBanner';
        }
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


