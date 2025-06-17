<?php

declare(strict_types=1);

namespace app\migrations;

class Migration_3 extends \app\core\Migration
{
    public function getVersion(): int
    {
        return 3;
    }

    public function up(): void
    {
        $this->database->pdo->query("CREATE TABLE IF NOT EXISTS notes (
            id serial primary key,
            title varchar(255) not null,
            description text not null,
            color varchar(50) not null,
            tags varchar(255) not null,
            created_at timestamp not null default CURRENT_TIMESTAMP,
            updated_at timestamp not null default CURRENT_TIMESTAMP
        );");

        parent::up();
    }
}
