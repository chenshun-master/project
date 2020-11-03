<?php /*a:3:{s:85:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\index\doctor_details.html";i:1548119468;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1548216047;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\footer.html";i:1544520347;}*/ ?>
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
    <link rel="stylesheet" href="/static/weixin/css/iconfont.css">
    <link rel="stylesheet" href="/static/weixin/css/main.css">
    <link rel="stylesheet" href="/static/weixin/css/function.css">
    
<link rel="stylesheet" href="/static/weixin/css/doctor_details.css">
<link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">

</head>

<body id="main-body">
    
<div id="container">
    <header>
        <div class="wl-top">
            <div class="wl-top-neirong">
                <div class="wl-top-touxiang">
                    <img src="<?php echo htmlentities($info['doctor_info']['portrait']); ?>" onerror="this.src='/static/image/user/tou.png'" width="71"
                         height="71">
                </div>
                <div class="wl-top-yisheng">
                    <div style="position: relative">
                        <dl class="wl-renz"></dl>
                    </div>
                    <dd><?php echo htmlentities($info['doctor_info']['real_name']); ?></dd>
                    <dt>
                        <button id="click-to-follow" data-isFollow="<?php echo htmlentities($isFollow); ?>" class="<?php echo $isFollow==1 ? 'isfollow' : ''; ?>">
                            <?php echo $isFollow==1 ? '<i class="iconfont icon-check"></i>已关注' : '＋关注'; ?>
                        </button>
                    </dt>
                </div>
                <div class="wl-top-anli">
                    <div class="wl-am">
                        <div style="width: 170px;margin: 0 auto">
                        <span><i class="iconfont icon-anli" style="font-size: 18px;color: #7DB0E8;float: left"></i><span
                                style="float: left">&nbsp;<?php echo htmlentities($statistics['diary']); ?>案例</span></span>
                            <span><i class="iconfont icon-ziliao"
                                     style="font-size: 18px;color: #7DB0E8;float: left"></i><span style="float: right">&nbsp;<?php echo htmlentities($statistics['article']); ?>文章</span></span>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
                <div class="wl-top-yishneg">
                    <dl data-href="/weixin/index/detailsDoctor/uid/<?php echo htmlentities($uid); ?>" class="href cus-click-href">
                        <dd class="iconfont icon-wenjian" style="font-size: 45px;color: #7DB0E8;"></dd>
                        <dt>医生资料</dt>
                    </dl>
                    <dl data-href="/weixin/index/doctorCertificate/uid/<?php echo htmlentities($uid); ?>" class="href cus-click-href">
                        <dd class="iconfont icon-zhengjian" style="font-size: 25px;color: #7DB0E8;"></dd>
                        <dt>医生证件</dt>
                    </dl>
                    <dl data-href="/weixin/index/honor/uid/<?php echo htmlentities($uid); ?>/type/2" class="href cus-click-href">
                        <dd class="iconfont icon-rongyu" style="font-size: 25px;color: #7DB0E8;"></dd>
                        <dt>医生荣誉</dt>
                    </dl>
                    <div style="clear: both"></div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <?php if((count($info['hospital_info']) > 0)): ?>
        <div class="wl-con-top">
            <div class="wl-jiu href click-to-hospital-details"  data-href="/weixin/index/hospitalDetails/uid/<?php echo htmlentities($info['hospital_info'][0]['uid']); ?>">
                <img src="<?php echo htmlentities($info['hospital_info'][0]['portrait']); ?>" onerror="this.src='/static/image/user/tou.png'"
                     width="40" height="40" style="float: left">
                <div style="position: relative">
                    <dl class="wl-renz1"></dl>
                </div>
                <dl class="wl-yiyuan">
                    <dd><?php echo htmlentities($info['hospital_info'][0]['hospital_name']); ?></dd>
                    <dt> <i class="iconfont icon-dingwei"></i><?php echo htmlentities($info['hospital_info'][0]['address']); ?></dt>
                </dl>
                <dl style="float: right;margin-top: 5px">
                    <span class="iconfont icon-back_left-copy wl-fanhui"></span>
                </dl>
            </div>

            <!--<div class="wl-jiu" style="line-height: 42px">-->
                <!--<i class="iconfont icon-dingwei" style="font-size: 16px;float: left;color: #7DB0E8;margin-left: 13px"></i>-->
                <!--<dl class="wl-yiyuan" style="margin-left: 15px">-->
                    <!--<dd><?php echo htmlentities($info['hospital_info'][0]['address']); ?></dd>-->
                <!--</dl>-->
                <!--<dl style="float: right;margin-top: 2px">-->
                    <!--<span class="iconfont icon-back_left-copy" style="font-size: 25px;color: #AAAAAA"></span>-->
                <!--</dl>-->
            <!--</div>-->
            <div style="clear: both"></div>
        </div>
        <?php endif; ?>
        <div >
            <ul class="wl-liebiao">
                <li class="active" i="0">项目</li>
                <li i="1">文章</li>
                <li i="2">日记</li>
            </ul>
            <div style="clear: both"></div>

            <div class="content">
                <div id="goodslist" class="mescroll">

                </div>
                <div style="clear: both"></div>
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


    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/plugin/mescroll/mescroll.min.js" charset="utf-8"></script>
<script src="/static/plugin/layui/layui.all.js"></script>

<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-project-one to-goods-project" data-project-id="{{ item.id}}">
        <dl class="wl-plastic-img"><img src="{{item.img}}" onerror="this.src='/static/weixin/image/img-diushi.png'"></dl>
        <div class="wl-top-title">
            <dt class="wl-plastic-title">{{item.name}}</dt>
            <dt class="wl-plastic-prepaid">
                <span class="wl-plastic-btn"><span>预付</span><span>￥{{item.prepay_price}}</span></span>
                <span class="wl-plastic-booking">{{item.sale_num}}人预订</span>
            </dt>
            <div style="clear:both"></div>
            <dd class="wl-plastic-actual">
                <span><sup style="font-size: 10px">￥</sup>{{item.sell_price}}</span>
                <span>￥{{item.market_price}}</span>
            </dd>
        </div>
    </div>
    {{#  }); }}
</script>

<script id="diaryTemplateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    <div class="wl-meili">
        <div class="wl-meili-img href to-diary-datail" data-diaryid="{{ item.id}}">
            <div class="wl-img-left">
                <div class="wl-before">
                    <img src="{{ item.before_imgs[0]}}" onerror="this.src='/static/weixin/image/img-diushi.png'"/>
                    <div class="wl-before-one">Before</div>
                </div>

                <div class="wl-after">
                    <img src="{{item.after_imgs[0]}}"onerror="this.src='/static/weixin/image/img-diushi.png'"/>
                    <div class="wl-after-one">After</div>
                </div>

            </div>
        </div>
        <div class="wl-title">
            {{ item.title }}
        </div>
        <div class="wl-long-top ">
            <div class="wl-meili-left1">
                <span class="iconfont icon-news_hot_fill_light" style="font-size: 20px;color: #7DB0E8;float: left;margin: 3px 7px 0 0;"></span>

                <span class="wl-longxioang">#隆胸</span>
                <span class="wl-longxioang">#胸部</span>

                {{#  layui.each(item.goodsList, function(index, goods1){ }}
                <span class="wl-longxioang">#{{ goods1.category_name }}</span>
                {{#  }); }}
            </div>
            <div class="wl-meili-right1">
                <span>{{ item.visit }}人浏览</span>
            </div>
        </div>

        {{#  layui.each(item.goodsList, function(index, goods){ }}
        <div class="wl-xiang bottom href to-goods-detai"  data-goodsid="{{ goods.id }}">
            <span class="iconfont icon-goumaiicon wl-goushop" ></span>
            <span class="wl-jie"> {{ goods.name }}</span>
            <span class="wl-fenshu se">￥{{ goods.sell_price }}元</span>
        </div>
        {{#  }); }}
    </div>
    {{#  }); }}
</script>

<script id="templateListArticle" type="text/html">
    {{#  layui.each(d, function(index, item){ }}

    {{# if(item.thumbnail == 0){ }}
    <div class="wl-nei1 href click-to-article" data-id="{{item.id}}">
        <div class="wl-dem2">{{item.title}}</div>
    </div>
    {{# } }}

    {{# if(item.thumbnail != 0 ){ }}
    <div class="wl-nei1 href click-to-article" data-id="{{item.id}}" >
        <div class="wl-neirong1">{{item.title}}</div>
        <div class="wl-neirong2">
            <img src="{{item.thumbnail}}" alt="" width="128" height="90">
        </div>
        <div style="clear: both"></div>
    </div>

    {{# } }}


    {{#  }); }}
</script>


<script type="text/javascript">

    $(document).on('click', '.cus-click-href', function () {
        window.location.href = $(this).data('href');
    });
    $(document).on('click', '.click-to-article', function () {
        window.location.href = '/weixin/article/articleDetails/id/' + $(this).data('id');
    });

    $(document).on('click', '.click-to-hospital-details', function () {
        window.location.href = $(this).data('href');
    });

    $('#click-to-follow').on('click', function () {
        if ($(this).data('isfollow') != 1 && $(this).data('isfollow') != 0) {
            redream.showTip('不能关注自己');
            return false;
        }
        objClass.follow.clickFollow($(this));
    });

    var objClass = {
        uid: <?php echo htmlentities($uid); ?>,
        follow: {
            followLoading: false,
            clickFollow: function (obj) {
                if (objClass.follow.followLoading) {
                    return false;
                }

                var type = obj.data('isfollow') == 0 ? 1 : 2;
                $.ajax({
                    url: "/weixin/api/followUser",
                    type: 'post',
                    data: {uid: objClass.uid, type: type},
                    dataType: 'json',
                    beforeSend: function () {
                        objClass.follow.followLoading = true;
                    },
                    complete: function () {
                        objClass.follow.followLoading = false;
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            if (obj.data('isfollow') == 0) {
                                obj.addClass('isfollow').html('<i class="iconfont icon-check"></i>已关注').data('isfollow', 1);
                            } else if (obj.data('isfollow') == 1) {
                                obj.removeClass('isfollow').html('+ 关注').data('isfollow', 0);
                            }
                        } else if (res.code == 401) {
                            redream.showTip(res.msg);
                            LoginBox.showBox();
                        } else {
                            redream.showTip('操作失败');
                        }
                    }
                });
            }
        },

    };
    // objClass.recommend.loadList();

    $(".wl-liebiao li").click(function () {
            $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
        listObj.index  = $(this).index();
        mescroll.resetUpScroll();
    });


    var mescroll = new MeScroll("container", {
        down:{auto:true},
        up: {
            clearEmptyId: "goodslist",
            page: {num: 0,size: 20},
            htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
            isBounce: false,
            noMoreSize: 5,
            empty: {
                icon: "/static/weixin/image/wenzhnag.png",
                tip: "该医生尚未发布~", //提示
            },
            callback: function(page){
                listObj.searchList(page,function(curPageData){
                    mescroll.endSuccess(curPageData.length);

                    if(listObj.index == 0){
                        layui.laytpl(templateList.innerHTML).render(curPageData, function(html){
                            $('#goodslist').append(html);
                        });
                    }else if(listObj.index == 1){
                        $.each(curPageData, function (k, val) {
                            if(val.thumbnail != '' && val.thumbnail != undefined){
                                var obj  = $.parseJSON(val.thumbnail);
                                curPageData[k].thumbnail = obj.img_1;
                            }
                        });

                        layui.laytpl(templateListArticle.innerHTML).render(curPageData, function(html){
                            $('#goodslist').append(html);
                        });
                    }else if(listObj.index == 2){
                        layui.laytpl(diaryTemplateList.innerHTML).render(curPageData, function(html){
                            $('#goodslist').append(html);
                        });
                    }

                }, function(){
                    mescroll.endErr();
                });
            }
        }
    });

    var listObj = {
        index:0,
        url:[
            '/weixin/api/getUserGoods',
            '/weixin/Article/getUserPublishArticle',
            '/weixin/api/getUserDiary'
        ],
        searchList: function (page, successCallback, errorCallback) {
            var data = $.extend({}, {user_id:objClass.uid,uid:objClass.uid,page: page.num, page_size: page.size});
            $.ajax({
                url: listObj.url[listObj.index],
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (res) {
                    successCallback(res.data.rows);

                },

            });
        },
    };
    mescroll.lockDownScroll(true);

    $(document).on('click','.to-diary-datail',function(){
        window.location.href = '/weixin/shop/diary?id='+$(this).data('diaryid');
    });
    $(document).on('click','.to-goods-detai',function(){
        window.location.href = '/weixin/shop/goodsDetails/goodsid/'+$(this).data('goodsid');
    });

    $(document).on('click','.to-goods-project',function(){
        window.location.href = '/weixin/shop/goodsDetails/goodsid/'+$(this).data('project-id');
    });


</script>

</body>
</html>