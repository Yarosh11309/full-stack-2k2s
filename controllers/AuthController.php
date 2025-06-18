<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Application;
use app\mappers\AuthMapper;
use app\models\AuthUser;

class AuthController
{
    private AuthMapper $mapper;

    public function __construct()
    {
        $this->mapper = new AuthMapper();
    }

    public function registerView(): void
    {
        Application::$app->getRouter()->renderTemplate('auth/register');
    }

    public function register(): void
    {
        $body = Application::$app->getRequest()->getBody();
        $login = $body['login'] ?? '';
        $password = $body['password'] ?? '';
        if ($login === '' || $password === '') {
            Application::$app->getRouter()->renderTemplate('auth/register', ['error' => 'Fill all fields']);
            return;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user = new AuthUser(null, $login, $hash);
        $this->mapper->Insert($user);
        Application::$app->login($user);
        header('Location: /notes');
    }

    public function loginView(): void
    {
        Application::$app->getRouter()->renderTemplate('auth/login');
    }

    public function login(): void
    {
        $body = Application::$app->getRequest()->getBody();
        $login = $body['login'] ?? '';
        $password = $body['password'] ?? '';
        $user = $this->mapper->getByLogin($login);
        if (!$user || !password_verify($password, $user->getPassword())) {
            Application::$app->getRouter()->renderTemplate('auth/login', ['error' => 'Invalid credentials']);
            return;
        }
        Application::$app->login($user);
        header('Location: /notes');
    }

    public function logout(): void
    {
        Application::$app->logout();
        header('Location: /login');
    }
}
