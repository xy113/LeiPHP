{template header}
<div class="console-title">
    <a href="{URL:('/admin/member/index')}" class="button float-right">用户列表</a>
    <h2>用户分组管理</h2>
</div>
<div class="content-div">
    <form method="post" autocomplete="off">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40" class="center">删?</th>
                <th width="50">GID</th>
                <th width="100">组名称</th>
                <th width="100">积分下线</th>
                <th width="110">积分上限</th>
            </tr>
            </thead>
            <tbody>
            <tr><th colspan="6">管理组</th></tr>
            @foreach($grouplist['system'] as $group)
            {eval $gid=$group[gid]}
            <tr>
                <td><input type="checkbox" class="checkbox" title="" name="delete[]" value="{$gid}" /></td>
                <td>{$gid}</td>
                <td><input type="text" title="" class="input-text w100" name="grouplist[{$gid}][title]" value="{{$group['title']}}" maxlength="10"></td>
                <td><input type="text" title="" class="input-text w100" name="grouplist[{$gid}][creditslower]" value="{$group[creditslower]}" maxlength="10"></td>
                <td><input type="text" title="" class="input-text w100" name="grouplist[{$gid}][creditshigher]" value="{$group[creditshigher]}" maxlength="10"></td>
            </tr>
            @endforeach
            </tbody>
            <tbody>
            <tr><th colspan="6">会员组</th></tr>
            @foreach($grouplist['member'] as $group)
            {eval $gid=$group[gid]}
            <tr>
                <td><input type="checkbox" class="checkbox" title="" name="delete[]" value="{$gid}" /></td>
                <td>{$gid}</td>
                <td><input type="text" title="" class="input-text w100" name="grouplist[{$gid}][title]" value="{$group[title]}" maxlength="10"></td>
                <td><input type="text" title="" class="input-text w100" name="grouplist[{$gid}][creditslower]" value="{$group[creditslower]}" maxlength="10"></td>
                <td><input type="text" title="" class="input-text w100" name="grouplist[{$gid}][creditshigher]" value="{$group[creditshigher]}" maxlength="10"></td>
            </tr>
            @endforeach
            </tbody>
            <tbody id="newgrouplist"></tbody>
            <tfoot>
            <tr>
                <td colspan="10"><a href="javascript:;" id="addgroup"><i class="iconfont icon-roundadd"></i>添加新分组</a></td>
            </tr>
            <tr>
                <td colspan="10">
                    <input type="submit" class="button" value="提交" />
                    <input type="button" class="button button-cancel" value="刷新" onclick="DSXUtil.reFresh()" />
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/html" id="rowtpl">
    <tr>
        <td></td>
        <td><input type="hidden" name="grouplist[nkey][type]" value="custom"></td>
        <td><input type="text" title="" class="input-text w100" name="grouplist[nkey][title]" value="" maxlength="10"></td>
        <td><input type="text" title="" class="input-text w100" name="grouplist[nkey][creditslower]" value="" maxlength="10"></td>
        <td><input type="text" title="" class="input-text w100" name="grouplist[nkey][creditshigher]" value="" maxlength="10"></td>
    </tr>
</script>
<script type="text/javascript">
    var nkey = 0;
    $("#addgroup").click(function(){
        nkey--;
        $("#newgrouplist").append($("#rowtpl").html().replace(/nkey/g,nkey));
    });
</script>
{template footer}
