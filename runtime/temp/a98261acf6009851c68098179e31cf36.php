<?php /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\loginReister.html";i:1542337614;}*/ ?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<!--  <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport" />-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta content="telephone=no" name="format-detection" />
		<link rel="stylesheet" type="text/css" href="/static/css/iconfont.css"/>
        <link rel="stylesheet" type="text/css" href="/static/plugin/layer_mobile/need/layer.css" />
		<link rel="stylesheet" type="text/css" href="/static/css/reg.css" />
		<link rel="stylesheet" type="text/css" href="/static/css/function.css" />
		<title>注册用户</title>
		<style>
			.code-hui{
				color: #cccccc !important;
			}
		</style>
		<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/static/js/rem.js" type="text/javascript" charset="utf-8"></script>

	</head>

	<body style="background-color: #fff;">
		<div class="con">
			<div class="wx-top">
			<a href="login.html"  class="iconfont icon-back_light" style="font-size: 40px;padding-top: 10px;margin-left: 25px;"></a>
				<div class="wx-reg">
					<h3 style="font-size:0.38rem;width: 95%;height: 127px;line-height: 127px;text-align: center;color: #1f1f1f">免费注册</h3>
			     	<p><input id="mobile" type="text"  placeholder="请输入你的手机号"  maxlength="11" onkeyup = "value=value.replace(/[^\d]/g,'')" /><button id="code-btn" onclick="objClass.sendSms()">获取验证码</button></p>
					<p style="margin-top: 15px;"><input id="sms_code" type="text"  placeholder="请输入你收到的验证码" maxlength="6" onkeyup = "value=value.replace(/[^\d]/g,'')" style="width: 500px;" ></p>
					<p style="margin-top: 15px;"><input id="password" type="password"  placeholder="6~16个字符，区分大小写" style="width: 400px;" class="yan"><span id='xian'><img src="/static/image/reg/zy.png" width="40px" /></span></p>
					<button id="btn" style="margin-top: 25px;" onclick="objClass.submit()">完成注册并登录</button>
					<span class="dian" style="margin-top: 20px;">点击“获取验证码”按钮，即表示同意<span style="color:#7DB0E8;">注册协议</span></span>
				</div>
                <!--<p class="weixin"><a href="/weixin/index/otherLogin?platform=weixin" class="qian"><img src="/static/image/reg/wx.jpg" width="80px" height="80px"/ style="float: left;margin-left: 100px;margin-left: 20px;"/><span style="margin-left: 30px;"> <<微信授权登录</span></a></p>-->
			</div>
		</div>
	</body>
<script src="/static/plugin/layer_mobile/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/verification-code.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

        var codeObj = new VerificationCode('code-btn','获取验证码','code-hui');
        codeObj.run();

        var  objClass = {
            loading:false,
            sendSmsCode:false,
            checkMobile:function(mobile){
                var reg_phone = /^[1][3,4,5,7,8][0-9]{9}$/;
                return reg_phone.test(mobile);
            },
            submit:function(){
                var mobile = $('#mobile').val();
                var sms_code = $('#sms_code').val();
                var password = $('#password').val();

                if(!this.checkMobile(mobile)){
                    redream.showTip('手机号格式不正确！');
                    return false;
                }

                if(sms_code == ''){
                    redream.showTip('请填写验证码！');
                    return false;
                }

                if(password == ''){
                    redream.showTip('请填写验证码！');
                    return false;
                }

                if(!this.loading){
                    $.ajax({
                        url:"/weixin/index/postReister",
                        type:'post',
                        data:{mobile:mobile,sms_code:sms_code,password:password},
                        dataType:'json',
                        beforeSend:function(){
                            objClass.loading = true;
                        },
                        complete:function(){
                            objClass.loading = false;
                        },
                        success:function(res){
                            if(res.code == 200){
                                layer.open({content: '注册成功',skin: 'msg',time: 2});
                                setTimeout(function(){
                                    window.location.href = '/weixin/index/login';
                                },3000);
                            }else if(res.code == 301){
                                redream.showTip('请求参数错误！');
                                return false;
                            }else if(res.code == 302){
                                redream.showTip('验证码错误！');
                                return false;
                            }else if(res.code == 303){
                                redream.showTip('验证码已过期！');
                                return false;
                            }else if(res.code == 304){
                                redream.showTip('用户不存在！');
                                return false;
                            }else {
                                redream.showTip('登录失败！');
                                return false;
                            }
                        }
                    });
                }
            },
            sendSms:function(){
                var mobile = $('#mobile').val();
                if(!this.checkMobile(mobile)){
                    redream.showTip('手机号格式不正确！');
                    return false;
                }

                if(codeObj.checkTime()){
                    return false;
                }

                if(!this.sendSmsCode){
                    $.ajax({
                        url:"/weixin/index/sendRegisterCode",
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
                                redream.showTip('该用户已被使用！');
                                return false;
                            }else{
                                redream.showTip('发送失败！');
                                return false;
                            }
                        }
                    });
                }
            }
        };


			$(function(){
			  $("#xian").click(function(){
				if($(".yan").prop("type")=="password"){
					$(".yan").prop("type","text");
					$("#xian img").attr("src","/static/image/reg/by.png")
				}else{
					 $(".yan").prop("type","password");
					$("#xian img").attr("src","/static/image/reg/zy.png")
				}

			  });
			})
			$(function(){
			    $('.wx-reg input').on('.wx-reg input ',function(){
			        if(($.trim($('#mobile').val())!=="")&&($.trim($('#sms_code').val())!=="")&&($.trim($('#password').val())!=="")){
			        $('#btn').css({'background':'#7DB0E8'});
			    }else{
			        $('#btn').css({'background':'#EBEBEB'});
			         }
			    });
			});

</script>
</html>