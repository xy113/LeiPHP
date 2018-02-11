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
 * Time: 上午10:19
 */

namespace App\Controllers\Admin;


use App\Models\Express;

class ExpressController extends BaseController
{
    /**
     * 快递管理
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete && is_array($delete)){
                foreach ($delete as $id){
                    Express::getInstance()->where(array('id'=>$id))->delete();
                }
            }
            $express_list = $_GET['express_list'];
            if ($express_list && is_array($express_list)){
                foreach ($express_list as $id=>$express){
                    if ($express['name']) {
                        if ($id > 0) {
                            Express::getInstance()->where(array('id'=>$id))->data($express)->save();
                        }else {
                            Express::getInstance()->data($express)->add();
                        }
                    }
                }
            }
            $this->showSuccess('save_succeed');
        }else {
            $express_list = Express::getInstance()->select();
            include view('common/express');
        }
    }
}
