<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/10
 * Time: 上午10:18
 */

namespace App\Models;


use Core\Model;

class PostItem extends Model
{

    protected $table = 'post_item';
    protected $primaryKey = 'aid';
    public $timestamps = true;

    /**
     * @param $aid
     * @param int $num
     * @param int $type
     * @return bool|int
     */
    public function updateViewNum($aid, $num=1, $type=1){
        if ($type) {
            return $this->where(array('aid'=>$aid))->update("`view_num`=`view_num`+$num");
        }else {
            return $this->where(array('aid'=>$aid))->update("`view_num`=`view_num`-$num");
        }
    }

    /**
     * @param $aid
     */
    public function deleteAll($aid){
        $condition = array('aid'=>$aid);
        $this->where($condition)->delete();
        PostComment::getInstance()->where($condition)->delete();
        PostContent::getInstance()->where($condition)->delete();
        PostLog::getInstance()->where($condition)->delete();
        PostMedia::getInstance()->where($condition)->delete();
        PostImage::getInstance()->where($condition)->delete();
    }
}
