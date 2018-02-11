<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/9
 * Time: 下午4:09
 */

namespace App\Controllers\Admin;


use App\Models\Menu;

class MenuController extends BaseController
{

    /**
     * index
     */
    public function index(){

        $menuid = intval($_GET['menuid']);
        if ($menuid) {
            $this->itemlist();
        }else {
            $this->menulist();
        }
    }

    /**
     * 菜单列表
     */
    public function menulist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                foreach ($delete as $id){
                    Menu::getInstance()->where(array('id'=>$id))->delete();
                    Menu::getInstance()->where(array('menuid'=>$id))->delete();
                }
            }
            $menulist = $_GET['menulist'];
            if ($menulist && is_array($menulist)){
                $displayorder = 0;
                foreach ($menulist as $id=>$menu){
                    if ($menu['name']){
                        $menu['type'] = 'menu';
                        $menu['displayorder'] = $displayorder;
                        $displayorder++;
                        if ($id > 0){
                            Menu::getInstance()->where(array('id'=>$id))->data($menu)->save();
                        }else {
                            Menu::getInstance()->data($menu)->add();
                        }
                    }
                }
            }
            $this->updateCache();
            $this->showSuccess('save_succeed');
        }else {
            $menulist = Menu::getInstance()->where(array('type'=>'menu'))->select();
            include view('common/menu_names');
        }
    }

    /**
     * 菜单项列表
     */
    public function itemlist(){
        global $_G,$_lang;
        $menuid = intval($_GET['menuid']);
        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                foreach ($delete as $id){
                    Menu::getInstance()->where(array('id'=>$id))->delete();
                }
            }
            $itemlist = $_GET['itemlist'];
            if ($itemlist && is_array($itemlist)){
                $displayorder = 0;
                foreach ($itemlist as $id=>$item){
                    $item['type'] = 'item';
                    $item['menuid'] = $menuid;
                    $item['displayorder'] = $displayorder;
                    $displayorder++;
                    if ($item['name']) {
                        if ($id > 0){
                            Menu::getInstance()->where(array('id'=>$id))->data($item)->save();
                        }else {
                            Menu::getInstance()->data($item)->add();
                        }
                    }
                }
            }
            $this->updateCache();
            $this->showSuccess('save_succeed');
        }else {
            $menu = get_object_vars(Menu::getInstance()->where(array('id'=>$menuid))->getOne());
            $itemlist = Menu::getInstance()->where(array('menuid'=>$menuid))->order('displayorder ASC, id ASC')->select();

            include view('common/menu_items');
        }
    }

    private function printItems($items, $fid=0){
        $html = '';
        if (is_array($items)) {
            foreach ($items as $id=>$item){
                if ($item['fid'] == $fid){
                    $disabled = $item['type'] == 'system' ? ' disabled' : '';
                    $target[$item['target']] == ' selected';
                    $available = $item['available'] ? ' checked' : '';
                    $iconurl = image($item['icon']);
                    echo <<<END
					<div class="menu-item" style="margin: 0;">				     
				     <table cellpadding="0" cellspacing="0" width="100%" class="listtable border-none">
				        <tbody>
				            <tr>
				            	<td width="40">
				            		<input type="checkbox" class="checkbox checkmark" name="delete[]" value="$id">
				            		<input type="hidden" name="itemlist[$id][fid]" class="fid" value="$item[fid]">
				            	</td>
				            	<td width="70"><img src="$iconurl" width="50" height="50" rel="menuicon" data-id="{$id}"></td>
				            	<td width="120"><input type="text" name="itemlist[$id][name]" class="input-text" value="$item[name]" style="width: 100px;"></td>
				                <td><input type="text" name="itemlist[$id][url]" class="input-text w300" value="$item[url]"$disabled></td>
				                <td width="80">
				                	<select name="itemlist[$id][target]" style="width: auto;">
				                        <option value="_self"$target[_self]>本窗口</option>
				                        <option value="_blank"$target[_blank]>新窗口</option>
				                        <option value="_top"$target[_top]>顶层框架</option>
				                    </select>
				                </td>
				                <td width="40"><input type="checkbox" name="itemlist[$id][available]" value="1" $available></td>
				            </tr>
				        </tbody>
				    </table>
				    <div class="sub-menu" data-id="$id" style="padding-left:30px; min-height:10px;">
	
END;
                    $this->printItems($items, $id);
                    echo '</div></div>';
                }
            }
        }
    }

    /**
     *
     */
    public function seticon(){
        $id = intval($_GET['id']);
        $icon = trim($_GET['icon']);
        Menu::getInstance()->where(array('id'=>$id))->data(array('icon'=>$icon))->save();
        Menu::getInstance()->setCache();
        $this->showAjaxReturn();
    }

    /**
     * 更新菜单缓存
     */
    private function updateCache(){

        $menulist = Menu::getInstance()->where(array('type'=>'menu', 'available'=>1))->order('displayorder ASC,id ASC')->select();
        $itemlist = Menu::getInstance()->where(array('type'=>'item', 'available'=>1))->order('displayorder ASC,id ASC')->select();

        $cachelist = array();
        foreach ($itemlist as $item){
            $cachelist[$item->menuid][] = $item->toArray();
        }

        foreach ($cachelist as $menuid=>$menus){
            cache('menu_'.$menuid, $menus);
        }
    }
}
