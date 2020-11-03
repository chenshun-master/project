<?php /*a:2:{s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\category\index.html";i:1550564431;s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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

    
<style>
    .btn-sm{
        padding-left: 5px;
        margin-left: 3px;
        margin-top: -8px;
    }
</style>

    
</head>
<body class="gray-bg" id="cus-body" >

<div class="row white-bg" id="cus-breadcrumb">
    <div class="col-sm-4">
        <ul class="breadcrumb">
            <li><a ><i class="fa fa-home"></i> 主页</a></li>
            <li>分类管理</li>
            <li>分类列表</li>
        </ul>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <a href="/admin/category/addCategory" class="btn btn-sm btn-info">添加项目分类</a>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
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
                        </thead>
                        <tbody>
                        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td style="text-align: center;"><?php echo htmlentities($vo['id']); ?></td>
                            <td style="text-align: center;"><?php echo htmlentities($vo['name']); ?></td>
                            <td style="text-align: center;">
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


</body>
</html>
