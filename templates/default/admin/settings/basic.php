{template header}
<div class="console-title">
    <h2>系统设置->基本设置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="{URL:('/admin/settings/save')}">
        {__formhash__}
        <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="basic">
            <tr>
                <td class="cell-name" width="90">网站名称:</td>
                <td width="320"><input title="" name="settings[sitename]" class="input-text w300" value="{$settings[sitename]}" type="text"></td>
                <td>系统名称，将显示在导航条和标题中</td>
            </tr>
            <tr>
                <td class="cell-name">网站地址:</td>
                <td><input title="" name="settings[siteurl]" class="input-text w300" value="{$settings[siteurl]}" type="text"></td>
                <td>网站 URL，将作为链接显示在页面底部</td>
            </tr>
            <tr>
                <td class="cell-name">关键字:</td>
                <td><input title="" name="settings[keywords]" class="input-text w300" value="{$settings[keywords]}"></td>
                <td>Keywords 项出现在页面头部的 Meta 标签中，用于记录本页面的关键字，多个关键字间请用半角逗号 "," 隔开</td>
            </tr>
            <tr>
                <td class="cell-name">网站描述:</td>
                <td><textarea title="" name="settings[description]" class="textarea w300" style="height: 100px;">{$settings[description]}</textarea></td>
                <td>Description 出现在页面头部的 Meta 标签中，用于记录本页面的概要与描述</td>
            </tr>
            <tr>
                <td class="cell-name">备案信息:</td>
                <td><input title="" name="settings[icp]" class="input-text w300" value="{$settings[icp]}" type="text"></td>
                <td>页面底部可以显示 ICP 备案信息，如果网站已备案，在此输入您的授权码，它将显示在页面底部，如果没有请留空</td>
            </tr>
            <tr>
                <td class="cell-name">版权信息:</td>
                <td><input title="" name="settings[copyright]" class="input-text w300" value="{$settings[copyright]}"></td>
                <td>网站的版权信息，将显示在页面底部</td>
            </tr>
            <tr>
                <td class="cell-name">统计代码:</td>
                <td><textarea title="" name="settings[statcode]" class="textarea w300" style="height: 100px;">{$settings[statcode]}</textarea></td>
                <td>用于统计网站访问情况的第三方统计代码，通常为JS代码</td>
            </tr>
            <tr>
                <td class="cell-name">关闭网站:</td>
                <td>
                    <label><input name="settings[sysclosed]" class="radio" value="1" type="radio"{if $settings[sysclosed]} checked="checked"{/if}> 是</label>
                    <label><input name="settings[sysclosed]" class="radio" value="0" type="radio"{if !$settings[sysclosed]} checked="checked"{/if}> 否</label>
                </td>
                <td>暂时将网站关闭，其他人无法访问，但不影响管理员访问</td>
            </tr>
            <tr>
                <td class="cell-name">关闭原因:</td>
                <td><textarea title="" name="settings[sysclosedreason]" class="textarea w300">{$settings[sysclosedreason]}</textarea></td>
                <td>网站关闭时出现的提示信息</td>
            </tr>
            <tr>
                <td class="cell-name">地图接口Key:</td>
                <td><input title="" name="settings[amap_key]" class="input-text w300" value="{$settings[amap_key]}"></td>
                <td>高德地图访问接口Key</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><input name="button-submit" class="button submit" value="更新配置" type="submit"></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>

{template footer}
