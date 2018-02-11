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
 * Time: 上午10:21
 */

namespace App\Models;


use Core\Model;

class PostCatlog extends Model
{

    protected $table = 'post_catlog';
    protected $primaryKey = 'catid';


    /**
     * @return bool|mixed
     */
    public function updateCache(){
        $catloglist = array();
        foreach ($this->where(array('available'=>1))->order('displayorder ASC,catid ASC')->select() as $catlog){
            $catloglist[$catlog['catid']] = $catlog;
        }
        return cache('post_catlog', $catloglist);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $catloglist = cache('post_catlog');
        if (!is_array($catloglist)) {
            $this->updateCache();
            return $this->getCache();
        }else {
            return $catloglist;
        }
    }

    /**
     * 获取目录树
     * @return array
     */
    public function getCatlogTree(){
        $catloglist = array();
        foreach ($this->getCache() as $catlog){
            $catloglist[$catlog['fid']][$catlog['catid']] = $catlog;
        }
        return $catloglist;
    }

    /**
     * @param $catid
     * @return array
     */
    public function getAllChildIds($catid, &$childCatids=array()){
        static $catloglist;
        if (!$childCatids) $childCatids = array($catid);
        if (!$catloglist) $catloglist = $this->getCache();
        foreach ($catloglist as $catlog){
            if ($catlog['fid'] == $catid){
                $childCatids[] = $catlog['catid'];
                $this->getAllChildIds($catlog['catid'], $childCatids);
            }
        }
        return $childCatids;
    }

    /**
     * @param $catid
     * @param array $childCatlog
     * @return array
     */
    public function getAllChilds($catid, &$childCatlog=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = $this->getCache();
        if (!$childCatlog) $childCatlog[] = $catloglist[$catid];
        foreach ($catloglist as $catlog){
            if ($catlog['fid'] == $catid){
                $childCatlog[] = $catlog;
                $this->getAllChilds($catlog['catid'], $childCatlog);
            }
        }
        return $childCatlog;
    }

    /**
     * @param $catid
     * @param $parentCatids
     * @return mixed
     */
    public function getParentIds($catid, &$parentCatids=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = $this->getCache();
        if (!$parentCatids) $parentCatids = array($catid);

        $curCatlog = $catloglist[$catid];
        if ($curCatlog['fid']) {
            foreach ($catloglist as $catlog){
                if ($catlog['catid'] == $curCatlog['fid']){
                    $parentCatids[] = $catlog['catid'];
                    $this->getParentIds($catlog['catid'], $parentCatids);
                }
            }
        }
        return $parentCatids;
    }

    /**
     * @param $catid
     * @param array $parents
     * @return array
     */
    public function getParents($catid, &$parents=array()){
        static $catloglist;
        if (!$catloglist) $catloglist = $this->getCache();

        $curCatlog = $catloglist[$catid];
        if (!$parents) $parents = array($curCatlog);
        if ($curCatlog['fid']) {
            foreach ($catloglist as $catlog){
                if ($catlog['catid'] == $curCatlog['fid']){
                    $parents[] = $catlog['catid'];
                    $this->getParents($catlog['catid'], $parents);
                }
            }
        }
        return $parents;
    }
}
