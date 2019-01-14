(function(window, $){
    function LoginBox(){
        /**
         * 是否初始化
         * @type {boolean}
         */
        this.ini = false;

        this.smsObj = null;

        /**
         * 显示登录窗口
         */
        this.showBox= function(){
            if(this.ini === false){
                this.loadBoxHtml();
            }

            $('.wl-mask').show();
        };

        /**
         * 关闭隐藏登录窗口
         */
        this.hideBox= function(){
            $('.wl-mask').hide();
        };

        /**
         * 加载登录窗口的html代码
         */
        this.loadBoxHtml = function(){
            this.ini = true;
            var box = `<div class="wl-mask" >
                            <div class="wl-login-mask">
                                <div id="wl-login-box" >
                                    <div class="wl-login-box-header">
                                        <div id="wl-login-box-tip"></div>
                                        <div class="wl-login-box-close">
                                            <i class="iconfont icon-guanbi1" style="font-size: 34px;color: #cec2c2"></i>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                    
                                    <div class="wl-login-box-body">
                                        <div class="wl-login-box-tab">
                                            <ul class="wl-qiehuan">
                                                <li  class="active">短信验证码登录</li>
                                                <li>账号密码登录</li>
                                            </ul>
                                            <div style="clear:both"></div>
                                            <div class="wl-content">
                                                <div class="wl-qie active">
                                                    <div class="wl-sms">
                                                        <div class="wl-phone">
                                                            <input type="text" id="login-mobile1" placeholder="请输入你的手机号" style="width: 70%;" >
                                                            <span id="wl-login-box-sendsms">获取验证码</span>
                                                        </div>
                                                        <div class="wl-phone">
                                                            <input type="text" id="login-sms-code" maxlength="6"  placeholder="短信验证码" onkeyup="this.value=this.value.replace(/\\D/g,'')" onafterpaste="this.value=this.value.replace(/\\D/g,'')" >
                                                        </div>
                                                        <div class="wl-login-box-btn1  wl-login-box-btn">登录</div>
                                                    </div>
                                                    <div style="clear:both"></div>
                                                </div>
                    
                                                <div class="wl-qie">
                                                    <div class="wl-sms">
                                                        <div class="wl-phone">
                                                            <input type="text" id="login-mobile2" placeholder="请输入您的账号">
                                                        </div>
                                                        <div class="wl-phone">
                                                            <input type="password" id="login-pwd" placeholder="请输入您的密码">
                                                        </div>
                                                        <div class="wl-login-box-btn2 wl-login-box-btn">登录</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wl-key-log wl-login-box-type" data-type="weixin"><i class="iconfont  icon-weixin1"></i>微信授权登录>></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

            $('body').append(box);
            this.loadEvent();
        };

        /**
         * 密码登录
         */
        this.pwdLogin = function(){
            var _this = this,mobile = $('#login-mobile2').val(),pwd = $('#login-pwd').val();
            if(!redream.checkMobile(mobile)){
                _this.showTip('手机号格式错误');
            }else if(pwd == ''){
                _this.showTip('请输入登录密码');
            }else{
                $.ajax({
                    url:"/weixin/index/postLogin",
                    type:'post',
                    data:{mobile:mobile,password:pwd},
                    dataType:'json',
                    success:function(res){
                        if(res.code == 200){
                            _this.showTip('登录成功');
                            setTimeout(function(){
                                window.location.reload();
                            },1500);
                        }else {
                            _this.showTip('登录失败');
                        }
                    }
                });
            }
        };

        /**
         * 短信快捷登录
         */
        this.smsLogin = function(){
            var _this = this,mobile = $('#login-mobile1').val(),sms_code = $('#login-sms-code').val();
            if(!redream.checkMobile(mobile)){
                _this.showTip('手机号格式错误');
            }else if(sms_code.length !== 6){
                _this.showTip('验证码错误');
            }else{
                $.ajax({
                    url:"/weixin/index/codeLogin",
                    type:'post',
                    data:{mobile:mobile,sms_code:sms_code},
                    dataType:'json',
                    success:function(res){
                        if(res.code == 200){
                            _this.showTip('登录成功');
                            setTimeout(function(){
                                window.location.reload();
                            },1500);
                        }else {
                            _this.showTip('登录失败');
                        }
                    }
                });
            }
        };

        /**
         * 发送短信登录验证码
         */
        this.sendSms = function(){
            var _this = this,mobile = $('#login-mobile1').val();
            if(!redream.checkMobile(mobile)){
                _this.showTip('手机号格式错误');
            }else{
                $.ajax({
                    url:"/weixin/index/sendQuickLoginSmsCode",
                    type:'post',
                    data:{mobile:mobile},
                    dataType:'json',
                    success:function(res){
                        if(res.code == 200){
                            _this.showTip('验证码发送成功');
                            _this.smsObj.trigger();
                        }else {
                            _this.showTip(res.msg);
                        }
                    }
                });
            }
        };

        /**
         * 显示错误提示信息
         */
        this.showTip = function(msg){
            $('#wl-login-box-tip').fadeIn("slow").delay(2000).fadeOut().text(msg);
        };

        /**
         * 加载绑定事假
         */
        this.loadEvent = function(){
            this.smsObj = new SmsCode('wl-login-box-sendsms','获取验证码','code-hui','wl-login-sms',60);
            var _this = this;
            $(document).on('click','#wl-login-box-sendsms',function(){
                if(!_this.smsObj.checkTime()){
                    _this.sendSms();
                }
            });

            $(document).on('click','.wl-login-box-close',function(){
                _this.hideBox();
            });

            $(document).on('click','.wl-login-box-btn1',function(){
                _this.smsLogin();
            });

            $(document).on('click','.wl-login-box-btn2',function(){
                _this.pwdLogin();
            });


            $(document).on('click','.wl-login-box-type',function(){
                window.location.href = '/weixin/index/otherLogin?platform='+$(this).data('type');
            });

            $(".wl-qiehuan li").click(function () {　　　　 //获取点击的元素给其添加样式，讲其兄弟元素的样式移除
                $(this).addClass("active").siblings().removeClass("active");　　　　 //获取选中元素的下标
                var index = $(this).index();
                $(this).parent().siblings().children().eq(index).addClass("active").siblings().removeClass("active");
            });

            $('.wl-sms').on('input',function(){
                if(($.trim($('#login-mobile1').val())!=="")&&($.trim($('#login-sms-code').val())!=="")){
                    $('.wl-login-box-btn1').css({'background':'#7DB0E8'});
                }else{
                    $('.wl-login-box-btn1').css({'background':'#EBEBEB'});
                }
            }).on('input',function(){
                if(($.trim($('#login-mobile2').val())!=="")&&($.trim($('#login-pwd').val())!=="")){
                    $('.wl-login-box-btn2').css({'background':'#7DB0E8'});
                }else{
                    $('.wl-login-box-btn2').css({'background':'#EBEBEB'});
                }
            });

            //点击空白处隐藏弹出层
            $(".wl-mask").click(function (event) {
                var _con = $('.wl-login-mask'); // 设置目标区域
                if (!_con.is(event.target) && _con.has(event.target).length == 0) {
                    $('.wl-mask').hide(); //淡出消失
                }
            });
        };
    }

    /**
     * 验证码倒计时类
     * @param idSelector       ID 选择器名( 不带 '#' 符号)
     * @param characters       倒计时完成后按钮的提示文字
     * @param btnClass         按钮发送中的class 类
     * @param alias            别名不能重复
     * @param second           倒计时秒
     * @constructor
     */
    function SmsCode(idSelector,text,btnClass,alias,second){
        this.options = {
            idSelector :idSelector,
            characters :text,
            btnClass   :btnClass,
            alias      :alias,
            second     :second,
        };

        this.getTime = function(){
            var time =  sessionStorage.getItem(this.options.alias);
            if(time == null){
                return 0;
            }else{
                var date = new Date();
                var time1 = parseInt(date.getTime()/1000);

                var time2 = time - time1;

                if(time2 >= 0){
                    return time2;
                }else{
                    sessionStorage.removeItem(this.options.alias);
                    return 0;
                }
            }
        };

        this.setTime = function(){
            var date = new Date();
            var time = parseInt(date.getTime()/1000);
            return sessionStorage.setItem(this.options.alias,time + this.options.second);
        };

        /**
         * 验证发送验证码时间是否在倒计时中
         */
        this.checkTime = function(){
            if(this.getTime() > 0){
                return true;
            }else{
                return false;
            }
        };

        /**
         * 页面打开是运行
         * @returns {undefined}
         */
        this.run = function(){
            if(this.getTime() > 0){
                this.count();
            }
        };

        /**
         * 倒计时
         * @param maxtime  倒计时数
         */
        this.count = function(){
            var _this = this;
            function CountDown() {
                if (_this.getTime() > 0) {
                    document.getElementById(_this.options.idSelector).innerHTML = '('+ _this.getTime() + "s)重新获取";
                    document.getElementById(_this.options.idSelector).classList.add(_this.options.btnClass);
                    document.getElementById(_this.options.idSelector).disabled = true;
                }
                else {
                    clearInterval(_this.timer);
                    document.getElementById(_this.options.idSelector).innerHTML = _this.options.characters;
                    document.getElementById(_this.options.idSelector).classList.remove(_this.options.btnClass);
                    document.getElementById(_this.options.idSelector).disabled = false;
                    sessionStorage.removeItem(_this.options.alias);
                }
            }

            _this.timer = setInterval(CountDown, 1000);
        };

        /**
         * 触发并开始倒计时
         */
        this.trigger = function(){
            this.setTime();
            this.count();
        };

        //初始化运行
        this.run();
    }

    window.SmsCode = SmsCode;
    window.LoginBox = new LoginBox();
})(window, jQuery);