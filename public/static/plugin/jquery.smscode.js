(function(window){

    /**
     * 验证码倒计时类
     * @param idSelector       ID 选择器名( 不带 '#' 符号)
     * @param characters       倒计时完成后按钮的提示文字
     * @param btnClass         按钮发送中的class 类
     * @param alias            别名不能重复
     * @param second           倒计时秒
     * @constructor
     */
    function Code(idSelector,text,btnClass,alias,second){
        this.options = {
            idSelector :idSelector,
            characters :text,
            btnClass   :btnClass,
            alias      :alias,
            second     :second,
        };

        //初始化运行
        this.run();
    }

    Code.prototype.getTime = function(){
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

    Code.prototype.setTime = function(){
        var date = new Date();
        var time = parseInt(date.getTime()/1000);
        return sessionStorage.setItem(this.options.alias,time + this.options.second);
    };

    /**
     * 验证发送验证码时间是否在倒计时中
     */
    Code.prototype.checkTime = function(){
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
    Code.prototype.run = function(){
        if(this.getTime() > 0){
            this.count();
        }
    };

    /**
     * 倒计时
     * @param maxtime  倒计时数
     */
    Code.prototype.count = function(){
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
    Code.prototype.trigger = function(){
        this.setTime();
        this.count();
    };

    window.Code = Code;
})(window);