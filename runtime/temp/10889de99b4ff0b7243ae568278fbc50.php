<?php /*a:1:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\article\test.html";i:1541727405;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/pc/css/relrase.css">
    <link rel="stylesheet" href="/pc/css/test.css">
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <style>
        #remoteUrl{ime-mode: disabled !important;background-color: #cccccc;}
    </style>
</head>
<body style="background: #F8F8F8">
<div class="wl-con" >
    <div class="wl-top">
        <div style="position:relative;width:1265px;margin:0 auto;top:17px;left: 10px">
            <img src="/pc/image/logo1.png" alt="">
        </div>
    </div>
    <div class="wl-zhanghao-box"
         style="position:relative;width:1265px;margin:0 auto;top:-80px;right: 42px;cursor: pointer">
        <div class="wl-zhanghao" style="right:0;">
            <p style="height: 80px;padding-top: 9px; background: #7DB0E8;" class="wl-xian"><span class="wl-toux"></span><span
                    style="color: white;margin-left: 48px;float: left;margin-top: -1px;">用户名称</span><i
                    class="iconfont icon-triangledownfill" style="color: white;"></i></p>
            <div class="wl-cang" style="display: none">
                <p class="wl-xiany" id="wl-anquan" onclick="redream.href('/index/user/main')"><i
                        class="iconfont icon-shezhi" style="font-size: 22px;margin-right: 10px"></i>账号设置</p>
                <p class="wl-xiany"><i class="iconfont icon-guanbi" style="font-size: 18px;margin-right: 10px"></i>退出登录
                </p>
            </div>
        </div>
    </div>
    <div class="tab-box" style="position: relative">
        <div class="wl-fabiao3" style="cursor: pointer">发表文章</div>
        <ul class="renzheng">
            <div class="wl-xian1" onclick="redream.href('/index/user/certification')">
                <span class="wl-renzhengs"><i class="iconfont icon-medal_light wl-xz"
                   style="font-size: 30px"></i>实名认证</span></i>
            </div>

        </ul>
        <div class="wl-fabu">
            <p>发表文章</p>
            <div style="height: 60px;line-height: 60px;padding-left: 10px;margin-top: 20px">
                <div style="float: left;width: 7%;margin-left: 52px;"> 标题</div>
                <div style="float: left;width: 87%;"><input type="text" value="" id="fr-title" placeholder="请输入文章标题"
                                                            style="width: 93%;height: 36px;text-indent: 10px"></div>
            </div>
            <div style="clear: both;height: 60px;line-height: 60px;padding-left: 10px;">
                <div style="float: left;width: 7%; margin-left: 52px;"> 摘要</div>
                <div style="float: left;width: 87%;"><input type="text" value="" id="fr-zaiyao" placeholder="请输入文章摘要"
                                                            style="width: 93%;height: 36px;text-indent: 10px"></div>
            </div>
            <div style="clear: both;height: 60px;line-height: 60px;padding-left: 10px;">
                <div style="float: left;width: 7%;margin-left: 52px;"> 标签</div>
                <div style="float: left;width: 87%;"><input type="text" value="" id="fr-tag" placeholder="请输入文章标签"
                                                            style="width: 93%;height: 36px;text-indent: 10px"></div>
            </div>

            <div style="clear: both;padding-left: 10px;">
                <div style="float: left;width: 90%;margin-top: 35px; margin-left: 44px;">
                    <textarea id="editor_id" name="content" style="width:99% !important;height:300px;background: white;resize:none"></textarea>
                </div>
            </div>
            <div style="clear: both;min-height: 200px;padding-left: 10px;padding-top: 38px;position: relative">
                <div style="float: left;width: 87%;margin-left: 47px;" id="ccc">
                    <div style="width: 138px;height: 138px;border:2px dashed #cdcdcd; border-radius: 25px;float: left;position: relative;"  id="ttttt">
                        <dl style="position: absolute;width: 134px;height: 134px;cursor: pointer;top: 23px;left: 29px;">
                            <!--padding-left: 30px;padding-top: 20px;-->
                            <dd class="iconfont icon-xiangji" style="font-size: 50px;color:#cdcdcd;margin-left: 8px;z-index: 2"></dd>
                            <dt style="color: #cdcdcd;margin-right: 10px;cursor: pointer">添加缩略图</dt>
                        </dl>
                        <form id="infoLogoForm" enctype='multipart/form-data'>
                            <input type="file" name="img" accept="image/*" id="btn-input-file"  style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"/>
                        </form>
                    </div>
                </div>
            </div>

            <div style="height: 100px;border-top: 1px solid #EEEEEE">
                <button onclick="objClass.submit()" class="wl-tijiao" style="cursor: pointer">发表</button>
            </div>
        </div>

    </div>
</div>

</body>
<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script charset="utf-8" src="/static/plugin/kindeditor/kindeditor-all.js"></script>
<script charset="utf-8" src="/static/plugin/kindeditor/lang/zh-CN.js"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script>
    KindEditor.ready(function (K) {
        // https://blog.csdn.net/qxl2012/article/details/78052128
        K.allowImageRemote = false;
        window.editor = K.create('#editor_id', {
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
            uploadJson: '/index/upload/uploadfile',
            allowFileManager: false,
            allowImageRemote:true,
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

    var objClass = {
        loading: false,
        submit: function () {
            window.editor.sync();
            var content = $.trim($('#editor_id').val());
            var title = $.trim($('#fr-title').val());
            var zaiyao = $('#fr-zaiyao').val();
            var tag = $('#fr-tag').val();

            if (title == '') {
                alert('标题不能为空');
                return false;
            }

            if (this.loading) {
                return false;
            }

            $.ajax({
                url: "/index/article/releaseArticle",
                type: 'post',
                data: {title: title, tag: tag, centent: content, excerpt: zaiyao},
                dataType: 'json',
                beforeSend: function () {
                    objClass.oneLoading = true;
                },
                complete: function () {
                    objClass.oneLoading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        alert('发布成功');
                        $('#editor_id').val('');
                        $('#fr-title').val('');
                        $('#fr-zaiyao').val('');
                        $('#fr-tag').val('');
                        window.editor.html('');
                    }
                }
            });

        }
    };


    $("#btn-input-file").on("change", function () {
        $.ajax({
            url: '/index/article/uploadThumbnailImg',
            type: 'POST',
            cache: false,
            data: new FormData($('#infoLogoForm')[0]),
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {

            },
            success: function (data) {
                if (data.code == 200) {
                    var html = '<div style="width: 138px;height: 138px;border: 2px dashed #cdcdcd;float: left;margin-left: 10px;border-radius: 25px">' +
                        '<img src="' + data.data.image_url + '" alt="" width="120" height="120" style="border-radius: 25px;margin: 7px 0 0 7px">'+'<span class="iconfont icon-roundclosefill" style="width:50px;height:50px;color: red;font-size: 30px;z-index: 9999"></span>'+'</div>';
                    $('#ccc').append(html);
                }
            }
        });
    });
</script>
<script type="text/javascript">

    $(".tab-box li").each(function (index) {
        $(this).click(function () {
            $("li.active").removeClass("active"); //注意这里
            $(this).addClass("active");
            $(".tab-content div.active-txt").removeClass("active-txt");
            $(".tab-content div").eq(index).addClass("active-txt");
        });
    });
    $(".wl-xian").click(function () {
        $(".wl-cang").toggle();
    })

    $(".wl-shimin").click(function () {
        $(".wl-cang1").toggle();
    })




</script>
</html>