<?php

namespace App\Core\Routing;

use App\Core\DependencyInjection\ContainerInterface;

class Router
{
    private const ROUTES = [
        '/login' => 'App\Modules\Auth\Presentation\FRONT\LoginAction\LoginAction',
        '/logout' => 'App\Modules\Auth\Presentation\FRONT\LogoutAction\LogoutAction',
        '/register' => 'App\Modules\Auth\Presentation\FRONT\RegisterAction\RegisterAction',
        '/missions' => 'App\Modules\Mission\Presentation\FRONT\MissionAction\ListMissionAction'
    ];

    public function __construct(
        private readonly ContainerInterface $container
    ) {
    }

    public function dispatch(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (array_key_exists($requestUri, self::ROUTES)) {
            $className = self::ROUTES[$requestUri];
            $classPath = str_replace('\\', '/', $className) . '.php';

            if (class_exists($className)) {

                if ($this->container->has($className)) {
                    $action = $this->container->get($className);
                } else {
                    $action = new $className();
                }

                if (is_callable($action)) {
                    $action();
                    exit;
                }
            }
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo "404 - Page not found";
        exit;
    }
}