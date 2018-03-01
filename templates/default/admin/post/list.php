{template header}
<div class="console-title">
    <div class="float-right">
        <form name="search" action="{URL:('/')}">
            <input type="hidden" name="m" value="{$_G[m]}">
            <input type="hidden" name="c" value="{$_G[c]}">
            <input type="hidden" name="a" value="{$_G[a]}">
            <input type="hidden" name="searchType" value="0">
            <input type="text" title="" class="input-text" name="q" value="{$q}" placeholder="关键字">
            <label><button type="submit" class="button">快速搜索</button></label>
            <label><button type="button" class="button" onclick="$('#search-container').toggle()">高级搜索</button></label>
        </form>
    </div>
    <h2>文章管理->文章列表</h2>
</div>
<script src="/static/DatePicker/WdatePicker.js" type="text/javascript"></script>
<div class="search-container" id="search-container"{if !$searchType} style="display: none;"{/if}>
    <form method="get" id="searchFrom">
        <input type="hidden" name="m" value="{$_G[m]}">
        <input type="hidden" name="c" value="{$_G[c]}">
        <input type="hidden" name="a" value="{$_G[a]}">
        <input type="hidden" name="searchType" value="1">
        <div class="row">
            <div class="cell">
                <label>文章标题:</label>
                <div class="field"><input type="text" title="" class="input-text" name="title" value="{$title}"></div>
            </div>
            <div class="cell">
                <label>用户:</label>
                <div class="field"><input type="text" title="" class="input-text" name="username" value="{$username}"></div>
            </div>
            <div class="cell">
                <label>目录分类:</label>
                <div class="field">
                    <select name="catid" class="select" title="">
                        <option value="">全部</option>
                        {foreach $catloglist[0] $catid1 $cat1}
                        <option value="{$catid1}"{if $catid==$catid1} selected{/if}>{$cat1[name]}</option>
                        {foreach $catloglist[$catid1] $catid2 $cat2}
                        <option value="{$catid2}"{if $catid==$catid2} selected{/if}>|--{$cat2[name]}</option>
                        {foreach $catloglist[$catid2] $catid3 $cat3}
                        <option value="{$catid3}"{if $catid==$catid3} selected{/if}>|--|--{$cat3[name]}</option>
                        {/foreach}
                        {/foreach}
                        {/foreach}
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label>审核状态:</label>
                <div class="field">
                    <select name="status" class="select" title="">
                        <option value="">全部</option>
                        {foreach $_lang[post_status] $k $v}
                        <option value="{$k}"{if $status=="$k"} selected{/if}>{$v}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>形式:</label>
                <div class="field">
                    <select name="type" class="select" title="">
                        <option value="">全部</option>
                        {foreach $_lang[post_types] $k $v}
                        <option value="{$k}"{if $type==$k} selected{/if}>{$v}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="cell">
                <label>发布时间:</label>
                <div class="field">
                    <input type="text" title="" class="input-text" name="time_begin" value="{$time_begin}" onclick="WdatePicker()" style="width: 100px;"> -
                    <input type="text" title="" class="input-text" name="time_end" value="{$time_end}" onclick="WdatePicker()" style="width: 100px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="cell">
                <label></label>
                <div class="field">
                    <button type="submit" class="button">搜索</button>
                    <button type="reset" class="button button-cancel">重置</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="content-div">
    <form method="post" id="listForm">
        {__formhash__}
        <input type="hidden" name="eventType" id="J_eventType" value="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40" class="center"><input title="全选" type="checkbox" class="checkbox checkall checkmark"></th>
                <th width="60">图片</th>
                <th>标题</th>
                <th>用户</th>
                <th>分类</th>
                <th>形式</th>
                <th>点击</th>
                <th>时间</th>
                <th>状态</th>
                <th width="45">编辑</th>
            </tr>
            </thead>
            <tbody>
            {foreach $itemlist $item}
            {eval $aid=$item[aid]}
            {eval $type_name=$_lang['post_types'][$item['type']]}
            {eval $status_name=$_lang['post_status'][$item['status']]}
            <tr>
                <td class="center"><input type="checkbox" class="checkbox checkmark itemCheckBox" name="items[]" value="{$aid}"></td>
                <td><img src="{img $item[image]}" width="50" height="50" rel="pickimage" data-id="{$aid}"></td>
                <th><a href="{URL:('/post/detail',array('aid'=>$aid))}" target="_blank">{$item[title]}</a></th>
                <td>{$item[username]}</td>
                <td>{$item[cat_name]}</td>
                <td>{$type_name}</td>
                <td>{$item[view_num]}</td>
                <td>{date:$item[create_at]|'Y-m-d H:i:s'}</td>
                <td>{$status_name}</td>
                <td><a href="{URL:('/admin/post/publish', array('aid'=>$aid))}">编辑</a></td>
            </tr>
            {/foreach}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <div class="pagination float-right">{$pagination}</div>
                    <label><input type="checkbox" class="checkbox checkall checkmark"> {$_lang[selectall]}</label>
                    <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                    <label><button type="button" class="btn btn-action" data-action="move">移动</button></label>
                    <label><button type="button" class="btn btn-action" data-action="review" data-value="pass">审核通过</button></label>
                    <label><button type="button" class="btn btn-action" data-action="review" data-value="refuse">审核不过</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/template" id="targetTpl">
    <span style="float: left; line-height: 28px;">选择目标分类：</span>
    <select name="target" class="select" title="" id="moveTarget">
        {foreach $catloglist[0] $catid1 $cat1}
        <option value="{$catid1}">{$cat1[name]}</option>
        {foreach $catloglist[$catid1] $catid2 $cat2}
        <option value="{$catid2}">|--{$cat2[name]}</option>
        {foreach $catloglist[$catid2] $catid3 $cat3}
        <option value="{$catid3}">|--|--{$cat3[name]}</option>
        {/foreach}
        {/foreach}
        {/foreach}
    </select>
</script>
<script type="text/javascript">
    $(function () {
        var spinner;
        $("img[rel=pickimage]").on('click', function () {
            var self = this;
            var aid = $(this).attr('data-id');
            DSXUI.showImagePicker(function (data) {
                $(self).attr('src', data.imageurl);
                $.post("{{url('/admin/post/setimage')}}", {aid:aid,image:data.image});
            });
        });
        $(".btn-action").on('click', function () {
            if ($(".itemCheckBox:checked").length === 0){
                DSXUI.error('请选择文章');
                return false;
            }
            var action = $(this).attr('data-action');
            if (action === 'delete'){
                DSXUI.showConfirm('删除文章', '确认要删除所选文章吗?', function () {
                    $("#listForm").ajaxSubmit({
                        url:"{URL:('/admin/post/delete')}",
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },
                        success:function (response) {
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
                });
            }
            if (action === 'move'){
                DSXUI.dialog({
                    content:$("#targetTpl").html(),
                    title:'移动文章',
                    onConfirm:function (dlg) {
                        var target = $("#moveTarget").val();
                        dlg.close();
                        $("#listForm").ajaxSubmit({
                            url:"{URL:('/admin/post/move')}",
                            dataType:'json',
                            data:{target:target},
                            beforeSend:function () {
                                spinner = DSXUI.showSpinner();
                            },
                            success:function (response) {
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
                });
            }
            if (action === 'review'){
                $("#listForm").ajaxSubmit({
                    url:"{URL:('/admin/post/review')}",
                    dataType:'json',
                    data:{event:$(this).attr('data-value')},
                    beforeSend:function () {
                        spinner = DSXUI.showSpinner();
                    },
                    success:function (response) {
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
        });
    });
</script>
{template footer}
