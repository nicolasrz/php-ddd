<?php

namespace App\Core\Routing;

class Middleware
{
    private const PRIVATE_ROUTES = [
        '/missions'
    ];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $hasSession = isset($_SESSION['userId']);
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (in_array($requestUri, self::PRIVATE_ROUTES) && !$hasSession) {
            header("Location: /login");
            exit;
        }
    }
}
