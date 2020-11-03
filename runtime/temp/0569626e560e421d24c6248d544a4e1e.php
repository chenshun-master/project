<?php /*a:2:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\login.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;}*/ ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="applicable-device" content="pc,mobile">
    <title><?php echo config('conf.title'); ?></title>
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" href="/static/weixin/css/function.css">
    
<link rel="stylesheet" href="/static/weixin/css/login.css">

</head>

<body id="main-body">
    
<!--这里编写主体内容-->
<div class="wl-login">
    <a href="/weixin/index/loginReister" class="wl-jump">立即注册 <i class="iconfont icon-back_left-copy"></i></a>
    <a href="/weixin/index/index"><div class="wl-logo"><img src="/static/weixin/image/bg-logo.png" alt=""></div></a>
        <div class="wl-dialog">
            <ul class="wl-deji">
                <li class="active">手机号快捷登录</li>
                <li>账号密码登录</li>
            </ul>
            <div style="clear: both"></div>
            <div class="content">
                <div class="wl-d active one">
                    <div class="wl-input-box">
                        <input type="text" placeholder="请输入您的手机号" style="width: 60%" id="mobile1" name="phone" maxlength="11" onkeyup = "value=value.replace(/[^\d]/g,'')">
                        <button class="wl-obtain" id="code-btn" onclick="objClass.sendSms()">获取验证码</button></div>
                    <div class="wl-input-box"><input type="text" placeholder="请输入您收到的验证码" id="sms_code"   maxlength="6"  onkeyup = "value=value.replace(/[^\d]/g,'')"></div>

                    <button class="wl-the-login" id="btn" onclick="objClass.submitOne()">登录</button>
                </div>
                <div class="wl-d two">
                    <div class="wl-input-box"><input type="text" placeholder="请输入您的手机号" id="mobile2"  maxlength="11" onkeyup = "value=value.replace(/[^\d]/g,'')" ></div>
                    <div class="wl-input-box"><input type="password" placeholder="请输入密码" id="password" maxlength="18"></div>

                    <button class="wl-the-login" id="btn1" onclick="objClass.submitTwo()">登录</button>
                    <a href="/weixin/index/backpwd" class="wl-back">找回密码</a>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
</div>



    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/js/verification-code.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/plugin/layer_mobile/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    $(".wl-deji li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
        $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
        var index = $(this).index();
        $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
    });

    var codeObj = new VerificationCode('code-btn','获取验证码','code-hui');
    codeObj.run();

    const redir = '<?php echo htmlentities($redir); ?>';
    var  objClass = {
        oneLoading:false,
        twoLoading:false,
        sendSmsCode:false,
        checkMobile:function(mobile){
            var reg_phone = /^[1][3,4,5,7,8][0-9]{9}$/;
            return reg_phone.test(mobile);
        },
        submitOne:function(){
            var mobile = $('#mobile1').val();
            var sms_code = $('#sms_code').val();

            if(!this.checkMobile(mobile)){
                redream.showTip('手机号格式不正确！');
                return false;
            }

            if(sms_code == ''){
                redream.showTip('请填写验证码！');
                return false;
            }

            if(!this.oneLoading){
                $.ajax({
                    url:"/weixin/index/codeLogin",
                    type:'post',
                    data:{mobile:mobile,sms_code:sms_code},
                    dataType:'json',
                    beforeSend:function(){
                        objClass.oneLoading = true;
                    },
                    complete:function(){
                        objClass.oneLoading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            layer.open({type: 2,content: '登录中...',time:4});
                            setTimeout(function(){
                                window.location.href = redir;
                            },2000);
                        }else if(res.code == 301){
                            layer.open({content: '请求参数错误',skin: 'msg',time: 2});
                        }else if(res.code == 302){
                            layer.open({content: '验证码错误',skin: 'msg',time: 2});
                        }else if(res.code == 303){
                            layer.open({content: '验证码已过期',skin: 'msg',time: 2});
                        }else if(res.code == 304){
                            layer.open({content: '用户不存在',skin: 'msg',time: 2});
                        }else {
                            layer.open({content: '登录失败',skin: 'msg',time: 2});
                        }
                    }
                });
            }
        },
        submitTwo:function(){
            var mobile = $('#mobile2').val();
            var password = $('#password').val();
            if(!this.checkMobile(mobile)){
                redream.showTip('请填写您的手机号！');
                return false;
            }
            if(password.length == ''){
                redream.showTip('请输入您的密码！');
                return false;
            }
            if(!objClass.twoLoading){
                $.ajax({
                    url:"/weixin/index/postLogin",
                    type:'post',
                    data:{mobile:mobile,password:password},
                    dataType:'json',
                    beforeSend:function(){
                        objClass.twoLoading = true;
                    },
                    complete:function(){
                        objClass.twoLoading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            layer.open({type: 2,content: '登录中...',time:4});
                            setTimeout(function(){
                                window.location.href = redir;
                            },2000);
                        }else if(res.code == 301){
                            redream.showTip('请求参数错误！');
                        }else if(res.code == 302){
                            redream.showTip('用户不存在！');
                        }else if(res.code == 303){
                            redream.showTip('用户密码填写错误！');
                        }else{
                            redream.showTip('登录失败！');
                        }
                    }
                });
            }
        },
        sendSms:function(){
            var mobile = $('#mobile1').val();
            if(!this.checkMobile(mobile)){
                redream.showTip('手机号格式不正确！');
                return false;
            }

            if(codeObj.checkTime()){
                return false;
            }

            if(!this.sendSmsCode){
                $.ajax({
                    url:"/weixin/index/sendQuickLoginSmsCode",
                    type:'post',
                    data:{mobile:mobile},
                    dataType:'json',
                    beforeSend:function(){
                        objClass.sendSmsCode = true;
                    },
                    complete:function(){
                        objClass.sendSmsCode = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            redream.showTip('发送成功！');
                            codeObj.sendSmsCode();
                            return false;
                        }else if(res.code == 301){
                            redream.showTip('请求参数错误！');
                            return false;
                        }else if(res.code == 302){
                            redream.showTip('该手机号未注册！');
                            return false;
                        }
                    }
                });
            }
        }
    };

    $('.eye').click(function () {
        $(this).parent().find("input").attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password'
        })
    });
    $(function(){
        $('.one input').on('input ',function(){
            if(($.trim($('#mobile1').val())!=="")&&($.trim($('#sms_code').val())!=="")){
                $('#btn').css({'background':'#7DB0E8'});
            }else{
                $('#btn').css({'background':'#EBEBEB'});
            }
        });

        $('.two input').on('input ',function(){
            if(($.trim($('#mobile2').val())!=="") && ($.trim($('#password').val())!=="")){
                $('#btn1').css({'background':'#7DB0E8'});
            }else{
                $('#btn1').css({'background':'#EBEBEB'});
            }
        });
    });
</script>

</body>
</html>