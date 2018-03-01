{template header}
<script src="/static/DatePicker/WdatePicker.js"></script>
<div class="navigation">
    <a>后台管理</a>
    <span>></span>
    <a>会员管理</a>
    <span>></span>
    <a>会员列表</a>
</div>
<div class="search-container">
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="{$_G[m]}">
        <input type="hidden" name="c" value="{$_G[c]}">
        <input type="hidden" name="a" value="{$_G[a]}" id="J_a">
        <div class="row">
            <div class="cell">
                <label>用户名:</label>
                <div class="field"><input type="text" title="" class="input-text" name="username" value="{$username}"></div>
            </div>
            <div class="cell">
                <label>手机号:</label>
                <div class="field"><input type="text" title="" class="input-text" name="mobile" value="{$mobile}"></div>
            </div>
            <div class="cell">
                <label>邮箱:</label>
                <div class="field"><input type="text" title="" class="input-text" name="email" value="{$email}"></div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>会员ID:</label>
                <div class="field"><input type="text" title="" class="input-text" name="uid" value="{$uid}"></div>
            </div>
            <div class="cell">
                <label>注册日期:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="reg_time_begin" onclick="WdatePicker()" value="{$reg_time_begin}" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="reg_time_end" onclick="WdatePicker()" value="{$reg_time_end}" style="width: 100px;">
                </div>
            </div>
            <div class="cell">
                <label>最后登录:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="last_visit_begin" onclick="WdatePicker()" value="{$last_visit_begin}" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="last_visit_end" onclick="WdatePicker()" value="{$last_visit_end}" style="width: 100px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label></label>
                <div class="field">
                    <button type="submit" class="button" id="btn-search">搜索</button>
                    <button type="button" class="button button-cancel" id="btn-export">重置</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="content-div">
    <form method="post" id="listForm" action="">
        {__formhash__}
        <input type="hidden" name="eventType" value="" id="J_eventType">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="20">选</th>
                <th width="30">头像</th>
                <th>姓名</th>
                <th>手机号</th>
                <th>电子邮箱</th>
                <th>用户组</th>
                <th>注册日期</th>
                <th>最后登录</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody id="members">
            {foreach $memberlist $uid $member}
            {eval $uid=$member[uid]}
            {eval $status_name=$_lang[member_status][$member[status]]}
            {eval $isfounder=in_array($uid, C('FOUNDERS'));}
            {eval $grouptitle=$grouplist[$member[gid]][title]}
            <tr>
                <td><input title="" type="checkbox" class="checkbox checkmark"{if $isfounder} disabled="disabled"{else} name="members[]" value="{$uid}"{/if} /></td>
                <td><img src="{{avatar($uid,'small')}}" width="30" height="30" style="border-radius:100%;"></td>
                <th><a>{$member[username]}</a></th>
                <td>{$member[mobile]}</td>
                <td>{$member[email]}</td>
                <td>{$grouptitle}</td>
                <td><a href="http://ip.taobao.com/?ip={$member[regip]}" target="_blank">{date:$member[regdate]|'Y-m-d H:i:s'}</a></td>
                <td><a href="http://ip.taobao.com/?ip={$member[lastvisitip]}" target="_blank">{date:$member[lastvisit]|'Y-m-d H:i:s'}</a></td>
                <td>{$status_name}</td>
            </tr>
            {/foreach}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="12">
                    <div class="pagination float-right">{$pagination}</div>
                    <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
                    <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                    <label><button type="button" class="btn btn-action" data-action="allow">允许登录</button></label>
                    <label><button type="button" class="btn btn-action" data-action="forbiden">禁止登录</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $(".btn-action").on('click', function () {
            var spinner = null;
            var action = $(this).attr('data-action');
            var submitForm = function () {
                $("#listForm").ajaxSubmit({
                    dataType:'json',
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },success:function (response) {
                        setTimeout(function () {
                            spinner.close();
                            if (response.errcode === 0){
                                DSXUtil.reFresh();
                            }else {
                                DSXUI.error(response.errmsg);
                            }
                        }, 500);
                    }
                });
            }
            $("#J_eventType").val(action);
            if (action === 'delete'){
                DSXUI.showConfirm('删除会员', '确认要删除所选会员吗?', function () {
                    submitForm();
                });
            }else {
                submitForm();
            }
        });
    });
</script>
{template footer}
