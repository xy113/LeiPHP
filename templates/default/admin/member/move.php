{template header}
<div class="console-title">
	<h2>选择目标分组</h2>
</div>
<div class="area">
	<form method="post" action="{echo U('a=moveto')}">
    	<input type="hidden" name="formsubmit" value="yes">
        <input type="hidden" name="formhash" value="{FORMHASH}">
        <input type="hidden" name="uids" value="$uids">
    	<table cellpadding="0" cellspacing="0" width="100%" class="formtable">
        	<tbody>
            	<tr>
                    <td>目标分组</td>
                </tr>
            	<tr>
                    <td>
                    	<select name="target" size="10" class="select" style="width:300px; height:300px;">
                        {loop $usergrouplist $group}
                        <option value="{$group[gid]}">{$group[title]}</option>
                        {/loop}
                        </select>
                    </td>
                </tr>
            </tbody>
            <tfoot>
            	<tr>
                	<td>
                    	<input type="submit" class="button" value="提交">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
{template footer}