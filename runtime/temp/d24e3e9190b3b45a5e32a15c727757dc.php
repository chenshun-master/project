<?php /*a:1:{s:79:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\resetpwd.html";i:1542337614;}*/ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--  <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport" />-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta content="telephone=no" name="format-detection" />
		<link rel="stylesheet" type="text/css" href="/static/plugin/layer_mobile/need/layer.css" />
		<link rel="stylesheet" type="text/css" href="/static/css/backpwd.css" />
		<link rel="stylesheet" type="text/css" href="/static/css/function.css" />
		<title>Title</title>
		<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/static/js/rem.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div class="con">
			<div class="wx-top">
			<a href="login.html"  class="zj"></a>
				<div class="wx-reg">		
					<h3 style="font-size:0.38rem;width: 95%;height: 127px;line-height: 127px;text-align: center;color: #1f1f1f">设置密码</h3>
			     	<p style="margin-top: 40px;"><input id="password1" type="password"  placeholder="新密码" style="width: 555px;"></p>
					<p style="margin-top: 40px;"><input id="password2" type="password"  placeholder="重复密码" style="width: 555px;"></p>
					<input id="mobile" type="hidden"  value="<?php echo htmlentities($mobile); ?>"  />
					<input id="verify_code" type="hidden" value="<?php echo htmlentities($verify_code); ?>"  />
					<button id="btn" style="margin-top: 100px;" onclick="objClass.submit()">完成</button>
				</div>
			</div>
		</div>
	</body>
	<script src="/static/plugin/layer_mobile/layer.js" type="text/javascript" charset="utf-8"></script>
	<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
        var  objClass = {
            loading:false,
            submit:function(){
                var password1 = $('#password1').val();
                var password2 = $('#password2').val();
                var mobile = $('#mobile').val();
                var verify_code = $('#verify_code').val();

				if(password1 == ''){
                    redream.showTip('请填写新的密码！');
                    return false;
				}

                if(password1 != password2){
                    redream.showTip('两次密码不一致！');
                    return false;
                }

                if(!this.loading){
                    $.ajax({
                        url:"/weixin/index/postResetPwd",
                        type:'post',
                        data:{mobile:mobile,password1:password1,password2:password2,verify_code:verify_code},
                        dataType:'json',
                        beforeSend:function(){
                            objClass.loading = true;
                        },
                        complete:function(){
                            objClass.loading = false;
                        },
                        success:function(res){
                            if(res.code == 200){
                                redream.showTip('重置成功！');
                                window.location.href = '/weixin/index/login';
                                return false;
                            }else if(res.code == 301){
                                redream.showTip('请求参数错误！');
                                return false;
                            }else if(res.code == 302){
                                redream.showTip('两次密码不一致！');
                                return false;
                            }else {
                                redream.showTip('密码重置失败！');
                                return false;
                            }
                        }
                    });
                }
            }
        };
        $(function(){
            $('.wx-reg input').on('.wx-reg input ',function(){
                if(($.trim($('#password1').val())!=="")&&($.trim($('#password2').val())!=="")){
                    $('#btn').css({'background':'#7DB0E8'});
                }else{
                    $('#btn').css({'background':'#EBEBEB'});
                }
            });
        });
	</script>
</html>