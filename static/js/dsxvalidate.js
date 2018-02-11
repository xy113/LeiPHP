//验证
var DSXValidate = {
    IsURL : function(url){
        return /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\:+!]*([^<>])*$/.test(url);
    },
    IsChineseName:function(username){
        return /^[\u4e00-\u9fa5]{2,12}$/.test(username);
    },
    IsUserName:function(username){
        return /^[a-zA-Z0-9_\u4e00-\u9fa5]{2,20}$/.test(username);
    },
    IsEmail : function(email){
        return /^[-._A-Za-z0-9]+@([A-Za-z0-9]+\.)+[A-Za-z]{2,3}$/.test(email);
    },
    IsMobile : function(num){
        return /^1[3|4|5|7|8]\d{9}$/.test(num);
    },
    IsPassword : function(str){
        return /^.{6,20}$/.test(str);
    },
    IsIdCardNo : function(idCard){
        var Wi = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2, 1 ];    // 加权因子
        var ValideCode = [ 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ];            // 身份证验证位值.10代表X
        /**
         * 判断身份证号码为18位时最后的验证位是否正确
         * @param a_idCard 身份证号码数组
         * @return
         */
        this.isTrueValidateCodeBy18IdCard = function(a_idCard) {
            var sum = 0;                             // 声明加权求和变量
            if (a_idCard[17].toLowerCase() === 'x') {
                a_idCard[17] = 10;                    // 将最后位为x的验证码替换为10方便后续操作
            }
            for ( var i = 0; i < 17; i++) {
                sum += Wi[i] * a_idCard[i];            // 加权求和
            }
            valCodePosition = sum % 11;                // 得到验证码所位置
            if (a_idCard[17] == ValideCode[valCodePosition]) {
                return true;
            } else {
                return false;
            }
        }
        /**
         * 验证18位数身份证号码中的生日是否是有效生日
         * @param idCard 18位书身份证字符串
         * @return
         */
        this.isValidityBrithBy18IdCard = function(idCard18){
            var year =  idCard18.substring(6,10);
            var month = idCard18.substring(10,12);
            var day = idCard18.substring(12,14);
            var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
            // 这里用getFullYear()获取年份，避免千年虫问题
            if(temp_date.getFullYear()!=parseFloat(year)
                ||temp_date.getMonth()!=parseFloat(month)-1
                ||temp_date.getDate()!=parseFloat(day)){
                return false;
            }else{
                return true;
            }
        }
        /**
         * 验证15位数身份证号码中的生日是否是有效生日
         * @param idCard15 15位书身份证字符串
         * @return
         */
        this.isValidityBrithBy15IdCard = function(idCard15){
            var year =  idCard15.substring(6,8);
            var month = idCard15.substring(8,10);
            var day = idCard15.substring(10,12);
            var temp_date = new Date(year,parseFloat(month)-1,parseFloat(day));
            // 对于老身份证中的你年龄则不需考虑千年虫问题而使用getYear()方法
            if(temp_date.getYear()!=parseFloat(year)
                ||temp_date.getMonth()!=parseFloat(month)-1
                ||temp_date.getDate()!=parseFloat(day)){
                return false;
            }else{
                return true;
            }
        }
        idCard = idCard.replace(/ /g, "");               //去掉字符串头尾空格
        idCard = idCard.replace(/(^\s*)|(\s*$)/g, "");
        if (idCard.length == 15) {
            return this.isValidityBrithBy15IdCard(idCard);       //进行15位身份证的验证
        } else if (idCard.length == 18) {
            var a_idCard = idCard.split("");                // 得到身份证数组
            if(this.isValidityBrithBy18IdCard(idCard)&&this.isTrueValidateCodeBy18IdCard(a_idCard)){   //进行18位身份证的基本验证和第18位的验证
                return true;
            }else {
                return false;
            }
        } else {
            return false;
        }
    }
}

var DSXUtil = {
    mb_cutstr : function(str, maxlen, dot) {
        var len = 0;
        var ret = '';
        var dot = !dot ? '...' : '';
        maxlen = maxlen - dot.length;
        for(var i = 0; i < str.length; i++) {
            len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
            if(len > maxlen) {
                ret += dot;
                break;
            }
            ret += str.substr(i, 1);
        }
        return ret;
    },
    paramToJSON : function(str){
        if(!str) return;
        var json = {};
        var arr = str.split('&');
        $.each(arr,function(i,o){
            var arr2 = o.split('=');
            json[arr2[0]] = arr2[1] ? arr2[1] : '';
        });
        return json;
    },
    randomString : function (len) {
        len = len || 32;
        var $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
        var maxPos = $chars.length;
        var pwd = '';
        for (i = 0; i < len; i++) {
            pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    },
    getQueryString : function(item){
        var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)","i"));
        return svalue ? svalue[1] : svalue;
    },
    /*
    * url 目标url
    * arg 需要替换的参数名称
    * arg_val 替换后的参数的值
    * return url 参数替换后的url
    */
    changeURLArg:function(url,arg,arg_val){
        var pattern=arg+'=([^&]*)';
        var replaceText=arg+'='+arg_val;
        if(url.match(pattern)){
            var tmp='/('+ arg+'=)([^&]*)/gi';
            tmp=url.replace(eval(tmp),replaceText);
            return tmp;
        }else{
            if(url.match('[\?]')){
                return url+'&'+replaceText;
            }else{
                return url+'?'+replaceText;
            }
        }
    },
    setCookie : function(name, value, expiresHours) {
        var cookieString = name + "=" + escape(value);
        //判断是否设置过期时间
        if(expiresHours > 0){
            var date = new Date();
            date.setTime(date.getTime() + expiresHours * 3600 * 1000);
            cookieString = cookieString + "; expires=" + date.toGMTString();
        }
        document.cookie = cookieString;
    },
    getCookie : function(strName){
        var strCookie = document.cookie.split("; ");
        for (var i=0; i < strCookie.length; i++) {
            var strCrumb = strCookie[i].split("=");
            if (strName == strCrumb[0]) {
                return strCrumb[1] ? unescape(strCrumb[1]) : null;
            }
        }
        return null;
    },
    reFresh:function(){
        window.location = window.location.href;
    },
    stopPropagation : function(event){
        var e = event || window.event;
        if(e.stopPropagation){
            e.stopPropagation();
        }else {
            e.cancelBubble = true;
        }
    },
    checkLogin : function(success, fail){
        $.ajax({
            url:'/?m=account&c=chklogin',
            async:false,
            dataType:"json",
            success: function(json){
                if(json.errcode == 0) {
                    if (success) success(json);
                }else {
                    if (fail) fail(json);
                }
            }
        });
    }
}