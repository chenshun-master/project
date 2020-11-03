<?php /*a:2:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\admin\index.html";i:1550200576;s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout2-main.html";i:1549940378;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo config('conf.title'); ?></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico"> <link href="/static/plugin/hAdmin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/animate.css" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/style.css?v=4.1.0" rel="stylesheet">
    <style>
        .form-control,input{
            border-radius: 0 !important;
        }

        #cus-breadcrumb{
            width: 100%;padding: 10px;margin: 0;
        }
    </style>

    
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css"  media="all">

    
</head>
<body class="gray-bg" id="cus-body" >

<div class="row white-bg" id="cus-breadcrumb">
    <div class="col-sm-4">
        <ul class="breadcrumb">
            <li><a ><i class="fa fa-home"></i> 主页</a></li>
            <li>用户管理</li>
            <li>管理员列表</li>
        </ul>
    </div>
</div>
<section class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title white-bg" style="border-top: 3px solid #f58d8d">
            <h5>管理员列表</h5>
        </div>
        <div class="ibox-content">
            <table id="table-list" lay-filter="admin"></table>
        </div>
    </div>
</section>


<!-- 全局js -->
<script src="/static/plugin/hAdmin/js/jquery.min.js?v=2.1.4"></script>
<script src="/static/plugin/hAdmin/js/bootstrap.min.js?v=3.3.6"></script>
<script>
    var layuiTable =  {
        getCheckId: function(tableId,id){
            var checkStatus = table.checkStatus(tableId) ,data = checkStatus.data;
            if(data.length > 0){
                var ids = [];
                $.each(data,function(k,v){ids.push(v[id]);});
                return ids;
            }else{
                return [];
            }
        }
    };
</script>

<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload()" ><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.add()"><i class="layui-icon layui-icon-add-1" ></i>添加管理员</button>
    </div>
</script>
<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript" src="/static/admin/js/admin_index.js"></script>
<script type="text/javascript">

</script>

</body>
</html>
