<?php /*a:1:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\error\loss.html";i:1549940378;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection"/>
    <title><?php echo config('conf.title'); ?> - 404 页面找不到</title>
    <style>
        .con {
            width: 100%;
            height: 1206px;
            background: url("/static/image/user/sj-1.png") no-repeat;
            position: relative;
        }

        .cont {
            width: 500px;
            height: 200px;
            margin: 0 auto;
            position: absolute;
            top: 686px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .cont p:nth-child(1) {
            color: #7db0e8;
            font-size: 32px;
        }

        .cont p:nth-child(2) {
            color: #AFAFAF;
            font-size: 24px;
        }
    </style>
</head>

<body style="background: #ffffff;">
<div class="con" >
    <div class="cont">
        <p>哎呀！出错了！</p>
        <p>找不到请求页面，请稍后再试！</p>

    </div>
</div>
</body>

</html>