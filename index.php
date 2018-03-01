<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);
define('DEBUG', true);
define('REWRITE_MOD', true);
define('ROOT_PATH',dirname(__FILE__).'/');
require ROOT_PATH.'library/Application.php';
$application = new Application();
$application->start();
