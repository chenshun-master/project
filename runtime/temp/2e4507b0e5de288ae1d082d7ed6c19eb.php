<?php /*a:5:{s:84:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\user\modify_userinfo.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1549940378;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1549940378;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="applicable-device" content="pc,mobile">
    <title><?php echo config('conf.title'); ?></title>
    <link rel="stylesheet" type="text/css" href="/static/web/css/main.css"/>
    <link rel="stylesheet" href="/static/css/iconfont.css">
    

<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
<link rel="stylesheet" type="text/css" href="https://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
<link href="/static/web/dis/head/sitelogo.css" rel="stylesheet">
<link href="/static/web/dis/head/cropper.min.css" rel="stylesheet">
<link rel="stylesheet" href="/static/web/css1/modify_userinfo.css">

</head>

<body >
    
        <header>
    <div class="layui-row">
        <div class="layui-col-xs12 layui-col-md12">
            <div class="web-header">
                <div class="web-header-content">
                    <div class="web-header-logo">
                         欢迎 <?php echo htmlentities($u['nickname']); ?> 来到薇琳医美！
                    </div>
                    <div class="web-head-portrait">
                        <ul class="web-article">
                          <li>  <a href="/index/user/certification">实名认证</a></li>
                            <?php if(($u && in_array($u['type'],[3,4]))): ?>
                               <li><a id="click-to-merchant">商户管理</a></li>
                            <?php endif; ?>
                           <li> <a href="/index/user/modifyUserInfo">账号设置</a></li>
                            <li><a href="/index/user/signOut">退出登录</a></li>
                        </ul>

                        <!--<ul class="web-reg">-->
                            <!--<li class="web-top-login">登录</li>-->
                            <!--<li class="web-top-login">注册</li>-->
                        <!--</ul>-->
                        <div style="clear: both"></div>
                    </div>
            </div>
        </div>
            <div style="width: 100%;min-height: 80px;background-color: #7DB0E8;">
                <div class="web-logo">
                    <div class="wl-logo-one">
                        <img src="/static/web/image/logo1.png" alt="">
                    </div>
                    <!--<div class="web-top-input">-->
                        <!--<a href="/index/shop/myshoplist"> <input type="text" placeholder="搜索的商品"></a>-->
                    <!--</div>-->
                    <div class="web-top-rigth">
                        <img src="/static/web/image/bj_logo.png" alt="" width="50" height="50">
                        <div class="web-zhengxing">
                            <dl>中国整形美容协会</dl>
                            <dt>互联网分会理事单位</dt>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
    

    

<div class="web-content">
    <div class="web-content-left">
        <content>
    <div class="web-navigation-title web-bold">个人中心</div>
    <ul class="web-navigation">
        <li class="web-wenzhangliebiao web-bold"> <span></span>文章列表 <span></span></li>
    <ul class="web-daohang">
        <?php if((checkFooter('/index/article/article'))): ?>
        <a href="/index/article/article"> <li class="web-tinjain"><i class="iconfont icon-fabiaowenzhang1" style="color: white"></i>发表文章</li></a>
        <?php else: ?>
        <a href="/index/article/article"> <li><i class="iconfont icon-fabiaowenzhang1" style="color: #FC9E9E"></i>发表文章</li></a>
        <?php endif; if((checkFooter('/index/article/graphic'))): ?>
        <a href="/index/article/graphic"><li class="web-tinjain"><i class="iconfont icon-wodewenzhang" style="color: white"></i>我的文章</li></a>
       <?php else: ?>
        <a href="/index/article/graphic"><li><i class="iconfont icon-wodewenzhang" style="color:#FE9F88"></i>我的文章</li></a>
        <?php endif; ?>

    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>分销商品 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/shop/index'))): ?>
            <a href="/index/shop/index"><li class="web-tinjain"><i class="iconfont icon-shangpinliebiao2" style="color: white"></i>商品列表</li></a>
            <?php else: ?>
            <a href="/index/shop/index"><li><i class="iconfont icon-shangpinliebiao2" style="color: #FFAC9C"></i>商品列表</li></a>
            <?php endif; if((checkFooter('/index/shop/myshoplist'))): ?>
            <a href="/index/shop/myshoplist"><li class="web-tinjain"><i class="iconfont icon-fenxiaoliebiao1" style="color: white"></i>分销列表</li></a>
            <?php else: ?>
            <a href="/index/shop/myshoplist"><li><i class="iconfont icon-fenxiaoliebiao1" style="color:#FF988A"></i>分销列表</li></a>
            <?php endif; ?>

    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>我的认证 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/user/certification'))): ?>
            <a href="/index/user/certification"><li  class="web-tinjain"><i class="iconfont icon-shimingrenzheng2" style="color: white"></i>实名认证</li></a>
            <?php else: ?>
            <a href="/index/user/certification"><li><i class="iconfont icon-shimingrenzheng2" style="color: #FFAC9C"></i>实名认证</li></a>
            <?php endif; ?>
    </ul>
        <li class="web-wenzhangliebiao web-bold"> <span></span>账号设置 <span></span></li>
        <ul class="web-daohang">
            <?php if((checkFooter('/index/user/main'))): ?>
            <a href="/index/user/main"><li  class="web-tinjain"><i class="iconfont icon-yonghuxinxi" style="color: white"></i>用户信息</li></a>
            <?php else: ?>
            <a href="/index/user/main"><li><i class="iconfont icon-yonghuxinxi" style="color: #FF917B"></i>用户信息</li></a>
            <?php endif; if((checkFooter('/index/user/modifyUserInfo'))): ?>
            <a href="/index/user/modifyUserInfo"><li  class="web-tinjain"><i class="iconfont icon-xiugaiziliao" style="color: white"></i>修改资料</li></a>
            <?php else: ?>
            <a href="/index/user/modifyUserInfo"><li><i class="iconfont icon-xiugaiziliao" style="color: #FE9F88"></i>修改资料</li></a>
            <?php endif; if((checkFooter('/index/user/security'))): ?>
            <a href="/index/user/security"><li  class="web-tinjain"><i class="iconfont icon-anquanzhongxin" style="color: white"></i>安全中心</li></a>
            <?php else: ?>
            <a href="/index/user/security"><li><i class="iconfont icon-anquanzhongxin" style="color: #FF917B"></i>安全中心</li></a>
            <?php endif; ?>

        </ul>
    </ul>

    </ul>
</content>

    </div>
    <div class="web-content-right">
        <ul class="wl-deji">
            <li class="active">基本资料</li>
            <!--<li>修改头像</li>-->
        </ul>
        <div style="clear: both"></div>
        <div class="content">
            <div class="wl-d active">
                <div class="web-top-name">
                    <ul>
                        <li class="web-information">修改头像<span class="web-se">*</span></li>
                        <li class="web-touxiang">
                            <img src="<?php echo htmlentities($user_info['portrait']); ?>" onerror="this.src='/static/web/image/tou.png'"  class="btn-primary" data-toggle="modal" data-target="#avatar-modal">
                        </li>
                    </ul>
                </div>
                <div class="web-top-name">
                    <ul>
                        <li class="web-information">昵称<span class="web-se">*</span></li>
                        <li><?php echo htmlentities($user_info['nickname']); ?></li>
                    </ul>
                </div>
                <div class="web-top-name">
                    <ul>
                        <li class="web-information">性别<span class="web-se">*</span></li>
                        <li>
                            <input type="radio" name="sex" class="web-radio" value="1" <?php if($user_info['sex'] == '1'): ?> checked <?php endif; ?> ><span class="web-sex">男</span>
                            &nbsp;&nbsp;
                            <input type="radio" name="sex" class="web-radio" value="2"  <?php if($user_info['sex'] == '2'): ?> checked <?php endif; ?>><span class="web-sex">女</span>
                        </li>
                    </ul>
                </div>
                <div class="web-top-name">
                    <ul>
                        <li class="web-information">生日<span class="web-se">*</span></li>
                        <li>
                            <input type="text" class="layui-input web-day" id="fr-date" placeholder="请输入你的生日" value="<?php echo htmlentities($user_info['birthday_date']); ?>">
                        </li>
                    </ul>
                </div>

                <div class="web-top-name wl-hidden">
                    <ul>
                        <li class="web-information">所在地址 <span class="web-se">*</span></li>
                        <li>
                            <select id="fr3-province" class="wl-liandong fr-province">
                                <option value="">请选择省</option>
                            </select>
                            <select id="fr3-city" class="wl-liandong fr-city">
                                <option value="">请选择市</option>
                            </select>
                            <select id="fr3-area-county" class="wl-liandong fr-area-county">
                                <option value="">请选择县</option>
                            </select>
                        </li>
                    </ul>
                </div>

                <div class="web-top-name">
                    <ul>
                        <li class="web-information">个人简介<span class="web-se">*</span></li>
                        <li><textarea type="text" placeholder="请输入个人简介" id="fr-profile"><?php echo htmlentities($user_info['profile']); ?></textarea></li>
                    </ul>
                </div>
                <div style="clear: both"></div>
                <div class="wl-top-btn">
                    <div class="web-btn" onclick="editProfile.submit()">修改资料</div>
                </div>
            </div>
            <!--修改头像-->
            <div class="wl-d">

            </div>
        </div>
        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="avatar-form">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal" type="button">&times;</button>
                            <h4 class="modal-title" id="avatar-modal-label">上传图片</h4>
                        </div>
                        <div class="modal-body">
                            <div class="avatar-body">
                                <div class="avatar-upload">
                                    <input class="avatar-src" name="avatar_src" type="hidden">
                                    <input class="avatar-data" name="avatar_data" type="hidden">
                                    <label for="avatarInput" style="line-height: 35px;">图片上传</label>
                                    <button class="btn btn-danger" type="button" style="height: 35px;"
                                            onclick="$('input[id=avatarInput]').click();">请选择图片
                                    </button>
                                    <span id="avatar-name"></span>
                                    <input class="avatar-input hide" id="avatarInput" name="avatar_file" type="file">
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="avatar-preview preview-lg" id="imageHead"></div>

                                    </div>
                                </div>
                                <div class="row avatar-btns">
                                    <div class="col-md-4">
                                        <div class="btn-group">
                                            <button class="btn btn-danger fa fa-undo" data-method="rotate"
                                                    data-option="-90" type="button" title="Rotate -90 degrees"> 向左旋转
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn  btn-danger fa fa-repeat" data-method="rotate"
                                                    data-option="90" type="button" title="Rotate 90 degrees"> 向右旋转
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-5" style="text-align: right;">
                                        <button class="btn btn-danger fa fa-arrows" data-method="setDragMode" data-option="move" type="button" title="移动">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger fa fa-search-plus"  data-method="zoom" data-option="0.1" title="放大图片">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, 0.1)"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger fa fa-search-minus" data-method="zoom" data-option="-0.1" title="缩小图片">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;zoom&quot;, -0.1)"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger fa fa-refresh" data-method="reset" title="重置图片">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;reset&quot;)" aria-describedby="tooltip866214"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-danger btn-block avatar-save fa fa-save" type="button"
                                                data-dismiss="modal"> 保存修改
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
    </div>
</div>


    
    <footer>
    <div class="web-footer">
        <div class="web-footer-content">
        <dl>
            <span><?php echo config('conf.copyright'); ?></span>
            <span>Wei Lin Medical beauty</span>
            <a href="#"><img src="https://statics.wmnrj.com/images/beian.png" alt="">公安网备 34040302000221号</a>
        </dl>
            <dt><span>客服电话:021-62829999</span><span>医院地址:上海市静安区江宁路818号（江宁路海防路路口）</span></dt>
        </div>
    </div>
</footer>
    

    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $('#click-to-merchant').on('click',function(){
            $.ajax({
                url: "/index/user/getAuthCode",
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if(res.code == 200){
                        window.open(res.data.url,'_blank');
                    }
                }
            });
        });
    </script>
    
<script src="/static/web/dis/head/jquery.min.js"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/plugin/layui/layui.js"></script>
<script src="http://www.jq22.com/jquery/bootstrap-3.3.4.js"></script>
<script src="/static/web/dis/head/html2canvas.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/web/dis/head/cropper.js"></script>
<script src="/static/web/dis/head/sitelogo.js"></script>
<script>
    $(".wl-deji li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
        $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
        var index = $(this).index();
        $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
    });

    layui.use('laydate', function () {
        var laydate = layui.laydate;
        laydate.render({elem: '#fr-date'});
    });

    var editProfile ={
        loading:false,
        submit:function(){
            var data = {
                profile:$.trim($('#fr-profile').val()),
                sex:$("input[name='sex']:checked").val(),
                date:$('#fr-date').val(),
            };
            if(!this.loading){
                $.ajax({
                    url:"/index/user/editProfile",
                    type:'post',
                    data:data,
                    dataType:'json',
                    beforeSend:function(){
                        editProfile.loading = true;
                    },
                    complete:function(){
                        editProfile.loading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            alert('修改成功');
                        }else {
                            alert('修改失败');
                        }
                    }
                });
            }
        }
    };
</script>
<script>
    var myAddressObj = {
        requestParams: {
            region_path: ',',
            region_grade: '1',
        },
        loadAddressList: function (region_path, region_grade) {
            myAddressObj.requestParams = {region_path: region_path, region_grade: region_grade};
            $.ajax({
                url: "/weixin/api/getAddress",
                type: 'post',
                data: myAddressObj.requestParams,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 200) {
                        var data = res.data;
                        if (data.request_params.region_path == myAddressObj.requestParams.region_path && data.request_params.region_grade == myAddressObj.requestParams.region_grade) {
                            var html = '';
                            $.each(data.infos, function (k, v) {
                                html += myAddressObj.getSelectOptions(v);
                            });
                            if (data.request_params.region_grade == 1) {
                                $('.fr-province').empty().append('<option value="" >请选择省</option>').append(html);
                            } else if (data.request_params.region_grade == 2) {
                                $('.fr-city').empty().append('<option value="" >请选择市</option>').append(html);
                                $('.fr-area-county').empty().append('<option value="" >请选择县</option>');
                            } else if (data.request_params.region_grade == 3) {
                                $('.fr-area-county').empty().append('<option value="" >请选择县</option>').append(html);
                            }
                        }
                    }
                }
            });
        },
        getSelectOptions: function (data) {
            return '<option value="' + data.id + '"  data-region_path="' + data.region_path + '"  data-region_grade="' + data.find_next_region_grade + '" >' + data.local_name + '</option>';
        }
    };

    myAddressObj.loadAddressList(myAddressObj.requestParams.region_path, myAddressObj.requestParams.region_grade);

    $('.fr-province,.fr-city,.fr-area-county').on('change', function () {
        var obj = $(this).find("option:selected");
        myAddressObj.loadAddressList(obj.data('region_path'), obj.data('region_grade'));
    });
</script>
<script type="text/javascript">
    //做个下简易的验证  大小 格式
    $('#avatarInput').on('change', function (e) {
        var filemaxsize = 1024 * 5;//5M
        var target = $(e.target);
        var Size = target[0].files[0].size / 1024;
        if (Size > filemaxsize) {
            alert('图片过大，请重新选择!');
            $(".avatar-wrapper").childre().remove;
            return false;
        }
        if (!this.files[0].type.match(/image.*/)) {
            alert('请选择正确的图片!')
        } else {
            var filename = document.querySelector("#avatar-name");
            var texts = document.querySelector("#avatarInput").value;
            var teststr = texts; //你这里的路径写错了
            testend = teststr.match(/[^\\]+\.[^\(]+/i); //直接完整文件名的
            filename.innerHTML = testend;
        }

    });

    $(".avatar-save").on("click", function () {
        var img_lg = document.getElementById('imageHead');
        // 截图小的显示框内的内容
        html2canvas(img_lg, {
            allowTaint: true,
            taintTest: false,
            onrendered: function (canvas) {
                canvas.id = "mycanvas";
                //生成base64图片数据
                var dataUrl = canvas.toDataURL("image/jpeg");
                var newImg = document.createElement("img");
                newImg.src = dataUrl;
                imagesAjax(dataUrl)
            }
        });
    });

    function imagesAjax(src) {
        var data = {};
        data.img = src;
        data.jid = $('#jid').val();
        $.ajax({
            url: "/index/user/uploadHead",
            data: data,
            type: "POST",
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    redream.showTip('头像修改成功');
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000)
                } else {
                    redream.showTip('头像修改失败');
                }
            }
        });
    }
</script>

</body>
</html>