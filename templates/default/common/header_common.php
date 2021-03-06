<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{$_G['title']}}</title>
    <meta name="keywords" content="{$_G[keywords]}">
    <meta name="description" content="{$_G[description]}">
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="/static/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/static/css/style_cg.css">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
    <script src="/static/js/angular.min.js" type="text/javascript"></script>
</head>
<body>
{template top_common}
<div class="header">
    <div class="area banner">
        <div class="global-logo">
            <img src="/static/images/cugeng/global-logo.png">
        </div>
        <div class="global-search-box">
            <form method="get" action="{{url('/')}}">
                <input type="hidden" name="m" value="item">
                <input type="hidden" name="c" value="search">
                <div class="input-box">
                    <input type="text" class="text" placeholder="商品名称" name="q" value="{$q}">
                    <input type="submit" class="btn" value="搜索">
                </div>
            </form>
            <div class="hot">
                热门搜索:
                <a href="{U:('m=item&c=search&q=花菜')}">花菜</a>、
                <a href="{U:('m=item&c=search&q=胡萝卜')}">胡萝卜</a>、
                <a href="{U:('m=item&c=search&q=五花肉')}">五花肉</a>
            </div>
        </div>
        <ul class="apps">
            <li>
                <div class="pic showqrcode"><img src="/static/images/common/weixin_qrcode.jpg"></div>
                <p>在微信关注我们</p>
            </li>
            <li>
                <div class="pic showqrcode"><img src="/static/images/common/app_qrcode.jpg"></div>
                <p>下载粗耕APP</p>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(".showqrcode").mouseenter(function () {
        var src = $(this).find('img').attr('src');
        var offset = $(this).offset();
        var img = $("<img/>").width(200).height(200).attr('id','J-qrcode-preview').attr('src', src).appendTo(document.body);
        img.css({'z-index':9999, 'left':offset.left + $(this).width() - 200, 'top':offset.top+$(this).height(),'position':'fixed', 'border':'1px #DDD solid'});
    }).mouseleave(function () {
        $("#J-qrcode-preview").remove();
    });
</script>
<div class="global-nav">
    <div class="nav">
        <div class="cat"><a href="{U:('m=item&c=catlog')}"><span class="iconfont icon-sort"></span> 全部商品分类</a></div>
        <ul>
            <li><a href="{U:('/')}"{if $_G[nav]=="home"} class="cur"{/if}>首页</a></li>
            <li><a href="{U:('m=item&c=youxuan')}"{if $_G[nav]=="item"} class="cur"{/if}>粗耕优选</a></li>
            <li><a href="{U:('m=shop&c=index')}"{if $_G[nav]=="shop"} class="cur"{/if}>企业店铺</a></li>
            <li><a href="{U:('m=member&c=order&a=index')}">我的订单</a></li>
        </ul>
        <div class="cart" id="nav-cart">
            <a href="{U:('m=cart&c=index')}">
            <span class="ico"></span>
            <span>购物车{cookie cart_total_count}件</span>
            <strong>去结算>></strong>
            </a>
        </div>
    </div>
</div>
