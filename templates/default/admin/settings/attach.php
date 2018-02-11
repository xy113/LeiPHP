{template header}
<div class="console-title">
    <h2>系统设置->附件设置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="{URL:('/admin/settings/save')}">
        {__formhash__}
        <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="attach">
            <tr>
                <td class="cell-name" width="100">允许上传的文件类型:</td>
                <td width="320"><input title="" name="settings[file_allow_types]" class="input-text w300" value="{$settings[file_allow_types]}" type="text"></td>
                <td>填写文件扩展名，多个名称间请用半角逗号 "," 隔开</td>
            </tr>
            <tr>
                <td class="cell-name">允许上传的文件最大限制:</td>
                <td><input title="" name="settings[file_max_size]" class="input-text w300" value="{$settings[file_max_size]}" type="text"></td>
                <td>允许上传的文件体积最大值，单位MB</td>
            </tr>
            <tr>
                <td class="cell-name">允许上传的图片类型:</td>
                <td><input title="" name="settings[image_allow_types]" class="input-text w300" value="{$settings[image_allow_types]}"></td>
                <td>填写文件扩展名，多个名称间请用半角逗号 "," 隔开</td>
            </tr>
            <tr>
                <td class="cell-name">允许上传的图片最大限制:</td>
                <td><input title="" name="settings[image_max_size]" class="input-text w300" value="{$settings[image_max_size]}"></td>
                <td>允许上传的文件体积最大值，单位MB</td>
            </tr>
            <tr>
                <td class="cell-name">图片缩略图宽:</td>
                <td><input title="" name="settings[image_thumb_width]" class="input-text w300" value="{$settings[image_thumb_width]}"></td>
                <td>图片缩略图宽度，单位像素</td>
            </tr>
            <tr>
                <td class="cell-name">图片缩略图高:</td>
                <td><input title="" name="settings[image_thumb_height]" class="input-text w300" value="{$settings[image_thumb_height]}"></td>
                <td>图片缩略图高度，单位像素</td>
            </tr>
            <tr>
                <td class="cell-name">图片最大宽度:</td>
                <td><input title="" name="settings[image_max_width]" class="input-text w300" value="{$settings[image_max_width]}"></td>
                <td>单位像素，图片宽度超过设定值将自动压缩，不限请填0</td>
            </tr>
            <tr>
                <td class="cell-name">图片最大高度:</td>
                <td><input title="" name="settings[image_max_height]" class="input-text w300" value="{$settings[image_max_height]}"></td>
                <td>单位像素，图片高度超过设定值将自动压缩，不限请填0</td>
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
