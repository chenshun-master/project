<?php /*a:2:{s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\shop\addgood.html";i:1549940378;s:84:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\layout\layout2-main.html";i:1549940378;}*/ ?>
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
    #from-img-box > div{
        float: left;
        margin-left: 5px;
        width: 100px;
        height: 120px;
    }

    #from-img-box > div:first-child{
        margin-left: 0px;
    }
    #from-img-box > div > img{
        width: 100px;
        height: 100px;
        border: 1px solid #f2f2f2;
    }

    .icon-i{
        background: #f3eef0;
    }

    .icon-i i:hover{
        color:#0b97c4 !important;
    }

    .icon-i i:nth-child(1){
        color: #0b93d5;font-size: 18px;font-weight: bold;cursor: pointer;
    }

    .icon-i i:nth-child(2){
        color: #0b93d5;font-size: 18px;font-weight: bold;margin-left: 20px;cursor: pointer;
    }

    .icon-i i:nth-child(3){
        color: #0b93d5;font-size: 18px;font-weight: bold;margin-left: 18px;cursor: pointer;
    }

    #remoteUrl{ime-mode: disabled !important;background-color: #cccccc;}

    #categoryList th{
        color:#00c0ef;
    }

    #categoryList .layui-badge{
        cursor: pointer;
        padding-left: 5px;
        padding-right: 5px;
        margin-left: 5px;
        margin-top: 5px;
    }

    .select{
        background: #00a65a !important;
        color: white !important;
    }

    #process-hint-table td p{
        margin-top: 8px;
        width: 10px;
    }

    #process-hint-table td p i{
        color: red;cursor: pointer;display: none;
    }
</style>

    
</head>
<body class="gray-bg" id="cus-body" >

<div class="row white-bg" id="cus-breadcrumb">
    <div class="col-sm-4">
        <ul class="breadcrumb">
            <li><a ><i class="fa fa-home"></i> 主页</a></li>
            <li>商品管理</li>
            <li>添加商品</li>
        </ul>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 商品信息</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">商品详情</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">商品购买须知</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form class="form-horizontal " onsubmit="return false;" id="fr-goods">
                                <div class="box-body">
                                    <input type="hidden" value="<?php echo !empty($info['goods_info']['id']) ? htmlentities($info['goods_info']['id']) : 0; ?>" id="fr-gooid_id">
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">商品名称</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="fr-good-name" placeholder="商品名称"  value="<?php echo !empty($info['goods_info']['name']) ? htmlentities($info['goods_info']['name']) : ''; ?>"  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">搜索关键词</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="fr-search-words" placeholder="商品搜索关键词" value="<?php echo !empty($info['goods_info']['search_words']) ? htmlentities($info['goods_info']['search_words']) : ''; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">商品类别</label>
                                        <div class="col-sm-10" style="padding-top: 5px;">
                                            <input type="hidden" value="<?php echo !empty($info['goods_info']['category_id']) ? htmlentities($info['goods_info']['category_id']) : 0; ?>" id="fr-category">
                                            <span class="layui-btn layui-btn-xs" onclick="objClass.choiceCategory()">  <i class="layui-icon layui-icon-add-1"></i> 选择类别</span>
                                            <span id='categoryList-select'>
                                            <?php if((isset($info['goods_info']['category_id']))): ?>
                                                <span class="layui-badge layui-bg-blue" data-id="<?php echo !empty($info['goods_info']['category_id']) ? htmlentities($info['goods_info']['category_id']) : 0; ?>" ><?php echo htmlentities($info['goods_info']['category_name']); ?></span>
                                            <?php endif; ?>
                                        </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">商品信息</label>
                                        <div class="col-sm-10">
                                            <div  style="margin-top: 5px;">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">基础信息 <code style="font-size: 12px !important;">温馨提示：当预付金额等于销售价格 即等于在线全款支付</code></h3>
                                                </div>
                                                <br />
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr style="color: #0b97c4">
                                                        <th>市场价格</th>
                                                        <th>销售价格</th>
                                                        <th>预付金额 / 在线支付金额</th>
                                                        <th>到付金额</th>
                                                        <th>预约名额</th>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="form-control" style="width: 150px;"  id="fr-market_price"  value="<?php echo !empty($info['goods_info']['market_price']) ? htmlentities($info['goods_info']['market_price']) : ''; ?>" onkeyup="checkDecimal(this)" /></td>
                                                        <td><input type="text" class="form-control" style="width: 150px;" id="fr-sell_price" value="<?php echo !empty($info['goods_info']['sell_price']) ? htmlentities($info['goods_info']['sell_price']) : ''; ?>" onkeyup="checkDecimal(this)" ></td>
                                                        <td><input type="text" class="form-control" style="width: 150px;" id="fr-prepay_price" value="<?php echo !empty($info['goods_info']['prepay_price']) ? htmlentities($info['goods_info']['prepay_price']) : ''; ?>" onkeyup="checkDecimal(this)" ></td>
                                                        <td><input type="text" class="form-control" style="width: 150px;" id="fr-topay_price" value="<?php echo !empty($info['goods_info']['topay_price']) ? htmlentities($info['goods_info']['topay_price']) : ''; ?>" readonly></td>
                                                        <td><input type="text" class="form-control" style="width: 150px;" id="fr-store_nums" value="<?php echo !empty($info['goods_info']['store_nums']) ? htmlentities($info['goods_info']['store_nums']) : ''; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">商品状态</label>
                                        <div class="col-sm-10" style="padding-top: 8px;">
                                            <div class="layui-input-block" style="margin-left: 0px;" >
                                                <label  style="font-weight:normal;cursor: pointer">
                                                    <input type="radio" name="status" value="3" title="是" checked> 申请上架
                                                </label>
                                                <label  style="font-weight:normal;cursor: pointer;margin-left: 10px;">
                                                    <input type="radio" name="status" value="2" >  下架
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">手术医生</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="fr-doctor-id" style="height: 36px !important;">
                                                <option value="">请选择医生</option>
                                                <?php foreach($doctorOrHospitalList['doctor'] as $vo): if((count($info['goods_info']) > 0 && $vo['doctor_id'] == $info['goods_info']['doctor_id'])): ?>
                                                <option value="<?php echo htmlentities($vo['doctor_id']); ?>" selected ><?php echo htmlentities($vo['real_name']); ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo htmlentities($vo['doctor_id']); ?>" ><?php echo htmlentities($vo['real_name']); ?></option>
                                                <?php endif; endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">手术医院</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="fr-hospital-id" style="height: 36px !important;">
                                                <option value="">请选择医院</option>
                                                <?php foreach($doctorOrHospitalList['hospital'] as $vo): if((count($info['goods_info']) > 0 && $vo['hospital_id'] == $info['goods_info']['hospital_id'])): ?>
                                                <option value="<?php echo htmlentities($vo['hospital_id']); ?>" selected ><?php echo htmlentities($vo['hospital_name']); ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo htmlentities($vo['hospital_id']); ?>"><?php echo htmlentities($vo['hospital_name']); ?></option>
                                                <?php endif; endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">商品图片</label>
                                        <div class="col-sm-10">
                                            <div style="position: relative;cursor: pointer">
                                                <div class="layui-btn layui-btn-sm layui-btn-normal" style="position: absolute;top: 0;z-index: 1;">
                                                    <i class="layui-icon layui-icon-upload-drag"></i>商品图片
                                                </div>
                                                <input type="file" name="goodsFile" style="position: absolute;top: 0;z-index: 2;width: 87px;opacity: 0;"  id="fr-upload-goodsimg"  />
                                            </div>

                                            <div class="layui-inline layui-word-aux" style="margin-left: 100px;padding-top: 5px;top: 5px;">
                                                每张图片最大限制在5M以内，最多可添加6张<span style="color: #ec7f7f">(商品图片建议1:1比例的图片)</span>
                                            </div>

                                            <div id="from-img-box">
                                                <?php if((count($info['goods_imgs']) > 0)): foreach($info['goods_imgs'] as $val): ?>
                                                <div class="from-img-divs">
                                                    <img src="<?php echo htmlentities($val['img']); ?>" data-goodimgid="<?php echo htmlentities($val['id']); ?>"  class="fr-imgs-val" >
                                                    <div class="icon-i">
                                                        <i class="layui-icon layui-icon-left fr-move-left" title="左移动"></i>
                                                        <i class="layui-icon layui-icon-close fr-move-close" title="删除"></i>
                                                        <i class="layui-icon layui-icon-right fr-move-right" title="右移动"></i>
                                                    </div>
                                                </div>
                                                <?php endforeach; endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer clearfix" style="padding-left: 146px;">
                                        <button class="btn btn-info " type="button"  onclick="objClass.releaseGoods()" ><i class="fa fa-paste"></i> 发布商品</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane ">
                        <div class="panel-body">
                            <textarea id="editor_id" name="content" style="width:99% !important;height:300px;background: white;"><?php echo !empty($info['goods_info']['content']) ? htmlentities($info['goods_info']['content']) : ''; ?></textarea>
                            <div class="box-footer clearfix" style="padding-left: 0px;padding-top: 20px;">
                                <button class="btn btn-info " type="button"  onclick="objClass.releaseGoods()" ><i class="fa fa-paste"></i> 发布商品</button>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane ">
                        <div class="panel-body">
                            <form class="form-horizontal " onsubmit="return false;" id="fr-instructions">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">购买有效期</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" placeholder="有效期多少天"  id="fr-buy_deadline" value="<?php echo !empty($info['goods_info']['buy_deadline']) ? htmlentities($info['goods_info']['buy_deadline']) : ''; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="layui-form-mid layui-word-aux">商品购买日起 <span id="cus-day">xxx</span> 内有效, <font color="red">0代表永久有效</font></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">预约信息</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="提示信息  (例如：请您提前1天预约)" id="fr-buy-notice"  value="<?php echo !empty($info['goods_info']['notice']) ? htmlentities($info['goods_info']['notice']) : ''; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">使用时间段</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="layui-input" id="fr-time-slot" placeholder="开始时间 - 结束时间"  value="<?php echo !empty($info['goods_info']['time_slot']) ? htmlentities($info['goods_info']['time_slot']) : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label  class="col-sm-1 control-label">购买流程</label>
                                        <div class="col-sm-6">
                                            <div class="layui-form-mid layui-word-aux">购买流程详细信息 </div>
                                            <div class="layui-form-mid layui-word-aux" style="display: inline-block;float: right">
                                                <a class="btn btn-default btn-flat btn-xs" onclick="tabObj.addTr()">添加一栏</a>
                                            </div>
                                            <table class="table" id="process-hint-table">
                                                <tbody>
                                                <?php if((isset($info['goods_info']['buyflow']))): foreach($info['goods_info']['buyflow'] as $k=>$text): ?>
                                                <tr>
                                                    <td width="10" align="center" valign="middle"><p class="tab-number"><?php echo htmlentities($k+1); ?>.</p></td>
                                                    <td><input type="text" class="form-control" value="<?php echo htmlentities($text); ?>"></td>
                                                    <td width="10"><p ><i class="fa fa-fw fa-trash-o" ></i></p></td>
                                                </tr>
                                                <?php endforeach; else: ?>
                                                <tr>
                                                    <td width="10" align="center" valign="middle"><p class="tab-number">1.</p></td>
                                                    <td><input type="text" class="form-control" value=""></td>
                                                    <td width="10"><p ><i class="fa fa-fw fa-trash-o" ></i></p></td>
                                                </tr>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="box-footer clearfix" style="padding-left: 146px;">
                                        <button class="btn btn-info " type="button"  onclick="objClass.releaseGoods()" ><i class="fa fa-paste"></i> 发布商品</button>
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

<script id="demo" type="text/html">
    <div style="min-width: 700px;min-height: 100px;" id="categoryList">
        <div class="layui-row layui-col-space1">
            <table class="table table-bordered">
                <tbody>
                <tr id="cus-category-tr-1">
                    <th width="50" >类别</th><td id="cus-category-1"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</script>



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

<script type="text/javascript" src="/static/plugin/layui/layui.all.js"></script>
<script charset="utf-8" src="/static/plugin/kindeditor/kindeditor-all.js"></script>
<script charset="utf-8" src="/static/plugin/kindeditor/lang/zh-CN.js"></script>
<script type="text/javascript">
    KindEditor.ready(function (K) {
        // https://blog.csdn.net/qxl2012/article/details/78052128
        K.allowImageRemote = false;
        window.editor = K.create('#editor_id', {
            width : '800px',
            height:'600px',
            resizeType:1,
            cssPath: '/static/plugin/kindeditor/plugins/code/prettify.css',
            resizeMode : 1,
            items : [
                'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
                'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|',
                'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'pagebreak',
                'anchor', 'link', 'unlink'
            ],
            uploadJson: '/seller/index/editUploadImgFile',
            allowFileManager: false,
            allowImageRemote:true,
            syncType:'auto',
            afterCreate: function () {
                var self = this;
                self.sync();
            }
        });

        window.editor.sync();
    });

    $(document).on('focus','#remoteUrl',function(){
        $(this).prop("readonly","readonly");
        $(this).parent().hide();
    });

    //时间范围
    layui.laydate.render({elem: '#fr-time-slot',type: 'time',range: true});

    var objClass = {
        uploadLoading:false,
        categoryList:[],
        loading:false,
        uploadGoodsImg:function(formData){
            if(this.uploadLoading == false){
                $.ajax({
                    url: '/seller/shopApi/uploadGoodImg',
                    type: 'POST',
                    cache: false,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend:function(){
                        objClass.uploadLoading = true;

                        var html = '<div class="from-img-divs" style="background-color: #f2f2f2;" id="from-img-uploadimg">' +
                            '<p align="center" style="margin-top: 30px;">' +
                            '<i class="layui-icon layui-icon-loading layui-icon layui-anim layui-anim-rotate layui-anim-loop" style="font-size: 20px;"></i>' +
                            '</p >' +
                            '<br />' +
                            '<p align="center" style="color: #CCCCCC">上传中...</p>' +
                            '</div>';

                        $('#from-img-box').append(html);
                    },
                    complete:function(){
                        objClass.uploadLoading = false;
                        $('#from-img-uploadimg').remove();
                    },
                    success: function (res) {
                        if(res.code == 200){
                            var html = '<div class="from-img-divs">' +
                                '<img src="'+res.data.img+'" data-goodimgid="'+res.data.img_id+'"  class="fr-imgs-val" >' +
                                '<div class="icon-i">' +
                                '<i class="layui-icon layui-icon-left fr-move-left" title="左移动"></i>' +
                                '<i class="layui-icon layui-icon-close fr-move-close" title="删除"></i>' +
                                '<i class="layui-icon layui-icon-right fr-move-right" title="右移动"></i>' +
                                '</div>' +
                                '</div>';
                            $('#from-img-box').append(html);
                        }else{
                            layer.msg(res.msg);
                            $('#fr-upload-goodsimg').val('');
                        }
                    }
                });
            }
        },
        tdMove:function(flag,obj){
            if(this.uploadLoading){
                return false;
            }

            var div = $(obj).parent().parent(); //获取到触发的tr
            if(flag =="left"){    //向上移动
                if($(div).prev().html()==null){ //获取tr的前一个相同等级的元素是否为空
                    return false;
                }else {
                    $(div).insertBefore($(div).prev()); //将本身插入到目标tr的前面
                }
            }else if(flag == 'right'){
                if($(div).next().html()==null){
                    return false;
                }else {
                    $(div).insertAfter($(div).next()); //将本身插入到目标tr的后面
                }
            }
        },
        releaseGoods:function(){
            window.editor.sync();
            var data = {
                name                :$.trim($('#fr-good-name').val()),
                search_keyword      :$.trim($('#fr-search-words').val()),
                category            :$('#fr-category').val(),
                market_price        :$('#fr-market_price').val(),
                sell_price          :$('#fr-sell_price').val(),
                prepay_price        :$('#fr-prepay_price').val(),
                topay_price         :$('#fr-topay_price').val(),
                store_nums          :$('#fr-store_nums').val(),
                status              :$('input[name="status"]:checked').val(),
                doctor_id           :$('#fr-doctor-id').val(),
                hospital_id         :$('#fr-hospital-id').val(),
                img_ids             :'',
                content             :$('#editor_id').val(),
                buy_deadline        :$('#buy_deadline').val(),
                notice              :$.trim($('#fr-buy-notice').val()),
                buyflow             :tabObj.getInputVal(),
                time_slot           :$.trim($('#fr-time-slot').val()),
                goods_id            :$('#fr-gooid_id').val()
            };

            var img_num = 0;
            $.each($('.fr-imgs-val'),function(k,v){
                data.img_ids +=  ','+ $('.fr-imgs-val')[k].dataset.goodimgid;img_num++;
            });

            if(data.name == '') {
                parent.toastr.info( '商品名称不能为空!','温馨提示: ');
            }else if(data.category == ''){
                parent.toastr.info( '请选择商品所在分类!','温馨提示: ');
            }else if(data.market_price == ''){
                parent.toastr.info( '市场价格不能为空!','温馨提示: ');
            }else if(data.prepay_price == ''){
                parent.toastr.info( '预付价格不能为空!','温馨提示: ');
            }else if(data.topay_price == ''){
                parent.toastr.info( '到付价格不能为空!','温馨提示: ');
            }else if(data.store_nums == ''){
                parent.toastr.info( '预约名额不能为空!','温馨提示: ');
            }else if(data.doctor_id == ''){
                parent.toastr.info( '请选择手术医生!','温馨提示: ');
            }else if(data.hospital_id == ''){
                parent.toastr.info( '请选择手术医院!','温馨提示: ');
            }else if(img_num == 0){
                parent.toastr.info( '请上传商品预览图片!','温馨提示: ');
            }else if(data.buy_deadline == ''){
                $('.nav-tabs > li').eq(3).trigger('click');
                parent.toastr.info( '请填写商品购买有效期!','温馨提示: ');
            }else if(data.notice == ''){
                $('.nav-tabs > li').eq(3).trigger('click');
                parent.toastr.info( '请填写预约提示信息!','温馨提示: ');
            }else if(data.time_slot == ''){
                $('.nav-tabs > li').eq(3).trigger('click');
                parent.toastr.info( '商品使用时间段不能为空!','温馨提示: ');
            }else if(data.buyflow == ''){
                $('.nav-tabs > li').eq(3).trigger('click');
                parent.toastr.info( '商品购买流程不能有空!','温馨提示: ');
            }else if(objClass.loading == false){
                var loading = layer.msg('提交中，请稍等...', {icon: 16,shade: 0.01,time:0});
                $.ajax({
                    url: '/seller/shopApi/releaseGoods',
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
                                window.location.href = '/seller/shop/index'
                            },2000)
                        }else{
                            layer.msg(res.msg);
                        }
                    }
                });
            }
        },
        choiceCategory:function(){
            var index = layer.open({
                type: 1,
                title:'选择分类',
                area: ['800px', '400px'],
                skin: 'layui-layer-rim', //加上边框
                content: demo.innerHTML
                ,btn: ['添加', '取消'],
                yes:function(){
                    $('#categoryList-select').html('');

                    $('#fr-category').val($('.select').data('id'));
                    $('#categoryList-select').append('<span class="layui-badge layui-bg-blue" data-id="'+ $('.select').data('id') +'" >'+ $('.select').text() +'</span>');

                    layer.close(index);
                }
            });

            this.ajaxLloadingCategory(1,0);
        },
        ajaxLloadingCategory:function(hierarchy,pid){
            $.ajax({
                url: '/seller/shopApi/getCategoryList',
                type: 'POST',
                data:{category_id:pid},
                dataType: "json",
                success: function (res) {
                    if(res.code == 200){
                        var hierarchy2 = parseInt(hierarchy) + 1;
                        $.each(res.data.rows,function(k,v){
                            $('#cus-category-'+hierarchy).append('<span class="layui-badge layui-bg-gray click-find-category" data-findid="'+ hierarchy2 +'"  data-pid="'+ v.id+'"  data-id="'+ v.id +'">'+ v.name +'</span>');
                        });
                    }
                }
            });
        },
    };

    $(document).on('click','.click-find-category',function(){
        $(this).addClass('select').siblings().removeClass('select');
    });

    $('#fr-upload-goodsimg').on('change',function(){
        var formData = new FormData($('#fr-goods')[0]);
        objClass.uploadGoodsImg(formData);
    });

    $('#from-img-divs').on('from-img-divs');

    $(document).on('click','.fr-move-left',function(){
        objClass.tdMove('left',$(this));
    }).on('click','.fr-move-close',function(){
        var _this = $(this);
        var index = layer.confirm('您确定要删除图片吗？', {
            btn: ['删除','取消'] //按钮
        }, function(){
            _this.parent().parent().remove()
            layer.close(index);
        });
    }).on('click','.fr-move-right',function(){
        objClass.tdMove('right',$(this));
    });

    $(document).on('mouseover','#process-hint-table tr',function(){
        $(this).find('i').show();
    }).on('mouseout','#process-hint-table tr',function(){
        $(this).find('i').hide();
    }).on('click','#process-hint-table tr td p i ',function(){
        tabObj.removeTr($(this));
    });

    var tabObj = {
        addTr:function(){
            var l = $('#process-hint-table > tbody > tr').length + 1;
            $('#process-hint-table > tbody').append('<tr><td width="10" align="center" valign="middle"><p class="tab-number">'+ l +'.</p></td><td><input type="text" class="form-control" ></td><td width="10"><p ><i class="fa fa-fw fa-trash-o" ></i></p></td></tr>');
        },
        removeTr:function(o){
            var val = $.trim(o.parent().parent().parent().find('input').val());
            if(val != ''){
                var index = layer.confirm('您确定要删除这条信息吗？', {
                    title:'温馨提示',
                    btn: ['确定','取消'] //按钮
                }, function(){
                    o.parent().parent().parent().remove();
                    layer.close(index);
                    tabObj.sort();
                });
            }else{
                o.parent().parent().parent().remove();
                tabObj.sort();
            }
        },
        sort:function(){
            $.each($('#process-hint-table > tbody > tr'),function(k,v){
                var text = parseInt(k +1);
                $('#process-hint-table > tbody > tr').eq(k).find('.tab-number').text(text + '.')
            });
        },
        getInputVal:function(){
            var num = 0,data = [];
            $.each($('#process-hint-table > tbody > tr'),function(k,v){
                num++;
                var val = $('#process-hint-table > tbody > tr').eq(k).find('input').val();

                if($.trim(val) == ''){return true;}
                data[k] = val;
            });

            if(num != data.length){
                return false;
            }

            return data;
        }
    };

    $('#fr-prepay_price').on('input',function(){
        var val = $(this).val();
        if(val != ''){
            if(parseFloat(val) < parseFloat($('#fr-sell_price').val())){
                var s = parseFloat($('#fr-sell_price').val()) - parseFloat(val);
                $('#fr-topay_price').val(s);
            }else if(parseFloat(val) >= parseFloat($('#fr-sell_price').val())){
                $('#fr-topay_price').val('0.00');
                if(parseFloat(val) > parseFloat($('#fr-sell_price').val())){
                    // layer.msg('预约价格不能大于销售价格');
                    layer.msg('预约价格不能大于销售价格', {icon: 5});
                }
            }
        }else{
            $('#fr-topay_price').val($('#fr-sell_price').val());
        }
    }).on('change',function(){
        if($(this).val() == ''){
            $(this).val('0.00');
        }else{
            $(this).val(parseFloat($(this).val()));
            var val = $(this).val();
            if(parseFloat(val) < parseFloat($('#fr-sell_price').val())){
                var s = parseFloat($('#fr-sell_price').val()) - parseFloat(val);
                $('#fr-topay_price').val(s);
            }else if(parseFloat(val) >= parseFloat($('#fr-sell_price').val())){
                $('#fr-topay_price').val('0.00');
                if(parseFloat(val) > parseFloat($('#fr-sell_price').val())){
                    // layer.msg('预约价格不能大于销售价格');
                    layer.msg('预约价格不能大于销售价格', {icon: 5});
                }
            }
        }
    });

    $('#fr-sell_price').on('input',function(){
        $('#fr-prepay_price').val('');
        $('#fr-topay_price').val('');
    });

    function checkDecimal(obj) {
        var temp = /^\d+\.?\d{0,15}$/;
        if (temp.test(obj.value)) {
            var temp2 = /^\d+\.?\d{0,2}$/;
            if(!temp2.test(obj.value)){
                obj.value = obj.value.substr(0, obj.value.length - 1);
            }
        } else {
            obj.value = '';
        }
    }
</script>

</body>
</html>
