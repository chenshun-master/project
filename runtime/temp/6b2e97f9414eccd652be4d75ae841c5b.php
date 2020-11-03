<?php /*a:5:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\category\add.html";i:1545377421;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout.html";i:1545805646;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\header.html";i:1545894446;s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\left.html";i:1545893987;s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\right.html";i:1545893391;}*/ ?>
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
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-box1" data-toggle="tab">添加项目分类</a></li>
                </ul>
                <div class="tab-content" style='min-height: 500px;'>
                    <div class="tab-pane active" id="tab-box1">
                        <form class="form-horizontal " id="infoLogoForm"  enctype="multipart/form-data" onsubmit="return false;">
                            <div class="box-body">
                                <input type="hidden" value="<?php echo htmlentities($res['id']); ?>" id="fr-category_id">
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">分类名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fr-category-name" placeholder="请输入分类名称"  value="<?php echo htmlentities($res['name']); ?>"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">顶级分类</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" id="fr-parent_id">
                                            <option value="0">顶级分类</option>
                                            <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                                            <option <?php if($res['parent_id'] == $val['id']): ?>selected="selected"<?php endif; ?> value="<?php echo htmlentities($val['id']); ?>"><?php if($val['level'] != 0): ?>|<?php endif; ?><?php echo str_repeat('-', $val['level']*4)?><?php echo htmlentities($val['name']); ?></option>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">排序</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fr-category-sort" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" placeholder="请输入排序内容"  value="<?php echo htmlentities($res['sort']); ?>"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">标题</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fr-category-title" placeholder="请输入标题"  value="<?php echo htmlentities($res['title']); ?>"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">关键字</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fr-category-keywords" placeholder="请输入关键字"  value="<?php echo htmlentities($res['keywords']); ?>"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-1 control-label">描述</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="fr-category-descript" placeholder="请输入描述内容"  value="<?php echo htmlentities($res['descript']); ?>"  />
                                    </div>
                                </div>
                                <div class="box-footer clearfix" style="padding-left: 146px;">
                                    <button type="submit" class="btn btn-success btn-embossed" onclick="objClass.releaseCategory()">提交数据</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/static/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/static/js/functions.js"></script>
<!-- layui -->
<script src="/static/plugin/layui/layui.all.js"></script>
<script>
    var objClass = {
        loading:false,
        releaseCategory:function () {
            var data = {
                id        : $('#fr-category_id').val(),
                name      : $('#fr-category-name').val(),
                parent_id : $('#fr-parent_id').val(),
                sort      : $('#fr-category-sort').val(),
                title     : $('#fr-category-title').val(),
                keywords   : $('#fr-category-keywords').val(),
                descript  : $('#fr-category-descript').val(),
            };
            if(data.name == ''){
                layer.msg('分类名称不能为空');
            }else if(data.sort == ''){
                layer.msg('排序内容不能为空');
            }else if(data.title == ''){
                layer.msg('标题不能为空');
            }else if(data.keywords == ''){
                layer.msg('关键字不能为空');
            }else if(data.descript == ''){
                layer.msg('描述内容不能为空');
            }else if(objClass.loading == false){
                var loading = layer.msg('提交中，请稍等...', {icon: 16,shade: 0.01,time:0});
                $.ajax({
                    url: '/admin/category/releaseCategory',
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    beforeSend:function(){
                        objClass.loading = true;
                    },
                    complete:function(){
                        objClass.loading = false;
                        layer.close(loading);
                    },
                    success: function (res) {
                        if(res.code == 200){
                            layer.msg('提交成功...', {icon: 1});
                            setTimeout(function(){
                                window.location.href = '/admin/category/index'
                            },2000)
                        }else{
                            layer.msg(res.msg);
                        }
                    }
                });
            }
        }
    }
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


