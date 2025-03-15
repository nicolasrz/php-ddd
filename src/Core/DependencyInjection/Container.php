<?php

namespace App\Core\DependencyInjection;

use App\Modules\Auth\Application\Service\AuthenticationService;
use App\Modules\Auth\Application\UseCase\ConnecteUtilisateurUseCase;
use App\Modules\Auth\Application\UseCase\EnregisterUnUseUseCase;
use App\Modules\Auth\Domain\Service\CheckPasswordInterface;
use App\Modules\Auth\Infrastructure\Service\BcryptPasswordHashing;
use App\Modules\Auth\Presentation\FRONT\LoginAction\LoginAction;
use App\Modules\Auth\Presentation\FRONT\RegisterAction\RegisterAction;
use App\Modules\Mission\Application\UseCase\ListMissionUseCase;
use App\Modules\Mission\Domain\Repository\MissionRepositoryInterface;
use App\Modules\Mission\Infrastructure\Repository\InMemoryMissionRepository;
use App\Modules\Mission\Presentation\FRONT\MissionAction\ListMissionAction;
use App\Shared\Auth\Domain\Repository\AuthUserRepositoryInterface;
use App\Shared\Auth\Domain\Service\SessionManagerInterface;
use App\Shared\Auth\Infrastructure\Repository\InFileMemoryAuthUserRepository;
use App\Shared\Auth\Infrastructure\Service\PhpSessionManager;
use App\Modules\Mission\Infrastructure\Policy\MissionPolicy;
use App\Core\Security\SecurityMiddleware;
use App\Modules\Auth\Presentation\FRONT\LogoutAction\LogoutAction;

class Container implements ContainerInterface
{
    private array $instances = [];
    private array $factories = [];

    public function __construct()
    {
        $this->registerServices();
    }

    public function get(string $id): object
    {
        if ($this->has($id)) {
            return $this->instances[$id] ??= ($this->factories[$id])($this);
        }

        throw new \RuntimeException(sprintf('Service "%s" not found in container', $id));
    }

    public function has(string $id): bool
    {
        return isset($this->factories[$id]);
    }

    private function registerServices(): void
    {
        // Enregistrement des services d'infrastructure
        $this->factories[CheckPasswordInterface::class] = fn() => new BcryptPasswordHashing();
        $this->factories[SessionManagerInterface::class] = fn() => new PhpSessionManager();
        $this->factories[AuthUserRepositoryInterface::class] = fn() => new InFileMemoryAuthUserRepository();
        $this->factories[MissionRepositoryInterface::class] = fn() => new InMemoryMissionRepository();

        // Securité
        $this->factories[SecurityMiddleware::class] = function (Container $container) {
            return new SecurityMiddleware(
                $container->get(SessionManagerInterface::class)
            );
        };
        
        // Policies 
        $this->factories[MissionPolicy::class] = function (Container $container) {
            return new MissionPolicy();
        };      

        // Enregistrement des services applicatifs
        $this->factories[AuthenticationService::class] = function (Container $container) {
            return new AuthenticationService(
                $container->get(CheckPasswordInterface::class),
                $container->get(SessionManagerInterface::class)
            );
        };

        // Enregistrement des UseCases
        $this->factories[ConnecteUtilisateurUseCase::class] = function (Container $container) {
            return new ConnecteUtilisateurUseCase(
                $container->get(AuthUserRepositoryInterface::class),
                $container->get(AuthenticationService::class)
            );
        };
        $this->factories[EnregisterUnUseUseCase::class] = function (Container $container) {
            return new EnregisterUnUseUseCase(
                $container->get(AuthenticationService::class),
                $container->get(AuthUserRepositoryInterface::class),
            );
        };

        $this->factories[ListMissionUseCase::class] = function (Container $container) {
            return new ListMissionUseCase(
                $container->get(MissionRepositoryInterface::class)
            );
        };

        // Enregistrement des actions
        $this->factories[LoginAction::class] = function (Container $container) {
            return new LoginAction(
                $container->get(ConnecteUtilisateurUseCase::class)
            );
        };
        $this->factories[LogoutAction::class] = function (Container $container) {
            return new LogoutAction(
                $container->get(SessionManagerInterface::class)
            );
        };
        $this->factories[RegisterAction::class] = function (Container $container) {
            return new RegisterAction(
                $container->get(EnregisterUnUseUseCase::class)
            );
        };

        $this->factories[ListMissionAction::class] = function (Container $container) {
            return new ListMissionAction(
                $container->get(SessionManagerInterface::class),
                $container->get(ListMissionUseCase::class),
                $container->get(MissionPolicy::class)   
            );
        };
    }
}