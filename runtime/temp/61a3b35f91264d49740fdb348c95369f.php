<?php /*a:2:{s:86:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\certification-me.html";i:1549940378;s:78:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\layout\layout.html";i:1549940378;}*/ ?>
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
    
<link rel="stylesheet" href="/static/weixin/css/collection1.css">
<link rel="stylesheet" type="text/css" href="/static/weixin/css/dropload.css"/>

</head>

<body id="main-body">
    
<div>
    <i class="iconfont icon-back_light wl-fanhui "onclick="redream.toReferer()"></i>
    <ul class="wl-deji">
        <li class="active left-li" id="one">收藏</li>
        <li id="two">评论</li>
        <li id="three">点赞</li>
    </ul>
    <div class="content">
        <div class="wl-d active" id="cus-favorite-container">
            <div id="cus-favorite-container-list" >
            </div>
        </div>
        <div class="wl-d" id="cus-comment-container">
            <div id="cus-comment-container-list" >
            </div>
        </div>
        <div class="wl-d" id="cus-like-container">
            <div id="cus-like-container-list" >
            </div>
        </div>
    </div>
</div>


    <script type="text/javascript">
        const baseConfig ={
            autoLogin:<?php echo config('conf.weixin_automatic_logon')?1:0; ?>,
        };
    </script>
    <script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/js/functions.js"></script>
    <script src="/static/weixin/viewjs/login-box.js"></script>
    
<script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(".wl-deji li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
        $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
        var index = $(this).index();
        $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");

    });
</script>
<script type="text/javascript">
    var myObj = {
        favorite:{
            listData:{
                loading:false,
                ini:false,
                page:0,
                page_total:1,
                page_size:20,
            },

            loadList:function(me){
                if(myObj.favorite.listData.loading){
                    return false;
                }

                myObj.favorite.listData.page++;
                if(myObj.favorite.listData.ini == true){
                    if(myObj.favorite.listData.page > myObj.favorite.listData.page_total){
                        me.resetload();
                        return false;
                    }
                }

                $.ajax({
                    url:"/weixin/user/getFavoriteArticleList",
                    type:'post',
                    data:{page:myObj.favorite.listData.page,page_size:myObj.favorite.listData.page_size},
                    dataType:'json',
                    beforeSend:function(){
                        myObj.favorite.listData.loading = true;
                    },
                    complete:function(){
                        myObj.favorite.listData.loading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            if(myObj.favorite.listData.ini == false){
                                myObj.favorite.listData.ini = true;
                                myObj.favorite.listData.page_total = res.data.page_total;
                                $('#cus-favorite-container-list').html('');
                            }
                            $('#cus-favorite-container-list').append(res.data.html);
                            if(myObj.favorite.listData.page >= myObj.favorite.listData.page_total){
                                me.noData();
                            }
                        }
                        me.resetload();
                    }
                });
            },
        },
        comment:{
            listData:{
                loading:false,
                ini:false,
                page:0,
                page_total:1,
                page_size:20,
            },
            loadList:function(me){
                if(myObj.comment.listData.loading){
                    return false;
                }

                myObj.comment.listData.page++;
                if(myObj.comment.listData.ini == true){
                    if(myObj.comment.listData.page > myObj.comment.listData.page_total){
                        me.resetload();return false;
                    }
                }

                $.ajax({
                    url:"/weixin/user/getCommentArticleList",
                    type:'post',
                    data:{type:1,page:myObj.comment.listData.page,page_size:myObj.comment.listData.page_size},
                    dataType:'json',
                    beforeSend:function(){
                        myObj.comment.listData.loading = true;
                    },
                    complete:function(){
                        myObj.comment.listData.loading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            if(myObj.comment.listData.ini == false){
                                myObj.comment.listData.ini = true;
                                myObj.comment.listData.page_total = res.data.page_total;
                                $('#cus-comment-container-list').html('');
                            }

                            $('#cus-comment-container-list').append(res.data.html);

                            if(myObj.comment.listData.page >= myObj.comment.listData.page_total){
                                me.noData();
                            }
                        }
                        me.resetload();
                    }
                });
            },
        },
        like:{
            listData:{
                loading:false,
                ini:false,
                page:0,
                page_total:1,
                page_size:20,
            },
            loadList:function(me){
                if(myObj.like.listData.loading){
                    return false;
                }

                myObj.like.listData.page++;
                if(myObj.like.listData.ini == true){
                    if(myObj.like.listData.page > myObj.like.listData.page_total){
                        me.resetload();return false;
                    }
                }

                $.ajax({
                    url:"/weixin/user/getLikeArticleList",
                    type:'post',
                    data:{type:1,page:myObj.like.listData.page,page_size:myObj.like.listData.page_size},
                    dataType:'json',
                    beforeSend:function(){
                        myObj.like.listData.loading = true;
                    },
                    complete:function(){
                        myObj.like.listData.loading = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            if(myObj.like.listData.ini == false){
                                myObj.like.listData.ini = true;
                                myObj.like.listData.page_total = res.data.page_total;
                                $('#cus-like-container-list').html('');
                            }

                            $('#cus-like-container-list').append(res.data.html);

                            if(myObj.like.listData.page >= myObj.like.listData.page_total){
                                me.noData();
                            }
                        }
                        me.resetload();
                    }
                });
            },
        },
        //用户点赞操作

        //文章点赞方法
        clickFabulousLading:false,
        clickFabulous:function (obj) {
            var id = obj.data('id');
            var type = obj.data('type') == 1 ? 2 : 1;
            console.log(obj.data('type'));
            if(!myObj.clickFabulousLading){
                $.ajax({
                    url: "/weixin/user/giveFabulous",
                    type: 'post',
                    data: {obj_id: id, type: type,flag:1},
                    dataType: 'json',
                    beforeSend: function () {
                        myObj.clickFabulousLading = true;
                    },
                    complete: function () {
                        myObj.clickFabulousLading = false;
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

    $('#cus-favorite-container').dropload({
        scrollArea : window,
        loadUpFn:function(me){
            myObj.favorite.listData.loading = false;
            myObj.favorite.listData.ini = false;
            myObj.favorite.listData.page = 0;
            myObj.favorite.listData.page_total = 0;
            myObj.favorite.loadList(me);
        },
        loadDownFn : function(me){
            myObj.favorite.loadList(me);
        }
    });

    $('#cus-comment-container').dropload({
        scrollArea : window,
        loadUpFn:function(me){
            myObj.comment.listData.loading = false;
            myObj.comment.listData.ini = false;
            myObj.comment.listData.page = 0;
            myObj.comment.listData.page_total = 0;
            myObj.comment.loadList(me);
        },
        loadDownFn : function(me){
            myObj.comment.loadList(me);
        }
    });

    $('#cus-like-container').dropload({
        scrollArea : window,
        loadUpFn:function(me){
            myObj.like.listData.loading = false;
            myObj.like.listData.ini = false;
            myObj.like.listData.page = 0;
            myObj.like.listData.page_total = 0;
            myObj.like.loadList(me);
        },
        loadDownFn : function(me){
            myObj.like.loadList(me);
        }
    });


    $(document).on('click','.cus-click-href',function(){
        if($(this).data('type') == 1){
            window.location.href = '/weixin/article/articleDetails/id/'+ $(this).data('id');
        }
    });

    $(document).on('click','.cus-article-href2',function(){
        window.location.href = '/weixin/article/userMain/id/'+ $(this).data('user_id');
    });

    $(document).on('click','.cus-article-fabulous',function(event){
        myObj.clickFabulous($(this),1);
        event.stopPropagation();
    });

    // $(function(){
    //     $("#cus-favorite-container-list,#cus-comment-container-list,#cus-like-container-list").css('minHeight','300px');
    // });
    $(".wl-deji li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
        $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
        var index = $(this).index();
        $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");

    });


</script>

</body>
</html>