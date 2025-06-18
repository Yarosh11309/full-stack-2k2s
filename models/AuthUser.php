<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class AuthUser extends Model
{
    private string $login;
    private string $password;

    public function __construct(?int $id, string $login, string $password)
    {
        parent::__construct($id);
        $this->login = $login;
        $this->password = $password;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
