;(function ($) {
    $.fn.extend({
        //层居中
        center: function (settings) {
            settings = $.extend({'fixed':true},settings);
            return this.each(function() {
                var top = ($(window).height() - $(this).outerHeight()) / 2;
                var left = ($(window).width() - $(this).outerWidth()) / 2;
                if(settings.fixed){
                    $(this).css({position:'fixed', margin:0, top:top,left:left});
                }else{
                    $(this).css({
                        position:'absolute',
                        margin:0,
                        top:top+$(document).scrollTop(),
                        left:left+$(document).scrollLeft()
                    });
                }
            });
        },
        //层可拖动
        dragable:function(options){
            options = $.extend({},options);
            var self = this;
            var mouse = {x:0,y:0};
            $(this).css({'position':'absolute'});
            this.moveDiv = function(event){
                var e = window.event || event;
                var position = $(self).offset();
                var top = position.top + (e.clientY - mouse.y);
                var left = position.left + (e.clientX - mouse.x);
                $(self).css({top:top,left:left});
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            }
            var handle = options.handle ? $(options.handle) : $(this);
            handle.mousedown(function(event){
                var e = window.event || event;
                mouse.x = e.clientX;
                mouse.y = e.clientY;
                $(document).bind('mousemove',self.moveDiv);
                handle.css({'cursor': 'move'});
            });
            $(document).mouseup(function(){
                $(document).unbind('mousemove',self.moveDiv);
                handle.css({'cursor': 'default'});
            });
        },
        //当前位置插入内容
        insertContent: function(myValue, t) {
            var $t = $(this)[0];
            if (document.selection) { //ie
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd("character", wee + t);
                    t <= 0 ? sel.moveStart("character", wee - 2 * t - myValue.length) : sel.moveStart("character", wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t, $t.selectionEnd + t);
                    this.focus();
                }
            }
            else {
                this.value += myValue;
                this.focus();
            }
        },
        //表单验证
        validate:function(option){
            var self  = this;
            var form  = $(this);
            var tips  = $('<div/>').addClass("ui-tips-box ui-form-tips").css({'z-index':'10005'});
            var arrow = $('<div/>').addClass("ui-tips-arrow ui-form-tips").css({'z-index':'10005'});
            var validateItems = $(this).find("[required]");
            this.flag = true;
            this.showPrompt = function(o,text){
                self.hidePrompt();
                $("body").append(tips);
                $("body").append(arrow);
                tips.empty().text(text);
                var offset = $(o).offset();
                arrow.css({top:offset.top-14, left:offset.left + 10});
                tips.css({top:offset.top-$(tips).outerHeight()-8, left:offset.left});
            }
            this.hidePrompt = function(){
                $(".ui-form-tips").remove();
            }

            this.validateItem = function(o){
                var value   = $.trim($(o).val());
                var regular = $(o).attr("regular");
                var errmsg  = $(o).attr('error');
                if(value == undefined) value = '';
                if(regular == undefined || regular == ''){
                    if(value.length < 1){
                        if(errmsg != undefined && errmsg != '') self.showPrompt(o, errmsg);
                        self.flag = false;
                    }
                }else {
                    regular = eval(regular);
                    if(!regular.test(value)){
                        if(errmsg != undefined) self.showPrompt(o, errmsg);
                        self.flag = false;
                    }
                }
            }

            this.validateForm = function(){
                $(self).find("[required]").each(function(index, element) {
                    if(self.flag) self.validateItem(element);
                });
            }

            this.bind = function(){
                $(self).find("[prompt]").each(function(index, element) {
                    if($(element).attr('prompt') != undefined){
                        $(element).focus(function(e) {
                            self.showPrompt(element, $(element).attr('prompt'));
                        });
                    }
                    $(element).blur(function(e) {
                        self.hidePrompt();
                    });
                });
            }

            this.bind();
            this.validateForm();
            return this.flag;
        },
        //ajax上传文件
        AjaxFileUpload:function(options) {
            var defaults = {
                    action: "upload.php",
                    dataType: 'json',
                    data: {},
                    onChange: function (filename) {
                    },
                    onSubmit: function (filename) {
                    },
                    onComplete: function (filename, response) {
                    }
                },
                settings = $.extend({}, defaults, options),
                randomId = (function () {
                    var id = 0;
                    return function () {
                        return "_AjaxFileUpload" + id++;
                    };
                })();

            return this.each(function () {
                var $this = $(this);
                if ($this.is("input") && $this.attr("type") === "file") {
                    $this.bind("change", onChange);
                }
            });

            function onChange(e) {
                var $element = $(e.target),
                    id = $element.attr('id'),
                    $clone = $element.removeAttr('id').clone().attr('id', id).AjaxFileUpload(options),
                    filename = $element.val().replace(/.*(\/|\\)/, ""),
                    iframe = createIframe(),
                    form = createForm(iframe);

                // We append a clone since the original input will be destroyed
                $clone.insertBefore($element);
                settings.onChange.call($clone[0], filename);
                iframe.bind("load", {element: $clone, form: form, filename: filename}, onComplete);
                form.append($element).bind("submit", {
                    element: $clone,
                    iframe: iframe,
                    filename: filename
                }, onSubmit).submit();
            }

            function onSubmit(e) {
                var data = settings.onSubmit.call(e.data.element, e.data.filename);
                // If false cancel the submission
                if (data === false) {
                    // Remove the temporary form and iframe
                    $(e.target).remove();
                    e.data.iframe.remove();
                    return false;
                } else {
                    // Else, append additional inputs
                    for (var variable in data) {
                        $("<input />")
                            .attr("type", "hidden")
                            .attr("name", variable)
                            .val(data[variable])
                            .appendTo(e.target);
                    }
                }
            }

            function onComplete(e) {
                var $iframe = $(e.target),
                    doc = ($iframe[0].contentWindow || $iframe[0].contentDocument).document;
                //	response = doc.body.innerHTML;
                var docRoot = doc.body ? doc.body : doc.documentElement;
                var response = docRoot ? docRoot.innerHTML : null;
                // If you add mimetype in your response,
                // you have to delete the '<pre></pre>' tag.
                // The pre tag in Chrome has attribute, so have to use regex to remove
                var rx = new RegExp("<pre.*?>(.*?)</pre>", "i");
                var am = rx.exec(response);
                //this is the desired data extracted
                var response = am ? am[1] : response;    //the only submatch or empty
                if (response) {
                    if (settings.dataType.toLowerCase() == 'json') response = $.parseJSON(response);
                } else {
                    response = {};
                }

                settings.onComplete.call(e.data.element, e.data.filename, response);

                // Remove the temporary form and iframe
                e.data.form.remove();
                $iframe.remove();
            }

            function createIframe() {
                var id = randomId();
                // The iframe must be appended as a string otherwise IE7 will pop up the response in a new window
                $("body").append('<iframe src="javascript:false;" name="' + id + '" id="' + id + '" style="display: none;"></iframe>');
                return $('#' + id);
            }

            function createForm(iframe) {
                return $("<form />")
                    .attr({
                        method: "post",
                        action: settings.action,
                        enctype: "multipart/form-data",
                        target: iframe[0].name
                    })
                    .hide()
                    .appendTo("body");
            }
        }
    });
})(jQuery);