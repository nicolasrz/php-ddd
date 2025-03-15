<?php

namespace App\Shared\Presentation;

trait ActionTrait
{
    public function isGetRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPostRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function throwNotFoundException(): void
    {
        header('HTTP/1.0 404 Not Found');
        echo '404 - Page non trouvée';
        exit;
    }

    public function throwForbiddenException(): void
    {
        header('HTTP/1.0 403 Forbidden');
        echo '403 - Accès refusé';
        exit;
    }
}