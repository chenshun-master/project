(function(window,$){
    window.redream = {
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
        showTip:function(message,time){
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