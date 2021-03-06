<?php /*a:1:{s:87:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\article\article_release.html";i:1546391587;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo config('conf.title'); ?> - 发表文章</title>
    <link rel="stylesheet" href="/static/web/css/relrase.css">
    <link rel="stylesheet" href="/static/web/css/test.css">
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/web/css/graphic.css">
    <style>
        #remoteUrl {
            ime-mode: disabled !important;
            background-color: #cccccc;
        }
        .wl-zh1 {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0px;
            background-color: rgba(0, 0, 0, .7);
            z-index: 99999;
        }
        .wl-z1 {
            width: 145px;
            height: 100px;
            margin: 0 auto;
            position: fixed;
            top: 37%;
            border-radius: 20px;
            right: 0;
            left: 0;
            bottom: 0px;
        }
        #ttttt{width: 138px;height: 138px;border:2px dashed #cdcdcd; border-radius: 25px;float: left;position: relative;}
        .cus-remove-img-list{width: 138px;height: 138px;border: 2px dashed #cdcdcd;float: left;margin-left: 10px;border-radius: 25px;position: relative}
        .cus-remove-img-list > img{border-radius: 25px;margin: 7px 0 0 7px;}
        .cus-remove-img-list .cus-remove-img{width:50px;height:50px;color: red;font-size: 30px;z-index: 9999;position: absolute;top: -11px;right: -28px;cursor: pointer}
    </style>
</head>
<body style="background: #F8F8F8">
<div class="wl-con">
    <div class="wl-top">
        <div style="position:relative;width:1265px;margin:0 auto;top:20px;left: 10px">
            <img src="/static/web/image/logo1.png" alt="">
        </div>
    </div>
    <div class="wl-zhanghao-box"
         style="position:relative;width:1265px;margin:0 auto;top:-80px;right: 42px;cursor: pointer">
        <div class="wl-zhanghao" style="right:0;">
            <p style="height: 80px;padding-top: 9px; background: #7DB0E8;" class="wl-xian">
                <img src="<?php echo htmlentities($user_info['portrait']); ?>" class="wl-toux" onerror="this.src='/static/web/image/tou.png'"/>
                <span style="color: white;margin-left: 48px;float: left;margin-top: -1px;"><?php echo htmlentities($user_info['nickname']); ?></span><i
                    class="iconfont icon-triangledownfill" style="color: white;"></i>
            </p>
            <div class="wl-cang" style="display: none">
                <a href="/index/user/main"><p class="wl-xiany" id="wl-anquan"><i class="iconfont icon-shezhi"
                                                                                 style="font-size: 22px;margin-right: 10px"></i>账号设置
                </p></a>
                <p class="wl-xiany" onclick="redream.href('/index/user/signOut')"><i class="iconfont icon-guanbi"
                                                                                     style="font-size: 18px;margin-right: 10px"></i>退出登录
                </p>
            </div>
        </div>
    </div>

    <div class="wl-tabc" style="width: 100%">
        <div class="tab-box" style="position: relative">
            <div class="wl-nide">
                <ul class="wl-top-liebiao">
                    <li class="wl-yingj"><i class="iconfont icon-quanbu2 wl-biao" style="font-size: 25px;"></i>文章列表<i
                            class="iconfont icon-triangleupfill wl-xiala qiehuan" style="font-size: 20px;top: 0;"></i>
                    </li>
                    <div class="wl-ding">
                        <a href="/index/article/article">
                            <li class="action">发表文章</li>
                        </a>
                        <a href="/index/article/graphic">
                            <li>我的文章</li>
                        </a>
                    </div>
                </ul>
                <ul class="wl-top-liebiao" style="margin-top: 10px">
                    <a href="/index/shop/index">
                        <li class=""><i class="iconfont icon-quanbu2 wl-biao" style="font-size: 25px;"></i>分销商品<i
                                class="iconfont icon-triangledownfill wl-xiala " style="font-size: 20px;top: 0;"></i>
                        </li>
                    </a>
                    <div class="wl-ding">
                        <!--<a href="/index/article/articleLists"><li>推荐文章 </li></a>-->
                        <!--<a href="/index/article/recommend"><li >我的推荐</li></a>-->
                    </div>
                </ul>
                <a href="/index/user/certification">
                    <div class="wl-shiming"><i class="iconfont icon-medal_light wl-biao" style="font-size: 25px;"></i>实名认证<i
                            class="iconfont icon-triangledownfill wl-xiala" style="font-size: 20px;top: 0;"></i></div>
                </a>
                <a href="/seller/index">
                    <div class="wl-shiming" style="margin-top: 10px">
                        <i class="iconfont icon-wodexingqiu_shoucangdeshangpin wl-biao" style="font-size: 25px;"></i>商户管理
                    </div>
                </a>
            </div>
            <div class="wl-fabu">
                <p>发表文章</p>
                <input type="hidden" id="fr-id" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['id']) : 0; ?>">
                <input type="hidden" id="fr-draft" value="<?php echo $articleInfo && $articleInfo['status']==2 ? 1 : 0; ?>">
                <div style="height: 60px;line-height: 60px;padding-left: 10px;margin-top: 20px">
                    <div style="float: left;width: 7%;margin-left: 52px;"> 标 题</div>
                    <div style="float: left;width: 87%;"><input type="text" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['title']) : ''; ?>" id="fr-title" placeholder="请输入文章标题" style="width: 93%;height: 36px;text-indent: 10px"></div>
                </div>
                <div style="clear: both;height: 60px;line-height: 60px;padding-left: 10px;">
                    <div style="float: left;width: 7%; margin-left: 52px;"> 摘 要</div>
                    <div style="float: left;width: 87%;"><input type="text" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['excerpt']) : ''; ?>" id="fr-zaiyao" placeholder="请输入文章摘要" style="width: 93%;height: 36px;text-indent: 10px"></div>
                </div>
                <div style="clear: both;min-height: 60px;line-height: 60px;padding-left: 10px;">
                    <div style="float: left;width: 7%;margin-left: 52px;"> 标 签</div>
                    <div style="float: left;width: 87%;">
                        <input type="text" value="<?php echo !empty($articleInfo) ? htmlentities($articleInfo['tag']) : ''; ?>" id="fr-tag" placeholder="文章标签 例如(xxx,xxx,xxx) 请用英文逗号',' 分割,标签有利于文章之间的关联" style="width: 93%;height: 36px;text-indent: 10px">
                    </div>
                </div>
                <div style="clear: both;padding-left: 10px;">
                    <div style="float: left;width: 90%;margin-top: 35px; margin-left: 44px;">
                        <textarea id="editor_id" name="content" style="width:99% !important;height:300px;background: white;"><?php echo $articleInfo?$articleInfo['content']:''; ?></textarea>
                    </div>
                </div>
                <div style="clear: both;min-height: 200px;padding-left: 10px;padding-top: 38px;position: relative">
                    <div style="float: left;width: 87%;margin-left: 47px;" id="ccc">
                        <div id="ttttt">
                            <dl style="position: absolute;width: 134px;height: 134px;cursor: pointer;top: 23px;left: 28px;">
                                <dd class="iconfont icon-xiangji" style="font-size: 50px;color:#cdcdcd;margin-left: 13px;z-index: 2"></dd>
                                <dt style="color: #cdcdcd;margin-right: 10px;cursor: pointer">添加缩略图</dt>
                            </dl>
                            <form id="infoLogoForm" enctype='multipart/form-data'>
                                <input type="file" name="imgFile" accept="image/*" id="btn-input-file" style="width: 134px;height: 134px;opacity: 0;z-index: 3;cursor: pointer"/>
                            </form>
                        </div>

                        <?php if(($articleInfo && count($articleInfo['thumbnail']) > 0)): foreach($articleInfo['thumbnail'] as $src): ?>
                                <div class="cus-remove-img-list">
                                    <img src="<?php echo htmlentities($src); ?>" class="cus-fr-images" width="120" height="120">
                                    <span class="iconfont icon-roundclosefill cus-remove-img"></span>
                                </div>
                            <?php endforeach; endif; ?>
                    </div>
                    <p style="position: absolute;top: 190px;left: 58px;color: #a1a1a1;font-size: 12px;"><font color="red">注</font>：缩略图最多只能上传三张</p>
                </div>

                <div style="position: relative;width: 100%;min-height: 155px">
                    <div style=";width:100%;height: 100px;border-top: 1px solid #EEEEEE;position: absolute;bottom: 10px">
                        <?php if((!$articleInfo || ($articleInfo && $articleInfo['status'] == 2))): ?>
                            <button onclick="objClass.submit(2)" class="wl-tijiao wl-baozun" >
                                保存草稿
                            </button>
                        <?php endif; ?>
                        <button onclick="objClass.submit(1)" class="wl-tijiao">
                            发表文章
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <footer class="wl-foot" style="bottom: -125px"><?php echo config('conf.copyright'); ?></footer>
    </div>
    <div class="wl-zh1" id="wl-loading-box" style="display: none">
        <div class="wl-z1">
            <dl>
                <img src="/static/image/user/timg.gif" alt="" width="60px" style="margin: 0 auto;position: absolute;left: -10px;right: 0;">
            </dl>
            <dt style="text-align: center;color: white;font-size: 25px;position: absolute;left: 0;right: 0;top: 80px;">上传中...</dt>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script charset="utf-8" src="/static/plugin/kindeditor/kindeditor-all.js"></script>
<script charset="utf-8" src="/static/plugin/kindeditor/lang/zh-CN.js"></script>
<script>
    KindEditor.ready(function (K) {
        // https://blog.csdn.net/qxl2012/article/details/78052128
        K.allowImageRemote = false;
        window.editor = K.create('#editor_id', {
            cssPath: '/static/plugin/kindeditor/plugins/code/prettify.css',
            resizeMode: 1,
            items: [
                'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'cut', 'copy', '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|',
                'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image',  'hr',
                'anchor', 'link', 'unlink'
            ],
            uploadJson: '/index/upload/editUploadImgFile',
            allowFileManager: false,
            allowImageRemote: true,
            syncType: 'auto',
            afterCreate: function () {
                var self = this;
                self.sync();
            }
        });

        window.editor.sync();
    });

    $(document).on('focus', '#remoteUrl', function () {
        $(this).prop("readonly", "readonly");
        $(this).parent().hide();
    });

    var objClass = {
        loading: false,
        loading2: false,
        getData:function(flag){
            window.editor.sync();
            var imgArr = [];
            $.each($('.cus-fr-images'), function (key, val) {
                imgArr.push(val.src);
            });

            return {
                article_id:$('#fr-id').val(),
                flag:flag,
                title: $.trim($('#fr-title').val()),
                tag: $('#fr-tag').val(),
                content: $.trim($('#editor_id').val()),
                excerpt: $('#fr-zaiyao').val(),
                thumbnail_img: imgArr,
                isdraft:$('#fr-draft').val(),
            };
        },
        submit: function (flag) {
            var data = this.getData(flag);
            if (data.title == '') {
                alert('标题不能为空');
            }else if (!this.loading) {
                $.ajax({
                    url: "/index/article/releaseArticle",
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        objClass.loading = true;
                    },
                    complete: function () {
                        objClass.loading = false;
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            alert('发布成功');
                            window.location.href = '/index/article/graphic';
                        } else {
                            alert(res.msg);
                        }
                    }
                });
            }
        },
    };

    $("#btn-input-file").on("change", function () {
        if (objClass.loading2) {
            return false;
        }

        var formData = new FormData($('#infoLogoForm')[0]);
        formData.append('type', 5);
        $.ajax({
            url: '/index/upload/uploadImgFile',
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                objClass.loading2 = true;
                $(".wl-zh1").show();
            },
            complete: function () {
                objClass.loading2 = false;
                $(".wl-zh1").hide();
            },
            success: function (data) {
                if (data.code == 200) {
                    $('#ccc').append('<div  class="cus-remove-img-list"><img src="' + data.data.url + '" class="cus-fr-images" width="120" height="120" ><span class="iconfont icon-roundclosefill cus-remove-img" ></span></div>');
                    if ($('.cus-fr-images').length >= 3) {
                        $('#btn-input-file').prop('disabled', true);
                    }
                } else {
                    alert(data.msg);
                }
            }
        });
    });

    $(".wl-xian").click(function () {
        $(".wl-cang").toggle();
    });

    $(".wl-shimin").click(function () {
        $(".wl-cang1").toggle();
    });

    $(".wl-tabc").click(function () {
        $(".wl-cang").hide();
    });

    $(document).on('click', '.cus-remove-img', function () {
        $(this).parent().remove();
        $('#btn-input-file').prop('disabled', false);
    });

    $(".wl-yingj").click(function () {
        $(".wl-ding").toggle();
        $(".qiehuan").toggleClass('iconfont  icon-triangledownfill');
        $(".qiehuan").toggleClass('iconfont icon-triangleupfill');
    });
</script>
</html>