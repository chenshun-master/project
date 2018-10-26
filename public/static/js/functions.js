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
        }
}
})(window,jQuery);