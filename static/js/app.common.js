/**
 * Created by songdewei on 2017/6/27.
 */
var tap = window.ontouchstart ? 'tap' : 'click';
function onBridgeReady(callback) {
    var ua = navigator.userAgent.toLowerCase();
    if (/android/.test(ua)){
        if (window.WebViewJavascriptBridge) {
            callback(WebViewJavascriptBridge)
        } else {
            if (window.WebViewJavascriptBridge) {
                callback(WebViewJavascriptBridge);
            } else {
                document.addEventListener("WebViewJavascriptBridgeReady", function (event) {
                    callback(WebViewJavascriptBridge);
                }, false);
            }
        }
    }else {
        if (window.WebViewJavascriptBridge) {
            return callback(WebViewJavascriptBridge);
        }
        if (window.WVJBCallbacks) {
            return window.WVJBCallbacks.push(callback);
        }
        window.WVJBCallbacks = [callback];
        var WVJBIframe = document.createElement('iframe');
        WVJBIframe.style.display = 'none';
        WVJBIframe.src = 'https://__bridge_loaded__';
        document.documentElement.appendChild(WVJBIframe);
        setTimeout(function() {
            document.documentElement.removeChild(WVJBIframe)
        }, 0);
    }
}

function showAppMsg(msg, callback){
    var div = $("<div/>").addClass('app-message').html(msg).appendTo(document.body).center();
    setTimeout(function () {
        div.remove();
        if (callback) callback();
    }, 1500);
}
function showAppConfirm(text, callback, cancel) {
    var overLayer = $('<div/>').addClass('ui-overlayer').appendTo(document.body);
    var alertbox = $('<div/>').addClass('app-confirm').appendTo(document.body);
    var contect = $('<div/>').addClass('content').html(text);
    var btnOK = $('<div/>').addClass('btn btn-ok').text('确定');
    var btnCancel = $('<div/>').addClass('btn btn-cancel').text('取消');
    var bot = $('<div/>').addClass('bot');
    bot.append(btnOK);
    bot.append(btnCancel);
    alertbox.append(contect);
    alertbox.append(bot).center();
    btnOK.on('click', function (e) {
        overLayer.remove();
        alertbox.remove();
        if (callback) callback();
    });
    btnCancel.on('click', function (e) {
        overLayer.remove();
        alertbox.remove();
        if (cancel) cancel();
    });
}

$(function () {
    onBridgeReady(function (bridge) {
        //打开一个指定连接
        $("[handler=openURL]").on(tap, function (e) {
            var url = $(this).attr('data-url');
            bridge.callHandler('openURL', url);
        });
        //商品详情
        $("[handler=viewItem]").on(tap, function (e) {
            var id = $(this).attr('data-id');
            bridge.callHandler('viewItem', id);
        });
        //店铺详情
        $("[handler=viewShop]").on(tap, function (e) {
            var shop_id = $(this).attr('data-id');
            bridge.callHandler('viewShop', shop_id);
        });
        //文章详情
        $("[handler=viewArticle]").on(tap, function (e) {
            var id = $(this).attr('data-id');
            bridge.callHandler('viewArticle', id);
        });
    });
    $(document).on(tap, function (e) {
        DSXUtil.stopPropagation(e);
    });
});
