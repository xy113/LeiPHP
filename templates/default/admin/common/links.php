{template header}
<div class="console-title">
    <h2>链接管理</h2>
</div>
<div class="content-div">
    <form method="post" action="">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="20">删?</th>
                <th width="40">图片</th>
                <th>名称</th>
                <th width="60">显示顺序</th>
                <th>网址</th>
            </tr>
            </thead>
            {loop $categorylist $cat}
            {eval $catid=$cat[id]}
            <tbody id="tbcontent_$catid">
            <tr>
                <td><input type="checkbox" title="" class="checkbox checkmark" name="delete[]" value="{$catid}" /></td>
                <td></td>
                <td><input type="text" title="" class="input-text" name="itemlist[{$catid}][title]" value="{$cat[title]}" maxlength="10"></td>
                <td><input type="text" title="" class="input-text w60" name="itemlist[{$catid}][displayorder]" value="{$cat[displayorder]}" maxlength="4"></td>
                <td></td>
            </tr>
            {loop $itemlist[$catid] $id $item}
            <tr>
                <td><input type="checkbox" title="" class="checkbox checkmark" name="delete[]" value="{$id}" /></td>
                <td><img src="{img $item[image]}" width="40" height="40" rel="pickimg" data-id="{$id}"></td>
                <td>
                    <div class="catlog">
                        <input type="text" title="" class="input-text" name="itemlist[{$id}][title]" value="{$item[title]}" maxlength="10">
                    </div>
                </td>
                <td><input type="text" title="" class="input-text w60" name="itemlist[{$id}][displayorder]" value="{$item[displayorder]}" maxlength="4"></td>
                <td><input type="text" title="" class="input-text w300" name="itemlist[{$id}][url]" value="{$item[url]}"></td>
            </tr>
            {/loop}
            </tbody>
            <tbody id="newItem_{$catid}"></tbody>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td colspan="3">
                    <div class="addnew-wrap">
                        <a rel="addItem" data-id="{$catid}"><i class="iconfont icon-roundadd"></i><span>添加链接</span></a>
                    </div>
                </td>
            </tr>
            </tbody>
            {/loop}
            <tbody id="newCategory"></tbody>
            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td colspan="3"><a id="addCategory"><i class="iconfont icon-roundadd"></i><span>添加分类</span></a></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <div class="pagination">{$pagination}</div>
                    <label><input type="submit" class="button" value="提交" /></label>
                    <label><input type="button" class="button button-cancel" value="刷新" onclick="DSXUtil.reFresh()" /></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    var k = 0;
    $(function () {
         $("#addCategory").on('click', function () {
             $("#newCategory").append('<tr>' +
                 '        <td><input type="hidden" name="itemlist['+k+'][type]" value="category" /></td>' +
                 '        <td></td>' +
                 '        <td><input type="text" title="" class="input-text" name="itemlist['+k+'][title]" value="新分类" maxlength="10"></td>' +
                 '        <td><input type="text" title="" class="input-text w60" name="itemlist['+k+'][displayorder]" value="0" maxlength="4"></td>' +
                 '        <td></td>' +
                 '    </tr>');
             k--;
         });

         $("[rel=addItem]").on('click', function () {
             var catid = $(this).attr('data-id');
             $("#newItem_"+catid).append('<tr>' +
                 '        <td><input type="hidden" name="itemlist['+k+'][catid]" value="'+catid+'" /></td>\n' +
                 '        <td><input type="hidden" name="itemlist['+k+'][type]" value="item" /></td>\n' +
                 '        <td><div class="catlog"><input type="text" class="input-text" name="itemlist['+k+'][title]" value="新链接" maxlength="10"></div></td>\n' +
                 '        <td><input type="text" class="input-text w60" name="itemlist['+k+'][displayorder]" value="0" maxlength="4"></td>\n' +
                 '        <td><input type="text" class="input-text w300" name="itemlist['+k+'][url]" value=""></td>\n' +
                 '    </tr>');
             k--;
         });

         $("img[rel=pickimg]").on('click', function () {
             var id = $(this).attr('data-id'), self = this;
             DSXUI.showImagePicker(function (data) {
                 $(self).attr('src', data.thumburl);
                 $.post("{URL:('/admin/link/setimage')}",{id:id,image:data.image});
             });
         });
    });
</script>
{template footer}
