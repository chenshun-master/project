<?php /*a:2:{s:73:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\admin\add.html";i:1550226371;s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
            <li>管理员管理</li>
            <li>添加管理员</li>
        </ul>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">添加管理员</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form class="form-horizontal " onsubmit="return false;">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">管理员名称</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="fr-admin-username"  placeholder="请输入管理员名称" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">管理员密码</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="fr-admin-password" maxlength="16" placeholder="请输入管理员密码"  />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">管理员状态</label>
                                        <div class="col-sm-10" style="padding-top: 8px;">
                                            <div class="layui-input-block" style="margin-left: 0px;" >

                                                <label  style="font-weight:normal;cursor: pointer">
                                                    <input type="radio" name="status" value="10" checked > 启用
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label  style="font-weight:normal;cursor: pointer">
                                                    <input type="radio" name="status" value="0">  已禁用
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer clearfix" style="padding-left: 146px;">
                                        <button type="submit" class="btn btn-info btn-embossed" onclick="objClass.releaseAdmin()">提交数据</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



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

<script src="/static/js/functions.js"></script>
<!-- layui -->
<script src="/static/plugin/layui/layui.all.js"></script>
<script>
    var objClass = {
        loading:false,
        releaseAdmin:function () {
            var data = {
                id       : $('#fr-admin_id').val(),
                username : $('#fr-admin-username').val(),
                password : $('#fr-admin-password').val(),
                status   : $('input:radio:checked').val(),
            };
            if(data.username == ''){
                layer.msg('管理员名称不能为空');
            }else if(data.username.length<5 || data.username.length>16){
                layer.msg('管理员名称格式不正确');
            }else if(!redream.checkPassword(data.password)){
                layer.msg('管理员密码格式有误');
            }else if(objClass.loading == false){
                var loading = layer.msg('提交中，请稍等...', {icon: 16,shade: 0.01,time:0});
                $.ajax({
                    url: '/admin/admin/releaseAdmin',
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
                                window.location.href = '/admin/admin/index'
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

</body>
</html>
