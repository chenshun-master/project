<?php /*a:1:{s:85:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\userArticleList.html";i:1548119468;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--  <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport" />-->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection"/>
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/home_page.css"/>
    <link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_890503_bqq4ljep3ij.css"/>
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/dropload.css"/>
    <title><?php echo config('conf.title'); ?></title>
    <style>
        /*.wkf{*/
            /*display: none;*/
            /*position: fixed;*/
            /*top: 565px;*/
            /*left: 256px;*/
            /*width: 240px;*/
            /*height: 56px;*/
            /*line-height: 56px;*/
            /*text-align: center;*/
            /*background: #0FD6DD;*/
            /*color: #FFFFFF;*/
            /*font-size:0.28rem;*/
            /*border-radius:10px ;*/
        /*}*/

        .souBak{
            color: #7DB0E8 !important;
        }
        .href,.cus-article-fabulous,.cus-article-href{
            cursor: pointer;
        }
    </style>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/rem.js" type="text/javascript" charset="utf-8"></script>
</head>

<body style="background: #ffffff;">
<div class="con">
    <div class="wx-top">
        <a onclick="redream.toReferer()"  class="tb href"></a><?php echo !empty($user_info['nickname']) ? htmlentities($user_info['nickname']) : htmlentities(mobileFilter($user_info['mobile'])); ?>
    </div>
    <div class="wx-t1">
        <img src="<?php echo htmlentities($user_info['portrait']); ?>"  onclick="redream.href('/weixin/user/main')" onerror='this.src="/static/image/user/tou.png"' />
        <div class="wx-wen">
            <dl>
                <dt><?php echo htmlentities($publishStatistics['article']); ?></dt>
                <dd>文章</dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities($publishStatistics['video']); ?></dt>
                <dd>视频</dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities($publishStatistics['diary']); ?></dt>
                <dd>案例</dd>
            </dl>
            <dl>
                <dt><?php echo htmlentities($publishStatistics['goodsgood']); ?></dt>
                <dd>热门商品</dd>
            </dl>
            <button id="btn">
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
                <?php endif;?></button>
            <button onclick="redream.href('/weixin/user/modify')" id="btn1">编辑资料</button>
        </div>
    </div>

    <div id="cus-container">
        <div id="cus-container-list">

        </div>
    </div>
</div>

</body>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var objClass = {
        listData:{
            loading:false,
            ini:false,
            page:0,
            page_total:1,
            page_size:20,
        },

        //相关推荐数据加载
        loadList:function(me){
            if(this.listData.loading){
                return false;
            }

            this.listData.page++;
            if(this.listData.ini == true){
                if(this.listData.page > this.listData.page_total){
                    me.resetload();return false;
                }
            }
            $.ajax({
                url:"/weixin/user/getPublishList",
                type:'post',
                data:{type:1,page:this.listData.page,page_size:this.listData.page_size},
                dataType:'json',
                beforeSend:function(){
                    objClass.listData.loading = true;
                },
                complete:function(){
                    objClass.listData.loading = false;
                },
                success:function(res){
                    if(res.code == 200){
                        if(objClass.listData.ini == false){
                            objClass.listData.ini = true;
                            objClass.listData.page_total = res.data.page_total;
                            $('#cus-container-list').html('');
                        }
                        $('#cus-container-list').append(res.data.htmlContent);
                        if(objClass.listData.page >= objClass.listData.page_total){
                            me.noData();
                        }
                    }
                    me.resetload();
                }
            });
        },

        //用户点赞操作
        clickFabulous:function(obj){
            var id = obj.data('id');
            var type = obj.data('click') == 1 ?2:1;
            $.ajax({
                url:"/weixin/article/clickZan",
                type:'post',
                data:{id:id,type:type},
                dataType:'json',
                beforeSend:function(){
                    objClass.oneLoading = true;
                },
                complete:function(){
                    objClass.oneLoading = false;
                },
                success:function(res){
                    if(res.code == 200){
                        if(type == 1){
                            obj.data('click',1);
                            obj.find('.cus-article-like-num').text(parseInt(obj.find('.cus-article-like-num').text()) + 1);
                            obj.find('.cus-tubiao').removeClass('icon-appreciate_light').addClass('icon-appreciate_fill_light').addClass('souBak');


                        }else{
                            obj.data('click',0);
                            obj.find('.cus-article-like-num').text(parseInt(obj.find('.cus-article-like-num').text()) -1);
                            obj.find('.cus-tubiao').removeClass('icon-appreciate_fill_light').removeClass('souBak').addClass('icon-appreciate_light');
                        }
                    }
                }
            });
        },
    };

    $('#cus-container').dropload({
        scrollArea : window,
        loadUpFn:function(me){
            objClass.listData.loading = false;
            objClass.listData.ini = false;
            objClass.listData.page = 0;
            objClass.listData.page_total = 0;
            objClass.loadList(me);
        },
        loadDownFn : function(me){
            objClass.loadList(me);
        }
    });



    $(document).on('click','.cus-article-fabulous',function(event){
        objClass.clickFabulous($(this));
        event.stopPropagation();
    });

    $(document).on('click','.cus-article-href',function(){
        window.location.href = '/weixin/article/articleDetails/id/'+ $(this).data('id');
    });

    $(document).on('click','.cus-article-href2',function(){
        // window.location.href = '/weixin/article/userMain/id'+ $(this).data('user_id');
    });

    $(function () {
        $("#cus-container-list").css('minHeight','300px');
    })
</script>
</html>