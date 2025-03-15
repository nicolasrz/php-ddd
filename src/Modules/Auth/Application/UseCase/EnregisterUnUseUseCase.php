<?php

namespace App\Modules\Auth\Application\UseCase;

use App\Modules\Auth\Application\Service\AuthenticationService;
use App\Shared\Auth\Domain\Repository\AuthUserRepositoryInterface;

class EnregisterUnUseUseCase
{
    public function __construct(
        private readonly AuthenticationService       $authenticationService,
        private readonly AuthUserRepositoryInterface $userRepository,
    ){}

    public function handle(string $username, string $password): void {

        $user = $this->authenticationService->createUser($username, $password);
        $this->userRepository->save($user);
    }


}