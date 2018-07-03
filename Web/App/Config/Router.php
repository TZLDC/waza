<?php

use Windward\Core\Router;
use Windward\Core\Http;

$router = new Router($container);
$router->addRoute(Http::METHOD_GET, '/demo/custom/uri', array('Demo', 'customuri'), 'merchant_customuri');
$router->addRoute(Http::METHOD_ANY, '/360/u/check_code', array('Show', 'code'));
$router->addRoute(Http::METHOD_ANY, '/360/u/check_code/:lang', array('Show', 'code'));
$router->addRoute(Http::METHOD_GET, '/360/u/:lang/:code', array('Show', 'around'));
$router->addRoute(Http::METHOD_GET, '/360/u/:lang/:code/movie', array('Show', 'video'));
$router->addRoute(Http::METHOD_GET, '/360/u/:lang/:code/images', array('Show', 'photo'));
$router->addRoute(Http::METHOD_GET, '/360/u/:lang/:code/images/:id', array('Show', 'photo'));
$router->setNotfoundHandler(array('base', 'error404'));
return $router;
