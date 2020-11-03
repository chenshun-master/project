<?php /*a:3:{s:75:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\main2.html";i:1546591470;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1546521460;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\footer.html";i:1544520347;}*/ ?>
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
    <!--这里引入框架 需要的 css script-->
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" href="/static/css/function.css">
    
<link rel="stylesheet" type="text/css" href="/static/weixin/css/usermain.css" />
<style>
    .se{
        color: red;
    }
</style>

</head>

<body style="width:100%;max-width: 640px;margin:0 auto;background: white">
    
<!--这里编写主体内容-->
<div style="width: 100%;padding-bottom: 100px;background: white">
<header>
    <div class="wl-top">
        <div class="wl-ttop">
            <a href="/weixin/user/modify">
            <div class="wl-touxiang">
                <img src="<?php echo htmlentities($user_info['portrait']); ?>" alt=""  onerror='this.src="/static/image/user/tou.png"'>
            </div>
            </a>
            <div class="wl-renzheng">
                <div class="wl-yonghu">
                    <dl><?php echo !empty($user_info['nickname']) ? htmlentities($user_info['nickname']) : htmlentities(mobileFilter($user_info['mobile'])); ?></dl>
                    <?php if($user_info['type'] == 1):?>
                    <dd  onclick="redream.href('/weixin/user/certification')" ><i class="iconfont icon-renzhenghuiyuan"></i>申请认证</dd>
                    <?php elseif($user_info['type'] == 2):?>
                    <dd class="xian"> <i class="iconfont icon-renzhenghuiyuan"></i>认证用户</dd>
                    <?php elseif($user_info['type'] == 3):?>
                    <dd class="xian"><i class="iconfont icon-renzhenghuiyuan"></i>认证医生</dd>
                    <?php elseif($user_info['type'] == 4):?>
                    <dd class="xian"><i class="iconfont icon-renzhenghuiyuan"></i>认证医院</dd>
                    <?php elseif($user_info['type'] == 5):?>
                    <dd class="xian"><i class="iconfont icon-renzhenghuiyuan"></i>官方团队</dd>
                    <?php endif;?>
                </div>
                <a href="/weixin/user/modify">
                    <div class="wl-fanhui">
                       设置
                    </div>
                </a>
            </div>
            <div style="clear:both;" ></div>
        </div>
        <div class="wl-reward">
            <a href="/weixin/user/scoreRecord">
                <div class="wl-integral" style="border-right:1px solid #d7cece ">
                    <dl class="wl-jifen"><?php echo htmlentities($user_info['usable_score']); ?></dl>
                    <dt>可用积分 <i class="iconfont icon-xiangyou"></i></dt>
                </div>
            </a>
            <a href="/weixin/user/balanceOf">
                <div class="wl-integral">
                    <dl class="wl-yue"><?php echo htmlentities($user_info['account']); ?></dl>
                    <dt>账户余额 <i class="iconfont icon-xiangyou"></i></dt>
                </div>
            </a>
        </div>
    </div>

</header>
<main>
<div onclick="redream.href('/weixin/shop/myOrder')">
    <p class="wl-dingdan">
        <span class="wl-me-dingdan">我的订单</span>
        <a href="/weixin/shop/myOrder#all" class="wl-ckqb">
            <span>查看全部订单<i class="iconfont icon-back_left-copy" style="font-size: 12px;color: #333333"></i></span>
        </a>
    </p>
    <div class="wl-anli">
        <ul>
            <a href="/weixin/shop/myOrder#all">
                <li >
                    <dl class="iconfont icon-order" style="font-size: 26px"></dl>
                    <dt>全部</dt>
                </li>
            </a>
            <a href="/weixin/shop/myOrder#paid">
                <li>
                    <dl class="iconfont icon-daizhifu" style="font-size: 26px"></dl>
                    <dt>待支付</dt>
                </li>
            </a>
            <a href="/weixin/shop/myOrder#consumption">
                <li>
                    <dl  class="iconfont icon-xiaofeishuju" style="font-size: 27px"></dl>
                    <dt>待消费</dt>
                </li>
            </a>
            <a href="/weixin/shop/myOrder#complete">
                <li style="border: none">
                    <dl  class="iconfont icon-daizhifu" style="font-size: 26px"></dl>
                    <dt>已完成</dt>
                </li>
            </a>
        </ul>
    </div>
</div>
    <div class="wl-shoucang">
        <ul>
            <a href="/weixin/user/collection#favorite">
                <li>
                    <dl   class="iconfont icon-favor_fill_light" style="font-size: 30px;color: #69BD65;"></dl>
                    <dt>我的收藏</dt>
                </li>
            </a>
            <a href="/weixin/user/collection#comment">
                <li>
                    <dl class="iconfont icon-commentfill"   style="font-size: 30px;color: #EB545F;"></dl>
                    <dt>我的评论</dt>
                </li>
            </a>

            <a href="/weixin/user/collection#like">
                <li>
                    <dl  class="iconfont icon-dianzan1"  style="font-size: 30px;color: #7DB0E8;"></dl>
                    <dt>我的点赞</dt>
                </li>
            </a>
            <a href="/weixin/user/userArticleList">
                <li>
                    <dl class="iconfont icon-dingdan1"   style="font-size: 30px;color: #EB825D;"></dl>
                    <dt>我的文章</dt>
                </li>
            </a>
            <a href="/weixin/user/friends">
                <li>
                    <dl  class="iconfont icon-friendfill"  style="font-size: 30px;color: #F29C9F;"></dl>
                    <dt>我的好友</dt>
                </li>
            </a>
        </ul>
    </div>
    <div class="wl-tongzhi">
        <a href="/weixin/user/notice"><p style="position: relative">消息通知<i class="wl-xui" id="cus-unread-msg-tip" style="display: none">0</i><span class="iconfont icon-back_left-copy" style="font-size: 20px"></span></p></a>
        <a href="/weixin/user/certification"><p style=" border-bottom: 6px solid #F4F5F6;">用户认证 <span class="iconfont icon-back_left-copy" style="font-size: 20px"></span></p></a>
        <a href="/weixin/user/modifypwd"><p>修改密码 <span class="iconfont icon-back_left-copy" style="font-size: 20px"></span></p></a>
        <a href="/weixin/user/replacephone"><p style=" border-bottom: 6px solid #F4F5F6;">修改手机号 <span class="iconfont icon-back_left-copy" style="font-size: 20px"></span></p></a>
        <p class="tkyy">联系我们 <span class="iconfont icon-back_left-copy" style="font-size: 20px"></span></p>
    </div>
    <?php if($isSignOut):?>
        <a href="/weixin/user/signOut" ><div class="wl-btn">退出登录</div></a>
    <?php endif;?>

    <div class="marsk-container">
        <div class="tkyy_con">
            <p  class="dian"><?php echo htmlentities($contactMobile); ?></p>
            <p ><span class="quxiao">取消</span><span class="bd"><a href="tel:<?php echo htmlentities($contactMobile); ?>">拨打</a></span></p>
        </div>
    </div>
</main>
</div>

<footer class="wl-footer">
    <a href="/weixin/index/index">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/index/index'))): ?>
                <dl class="iconfont icon-home_fill_light xian" style="font-size: 25px;"></dl>
                <dd class="xian">首页</dd>
            <?php else: ?>
                <dl class="iconfont icon-home_light" style="font-size: 25px;"></dl>
                <dd >首页</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/index/doctor">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/index/doctor'))): ?>
            <dl class="iconfont icon-yishengsshixin xian" style="font-size: 25px;"></dl>
            <dd class="xian">医生</dd>
            <?php else: ?>
            <dl class="iconfont icon-yishengkkongxin" style="font-size: 25px;"></dl>
            <dd >医生</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/shop/index">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/shop/index'))): ?>
            <dl class="iconfont icon-shopfill xian" style="font-size: 25px;"></dl>
            <dd class="xian">商城</dd>
            <?php else: ?>
            <dl class="iconfont icon-shoplight" style="font-size: 25px;"></dl>
            <dd >商城</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/index/hospital">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/index/hospital'))): ?>
            <dl class="iconfont icon-yiyuan3 xian" style="font-size: 25px;"></dl>
            <dd class="xian">医院</dd>
            <?php else: ?>
            <dl class="iconfont icon-chakanyiyuan" style="font-size: 25px;"></dl>
            <dd >医院</dd>
            <?php endif; ?>
        </div>
    </a>
    <a href="/weixin/user/main">
        <div class="wl-foot">
            <?php if((checkFooter('/weixin/user/main'))): ?>
            <dl class="iconfont icon-my_fill_light xian" style="font-size: 25px;"></dl>
            <dd class="xian">我的</dd>
            <?php else: ?>
            <dl class="iconfont icon-my_light" style="font-size: 25px;"></dl>
            <dd >我的</dd>
            <?php endif; ?>
        </div>
    </a>
</footer>

    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    
<script>
    var myObj = {
        loadindUnreadMsg:function(){
            $.ajax({
                url: "/weixin/api/getUnreadMsg",
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if (res.code == 200) {
                        if(res.data.total > 0){
                            $('#cus-unread-msg-tip').text(res.data.total).show();
                        }
                    }
                }
            });
        }
    };


    $(function(){
        myObj.loadindUnreadMsg();
    });

        $(".tkyy").click(function (event) {
            event.stopPropagation(); //停止事件冒泡
            $(".marsk-container").toggle();
        });

        //点击空白处隐藏弹出层
        $(".marsk-container").click(function (event) {
            var _con = $('.tkyy_con'); // 设置目标区域
            if (!_con.is(event.target) && _con.has(event.target).length == 0) {
                $('.marsk-container').hide(); //淡出消失
            }
        });
        $(".quxiao").click(function () {
            $('.marsk-container').hide(); //淡出消失
        })


</script>

</body>
</html>