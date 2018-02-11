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
 * Time: 上午9:23
 */

namespace App\Controllers\Admin;


use App\Models\Block;
use App\Models\BlockItem;

class BlockController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->namelist();
    }

    /**
     * 板块列表
     */
    public function namelist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $blocks = $_GET['blocks'];
            if ($blocks) {
                foreach ($blocks as $block_id){
                    Block::getInstance()->where(array('block_id'=>$block_id))->delete();
                    BlockItem::getInstance()->where(array('block_id'=>$block_id))->delete();
                }
            }
            $this->showAjaxReturn();
        }else {
            $pagesize  = 20;
            $totalnum  = Block::getInstance()->count();
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $blocklist = Block::getInstance()->page($_G['page'], $pagesize)->order('block_id')->select();
            $pagination = $this->pagination($_G['page'], $pagecount, $totalnum, null, true);

            $_G['title'] = $_lang['block_manage'];
            include view('block/blocks');
        }
    }

    /**
     * 保存块内容
     */
    public function save_block(){
        if ($this->checkFormSubmit()) {
            $block = $_GET['block'];
            $block_id = intval($_GET['block_id']);
            if ($block_id) {
                Block::getInstance()->where(array('block_id'=>$block_id))->data($block)->save();
            }else {
                Block::getInstance()->data($block)->add();
            }
            $this->showAjaxReturn();
        }
    }

    /**
     * 获取板块信息
     */
    public function get_block(){
        $block_id = intval($_GET['block_id']);
        $block = Block::getInstance()->where(array('block_id'=>$block_id))->getOne();
        $this->showAjaxReturn($block);
    }

    /**
     * 内容管理
     */
    public function itemlist(){
        global $_G,$_lang;

        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $eventType = trim($_GET['eventType']);
            if ($eventType === 'delete'){
                $delete = $_GET['delete'];
                if ($delete && is_array($delete)) {
                    foreach ($delete as $id){
                        BlockItem::getInstance()->where(array('id'=>$id))->delete();
                    }
                }
            }

            if ($eventType === 'update'){
                $itemlist = $_GET['itemlist'];
                if ($itemlist && is_array($itemlist)){
                    $displayorder = 0;
                    foreach ($itemlist as $id=>$item){
                        if ($item['title'] && $item['url']){
                            $displayorder++;
                            $item['displayorder'] = $displayorder;
                            BlockItem::getInstance()->where(array('id'=>$id))->data($item)->save();
                        }
                    }
                }
            }

            Block::getInstance()->setCache($block_id);
            $this->showAjaxReturn();
        }else {

            $itemlist = BlockItem::getInstance()->where(array('block_id'=>$block_id))->order('displayorder ASC,id ASC')->select();
            $_G['title'] = $_lang['block_item_manage'];
            include view('block/items');
        }
    }

    /**
     * 添加内容项
     */
    public function add_item(){
        global $_G,$_lang;

        $block_id = intval($_GET['block_id']);
        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['title'] && $item['url']){
                $item['block_id'] = $block_id;
                BlockItem::getInstance()->data($item)->add();
                Block::getInstance()->setCache($block_id);
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'continue_add', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>URL('/admin/block/itemlist','block_id='.$block_id))
                ));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $_G['title'] = $_lang['block_item_manage'];
            include view('block/add_item');
        }
    }

    /**
     * 修改内容
     */
    public function edit_item(){
        global $_G,$_lang;

        $id = intval($_GET['id']);
        $block_id = intval($_GET['block_id']);

        if ($this->checkFormSubmit()) {
            $item = $_GET['item'];
            if ($item['title'] && $item['url']){
                BlockItem::getInstance()->where(array('id'=>$id))->data($item)->save();
                Block::getInstance()->setCache($block_id);
                $this->showSuccess('save_succeed', null, array(
                    array('text'=>'reedit', 'url'=>curPageURL()),
                    array('text'=>'back_list', 'url'=>URL('/admin/block/itemlist','block_id='.$block_id))
                ));
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $item = BlockItem::getInstance()->where(array('id'=>$id))->getOne();
            $_G['title'] = $_lang['block_item_manage'];
            include view('block/add_item');
        }
    }

    /**
     * 修改图片
     */
    public function set_item_image(){
        $id = intval($_GET['id']);
        $image = trim($_GET['image']);
        $block_id = intval($_GET['block_id']);
        BlockItem::getInstance()->where(array('id'=>$id))->data(array('image'=>$image))->save();
        Block::getInstance()->setCache($block_id);
        $this->showAjaxReturn();
    }
}
