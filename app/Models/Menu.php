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
 * Time: 上午9:39
 */

namespace App\Models;


use Core\Model;

class Menu extends Model
{

    protected $table = 'menu';
    protected $primaryKey = 'id';

    /**
     *
     */
    public function setCache(){
        $menulist = array();
        foreach ($this->where(array('type'=>'item'))->order('displayorder ASC,id ASC')->select() as $menu){
            $menulist[$menu['menuid']][$menu['id']] = $menu;
        }

        foreach ($menulist as $menuid=>$items){
            cache('menu_'.$menuid, $items);
        }
    }

    /**
     * @param $menuid
     * @return bool|mixed
     */
    public function getCache($menuid){
        $menulist = cache('menu_'.$menuid);
        if (is_array($menulist)) {
            return $menulist;
        }else {
            $this->setCache();
            return $this->getCache($menuid);
        }
    }
}
