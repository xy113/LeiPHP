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
 * Time: 下午4:40
 */

namespace App\Controllers\Admin;


use App\Models\Ad;

class AdController extends BaseController
{

    public function index(){
        $this->itemlist();
    }

    /**
     * 广告列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $ads = $_GET['ads'];
            $eventType = trim($_GET['eventType']);
            if ($ads) {
                if ($eventType === 'delete'){
                    foreach ($ads as $id){
                        Ad::getInstance()->where(array('id'=>$id))->delete();
                    }
                }

                if ($eventType === 'enable'){
                    foreach ($ads as $id){
                        Ad::getInstance()->where(array('id'=>$id))->data(array('available'=>1))->save();
                    }
                }

                if ($eventType === 'disable'){
                    foreach ($ads as $id){
                        Ad::getInstance()->where(array('id'=>$id))->data(array('available'=>0))->save();
                    }
                }
                $this->showAjaxReturn();
            }
            if (!empty($ids) && is_array($ids)){
                $ids = implodeids($ids);
                switch ($_GET['option']) {
                    case 'enable':
                        Ad::getInstance()->where("id IN($ids)")->data(array('status'=>0))->save();
                        break;
                    case 'disable':
                        Ad::getInstance()->where("id IN($ids)")->data(array('status'=>-1))->save();
                        break;
                    case 'unaudit':
                        Ad::getInstance()->where("id IN($ids)")->data(array('status'=>-11))->save();
                        break;
                    default:Ad::getInstance()->where("id IN($ids)")->delete();
                }
                $this->showSuccess('update_succeed');
            }else {
                $this->showError('no_select');
            }
        }else {

            $totalnum  = Ad::getInstance()->count();
            $pagecount = $totalnum < $pagesize ? 1 : ceil($totalnum/$pagesize);
            $adlist = Ad::getInstance()->page(G('page'), 20)->select();
            $pagination = $this->mutipage(G('page'), 20, $totalnum, null, true);

            include view('common/ad_list');
        }
    }

    /**
     * 添加广告
     */
    public function add(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $adnew  = $_GET['adnew'];
            $addata = $_GET['addata'];
            if ($adnew['title']) {
                $adnew['data'] = serialize($addata[$adnew['type']]);
                (new AdModel())->data($adnew)->save();
                $this->showSuccess('save_succeed');
            }else {
                $this->showError('undefined_action');
            }
        }else {

            include template('common/ad_form');
        }
    }

    /**
     * 编辑广告
     */
    public function edit(){
        global $_G,$_lang;
        $id = intval($_GET['id']);

        $model = new AdModel();
        if ($this->checkFormSubmit()){
            $adnew  = $_GET['adnew'];
            $addata = $_GET['addata'];
            if ($adnew['title']) {
                $adnew['data'] = serialize($addata[$adnew['type']]);
                $model->where(array('id'=>$id))->data($adnew)->save();
                $this->showSuccess('update_succeed');
            }else {
                $this->showError('undefined_action');
            }
        }else {

            $ad = $model->where(array('id'=>$id))->getOne();
            $addata[$ad['type']] = unserialize($ad['data']);
            include template('common/ad_form');
        }
    }
}
