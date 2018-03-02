{template header}
<div class="console-title">
    <div class="float-right">
        <a href="{URL:('/admin/pages/add',array('catid'=>$catid))}" class="button">添加页面</a>
    </div>
    <h2>页面管理</h2>
</div>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab{if !$catid} on{/if}"><a href="{URL:('/admin/pages')}">全部</a><span>|</span></div>
        {foreach $categorylist $clist}
        <div class="tab{if $catid==$clist[pageid]} on{/if}"><a href="{URL:('/admin/pages','catid='.$clist[pageid])}">{$clist[title]}</a><span>|</span></div>
        {/foreach}
    </div>
</div>

<div class="content-div">
    <form method="post" action="" id="listForm">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40">删?</th>
                <th>标题</th>
                <th>别名</th>
                <th width="80">排序</th>
                <th width="120">发布时间</th>
                <th width="120">最后修改</th>
                <th width="40">编辑</th>
            </tr>
            </thead>
            <tbody>
            {foreach $pagelist $item}
            {eval $pageid=$item[pageid]}
            <tr>
                <td><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="delete[]" value="{$pageid}"></td>
                <th><a href="{URL:('/pages/detail','pageid='.$pageid)}" target="_blank">{$item[title]}</a></th>
                <td>{$item[alias]}</td>
                <td><input title="" type="text" class="input-text w60" name="pagelist[{$pageid}][displayorder]" value="{$item[displayorder]}" /></td>
                <td>{echo @date('Y-m-d H:i',$item[create_at])}</td>
                <td>{echo @date('Y-m-d H:i',$item[update_at])}</td>
                <td><a href="{URL:('/admin/pages/edit','pageid='.$pageid)}">编辑</a></td>
            </tr>
            {/foreach}
            </tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <span class="float-right">{$pagination}</span>
                    <label><input type="checkbox" class="checkbox checkall"> 全选</label>
                    <label><button type="submit" class="btn">提交</button></label>
                    <label><button type="button" class="btn" onclick="DSXUtil.reFresh()">刷新</button></label>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/javascript">
$(function () {
    $("#deleteButton").on('click', function () {
        if ($(".itemCheckBox:checked").length === 0){
            DSXUI.error('请选择项目');
            return false;
        }
        var spinner = null;
        $("#listForm").ajaxSubmit({
            dataType:'json' ,
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
    });
});
</script>
{template footer}
