<?php

namespace App\Modules\Auth\Presentation\FRONT\LoginAction;

use App\Modules\Auth\Application\UseCase\ConnecteUtilisateurUseCase;
use App\Shared\Presentation\ActionTrait;

class LoginAction
{
    use ActionTrait;

    public function __construct(
        private readonly ConnecteUtilisateurUseCase $connecteUtilisateurUseCase,
    ){}

    public function __invoke()
    {
        if ($this->isGetRequest()) {
            $this->showForm();
            return;
        }

        if($this->isPostRequest()) {
            $this->handlePost();
            return;
        }

        $this->throwNotFoundException();
    }

    private function showForm(array $errors = []): void
    {
        include __DIR__ . '/show-login-form.html';
    }

    private function handlePost(): void
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        if(empty($username) || empty($password)) {
            $this->showForm(['error' => 'Veuillez remplir tous les champs']);
            return;
        }
        try {
            $this->connecteUtilisateurUseCase->handle($username, $password);
        } catch (\Exception $e) {
            $this->showForm(['error' => $e->getMessage()]);
            return;
        }

        header("Location: /missions");
        exit;
    }
}
