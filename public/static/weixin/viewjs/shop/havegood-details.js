var mySwiper = new Swiper('.swiper-container', {
    autoplay: true,//可选选项，自动滑动
    pagination: {
        el: '.swiper-pagination',
    }
});
$(".cus-ping").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".marsk-container").show();
    $("body,html").css({
        "height":"100%",
        "overflow":"hidden"
    });
});

$(".marsk-container").click(function (event) {
    var _con = $('.tkyy_con'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.marsk-container').hide(); //淡出消失
    }
}).on('touchstart', function (event) {
    var _con = $('.tkyy_con'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.marsk-container').hide(); //淡出消失
        $("body").removeClass("body");
    }
    event.stopPropagation(); //停止事件冒泡
});

$(".wl-quxiao").click(function () {
    $(".marsk-container").hide();
    $("body").removeClass("body");
    $("body,html").css({"height":"100%","overflow":"auto"});
});

$('.wl-tan-pinglun').on('touchstart', function () {
    $('.wl-foot-gundong').css('overflowY', "auto");
}).on('click', function () {
    $('.wl-foot-gundong').css('overflowY', "auto");
});

$(".wl-foot-input").click(function (event) {
    event.stopPropagation(); //停止事件冒泡
    $(".wl-zhez2").toggle();
    $('.wl-text').focus();
});

$(document).on('input', 'textarea', function () {
    if (($.trim($('.wl-text').val()) !== "")) {
        $('.wl-fabu').css({'color': '#7DB0E8'});
    } else {
        $('.wl-fabu').css({'color': '#B7B7B9'});
    }
});

//点击空白处隐藏弹出层
$(".wl-zhez2").click(function (event) {
    var _con = $('.wl-zl2'); // 设置目标区域
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.wl-zhez2').hide(); //淡出消失
    }
});

$(".wl-fenxiang").click(function () {
    $("#cus-myshare-box").show();
});
$("#cus-myshare-box").click(function () {
    $("#cus-myshare-box").hide();
});

$(".wl-zhezhao").click(function (event) {
    var _con = $('.wl-zhe1');
    if (!_con.is(event.target) && _con.has(event.target).length == 0) {
        $('.wl-zhezhao').hide();
    }
});

var myObj = {
    getCommentList: function () {
        $.ajax({
            url: "/weixin/api/getCommentList",
            type: 'get',
            data: {type:3,obj_id: $('#fr-good-goods-id').val(),page: 1,page_size: 10000},
            dataType: 'json',
            success: function (res) {
                if (res.code == 200) {
                    $('#container-list').html('');
                    if (res.data.page_total == 0) {
                        $('#container-list').html(' <div class="wl-no-shuju"> <dl class="iconfont icon-tianxierenzhengxinxi"></dl> <dt>暂无评论</dt></div>');
                    }
                    $("#cus-pinglun-num").html(res.data.total);
                    layui.laytpl(templateList.innerHTML).render(res.data.rows, function (html) {
                        $('#container-list').append(html);
                    });
                }
            }
        });
    },
    recommended: {
        listData: {
            gid: $('#fr-good-goods-id').val(),
            loading: false,
            ini: false,
            page: 0,
            page_total: 1,
            page_size: 3,
        },
        loadList: function () {
            if (myObj.recommended.listData.loading) {
                return false;
            }
            myObj.recommended.listData.page++;
            if (myObj.recommended.listData.ini == true) {
                if (myObj.recommended.listData.page > myObj.recommended.listData.page_total) {
                    return false;
                }
            }
            $.ajax({
                url: "/weixin/shopapi/getGoodGoodsRelevant",
                type: 'post',
                data: {
                    gid: myObj.recommended.listData.gid,
                    page: myObj.recommended.listData.page,
                    page_size: myObj.recommended.listData.page_size
                },
                dataType: 'json',
                beforeSend: function () {
                    myObj.recommended.listData.loading = true;
                },
                complete: function () {
                    myObj.recommended.listData.loading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if (myObj.recommended.listData.ini == false) {
                            myObj.recommended.listData.ini = true;
                            myObj.recommended.listData.page_total = res.data.page_total;
                            $('#recommended-List').html('');
                            if (res.data.page_total == 0) {
                                $('#recommended-List').html(' <div class="wl-no-shuju" style="margin-top: 40px"> <dl class="iconfont icon-tianxierenzhengxinxi" style="font-size: 30px"></dl> <dt style="margin: 0">暂无商品</dt></div>');
                            }
                        }
                        layui.laytpl(recommendedList.innerHTML).render(res.data.rows, function (html) {
                            $('#recommended-List').append(html);
                        });
                    }
                }
            });
        }
    },
    giveLikeLoading: false,
    giveLike: function (o, dataObj) {
        if (myObj.giveLikeLoading == false) {
            $.ajax({
                url: "/weixin/user/giveFabulous",
                type: 'post',
                data: dataObj,
                dataType: 'json',
                beforeSend: function () {
                    myObj.giveLikeLoading = true;
                },
                complete: function () {
                    myObj.giveLikeLoading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if (dataObj.flag == 2) {
                            var num = parseInt(o.find('.wl-dian-one').text());
                            if (dataObj.type == 1) {
                                o.data('type', 1).find('.iconfont').addClass("cus-red");
                                num++;
                                o.find('.wl-dian-one').text(num);
                            } else {
                                o.data('type', 0).find('.iconfont').removeClass('cus-red');
                                num--;
                                o.find('.wl-dian-one').text(num);
                            }
                        } else if (dataObj.flag == 3) {
                            if (dataObj.type == 1) {
                                o.data('type', 1).removeClass('icon-emojilight').addClass("icon-emojifill").addClass('cus-sou');
                            } else {
                                o.data('type', 0).removeClass('cus-sou').removeClass('icon-emojifill').addClass("icon-emojilight");
                            }
                        }
                    } else if (res.code == 401) {
                        redream.showTip('请登录后操作...');
                    }
                }
            });
        }
    },

    collectionLoading: false,
    collection: function (o, dataObj) {
        if (myObj.collectionLoading == false) {
            $.ajax({
                url: "/weixin/user/giveFavorite",
                type: 'post',
                data: dataObj,
                dataType: 'json',
                beforeSend: function () {
                    myObj.collectionLoading = true;
                },
                complete: function () {
                    myObj.collectionLoading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        if (dataObj.flag == 3) {
                            if (dataObj.type == 1) {
                                o.data('type', 1).removeClass('icon-favor_light').addClass("icon-favor_fill_light").addClass('cus-sou');
                            } else {
                                o.data('type', 0).removeClass('icon-favor_fill_light').removeClass('cus-sou').addClass("icon-favor_light");
                            }
                        }
                    } else if (res.code == 401) {
                        redream.showTip('请登录后操作...');
                    }
                }
            });
        }
    },
    publishCommentConf: {loading: false},
    publishComment: function (type, flag) {
        var content = $('.wl-text').val();
        $('.wl-text').focus();
        $('.wl-text').val('');
        var pid = $('#cus-comment-pid').val();
        if(myObj.publishCommentConf.loading == false){
            $.ajax({
                url: "/weixin/api/createComment",
                type: 'post',
                data: {type:3,obj_id: $('#fr-good-goods-id').val(),content: content},
                dataType: 'json',
                beforeSend: function () {
                    myObj.publishCommentConf.loading = true;
                },
                success: function (res) {
                    myObj.publishCommentConf.loading = false;
                    if (res.code == 200) {
                        $('.wl-zhez2').hide();
                        $('.wl-text').val('').blur();
                        $('.wl-foot-gundong ').animate({scrollTop:0});
                        myObj.getCommentList();
                        redream.showTip('发布成功');
                    } else if (res.code == 401) {
                        redream.showTip('请先进行登录');
                        $('.wl-zhez2').hide();
                    }else{
                        redream.showTip('评论失败');
                    }
                }
            });
        }
    },
    isAdd: false,
    addFriendLoading: false,
    showAddFriend: function () {
        if (!this.isAdd) {
            $(".wl-zhezhao").toggle();
        } else {
            redream.showTip('不能重复申请...');
        }
    },
    //好友申请
    submitFriendApply: function () {
        var remarks = $.trim($('#fr-friend-remarks').val());
        if (redream.isEmptyStr(remarks)) {
            redream.showTip('申请备注不能为空...');
            return false;
        } else if (!this.addFriendLoading) {
            $.ajax({
                url: "/weixin/user/addFriend",
                type: 'post',
                data: {
                    friend_id: $('#fr-user-id').val(),
                    remarks: remarks
                },
                dataType: 'json',
                beforeSend: function () {
                    myObj.addFriendLoading = true;
                },
                complete: function () {
                    myObj.addFriendLoading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        myObj.isAdd = true;
                        redream.showTip('申请提交成功...');
                        $('#cus-add-friend').text('已申请');
                        $(".wl-zhezhao").toggle();
                        $(".wl-zhezhao").hide();
                    } else if (res.code == 401) {
                        redream.showTip('请先进行登录');
                    } else if (res.code == 403) {
                        redream.showTip('您还没有授权');
                    } else {
                        redream.showTip(res.msg);
                    }
                }
            });
        }
    },
};

myObj.getCommentList();
myObj.recommended.loadList();

$(document).on('click', '#click-place-order', function () {
    window.location.href = '/weixin/shop/goodsDetails?goodsid=' + $('#fr-goodid').val() + '&gid=' + $('#fr-good-goods-id').val();
}).on('click', '.click-to-havegoodDetails', function () {
    window.location.href = '/weixin/shop/goodsDetails?goodsid=' + $(this).data('id') ;
}).on('click', '.cus-touser-main', function () {
    window.location.href = '/weixin/article/userMain/id/' + $(this).data('user_id');
}).on('click', '.cus-comment-fabulous', function () {
    var type = $(this).data('type') ==0 ?1:2;
    myObj.giveLike($(this), {type: type, obj_id: $(this).data('id'), flag: 2});
}).on('click', '#cus-click-collection', function () {
    var type = $(this).data('type') ==0 ?1:2;
    myObj.collection($(this), {type: type, obj_id: $('#fr-good-goods-id').val(), flag: 3});
});

$('#cus-click-fabulous').on('click', function () {
    var type = $(this).data('type') ==0 ?1:2;
    myObj.giveLike($(this), {type: type, obj_id: $('#fr-good-goods-id').val(), flag: 3});
});

$('#wl-goods-detail').find('img').removeAttr('width').removeAttr('height');
$('#wl-goods-detail').find('table').removeAttr('width').removeAttr('height');