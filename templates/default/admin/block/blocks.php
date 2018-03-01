{template header}
<div class="console-title">
    <a href="javascript:;" class="button float-right" id="add_block">添加板块</a>
    <h2>内容板块管理</h2>
</div>
<div class="content-div">
    <form method="post" id="listForm" autocomplete="off">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="50"><label><input type="checkbox" class="checkbox checkall checkmark"></label></th>
                <th width="60">ID</th>
                <th width="300">名称</th>
                <th>说明</th>
                <th width="80">编辑</th>
            </tr>
            </thead>
            <tbody>
            {foreach $blocklist $block}
            <tr>
                <td><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="blocks[]" value="{$block[block_id]}"></td>
                <td>{$block[block_id]}</td>
                <td><a rel="edit" data-id="{$block[block_id]}">{$block[block_name]}</a></td>
                <td>{$block[block_desc]}</td>
                <td><a href="{URL:('/admin/block/itemlist', array('block_id'=>$block[block_id]))}">内容管理</a></td>
            </tr>
            {/foreach}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <div class="pagination float-right">{$pagination}</div>
                    <label><input type="checkbox" class="checkbox checkall checkmark"> 全选</label>
                    <label><button type="button" class="btn" id="deleteButton">删除</button></label>
                    <label><button type="button" class="btn" data-action="refresh">刷新</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/template" id="blockFormTpl">
    <div style="padding: 10px 20px;">
        <form method="post" id="J_Frmblock" action="{URL:('/admin/block/save_block')}">
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="formhash" value="{FORMHASH}">
            <input type="hidden" name="block_id" value="{block[block_id]}">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
                <tbody>
                    <tr>
                        <td class="cell-name">板块名称</td>
                        <td><input title="" type="text" class="input-text w300" name="block[block_name]" value="{block[block_name]}" id="J_block_name"></td>
                    </tr>
                    <tr>
                        <td class="cell-name">板块说明</td>
                        <td><textarea title="" class="textarea" name="block[block_desc]" id="J_block_desc" style="height: 100px;">{block[block_desc]}</textarea></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</script>
<script type="text/javascript">
    $(function () {
        $("#add_block").on('click', function (e) {
            var html = $("#blockFormTpl").html().replace(/\{block\[(.*?)\]\}/g, function () {
                return '';
            });
            DSXUI.dialog({
                title:'添加板块',
                content:html,
                onConfirm:function (dlg) {
                    var block_name = $.trim($("#J_block_name").val());
                    if(!block_name) {
                        DSXUI.error('请填写板块名称');
                        return false;
                    }
                    $("#J_Frmblock").ajaxSubmit({
                        dataType:'json',
                        success:function (response) {
                            if (response.errcode === 0){
                                dlg.close();
                                window.location.href = "{URL:('/admin/block/index')}&sp="+Math.random();
                            }
                        }
                    });
                }
            });
        });

        $("a[rel=edit]").on('click', function () {
            var block_id = $(this).attr('data-id');
            $.ajax({
                url:"{U:('c=block&a=get_block')}",
                data:{block_id:block_id},
                dataType:'json',
                success:function (responsedata) {
                    var html = $("#blockFormTpl").html().replace(/\{block\[(.*?)\]\}/g, function (s, k) {
                        return responsedata.data[k];
                    });
                    DSXUI.dialog({
                        title:'添加板块',
                        content:html,
                        onConfirm:function (dlg) {
                            var block_name = $.trim($("#J_block_name").val());
                            if(!block_name) {
                                DSXUI.error('请填写板块名称');
                                return false;
                            }
                            $("#J_Frmblock").ajaxSubmit({
                                dataType:'json',
                                success:function (response) {
                                    if (response.errcode === 0){
                                        dlg.close();
                                        window.location.href = "{URL:('/admin/block/index')}&sp="+Math.random();
                                    }
                                }
                            });
                        }
                    });
                }
            });
        });

        $("#deleteButton").on('click', function () {
            if ($(".itemCheckBox:checked").length === 0){
                DSXUI.error('请选择选项');
                return false;
            }
            var spinner = null;
            DSXUI.showConfirm('删除板块', '确认删除所选板块吗?', function () {
                $("#listForm").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode === 0){
                                DSXUtil.reFresh();
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500);
                    }
                });
            });
        });
    });
</script>
{template footer}
