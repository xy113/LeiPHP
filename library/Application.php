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
 * Time: 下午4:40
 */

define('version', '1.0');
define('IN_LEIPHP', true);
defined('ROOT_PATH')      or define('ROOT_PATH',   dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('LIB_PATH')       or define('LIB_PATH',    __DIR__.'/');
defined('APP_PATH')       or define('APP_PATH',    ROOT_PATH.'app/');
defined('CERT_PATH')      or define('CERT_PATH',   ROOT_PATH.'cert/');
defined('CONFIG_PATH')    or define('CONFIG_PATH', ROOT_PATH.'config/');
defined('LANG_PATH')      or define('LANG_PATH',   ROOT_PATH.'lang/');
defined('DATA_PATH')      or define('DATA_PATH',   ROOT_PATH.'data/');
defined('RUNTIME_DIR')    or define('RUNTIME_DIR', ROOT_PATH.'runtime/');
defined('CACHE_PATH')     or define('CACHE_PATH',  RUNTIME_DIR.'cache/');
defined('TPL_PATH')       or define('TPL_PATH',    ROOT_PATH.'templates/');
defined('DEFAULT_MODEL')  or define('DEFAULT_MODEL', 'home');
defined('DEFAULT_LANG')   or define('DEFAULT_LANG', 'zh_cn');
defined('THEME')  or define('THEME', 'default');
defined('REWRITE_MOD') or define('REWRITE_MOD', true);

class Application{
	private $var = array();

    /**
     * Application constructor.
     */
    function __construct(){
        //自动加载类
		spl_autoload_register(function ($class){
            if (false !== strpos($class, '\\')){
                $classname  = substr($class, strrpos($class, '\\')+1);
                $namespace  = substr($class, 0, strrpos($class, '\\')+1);
                $namespace  = str_replace('\\','/',$namespace);

                $classfile = LIB_PATH.$namespace.$classname.'.php';
                if (is_file($classfile)){
                    require $classfile;
                }else{
                    $classfile = APP_PATH.str_replace('App/', '', $namespace).$classname.'.php';
                    if (is_file($classfile)) require $classfile;
                }
            }else {
                if (is_file(LIB_PATH.'Core/'.$class.'.php')){
                    require LIB_PATH.'Core/'.$class.'.php';
                }
            }
        }, true);
		//设置调试模式
		if (defined('DEBUG') && DEBUG) {
            ini_set('display_errors', 'on');
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
        }else {
            ini_set('display_errors', 'off');
            error_reporting(0);
        }

		$this->timezone_set(8);
		if(version_compare(PHP_VERSION,'5.4.0','<')) {
			@ini_set('magic_quotes_runtime',0);
			define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc() ? true : false);
		}else{
			define('MAGIC_QUOTES_GPC',false);
		}

		include LIB_PATH.'functions/common.php';
		if(!MAGIC_QUOTES_GPC) {
			$_GET = daddslashes($_GET);
			$_POST = daddslashes($_POST);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
			$_GET = array_merge($_GET, $_POST);
		}

		//加载配置文件
		global $_config;
        $_config = include(CONFIG_PATH.'app.php');
		if (is_array(C('AUTO_LOAD_CONFIG'))) {
            foreach (C('AUTO_LOAD_CONFIG') as $name){
                $confile = CONFIG_PATH.$name.'.php';
                if (is_file($confile)) {
                    $_config = array_merge($_config, include($confile));
                }
            }
            unset($confile,$name);
		}

		//加载语言包
		global $_lang;
        $_lang = array();
		$langlist = array('common','ui','admin','member');
		if (is_array(C('AUTO_LOAD_LANGS'))){
			$langlist = array_merge($langlist, C('AUTO_LOAD_LANGS'));
		}
		if ($langlist && is_array($langlist)){
			array_unique($langlist);
			foreach ($langlist as $name){
				$langfile = LANG_PATH.DEFAULT_LANG.'/lang.'.$name.'.php';
				if (is_file($langfile)){
                    $_lang = array_merge($_lang,include($langfile));
				}
			}
		}
		unset($langlist, $langfile, $name);

		//加载function文件
		$functionlist = array();
		if (is_array(C('AUTO_LOAD_FUNCTIONS'))){
			$functionlist = array_merge($functionlist, C('AUTO_LOAD_FUNCTIONS'));
		}
		if ($functionlist) {
			array_unique($functionlist);
			foreach ($functionlist as $name){
				$funcfile = APP_PATH.'functions/'.$name.'.php';
				if (is_file($funcfile)){
					include_once $funcfile;
				}
			}
		}
		unset($functionlist, $funcfile, $name);

		define('FORMHASH', formhash());
		define('TIMESTAMP', time());
		define('DATESTAMP', date('Ymd',time()));
		@header("Content-type: text/html; charset=utf-8");
		@header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
		@header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		@header('Cache-Control: no-cache, must-revalidate');
		@header('Pragma: no-cache');
		@header('X-Frame-Options: SAMEORIGIN');

		//判断是否移动设备访问
		if(mobilecheck() || $_GET['mobile'] == 'yes'){
			define('IN_MOBILE', true);
		}else {
			define('IN_MOBILE', false);
		}

        //全局变量
        global $_G;
        $_G = array();
        $this->var = &$_G;
	}

    /**
     * 启动应用程序
     */
    public function start(){
        if (REWRITE_MOD) {
            $model = $controller = $action = '';
            $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            if ($uri === '/'){
                $model = DEFAULT_MODEL;
                $controller = 'index';
                $action = 'index';
            }else {
                $pathinfo = explode('/', trim($uri, '/'));
                if (isset($pathinfo[0])){
                    $model = $pathinfo[0];
                }else{
                    $model = DEFAULT_MODEL;
                }

                if (isset($pathinfo[1])){
                    $controller = $pathinfo[1];
                }else {
                    $controller = 'index';
                }

                if (isset($pathinfo[2])){
                    $action = $pathinfo[2];
                }else {
                    $action = 'index';
                }
            }

            $this->var['m'] = $model;
            $this->var['c'] = $controller;
            $this->var['a'] = $action;
        }else {
            $this->var['m'] = isset($_GET['m']) ? htmlspecialchars($_GET['m']) : DEFAULT_MODEL;
            $this->var['c'] = isset($_GET['c']) ? htmlspecialchars($_GET['c']) : 'index';
            $this->var['a'] = isset($_GET['a']) ? htmlspecialchars($_GET['a']) : 'index';
        }

        if(!preg_match('/^[a-zA-Z0-9_]+$/i',$this->var['m'])){
            die('Wrong parameters, m must be a charactor form a-zA-Z0-9!');
        }


        if(!preg_match('/^[a-zA-Z0-9_]+$/i',$this->var['c'])){
            die('Wrong parameters, c must be a charactor form a-zA-Z0-9!');
        }

        if(!preg_match('/^[a-zA-Z0-9_]+$/i',$this->var['a'])){
            die('Wrong parameters, a must be a charactor form a-zA-Z0-9!');
        }

		$class = 'App\\Controllers\\'.ucfirst(strtolower($model)).'\\'.ucfirst(strtolower($controller)).'Controller';
		$app = new $class();
		$app->$action();
	}

    /**
     * 设置时区
     * @param int|number $timeoffset
     */
	public function timezone_set($timeoffset = 0) {
		if(function_exists('date_default_timezone_set')) {
			@date_default_timezone_set('Etc/GMT'.($timeoffset > 0 ? '-' : '+').(abs($timeoffset)));
		}
	}
}
