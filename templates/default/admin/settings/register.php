{template header}
<div class="console-title">
    <h2>系统设置->注册设置</h2>
</div>
<div class="content-div">
    <form method="post" id="settingForm" action="{{url('/admin/settings/save')}}">
        {__formhash__}
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="formtable">
            <tbody>
            <tr>
                <td class="cell-name" width="90">开放用户注册:</td>
                <td width="320">
                    <label><input type="radio" value="1" class="radio" name="settings[regallowed]"{if $settings[regallowed]} checked{/if}>是</label>
                    <label><input type="radio" value="0" class="radio" name="settings[regallowed]"{if !$settings[regallowed]} checked{/if}>否</label>
                </td>
                <td>设置是否允许游客注册成为网站会员。</td>
            </tr>
            <tr>
                <td class="cell-name">新用户注册验证:</td>
                <td>
                    <select title="" class="select" name="settings[regverify]">
                        <option value="0"{if $settings[regverify]=='0'} selected{/if}>无</option>
                        <option value="1"{if $settings[regverify]=='1'} selected{/if}>Email验证</option>
                        <option value="2"{if $settings[regverify]=='2'} selected{/if}>人工审核</option>
                    </select>
                </td>
                <td>选择“无”用户可直接注册成功；选择“Email 验证”将向用户注册 Email 发送一封验证邮件以确认邮箱的有效性；
                    选择“人工审核”将由管理员人工逐个确定是否允许新用户注册</td>
            </tr>
            <tr>
                <td class="cell-name">发送欢迎信息:</td>
                <td>
                    <ul>
                        <li><input title="" type="radio" value="0" class="radio" name="settings[wellcomemsg]"{if $settings[wellcomemsg]=='0'} checked{/if}> 不发送</li>
                        <li><input title="" type="radio" value="1" class="radio" name="settings[wellcomemsg]"{if $settings[wellcomemsg]=='1'} checked{/if}> 发送欢迎短信息</li>
                        <li><input title="" type="radio" value="2" class="radio" name="settings[wellcomemsg]"{if $settings[wellcomemsg]=='2'} checked{/if}> 发送欢迎Email</li>
                    </ul>
                </td>
                <td>可选择是否自动向新注册用户发送一条欢迎信息</td>
            </tr>
            <tr>
                <td class="cell-name">欢迎邮件标题:</td>
                <td><input title="" type="text" name="settings[wellcomemsgtitle]" value="{$settings[wellcomemsgtitle]}" class="input-text w300"></td>
                <td>系统发送的欢迎信息的标题，不支持 HTML，不超过 75 字节。</td>
            </tr>
            <tr>
                <td class="cell-name">欢迎邮件内容:</td>
                <td><textarea title="" class="textarea w300" name="settings[wellcomemsgtxt]" style="height: 150px;">{$settings[wellcomemsgtxt]}</textarea></td>
                <td>系统发送的欢迎信息的内容。标题内容均支持变量替换，可以使用如下变量:<br>{username} : 用户名<br>{time} : 发送时间<br>{sitename} : 站点名称<br>{adminemail} : 管理员email</td>
            </tr>
            <tr>
                <td class="cell-name">显示许可协议:</td>
                <td>
                    <label><input type="radio" value="1" class="radio" name="settings[sysrules]"{if $settings[sysrules]} checked{/if}> 是</label>
                    <label><input type="radio" value="0" class="radio" name="settings[sysrules]"{if !$settings[sysrules]} checked{/if}> 否</label>
                </td>
                <td>新用户注册时显示许可协议</td>
            </tr>
            <tr>
                <td class="cell-name">许可协议内容:</td>
                <td><textarea title="" class="textarea w300" name="settings[sysrulestxt]" style="height: 150px;">{$settings[sysrulestxt]}</textarea></td>
                <td>注册许可协议的详细内容</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td colspan="2"><input type="submit" value="更新配置" class="button"></td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
{template footer}
