<?php /*a:2:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\diary\index.html";i:1549940378;s:84:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
    .control-label{
        font-weight: normal !important;
    }

    .diary-img-boxs {
        position: relative;
        width: 100px;
        height: 100px;
        cursor: pointer;
        float: left !important;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .diary-img-boxs-remove {
        position: absolute;
        top: 0;
        right: 0px;
        z-index: 2;
        color: red;
        background: white;
        width: 20px;
        height: 20px;
        display: none;
    }

    .diary-img-boxs:hover .diary-img-boxs-remove {
        display: block;
    }

    .diary-goods{
        min-height: 20px;margin-top: 10px;
    }

    .diary-goods > ul > li {
        padding: 5px 5px 5px 0;border-bottom: 1px solid #f5eeee;position: relative
    }

    .diary-goods > ul > li > span:first-child{
        padding-left: 5px;color: #787070
    }

    .diary-goods > ul > li .diary-goods-remove{
        display: inline-block;width: 50px;height: 20px;background: #ff5722;color: white;position: absolute;right: 0px;top: 10px;padding: 0 3px 0 3px;cursor: pointer;display: none;
    }

    .diary-goods > ul > li:hover .diary-goods-remove{
        display: block;
    }
</style>

    
</head>
<body class="gray-bg" id="cus-body" >

<div class="row white-bg" id="cus-breadcrumb">
    <div class="col-sm-4">
        <ul class="breadcrumb">
            <li><a ><i class="fa fa-home"></i> 主页</a></li>
            <li>我的管理</li>
            <li>日记案例管理</li>
        </ul>
    </div>
</div>
<section class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title white-bg" style="border-top: 3px solid #efafe7">
            <h5>美丽日记</h5>
        </div>
        <div class="ibox-content">
            <table id="table-list" ></table>
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


<script type="text/html" id="searchGoodsTemplate">
    <div class="layui-card">
        <table id="search-goods-list" ></table>
    </div>
</script>

<script type="text/html" id="caseTemplate">
    <div class="col-md-12" style="margin: 0 auto;margin-top: 5px;">
        <div class="box" >
            <form class="form-horizontal" id="from" onsubmit="return false">
                <div class="box-body" style="height: 580px !important;overflow-y: auto;overflow-x: hidden">
                    <div class="form-group" style="margin-bottom: 5px;">
                        <label class="col-sm-1 control-label" >日记标题</label>
                        <div class="col-sm-11">
                            <input type="text" class="form-control" placeholder="请填写案例标题 ..." id="fr-diary-title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-11">
                            <p style="margin-top: 3px;color: #0b93d5;cursor: pointer" onclick="objClass.choiceGoods()">选择相关商品</p>
                            <div class="diary-goods"><ul></ul></div>
                        </div>
                    </div>

                    <div class="box-header with-border">
                        <h3 class="box-title">术前照片</h3>
                    </div>
                    <br />

                    <div class="form-group">
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-11" id="img-container">
                            <div style="width: 100px;height: 100px;border:1px solid #CCCCCC;cursor: pointer;float: left;position: relative;margin-bottom: 10px;margin-right: 10px;">
                                <div style="width: 100%;height: 100%;">
                                    <img src="/static/seller/image/plus.png"  width="20" height="20" style="margin-left: 40px;margin-top: 40px;" class="cus-img">
                                </div>
                                <div style="position: absolute;z-index: 2;top: 0px">
                                    <input type="file" name="imgFile"  style="width: 100px;height: 100px;border: none;opacity: 0;cursor: pointer" id="fr-diary-img-upload"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <!--<span style="color: #f39292;font-size: 14px;">温馨提示:变美过程日记请在日记创建后到详情页面添加</span>-->
                    <button class="layui-btn layui-btn-sm layui-btn-normal pull-right" onclick="objClass.addDiary()" style="margin-left: 10px !important;">立即发布</button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger pull-right" onclick="layer.close(objClass.addDiaryBoxIndex)">取消</button>
                </div>
            </form>
        </div>
    </div>
</script>

<script type="text/html" id="toolbarDemo">
    <div class="layui-btn-container">
        <button class="layui-btn layui-btn-sm btn-refresh-bg" onclick="objClass.reload()" ><i class="layui-icon layui-icon-refresh-3"></i></button>
        <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="objClass.add()"><i class="layui-icon layui-icon-add-1" ></i>添加日记</button>
    </div>
</script>
<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>

<script type="text/javascript" src="/static/seller/js/diary_index.js"></script>

</body>
</html>
