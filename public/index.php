<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/13 0013
 * Time: 9:06
 */
define('_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('_SYS_PATH', _ROOT.'..'.DIRECTORY_SEPARATOR.'Sakura'.DIRECTORY_SEPARATOR);
define('_APP', _ROOT.'..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR);

$_config = require_once  _SYS_PATH.'config.php';
require_once  _SYS_PATH.'bootstrap.php';

$app = new Sakura();
$app->run();
