var E = window.wangEditor;
var editor = new E('#wang-editor');
editor.customConfig.uploadImgServer = '/index/upload/uploadFile';
editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024;
editor.customConfig.uploadImgMaxLength = 3;
editor.customConfig.showLinkImg = false;
editor.customConfig.menus = [
    'head',  // 标题
    'bold',  // 粗体
    'fontSize',  // 字号
    'fontName',  // 字体
    'italic',  // 斜体
    'underline',  // 下划线
    'strikeThrough',  // 删除线
    'foreColor',  // 文字颜色
    'backColor',  // 背景颜色
    'link',  // 插入链接
    'list',  // 列表
    'justify',  // 对齐方式
    'quote',  // 引用
    'image',  // 插入图片
    'table',  // 表格
    'undo',  // 撤销
    'redo'  // 重复
];
editor.create();


var objClass = {
    loading: false,
    loading2: false,
    getData:function(flag){
        var imgArr = [];
        $.each($('.cus-fr-images'), function (key, val) {
            imgArr.push(val.src);
        });

        return {
            article_id:$('#fr-id').val(),
            flag:flag,
            title: $.trim($('#fr-title').val()),
            tag: $('#fr-tag').val(),
            content: $.trim(editor.txt.html()),
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