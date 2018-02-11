<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/11
 * Time: 上午9:43
 */

namespace App\Controllers\Admin;


use App\Models\PostCatlog;
use App\Models\PostItem;
use Core\Pinyin;

class PostcatlogController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }

    /**
     *
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()) {
            $catloglist = $_GET['catloglist'];
            if ($catloglist && is_array($catloglist)){
                foreach ($catloglist as $catid=>$catlog){
                    if ($catlog['name']) {
                        PostCatlog::getInstance()->where(array('catid'=>$catid))->data($catlog)->save();
                    }
                }
                PostCatlog::getInstance()->updateCache();
            }
            $this->showSuccess('update_succeed');
        }else {

            $catloglist = $this->getCatlogList();
            include view('post/catlog_list');
        }
    }

    /**
     * 添加分类
     */
    public function add(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $catlog = $_GET['catlog'];
            if ($catlog['name']) {
                $pinyin = new Pinyin();
                $catlog['identifer'] = $pinyin->getPinyin($catlog['name']);

                PostCatlog::getInstance()->add($catlog);
                PostCatlog::getInstance()->updateCache();
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_add', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>URL('/admin/postcatlog/index'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $catloglist = $this->getCatlogList();
            include view('post/catlog_form');
        }
    }

    /**
     * 编辑分类
     */
    public function edit(){
        global $_G, $_lang;

        $catid = intval($_GET['catid']);

        if ($this->checkFormSubmit()){
            $catlog = $_GET['catlog'];
            if ($catlog['name']) {
                $pinyin = new Pinyin();
                $catlog['identifer'] = $pinyin->getPinyin($catlog['name']);

                PostCatlog::getInstance()->where(array('catid'=>$catid))->data($catlog)->save();
                PostCatlog::getInstance()->updateCache();
                $this->showSuccess('update_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>URL('/admin/postcatlog/index'))
                ));
            }else {
                $this->showError('invalid_parameter');
            }
        }else {

            $catlog = PostCatlog::getInstance()->where(array('catid'=>$catid))->getOne();
            $catloglist = $this->getCatlogList();

            include view('post/catlog_form');
        }
    }

    /**
     * 删除分类
     */
    public function delete(){
        global $_G, $_lang;

        $catid = intval($_GET['catid']);
        if ($this->checkFormSubmit()){
            $moveto = intval($_GET['moveto']);
            $deleteChilds = intval($_GET['deleteChilds']);

            if (!$deleteChilds && !$moveto){
                $this->showError('invalid_parameter');
            }

            $childIds = PostCatlog::getInstance()->getAllChildIds($catid);
            if (PostCatlog::getInstance()->where(array('catid'=>$catid))->delete()){
                if ($deleteChilds) {
                    foreach ($childIds as $catid){
                        PostCatlog::getInstance()->where(array('catid'=>$catid))->delete();
                    }
                    $itemlist = PostItem::getInstance()->where(array('catid'=>array('IN', implodeids($childIds))))->select();
                    foreach ($itemlist as $item){
                        PostItem::getInstance()->deleteAll($item['aid']);
                    }
                }else {
                    foreach (PostCatlog::getInstance()->where(array('fid'=>$catid))->select() as $catlog){
                        PostCatlog::getInstance()->where(array('catid'=>$catlog['catid']))->data(array('fid'=>$moveto))->save();
                    }
                    PostItem::getInstance()->where(array('catid'=>$catid))->data(array('catid'=>$moveto))->save();
                }
                PostCatlog::getInstance()->updateCache();
            }
            $this->showSuccess('delete_succeed', null, array(
                array('text'=>'back_list', 'url'=>URL('/admin/postcatlog/index'))
            ));
        }else {

            $catlog = PostCatlog::getInstance()->where(array('catid'=>$catid))->getOne();
            $catloglist = $this->getCatlogList();
            include view('post/catlog_delete');
        }
    }

    /**
     * 合并分类
     */
    public function merge(){
        global $_G, $_lang;

        if ($this->checkFormSubmit()){
            $target = intval($_GET['target']);
            $source = $_GET['source'];
            if (is_array($source)) {
                foreach ($source as $catid){
                    if ($catid != $target){
                        PostItem::getInstance()->where(array('catid'=>$catid))->data(array('catid'=>$target))->save();
                        PostCatlog::getInstance()->where(array('catid'=>$catid))->delete();
                    }
                }
                PostCatlog::getInstance()->updateCache();
            }
            $this->showSuccess('update_succeed', null, array(
                array('text'=>'back_list', 'url'=>URL('/admin/postcatlog/index'))
            ));
        }else {

            $catloglist = $this->getCatlogList();
            include view('post/catlog_merge');
        }
    }

    /**
     *
     */
    public function seticon(){
        $catid = intval($_GET['catid']);
        $icon = htmlspecialchars($_GET['icon']);
        if ($catid && $icon){
            PostCatlog::getInstance()->where(array('catid'=>$catid))->data(array('icon'=>$icon))->save();
        }
        $this->showAjaxReturn();
    }

    /**
     * @return array
     */
    private function getCatlogList(){
        $catloglist = array();
        foreach (PostCatlog::getInstance()->order('displayorder ASC,catid ASC')->select() as $catlog){
            $catloglist[$catlog['fid']][$catlog['catid']] = $catlog;
        }
        return $catloglist;
    }
}
