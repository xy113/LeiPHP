var DSXUI = {
    message : function(settings){
        var opt = $.extend({
            type:'success',
            text:'操作完成'
        },settings);

        if(opt.type !== 'success' && opt.type !== 'error' && opt.type !== 'warning') opt.type = 'infomation';
        var icon;
        switch(opt.type) {
            case 'success':
                icon = '&#xe656;';
                break;
            case 'error':
                icon = '&#xe658;';
                break;
            case 'warning':
                icon = '&#xe662;';
                break;
            default : icon = '&#xe6e4;';
        }
        $("#ui-message-box").remove();
        var div = $('<div/>').addClass('dsx-message-box').attr('id','dsx-message-box');
        var con = $('<div/>').addClass('message-div message-'+opt.type).html('<div class="iconfont message-icon">'+icon+'</div><div class="message-text">'+opt.text+'</div>');
        div.html(con).appendTo(document.body).fadeIn('fast').center();
        if(opt.afterShow) opt.afterShow(div);
        setTimeout(function(){div.remove(); if(opt.afterClose) opt.afterClose(div);},2000);
    },
    success : function(text, callback){
        DSXUI.message({type:'success',text:text,afterClose:callback});
    },
    error : function(text,callback){
        DSXUI.message({type:'error',text:text,afterClose:callback});
    },
    warning : function(text,callback){
        DSXUI.message({type:'warning',text:text,afterClose:callback});
    },
    infomation : function(text,callback){
        DSXUI.message({type:'infomation',text:text,afterClose:callback});
    },
    confirm : function(selector,text,ok,cancel){
        $(selector).confirm({text:text,onConfirm:ok,onCancel:cancel});
    },
    showAjaxLoading : function(text){
        text = text||'数据加载中...';
        var overlayer = $("<div/>").addClass("dsx-overlayer").appendTo(document.body);
        var loading = $('<div class="dsx-loading-box" id="dsx-loading-box"><span class="ico"></span>'+text+'</div>')
            .appendTo(document.body).center();
        this.close = function(){
            overlayer.remove();
            loading.remove();
        }
        return this;
    },
    showloading : function(text){
        return DSXUI.showAjaxLoading(text);
    },
    showSpinner : function(){
        var overlayer = $("<div/>").addClass("dsx-overlayer").appendTo(document.body);
        var spinner = $('<div class="dsx-spinner" id="dsx-spinner"></div>').appendTo(document.body).center();
        this.close = function(){
            overlayer.remove();
            spinner.remove();
        }
        return this;
    },
    dialog:function(settings){
        return new DSXDialog(settings);
    },
    showConfirm:function (title, text, callback, cancel) {
        if (!title) title = '删除确认';
        if (!text) text = '确认要删除此项目吗?';
        DSXUI.dialog({
            width:350,
            dragable:false,
            title:title,
            content:'<div style="font-size: 14px;">'+text+'</div>',
            onConfirm:function(dlg){
                dlg.close();
                if(callback) callback(dlg);
            },
            onCancel:function(dlg){
                if (cancel) cancel(dlg);
            }
        });
    },

    //图片选择器 新版
    showImagePicker:function (callback) {
        DSXUI.dialog({
            width:'780px',
            height:'520px',
            title:'图片空间',
            hideFooter:true,
            iframe:'/index.php?m=material&c=image&a=plugin',
            afterShow:function (dlg) {
                window.onPickedImage = function (response) {
                    dlg.close();
                    if (callback) callback(response);
                }
            },
            afterClose:function () {
                window.onPickedImage = null;
            }
        });
    },
    showAjaxLogin : function (callback) {
        DSXUI.dialog({
            width:350,
            height:365,
            hideFooter:true,
            title:'登录粗耕',
            content:'<iframe scrolling="no" frameborder="0" style="width: 100%; height: 100%;" src="/?m=account&c=login&a=ajaxlogin"></iframe>',
            afterShow:function (dlg) {
                window.afterLogin = function (data) {
                    dlg.close();
                    if (callback) callback(data);
                }
            }
        });
    }
}