<?php
define('DEBUG', true);
define('ROOT_PATH',dirname(__FILE__).'/');
require ROOT_PATH.'library/Application.php';
$application = new Application();
$application->start();
