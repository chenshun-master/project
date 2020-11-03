<?php /*a:1:{s:79:"D:\phpstudy\PHPTutorial\WWW\project\application\index\view\article\graphic.html";i:1545734507;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo config('conf.title'); ?> - 发表文章</title>
    <link rel="stylesheet" href="/static/web/css/test.css">
    <link rel="stylesheet" href="/static/web/css/graphic.css">
    <link rel="stylesheet" href="/static/web/css/relrase.css">
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/css/function.css">
    <link rel="stylesheet" href="/static/plugin/layui/css/layui.css">
</head>
<body  style="background: #F8F8F8"   >
<div class="wl-con" >
    <div class="wl-top" >
        <div style="position:relative;width:1265px;margin:0 auto;top:20px;left: 10px">
            <img src="/static/web/image/logo1.png" alt="" >
        </div>
    </div>
    <div class="wl-zhanghao-box" style="position:relative;width:1265px;margin:0 auto;top:-80px;right: 42px;cursor: pointer">
        <div class="wl-zhanghao" style="right:0;">
            <p style="height: 80px;padding-top: 9px; background: #7DB0E8;" class="wl-xian">
                <img src="<?php echo htmlentities($user_info['portrait']); ?>" class="wl-toux" onerror="this.src='/static/web/image/tou.png'"/>
                <span style="color: white;margin-left: 48px;float: left;margin-top: -1px;"><?php echo htmlentities($user_info['nickname']); ?></span><i class="iconfont icon-triangledownfill" style="color: white;"></i> </p>
            <div class="wl-cang" style="display: none">
                <a href="/index/user/main"> <p class="wl-xiany" id="wl-anquan"><i class="iconfont icon-shezhi" style="font-size: 22px;margin-right: 10px"></i>账号设置</p></a>
                <p class="wl-xiany" onclick="redream.href('/index/user/signOut')"><i class="iconfont icon-guanbi" style="font-size: 18px;margin-right: 10px"></i>退出登录</a></p>
            </div>
        </div>
    </div>
    <div class="wl-tabc" style="width: 100%">
        <div class="tab-box" style="position: relative;min-height:600px;">
            <div class="wl-nide">
                <ul  class="wl-top-liebiao">
                    <li class="wl-yingj"><i class="iconfont icon-quanbu2 wl-biao" style="font-size: 25px;"></i>文章列表<i class="iconfont icon-triangleupfill wl-xiala qiehuan" style="font-size: 20px;top: 0;"></i></li>
                    <div class="wl-ding">
                        <a href="/index/article/article"> <li >发表文章</li> </a>
                        <a href="/index/article/graphic"> <li class="action">我的文章 </li></a>
                    </div>
                </ul>
                <ul  class="wl-top-liebiao" style="margin-top: 10px">
                    <a href="/index/shop/index">
                        <li class=""><i class="iconfont icon-quanbu2 wl-biao" style="font-size: 25px;"></i>分销商品<i class="iconfont icon-triangledownfill wl-xiala " style="font-size: 20px;top: 0;"></i></li>
                    </a>
                    <div class="wl-ding"></div>
                </ul>
                <a href="/index/user/certification">
                    <div class="wl-shiming"><i class="iconfont icon-medal_light wl-biao" style="font-size: 25px;"></i>实名认证<i class="iconfont icon-triangledownfill wl-xiala" style="font-size: 20px;top: 0;"></i></div>
                </a>
                <a href="/seller/index">
                    <div class="wl-shiming" style="margin-top: 10px">
                        <i class="iconfont icon-wodexingqiu_shoucangdeshangpin wl-biao" style="font-size: 25px;"></i>商户管理
                    </div>
                </a>
            </div>
            <div class="wl-fabu">
                <p>我的文章</p>
                <div class="wl-xianshi-neirong">
                    <div class="wl-all-title">
                        <?php if((count($rows) > 0)): ?>
                        <span style="display: inline-block;float: left">共 <?php echo htmlentities($total); ?> 条数据，已显示 <?php echo count($rows); ?> 条</span>
                        <?php endif; if(($draftId > 0)): ?>
                            <span style="cursor: pointer;display: inline-block;float: right">
                                <a href="<?php echo url('/index/article/article',['id'=>$draftId]); ?>" style="color: #ff8868;" title="立即编辑">温馨提示：您有草稿还没发布哦！</a>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div id="container-list">
                        <?php if((count($rows) > 0)): foreach($rows as $key=>$val): ?>
                            <div class="wl-all-neirong">
                                <div class="wl-all-left">
                                    <img src="<?php echo !empty($val['thumbnail']) ? htmlentities($val['thumbnail']['img_1']) : ''; ?>" alt="<?php echo htmlentities($val['title']); ?>" onerror="this.src='/static/web/image/diushi.jpg'"/>
                                </div>
                                <div class="wl-all-center">
                                    <dl><?php echo htmlentities($val['title']); ?></dl>
                                    <dt>已发表</dt>
                                    <dd><?php echo htmlentities($val['published_time']); ?></dd>
                                </div>
                                <div class="wl-all-right" style="cursor: pointer;float: right">
                                    <span style="margin-left: 2px"><a href="<?php echo url('/index/article/article',['id'=>$val['id']]); ?>" target="_blank">修改</a></span>
                                    <span style="margin-left: 2px"><a href="<?php echo url('/weixin/article/articleDetails',['id'=>$val['id']]); ?>" target="_blank">查看</a></span>
                                </div>
                            </div>
                            <?php endforeach; else: ?>
                        <div class="wl-weifabiao">
                            <dl class="iconfont icon-wushuju"></dl>
                            <dt>你还没有发布过文章</dt>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div id="wl-fenye" ></div>
                </div>
                <footer class="wl-foot" style=""><?php echo config('conf.copyright'); ?></footer>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/plugin/layui/layui.js"></script>
<script>
    layui.use(['laypage', 'layer'], function(){
        var laypage = layui.laypage,layer = layui.layer;
        laypage.render({
            elem: 'wl-fenye'
            ,limit:15
            ,count:<?php echo htmlentities($total); ?>
            ,curr:<?php echo htmlentities($page); ?>
            ,jump: function(obj, first){
                if(!first){
                    window.location.href = '/index/article/graphic/page/'+obj.curr;
                }
            }
        });
    });

    $(".wl-xian").click(function () {
        $(".wl-cang").toggle();
    });
    $(".wl-yingj").click(function () {
        $(".wl-ding").toggle();
        $(".qiehuan").toggleClass('iconfont  icon-triangledownfill');
        $(".qiehuan").toggleClass('iconfont icon-triangleupfill');
    })
    $('.wl-tabc').click(function () {
        $('.wl-cang').hide();
    })
</script>
</html>