<?php /*a:5:{s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\user\security.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\layout.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\header.html";i:1549940378;s:81:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\navigation.html";i:1549940378;s:77:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\layout\footer.html";i:1549940378;}*/ ?>
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
    
<!--<link rel="stylesheet" href="/static/web/css1/published_article.css">-->
<link rel="stylesheet" href="/static/web/css1/modify_userinfo.css">
<link rel="stylesheet" href="/static/plugin/layui/css/layui.css">

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
            <li class="active">修改手机号</li>
            <li>修改密码</li>
        </ul>
        <div style="clear: both"></div>

        <div class="content">
            <div class="wl-d active">
                <div class="web-validation">
                    <ul>
                        <li class="web-line">
                            <dl class="web-radius">1<span class="web-henxian-right"></span></dl>
                            <dt>请验证你的旧手机号</dt>
                        </li>
                        <li class="web-line1">
                            <dl class="web-radius1"><span class="web-henxian-left1"></span>2<span class="web-henxian-right1"></span></dl>
                            <dt>请绑定新的手机号码</dt>
                        </li>
                        <li class="web-line2">
                            <dl class="web-radius2"><span class="web-henxian-left2"></span>3</dl>
                            <dt>完成</dt>
                        </li>
                    </ul>
                </div>
                <!--修改手机号第一步-->
                <div class="wl-process web-phone">
                    <div class="web-top-name">
                        <ul>
                            <li class="web-binding-phone">已绑定手机号</li><li><?php echo htmlentities(mobileFilter($user_info['mobile'])); ?></li>
                        </ul>
                    </div>
                    <div class="web-top-name">
                        <ul>
                            <li class="web-binding-phone">验证码</li>
                            <li style="position: relative">
                                <input type="text" placeholder="请输入你收到的验证码" class="web-input" id="fr-sms-code1"  style="width: 45%" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="6">
                                <span class="wl-huqou" onclick="objClass.sendSms1()" id="code-btn1">获取验证码</span>
                            <li style="position: absolute;right: 240px">
                                <span class="web-error" ><i class="iconfont icon-tishi"></i>
                                    <span class="web-code1">验证码不能为空</span>
                                </span>
                            </li>
                            </li>

                        </ul>
                    </div>
                    <div>
                       <p style="padding-left: 33.5%;color: #FC7D7D" id="fr-sms-code-tip" ></p>
                    </div>
                    <div style="clear: both"></div>
                    <div class="wl-top-btn1">
                        <div class="web-btn1" onclick="objClass.verify1()" style="margin-left: 33.5%;" >立即修改</div>
                    </div>
                </div>
                <!--修改手机号第二步-->
                <div class="web-phone wl-process wl-hidden">
                    <div class="web-top-name">
                        <ul>
                            <li class="web-binding-phone">新手机号<span class="web-se">*</span></li>
                            <li>
                                <input type="text" placeholder="请输入您的手机号" class="web-input"  id="fr-new-mobile" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="11">
                                <span class="web-error" id="error">
                                    <i class="iconfont icon-tishi"></i>
                                    <span class="web-code">手机号不能为空</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="web-top-name ">
                        <ul>
                            <li class="web-binding-phone">验证码 <span class="web-se">*</span></li>
                            <li>
                                <input type="text" placeholder="请输入你收到的验证码" class="web-input" style="width: 45%" id="fr-sms-code2" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="6">
                                <span class="wl-huqou" id="code-btn2" onclick="objClass.sendSms2()">获取验证码</span>
                                <span class="web-error" id="error1">
                                    <i class="iconfont icon-tishi"></i><span class="web-code1">验证码不能为空</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p style="padding-left: 33.5%;color: #FC7D7D" id="fr-sms-code-tip1" ></p>
                    </div>
                    <div style="clear: both"></div>
                    <div class="wl-top-btn1">
                        <div class="web-btn1" onclick="objClass.changeMobile()"  style="margin-left: 33.5%;">立即修改</div>
                    </div>
                </div>
                <!--修改手机号成功-->
                <div class="web-phone1 wl-process  wl-hidden">
                    <dl><i class="iconfont icon-roundcheck web-phone-success"></i></dl>
                    <dt>恭喜你手机号修改成功！</dt>
                    <dd>完成</dd>
                </div>
            </div>
            <!--修改密码-->
            <div class="wl-d">
                <div class="web-queren">请通过已绑定手机<span><?php echo htmlentities(mobileFilter($user_info['mobile'])); ?></span> 进行验证！</div>
                <input type="hidden" value="<?php echo htmlentities($user_info['mobile']); ?>" id="fr-box1-mobile"/>
                <div class="web-top-name">
                    <ul>
                        <li class="web-information">输入验证码 <span class="web-se">*</span></li>
                        <li>
                            <input type="text" placeholder="请输入你收到的验证码" class="web-input" style="width: 40%" id="fr-box1-sms-code" onkeyup="value=value.replace(/[^\d]/g,'')" maxlength="6">
                            <span class="wl-huqou" id="code-btn3" onclick="objClass.sendSms3()" style="width: 18%;">获取验证码</span>
                            <span class="web-error" id="error2">
                                <i class="iconfont icon-tishi"></i>
                                <span class="web-code2">验证码不能为空</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="web-top-name web-kok">
                    <ul>
                        <li class="web-information">设置新密码 <span class="web-se">*</span></li>
                        <li>
                            <input type="password" placeholder="请输入新密码" class="web-input" style="width: 60.5%" id="fr-box1-password" maxlength="18">

                            <span class="web-error" id="error3"><i class="iconfont icon-tishi"></i>
                                <span class="web-code3">请输入新密码</span>
                            </span>
                        </li>
                    </ul>


                </div>
                <p class="web-pwd-format">密码格式必须为8~16位字母+数字</p>

                <div class="web-top-name web-kok">
                    <ul>
                        <li class="web-information">确认新密码 <span class="web-se">*</span></li>
                        <li>
                            <input type="password" placeholder="请确认您的新密码" class="web-input" style="width: 60.5%" id="fr-box1-password2" maxlength="18">
                            <span class="web-error" id="error4">
                                <i class="iconfont icon-tishi"></i>
                                <span class="web-code4">请确认您的新密码</span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="wl-top-btn1">
                    <div class="web-btn1" onclick="objClass.submit()" id="fr-box2-btn">立即修改</div>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
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
    
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/plugin/layui/layui.js"></script>
<script src="/static/plugin/jquery.smscode.js"></script>
<script type="text/javascript" >
    const mobile = "<?php echo htmlentities($user_info['mobile']); ?>";

    $(".wl-deji li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
        $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
        var index = $(this).index();
        $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
    });

    //获取修改手机号验证码
    var code1 = new Code('code-btn1', '获取验证码', 'wl-sms-disable', 'pc-security-sms1', 60);
    var code2 = new Code('code-btn2', '获取验证码', 'wl-sms-disable', 'pc-security-sms2', 60);
    var code3 = new Code('code-btn3', '获取验证码', 'wl-sms-disable', 'pc-security-sms3', 60);

    var objClass = {
        loading: false,
        sendSmsCode: false,
        verify_code:'',
        changeMobileLoading:false,
        errr: function (msg) {
            $('#cus-changepwd-err-tip').fadeIn("slow").delay(3000).fadeOut().text(msg);
        },
        submit: function () {

            var sms_code = $('#fr-box1-sms-code').val();
            var password = $('#fr-box1-password').val();
            var password1 = $('#fr-box1-password2').val();
            $('.web-error').hide();
            if (sms_code == '') {
                $('#error2').show();
                return false;
            }else if(sms_code.length !=6 ){
                $('#error2').show().find('.web-code2').text('验证码格式错误');
            } else if (password == '') {
                $('#error3').show();
                return false;
            } else if (!redream.checkPassword(password)) {
                $('#error3').show().find('span').text('密码格式错误');
                return false;
            } else if (password1 == '') {
                $('#error4').show();
                return false;
            } else if (password != password1) {
                $('#error4').show().find('.web-code4').text('两次密码输入不一致!');
                return false;
            } else if (!this.loading) {
                $.ajax({
                    url: "/index/user/modifyPassword",
                    type: 'post',
                    data: {password: password, sms_code: sms_code},
                    dataType: 'json',
                    beforeSend: function () {
                        objClass.loading = true;
                        $('#fr-box2-btn').text('修改中...');
                    },
                    complete: function () {
                        objClass.loading = false;
                        $('#fr-box2-btn').text('立即修改');
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            objClass.loading = true;
                            $('#fr-box1-sms-code').val('');
                            $('#fr-box1-password').val('');
                            $('#fr-box1-password2').val('');
                            $('#fr-box2-btn').removeClass('wl-main-bg-color').prop('disabled', true);
                            alert('恭喜您，密码修改成功！！！');
                        }else{
                            $('#error2').show().find('.web-code2').text('验证码错误');
                        }
                    }
                });
            }
        },
        sendSms1:function(){
            if(!code1.checkTime()){
                this.send(8,mobile,function(res){
                    if(res.code == 200){
                        code1.trigger();
                    }else{
                        $('#error2').show().find('.web-code2').text('验证码发送失败');
                    }
                });
            }
        },
        sendSms2:function(){
            var mobile = $('#fr-new-mobile').val();
            if (!redream.checkMobile(mobile)) {
                $('#fr-sms-code-tip1').text('手机号格式错误！');
                return false;
            }

            if(!code2.checkTime()){
                this.send(6,mobile,function(res){
                    if(res.code == 200){
                        code2.trigger();
                    }else{
                        $('#fr-sms-code-tip').text('验证码发送失败');
                    }
                });
            }
        },
        sendSms3:function(){
            if(!code3.checkTime()){
                this.send(5,mobile,function(res){
                    if(res.code == 200){
                        code3.trigger();
                    }else{
                        $('#fr-sms-code-tip').text('验证码发送失败');
                    }
                });
            }
        },
        //验证手机号
        verify1:function(){
            var code = $('#fr-sms-code1').val();
            $('.web-error').hide();
            if(code == ''){
                $('#fr-sms-code-tip').text('验证码不能为空！');
                return false;
            }else if(code.length !=6){
                $('#fr-sms-code-tip').text('验证码格式错误！');
                return false;
            }
            $.ajax({
                url: "/index/user/verifyCode",
                type: 'post',
                data: {mobile: mobile, type: 8,sms_code:code},
                dataType: 'json',
                success: function(res){
                    if(res.code == 200){
                        $('.wl-process').addClass('wl-hidden');
                        $('.wl-process').eq(1).removeClass('wl-hidden');
                        $('.web-henxian-left1').addClass('web-color');
                        $('.web-radius1').addClass('web-radius');
                        $('.web-henxian-right1').addClass('web-color');
                        objClass.verify_code = res.data.verify_code;
                    }else {
                        $('#fr-sms-code-tip').text('验证码错误！');
                    }
                }
            });
        },

        changeMobile:function(){
            var mobile = $('#fr-new-mobile').val();
            var code   = $('#fr-sms-code2').val();

            if(!redream.checkMobile(mobile)){
                $('#fr-sms-code-tip1').text('手机号格式错误！');
                return false;
            }else if(code.length !=6){
                $('#fr-sms-code-tip1').text('验证码格式错误！');
                return false;
            }else if(this.changeMobileLoading == false){
                this.changeMobileLoading = true;
                $.ajax({
                    url: "/index/user/modifyMobile",
                    type: 'post',
                    data: {mobile: mobile, sms_code: code,verify_code:this.verify_code},
                    dataType: 'json',
                    success: function(res){
                        if(res.code == 200){
                            $('.wl-process').addClass('wl-hidden');
                            $('.wl-process').eq(2).removeClass('wl-hidden');
                            $('.web-henxian-left2').addClass('web-color');
                            $('.web-radius2').addClass('web-radius');
                            setTimeout(function(){
                                window.location.reload();
                            },3000);
                        }else{
                            objClass.changeMobileLoading = false;
                            $('#fr-sms-code-tip1').text('验证码错误！');
                        }
                    },
                    error:function(){
                        objClass.changeMobileLoading = false;
                    }
                });
            }
        },

        //发送短信验证码
        send:function(type,mobile,callback){
            $.ajax({
                url: "/index/index/sendSmsCode",
                type: 'post',
                data: {mobile: mobile, type: type},
                dataType: 'json',
                success: callback
            });
        }
    };
</script>

</body>
</html>