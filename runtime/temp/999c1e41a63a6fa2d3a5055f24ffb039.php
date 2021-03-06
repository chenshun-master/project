<?php /*a:1:{s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\modify_pwd.html";i:1542360273;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--  <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport" />-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection"/>
    <link rel="stylesheet" type="text/css" href="/static/css/modify_pwd.css"/>
    <link rel="stylesheet" type="text/css" href="/static/css/function.css"/>
    <title>修改密码</title>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/rem.js" type="text/javascript" charset="utf-8"></script>
</head>

<body style="background: #ffffff">
<div class="con">
    <div class="wx-top">
        <a href="javascript:history.go(-1)" class="tb"></a> 修改密码
    </div>
    <p class="xgma">
        <span>旧密码</span>
        <input type="password"  id="old-passwrod" placeholder="请输入你的旧密码"  style="padding-left: 25px;"/></p>
    <p class="xgma" style="	border-bottom: 10px solid #F1F1F1;">
        <span>新密码</span>
        <input type="password"  id="passwrod" placeholder="请输入你的新密码"  style="padding-left: 25px;"/>
    </p>
    <p class="xgma"  style="	border-bottom: 10px solid #F1F1F1;">
        <span>确认密码</span>
        <input type="password"  id="new-password" placeholder="请再次输入你的新密码"  style="margin-left: 25px" />
    </p>
    <button id="btn" onclick="objClass.submit()">修改密码</button>
</div>
</body>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    $('.con input').on('.con input ',function(){
        if(($.trim($('#old-passwrod').val())!=="")&&($.trim($('#passwrod').val())!=="")&&($.trim($('#new-password').val())!=="")){
            $('#btn').css({'background':'#7DB0E8'});
        }else{
            $('#btn').css({'background':'#EBEBEB'});
        }
    });
    var objClass ={
        loading:false,
        submit:function(){
            var old_pasword  = $('#old-passwrod').val();
            var pasword  = $('#passwrod').val();
            var new_pasword  = $('#new-password').val();
            if(redream.isEmptyStr(old_pasword)){
                redream.showTip('旧密码不能为空');
                return false;
            }else if(redream.isEmptyStr(pasword)){
                redream.showTip('新密码不能为空');
                return false;
            }else if(!redream.checkPassword(pasword)){
                redream.showTip('新密码格式错误');
                return false;
            }else if(pasword != new_pasword){
                redream.showTip('重复密码输入错误');
                return false;
            }

            if(!this.loading){
                $.ajax({
                    url:"/weixin/user/changePassword",
                    type:'post',
                    data:{old_password:old_pasword,new_password:new_pasword},
                    dataType:'json',
                    beforeSend:function(){
                        objClass.loading = true;
                    },
                    complete:function(){
                        objClass.loading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            redream.showTip('密码修改成功');
                            $('#old-passwrod').val('');
                            $('#passwrod').val('');
                            $('#new-password').val('');
                        }else{
                            redream.showTip(res.msg);
                        }
                    },
                });
            }
        }
    }

</script>
</html>