<?php

include __DIR__ . "/../vendor/autoload.php";

use App\Core\DependencyInjection\Container;
use App\Core\Routing\Router;
use App\Core\Routing\Middleware;
session_start();

$container = new Container();
$router = new Router($container);

// new Middleware();
$router->dispatch();
