<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/28
 * Time: 上午9:26
 */

namespace App\Controllers\Material;


use Core\Controller;

class BaseController extends Controller
{
    /**
     * BaseController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->islogin) {
            exit();
        }
    }
}
