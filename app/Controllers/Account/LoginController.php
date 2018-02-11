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
 * Time: 上午10:05
 */

namespace App\Controllers\Account;


use Core\Controller;

class LoginController extends Controller
{
    /**
     * LoginController constructor.
     */
    function __construct()
    {
        parent::__construct();
        if ($this->islogin) $this->redirect(U('m=member'));
    }

    /**
     *
     */
    public function index(){
        global $_G, $_lang;

        $redirect = htmlspecialchars($_GET['redirect']);
        include view('login');
    }

    /**
     * 验证登录
     */
    public function chklogin(){
        $account  = htmlspecialchars(trim($_GET['account_'.FORMHASH]));
        $password = trim($_GET['password_'.FORMHASH]);
        $captchacode = trim($_GET['captchacode']);
        $this->checkCaptchacode($captchacode, G('inajax'));

        if ($_GET['formhash'] !== formhash()){
            $this->showAjaxError('FAIL', L('undefined_action'));
        }

        $model = new MemberModel();
        $member = $model->where("`username`='$account' OR `mobile`='$account' OR `email`='$account'")->getOne();
        if ($member) {
            if ($member['password'] == getPassword($password)){
                cookie('uid', $member['uid']);
                cookie('username', $member['username']);
                (new MemberStatusModel())->where(array('uid'=>$member['uid']))
                    ->data(array('lastvisit'=>time(), 'lastvisitip'=>getIp()))->save();
                $this->showAjaxReturn();
            }else {
                $this->showAjaxError('1003', 'password_incorrect');
            }
        }else {
            $this->showAjaxError(1, 'account_invalid');
        }
    }

    /**
     * AJAX login
     */
    public function ajaxlogin(){
        global $_G,$_lang;

        include template('ajaxlogin');
    }

    /**
     *
     */
    public function qrcode(){
        $login_code = cookie('login_code');
        if (!$login_code) {
            $login_code = md5(time().random(10));
            M('scan_login')->insert(array(
                'uid'=>0,
                'login_code'=>$login_code,
                'scaned'=>0,
                'create_time'=>time()
            ));
            cookie('login_code', $login_code);
        }
        $url = "cgapp://scanLogin?login_code=".$login_code;
        include LIB_PATH.'Vendor/phpqrcode.php';
        \QRcode::png($url, false, QR_ECLEVEL_H, 10);
    }

    /**
     *
     */
    public function scan_query(){
        $login_code = cookie('login_code');
        $check = M('scan_login')->where(array('login_code'=>$login_code, 'scaned'=>1))->getOne();
        if ($check) {
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }

    /**
     *
     */
    public function confirm_login(){
        $login_code = cookie('login_code');
        $check = M('scan_login')->where(array('login_code'=>$login_code, 'scaned'=>1))->getOne();
        if ($check) {
            $member = (new MemberModel())->where(array('uid'=>$check['uid']))->getOne();
            cookie('login_code', null);
            cookie('uid', $member['uid']);
            cookie('username', $member['username']);
            (new MemberStatusModel())->where(array('uid'=>$check['uid']))->data(array('lastvisit'=>TIMESTAMP, 'lastvisitip'=>getIp()))->save();
            M('scan_login')->where(array('login_code'=>$login_code))->delete();
            $this->showAjaxReturn();
        }else {
            $this->showAjaxError(1, 'not scaned');
        }
    }
}
