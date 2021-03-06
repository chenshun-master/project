<?php /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\replace_phone.html";i:1542433051;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
    <title>微琳医美</title>
    <link rel="stylesheet" type="text/css" href="/static/css/replace_phone.css"/>
    <script src="/static/js/rem.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/static/css/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/static/css/function.css"/>
    <style>
        .code-hui{color: #CCCCCC}
    </style>
</head>
<style>

</style>
<body style="background: #F2F2F2;">
<div class="wl-con">
    <div class="wl-top">
         <div>
             <span class="iconfont  icon-back_light" style="font-size: 40px;float: left;cursor: pointer;" onclick="redream.href('/weixin/user/main')"></span>
             <span style="float: left;font-size: 0.34rem;color: #1B1B1B;margin-left: 245px">更换手机号</span>
         </div>
    </div>
    <div id="cus-box">
        <dl class="wl-jie">
            <dd>更换绑定的手机号</dd>
            <dt>之后可以用新手机号及当前密码登录</dt>
        </dl>
        <div class="wl-xsj">
            <p style="border-bottom: 1px solid #DFDFDF;">
                <input type="text" placeholder="请输入当前绑定的手机号" id="fr-old-mobile" value="<?php echo htmlentities(mobileFilter($mobile)); ?>" readonly>
            </p>
            <p>
                <input type="text" placeholder="请输入新手机号" id="fr-new-mobile" maxlength="11" onkeyup = "value=value.replace(/[^\d]/g,'')" />
            </p>
        </div>
        <button class="wl-btn" disabled onclick="myObj.nextStep()">下一步</button>
    </div>

    <div id="cus-box1" style="display: none;">
        <dl class="wl-jie ">
            <dd>更换绑定的手机号</dd>
            <dt>之后可以用新手机号及当前密码登录</dt>
        </dl>
        <div class="wl-xsj">
            <p style=" border-bottom: 1px solid #DFDFDF;">
                <input type="text" id="fr2-new-mobile" readonly ><span id="fr2-sms-code-btn" onclick="myObj.sendSms()">获取验证码</span>
            </p>
            <p><input type="text" placeholder="请输入验证码" maxlength="6" id="fr2-sms-code" ></p>
        </div>
        <button class="wl-btn" onclick="myObj.submit()">立即修改</button>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/verification-code.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var codeObj = new VerificationCode('fr2-sms-code-btn','获取验证码','code-hui');
    codeObj.run();

    $('#cus-box input').on('.one keyup',function(){
        var mobile = $.trim($('#fr-new-mobile').val());
        if(mobile != '' && redream.checkMobile(mobile)){
            $('.wl-btn').css({'background':'#7DB0E8'}).prop('disabled',false);
        }else{
            $('.wl-btn').css({'background':'#C8C8C8'}).prop('disabled',true);
        }
    });

    var myObj = {
        oldMobile:"<?php echo htmlentities($mobile); ?>",
        smsloading:false,
        loading:false,
        nextStep:function(){
            var newMobile = $.trim($('#fr-new-mobile').val());
            if(newMobile == this.oldMobile){
                redream.showTip('新手机号不能与当前手机号一致');
            }else{
                $('#fr2-new-mobile').val(newMobile);
                $('#cus-box').hide();
                $('#cus-box1').show();
            }
        },
        sendSms:function(){
            var newMobile = $.trim($('#fr2-new-mobile').val());
            if(codeObj.checkTime()){
                return false;
            }else if(!this.smsloading){
                $.ajax({
                    url:"/weixin/index/sendSmsCode",
                    type:'post',
                    data:{mobile:newMobile,type:6},
                    dataType:'json',
                    beforeSend:function(){
                        myObj.smsloading = true;
                    },
                    complete:function(){
                        myObj.smsloading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            codeObj.sendSmsCode();
                            redream.showTip('发送成功');
                        }else{
                            redream.showTip('发送失败');
                        }
                    }
                });
            }
        },
        submit:function(){
            var newMobile = $.trim($('#fr2-new-mobile').val());
            var sms_code  = $.trim($('#fr2-sms-code').val());
            if(!redream.checkMobile(newMobile) || sms_code == ''){
                return false;
            }else if(!this.loading){
                $.ajax({
                    url:"/weixin/user/changeMobile",
                    type:'post',
                    data:{mobile:newMobile,sms_code:sms_code},
                    dataType:'json',
                    beforeSend:function(){
                        myObj.smsloading = true;
                    },
                    complete:function(){
                        myObj.smsloading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            redream.showTip('修改成功');
                            setTimeout(function(){
                                window.location.href = '/weixin/user/main';
                            },2000);
                        }else if(res.code == 302 || res.code == 303){
                            redream.showTip('验证码错误');
                        }else{
                            redream.showTip('修改失败');
                        }
                    }
                });
            }
        }
    };
</script>
</html>