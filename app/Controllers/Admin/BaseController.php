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
 * Time: 上午9:45
 */

namespace App\Controllers\Admin;


use Core\Controller;

class BaseController extends Controller
{
    protected $adminid = 0;
    /**
     * BaseController constructor.
     */
    function __construct(){
        parent::__construct();
        define('IN_ADMIN', true);
        $this->adminid = intval(cookie('adminid'));

        if (!$this->adminid || !$this->uid || !$this->username){
            if (G('c') === 'login' && G('m') === 'admin'){
                //
            }else {
                $this->showAdminLogin();
            }
        }else {
            if ($this->adminid != $this->uid) {
                cookie('adminid', null);
                $this->showAdminLogin();
            }else {
                cookie('adminid', $this->uid, 7200);
            }
        }
    }

    /**
     * 显示管理员登录
     */
    protected function showAdminLogin($redirect=null){
        global $_G, $_lang;
        include view('login');
        exit();
    }
}
