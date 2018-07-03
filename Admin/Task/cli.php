<?php
if ($argc <= 1) {
    exit("用法：APP_ENV={env} php Cli.php [uri]\n");
}

error_reporting(7);
//ini_set("display_errors","On");
date_default_timezone_set('PRC');

define('ROOT', realpath(__DIR__ . '/..'));
define('APP', ROOT . '/App');
define('APP_ENV', isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'local');

include ROOT . '/App/Config/Const.php';
include ROOT . '/../vendor/autoload.php';
include ROOT . '/App/Bootstrap.php';

$container->set('router', function () use ($container) {
    return new Windward\Cli\Router($container);
});

use Windward\Core\Application;

$app = new Application($container);
$app->handle($argv[1]);
