<?php

declare(strict_types=1);

namespace app\mappers;

use app\core\Mapper;
use app\core\Model;
use app\models\Note;

class NoteMapper extends Mapper
{
    private int $userId = 0;
    private ?\PDOStatement $insert;
    private ?\PDOStatement $update;
    private ?\PDOStatement $delete;
    private ?\PDOStatement $select;
    private ?\PDOStatement $selectAll;

    public function __construct()
    {
        parent::__construct();

        $this->insert = $this->getPdo()->prepare(
            "INSERT INTO notes (title, description, color, tags, user_id) VALUES (:title, :description, :color, :tags, :user_id)"
        );

        $this->update = $this->getPdo()->prepare(
            "UPDATE notes SET title = :title, description = :description, color = :color, tags = :tags, updated_at = current_timestamp WHERE id = :id AND user_id = :user_id"
        );

        $this->delete = $this->getPdo()->prepare("DELETE FROM notes WHERE id = :id AND user_id = :user_id");

        $this->select = $this->getPdo()->prepare("SELECT * FROM notes WHERE id = :id AND user_id = :user_id");
        $this->selectAll = $this->getPdo()->prepare("SELECT * FROM notes WHERE user_id = :user_id ORDER BY created_at DESC");
    }

    protected function doInsert(Model $model): Model
    {
        /** @var Note $model */
        $this->insert->execute([
            ':title' => $model->getTitle(),
            ':description' => $model->getDescription(),
            ':color' => $model->getColor(),
            ':tags' => $model->getTags(),
            ':user_id' => $model->getUserId(),
        ]);
        $model->setId((int)$this->getPdo()->lastInsertId());
        return $model;
    }

    protected function doUpdate(Model $model)
    {
        /** @var Note $model */
        $this->update->execute([
            ':id' => $model->getId(),
            ':title' => $model->getTitle(),
            ':description' => $model->getDescription(),
            ':color' => $model->getColor(),
            ':tags' => $model->getTags(),
            ':user_id' => $model->getUserId(),
        ]);
    }

    protected function doDelete(Model $model)
    {
        $this->delete->execute([':id' => $model->getId(), ':user_id' => $model->getUserId()]);
    }

    public function doSelect(int $id): array
    {
        $this->select->execute([':id' => $id, ':user_id' => $this->userId]);
        return $this->select->fetch(\PDO::FETCH_ASSOC) ?: [];
    }

    protected function doSelectAll(): array
    {
        $this->selectAll->execute([':user_id' => $this->userId]);
        return $this->selectAll->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInstance(): Mapper
    {
        return $this;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function createObject(array $data): Model
    {
        return new Note(
            id: $data['id'] ?? null,
            user_id: $data['user_id'] ?? 0,
            title: $data['title'] ?? '',
            description: $data['description'] ?? '',
            color: $data['color'] ?? '',
            tags: $data['tags'] ?? '',
            created_at: $data['created_at'] ?? '',
            updated_at: $data['updated_at'] ?? ''
        );
    }

    public function filter(int $userId, ?string $query = null, ?string $tag = null, ?string $color = null): array
    {
        $sql = 'SELECT * FROM notes WHERE user_id = :user_id';
        $params = [':user_id' => $userId];
        if ($query) {
            $sql .= ' AND (title ILIKE :query OR description ILIKE :query)';
            $params[':query'] = '%' . $query . '%';
        }
        if ($tag) {
            $sql .= ' AND tags ILIKE :tag';
            $params[':tag'] = '%' . $tag . '%';
        }
        if ($color) {
            $sql .= ' AND color = :color';
            $params[':color'] = $color;
        }
        $sql .= ' ORDER BY created_at DESC';
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
