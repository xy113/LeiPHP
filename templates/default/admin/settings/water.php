{template header}
<div class="console-title">
    <h2>系统设置->水印设置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="{URL:('/admin/settings/save')}">
        {__formhash__}
        <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="water">
            <tr>
                <td class="cell-name" width="90">开启图片水印:</td>
                <td width="320">
                    <label><input name="settings[water_mark]" type="radio" class="radio" value="1"{if $settings[water_mark]=='1'} checked{/if}> 是</label>
                    <label><input name="settings[water_mark]" type="radio" class="radio" value="0"{if $settings[water_mark]=='0'} checked{/if}> 否</label>
                </td>
                <td>是否启用图片水印</td>
            </tr>
            <tr>
                <td class="cell-name">水印类型:</td>
                <td>
                    <label><input name="settings[water_type]" type="radio" class="radio" value="1"{if $settings[water_type]=='1'} checked{/if}> 图片水印</label>
                    <label><input name="settings[water_type]" type="radio" class="radio" value="0"{if $settings[water_type]=='0'} checked{/if}> 文字水印</label>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="cell-name">水印位置:</td>
                <td>
                    <select title="" class="select w200" name="settings[water_pos]">
                        <option value="1"{if $settings[water_pos]=='1'} selected{/if}>左上角</option>
                        <option value="2"{if $settings[water_pos]=='2'} selected{/if}>上居中</option>
                        <option value="3"{if $settings[water_pos]=='3'} selected{/if}>右上角</option>
                        <option value="4"{if $settings[water_pos]=='4'} selected{/if}>左居中</option>
                        <option value="5"{if $settings[water_pos]=='5'} selected{/if}>居中</option>
                        <option value="6"{if $settings[water_pos]=='6'} selected{/if}>右居中</option>
                        <option value="7"{if $settings[water_pos]=='7'} selected{/if}>左下角</option>
                        <option value="8"{if $settings[water_pos]=='8'} selected{/if}>下居中</option>
                        <option value="9"{if $settings[water_pos]=='9'} selected{/if}>右下角</option>
                    </select>
                </td>
                <td></td>
            </tr>
            <tr>
                <td class="cell-name">水印透明度:</td>
                <td><input title="" name="settings[water_alpha]" class="input-text w300" value="{$settings[water_alpha]}"></td>
                <td>水印透明度,100为不透明</td>
            </tr>
            <tr>
                <td class="cell-name">水印文字:</td>
                <td><textarea title="" name="settings[water_text]" class="textarea w300">{$settings[water_text]}</textarea></td>
                <td>水印文字，仅当设定为文字水印时有效</td>
            </tr>
            <tr>
                <td class="cell-name">水印颜色:</td>
                <td><input title="" name="settings[water_color]" class="input-text w300" value="{$settings[water_color]}"></td>
                <td>水印文字颜色，仅当设定为文字水印时有效</td>
            </tr>
            <tr>
                <td class="cell-name">字体大小:</td>
                <td><input title="" name="settings[water_size]" class="input-text w300" value="{$settings[water_size]}"></td>
                <td>水印文字字体大小，仅当设定为文字水印时有效</td>
            </tr>
            <tr>
                <td class="cell-name">位置偏移量:</td>
                <td><input title="" name="settings[water_offset]" class="input-text w300" value="{$settings[water_offset]}"></td>
                <td>水印位置偏移量，单位像素</td>
            </tr>
            <tr>
                <td class="cell-name">旋转角度:</td>
                <td><input title="" name="settings[water_angle]" class="input-text w300" value="{$settings[water_angle]}"></td>
                <td>水印文字旋转角度</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><input class="button submit" value="更新配置" type="submit"></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
{template footer}
