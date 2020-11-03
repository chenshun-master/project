<?php /*a:2:{s:88:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\article\article_details.html";i:1557387052;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;}*/ ?>
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
    
<link rel="stylesheet" href="/static/weixin/css/article_details2.css">

</head>

<body id="main-body">
    

<div class="wl-body " style="padding-bottom: 100px;background: white">
    <header>
        <div class="wl-top">
            <i class="iconfont icon-back_light " style="position: absolute;top: 0px;left: 5px;font-size: 25px"
               onclick="redream.toReferer()"></i>
        </div>
    </header>
    <main>
        <div class="wl-title href"><?php echo htmlentities($article_info['title']); ?></div>
        <div class="wl-main href">
            <div>
                <div class="wl-tou-img href"><img src="<?php echo htmlentities($article_info['portrait']); ?>" alt=""
                                                  data-user_id="<?php echo htmlentities($article_info['user_id']); ?>"
                                                  onerror='this.src="/static/image/user/tou.png"'
                                                  class="cus-touser-main"></div>
                <div class="wl-tou-yonghu href">
                    <dl>
                        <?php echo $article_info['user_type']==3 ? htmlentities($article_info['username']) :  ($article_info['user_type'] == 4
                        || $article_info['user_type'] ==5 ? $article_info['enterprise_name'] :
                        $article_info['nickname']); ?>
                    </dl>
                    <dt><?php echo htmlentities(formatTime(strtotime($article_info['published_time']))); ?></dt>
                </div>
            </div>
            <div class="wl-jiahy href">
                <?php if($isFriend === true):?>
                <button><a href="/weixin/user/userDialogue/uid/<?php echo htmlentities($article_info['user_id']); ?>" style="color: #ffffff">私信</a>
                </button>
                <?php elseif($isFriend === false):?>
                <button onclick="objClass.showAddFriend()" id="cus-add-friend">加好友</button>
                <?php else:endif;?>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="wl-neirong">
            <?php echo $article_info['content'] ?>
        </div>
        <div class="wl-end">--&nbsp;THE END&nbsp;--</div>
        <div class="wl-fengxiang">
            <div class="wl-xiang" style="position: relative" id="cus-click-fabulous" data-fabulous="<?php echo htmlentities($isFabulous); ?>"
                 onclick="objClass.clickFabulous()">
                <i class="iconfont  <?php echo $isFabulous==1 ? 'icon-dianzan' : 'icon-dianzan1 cus-blue'; ?>"
                   style="font-size: 20px;color: #E0E0E0;float: left;margin-left: 30%;"></i>
                <span class="wl-weixn" style="left: 7px;"><?php echo htmlentities($article_info['like']); ?></span>
            </div>
            <div class="wl-xiang pengyouqua" onclick="myShare.wechatTimeline()">
                <span>分享朋友圈</span>
            </div>
            <div class="wl-xiang" style="position: relative" onclick="myShare.wechatFriend()">
                <i class="iconfont  icon-weixin1"
                   style="font-size: 25px;color: #0dc323;float: left;margin-left: 14%;"></i>
                <span class="wl-weixn">分享微信</span>
            </div>
        </div>
        <div class="wl-tuijian" style="display: none">
            <div class="wl-xiangguan">相关推荐</div>
            <div id="cus-recommend-content">

            </div>
            <p class="ckgd" onclick="objClass.loadRecommendList()" id="cus-recommend-loading-btn">查看更多</p>
        </div>
        <div id="cus-comment">
            <div class="wl-xiangguan">相关评论</div>
            <div id="cus-comment-content">

            </div>
            <p class="ckgd" style="display: none;" id="cus-comment-tip">以显示所有评论</p>
        </div>
    </main>
</div>
<footer>
    <div class="wl-foot">
        <input type="text" class="wl-foot-input" placeholder="写评论...">
        <ul class="wl-shoucang">
            <li class="iconfont icon-comment_light " style="margin-left: 10px;"></li>
            <?php if($article_info['isFavorites'] == 1):?>
            <li class="iconfont icon-favor_fill_light cus-favorite "></li>
            <?php else:?>
            <li class="iconfont icon-favor_light " id="cus-click-favorite"></li>
            <?php endif;?>
        </ul>
    </div>
    <div class="wl-zhez2">
        <div class="wl-zl2">
            <textarea name="wl-text" cols="30" rows="10" class="wl-text" id="cus-comment-pid"></textarea>
            <i class="wl-fabu iconfont icon-fabu" onclick="objClass.publishComment()"></i>
        </div>
    </div>

    <div id="cus-myshare-box">
        <img src="/static/weixin/shop/image/index/bjtu.png" alt="" width="100%" height="100%">
    </div>

    <div class="wl-zhezhao">
        <div class="wl-zhe1">
            <p class="wl-renzh">备注信息 <i class="iconfont icon-guanbi1 wl-guanbi1"></i></p>
            <div class="wl-neie1">
                <p>你需要发送验证申请，等待对方通过</p>
                <textarea class="wl-neie2" style="resize: none" placeholder="(必填)填写备注信息..."
                          id="fr-friend-remarks"></textarea>
                <button class="wl-btn" onclick="objClass.submitFriendApply()">立即申请</button>
            </div>
        </div>
    </div>
</footer>


    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>
<script id="demo" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wzxq ">
        <div class="wx-x">
            <h3 data-id="{{item.id}}" class="cus-recommend-href href">{{item.title}}</h3>
            <p><span data-user_id="{{item.user_id}}" class="cus-touser-main href">{{item.nickname}}</span>
                <span>{{item.hits}}阅览量</span>
            </p>
        </div>
        <img src="{{item.thumbnail}}" alt="" data-id="{{item.id}}" class="cus-recommend-href">
    </div>
    {{#  }); }}
</script>

<script id="demo1" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-pinglun">
        <div style="float: left">
            <img src="{{item.portrait}}" alt="" width="30" height="30" class="cus-touser-main "
                 data-user_id="{{item.user_id}}" onerror="this.src='/static/image/user/tou.png'">
        </div>
        <div class="wl-ping-xiang">
            <div>
                <div class="wl-name cus-touser-main" data-user_id="{{item.user_id}}">{{item.nickname}}</div>
                <div class=" wl-dianzan cus-comment-fabulous" style="font-size: 18px" data-id="{{item.id}}"
                     data-click="{{item.isZan}}">
                    {{# if(item.isZan == 0){ }}
                    <span class="iconfont icon-dianzan wl-fabulous-icon" style="font-size: 18px;"></span>
                    {{# } }}
                    {{# if(item.isZan == 1){ }}
                    <span class="iconfont icon-dianzan1 wl-fabulous-icon cus-blue"
                          style="font-size: 18px;"></span>
                    {{# } }}
                    <span class="wl-dian-one" style="font-size: 13px">{{item.like_count}}</span>
                </div>
                <div style="clear:both"></div>
                <div class="wl-ping-neirong">{{item.content}}</div>
                <div class="wl-pji">{{item.created_time}}</div>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
        {{# }); }}
</script>

<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/static/plugin/wechat/WechatJsSdk.js"></script>
<script type="text/javascript" src="/static/plugin/nativeShare/NativeShare.js"></script>
<script type="text/javascript">
    var config = {
        debug: false,
        appId: '<?php echo htmlentities($weixin_config["appId"]); ?>',
        timestamp: '<?php echo htmlentities($weixin_config["timestamp"]); ?>',
        nonceStr: '<?php echo htmlentities($weixin_config["nonceStr"]); ?>',
        signature: '<?php echo htmlentities($weixin_config["signature"]); ?>',
        jsApiList: [
            'checkJsApi',
            "onMenuShareTimeline",              //分享给好友
            "onMenuShareAppMessage",            //分享到朋友圈
            "onMenuShareQQ",                    //分享到QQ
            "onMenuShareWeibo",                 //分享到微博
        ]
    };


    const conf = {
        article_id: <?php echo htmlentities($article_info['id']); ?>,
        u_id: <?php echo htmlentities($article_info['user_id']); ?>,
    };

    function callbacks() {
        var desc = "<?php echo htmlentities($article_info['excerpt']); ?>";
        var shareMessage = {
            title: "<?php echo htmlentities($article_info['title']); ?>",
            desc: (desc == '') ? window.location.href : desc,
            link: window.location.href,
            imgUrl: '<?php echo htmlentities($shareImg); ?>',
        };

        var wxCallback = {
            success: function () {
            },
            cancel: function () {
            },
            fail: function () {
            },
            complete: function () {
            }
        };

        weixinObj.onMenuShareTimeline(shareMessage, wxCallback);
        weixinObj.onMenuShareAppMessage(shareMessage, wxCallback);
    }

    var weixinObj = new WechatSdkModel(config, callbacks);

    var nativeShare = new NativeShare();
    var desc = "<?php echo htmlentities($article_info['excerpt']); ?>";
    nativeShare.setShareData({
        title: "<?php echo htmlentities($article_info['title']); ?>",
        desc: (desc == '') ? window.location.href : desc,
        link: window.location.href,
        icon: '<?php echo htmlentities($shareImg); ?>'
    });

    //自定义浏览器分享
    var myShare = {
        showShareBox: function () {
            if (redream.isWeiXin()) {
                $('#cus-myshare-box').show();
                return true;
            }
            this.call();
        },
        //分享到朋友圈
        wechatTimeline: function () {
            if (this.showShareBox()) {
                return false;
            }
            this.call('wechatTimeline');
        },
        //分享给微信好友
        wechatFriend: function () {
            if (this.showShareBox()) {
                return false;
            }
            this.call('wechatFriend');
        },
        call: function (command) {
            try {
                nativeShare.call(command)
            } catch (err) {
                // 如果不支持，你可以在这里做降级处理
                // alert(err.message)
                alert('浏览器不支持分享')
            }
        }
    };

</script>
<script type="text/javascript" src="/static/weixin/viewjs/article-details.js"></script>


</body>
</html>