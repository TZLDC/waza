<?php

use Windward\Core\Container;
use Windward\Core\Language;
use Windward\Core\Logger;
use Windward\Extend\Loader;
use Windward\Extend\Database;
use Windward\Mvc\View;
use Base\Lib\Csv;

Language::setBaseDir(ROOT . '/Lang/');

$container = new Container();

$container->set('loader', function () use ($container) {
    $loader = new Loader();
    
    $container->setControllerNamespace('App\\Controllers');
    $loader->addNamespace('App\\Controllers', APP . '/Controllers/');

    $container->setModelNamespace('App\\Models');
    $loader->addNamespace('App\\Models', APP . '/Models/');
    
    $loader->addNamespace('App\\Extend', APP . '/Extend/');
    
    $loader->addNamespace('App\\Config', APP . '/Config/');
    
    $loader->addNamespace('Base', ROOT . '/../Base/');
    
    $loader->register();
});

class_alias('\App\Config\\' . ucfirst(APP_ENV) . '\Db', "DbConfig");
class_alias('\App\Config\\' . ucfirst(APP_ENV) . '\Redis', "RedisConfig");
class_alias('\App\Config\\' . ucfirst(APP_ENV) . '\Code', "CodeConfig");
class_alias('\App\Config\\' . ucfirst(APP_ENV) . '\ConstEnv', "ConstConfig");

$container->set('router', function () use ($container) {
    return require ROOT . '/App/Config/Router.php';
});

$container->set('view', function () use ($container) {
    $view = new View(APP . '/Views', ROOT . '/Cache/smarty');
    $view->setContainer($container);
    return $view;
});

$container->set('masterConnection', function () {
    $config = \DbConfig::master;
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=UTF8";
    $pdo = new \PDO($dsn, $config['username'], $config['password'], $config['option']);
    return $pdo;
});

$container->set('slaveConnection', function () {
    $config = \DbConfig::slave ? \DbConfig::slave : [];
    if (!$config || !is_array($config)) {
        return null;
    }
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=UTF8";
    $pdo = new \PDO($dsn, $config['username'], $config['password'], $config['option']);
    return $pdo;
});

// $container->set('redis', function () {
//     $redis = new Redis();
//     try {
//         $redis->connect(\RedisConfig::host, \RedisConfig::port);
//         if (\RedisConfig::password) {
//             $redis->auth(\RedisConfig::password);
//         }
//         if (\RedisConfig::prefix) {
//             $redis->setOption(Redis::OPT_PREFIX, \RedisConfig::prefix);
//         }
        
//         register_shutdown_function(function () use ($redis) {
//             $redis && $redis->close();
//         });
//         return $redis;
//     } catch (Exception $e) {
//         return null;
//     }
//     return $redis;
// });

$container->set('logger', function () use ($container) {
    return new Logger($container, ROOT . '/Log');
});

$container->set('language', function () {
    $lang = new Language();
    return $lang;
});

$container->set('codeConfig', function () use ($container) {
    $codeConfig = new \CodeConfig();
    $container->view->assign('codeConfig', $codeConfig);
    return $codeConfig;
});
