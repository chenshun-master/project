<?php /*a:1:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\admin\view\index\login.html";i:1550281868;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title> <?php echo config('conf.title'); ?> - 后台登陆</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/static/plugin/hAdmin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/animate.css" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/style.css" rel="stylesheet">
    <link href="/static/plugin/hAdmin/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
    <!--&lt;!&ndash;[if lt IE 9]>-->
    <!--<meta http-equiv="refresh" content="0;ie.html" />-->
    <!--<![endif]&ndash;&gt;-->
    <script>
        if (window.top !== window.self) {
            window.top.location = window.location;
        }
    </script>

</head>

<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-14">
            <form class="layui-form">
                <h3 class="no-margins" style="text-align: center;"><b>后台登陆</b></h3>
                <div class="m-t-md"></div>
                <div class="form-group has-feedback">
                    <input type="text" name="username" required lay-verify="required" class="layui-input" placeholder="用户名">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" required lay-verify="required" class="layui-input" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <button class="btn btn-primary btn-block" lay-submit lay-filter="login">登陆</button>
            </form>
        </div>
    </div>
</div>

<script src="/static/plugin/layui/layui.all.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script>
    layui.use('form', function(){
        var form = layui.form

        //监听提交
        form.on('submit(login)', function(data) {
            // layer.msg(JSON.stringify(data.field));
            $.ajax({
                type: "post",
                url: "<?php echo url('admin/index/login'); ?>",
                data: data.field,
                success: function(data) {
                    layer.msg(data.msg);
                    if (data.status) {
                        window.location.href = '/admin';
                    }
                },
                beforeSend: function() {

                },
                complete: function() {

                }

            });
            return false;
        });
    });
</script>
</body>

</html>
