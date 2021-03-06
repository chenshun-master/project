<?php /*a:1:{s:80:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\collection.html";i:1548119468;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--  <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport" />-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="viewport" content="target-densitydpi=device-dpi, width=750px, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="telephone=no" name="format-detection"/>
    <title><?php echo config('conf.title'); ?></title>
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/collection.css"/>
    <link rel="stylesheet" type="text/css" href="/static/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/static/weixin/css/dropload.css"/>
    <style>
        .cus-click-href,.cus-article-href2,.cus-article-fabulous{cursor: pointer;}
        .cus-blue{color: #7DB0E8}
        .wl-ttu{    margin-top: 14px !important;}
    </style>
</head>
<style>

</style>
<body style="background: #ffffff;">
<div class="wl-con">
    <div class="wx-content">
        <header>
            <div class="top" style="position: relative;margin: 0">
                <a href="/weixin/user/main"><i class="iconfont icon-back_light" style="    font-size: 40px; position: absolute;top: 4px;left: 11px;" ></i></a>
                <div  class="wl-ttu" style="border-bottom: 1px solid #EEEEEE;">
                    <div style="margin: 0 auto;width: 43%;">
                        <span id="one">收藏</span>
                        <span id="two">评论</span>
                        <span id="three">点赞</span>
                    </div>
                </div>
            </div>
        </header>
        <div class="xia">
            <div class="one ones " id="cus-favorite-container" style="padding-bottom: 110px;margin-top: 0px">
                <div class="one-1 lists" id="cus-favorite-container-list" >
                </div>
            </div>
                <div class="one w-one3" id="cus-comment-container" style="padding-bottom: 110px;margin-top: 0px">
                    <div class="one-1 lists" id="cus-comment-container-list" >
                    </div>
                </div>
            <div class="one" style=";padding-bottom: 110px;margin-top: 0px" id="cus-like-container">
                <div class="one-1 lists" id="cus-like-container-list" >
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(function () {
        $(".ones").show();
        $(".top span").eq(0).addClass("se");
        var a,b,c,index = 0;
        $(".top span").click(function () {
            index = $(this).index();
            $(".xia .one").eq(index).show().siblings().hide();
            $(".top span").eq(index).addClass("se").siblings().removeClass("se");
            if (index == 0) {
                a = 1;
            }
            if (index == 1) {
                b = 1;
            }
            if (index == 2) {
                c = 1;
            }
            if (a == 1 && b == 1 && c == 1) {
                $("#xiao").hide();
            }
        });

        var url = window.location.toString();
        var maodian = url.split('#')[1];
        if(maodian == 'favorite'){
            $('#one').trigger('click');
        }else if(maodian == 'comment'){
            $('#two').trigger('click');
        }else if(maodian == 'like'){
            $('#three').trigger('click');
        }
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

        isZanLoadind:false,
        clickFabulous:function(obj){
            var id = obj.data('id');
            var type = obj.data('click') == 1 ?2:1;
            if(!myObj.isZanLoadind){
                $.ajax({
                    url: "/weixin/user/giveFabulous",
                    type: 'post',
                    data: {obj_id: id, type: type,flag:1},
                    dataType:'json',
                    beforeSend:function(){
                        myObj.isZanLoadind = true;
                    },
                    complete:function(){
                        myObj.isZanLoadind = false;
                    },
                    success:function(res){
                        if(res.code == 200){
                            var num = parseInt(obj.find('span').text());
                            if(type == 1){
                                obj.data('click',1);
                                obj.find('span').text(num + 1);
                                obj.find('i').removeClass('icon-dianzan').addClass('icon-dianzan1').addClass('cus-blue');
                            }else{
                                obj.data('click',0);
                                obj.find('span').text(num - 1);
                                obj.find('i').removeClass('icon-dianzan1').removeClass('cus-blue').addClass('icon-dianzan');
                            }
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
        myObj.clickFabulous($(this));
        event.stopPropagation();
    });

    $(function(){
        $("#cus-favorite-container-list,#cus-comment-container-list,#cus-like-container-list").css('minHeight','300px');
    });
</script>

</html>