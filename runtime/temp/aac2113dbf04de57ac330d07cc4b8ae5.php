<?php /*a:2:{s:79:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\user\my-doctor.html";i:1549940378;s:84:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
            <li>我的管理</li>
            <li>医生管理</li>
        </ul>
    </div>
</div>

<section class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="tabs-container nav-tabs-custom">
                <ul class="nav nav-tabs" id="my-tab-status">
                    <li class="active" ><a href="#tab-box1" data-toggle="tab">医生列表</a></li>
                    <li ><a href="#tab-box2" data-toggle="tab">申请列表</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-box1" class="tab-pane active">
                        <div class="panel-body">
                            <table class="layui-hide" id="table-list" ></table>
                        </div>
                    </div>
                    <div id="tab-box2" class="tab-pane">
                        <div class="panel-body">
                            <table class="layui-hide" id="table-list2" ></table>
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
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload('tab-reload')" ><i class="layui-icon layui-icon-refresh-3"></i></button>
        <!--<button type="button" class="layui-btn layui-btn-sm layui-btn-normal" ><i class="layui-icon layui-icon-add-1" ></i>邀请医生加入</button>-->
    </div>
</script>
<script type="text/html" id="toolbarDemo2">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload('tab-reload2')" ><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.adopt()">审核通过</button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick="objClass.fail()">审核失败</button>
    </div>
</script>

<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript" src="/static/seller/js/user-mydoctor.js"></script>

</body>
</html>
