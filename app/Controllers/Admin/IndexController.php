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
 * Time: 上午9:56
 */

namespace App\Controllers\Admin;


class IndexController extends BaseController
{
    public function index(){
        global $_G, $_lang;

        $_G['title'] = $_lang['home'];
        include view('admin');
    }

    /**
     *
     */
    public function wellcome(){
        global $G,$_lang;

        include view('wellcome');
    }
}
