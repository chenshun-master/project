<?php /*a:2:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\goods\index.html";i:1550137090;s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
            <li>商户管理</li>
            <li>商品列表</li>
        </ul>
    </div>
</div>
<section class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="tabs-container nav-tabs-custom">
                <ul class="nav nav-tabs" id="my-tab-status">
                    <li class="active" data-status="0"><a href="#tab-box1" data-toggle="tab">商品信息</a></li>
                    <li data-status="1"><a href="#tab-box1" data-toggle="tab">等待审核</a></li>
                    <li data-status="2"><a href="#tab-box1" data-toggle="tab">审核下架</a></li>
                    <li data-status="3"><a href="#tab-box1" data-toggle="tab">审核成功</a></li>
                </ul>

                <div class="tab-content">
                    <div id="tab-box1" class="tab-pane active">
                        <div class="panel-body">
                            <table class="layui-hide" id="table-list" lay-filter="goods"></table>
                        </div>
                    </div>
                </div>
            </div>
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
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload()"><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick="objClass.lower()">下架</button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-success" onclick="objClass.normal()">审核成功</button>
    </div>
</script>

<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript" src="/static/admin/js/goods_index.js"></script>
<script>

</script>

</body>
</html>
