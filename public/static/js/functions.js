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
         * 消息提示框
         * @param message   提示内容
         * @param time      消息自动消失时间 (默认 2 秒)
         */
        msg:function(message,time){
            var time = time || 2000;
            var idSelector = this.randomString(20)+ new Date().getTime();
            $('body').append('<div class="wl-msg" id="'+ idSelector+'" style="display: block">'+message+'</div>');
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
            if (!patrn.exec(password)) return false;
            return true
        },

        /**
         * 校验升身份证号
         * @param password
         * @returns {boolean}
         */
        checkIdcard:function(idcard){
            var patrn=/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/;
            if (!patrn.exec(idcard)) return false;
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
            }else if(str == ''){
                return true;
            }
            return false;
        },

        /**
         * 人性化时间处理 传入时间戳
         */
        beautifyTime:function (date_str){
            var  date=new Date();

            if(typeof(date_str)!='string'){
                return date;
            }

            var date_arr=date_str.split(new RegExp("[:| |-]","ig"));
            var date_obj = new Date(date_arr[0],date_arr[1]-1,date_arr[2],date_arr[3],date_arr[4],date_arr[5]);

            var date_seconddiff=( new Date().getTime()-date_obj.getTime() ) /1000 ;

            if(date_seconddiff <60*30){
                return  Math.ceil(date_seconddiff/60)+"分钟前 ";
            }else if(date_seconddiff <3600){
                return  "1小时前 ";
            }else if(date_seconddiff <3600*2){
                return  "2小时前 ";
            }else if(date_seconddiff <3600*3){
                return "3小时前 ";
            }else if(date.getFullYear()==date_arr[0] && date.getMonth()==date_arr[1]-1 && date.getDate()==date_arr[2]){
                return "今天 "+date_arr[3]+':'+date_arr[4]+'分';
            }else if(date.getFullYear()==date_arr[0] && date.getMonth()==date_arr[1]-1 && date.getDate()-1==date_arr[2]){
                return "昨天 "+date_arr[3]+':'+date_arr[4]+'分';
            }else if(date.getFullYear()==date_arr[0] && date.getMonth()==date_arr[1]-1 && date.getDate()-2==date_arr[2]){
                return "前天 "+date_arr[3]+':'+date_arr[4]+'分';
            }else if(date.getFullYear()==date_arr[0] && date.getMonth()==date_arr[1]-1 ){
                return (date.getMonth()+1)+"月"+  date_arr[2]+"日 "+date_arr[3]+':'+date_arr[4];
            }else {
                return date_str;
                return this.dateFormat('yyyy年MM月dd日',new Date(date_str));
            }
        },

        /**
         * 时间格式化
         * @param fmt     格式
         * @param date    Date  对象
         * @returns {*}
         */
        dateFormat:function(fmt,date){
            var o = {
                "M+" : date.getMonth()+1,     //月份
                "d+" : date.getDate(),     //日
                "h+" : date.getHours(),     //小时
                "m+" : date.getMinutes(),     //分
                "s+" : date.getSeconds(),     //秒
                "q+" : Math.floor((date.getMonth()+3)/3), //季度
                "S" : date.getMilliseconds()    //毫秒
            };
            if(/(y+)/.test(fmt))
                fmt=fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
            for(var k in o)
                if(new RegExp("("+ k +")").test(fmt))
                    fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
            return fmt;
        },

        /**
         * 禁用滚动条
         */
        unScroll:function() {
            var top = $(document).scrollTop();
            $(document).on('scroll.unable',function (e) {
                $(document).scrollTop(top);
            })
        },

        /**
         * 启用滚动条
         */
        removeUnScroll:function() {
            $(document).unbind("scroll.unable");
        },

        /**
         * js 页面跳转
         * @param href   页面路径
         */
        href:function(href){
            window.location.href = href;
        },

        /**
         * 判断是否是微信浏览器的函数
         * @returns {boolean}
         */
        isWeiXin:function(){
            var ua = window.navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i) == 'micromessenger'){
                return true;
            }else{
                return false;
            }
        },


        strlen:function(str){
            var len = 0;
            for (var i=0; i<str.length; i++) {
                var c = str.charCodeAt(i);
                if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                    len++;
                } else {
                    len+=2;
                }
            }
            return len;
        },
        toReferer(){
            if(document.referrer == ''){
                window.location.href = '/weixin';
            }else{
                history.go(-1);
            }
        },
        getObjLength:function (obj) {
            if(obj == '' ){return 0;}
            return  Object.keys(obj).length;
        }
}
})(window,jQuery);