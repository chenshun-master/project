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
    getGoodsHtml:function(data){
        var html = '<div style="max-width: 400px;margin: 20px auto;">' +
            '<div style="width:100%;margin: 0 auto;height: 110px;border: 1px solid #d3d3d3;padding:5px 0 0 5px">' +
            '<div style="float: left;width: 30%;height: 100px;">' +
            '<img src="https://img.alicdn.com/imgextra/i3/667038546/TB2a_f_XGe5V1BjSspkXXcoqpXa_!!667038546.jpg_140x140.jpg" width="100" height="100"/">' +
            '</div>' +
            '<div style="float: right;width: 69%;height: 100px;">' +
            '<dl style="font-size: 15px;margin: 0;padding: 0 5px 0 5px;width: 95%;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;">一片式无痕无钢圈文胸聚拢调整型小胸罩厚薄款少女士隐形性感内衣</dl>' +
            '<dt  style="font-size: 11px;padding:5px 5px 0 5px;">' +
            '<span style="text-decoration: line-through;">市场价￥999</span>' +
            '<span style="margin-left: 10px;color: #f50;">销售价<sub style="font-size: 11px;">￥</sub>120</span>' +
            '</dt>' +
            '<span style="color:#da0d15;float: right;margin-right: 20px;font-size: 13px;width: 60px;height:20px;line-height: 20px;border: 1px solid #da0d15;;text-align: center;border-radius: 3px;">去购买</span>' +
            '</div>' +
            '</div>' +
            '</div>';
        editor.cmd.do('insertHTML', html);
    }
};

$('#fr-title').on('keyup',function(){
    $('#title-lenght').text($(this).val().length);
});

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
                $('.web-tianjiai').append('<div  class="cus-remove-img-list"><img src="' + data.data.url + '" class="cus-fr-images" width="125" height="125" ><span class="iconfont icon-roundclosefill cus-remove-img" ></span></div>');
                if ($('.cus-fr-images').length >= 3) {
                    $('#btn-input-file').prop('disabled', true);
                }
            } else {
                alert(data.msg);
            }
        }
    });
});

$(document).on('click', '.cus-remove-img', function () {
    $(this).parent().remove();
    $('#btn-input-file').prop('disabled', false);
});
$('.w-e-toolbar').css('background-color','white');
// 修改信息遮罩层
$(".web-yulan").click(function(event) {
    if($("#fr-title").val()==''){
        alert('请输入标题！');
        return false;
    }
    event.stopPropagation(); //停止事件冒泡
    $(".wl-zhez2").toggle();
    $('.web-preview-title').text($("#fr-title").val());
    $('.web-preview-content').html(editor.txt.html());
});
//点击空白处隐藏弹出层
$(".wl-zhez2").click(function(event) {
    var _con = $('.wl-zl2'); // 设置目标区域
    if(!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.wl-zhez2').hide(); //淡出消失
    }
});
$('.w-e-toolbar').css("border",'1px solid #eeeeee');
$('.w-e-text-container').css("border",'1px solid #eeeeee')

$(function(){
    $('#wang-editor > .w-e-toolbar').append('<p class="w-e-menu" id="taobao-plugin" style="z-index:10001;padding: 3px !important;"><i class="iconfont icon-changyonglogo25" style="font-size: 23px;"></i></p>');
    $(document).on('click','#taobao-plugin',function () {
        alert('功能还在开发中，请耐心等待...');
    });
});