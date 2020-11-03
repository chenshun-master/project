<?php /*a:5:{s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\category\index.html";i:1545381226;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout.html";i:1545805646;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\header.html";i:1545894446;s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\left.html";i:1545893987;s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\right.html";i:1545893391;}*/ ?>
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
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">项目分类列表</h3>
                        <!-- /.box-tools -->
                    </div>
                    <div class="mailbox-controls">
                        <div class="btn-group">
                            <a href="/admin/category/addCategory" class="btn btn-primary">
                                新增项目分类
                            </a>
                        </div>

                        <!-- /.btn-group -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">

                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <th style="text-align: center;"><div class="th-inner ">编号</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">分类名称</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">父分类</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">标题</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">关键字</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">描述</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">排序</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">首页是否显示</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">创建时间</div><div class="fht-cell"></div></th>
                                    <th style="text-align: center;"><div class="th-inner ">操作</div><div class="fht-cell"></div></th>
                                </tr>
                                <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['id']); ?></td>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['name']); ?></td>
                                    <td>
                                        <?php if($vo['level'] != 0): ?> |<?php endif; ?>
                                        <?php echo str_repeat('-',$vo['level'] * 4) ?>
                                        <?php echo htmlentities($vo['name']); ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['title']); ?></td>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['keywords']); ?></td>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['descript']); ?></td>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['sort']); ?></td>
                                    <td style="text-align: center;">
                                        <?php if($vo['id'] > '0'): if($vo['visibility'] == '1'): ?>
                                        <a href="<?php echo url('/admin/category/update',array('id'=>$vo['id'],'visibility'=>0)); ?>"><span class="label label-success">显示</span></a>
                                        <?php else: ?>
                                        <a href="<?php echo url('/admin/category/update',array('id'=>$vo['id'],'visibility'=>1)); ?>"><span class="label label-danger">不显示</span></a>
                                        <?php endif; endif; ?>
                                    </td>
                                    <td style="text-align: center;"><?php echo htmlentities($vo['created_time']); ?></td>
                                    <td class="table-action" style="text-align: center;">
                                        <a href="<?php echo url('/admin/category/addCategory',array('id'=>$vo['id'])); ?>" class="btn btn-xs btn-success btn-editone" data-original-title="编辑"><i class="fa fa-pencil"></i></a>
                                        <!--<a href="<?php echo url('/admin/category/del',array('id'=>$vo['id'])); ?>" class="btn btn-xs btn-danger btn-delone" data-toggle="tooltip" title="" data-table-id="table" data-field-index="9" data-row-index="0" data-button-index="2" data-original-title="删除"><i class="fa fa-trash"></i></a>-->
                                    </td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="pull-right">
                            <!-- /.btn-group -->
                        </div>
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
</section>
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


