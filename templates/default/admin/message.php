{template header}
<div class="content-div">
    <div class="sysmessage">
        <h3 class="{$type}">{{$msg}}</h3>
        {if $autoredirect}
        <div class="tips">{{lang('auto_redirect')}}</div>
        {else}
        <div class="tips">{{lang('message_tips')}}</div>
        {/if}
        <div class="links">
            {if $links}
            {foreach $links $link}
            <a href="{{$link['url']}}"{if $link['target']} target="{{$link['target']}}"{/if}>{{$link['text']}}</a>
            {/foreach}
            {else}
            <a href="{{$forward}}">{{lang('go_back')}}</a>
            <a href="/">{{lang('go_home')}}</a>
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
            window.location = '{{$forward}}';
        }else {
            $("#timer").text(second);
        }
    },1000);
</script>
{/if}
{template footer}
