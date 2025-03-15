<?php

namespace App\Modules\Auth\Presentation\FRONT\LogoutAction;

use App\Shared\Auth\Domain\Service\SessionManagerInterface;

class LogoutAction
{

    public function __construct(
        private readonly SessionManagerInterface $sessionManager
    ) {
    }

    public function __invoke(): void
    {
        $this->sessionManager->destroy();
        header('Location: /login');
        exit;
    }
}   