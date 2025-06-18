<?php

declare(strict_types=1);

namespace app\migrations;

class Migration_4 extends \app\core\Migration
{
    public function getVersion(): int
    {
        return 4;
    }

    public function up(): void
    {
        // add login and password columns to users table
        $this->database->pdo->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS login varchar(255) UNIQUE;");
        $this->database->pdo->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS password varchar(255);");

        // link notes to users
        $this->database->pdo->query("ALTER TABLE notes ADD COLUMN IF NOT EXISTS user_id int REFERENCES users(id);");

        parent::up();
    }
}
