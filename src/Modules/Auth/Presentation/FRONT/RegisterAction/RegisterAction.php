<?php

namespace App\Modules\Auth\Presentation\FRONT\RegisterAction;

use App\Modules\Auth\Application\UseCase\EnregisterUnUseUseCase;
use App\Shared\Presentation\ActionTrait;

class RegisterAction
{
    use ActionTrait;

    public function __construct(
        private readonly EnregisterUnUseUseCase $enregisterUnUseUseCase
    ){}

    public function __invoke()
    {
        if ($this->isGetRequest()) {
            $this->showForm();
            return;
        }

        if($this->isPostRequest()) {
            $this->handlePost();
        }
        $this->throwNotFoundException();
    }

    private function showForm(array $errors = []): void
    {
        include __DIR__ . '/show-register-form.html';
    }

    private function handlePost() : void
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        if(empty($username) || empty($password)) {
            $this->showForm(['error' => 'Veuillez remplir tous les champs']);
            return;
        }

        try {
            $this->enregisterUnUseUseCase->handle($username, $password);
        } catch (\Exception $e) {
            $this->showForm(['error' => $e->getMessage()]);
            return;
        }

        header("Location: /login");
        exit;
    }
}