<?php

namespace App\Core\Security;

use App\Shared\Auth\Domain\Service\SessionManagerInterface;

class SecurityMiddleware
{
    private array $securedRoutes = [
        '/missions' => [
            'policy' => 'App\Modules\Mission\Infrastructure\Policy\MissionPolicy',
            'action' => 'list'
        ],
        '/missions/create' => [
            'policy' => 'App\Modules\Mission\Infrastructure\Policy\MissionPolicy',
            'action' => 'create'
        ],
    ];

    public function __construct(
        private readonly SessionManagerInterface $sessionManager
    ) {
    }

    public function handle(): void
    {

        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->securedRoutes[$requestUri])) {
            return;
        }

        $user = $this->sessionManager->getUser();
        if (!$user) {
            header('Location: /login');
            exit;
        }

        $routeConfig = $this->securedRoutes[$requestUri];
        $policy = new $routeConfig['policy']();
        if (!$policy->can($user, $routeConfig['action'])) {
            http_response_code(403);
            echo "Accès refusé";
            exit;
        }
    }
}