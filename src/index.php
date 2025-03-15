<?php

include __DIR__ . "/../vendor/autoload.php";

use App\Core\DependencyInjection\Container;
use App\Core\Routing\Router;
use App\Core\Routing\Middleware;
use App\Core\Security\SecurityMiddleware;
session_start();

$container = new Container();
$securityMiddleware = $container->get(SecurityMiddleware::class);
$securityMiddleware->handle();  
$router = new Router($container);

// new Middleware();
$router->dispatch();
