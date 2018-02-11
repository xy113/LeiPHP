{template header}
<div class="console-title">
	<a href="{echo U('a=memberlist')}" class="submit f-right">返回列表</a>
	<h2>{if $G[a]=='edit'}编辑用户{else}添加用户{/if}</h2>
</div>
<div class="area">
    <form method="post">
    <input type="hidden" name="formsubmit" value="yes">
    <input type="hidden" name="formhash" value="{FORMHASH}" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formtable">
        <tbody>
          <tr><th colspan="3">用户名</th></tr>
          <tr>
            <td width="320"><input type="text" class="input-text w300" name="membernew[username]" value="{$member[username]}"></td>
            <td class="tips">用户名,注册后不可修改</td>
          </tr>
          <tr><th colspan="3">密码</th></tr>
          <tr>
            <td><input type="password" class="input-text w300" name="membernew[password]" value="" placeholder="******"></td>
            <td class="tips">6-20位英文字母数组符号和下划线组合, 无需修改请留空。</td>
          </tr>
          <tr><th colspan="3">手机号</th></tr>
          <tr>
            <td><input type="text" class="input-text w300" name="membernew[mobile]" value="{$member[mobile]}"></td>
            <td class="tips">13,14,15,16,17,18开头的11位手机号码，可用于登录</td>
          </tr>
          <tr><th colspan="3">电子邮箱</th></tr>
          <tr>
            <td><input type="text" class="input-text w300" name="membernew[email]" value="{$member[email]}"></td>
            <td class="tips">电子邮箱地址，可用于登录，找回密码等操作</td>
          </tr>
          <tr><th colspan="3">用户分组</th></tr>
          <tr>
            <td>
                <select class="w300" name="membernew[gid]">
                    {loop $grouplist $group}
                    <option value="$group[gid]"{if $group[gid]==$member[gid]} selected{/if}>{$group[title]}</option>
                    {/loop}
                </select>
            </td>
            <td class="tips">选择分组后用户将获得相应的分组权限</td>
          </tr>
          <tr><th colspan="3">允许登录后台</th></tr>
          <tr>
            <td>
                <label><input type="radio" class="radio" name="membernew[admincp]" value="1"{if $member[admincp]} checked{/if}> 是</label>&nbsp;&nbsp;    
                <label><input type="radio" class="radio" name="membernew[admincp]" value="0"{if !$member[admincp]} checked{/if}> 否</label>
            </td>
            <td class="tips">是否允许该用户登录后台</td>
          </tr>
          <tr><th colspan="3">用户权限</th></tr>
          <tr>
            <td colspan="3">
            {loop $lang[member_perms] $k=>$v}
            <label>
            <input type="checkbox" class="checkbox" value="1" name="permission[{$k}]"{if $permission[$k]} checked="checked"{/if}> {$v}
            </label>
            {/loop}
            </td>
          </tr>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="2">
                    <input type="submit" class="button" value="提交" />
                    <input type="button" class="button cancel" value="刷新" onclick="window.location.reload();" />
                </td>
            </tr>
        </tfoot>
    </table>
    </form>
</div>
<script type="text/javascript">
$("#groupperm").change(function(){
	if($(this).val()>0){
		$("#groupsetting").show();
	}else{
		$("#groupsetting").hide();
	}
});
</script>
{template footer}