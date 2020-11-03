<?php /*a:2:{s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\user\my-hospital.html";i:1549940378;s:84:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
            <li>医院管理</li>
        </ul>
    </div>
</div>

<section class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-xs-12">
            <div class="tabs-container nav-tabs-custom">
                <ul class="nav nav-tabs" id="my-tab-status">
                    <li class="active"  data-id="tab-reload" ><a href="#tab-box1" data-toggle="tab">所属医院</a></li>
                    <li data-id="tab-reload2" ><a href="#tab-box2" data-toggle="tab">我的申请</a></li>
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
                    <div id="tab-box3" class="tab-pane">
                        <div class="panel-body">
                            <table class="layui-hide" id="table-list3" ></table>
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


<script type="text/html" id="box">
    <div class="col-md-12" style="margin: 0 auto;margin-top: 5px;">
        <div class="box" style="border-top: 1px solid #f4f4f4">
            <form class="form-horizontal" onsubmit="return false">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">医院名称</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="fr-select" style="height: 37px;">
                                <option>请选择申请的医院机构...</option>
                                <?php foreach($list as $v): ?>
                                <option value="<?php echo htmlentities($v['id']); ?>" ><?php echo htmlentities($v['hospital_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">申请备注</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" placeholder="(必填)请填写入驻医院备注信息..." id="fr-textarea" style="resize: none"></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="layui-btn layui-btn-sm layui-btn-normal pull-right" onclick="operationObj.submit()" style="margin-left: 10px !important;">立即申请</button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger pull-right" onclick="layer.close(operationObj.boxIndex)">取消</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload('tab-reload')" ><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="operationObj.showBox()"><i class="layui-icon layui-icon-add-1" ></i>添加医院</button>
    </div>
</script>

<script type="text/html" id="toolbarDemo2">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload('tab-reload2')" ><i class="layui-icon layui-icon-refresh-3"></i></button>
        <!--<button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick="objClass.confirmDel()"><i class="layui-icon layui-icon-delete"></i>删除</button>-->
    </div>
</script>

<script type="text/html" id="toolbarDemo3">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload('tab-reload3')" ><i class="layui-icon layui-icon-refresh-3"></i></button>
    </div>
</script>

<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script type="text/javascript" src="/static/seller/js/user-myhospital.js"></script>

</body>
</html>
