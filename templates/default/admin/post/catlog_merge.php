{template header}
<div class="console-title">
    <a href="{URL:('/admin/postcatlog/index')}" class="button float-right">返回列表</a>
	<h2>文章管理 > 合并分类</h2>
</div>
<div class="content-div">
	<form method="post">
    	{__formhash__}
    	<table cellpadding="0" cellspacing="0" width="100%" class="formtable">
        	<tbody>
            	<tr>
                	<th width="300">源分类</th>
                    <td width="50"></td>
                    <th>目标分类</th>
                </tr>
            	<tr>
                    <td>
                    	<select name="source[]" size="10" class="select" multiple="multiple" title="" style="height:300px;">
                            {loop $catloglist[0] $catid1 $cat1}
                            <option value="{$catid1}">{$cat1[name]}</option>
                            {loop $catloglist[$catid1] $catid2 $cat2}
                            <option value="{$catid2}">|--{$cat2[name]}</option>
                            {loop $catloglist[$catid2] $catid3 $cat3}
                            <option value="{$catid3}">|--|--{$cat3[name]}</option>
                            {/loop}
                            {/loop}
                            {/loop}
                        </select>
                    </td>
                	<td class="align-center" style="vertical-align: middle;">>></td>
                    <td>
                    	<select name="target" size="10" class="select" title="" style="width:300px; height:300px;">
                            {loop $catloglist[0] $catid1 $cat1}
                            <option value="{$catid1}">{$cat1[name]}</option>
                            {loop $catloglist[$catid1] $catid2 $cat2}
                            <option value="{$catid2}">|--{$cat2[name]}</option>
                            {loop $catloglist[$catid2] $catid3 $cat3}
                            <option value="{$catid3}">|--|--{$cat3[name]}</option>
                            {/loop}
                            {/loop}
                            {/loop}
                        </select>
                    </td>
                </tr>
            </tbody>
            <tfoot>
            	<tr>
                	<td>
                    	<input type="submit" class="button" value="确认合并">
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>
{template footer}
