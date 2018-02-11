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
 * Time: 上午10:01
 */

namespace App\Controllers\Admin;


class LogoutController extends BaseController
{
    /**
     *
     */
    public function index()
    {
        cookie('uid', null);
        cookie('username', null);
        cookie('adminid', null);
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
