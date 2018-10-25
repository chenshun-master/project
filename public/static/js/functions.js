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
            var idSelector = objClass.randomString(20)+ new Date().getTime();
            $('body').append('<div class="wkf" id="'+ idSelector+'" style="display: block">'+message+'</div>');
            $('#'+ idSelector).show().delay(time).fadeOut();
            (function(id,tt){
                setTimeout(function(){
                    $('#'+ id).remove();
                },tt);
            })(idSelector,time);
        }
    }
})(window,jQuery);