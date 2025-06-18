<?php

declare(strict_types=1);

namespace app\models;

use app\core\Model;

class Note extends Model
{
    private int $user_id;
    private string $title;
    private string $description;
    private string $color;
    private string $tags;
    private string $created_at;
    private string $updated_at;

    public function __construct(?int $id,
                                int $user_id,
                                string $title,
                                string $description,
                                string $color,
                                string $tags,
                                string $created_at = '',
                                string $updated_at = '')
    {
        parent::__construct($id);
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->color = $color;
        $this->tags = $tags;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
