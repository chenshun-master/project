<?php /*a:5:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\goods\index.html";i:1545902570;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout.html";i:1545963578;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\header.html";i:1545894446;s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\left.html";i:1545893987;s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\right.html";i:1545893391;}*/ ?>
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
        <li><a href="#">商品模块</a></li>
        <li class="active">商品列表</li>
    </ul>
</div>

<section class="content" >
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="nav-tabs-custom" >
                    <ul class="nav nav-tabs" id="my-tab-status">
                        <li class="active" data-status="0"><a href="#tab-box1" data-toggle="tab">商品信息</a></li>
                        <li data-status="1"><a href="#tab-box1" data-toggle="tab">等待审核</a></li>
                        <li data-status="2"><a href="#tab-box1" data-toggle="tab">审核下架</a></li>
                        <li data-status="3"><a href="#tab-box1" data-toggle="tab">审核成功</a></li>
                    </ul>
                    <div class="tab-content" style="min-height: 500px;">
                        <div class="tab-pane active" id="tab-box1">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="layui-hide" id="table-list" lay-filter="goods"></table>
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
        <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.reload()"><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick="objClass.lower()">下架</button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-success" onclick="objClass.normal()">审核成功</button>
    </div>
</script>
<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>

<script type="text/javascript">
    layui.table.render({
        elem: '#table-list'
        ,id:'tab-reload'
        ,url: '/admin/goods/getGoodsList' //数据接口
        ,toolbar: '#toolbarDemo'
        ,page: true
        ,request: {
            pageName: 'page' //页码的参数名称，默认：page
            ,limitName: 'page_size' //每页数据量的参数名，默认：limit
            ,seller_id:'seller_id'
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
            {type: 'checkbox', fixed: 'left'},
            {field: 'goods_no', title: '商品的编号',sort:true},
            {field: 'real_name', title: '坐诊医生'},
            {field: 'hospital_name', title: '坐诊医院'},
            {field: 'name', title: '项目名称'},
            {field: 'img', title: '商品图片',width:100,align:"center",templet:function (res) {
                    return '<img src="'+res.img+'" width="30" >';
                }},
            {field: 'market_price', title: '市场价格',sort:true},
            {field: 'sell_price', title: '销售价格',sort:true},
            {field: 'prepay_price', title: '预付价格',sort:true},
            {field: 'topay_price', title: '到付价格',sort:true},
            {field: 'up_time', title: '上架时间',sort:true},
            {field: 'down_time', title: '下架时间',sort:true},
            {field: 'store_nums', title: '库存/名额',sort:true},
            {field: 'status', title: '当前状态',sort:true,width:100,templet:function (res) {
                    if(res.status == 0){
                        return '<span class="label label-success">审核成功</span>';
                    }else if(res.status == 1){
                        return '<span class="label label-primary">已删除</span>';
                    }else if(res.status == 2){
                        return '<span class="label label-danger">下架</span>';
                    }else if(res.status == 3){
                        return '<span class="label label-warning">等待审核</span>';
                    }
            }},
            {field: 'sale_num', title: '项目预约数',sort:true},
            {field: 'case_num', title: '案例数',sort:true},
            {field: 'create_time', title: '创建时间'},
        ]]
    });

    var $ = layui.$, active = {
        getCheckId: function(){ //获取选中数据
            var checkStatus = layui.table.checkStatus('tab-reload') ,data = checkStatus.data;
            if(data.length > 0){
                var ids = [];
                $.each(data,function(k,v){ids.push(v.id);});
                return ids;
            }else{
                return [];
            }
        },
        getInfo: function(){
            var status = $('#status').val();
            //执行重载
            if($('#status').val()){
                var index = layer.msg('查询中，请稍候...',{icon: 16,time:false,shade:0});
                setTimeout(function() {
                    layui.table.reload('tab-reload', {
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        , where: {
                            status: status,
                        }
                    });
                    layer.close(index);
                },800);
            }else{
                table.reload('tab-reload', {
                    where: {
                        status:status,
                    }
                });
                layui.table.reload('');
            }
        }
    };
    $('.demoTable .layui-btn').on('click', function(){
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    $('#my-tab-status li').on('click',function(){
        objClass.where.status = $(this).data('status');
        objClass.reload();
    });
    var objClass = {
        where:{
            status:0
        },
        reload:function(){
            layui.table.reload('tab-reload', {
                page: {curr: 1},
                where:objClass.where
            });
        },
        lower:function(){
            var ids = active.getCheckId();
            if(ids.length == 0){
                layer.alert('请选择需要操作的商品',{title:'温馨提示'});
                return  false;
            }
            var index = layer.confirm('您确定要下架商品吗？', {
                btn: ['立即下架','取消']
            }, function(){
                objClass.updateSatus(ids,'lower',index);
            });
        },
        normal:function(){
            var ids = active.getCheckId();
            if(ids.length == 0){
                layer.alert('请选择需要操作的商品',{title:'温馨提示'});
                return  false;
            }
            var index = layer.confirm('您确定要审核成功商品吗？', {
                btn: ['立即审核成功','取消']
            }, function(){
                objClass.updateSatus(ids,'normal',index);
            });
        },
        updateLoading:false,
        updateSatus:function(ids,flag,index){
            if(objClass.updateLoading == false){
                $.ajax({
                    url: '/admin/goods/updateGoodsStatus',
                    type: 'POST',
                    data:{ids:ids,flag:flag},
                    dataType: "json",
                    success: function (res) {
                        layer.close(index);
                        if(res.code == 200){
                            layer.msg('操作成功。。。', {icon: 1});
                            layui.table.reload('tab-reload', {page: {curr: objClass.currentpage}});
                        }else{
                            layer.msg('操作失败。。。', {icon: 2});
                        }
                    }
                });
            }
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


