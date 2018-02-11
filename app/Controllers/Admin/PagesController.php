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
 * Time: 上午10:01
 */

namespace App\Controllers\Admin;


use App\Models\Pages;

class PagesController extends BaseController
{
    /**
     *
     */
    public function index()
    {
        $this->itemlist();
    }

    /**
     *
     */
    public function itemlist(){
        global $_G, $_lang;

        if ($this->checkFormSubmit()){
            //删除页面
            $delete = $_GET['delete'];
            if (!empty($delete) && is_array($delete)){
                foreach ($delete as $pageid){
                    Pages::getInstance()->where(array('pageid'=>$pageid))->delete();
                }
            }
            //更新页面
            $pagelist  = $_GET['pagelist'];
            if ($pagelist && is_array($pagelist)){
                foreach ($pagelist as $pageid=>$page){
                    Pages::getInstance()->where(array('pageid'=>$pageid))->data($page)->update();
                }
            }
            $this->showSuccess('update_succeed');
        }else {

            $condition = array('type'=>'page');
            $catid = intval($_GET['catid']);
            if ($catid) $condition['catid'] = $catid;

            $pagesize   = 20;
            $totalnum   = Pages::getInstance()->where($condition)->count();
            $pagecount  = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $pagelist   = Pages::getInstance()->where($condition)->page($_G['page'], $pagesize)->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, "catid=$catid", true);
            $categorylist = Pages::getInstance()->where(array('type'=>'category'))->select();

            include view('pages/list');
        }

    }

    /**
     *
     */
    public function add(){
        global $_G, $_lang;

        if ($this->checkFormSubmit()) {
            $newpage = $_GET['newpage'];
            if (!$newpage['summary']) {
                $newpage['summary'] = mb_substr(stripHtml($newpage['body']), 200);
            }
            Pages::getInstance()->data($newpage)->add();
            $this->showSuccess('save_succeed');
        }else{
            $categorylist = Pages::getInstance()->where(array('type'=>'category'))->select();
            $editorname = 'newpage[body]';
            include view('pages/add');
        }
    }

    /**
     * 编辑页面
     */
    public function edit(){
        global $_G, $_lang;

        $pageid = intval($_GET['pageid']);
        if($this->checkFormSubmit()){
            $newpage = $_GET['newpage'];
            if (!$newpage['summary']) {
                $newpage['summary'] = mb_substr(stripHtml($newpage['body']), 200);
            }
            Pages::getInstance()->where(array('pageid'=>$pageid))->data($newpage)->save();
            $this->showSuccess('update_succeed');
        }else {
            $page = Pages::getInstance()->where(array('pageid'=>$pageid))->getOne();
            $categorylist = Pages::getInstance()->where(array('type'=>'category'))->select();
            $editorname = 'newpage[body]';
            $editorcontent = $page['body'];
            include view('pages/add');
        }
    }

    /**
     * 页面分类管理
     */
    public function category(){
        global $_G,$_lang;

        if($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if (!empty($delete) && is_array($delete)){
                foreach ($delete as $pageid){
                    Pages::getInstance()->where(array('pageid'=>$pageid))->delete();
                    Pages::getInstance()->where(array('catid'=>$pageid))->delete();
                }
            }

            $categorylist = $_GET['categorylist'];
            if ($categorylist && is_array($categorylist)){
                foreach ($categorylist as $pageid=>$category){
                    if ($category['title']){
                        if ($pageid > 0){
                            Pages::getInstance()->where(array('pageid'=>$pageid))->data($category)->save();
                        }else {
                            $category['type'] = 'category';
                            Pages::getInstance()->data($category)->add();
                        }
                    }
                }
            }
            $this->showSuccess('save_succeed');
        }else {

            $categorylist = Pages::getInstance()->where(array('type'=>'category'))->select();
            include view('pages/category');
        }
    }
}
