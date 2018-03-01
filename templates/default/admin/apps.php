{template header}
<div class="console-title">
    <a class="button float-right" id="add-app">添加应用</a>
    <h2>应用管理</h2>
</div>
<div class="content-div">
    <form method="post" autocomplete="off">
        <input type="hidden" name="formsubmit" value="yes" />
        <input type="hidden" name="formhash" value="{FORMHASH}">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="50" class="center">删?</th>
                <th>应用名称</th>
                <th>APPID</th>
                <th>APPKEY</th>
            </tr>
            </thead>
            <tbody id="mainbody">
            {foreach $itemlist $item}
            <tr>
                <td><input type="checkbox" class="checkbox checkmark" name="ids[]" value="{$item[block_id]}"></td>
                <td>{$item[block_id]}</td>
                <td><a rel="edit" data-id="{$item[block_id]}">{$item[block_name]}</a></td>
                <td>{$item[block_desc]}</td>
            </tr>
            {/foreach}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <label><input type="checkbox" class="checkbox checkall"> 全选</label>
                    <label><input type="radio" class="radio" name="option" value="delete" checked> 删除</label>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <span class="pagination">{$pages}</span>
                    <input type="submit" class="button" value="{$_lang[submit]}">
                    <input type="button" class="button button-cancel" value="{$_lang[refresh]}" onclick="window.location.reload()">
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>

<script type="text/template" id="appFormTpl">
    <div style="padding: 10px 20px;">
        <form method="post" id="J_Frmblock" action="{U:('c=block&a=save_block')}">
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="formhash" value="{FORMHASH}">
            <input type="hidden" name="block_id" value="{block[block_id]}">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tbody>
                <tr>
                    <td class="cell-name">板块名称</td>
                    <td><input type="text" class="input-text w300" name="block[block_name]" value="{block[block_name]}" id="J_block_name"></td>
                </tr>
                <tr>
                    <td class="cell-name">板块说明</td>
                    <td><textarea class="textarea" name="block[block_desc]" id="J_block_desc" style="height: 100px;">{block[block_desc]}</textarea></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</script>
<script type="text/javascript">
    $(function () {
        $("#add-app").on('click', function () {
            var html = $("#appFormTpl").html();
            DSXUI.dialog({
                title:'添加应用',
                html:html
            })
        });
    })
</script>
{template footer}
