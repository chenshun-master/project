WechatSdkModel = (function(){

    /**
     * [WechatSdkModel 微信SDK接口类]
     * @param {[json Obj]} wx_config [微信SDK配置文件]
     */
    function WechatSdkModel(wx_config,callbacks){
        this.wx_config = wx_config;
        console.log(wx_config);

        wx.config({
            debug:false,
            appId: this.wx_config.appId,
            timestamp: this.wx_config.timestamp,
            nonceStr: this.wx_config.nonceStr,
            signature: this.wx_config.signature,
            jsApiList: [
                'checkJsApi',
                "onMenuShareTimeline",              //分享给好友
                "onMenuShareAppMessage",            //分享到朋友圈
                "onMenuShareQQ",                    //分享到QQ
                "onMenuShareWeibo",                 //分享到微博
                "checkJsApi"          //如果需要调扫码  侧加入至列表
            ]
        });

        wx.ready(function(){
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，
            // 所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，
            // 则可以直接调用，不需要放在ready函数中。

            callbacks();
        });

        wx.error(function(res){
            //config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，
            //也可以在返回的res参数中查看，对于SPA可以在这里更新签名。

            alert(res);
        });
    };

    // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
    WechatSdkModel.prototype.checkJsApi = function(wxCallbacks){
        var length = arguments.length;
        wx.checkJsApi({
            jsApiList: this.wx_config.jsApiList,
            success: function(res) {
                // 以键值对的形式返回，可用的api值true，不可用为false
                // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                if(length == 1){
                    wxCallbacks(res);
                }

            }
        });
    }

    // 2. 分享接口
    // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
    WechatSdkModel.prototype.onMenuShareAppMessage = function(wxData,wxCallback){
        console.log(wxData);
        wx.onMenuShareAppMessage({
            title: wxData.title, 										// 分享标题
            desc: wxData.desc, 											// 分享描述
            link: wxData.link, 											// 分享链接
            imgUrl: wxData.imgUrl, 										// 分享图标
            type: wxData.type || 'link', 								// 分享类型,music、video或link，不填默认为link
            dataUrl: wxData.dataUrl || '', 								// 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                wxCallback.success();									// 用户确认分享后执行的回调函数
            },
            cancel: function () {
                wxCallback.cancel();									// 用户取消分享后执行的回调函数
            },
            fail: function () {
                wxCallback.fail();										//接口调用失败时执行的回调函数
            },
            complete: function () {
                wxCallback.complete();									// 接口调用完成时执行的回调函数，无论成功或失败都会执行。
            },
            trigger: function () {
                wxCallback.complete();									//监听Menu中的按钮点击时触发的方法，该方法仅支持Menu中的相关接口。
            }
        });
    };

    // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
    WechatSdkModel.prototype.onMenuShareTimeline = function(wxData,wxCallback){
        wx.onMenuShareTimeline({
            title: wxData.title, 										// 分享标题
            desc: wxData.desc, 											// 分享描述
            link: wxData.link, 											// 分享链接
            imgUrl: wxData.imgUrl, 										// 分享图标
            success: function () {
                wxCallback.success();									// 用户确认分享后执行的回调函数
            },
            cancel: function () {
                wxCallback.cancel();									// 用户取消分享后执行的回调函数
            },
            fail: function () {
                wxCallback.fail();										//接口调用失败时执行的回调函数
            },
            complete: function () {
                wxCallback.complete();									// 接口调用完成时执行的回调函数，无论成功或失败都会执行。
            },
            trigger: function () {
                wxCallback.complete();									//监听Menu中的按钮点击时触发的方法，该方法仅支持Menu中的相关接口。
            }
        });
    };

    // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
    WechatSdkModel.prototype.onMenuShareQQ =function(wxData,wxCallback){
        wx.onMenuShareQQ({
            title: wxData.title, 										// 分享标题
            desc: wxData.desc, 											// 分享描述
            link: wxData.link, 											// 分享链接
            imgUrl: wxData.imgUrl, 										// 分享图标
            success: function () {
                wxCallback.success();									// 用户确认分享后执行的回调函数
            },
            cancel: function () {
                wxCallback.cancel();									// 用户取消分享后执行的回调函数
            },
            fail: function () {
                wxCallback.fail();										//接口调用失败时执行的回调函数
            },
            complete: function () {
                wxCallback.complete();									// 接口调用完成时执行的回调函数，无论成功或失败都会执行。
            },
            trigger: function () {
                wxCallback.complete();									//监听Menu中的按钮点击时触发的方法，该方法仅支持Menu中的相关接口。
            }
        });
    };

    // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
    WechatSdkModel.prototype.onMenuShareWeibo = function(wxData,wxCallback){
        wx.onMenuShareQQ({
            title: wxData.title, 										// 分享标题
            desc: wxData.desc, 											// 分享描述
            link: wxData.link, 											// 分享链接
            imgUrl: wxData.imgUrl, 										// 分享图标
            success: function () {
                wxCallback.success();									// 用户确认分享后执行的回调函数
            },
            cancel: function () {
                wxCallback.cancel();									// 用户取消分享后执行的回调函数
            },
            fail: function () {
                wxCallback.fail();										//接口调用失败时执行的回调函数
            },
            complete: function () {
                wxCallback.complete();									// 接口调用完成时执行的回调函数，无论成功或失败都会执行。
            },
            trigger: function () {
                wxCallback.complete();									//监听Menu中的按钮点击时触发的方法，该方法仅支持Menu中的相关接口。
            }
        });
    };

    // 2.5 监听“分享到QZone”按钮点击、自定义分享内容及分享接口
    WechatSdkModel.prototype.onMenuShareQZone = function(wxData,wxCallback){
        wx.onMenuShareQZone({
            title: wxData.title, 										// 分享标题
            desc: wxData.desc, 											// 分享描述
            link: wxData.link, 											// 分享链接
            imgUrl: wxData.imgUrl, 										// 分享图标
            success: function () {
                wxCallback.success();									// 用户确认分享后执行的回调函数
            },
            cancel: function () {
                wxCallback.cancel();									// 用户取消分享后执行的回调函数
            },
            fail: function () {
                wxCallback.fail();										//接口调用失败时执行的回调函数
            },
            complete: function () {
                wxCallback.complete();									// 接口调用完成时执行的回调函数，无论成功或失败都会执行。
            },
            trigger: function () {
                wxCallback.complete();									//监听Menu中的按钮点击时触发的方法，该方法仅支持Menu中的相关接口。
            }
        });
    };


    // 3 智能接口
    var voice = {localId: '',serverId: ''};

    // 3.1 识别音频并返回识别结果
    WechatSdkModel.prototype.translateVoice = function (localId) {
        wx.translateVoice({
            localId: localId,
            complete: function (res) {
                if (res.hasOwnProperty('translateResult')) {
                    alert('识别结果：' + res.translateResult);
                } else {
                    alert('无法识别');
                }
            }
        });
    };


    // 4 音频接口
    // 4.2 开始录音
    WechatSdkModel.prototype.startRecord = function (localId) {
        wx.startRecord({
            cancel: function () {
                alert('用户拒绝授权录音');
            }
        });
    };

    // 4.3 停止录音
    WechatSdkModel.prototype.stopRecord = function () {
        wx.stopRecord({
            success: function (res) {
                voice.localId = res.localId;
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });
    };



    // 5 图片接口
    // 5.1 拍照、本地选图
    var images = {localId: [],serverId: []};
    WechatSdkModel.prototype.chooseImage = function () {
        wx.chooseImage({
            success: function (res) {
                images.localId = res.localIds;
                alert('已选择 ' + res.localIds.length + ' 张图片');
            }
        });
    };



    // 5.2 图片预览
    /**
     * [previewImage description]
     * @param  {[string]} current_url 		[当前显示的图片的地址]
     * @param  {[array]} urls        		[图片列表]
     * @return {[type]}             [description]
     */
    WechatSdkModel.prototype.previewImage = function (current_url,urls) {
        wx.previewImage({
            current: current_url,
            urls: urls
        });
    };


    // 6 设备信息接口
    // 6.1 获取当前网络状态
    WechatSdkModel.prototype.getNetworkType = function(){
        wx.getNetworkType({
            success: function (res) {
                alert(res.networkType);
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });
    }


    // 7 地理位置接口
    // 7.1 查看地理位置
    WechatSdkModel.prototype.catLocation = function(){
        wx.getLocation({
            success: function (res) {
                wx.openLocation({
                    latitude: res.latitude,
                    longitude: res.longitude,
                    name: 'TIT 创意园',
                    address: '广州市海珠区新港中路 397 号',
                    scale: 14,
                    infoUrl: 'http://weixin.qq.com'
                });
            },
            cancel: function (res) {
                alert('用户拒绝授权获取地理位置');
            }
        });
    };


    // 8 界面操作接口
    // 8.1 隐藏右上角菜单
    WechatSdkModel.prototype.hideOptionMenu = function(){
        wx.hideOptionMenu();
    }

    // 8.2 隐藏右上角菜单
    WechatSdkModel.prototype.showOptionMenu = function(){
        wx.showOptionMenu();
    }

    /*
     * 8.3 批量隐藏菜单项  例如:
     * [
     * 	    'menuItem:readMode', 		// 阅读模式
     * 	    'menuItem:share:timeline', 	// 分享到朋友圈
     *      'menuItem:copyUrl' 			// 复制链接
     * ]
    */
    WechatSdkModel.prototype.hideMenuItems = function(menuLists){
        wx.hideMenuItems({
            menuList: menuLists,
            success: function (res) {
                alert('已隐藏“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });
    }

    /*
     * 8.4 批量显示菜单项  例如:
     * [
     * 	    'menuItem:readMode', 		// 阅读模式
     * 	    'menuItem:share:timeline', 	// 分享到朋友圈
     *      'menuItem:copyUrl' 			// 复制链接
     * ]
    */
    WechatSdkModel.prototype.hideMenuItems = function(menuLists){
        wx.showMenuItems({
            menuList: menuLists,
            success: function (res) {
                alert('已显示“阅读模式”，“分享到朋友圈”，“复制链接”等按钮');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
            }
        });
    }

    // 8.5 隐藏所有非基本菜单项
    WechatSdkModel.prototype.hideAllNonBaseMenuItem = function(){
        wx.hideAllNonBaseMenuItem({
            success: function () {
                alert('已隐藏所有非基本菜单项');
            }
        });
    }

    // 8.6 显示所有被隐藏的非基本菜单项
    WechatSdkModel.prototype.hideAllNonBaseMenuItem = function(){
        wx.showAllNonBaseMenuItem({
            success: function () {
                alert('已显示所有非基本菜单项');
            }
        });
    }

    // 8.7 关闭当前窗口
    WechatSdkModel.prototype.hideAllNonBaseMenuItem = function(){
        wx.closeWindow();
    }

    // 9 微信原生接口
    // 9.1.1 扫描二维码并返回结果
    WechatSdkModel.prototype.scanQRCode = function(){
        wx.scanQRCode();
    }

    // 9.1.2 扫描二维码并返回结果
    WechatSdkModel.prototype.scanQRCode = function(){
        wx.scanQRCode({
            needResult: 1,
            desc: 'scanQRCode desc',
            success: function (res) {
                alert(JSON.stringify(res));
            }
        });
    }

    // 10 微信支付接口
    // 10.1 发起一个支付请求
    WechatSdkModel.prototype.scanQRCode = function(){
        // 注意：此 Demo 使用 2.7 版本支付接口实现，建议使用此接口时参考微信支付相关最新文档。
        wx.chooseWXPay({
            timestamp: 1414723227,
            nonceStr: 'noncestr',
            package: 'addition=action_id%3dgaby1234%26limit_pay%3d&bank_type=WX&body=innertest&fee_type=1&input_charset=GBK&notify_url=http%3A%2F%2F120.204.206.246%2Fcgi-bin%2Fmmsupport-bin%2Fnotifypay&out_trade_no=1414723227818375338&partner=1900000109&spbill_create_ip=127.0.0.1&total_fee=1&sign=432B647FE95C7BF73BCD177CEECBEF8D',
            signType: 'SHA1', // 注意：新版支付接口使用 MD5 加密
            paySign: 'bd5b1933cda6e9548862944836a9b52e8c9a2b69'
        });
    }

    // 11.3  跳转微信商品页
    WechatSdkModel.prototype.openProductSpecificView = function(productId,extInfo){
        wx.openProductSpecificView({
            productId: productId,
            extInfo: extInfo
        });
    }

    // 12 微信卡券接口
    /**
     * [addCard 添加卡券]
     * @param {[array]} cardLists [卡券列表]
     * [
     *      {
     *         cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
     *         cardExt: '{"code": "", "openid": "", "timestamp": "1418301401", "signature":"f6628bf94d8e56d56bfa6598e798d5bad54892e5"}'
     *      },
     *      {
     *         cardId: 'pDF3iY9tv9zCGCj4jTXFOo1DxHdo',
     *         cardExt: '{"code": "", "openid": "", "timestamp": "1418301401", "signature":"f6628bf94d8e56d56bfa6598e798d5bad54892e5"}'
     *      }
     *   ]
     */
    WechatSdkModel.prototype.addCard = function(cardLists){
        wx.addCard({
            cardList: cardLists,
            success: function (res) {
                alert('已添加卡券：' + JSON.stringify(res.cardList));
            },
            cancel: function (res) {
                alert(JSON.stringify(res))
            }
        });
    }


    // 12.2 选择卡券
    WechatSdkModel.prototype.chooseCard = function(){
        wx.chooseCard({
            cardSign: '',
            timestamp: 000000000000,
            nonceStr: '',
            success: function (res) {
                res.cardList = JSON.parse(res.cardList);
                encrypt_code = res.cardList[0]['encrypt_code'];
                alert('已选择卡券：' + JSON.stringify(res.cardList));
                decryptCode(encrypt_code, function (code) {
                    codes.push(code);
                });
            },
            cancel: function (res) {
                alert(JSON.stringify(res))
            }
        });
    }


    //返回构造函数本身
    return WechatSdkModel;
})();