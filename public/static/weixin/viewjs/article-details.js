var objClass = {
    article_id: conf.article_id,
    u_id: conf.u_id,
    recommendData: {
        loading: false,
        ini: false,
        page: 0,
        page_total: 1,
        page_size: 3,
    },
    loadRecommendList: function () {
        if (this.recommendData.loading) {
            return false;
        }
        this.recommendData.page++;
        if (this.recommendData.ini == true) {
            if (this.recommendData.page > this.recommendData.page_total) {
                $('#cus-recommend-loading-btn').text('没有了');
                return false;
            }
        }
        $.ajax({
            url: "/weixin/article/getRelevantList",
            type: 'post',
            data: {id: this.article_id, page: this.recommendData.page, page_size: this.recommendData.page_size},
            dataType: 'json',
            beforeSend: function () {
                objClass.recommendData.loading = true;
                $('#cus-recommend-loading-btn').text('加载中...');
            },
            complete: function () {
                objClass.recommendData.loading = false;
                $('#cus-recommend-loading-btn').text('查看更多');
            },
            success: function (res) {
                if (res.code == 200) {
                    var data = res.data;
                    if (objClass.recommendData.ini == false) {
                        objClass.recommendData.ini = true;
                        objClass.recommendData.page_total = data.page_total;
                        if (data.page_total == 0) {
                            $('.wl-tuijian').hide();
                        } else {
                            $('.wl-tuijian').show();
                        }
                    }

                    layui.laytpl(demo.innerHTML).render(res.data.rows, function(html){
                        $('#cus-recommend-content').append(html);
                    });
                }
            }
        });
    },
    clickFabulous: function () {
        var type = $('#cus-click-fabulous').data('fabulous');
        $.ajax({
            url: "/weixin/user/giveFabulous",
            type: 'post',
            data: {obj_id: objClass.article_id, type: type,flag:1},
            dataType: 'json',
            beforeSend: function () {
                objClass.oneLoading = true;
            },
            complete: function () {
                objClass.oneLoading = false;
            },
            success: function (res) {
                if (res.code == 200) {
                    var num = parseInt($('#cus-click-fabulous').find('span').text());
                    if(type == 1){
                        $('#cus-click-fabulous').data('fabulous', 2);
                        $('#cus-click-fabulous').find('i').removeClass('icon-dianzan').addClass("icon-dianzan1").addClass('cus-blue');
                        $('#cus-click-fabulous').find('span').text( num + 1);
                    }else{
                        $('#cus-click-fabulous').data('fabulous', 1);
                        $('#cus-click-fabulous').find('i').removeClass('cus-blue').removeClass('icon-dianzan1').removeClass('icon-dianzan1').addClass("icon-dianzan");
                        $('#cus-click-fabulous').find('span').text( num - 1);
                    }
                } else if (res.code == 401) {
                    LoginBox.showBox().showTip('请先进行登录操作');
                }
            }
        });
    },
    commentData: {
        loading: false,
        ini: false,
        page: 0,
        page_total: 1,
        page_size: 15,
        // template: function (data) {
        //     var css =  data.isZan == 1 ? 'icon-dianzan1 cus-blue ': 'icon-dianzan';
        // }
    },
    loadCommentList: function () {
        if (this.commentData.loading) {
            return false;
        }
        this.commentData.page++;
        if (this.commentData.ini == true) {
            if (this.commentData.page > this.commentData.page_total) {
                $('#cus-comment-tip').show();
                return false;
            }
        }

        $.ajax({
            url: "/weixin/article/getCommentList",
            type: 'post',
            data: {id: this.article_id, page: this.commentData.page, page_size: this.commentData.page_size},
            dataType: 'json',
            beforeSend: function () {
                objClass.commentData.loading = true;
            },
            complete: function () {
                objClass.commentData.loading = false;
            },
            success: function (res) {
                if (res.code == 200) {
                    var data = res.data;
                    if (objClass.commentData.ini == false) {
                        $('#cus-comment-content').html('');
                        objClass.commentData.ini = true;
                        objClass.commentData.page_total = data.page_total;
                        if (data.page_total == 0) {
                            $('#cus-comment').hide();
                        } else {
                            $('#cus-comment').show();
                        }
                    }
                    layui.laytpl(demo1.innerHTML).render(res.data.rows, function(html){
                        $('#cus-comment-content').append(html);
                    });

                }
            }
        });
    },
    //评论点赞方法
    clickCommentFabulousLading:false,
    clickCommentFabulous:function (obj, flag) {
        var id = obj.data('id');
        var type = obj.data('click') == 1 ? 2 : 1;
        if(type == 2){
            return false;
        }else if(!objClass.clickCommentFabulousLading){
            $.ajax({
                url: "/weixin/user/giveFabulous",
                type: 'post',
                data: {obj_id: id, type: type,flag:2},
                dataType: 'json',
                beforeSend: function () {
                    objClass.clickCommentFabulousLading = true;
                },
                complete: function () {
                    objClass.clickCommentFabulousLading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if (flag == 1) {
                            var num = parseInt(obj.find('.wl-dian-one').text());
                            if (type == 1) {
                                obj.data('click', 1);
                                obj.find('.wl-dian-one').text(num + 1);
                                obj.find('.wl-fabulous-icon').removeClass('icon-dianzan').addClass('cus-blue').addClass('icon-dianzan1');
                            } else {
                                obj.data('click', 0);
                                obj.find('.wl-dian-one').text(num - 1);
                                obj.find('.wl-fabulous-icon').removeClass('icon-dianzan1').addClass('cus-blue').addClass('icon-dianzan');
                            }
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
    publishCommentConf:{
        loading:false,
    },
    publishComment:function(){
        var content = $('.wl-text').val();
        $('.wl-text').focus();
        $('.wl-text').val('');

        var pid = $('#cus-comment-pid').val();
        if(this.publishCommentConf.loading){
            return false;
        }
        objClass.publishCommentConf.loading = true;
        $.ajax({
            url: "/weixin/api/createComment",
            type: 'post',
            data: {type:1,pid: 0, obj_id: objClass.article_id,content:content},
            dataType: 'json',
            beforeSend: function () {
                objClass.publishCommentConf.loading = true;
            },
            success: function (res) {
                objClass.publishCommentConf.loading = false;
                if (res.code == 200) {
                    $('.wl-text').val('');
                    $('.wx-foot').show();
                    $('.wl-zhez2').hide();
                    document.activeElement.blur();
                    $(".wl-zhez2").blur();
                    $('.wl-zhez2').hide();
                    $(".wl-text").val("");
                    redream.showTip('发布成功');
                    objClass.commentData.ini= false;
                    objClass.commentData.page= 0;
                    objClass.commentData.page_total= 0;
                    objClass.loadCommentList();
                    $('.neirong').val('');
                }else if (res.code == 401){
                    LoginBox.showBox().showTip('请先进行登录操作');
                }else if (res.code == 403){
                    redream.showTip('您还没有授权');
                }else{
                    redream.showTip('评论失败');
                }
            }
        });
    },
    hrefDetails:function(id){
        window.location.href = '/weixin/article/articleDetails/id/' + id;
    },
    isAdd:false,
    addFriendLoading:false,
    showAddFriend:function(){
        if(!this.isAdd){
            $(".wl-zhezhao").toggle();
        }else{
            redream.showTip('不能重复申请...');
        }
    },
    submitFriendApply:function(){
        var remarks = $.trim($('#fr-friend-remarks').val());
        if(redream.isEmptyStr(remarks)){
            redream.showTip('申请备注不能为空...');
            return false;
        }else if(!this.addFriendLoading){
            $.ajax({
                url: "/weixin/user/addFriend",
                type: 'post',
                data: {friend_id: objClass.u_id,remarks:remarks},
                dataType: 'json',
                beforeSend:function(){
                    objClass.addFriendLoading = true;
                },
                complete:function(){
                    objClass.addFriendLoading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        objClass.isAdd = true;
                        redream.showTip('申请提交成功...');
                        $('#cus-add-friend').text('已申请');
                        $(".wl-zhezhao").toggle();
                    }else if (res.code == 401){
                        $('.wl-zhezhao').hide();
                        LoginBox.showBox().showTip('请先进行登录操作');
                    }else if (res.code == 403){
                        redream.showTip('您还没有授权');
                    }else{
                        redream.showTip(res.msg);
                    }
                }
            });
        }
    },
    myFavorite:{
        loading:false,
        submit:function(){
            if(objClass.myFavorite.loading){
                return false;
            }
            $.ajax({
                url: "/weixin/user/giveFavorite",
                type: 'post',
                data: {obj_id:objClass.article_id,flag:1,type:1},
                dataType: 'json',
                beforeSend: function () {
                    objClass.myFavorite.loading = true;
                },
                success: function (res) {
                    objClass.myFavorite.loading = false;
                    if (res.code == 200) {
                        $('#cus-click-favorite').removeClass('icon-favor_light').addClass('icon-favor_fill_light').addClass('cus-favorite');
                        objClass.myFavorite.loading = true;
                        redream.showTip('收藏成功...');
                    }else if(res.code == 401){
                        LoginBox.showBox().showTip('请先进行登录操作');
                    }
                }
            });
        }
    },
    showAddFriend:function(){
        if(!this.isAdd){
            $(".wl-zhezhao").toggle();
        }else{
            redream.showTip('不能重复申请...');
        }
    }
};

$('.wl-neirong img').removeAttr('style');

$(".wl-foot-input").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".wl-zhez2").toggle();
    $('.wl-text').focus();
});

$(document).on('click', '.cus-touser-main', function () {
    window.location.href = '/weixin/article/userMain/id/' + $(this).data('user_id');
});

$('#cus-myshare-box').on('click', function () {
    $(this).hide();
});

$('#cus-click-favorite').on('click', function () {
    objClass.myFavorite.submit();
});

$(document).on('input', 'textarea', function () {
    if (($.trim($('.wl-text').val()) !== "")) {
        $('.wl-fabu').css({'color': '#7DB0E8'});
    } else {
        $('.wl-fabu').css({'color': '#EBEBEB'});
    }
});

//点击空白处隐藏弹出层
$(".wl-zhez2").click(function (event) {
    var _con = $('.wl-zl2'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.wl-zhez2').hide(); //淡出消失
    }
});

$(".wl-zhezhao").click(function (event) {
    var _con = $('.wl-zhe1'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.wl-zhezhao').hide(); //淡出消失
    }
});
$(document).on('click', '.cus-recommend-href', function () {
    window.location.href = '/weixin/article/articleDetails/id/' + $(this).data('id');
});

$(document).on('click', '.cus-comment-fabulous', function () {
    objClass.clickCommentFabulous($(this), 1);
});

$('.wl-neirong').find('p').removeAttr('style');
$('.wl-guanbi1').click(function () {
    $('.wl-zhezhao').hide();
});

objClass.loadRecommendList();
objClass.loadCommentList();