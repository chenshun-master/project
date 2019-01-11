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
            }else{

            }
        };

        /**
         * 关闭隐藏登录窗口
         */
        this.hideBox= function(){
            $('#wl-login-box').hide();
        };

        /**
         * 加载登录窗口的html代码
         */
        this.loadBoxHtml = function(){
            this.ini = true;

            this.loadEvent();
        };

        /**
         * 密码登录
         */
        this.pwdLogin = function(){
            var _this = this,mobile = $('#login-mobile2').val(),pwd = $('#login-pwd').val();
            if(!redream.checkMobile(mobile)){
                _this.showTip('手机号格式错误');
            }else if(sms_code.length !== 6){
                _this.showTip('验证码错误');
            }else{
                $.ajax({
                    url:"/weixin/index/postLogin",
                    type:'post',
                    data:{mobile:mobile,password:pwd},
                    dataType:'json',
                    success:function(res){
                        if(res.code == 200){
                            _this.showTip('登录成功');
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
                    _this.showTip('验证码发送成功');

                    //这里是登录处理
                    _this.smsObj.trigger();
                }
            });


            $(document).on('click','.wl-login-box-close',function(){
                _this.hideBox();
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