<?php

$yii = dirname(__FILE__).'/protected/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';

# remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
# specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

define('HOME', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

require_once($yii);
# ïîäêëş÷åíèÿ ôàéëà ñ áàçîâûì íàáîğîì ôóíêöèé
require_once(dirname(__FILE__).'/basic.php');

Yii::createWebApplication($config)->run();
