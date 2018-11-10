(function(window){

    /**
     * 验证码倒计时类
     * @param idSelector       ID 选择器名( 不带 '#' 符号)
     * @param characters       倒计时完成后按钮的提示文字
     * @param btnClass         按钮发送中的class 类
     * @constructor
     */
    function VerificationCode(idSelector,characters,btnClass){
        this.idSelector= idSelector;
        this.characters = characters;
        this.btnClass = btnClass;
    }

    /**
     * 验证发送验证码时间是否在倒计时中
     */
    VerificationCode.prototype.checkTime = function(){
        if(window.name == '' || window.name == 0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 验证发送验证码时间是否过期
     */
    VerificationCode.prototype.sendSmsCode = function(){
        if(!this.checkTime()){
            this.count(60);
        }
    }

    /**
     * 页面打开是运行
     * @returns {undefined}
     */
    VerificationCode.prototype.run = function(){
        if(this.checkTime()){
            this.count(window.name);
        }
    }

    /**
     * 倒计时
     * @param maxtime  倒计时数
     */
    VerificationCode.prototype.count = function(maxtime){
        var _this = this;
        var maxtime = maxtime;
        function CountDown() {
            if (maxtime >= 0) {
                seconds = Math.floor(maxtime % 60);//秒
                document.getElementById(_this.idSelector).innerHTML = '('+ seconds + "s)重新获取";
                document.getElementById(_this.idSelector).classList.add(_this.btnClass);

                // document.getElementById(_this.idSelector).disabled = true;
                --maxtime;
                window.name = maxtime;
            }
            else {
                clearInterval(timer);
                document.getElementById(_this.idSelector).innerHTML = _this.characters;
                document.getElementById(_this.idSelector).classList.remove(_this.btnClass);
                // document.getElementById(_this.idSelector).disabled = false;
                window.name = '';
            }
        }

        timer = setInterval(CountDown, 1000);
    }

    window.VerificationCode = VerificationCode;
})(window);