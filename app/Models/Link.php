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
 * Time: 上午9:38
 */

namespace App\Models;


use Core\Model;

class Link extends Model
{

    protected $table = 'link';
    protected $primaryKey = 'id';

    /**
     *
     */
    public function updateCache(){
        $categorylist = $this->where(array('type'=>'categry'))->select();
        cache('link_category', $categorylist);
        $itemlist = $this->where(array('type'=>'item'))->select();
        cache('link_item', $itemlist);
    }

    /**
     * @return bool|mixed
     */
    public function getCategoryCache(){
        $categorylist = cache('link_category');
        if (!is_array($categorylist)) {
            $this->updateCache();
            return $this->getCategoryCache();
        }else {
            return $categorylist;
        }
    }

    /**
     * @return bool|mixed
     */
    public function getItemCache(){
        $itemlist = cache('link_item');
        if (!is_array($itemlist)) {
            $this->updateCache();
            return $this->getItemCache();
        }else {
            return $itemlist;
        }
    }
}
