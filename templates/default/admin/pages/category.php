{template header}
<div class="console-title">
    <a href="{URL:('/admin/page/add')}" class="button float-right">添加页面</a>
    <h2>页面分类</h2>
</div>
<div class="content-div">
    <form method="post" action="">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40">删?</th>
                <th width="80">显示顺序</th>
                <th>分类名称</th>
            </tr>
            </thead>
            <tbody id="newCategory">
            {foreach $categorylist $clist}
            {eval $pageid=$clist[pageid]}
            <tr>
                <td><input type="checkbox" title="" class="checkbox checkmark" name="delete[]" value="{$pageid}" /></td>
                <td><input type="text" title="" class="input-text w60" name="categorylist[{$pageid}][displayorder]" value="{$clist[displayorder]}" maxlength="4"></td>
                <td><input type="text" title="" class="input-text w200" name="categorylist[{$pageid}][title]" value="{$clist[title]}" maxlength="10"> </td>
            </tr>
            {/foreach}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5">
                    <label><input type="checkbox" class="checkbox checkall" name="delete[]" value="0" /> 全选</label>
                    <a href="javascript:;" onclick="addClass()"><i class="iconfont icon-roundadd"></i>添加分类</a></td>
            </tr>
            <tr>
                <td colspan="5">
                    <input type="submit" class="button" value="提交" />
                    <input type="button" class="button button-cancel" value="刷新" onclick="DSXUtil.reFresh()" />
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/template" id="J-category-tpl">
    <tr class="white">
        <td></td>
        <td><input type="text" title="" class="input-text w60" name="categorylist[#k#][displayorder]" value="0" maxlength="4"></td>
        <td><input type="text" title="" class="input-text w200" name="categorylist[#k#][title]" value="" maxlength="10"></td>
    </tr>
</script>
<script type="text/javascript">
    var k = 0;
    function addClass(){
        k--;
        var html = $("#J-category-tpl").html().replace(/#k#/g, k);
        $("#newCategory").append(html);
    }
</script>
{template footer}
