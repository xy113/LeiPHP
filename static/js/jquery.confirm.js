;(function ($) {
    $.fn.extend({
        confirm : function(settings){
            var option = $.extend({
                event:'click',
                text:'确定要删除吗?',
                btnYes:'确定',
                btnNo:'取消'
            },settings);

            var div = $('<div id="dsx-confirm-box" class="dsx-confirm-box">'+
                '<dl><dt class="txt">'+option.text+'</dt><dd><span class="btn btn-yes" tabindex="1">'+option.btnYes+'</span>'+
                '<span class="btn btn-no" tabindex="1">'+option.btnNo+'</span></dd></dl></div>');
            $(this).on(option.event,function(e) {
                if(e.stopPropagation){
                    e.stopPropagation();
                }else{
                    e.cancelBubble = true;
                }
                var self = this;
                var position = $(this).offset();
                var top = parseInt((position.top+$(this).outerHeight())) + 7;
                $(document.body).append(div);
                div.css({"top":top+"px","display":"none",'position':'absolute'}).fadeIn("fast");
                /*
                if((position.left + div.width()) > $(document).width()){
                    div.css({'right':$(document).width() - (position.left+$(this).outerWidth())+'px'});
                }else {
                    div.css({'left':position.left+'px'});
                }
                */
                if(position.left > $(document).width()/2){
                    div.css({'right':$(document).width() - (position.left+$(this).outerWidth())+'px'});
                }else {
                    div.css({'left':position.left+'px'});
                }
                div.find(".btn-yes").one('click',function(){
                    div.remove();
                    if(option.onConfirm) option.onConfirm(div,self);
                });
                div.find(".btn-no").click(function(){
                    div.remove();
                    if(option.onCancel) option.onCancel(div,self);
                });
                div.click(function(event){
                    var e = window.event || event;
                    if(e.stopPropagation){
                        e.stopPropagation();
                    }else{
                        e.cancelBubble = true;
                    }
                });
                $(document).on('click',function(){div.remove();});
            });
        }
    })
})(jQuery);