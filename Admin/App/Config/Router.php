<?php

use Windward\Core\Router;
use Windward\Core\Http;

$router = new Router($container);
$router->setNotfoundHandler(array('base', 'error404'));

$router->addRoute(Http::METHOD_ANY, '/admin/list?:sh', ['index', 'index']);
$router->addRoute(Http::METHOD_ANY, '/admin/upload/user/:id', ['index', 'input']);
$router->addRoute(Http::METHOD_ANY, '/admin/upload/user', ['index', 'input']);
$router->addRoute(Http::METHOD_ANY, '/admin/upload/images/:id', ['image', 'index']);
$router->addRoute(Http::METHOD_ANY, '/admin/upload/imageson/:id', ['image', 'add']);

return $router;
