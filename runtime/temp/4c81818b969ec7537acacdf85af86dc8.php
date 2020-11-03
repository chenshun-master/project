<?php /*a:2:{s:74:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\banner\add.html";i:1550134845;s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
<style>
    #from-img-box{
        margin-top: 20px;
    }
</style>

    
</head>
<body class="gray-bg" id="cus-body" >

<div class="row white-bg" id="cus-breadcrumb">
    <div class="col-sm-4">
        <ul class="breadcrumb">
            <li><a ><i class="fa fa-home"></i> 主页</a></li>
            <li>轮播图管理</li>
            <li>添加轮播图</li>
        </ul>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">添加轮播图</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form class="form-horizontal " id="infoLogoForm"  enctype="multipart/form-data" onsubmit="return false;">
                                <div class="box-body">
                                    <input type="hidden" value="<?php echo htmlentities($res['id']); ?>" id="fr-banner_id">
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">轮播图名称</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="fr-banner-name" placeholder="请输入轮播图名称"  value="<?php echo htmlentities($res['name']); ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">链接地址</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="fr-banner-url" placeholder="请输入有效的url地址"  value="<?php echo htmlentities($res['url']); ?>"  />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">类型</label>
                                        <div class="col-sm-10" style="padding-top: 8px;">
                                            <div class="layui-input-block" style="margin-left: 0px;" >

                                                <label  style="font-weight:normal;cursor: pointer">
                                                    <input type="radio" name="platform" value="h5" <?php if((isset($res['platform']) && ($res['platform'] !== '')?$res['platform']:'1') == 'h5'): ?>checked<?php endif; ?> checked> H5
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label  style="font-weight:normal;cursor: pointer">
                                                    <input type="radio" name="platform" value="pc" <?php if((isset($res['platform']) && ($res['platform'] !== '')?$res['platform']:'1') == 'pc'): ?>checked<?php endif; ?>>  PC
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">排序</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="fr-banner-order" onkeyup="value=value.replace(/[^\d{1,}\.\d{1,}|\d{1,}]/g,'')" placeholder="请输入排序内容"  value="<?php echo htmlentities($res['order']); ?>"  />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">轮播图片</label>
                                        <div class="col-sm-10">
                                            <div style="position: relative;cursor: pointer">
                                                <div class="layui-btn layui-btn-sm layui-btn-normal" style="position: absolute;top: 0;z-index: 1;">
                                                    <i class="layui-icon layui-icon-upload-drag"></i>轮播图片
                                                </div>
                                                <input type="file" name="img" style="position: absolute;top: 0;z-index: 2;width: 87px;opacity: 0;"  id="fr-upload-img"  />
                                            </div>

                                            <div class="layui-inline layui-word-aux" style="margin-left: 100px;padding-top: 5px;top: 5px;">
                                                每张图片最大限制在2M以内，必须上传图片
                                            </div>
                                            <div id="from-img-box">
                                                <div class="from-img-divs">
                                                    <?php if($res['id'] > '1'): ?>
                                                    <img src="<?php echo htmlentities($res['img']); ?>" data-imgid="<?php echo htmlentities($res['id']); ?>" style="width: 100px;height: 100px;"  class="fr-imgs-val" >
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer clearfix" style="padding-left: 146px;">
                                        <button type="submit" class="btn btn-info btn-embossed" onclick="objClass.releaseBanner()">提交数据</button>
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
        releaseBanner:function () {
            var regexp = /((http|https):\/\/([\w\-]+\.)+[\w\-]+(\/[\w\u4e00-\u9fa5\-\.\/?\@\%\!\&=\+\~\:\#\;\,]*)?)/ig;
            var data = {
                id       : $('#fr-banner_id').val(),
                name     : $('#fr-banner-name').val(),
                url      : $('#fr-banner-url').val(),
                platform : $('input:radio:checked').val(),
                order    : $('#fr-banner-order').val(),
            };
            var formData = new FormData($('#infoLogoForm')[0]);
            formData.append('id',data.id);
            formData.append('name',data.name);
            formData.append('url',data.url);
            formData.append('order',data.order);
            formData.append('platform',data.platform);
            if(data.name == ''){
                layer.msg('名称不能为空');
            }else if(data.url == ''){
                layer.msg('URl地址不能为空');
            }else if(!regexp.test(data.url)){
                layer.msg('请输入有效的URl地址');
            }else if(data.order == ''){
                layer.msg('排序内容不能为空');
            }else if(objClass.loading == false){
                var loading = layer.msg('提交中，请稍等...', {icon: 16,shade: 0.01,time:0});
                $.ajax({
                    url: '/admin/banner/releaseBanner',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,  //不处理发送的数据，因为data值是FormData对象，不需要对数据做处理
                    contentType: false,
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
                                window.location.href = '/admin/banner/index'
                            },2000)
                        }else if(res.code == 302){
                            layer.msg('请上传图片');
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
