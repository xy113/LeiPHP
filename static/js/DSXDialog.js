function DSXDialog(settings){
    var option = $.extend({
        title:'标题',
        yesBtnText:'确定',
        noBtnText:'取消',
        content:'在这里输入内容',
        fixed:true,
        dragable:true,
        hideHeader:false,
        hideFooter:false
    },settings);
    //兼容老版本
    option.content = option.content ? option.content : option.html;
    if (option.iframe) {
        option.content = '<iframe scrolling="no" frameborder="0" style="width: 100%; height: 100%;" src="'+option.iframe+'"></iframe>';
    }

    var self = this;
    var _window = window;
    var _document = window.document;
    var dialogCount = DSXDialog.__count;
    var header = option.hideHeader ? '' : '<div class="dialog-header"><h4 class="dialog-title">'+option.title+'</h4><a class="close">&times;</a></div>';
    var footer = option.hideFooter ? '' : '<div class="dialog-footer">' +
                '<button type="button" class="button btn-yes" tabindex="1">'+option.yesBtnText+'</button>' +
                '<button type="button" class="button button-cancel btn-no" tabindex="1">'+option.noBtnText+'</button>' +
                '</div>';
    var body = $('<div class="dialog-body">'+option.content+'</div>');
    var content = $("<div/>").addClass('dialog');
    content.append(header);
    content.append(body);
    content.append(footer);

    this.id = option.id ? option.id : 'dsx-modal-'+dialogCount;
    this.zIndex = option.zIndex ? option.zIndex : dialogCount+1000;
    this.dialog = $('<div id="'+this.id+'" class="dsx-modal"></div>').css({'z-index':this.zIndex+1}).append(content);
    this.overLayer = $('<div id="dsx-overlayer-'+dialogCount+'" class="dsx-overlayer"></div>').css({'z-index':this.zIndex});

    if (option.width) {
        if (/^\\d+$/.test(option.width)){
            body.width(option.width);
        }else {
            body.css('width', option.width);
        }
    }
    if (option.height){
        if (/^\\d+$/.test(option.height)){
            body.height(option.height);
        }else {
            body.css('height', option.height);
        }
    }

    this.setPosition = function(){
        var left = ($(_window).width() - self.dialog.outerWidth()) / 2;
        var top = ($(_window).height() - self.dialog.outerHeight()) / 2;
        if(option.fixed){
            self.dialog.css({top:top,left:left});
        }else{
            self.dialog.css({top:top+$(_document).scrollTop(),left:left+$(_document).scrollLeft()});
        }
    }

    this.close = function(){
        self.overLayer.remove();
        self.dialog.remove();
        if(option.afterClose) option.afterClose(self);
    }

    var init = function(){
        self.overLayer.appendTo(_document.body).show();
        self.dialog.appendTo(_document.body).show();
        self.setPosition();
        if (option.dragable) {
            var mouse={x:0,y:0};
            function moveDialog(event){
                var e = window.event || event;
                var top = parseInt(self.dialog.css('top')) + (e.clientY - mouse.y);
                var left = parseInt(self.dialog.css('left')) + (e.clientX - mouse.x);
                self.dialog.css({top:top,left:left});
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            };
            self.dialog.find('.dialog-header').mousedown(function(event){
                var e = window.event || event;
                mouse.x = e.clientX;
                mouse.y = e.clientY;
                $(_document).bind('mousemove',moveDialog);
                $(this).css('cursor','move');
            });
            $(_document).on('mouseup', function(event){
                $(_document).off('mousemove', moveDialog);
                self.dialog.find('.dialog-header').css('cursor','default');
            });
        }

        /* 绑定一些相关事件。 */
        self.dialog.find('.close').on('click', self.close);
        self.dialog.find('.btn-yes').on('click', function(e){
            if(option.onConfirm) option.onConfirm(self);
        });
        self.dialog.find('.btn-no').on('click', function(e){
            if(option.onCancel) option.onCancel(self);
            self.close();
        });
        if(option.afterShow) option.afterShow(self);
    }
    init.call(this);
    DSXDialog.__count++;
}
DSXDialog.__count = 1;