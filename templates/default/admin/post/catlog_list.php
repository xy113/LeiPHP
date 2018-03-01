{template header}
<div class="console-title">
    <a href="{URL:('/admin/postcatlog/add')}" class="button float-right">添加新分类</a>
    <h2>文章管理 > 分类管理</h2>
</div>
<div class="content-div">
    <form method="post" action="">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="60">ID</th>
                <th width="60" style="text-align: center;">图标</th>
                <th>分类名称</th>
                <th width="100">标识</th>
                <th width="80">显示顺序</th>
                <th width="50" class="align-center">可选</th>
                <th width="50" class="align-center">可用</th>
                <th width="80">选项</th>
            </tr>
            </thead>
            {foreach $catloglist[0] $catid_1 $catlog_1}
            <tbody id="catlog_{$catid_1}">
            <tr>
                <td width="60">{$catid_1}</td>
                <td width="60" style="text-align: center;"><img src="{img $catlog_1[icon]}" width="30" height="30" rel="pickimage" data-id="{$catid_1}"></td>
                <td><input type="text" title="" class="input-text" name="catloglist[{$catid_1}][name]" value="{$catlog_1[name]}" maxlength="10" style="font-weight:bold;"></td>
                <td width="100"><input type="text" title="" class="input-text w100"  name="catloglist[{$catid_1}][identifer]" value="{$catlog_1[identifer]}"></td>
                <td width="80"><input type="number" title="" class="input-text w60"  name="catloglist[{$catid_1}][displayorder]" value="{$catlog_1[displayorder]}"></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[{$catid_1}][enable]" value="1"{if $catlog_1[enable]} checked="checked"{/if}></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[{$catid_1}][available]" value="1"{if $catlog_1[available]} checked="checked"{/if}></td>
                <td width="40">
                    <a href="{URL:('/admin/postcatlog/edit', 'catid='.$catid_1)}">编辑</a>
                    <a href="{URL:('/admin/postcatlog/delete', 'catid='.$catid_1)}">删除</a>
                </td>
            </tr>
            </tbody>
            {foreach $catloglist[$catid_1] $catid_2 $catlog_2}
            <tbody id="catlog_{$catid_2}">
            <tr>
                <td width="60">{$catid_2}</td>
                <td width="60" class="align-center"><img src="{img $catlog_2[icon]}" width="30" height="30" rel="pickimage" data-id="{$catid_2}"></td>
                <td>
                    <div class="catlog">
                        <input type="text" title="" class="input-text" name="catloglist[{$catid_2}][name]" value="{$catlog_2[name]}" maxlength="10">
                    </div>
                </td>
                <td width="100"><input type="text" title="" class="input-text w100"  name="catloglist[{$catid_2}][identifer]" value="{$catlog_2[identifer]}"></td>
                <td width="80"><input type="number" title="" class="input-text w60"  name="catloglist[{$catid_2}][displayorder]" value="{$catlog_2[displayorder]}"></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[{$catid_2}][enable]" value="1"{if $catlog_2[enable]} checked="checked"{/if}></td>
                <td width="50" class="center"><input type="checkbox" title="" class="checkbox" name="catloglist[{$catid_2}][available]" value="1"{if $catlog_2[available]} checked="checked"{/if}></td>
                <td width="40">
                    <a href="{URL:('/admin/postcatlog/edit', 'catid='.$catid_2)}">编辑</a>
                    <a href="{URL:('/admin/postcatlog/delete', 'catid='.$catid_2)}">删除</a>
                </td>
            </tr>
            </tbody>
            {foreach $catloglist[$catid_2] $catid_3 $catlog_3}
            <tbody id="catlog_{$catid_3}">
            <tr>
                <td width="60">{$catid_3}</td>
                <td width="60" class="align-center"><img src="{img $catlog_3[icon]}" width="30" height="30" rel="pickimage" data-id="{$catid_3}"></td>
                <td>
                    <div class="catlog">
                        <div class="catlog">
                            <input type="text" title="" class="input-text" name="catloglist[{$catid_3}][name]" value="{$catlog_3[name]}" maxlength="10">
                        </div>
                    </div>
                </td>
                <td width="100"><input type="text" title="" class="input-text w100"  name="catloglist[{$catid_3}][identifer]" value="{$catlog_3[identifer]}"></td>
                <td width="80"><input type="number" title="" class="input-text w60"  name="catloglist[{$catid_3}][displayorder]" value="{$catlog_3[displayorder]}"></td>
                <td width="50" class="center"><input title="" type="checkbox" class="checkbox" name="catloglist[{$catid_3}][enable]" value="1"{if $catlog_3[enable]} checked="checked"{/if}></td>
                <td width="50" class="center"><input title="" type="checkbox" class="checkbox" name="catloglist[{$catid_3}][available]" value="1"{if $catlog_3[available]} checked="checked"{/if}></td>
                <td width="40">
                    <a href="{URL:('/admin/postcatlog/edit', 'catid='.$catid_3)}">编辑</a>
                    <a href="{URL:('/admin/postcatlog/delete', 'catid='.$catid_3)}">删除</a>
                </td>
            </tr>
            </tbody>
            {/foreach}
            {/foreach}
            {/foreach}
            <tfoot>
            <tr>
                <td colspan="10">
                    <label><button type="submit" class="button">保存</button></label>
                    <label><button type="button" class="button button-cancel" onclick="DSXUtil.reFresh()">刷新</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $("a[rel=delete]").on('click', function () {
            DSXUI.showConfirm('删除分类', '确认要删除分类吗?', function () {
                $.ajax({
                    url:"{URL:('/admin/postcatlog/index')}"
                });
            });
        });
        $("img[rel=pickimage]").on('click', function () {
            var self = this;
            var catid = $(this).attr('data-id');
            DSXUI.showImagePicker(function (data) {
                $(self).attr('src', data.imageurl);
                $.post("{URL:('/admin/postcatlog/seticon')}", {catid:catid,icon:data.image});
            });
        });
    });
</script>
{template footer}
