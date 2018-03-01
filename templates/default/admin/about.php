{template header}
<style type="text/css">html,body{background-color:#f2f2f2;}</style>
<h2 class="about-h2-title">欢迎使用大师兄CMS</h2>
<div class="area">
    <div class="about-content">
        <div class="frame0">
            <h3 class="title">开始使用</h3>
            <div class="item"><a class="button submit" href="{echo U('c=setting&a=basic')}">自定义你的站点</a></div>
        </div>
        <div class="frame0">
            <h3 class="title">接下来</h3>
            <div class="item"><i class="icon">&#xf0199;</i><a href="{echo U('c=post&a=add')}">撰写第一篇文章</a></div>
            <div class="item"><i class="icon">&#xf00a7;</i><a href="?" target="_blank">查看站点</a></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="about-left">
        <div class="about-content">
            <div class="content-title">大师兄新闻</div>
            <div class="textfield"></div>
        </div>
        <div class="blank"></div>
        <div class="about-content">
            <div class="content-title">关注大师兄</div>
            <p></p>
            <p>QQ:307718818</p>
            <p>邮箱:songdewei@163.com</p>
            <p>微信:大师兄网络服务平台</p>
            <p><img src="/static/images/common/weixin_qrcode.jpg" width="150" height="150"></p>
            <p></p>
        </div>
    </div>
    <div class="about-right">
        <div class="about-content">
            <div class="content-title">最新发布</div>
            <ul>
                {foreach $postlist[1] $list}
                <li><span>{echo date('Y-m-d H:i',$list[pubtime])}</span><a href="{$list[url]}" target="_blank">{$list[title]}</a></li>
                {/foreach}
            </ul>
        </div>
        <div class="blank"></div>
        <div class="about-content">
            <div class="content-title">待审文章</div>
            <ul>
                {foreach $postlist[2] $list}
                <li><span>{echo date('Y-m-d H:i',$list[pubtime])}</span><a href="{$list[url]}" target="_blank">{$list[title]}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
{template footer}
