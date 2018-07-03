<?php
error_reporting(7);
//ini_set("display_errors","On");
date_default_timezone_set('PRC');

define('WEB_PATH', __DIR__);
define('ROOT', realpath(__DIR__ . '/..'));
define('APP', ROOT . '/App');
define('APP_ENV',isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'local');


include ROOT . '/App/Config/Const.php';
include ROOT . '/../vendor/autoload.php';
include ROOT . '/App/Bootstrap.php';

use Windward\Core\Application;

$app = new Application($container);
$app->handle();

