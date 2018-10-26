(function(window,$){
    window.redream = {

        /**
         * 获取随机字符串
         * @param len        字符串长度
         * @returns {string}
         */
        randomString:function(len){
            len = len || 32;
            var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
            var maxPos = $chars.length;
            var pwd = '';
            for (i = 0; i < len; i++) {
                pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
            }
            return pwd;
        },

        /**
         * 消息提示框
         * @param message   提示内容
         * @param time      消息自动消失时间 (默认 2 秒)
         */
        showTip:function(message,time){
            var time = time || 2000;
            var idSelector = this.randomString(20)+ new Date().getTime();
            $('body').append('<div class="wkf" id="'+ idSelector+'" style="display: block">'+message+'</div>');
            $('#'+ idSelector).show().delay(time).fadeOut();
            (function(id,tt){
                setTimeout(function(){
                    $('#'+ id).remove();
                },tt);
            })(idSelector,time);
        },

        /**
         * 验证手机号格式
         * @param mobile
         * @returns {boolean}
         */
        checkMobile:function(mobile){
            var reg = /^[1][3,4,5,7,8][0-9]{9}$/;
            return reg.test(mobile);
        },

        /**
         * 校验密码：8-16位不为纯数字或字母的正在表达式
         * @param password
         * @returns {boolean}
         */
        checkPassword:function(password){
            var patrn=/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/;
            if (!patrn.exec(password)) return false
            return true
        },

        /**
         * 判断字符串是否为空
         * @param str        字符串
         * @returns {boolean}
         */
        isEmptyStr:function(str){
            if(str.length == 0){
                return true;
            }

            return false;
        }
    }
})(window,jQuery);