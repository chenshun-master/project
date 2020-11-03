<?php /*a:1:{s:76:"D:\phpstudy\PHPTutorial\WWW\project\application\seller\view\index\login.html";i:1550217554;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>商家后台管理</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/static/plugin/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/plugin/admin/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/static/plugin/admin/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/static/plugin/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/static/web/css/sellerLogin.css">
</head>
<body class="hold-transition login-page" style="height: 400px;">
<div class="login-box">
    <div class="login-box-body">
            <p class="login-box-msg  web-logo"></p>
            <p class="login-box-msg  web-title"><b>商户管理</b></p>
            <div class="form-group has-feedback">
                <i class="icon ion-person-stalker"></i>
                <input type="text" class="form-control" placeholder="请输入手机号" id="fr-mobile" autocomplete="off">

            </div>
            <div class="form-group has-feedback">
                <i class="icon ion-locked" ></i>
                <input type="password" class="form-control" placeholder="登录密码" id="fr-password" autocomplete="off">
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="loginObj.submit()">立即登录</button>
                </div>
            </div>
    </div>
</div>
<script src="/static/plugin/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/static/plugin/layui/layui.all.js"></script>
<script src="/static/js/functions.js"></script>
<script type="text/javascript">
        var loginObj = {
            loading:false,
            submit:function(){
                var mobile   = $('#fr-mobile').val();
                var password = $.trim($('#fr-password').val());
                if(!redream.checkMobile(mobile)){
                    layer.msg('请正确填写手机号');
                }else if(redream.isEmptyStr(password)){
                    layer.msg('密码不能为空');
                }else if(this.loading == false){
                    var index = layer.msg('登录中...', {icon: 16,shade: 0.01});
                    $.ajax({
                        url:"/seller/index/postLogin",
                        type:'post',
                        data:{mobile:mobile,password:password},
                        dataType:'json',
                        beforeSend:function(){
                            loginObj.loading = true;
                        },
                        complete:function(){
                            loginObj.loading = false;
                        },
                        success:function(res){
                            if(res.code == 200){
                                window.location.href = '/seller';
                            }else {
                                layer.close(index);
                                layer.msg('登录失败，密码错误...');
                            }
                        }
                    });
                }
            }
        }
</script>
</body>
</html>
