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
 * Time: 上午9:33
 */

namespace App\Models;


use Core\Model;

class Block extends Model
{

    protected $table = 'block';
    protected $primaryKey = 'block_id';

    /**
     * @param $block_id
     * @return bool|mixed
     */
    public function setCache($block_id){
        $itemlist = BlockItem::getInstance()->where(array('block_id'=>$block_id))->order('displayorder ASC,id ASC')->select();
        return cache('block_items_'.$block_id, $itemlist);
    }

    /**
     * @param $block_id
     * @return bool|mixed
     */
    public function getCache($block_id){
        $cache = cache('block_items_'.$block_id);
        if (is_array($cache)) {
            return $cache;
        }else {
            $this->setCache($block_id);
            return $this->getCache($block_id);
        }
    }
}
