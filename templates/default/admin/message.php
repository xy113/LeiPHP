{template header}
<div class="content-div">
    <div class="sysmessage">
        <h3 class="{$type}">{$msg}</h3>
        {if $autoredirect}
        <div class="tips">{$_lang[auto_redirect]}</div>
        {else}
        <div class="tips">{$_lang[message_tips]}</div>
        {/if}
        <div class="links">
            {if $links}
            {loop $links $link}
            <a href="{$link[url]}"{if $link[target]} target="{$link[target]}"{/if}>{$link[text]}</a>
            {/loop}
            {else}
            <a href="{$forward}">{$_lang[go_back]}</a>
            <a href="/">{$_lang[go_home]}</a>
            {/if}
        </div>
    </div>
</div>
{if $autoredirect}
<script type="text/javascript">
    var second = 5;
    var timeid = setInterval(function(){
        second--;
        if(second<1){
            clearTimeout(timeid);
            window.location = '{$forward}';
        }else {
            $("#timer").text(second);
        }
    },1000);
</script>
{/if}
{template footer}