<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{$_G[title]}-后台管理中心</title>
    <meta name="keywords" content="{$_G[keywords]}">
    <meta name="description" content="{$_G[description]}">
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="/static/images/common/favicon.png">
    <link rel="stylesheet" type="text/css" href="/static/css/admin.css">
    <script src="/static/js/jquery.js" type="text/javascript"></script>
    <script src="/static/js/common.js" type="text/javascript"></script>
</head>
<body>
<div class="mcenter-header">
    <div class="header">
        <strong class="logo">后台管理中心</strong>
        <div class="right-menu">
            <a href="{URL:('')}" target="_blank">网站首页</a>
            <a href="{URL:('/admin/logout')}">退出登录</a>
        </div>
    </div>
</div>
<div class="sidebar">
    <div class="sidebar-content">
        <div class="scroll">
            <div class="menus" id="menus">
                <dl>
                    <dd><a><i class="iconfont icon-radioboxfill"></i>系统设置</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/settings/basic')}">基本设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/optimiz')}">优化设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/register')}">注册设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/attach')}">附件设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/water')}">图片水印</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/weixin')}">微信设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/alipay')}">支付宝设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/settings/sms')}">短息平台设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/app')}">应用管理</a></li>
                        </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="iconfont icon-peoplefill"></i>用户管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/member/index')}">会员列表</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/membergroup/index')}">分组管理</a></li>
                        </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="iconfont icon-attentionfill"></i>界面管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/menu')}">菜单管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/ad')}">广告管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/block/namelist')}">内容板块</a></li>
                        </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="iconfont icon-rechargefill"></i>交易管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/order/index')}">订单记录</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/trade/index')}">交易记录</a></li>
                        </ul>
                    </dt>
                </dl>
                <dl>
                    <dd><a><i class="iconfont icon-newsfill"></i>文章管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/post/publish')}">发布文章</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/post/itemlist')}">文章列表</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/postcatlog/itemlist')}">分类管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/postcatlog/merge')}">合并分类</a></li>
                        </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="iconfont icon-messagefill"></i>微信管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/wxmenu')}">菜单设置</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/wxmaterial')}">素材管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/wxnews')}">图文消息</a></li>
                        </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="iconfont icon-babyfill"></i>页面管理</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/pages/add')}">新建页面</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/pages/itemlist')}">页面列表</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/pages/category')}">页面分类</a></li>
                        </ul>
                    </dt>
                </dl>

                <dl>
                    <dd><a><i class="iconfont icon-tagfill"></i>其他项目</a></dd>
                    <dt>
                        <ul>
                            <li><a rel="item" data-action="{URL:('/admin/material')}">素材管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/district')}">地区管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/express')}">快递管理</a></li>
                            <li><a rel="item" data-action="{URL:('/admin/link')}">友情链接</a></li>
                        </ul>
                    </dt>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="mainframe">
    <div class="main-content"><iframe name="mainframe" id="mainframe" src="{URL:('/admin/index/wellcome')}" frameborder="0" style="width: 100%; height: 100%; position: absolute; display: block;"></iframe></div>
</div>
<script type="text/javascript">
    $("#menus dl").each(function () {
        var self = this;
        $(this).find('dd').on('click', function () {
            $(self).find('dt').toggle();
        });
    });
    $("a[rel=item]").on('click', function () {
        $("#mainframe").attr('src', $(this).attr('data-action'));
        $("a[rel=item]").removeClass('cur');
        $(this).addClass('cur');
    });
</script>
</body>
</html>
