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
 * Time: 上午10:26
 */

namespace App\Controllers\Admin;


use App\Models\Material;

class MaterialController extends BaseController
{
    /**
     *
     */
    public function index(){
        $this->itemlist();
    }
    /**
     * 素材列表
     */
    public function itemlist(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $materials = $_GET['materials'];
            if ($materials && is_array($materials)){
                $materials = implodeids($materials);
                foreach (Material::getInstance()->where("`id` IN($materials)")->select() as $material){
                    if ($material['path']) @unlink(C('ATTACHDIR').$material['type'].'/'.$material['path']);
                    if ($material['thumb']) @unlink(C('ATTACHDIR').$material['type'].'/'.$material['thumb']);
                    //echo $material['id'].'<br>';
                    Material::getInstance()->where(array('id'=>$material['id']))->delete();
                }
            }
            $this->showAjaxReturn();
        }else {

            $condition = $queryParams = array();

            $type = $_GET['type'] ? $_GET['type'] : 'image';
            $condition[] = "m.type='$type'";
            $queryParams['type'] = $type;

            $uid = htmlspecialchars($_GET['uid']);
            if ($uid) {
                $condition[] = "m.uid='$uid'";
                $queryParams['uid'] = $uid;
            }

            $username = htmlspecialchars($_GET['username']);
            if ($username) {
                $condition[] = "mb.username='$username'";
                $queryParams['username'] = $username;
            }

            $name = htmlspecialchars($_GET['name']);
            if ($name) {
                $condition[] = "m.name LIKE '%$name%'";
                $queryParams['name'] = $name;
            }

            $time_begin = htmlspecialchars($_GET['time_begin']);
            if ($time_begin) {
                $condition[] = "m.dateline>".strtotime($time_begin);
                $queryParams['time_begin'] = $time_begin;
            }

            $time_end = htmlspecialchars($_GET['time_end']);
            if ($time_end) {
                $condition[] = "m.dateline<".strtotime($time_end);
                $queryParams['time_end'] = $time_end;
            }

            $model = Material::getInstance()->alias('m')->join('member mb', 'mb.uid=m.uid')->where($condition);
            $totalcount = $model->count();
            $itemlist = Material::getInstance()->alias('m')
                              ->join('member mb', 'mb.uid=m.uid')
                              ->where($condition)->field('m.*,mb.username')
                              ->page($_G['page'], 20)
                              ->order('m.id', 'DESC')->select();
            $pagination = $this->mutipage($_G['page'], 20, $totalcount, $queryParams, false);
            unset($condition, $queryParams);

            //载入模板
            include view('common/materials');
        }
    }
}
