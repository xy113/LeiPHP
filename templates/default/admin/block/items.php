{template header}
<div class="console-title">
    <a href="{URL:('/admin/block/add_item', array('block_id'=>$block_id))}" class="button float-right">添加项目</a>
    <h2>板块内容列表</h2>
</div>
<div class="content-div table-wrap">
    <form method="post" id="listForm" autocomplete="off">
        {__formhash__}
        <input type="hidden" name="eventType" value="" id="J_eventType">
        <table cellpadding="0" cellspacing="0" width="100%" class="listtable border-none">
            <thead>
                <tr>
                    <th width="40"><label><input type="checkbox" class="checkbox checkmark checkall"></label></th>
                    <th width="70">图片</th>
                    <th width="320">标题</th>
                    <th>链接</th>
                    <th width="50">选项</th>
                </tr>
            </thead>
        </table>
        <div class="sortable">
            {loop $itemlist $item}
            <table cellspacing="0" cellpadding="0" width="100%" class="listtable border-none">
                <tbody>
                    <tr>
                        <td width="40"><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="delete[]" value="{$item[id]}"></td>
                        <td width="70"><img src="{img $item[image]}" width="50" height="50" rel="pickimg" data-id="{$item[id]}"></td>
                        <td width="320"><input title="" type="text" class="input-text w300" name="itemlist[{$item[id]}][title]" value="{$item[title]}"></td>
                        <td><input title="" type="text" class="input-text w400" name="itemlist[{$item[id]}][url]" value="{$item[url]}"></td>
                        <td width="50"><a href="{URL:('/admin/block/edit_item','block_id='.$block_id.'&id='.$item[id])}">编辑</a></td>
                    </tr>
                </tbody>
            </table>
            {/loop}
        </div>
        <table cellpadding="0" cellspacing="0" width="100%" class="listtable border-none">
            <tfoot>
                <tr>
                    <td>
                        <label><input type="checkbox" class="checkbox checkmark checkall"> 全选</label>
                        <label><button type="button" class="btn" id="deleteButton">删除</button></label>
                        <label><button type="button" class="btn" id="updateButton">更新</button></label>
                        <label><button type="button" class="btn" data-action="refresh">刷新</button></label>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $("img[rel=pickimg]").on('click', function () {
            var self = this;
            var id = $(this).attr('data-id');
            DSXUI.showImagePicker(function (data) {
                $(self).attr('src', data.imageurl);
                $.ajax({
                    url:"{URL:('/admin/block/set_item_image')}",
                    data:{id:id,image:data.image, block_id:'{$block_id}'},
                    dataType:'json',
                    success:function (response) {

                    }
                });
            });
        });

        $("#deleteButton").on('click', function () {
            if ($(".itemCheckBox:checked").length === 0){
                DSXUI.error('请选择选项');
                return false;
            }
            var spinner = null;
            DSXUI.showConfirm('删除内容', '确认要删除所选内容吗?', function () {
                $("#J_eventType").val('delete');
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
        $("#updateButton").on('click', function () {
            var spinner = null;
            $("#J_eventType").val('update');
            $("#listForm").ajaxSubmit({
                dataType:'json',
                beforeSend:function () {
                    spinner = DSXUI.showSpinner();
                },
                success:function (response) {
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
</script>
{template footer}
