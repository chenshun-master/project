<?php /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\project\application\weixin\view\user\user_dialogue.html";i:1543485522;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="applicable-device" content="pc,mobile">
    <link rel="stylesheet" href="/static/css/user_dialogue.css">
    <link rel="stylesheet" href="/static/css/iconfont.css">
    <link rel="stylesheet" href="/static/css/dropload1.css" />
    <link rel="stylesheet" href="/static/css/function.css" />
    <title><?php echo config('conf.title'); ?></title>
    <style>
        .dropload-down{display: none;}
    </style>
</head>
<body style="background: #F2F2F2;" >
<header>

<div class="wl-top">
    <i class="iconfont icon-back_light" onclick="redream.toReferer()"></i>
    <?php echo htmlentities($uInfo['nickname']); ?>
</div>
</header>

<main  id="wl-container" style="padding-bottom: 150px !important;padding-top:50px;">
    <div id="wl-container-list">

    </div>
</main>

<div style="position: relative;display: none;" id="cus-tip-box">
    <div class="wl-weidu"><i class="iconfont icon-icon-angle-double-top" style="font-size: 20px;color: #7DB0E8;float: left;margin: 1px 4px 0px 7px;"></i><span id="">0</span>条新消息</div>
</div>

<footer>
    <div class="wl-foot" style="max-width: 750px">
        <textarea type="text"  <?php if(( $isFriend == 1)): ?>  placeholder="请输入留言信息"  <?php else: ?>  placeholder="禁止私信"  disabled  <?php endif; ?> class="neirong" id="cus-send-content"></textarea>
        <button class="wl-btn" id="cus-send-btn">发送</button>
    </div>
</footer>
</body>
<script src="/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/dropload.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/zepto.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/static/js/functions.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" >
    $('.wl-foot textarea').on('.kl1 input ', function () {
        if (($.trim($('.neirong').val()) !== "")) {
            $('.wl-btn').css({'color': '#7DB0E8'});
        } else {
            $('.wl-btn').css({'color': '#EBEBEB'});
            $('neirong').val('');
        }
    });
</script>
<script type="text/javascript" >
    var myObj = {
        uid:<?php echo htmlentities($uid); ?>,
        myPortrait:"<?php echo htmlentities($portrait); ?>",
        dialogue:{
            listData: {
                loading: false,
                ini: false,
                page: 0,
                page_total: 1,
                page_size: 15,
                record_id:0
            },
            templateLeft:function(data){
                return '<div class="wl-das">' +
                    '            <p class="wl-time">'+ data.created_time +'</p>' +
                    '            <div class="wl-conter" style="position: relative">' +
                    '                <div style="    position: absolute;left: 17px;top: 4px;">' +
                    '                    <img src="'+ data.send_user_portrait +'" alt="" width="40" height="40" onerror="this.src=\'/static/image/user/tou.png\'" >' +
                    '                </div>' +
                    '                    <div class="dbubble ">' +
                    '                        <div class="dbubble-text">'+ data.content +' </div>' +
                    '                        <div class="triangle-box triangle-box-left">' +
                    '                            <div class="triangle"></div>' +
                    '                        </div>' +
                    '                    </div>' +
                    '            </div><div style="clear: both"></div>' +
                    '        </div>';
            },
            templateRight:function(data){
                return '        <div class="wl-das">' +
                    '            <p class="wl-time">'+ data.created_time +'</p>' +
                    '            <div class="wl-conter"  style="position: relative">' +
                    '                <div style="    position: absolute;right: 17px;top: 4px;">' +
                    '                    <img src="'+ data.send_user_portrait +'" onerror="this.src=\'/static/image/user/tou.png\'" width="40" height="40">' +
                    '                </div>'+
                    '                <div class="dbubble1">' +
                    '                    <div class="dbubble-text">'+ data.content +'</div>' +
                    '                    <div class=" triangle-box triangle-box-right">' +
                    '                        <div class="triangle"></div>' +
                    '                    </div>' +
                    '                </div>' +
                    '            </div><div style="clear: both"></div>' +
                    '        </div>';
            },
            loadList: function (me) {
                if (myObj.dialogue.listData.loading) {
                    return false;
                }

                myObj.dialogue.listData.page++;
                if (myObj.dialogue.listData.ini == true) {
                    if (myObj.dialogue.listData.page > myObj.dialogue.listData.page_total) {
                        me.resetload();
                        return false;
                    }
                }

                $.ajax({
                    url: "/weixin/api/getDialogueList",
                    type: 'post',
                    data: {uid:myObj.uid,record_id:myObj.dialogue.listData.record_id,page: myObj.dialogue.listData.page, page_size: myObj.dialogue.listData.page_size},
                    dataType: 'json',
                    beforeSend: function () {
                        myObj.dialogue.listData.loading = true;
                    },
                    complete: function () {
                        myObj.dialogue.listData.loading = false;
                    },
                    success: function (res) {
                        if (res.code == 200) {
                            var ini = true;

                            if(myObj.dialogue.listData.record_id != 0){
                                ini = false;
                            }

                            $.each(res.data.rows,function(k,val){
                                if(myObj.dialogue.listData.record_id > val.id){
                                    myObj.dialogue.listData.record_id = val.id;
                                }else if(myObj.dialogue.listData.record_id == 0){
                                    myObj.dialogue.listData.record_id = val.id;
                                }

                                if(val.receive_user_id != myObj.uid){
                                    $('#wl-container-list').prepend(myObj.dialogue.templateLeft(val));
                                }else{
                                    $('#wl-container-list').prepend(myObj.dialogue.templateRight(val));
                                }
                            });

                            if(ini){
                                window.scrollTo(0, $(document).height());
                            }

                            if(res.data.unread_num > 0){
                                $('#cus-tip-box').show().find('span').text(res.data.unread_num);
                            }else{
                                $('#cus-tip-box').hide();
                            }
                        }
                        me.noData();
                        me.resetload();
                        me.lock('down');
                    }
                });
            }
        },
        sendContent:function(content){
            $.ajax({
                url: "/weixin/api/sendDialogueContent",
                type: 'post',
                data: {uid:myObj.uid,content:content},
                dataType: 'json',
                beforeSend: function () {
                    myObj.dialogue.listData.loading = true;
                },
                complete: function () {
                    myObj.dialogue.listData.loading = false;
                },
                success: function (res) {
                    if (res.code == 200) {
                        $('#wl-container-list').append(myObj.dialogue.templateRight({send_user_portrait:myObj.myPortrait,content:res.data.content,created_time:res.data.created_time}));
                        $('#cus-send-content').val('');
                        window.scrollTo(0, $(document).height());
                    }else{
                        alert('发送失败');
                    }
                }
            });
        },
    };

    $('#cus-send-btn').on('click',function(){
        var content = $.trim($('#cus-send-content').val());
        if(content != ''){
            myObj.sendContent(content);
        }
    });

    <?php if(($isFriend == 1)): ?>
        $('#wl-container').dropload({
            scrollArea: window,
            loadUpFn: function (me) {
                myObj.dialogue.listData.loading = false;
                myObj.dialogue.listData.ini = false;
                myObj.dialogue.listData.page = 0;
                myObj.dialogue.listData.page_total = 1;
                myObj.dialogue.loadList(me);
            },
            loadDownFn: function (me) {
                myObj.dialogue.loadList(me);
            }
        });
    <?php endif; ?>
</script>
</html>