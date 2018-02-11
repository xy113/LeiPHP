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
 * Time: 上午10:14
 */

namespace App\Controllers\Admin;


use App\Models\Link;

class LinkController extends BaseController
{
    /**
     *
     */
    public function index(){
        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                foreach ($delete as $id){
                    Link::getInstance()->where(array('id'=>$id))->delete();
                }
            }

            $itemlist = $_GET['itemlist'];
            if ($itemlist && is_array($itemlist)) {
                foreach ($itemlist as $id=>$item){
                    if ($item['title']) {
                        if ($id > 0){
                            Link::getInstance()->where(array('id'=>$id))->data($item)->save();
                        }else {
                            Link::getInstance()->data($item)->add();
                        }
                    }
                }
            }

            $model->updateCache();
            $this->showSuccess('update_succeed');

        }else {
            global $_G,$_lang;

            $categorylist = Link::getInstance()->where(array('type'=>'category'))->select();
            $itemlist = array();
            foreach (Link::getInstance()->where(array('type'=>'item'))->select() as $item){
                $itemlist[$item['catid']][$item['id']] = $item;
            }
            include view('common/links');
        }
    }

    /**
     *
     */
    public function setimage(){
        $id = intval($_GET['id']);
        $image = htmlspecialchars($_GET['image']);
        if ($id && $image){
            Link::getInstance()->where(array('id'=>$id))->data(array('image'=>$image))->save();
            Link::getInstance()->updateCache();
        }
        $this->showAjaxReturn(0);
    }
}
