<?php /*a:2:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\category\add.html";i:1550136592;s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
            <li>分类管理</li>
            <li>添加项目分类</li>
        </ul>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">添加项目分类</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
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
                                        <button type="submit" class="btn btn-info btn-embossed" onclick="objClass.releaseCategory()">提交数据</button>
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

</body>
</html>
