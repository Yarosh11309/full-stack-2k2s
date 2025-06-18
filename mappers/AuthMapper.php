<?php

declare(strict_types=1);

namespace app\mappers;

use app\core\Mapper;
use app\core\Model;
use app\models\AuthUser;

class AuthMapper extends Mapper
{
    private ?\PDOStatement $insert;
    private ?\PDOStatement $select;
    private ?\PDOStatement $selectByLogin;

    public function __construct()
    {
        parent::__construct();
        $this->insert = $this->getPdo()->prepare(
            "INSERT INTO users (login, password, first_name, second_name) " .
            "VALUES (:login, :password, :first_name, :second_name)"
        );
        $this->select = $this->getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $this->selectByLogin = $this->getPdo()->prepare("SELECT * FROM users WHERE login = :login");
    }

    protected function doInsert(Model $model): Model
    {
        /** @var AuthUser $model */
        $this->insert->execute([
            ':login' => $model->getLogin(),
            ':password' => $model->getPassword(),
            ':first_name' => $model->getFirstName(),
            ':second_name' => $model->getSecondName(),
        ]);
        $model->setId((int)$this->getPdo()->lastInsertId());
        return $model;
    }

    protected function doUpdate(Model $model)
    {
        // not implemented
    }

    protected function doDelete(Model $model)
    {
        // not implemented
    }

    public function doSelect(int $id): array
    {
        $this->select->execute([':id' => $id]);
        return $this->select->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    protected function doSelectAll(): array
    {
        return [];
    }

    public function getInstance(): Mapper
    {
        return $this;
    }

    public function createObject(array $data): Model
    {
        return new AuthUser(
            id: $data['id'] ?? null,
            login: $data['login'] ?? '',
            password: $data['password'] ?? '',
            first_name: $data['first_name'] ?? '',
            second_name: $data['second_name'] ?? ''
        );
    }

    public function getByLogin(string $login): ?AuthUser
    {
        $this->selectByLogin->execute([':login' => $login]);
        $row = $this->selectByLogin->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return $this->createObject($row);
    }
}
