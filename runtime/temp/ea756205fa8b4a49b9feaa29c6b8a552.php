<?php /*a:2:{s:86:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\userArticleList1.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;}*/ ?>
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
    
<link rel="stylesheet" href="/static/weixin/css/userArticle.css">
<link rel="stylesheet" href="/static/plugin/mescroll/mescroll.min.css">
<link rel="stylesheet" href="/static/weixin/css/index2.css">

</head>

<body id="main-body">
    
<header>
    <div class="wl-top">
        <div style="position: relative;" class="href">
            <i class="iconfont icon-back_light top-left" style="font-size: 25px;color: #333333"
               onclick="redream.toReferer()"></i>
            <span><?php echo !empty($user_info['nickname']) ? htmlentities($user_info['nickname']) : htmlentities(mobileFilter($user_info['mobile'])); ?></span>
        </div>
    </div>
</header>
<main class="mescroll" id="container">
    <div class="wl-top-img">
        <div class="wl-top-left">
            <img src=" <?php echo htmlentities($user_info['portrait']); ?>" alt="" onclick="redream.href('/weixin/user/main')"
                 onerror='this.src="/static/image/user/tou.png"'>
        </div>
        <div class="wl-top-right">
            <ul class="wl-wenzhnag">
                <li>
                    <dl><?php echo htmlentities($publishStatistics['article']); ?></dl>
                    <dt>文章</dt>
                </li>
                <li>
                    <dl><?php echo htmlentities($publishStatistics['video']); ?></dl>
                    <dt>视频</dt>
                </li>
                <li>
                    <dl><?php echo htmlentities($publishStatistics['diary']); ?></dl>
                    <dt>案例</dt>
                </li>
                <li>
                    <dl><?php echo htmlentities($publishStatistics['goodsgood']); ?></dl>
                    <dt>热门商品</dt>
                </li>
            </ul>
            <div style="clear: both"></div>
            <ul class="wl-attes">
                <li>
                    <?php if($user_info['type'] == 1):?>
                    <a href="/weixin/user/certification" style="color: #ffffff">申请认证</a>
                    <?php elseif($user_info['type'] == 2):?>
                    认证用户
                    <?php elseif($user_info['type'] == 3):?>
                    认证医生
                    <?php elseif($user_info['type'] == 4):?>
                    认证医院
                    <?php elseif($user_info['type'] == 5):?>
                    官方团队
                    <?php endif;?>
                </li>
                <li onclick="redream.href('/weixin/user/modify')">编辑资料</li>
            </ul>

        </div>
        <div style="clear: both"></div>
    </div>
    <div >
        <div id="container-list"></div>
    </div>
</main>


    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/plugin/layui/layui.all.js"></script>
<script src="/static/plugin/mescroll/mescroll.min.js" charset="utf-8"></script>
<script id="templateList" type="text/html">
    {{#  layui.each(d, function(index, item){ }}
    {{#  if(getImgNum(item) == 1){ }}
    <div data-id="{{  item.id }}">
        <div class="wl-main href">
            <div>
                <div class="wl-tou-img href">
                    <img src="{{ item.portrait}}" alt="" onerror="this.src=&quot;/static/image/user/tou.png&quot;"
                         data-user_id="63">
                </div>
                <div class="wl-tou-yonghu href">
                    <dl>{{item.nickname}}</dl>
                    <dt>{{item.published_time}}</dt>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="wl-neirong  ">
            <div class="wl-nei1 cus-article-href" data-id="{{  item.id }}">{{ item.title }}</div>
            <ul class="wl-tubiao">
                <li><i class="iconfont icon-share_light"></i><span></span></li>
                <li><i class="iconfont icon-comment_light"></i><span>{{ item.comment_count}}</span></li>
                <li class="cus-article-fabulous"    data-type="{{ item.isZan }}"  data-id="{{  item.id }}">
                    {{# if(item.isZan == 0){ }}
                    <i class="iconfont icon-dianzan wl-fabulous-icon"></i>
                    {{# } }}

                    {{# if(item.isZan == 1){ }}
                    <i class="iconfont icon-dianzan1 cus-blue wl-fabulous-icon"></i>
                    {{# } }}
                    <span class="wl-dian-one">{{ item.like}}</span>
                </li>
            </ul>
        </div>
    </div>
    {{#  } }}

    {{#  if(getImgNum(item) == 2){ }}
    <div data-id="{{  item.id }}">
        <div class="wl-main href">
            <div>
                <div class="wl-tou-img href">
                    <img src="{{ item.portrait}}" alt=""  onerror='this.src="/static/image/user/tou.png"'>
                </div>
                <div class="wl-tou-yonghu href">
                    <dl>{{item.nickname}}</dl>
                    <dt>{{item.published_time}}</dt>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="wl-neirong  ">
            <div class="wl-nei1 cus-article-href " data-id="{{  item.id }}">
                {{ item.title }}
            </div>
            <div class="wl-nei6 cus-article-href" data-id="{{  item.id }}">
                {{ showImg(item.thumbnail,getImgNum(item))}}
            </div>
            <ul class="wl-tubiao">
                <li><i class="iconfont icon-share_light"></i><span></span></li>
                <li><i class="iconfont icon-comment_light"></i><span>{{ item.comment_count}}</span></li>
                <li class="cus-article-fabulous" data-type="{{ item.isZan }}"  data-id="{{  item.id }}">
                    {{# if(item.isZan == 0){ }}
                    <i class="iconfont icon-dianzan wl-fabulous-icon"></i>
                    {{# } }}

                    {{# if(item.isZan == 1){ }}
                    <i class="iconfont icon-dianzan1 cus-blue  wl-fabulous-icon"></i>
                    {{# } }}
                    <span class="wl-dian-one">{{ item.like}}</span>
                </li>
            </ul>
        </div>
        <div style="clear:both"></div>
    </div>
    {{#  } }}

    {{#  if(getImgNum(item) == 3){ }}
    <div data-id="{{  item.id }}">
        <div class="wl-main href">
            <div>
                <div class="wl-tou-img href"  >
                    <img src="{{ item.portrait}}" alt=""  onerror='this.src="/static/image/user/tou.png"'>
                </div>
                <div class="wl-tou-yonghu href">
                    <dl>{{item.nickname}}</dl>
                    <dt>{{item.published_time}}</dt>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="wl-neirong ">
            <div class="wl-img-1 cus-article-href"  data-id="{{  item.id }}">
                <div class="wl-nei5  ">
                    {{ item.title }}
                </div>
                <div class="wl-left-img">
                    {{ showImg(item.thumbnail,getImgNum(item))}}
                </div>
                <div style="clear:both"></div>
            </div>
            <ul class="wl-tubiao">
                <li><i class="iconfont icon-share_light"></i><span></span></li>
                <li><i class="iconfont icon-comment_light"></i><span>{{ item.comment_count}}</span></li>
                <li class="cus-article-fabulous" data-type="{{ item.isZan }}"  data-id="{{  item.id }}">
                    {{# if(item.isZan == 0){ }}
                    <i class="iconfont icon-dianzan wl-fabulous-icon"></i>
                    {{# } }}

                    {{# if(item.isZan == 1){ }}
                    <i class="iconfont icon-dianzan1 cus-blue  wl-fabulous-icon"></i>
                    {{# } }}
                    <span class="wl-dian-one">{{ item.like}}</span>
                </li>
            </ul>
        </div>
        <div style="clear:both"></div>
    </div>
    {{#  } }}

    {{#  if(getImgNum(item) == 4){ }}
    <div data-id="{{  item.id }}">
        <div class="wl-main href">
            <div>
                <div class="wl-tou-img href">
                    <img src="{{ item.portrait}}" alt=""  onerror='this.src="/static/image/user/tou.png"'>
                </div>
                <div class="wl-tou-yonghu href">
                    <dl>{{item.nickname}}</dl>
                    <dt>{{item.published_time}}</dt>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="wl-neirong ">
            <div class="wl-nei1  cus-article-href" data-id="{{  item.id }}">
                {{ item.title }}
            </div>
            <div class="wl-nei3 cus-article-href" data-id="{{  item.id }}">
                {{ showImg(item.thumbnail,getImgNum(item))}}
            </div>
            <ul class="wl-tubiao">
                <li><i class="iconfont icon-share_light"></i><span></span></li>
                <li><i class="iconfont icon-comment_light"></i><span>{{ item.comment_count}}</span></li>
                <li class="cus-article-fabulous" data-type="{{ item.isZan }}" data-id="{{  item.id }}">
                    {{# if(item.isZan == 0){ }}
                    <i class="iconfont icon-dianzan wl-fabulous-icon"></i>
                    {{# } }}

                    {{# if(item.isZan == 1){ }}
                    <i class="iconfont icon-dianzan1 cus-blue  wl-fabulous-icon"></i>
                    {{# } }}
                    <span class="wl-dian-one">{{ item.like}}</span>
                </li>
            </ul>
        </div>
        <div style="clear:both"></div>
    </div>

    {{#  } }}
    {{#  }); }}

</script>
<script>
    function getImgNum(obj) {
        if (obj.thumbnail == '') {
            return 1;
        }
        var thumbnail = $.parseJSON(obj.thumbnail);
        var thumbnailLength = Object.keys(thumbnail).length;
        if (thumbnailLength == 0) {
            return 1;
        } else if (thumbnailLength > 0 && thumbnailLength < 3) {
            if (obj.is_top != 0 || obj.recommended != 0) {
                return 2;
            } else {
                return 3;
            }
        } else {
            return 4;
        }
    }

    function showImg(obj, type) {
        var html = '';
        obj = $.parseJSON(obj);
        if (type == 4) {
            $.each(obj, function (k, v) {
                html += '<img src="' + v + '" alt="">';
            });
        } else {
            html += '<img src="' + obj.img_1 + '" alt="">';
        }
        return html;
    }

    $(document).on('click','.cus-article-href',function(){
        window.location.href = '/weixin/article/articleDetails/id/'+ $(this).data('id');
    });
    $(".wl-liebiao li").click(function () {
        $(this).addClass("actice").siblings().removeClass("actice");
        var index = $(this).index();
        $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
    });

    var mescroll = new MeScroll("container", {
        down: {auto: true},
        up: {
            clearEmptyId: "container-list",
            page: {num: 0, size: 20},
            htmlNodata: '<p class="upwarp-nodata">-- 已加载全部 --</p>',
            isBounce: false,
            noMoreSize: 5,
            empty: {
                tip: "亲,您还没有发表过文章~", //提示
            },
            callback: function (page) {
                listObj.searchList(page, function (curPageData) {
                    mescroll.endSuccess(curPageData.length);
                    layui.laytpl(templateList.innerHTML).render(curPageData, function (html) {
                        $('#container-list').append(html);
                    });
                }, function () {
                    mescroll.endErr();
                });
            }
        }
    });

    var listObj = {
        searchList: function (page, successCallback, errorCallback) {
            var data = $.extend({}, {type: 1, page: page.num, page_size: page.size});
            $.ajax({
                url: "/weixin/user/getPublishList",
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (res) {
                    successCallback(res.data.rows);
                },
            });
        },
        //文章点赞方法
        clickFabulousLading:false,
        clickFabulous:function (obj, flag) {
            var id = obj.data('id');
            var type = obj.data('type') == 1 ? 2 : 1;
             if(!listObj.clickFabulousLading){
                $.ajax({
                    url: "/weixin/user/giveFabulous",
                    type: 'post',
                    data: {obj_id: id, type: type,flag:1},
                    dataType: 'json',
                    beforeSend: function () {
                        listObj.clickFabulousLading = true;
                    },
                    complete: function () {
                        listObj.clickFabulousLading = false;
                    },
                    success: function (res) {
                            if (res.code == 200) {
                                    var num = parseInt(obj.find('.wl-dian-one').text());
                                    if (type == 1) {
                                        obj.data('click', 1);
                                        obj.find('.wl-dian-one').text(num + 1);
                                        obj.find('.wl-fabulous-icon').removeClass('icon-dianzan').addClass('cus-blue').addClass('icon-dianzan1');
                                    } else {
                                        obj.data('click', 0);
                                        obj.find('.wl-dian-one').text(num - 1);
                                        obj.find('.wl-fabulous-icon').removeClass('icon-dianzan1').removeClass('cus-blue').addClass('icon-dianzan');
                                    }

                            }else if(res.code == 401){
                            LoginBox.showBox().showTip('请先进行登录操作');
                        }else if(res.code == 403){
                            redream.showTip('您还没有该权限');
                        }
                    }
                });
            }
        },
    };

    $(document).on('click', '.cus-article-fabulous', function (event) {
        listObj.clickFabulous($(this), 1);
        event.stopPropagation();
    });
</script>

</body>
</html>