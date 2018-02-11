;(function($){
    $.fn.Jscroll = function(settings){
        settings = $.extend({
            speed : 3000,
            animateSpeed:1000,
            direction : 'left',
            width:300,
            height:300,
            arrowLeft:'',
            arrowRight:''
        },settings);
        var that = this;
        var ul = $(this).find("ul");
        $(this).css({'overflow':'hidden','height':settings.height});
        if(settings.direction === 'left' || settings.direction === 'right') ul.css({'width':1000,'height':settings.height});
        that.t = setInterval(function(){that.AutoPlay();},settings.speed);
        that.scrollLeft = function(){
            ul.animate({marginLeft:-settings.width+"px"},settings.animateSpeed,function(){
                //把第一个li丢最后面去
                ul.css({marginLeft:0}).find("li:first").appendTo(ul);
            });
        }
        that.scrollRight = function(){
            ul.css({marginLeft:-settings.width+"px"}).find("li:last").prependTo(ul);
            ul.animate({marginLeft:0},settings.animateSpeed,function(){
                //把第一个li丢最后面去
            });
        }
        that.scrollUp = function(){
            ul.animate({marginTop:-settings.height+"px"},settings.animateSpeed,function(){
                //把第一个li丢最后面去
                ul.css({marginTop:0}).find("li:first").appendTo(ul);
            });
        }
        that.scrollDown = function(){
            ul.css({marginTop:-settings.height+"px"}).find("li:last").prependTo(ul);
            ul.animate({marginTop:0},settings.animateSpeed,function(){
                //把第一个li丢最后面去
            });
        }
        that.AutoPlay = function(){
            if(settings.direction === 'right'){
                that.scrollRight();
            }else if(settings.direction === 'up'){
                that.scrollUp();
            }else if(settings.direction === 'down'){
                that.scrollDown();
            }else{
                that.scrollLeft();
            }
        }
        $(this).hover(function(){
                clearTimeout(that.t);
            },
            function(){
                that.t = setInterval(function(){that.AutoPlay();},settings.speed);
            });
        $(this).find(settings.arrowLeft).bind('click',that.scrollRight);
        $(this).find(settings.arrowRight).bind('click',that.scrollLeft);
    }
})(jQuery);