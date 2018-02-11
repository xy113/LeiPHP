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
 * Time: 上午11:42
 */

namespace App\Controllers\Admin;


use App\Models\Member;

class LoginController extends BaseController
{
    /**
     * LoginController constructor.
     */
    function __construct(){
        parent::__construct();
        if ($this->adminid && $this->uid && $this->username){
            $this->redirect(URL('/admin'));
        }
    }

    /**
     * 管理员登录
     */
    public function index(){
        if ($this->checkFormSubmit()){
            $account  = htmlspecialchars($_GET['account_'.FORMHASH]);
            $password = trim($_GET['password_'.FORMHASH]);

            $member = Member::getInstance()->where("`username`='$account' OR `mobile`='$account' OR `email`='$account'")->getOne();
            if ($member['admincp'] == 1 && $member['password'] === getPassword($password)){
                cookie('uid', $member['uid']);
                cookie('username', $member['username']);
                cookie('adminid', $member['uid'] ,7200);
                $this->showAjaxReturn(array('uid'=>$member['uid'], 'username'=>$member['username']));
            }else {
                $this->showAjaxError(1, L('password incorrect'));
            }
        }else {
            $this->showAdminLogin();
        }
    }
}
