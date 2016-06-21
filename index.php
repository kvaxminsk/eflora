<?php
define('HOME', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
defined('YII_DEBUG') or define('YII_DEBUG', true);

$prevuri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);

if ($uri != $prevuri) {
	header("Location: ".$uri ,TRUE,301);
	exit();
}

$yii = HOME . '/admin/protected/framework/yii.php';
$config = HOME . '/admin/protected/config/main.php';

require_once($yii);
require_once(HOME . '/admin/config.php');
require_once(HOME . '/admin/basic.php');
require_once(HOME . '/admin/functions.php');

Yii::createWebApplication($config)->run();

