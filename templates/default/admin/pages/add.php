{template header}
<div class="console-title">
    <div class="float-right">
        <a href="{URL:('/admin/pages/category')}" class="button">分类管理</a>
        <a href="{URL:('/admin/pages/itemlist', array('catid'=>$catid))}" class="button">返回列表</a>
    </div>
    <h2>{if $G[a]=='add'}添加页面{else}编辑页面{/if}</h2>
</div>
<div class="content-div">
    <form method="post" action="" id="pageForm">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="60">标题</td>
                <td><input type="text" title="" id="title" class="input-text w300" name="newpage[title]" value="{$page[title]}"></td>
                <td width="60">别名</td>
                <td><input type="text" title="" class="input-text w300" name="newpage[alias]" value="{$page[alias]}"></td>
            </tr>
            <tr>
                <td>分类</td>
                <td>
                    <select name="newpage[catid]" class="select w300" title="">
                        {loop $categorylist $clist}
                        <option value="{$clist[pageid]}"{if $page[catid]==$clist[pageid]} selected{/if}>{$clist[title]}</option>
                        {/loop}
                    </select>
                </td>
                <td>模板</td>
                <td><input type="text" title="" class="input-text w300" name="newpage[template]" value="{$page[template]}"></td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="60">摘要</td>
                <td><textarea title="" style="width:100%;" name="newpage[summary]">{$page[summary]}</textarea></td>
             </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
            <tr>
                <td width="60">内容</td>
                <td><div style="box-sizing:border-box">{template editor}</div></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" class="button button-long">发布</button></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
    $("#pageForm").on('submit', function () {
        var title = $.trim($("#title").val());
        if (!title){
            DSXUI.error('请填写标题');
            return false;
        }
    });
</script>
{template footer}
