{template header}
<div class="console-title">
    <h2>系统设置->微信设置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="{URL:('/admin/settings/save')}">
        {__formhash__}
        <table class="formtable" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="weixin">
            <tr>
                <td class="cell-name" width="140">公众号APPID:</td>
                <td width="320"><input title="" name="settings[wx.appid]" class="input-text w300" value="{$settings['wx.appid']}" type="text"></td>
                <td>微信公众号appID</td>
            </tr>
            <tr>
                <td class="cell-name">公众号APPSECRET:</td>
                <td><input title="" name="settings[wx.appsecret]" class="input-text w300" value="{$settings['wx.appsecret']}" type="text"></td>
                <td>微信公众号appSecret</td>
            </tr>
            <tr>
                <td class="cell-name">微信支付商户号:</td>
                <td><input title="" name="settings[wx.mch_id]" class="input-text w300" value="{$settings['wx.mch_id']}"></td>
                <td>微信支付商户ID</td>
            </tr>
            <tr>
                <td class="cell-name">微信支付API安全秘钥:</td>
                <td><input title="" name="settings[wx.mch_key]" class="input-text w300" value="{$settings['wx.mch_key']}"></td>
                <td>微信支付API安全秘钥，不超过32位</td>
            </tr>
            <tr>
                <td class="cell-name">被关注自动回复:</td>
                <td>
                    <label><input type="radio" name="settings[wx.subscribe_msgtype]" value="1"{if $settings['wx.subscribe_msgtype']==1} checked{/if}> 文字消息</label>
                    <label><input type="radio" name="settings[wx.subscribe_msgtype]" value="2"{if $settings['wx.subscribe_msgtype']==2} checked{/if}> 图文消息</label>
                </td>
                <td>自动回复</td>
            </tr>
            <tr>
                <td class="cell-name">自动回复内容:</td>
                <td><textarea title="" name="settings[wx.subscribe_message]" class="textarea w300">{$settings['wx.subscribe_message']}</textarea></td>
                <td>公众号被关注时自动回复的文字内容</td>
            </tr>
            <tr>
                <td class="cell-name">自动回复图文消息:</td>
                <td><input title="" name="settings[wx.subscribe_media_id]" class="input-text w300" value="{$settings['wx.subscribe_media_id']}"></td>
                <td>公众号被关注时自动回复的图文消息，请填写素材的media_id</td>
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
