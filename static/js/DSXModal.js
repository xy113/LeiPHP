;(function ($) {
    $.fn.extend({
        DSXModal:function (options) {
            var opts = $.extend({
                event:'show',
                dragable:true
            }, options);

            var $this = $(this);
            if (opts.event === 'show'){
                var modal_bg = $("<div/>").addClass('dsx-modal-bg').appendTo(document.body).show();
                var dialog = $this.find(".dialog");
                $this.center().show();
                $this.find('[dismiss-modal]').on('click', function () {
                    $this.hide();
                    modal_bg.remove();
                });
                if (opts.dragable) {
                    var mouse = {x:0,y:0};
                    var moveDialog = function(event){
                        var e = window.event || event;
                        var position = dialog.offset();
                        var top = position.top + (e.clientY - mouse.y);
                        var left = position.left + (e.clientX - mouse.x);
                        $this.css({top:top,left:left});
                        mouse.x = e.clientX;
                        mouse.y = e.clientY;
                    }
                    $this.find(".dialog-header").on('mousedown',function(event){
                        var e = window.event || event;
                        e.preventDefault();
                        if(e.stopPropagation){
                            e.stopPropagation();
                        }else {
                            e.cancelBubble = true;
                        }
                        mouse.x = e.clientX;
                        mouse.y = e.clientY;
                        $(document).on('mousemove', moveDialog);
                        $(this).css({'cursor': 'move'});
                    });
                    $(document).on('mouseup',function(){
                        $this.css({'position':'fixed'});
                        $(document).off('mousemove', moveDialog);
                        $this.find(".dialog-header").css({'cursor': 'default'});
                    });
                }
            }

            if (opts.event === 'hide'){
                $this.hide();
                $(".dsx-modal-bg").remove();
            }

            if (opts.event === 'close'){
                $this.remove();
                $(".dsx-modal-bg").remove();
            }
        }
    });
})(jQuery);