{template header}
<div class="console-title">
    <div class="float-right">
        <form method="get" id="searchForm" action="">
            <input type="hidden" name="m" value="{$_G[m]}">
            <input type="hidden" name="c" value="{$_G[c]}">
            <input type="hidden" name="a" value="{$_G[a]}">
            <input type="hidden" name="province" value="{$province}" id="J_province">
            <input type="hidden" name="city" value="{$city}" id="J_city">
            <input type="hidden" name="county" value="{$county}" id="J_county">
            <select title="" id="province" class="select" style="width: auto;">
                <option>--省份--</option>
                {loop $provincelist $pro}
                <option value="{$pro[id]}"{if $pro[id]==$province} selected="selected"{/if}>{$pro[name]}</option>
                {/loop}
            </select>
            <select title="" id="city" class="select" style="width: auto;">
                <option value="0">--城市--</option>
                {loop $citylist $ct}
                <option value="{$ct[id]}"{if $ct[id]==$city} selected="selected"{/if}>{$ct[name]}</option>
                {/loop}
            </select>
            <select title="" id="county" class="select" style="width: auto;">
                <option value="0">--州县--</option>
                {loop $countylist $cot}
                <option value="{$cot[id]}"{if $cot[id]==$county} selected="selected"{/if}>{$cot[name]}</option>
                {/loop}
            </select>
        </form>
    </div>
    <h2>区域管理</h2>
</div>
<div class="content-div">
    <form method="post" action="">
        {__formhash__}
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
            <thead>
            <tr>
                <th width="40" class="center">删?</th>
                <th>名称</th>
                <th>拼音</th>
                <th>首字母</th>
                <th>区域代码</th>
                <th>经度</th>
                <th>纬度</th>
                <th>排序</th>
            </tr>
            </thead>
            <tbody>
            {loop $districtlist $dst}
            <tr>
                <td><input title="" type="checkbox" class="checkbox checkmark" name="delete[]" value="{$dst[id]}" /></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][name]" value="{$dst[name]}"></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][pinyin]" value="{$dst[pinyin]}"></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][letter]" value="{$dst[letter]}" style="width: 40px;"></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][zone_code]" value="{$dst[zone_code]}" style="width: 100px;"></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][lng]" value="{$dst[lng]}" style="width: 100px;"></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][lat]" value="{$dst[lat]}" style="width: 100px;"></td>
                <td><input title="" type="text" class="input-text" name="districtlist[{$dst[id]}][displayorder]" value="{$dst[displayorder]}" style="width: 60px;"></td>
            </tr>
            {/loop}
            </tbody>
            <tbody id="newDistrict"></tbody>
            <tfoot>
            <tr>
                <td colspan="10">
                    <label><input type="checkbox" class="checkbox checkall" /> 全选</label>
                    <a href="javascript:;" id="addnew"><i class="iconfont icon-roundadd"></i>添加区域</a>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <input type="submit" class="button" value="提交" />
                    <input type="button" class="button button-cancel" value="刷新" data-action="refresh" />
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
<script type="text/template" id="tplDistrict">
    <tr>
        <td></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][name]" value=""></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][pinyin]" value=""></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][letter]" value="" style="width: 40px;"></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][zone_code]" value="" style="width: 100px;"></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][lng]" value="" style="width: 100px;"></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][lat]" value="" style="width: 100px;"></td>
        <td><input title="" type="text" class="input-text" name="districtlist[#keynum#][displayorder]" value="" style="width: 60px;"></td>
    </tr>
</script>
<script type="text/javascript">
    var keynum = 0;
    $("#addnew").click(function(){
        var html = $("#tplDistrict").html().replace(/#keynum#/g,keynum);
        $("#newDistrict").append(html);
        keynum--;
    });
    $(function () {
        $("#province").on('change', function () {
            $("#J_province").val($(this).val());
            $("#J_city").val(0);
            $("#J_county").val(0);
            $("#searchForm").submit();
        });
        $("#city").on('change', function () {
            $("#J_city").val($(this).val());
            $("#J_county").val(0);
            $("#searchForm").submit();
        });
        $("#county").on('change', function () {
            $("#J_county").val($(this).val());
            $("#searchForm").submit();
        });
    });
</script>
{template footer}
