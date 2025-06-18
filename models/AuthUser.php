<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class AuthUser extends Model
{
    private string $login;
    private string $password;
    private string $first_name;
    private string $second_name;

    public function __construct(
        ?int $id,
        string $login,
        string $password,
        string $first_name,
        string $second_name
    ) {
        parent::__construct($id);
        $this->login = $login;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
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

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function getSecondName(): string
    {
        return $this->second_name;
    }

    public function setSecondName(string $second_name): void
    {
        $this->second_name = $second_name;
    }
}
