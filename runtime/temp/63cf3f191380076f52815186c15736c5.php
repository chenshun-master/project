<?php /*a:2:{s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\shop\goods_details.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;}*/ ?>
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
    
<link rel="stylesheet" href="/static/weixin/css/swiper.min.css">
<link rel="stylesheet" href="/static/weixin/shop/css/goods_details.css">

<style>

</style>

</head>

<body id="main-body">
    
<header>
    <div class="wl-top">
        <div style="position: relative;" class="href">
            <i class="iconfont icon-back_light top-left" style="font-size: 25px;color: #333333"
               data-href="<?php echo url('weixin/shop/index'); ?>" id="click-to-referer"></i>
            <span>商品详情页</span>
            <i class="iconfont <?php echo $info['goods_info']['isfavorite']==1 ? 'icon-favor_fill_light cus-sou' : 'icon-favor_light'; ?> top-right1"
               style="font-size: 25px;color: #333333" data-type="<?php echo htmlentities($info['goods_info']['isfavorite']); ?>"
               data-gid="<?php echo htmlentities($info['goods_info']['id']); ?>" id="cus-click-collection"></i>
            <i class="iconfont icon-share_light top-right" style="font-size: 25px;color: #333333"></i>
        </div>
    </div>
</header>

<main style="margin-top: 40px;padding-bottom: 100px;">
    <div class="swiper-container img-gao">
        <div class="swiper-wrapper ">
            <?php foreach($info['imgs'] as $img): ?>
            <div class="swiper-slide"><img src="<?php echo htmlentities($img); ?>" alt=""></div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="wl-neirong" id="cus-test-content">
        <div class="wl-title"><?php echo htmlentities($info['goods_info']['name']); ?></div>
        <div class="wl-jiage">
            <div class="wl-jiage">
                <span class="wl-jiage1"><sub
                        style="font-size: 8px">￥</sub><span><?php echo htmlentities($info['goods_info']['sell_price']); ?></span></span>
                <span class="wl-quchu">￥<?php echo htmlentities($info['goods_info']['market_price']); ?></span>
            </div>
        </div>

        <div class="wl-zizhi href">
            资质认证 . 全程认证 .全程陪护 . 定期回访<i class="iconfont icon-back_left-copy"
                                       style="font-size: 15px;float: right;margin-right: 10px"></i>
        </div>

        <div class="wl-dizhi">
            <div class="wl-dianhua">
                <div class="dianhua-left">
                    <dl><a href="/weixin/index/hospitalDetails/uid/<?php echo htmlentities($info['hospital_info']['user_id']); ?>"><?php echo htmlentities($info['hospital_info']['hospital_name']); ?></a>
                        <i class="iconfont icon-renzheng1" style="font-size: 20px;color: #F19149"></i>
                    </dl>
                    <dt><i class="iconfont icon-xingji" style="font-size: 18px;color:#7DB0E8;"></i>
                        <i class="iconfont icon-xingji" style="font-size: 18px;color:#7DB0E8;"></i>
                        <i class="iconfont icon-xingji" style="font-size: 18px;color:#7DB0E8;"></i>
                        <i class="iconfont icon-xingji" style="font-size: 18px;color:#7DB0E8;"></i>
                        <i class="iconfont icon-xingji" style="font-size: 18px;color:#7DB0E8;"></i>
                    </dt>
                </div>
                <div class="dianhua-right"><i class="iconfont icon-dianhua"
                                              style="font-size: 20px;color: #7DB0E8;margin: 0 auto"></i></div>
                <div style="clear: both"></div>
            </div>
            <div class="wl-dizhixaing">
                <i class="iconfont icon-dingwei1" style="font-size: 15px;color: #BFBFBF"></i>
                <span style="margin-left: 5px"> <?php echo htmlentities($info['hospital_info']['address_dateil']); ?></span>
            </div>
        </div>

        <div>
            <div class="wl-deji">
                <li class="active">
                    <!--<i class="iconfont icon-dingwei1 "></i>-->
                    商品详情</li>
                <li>
                    <!--<i class="iconfont icon-dingwei1"></i>-->
                    购买须知</li>
                <li>
                    <!--<i class="iconfont icon-dingwei1"></i>-->
                    美丽日记</li>
            </div>
            <div class="content">
                <div id="wl-xiangqing">
                    <div class="wl-shangping2">商品详情</div>
                    <div class="wl-youshi" id="wl-goods-detail">
                        <?php echo $info['goods_info']['content'] ?>
                    </div>
                </div>

                <div style="clear: both"></div>

                <div class="wl-xuzhi" id="cus-xuzi">
                    <div class="wl-shangping2">购买须知</div>
                    <div class="padding">
                        <dl>有效期</dl>
                        <dt>
                            <i class="iconfont icon-yuandian" style="font-size: 17px;float: left;margin-top: 1px;"></i>
                            <?php if(($info['goods_info']['buy_deadline'] == 0)): ?>
                            购买当天起永久有效
                            <?php else: ?>
                            购买当天起天<?php echo htmlentities($info['goods_info']['buy_deadline']); ?>内有效
                            <?php endif; ?>
                        </dt>
                    </div>
                    <div style="clear: both"></div>
                    <div class="padding">
                        <dl>预约信息</dl>
                        <dt><i class="iconfont icon-yuandian"
                               style="font-size: 17px;float: left;margin-top: 1px;"></i>
                            <?php echo htmlentities($info['goods_info']['notice']); ?>
                        </dt>
                    </div>
                    <div style="clear: both"></div>
                    <div class="padding">
                        <dl>可用时间</dl>
                        <dt><i class="iconfont icon-yuandian"
                               style="font-size: 17px;float: left;margin-top: 1px;"></i>
                            <?php echo htmlentities($info['goods_info']['time_slot']); ?>
                        </dt>
                    </div>
                    <div style="clear: both"></div>
                    <div style="margin-bottom: 5px;" class="padding">
                        <dl>消费流程</dl>
                        <?php if(($info['goods_info']['buyflow'])): foreach($info['goods_info']['buyflow'] as $text): ?>
                        <dt><i class="iconfont icon-yuandian"
                               style="font-size: 17px;float: left;margin-top: 1px;"></i><?php echo htmlentities($text); ?>
                        </dt>
                        <div style="clear: both"></div>
                        <?php endforeach; endif; ?>
                    </div>
                    <div style="clear: both"></div>
                </div>

                <div class="wl-gengduo">
                    <div class="wl-shangping2">本店热门商品 <span style="float: right;">查看更多>></span></div>
                    <div id="goods-container-list">
                        <div class="wl-container-list-empty">
                            暂无相关商品
                        </div>
                    </div>
                </div>

                <div id="wl-meili-riji">
                    <div class="wl-shangping2">美丽日记 <span style="float: right">查看更多>></span></div>
                    <div id="diary-container-list">
                        <div class="wl-container-list-empty">
                            此商品暂无美丽日记
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<footer>
    <div class="wl-re-footer">
        <div class="wl-yuyue">
            <dl>预约金:<span class="wl-jiage2"><sub style="font-size: 10px">￥</sub><span><?php echo htmlentities($info['goods_info']['prepay_price']); ?></span></span>
            </dl>
            <dd>到院尾付:￥<?php echo htmlentities($info['goods_info']['topay_price']); ?></dd>
        </div>
        <input type="hidden" value="<?php echo htmlentities($info['goods_info']['seller_id']); ?>" id="fr-seller-id">

        <?php if(($info['goods_info']['status'] == 0)): ?>
        <div class="wl-qianggou href" data-href="/weixin/shop/confirmOrder" id="click-place-order"
             data-goodsid="<?php echo htmlentities($info['goods_info']['id']); ?>" data-gid="<?php echo htmlentities($gid); ?>">
            立即抢购
        </div>
        <?php else: ?>
        <div class="wl-qianggou href" style="background: #f2e9e9;color: white">
            已下架
        </div>
        <?php endif; ?>
    </div>
</footer>

<div class="marsk-container">
    <div class="tkyy_con">
        <p class="dian"><?php echo htmlentities($info['hospital_info']['phone']); ?></p>
        <p><span class="quxiao">取消</span><span class="bd"><a href="tel:18798276809">拨打</a></span></p>
    </div>
</div>

<div class="marsk-container1">
    <div class="tkyy_con1">
        <div style="position: relative"><i class="iconfont icon-close wl-quxiao"></i></div>
        <div class="wl-zhezhao-title">放心美</div>
        <div class="wl-beian">
            <dl>
                <i class="iconfont icon-roundcheckfill-copy"
                   style="color:#F24F4F;font-size: 17px;margin-right: 8px"></i>资质认证
            </dl>
            <dt>商品、药品、医师资质已核实备案</dt>
        </div>
        <div class="wl-beian">
            <dl><i class="iconfont icon-roundcheckfill-copy"
                   style="color:#F24F4F;font-size: 17px;margin-right: 8px"></i>全程认证
            </dl>
            <dt>商品、药品、医师、医院资质通过认证审核</dt>
        </div>
        <div class="wl-beian">
            <dl><i class="iconfont icon-roundcheckfill-copy"
                   style="color:#F24F4F;font-size: 17px;margin-right: 8px"></i>全程陪护
            </dl>
            <dt>治疗期间我们会以您的健康为第一己任呵心陪护</dt>
        </div>
        <div class="wl-beian">
            <dl>
                <i class="iconfont icon-roundcheckfill-copy"
                   style="color:#F24F4F;font-size: 17px;margin-right: 8px"></i>
                定期回访
            </dl>
            <dt>我们会定期向您回访 关注您的回复和意见</dt>
        </div>
    </div>
</div>

<div id="cus-myshare-box">
    <img src="/static/weixin/shop/image/index/bjtu.png" alt="" width="100%" height="100%">
</div>


    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>


<script id="diaryTemplateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-meili">
        <div class="wl-meili-top">
            <div class="wl-meili-left">
                <img src="{{ item.portrait}}" onerror="this.src='/static/image/user/tou.png'"
                     data-uid="{{ item.user_id}}" data-type="{{ item.userType}}" class="to-user-detail href"/>
                <span class="wl-yonghu-ming">{{ item.nickname}}</span>
            </div>
        </div>
        <div class="wl-meili-img href to-diary-datail" data-diaryid="{{ item.id}}">
            <div class="wl-img-left">
                <div class="wl-before">
                    <img src="{{ item.before_imgs[0]}}"/>
                    <div class="wl-before-one">Before</div>
                </div>

                {{#if(item.after_imgs.length > 0){ }}
                <div class="wl-after">
                    <img src="{{item.after_imgs[0]}}" alt=""/>
                    <div class="wl-after-one">After</div>
                </div>
                {{# } }}
            </div>
        </div>
        <div class="wl-title">
            {{ item.title }}
        </div>
        <div class="wl-long-top ">
            <div class="wl-meili-left1">
                <span class="iconfont icon-news_hot_fill_light"
                      style="font-size: 20px;color: #7DB0E8;float: left;margin: 3px 7px 0 0;"></span>

                <span class="wl-longxioang">#隆胸</span>
                <span class="wl-longxioang">#胸部</span>

                {{# layui.each(item.goodsList, function(index, goods1){ }}
                <span class="wl-longxioang">#{{ goods1.category_name }}</span>
                {{# }); }}
            </div>
            <div class="wl-meili-right1">
                <span>{{ item.visit }}人浏览</span>
            </div>
        </div>

        {{# layui.each(item.goodsList, function(index, goods){ }}
        <div class="wl-xiang bottom href to-goods-detai" data-goodsid="{{ goods.id }}">
            <span class="iconfont icon-goumaiicon" style="float: left;font-size: 14px;color: #F29C9F"></span>
            <span class="wl-jie"> {{ goods.name }}</span>
            <span class="wl-fenshu se">￥{{ goods.sell_price }}</span>
        </div>
        {{# }); }}
    </div>
    {{#  }); }}
</script>
<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-remen padding to-goods-detai href" data-goodsid="{{ item.id }}">
        <div class="wl-remen-img">
            <img src="{{item.img}}">
        </div>
        <div class="wl-remen-right">
            <dl>{{item.name}}</dl>
            <dt>医院:{{item.hospital_name}}</dt>
            <dd>
                <span class="wl-jiage1"><sub style="font-size: 8px">￥</sub><span>{{item.sell_price}}</span></span>
                <span class="wl-quchu">￥{{item.prepay_price}}</span>
                <span class="wl-jia-right">{{item.sale_num}} 预约</span>
            </dd>
        </div>
    </div>
    {{#  }); }}
</script>
<script src="/static/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/static/plugin/wechat/WechatJsSdk.js"></script>

<script type="text/javascript">
    const uid = <?php echo htmlentities($info['goods_info']['uid']); ?>;
    const goodsid = <?php echo htmlentities($info['goods_info']['id']); ?>;
    const userType = <?php echo htmlentities($info['goods_info']['user_type']); ?>;

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

    function callbacks() {
        var shareMessage = {
            title: "<?php echo htmlentities($info['goods_info']['name']); ?>",
            desc: window.location.href,
            link: window.location.href,
            imgUrl: "<?php echo htmlentities($info['goods_info']['img']); ?>",
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
</script>
<script src="/static/weixin/viewjs/goods_details.js"></script>

</body>
</html>