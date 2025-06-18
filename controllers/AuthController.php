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
        $first = $body['first_name'] ?? '';
        $second = $body['second_name'] ?? '';
        if ($login === '' || $password === '' || $first === '' || $second === '') {
            Application::$app->getRouter()->renderTemplate('auth/register', ['error' => 'Fill all fields']);
            return;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user = new AuthUser(null, $login, $hash, $first, $second);
        $this->mapper->Insert($user);
        Application::$app->login($user);
        header('Location: /notes');
        exit;
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
        exit;
    }

    public function logout(): void
    {
        Application::$app->logout();
        header('Location: /login');
        exit;
    }
}
