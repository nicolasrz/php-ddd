<?php

namespace App\Modules\Auth\Application\UseCase;

use App\Modules\Auth\Application\Service\AuthenticationService;
use App\Shared\Auth\Domain\Repository\AuthUserRepositoryInterface;

class ConnecteUtilisateurUseCase
{

    public function __construct(
        private readonly AuthUserRepositoryInterface $userRepository,
        private readonly AuthenticationService       $authenticationService,
    ){}

    public function handle(string $username, string $password): void
    {
        $user = $this->userRepository->findByUsername($username);

        if (null === $user) {
            throw new \Exception('Utilisateur non trouvé');
        }

        $this->authenticationService->login($user, $password);

    }
}