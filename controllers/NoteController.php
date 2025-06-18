<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Application;
use app\mappers\NoteMapper;
use app\models\Note;

class NoteController
{
    private NoteMapper $mapper;

    public function __construct()
    {
        $this->mapper = new NoteMapper();
    }

    public function index(): void
    {
        $body = Application::$app->getRequest()->getBody();
        $query = $body['q'] ?? null;
        $tag = $body['tag'] ?? null;
        $color = $body['color'] ?? null;
        $rows = $this->mapper->filter($query, $tag, $color);
        $notes = array_map(fn($row) => $this->mapper->createObject($row), $rows);
        Application::$app->getRouter()->renderTemplate('notes/index', [
            'notes' => $notes,
            'filters' => ['q' => $query, 'tag' => $tag, 'color' => $color]
        ]);
    }

    public function createView(): void
    {
        Application::$app->getRouter()->renderTemplate('notes/form', [
            'action' => '/notes/create',
            'title' => '',
            'description' => '',
            'color' => '',
            'tags' => '',
            'note_id' => '',
            'is_edit' => false,
        ]);
    }

    public function create(): void
    {
        $body = Application::$app->getRequest()->getBody();
        $note = new Note(
            id: null,
            title: $body['title'] ?? '',
            description: $body['description'] ?? '',
            color: $body['color'] ?? '',
            tags: $body['tags'] ?? ''
        );
        $this->mapper->Insert($note);
        Application::$app->getRouter()->renderTemplate('notes/success', []);
    }

    public function editView(): void
    {
        $body = Application::$app->getRequest()->getBody();
        if (!isset($body['id'])) {
            Application::$app->getRouter()->renderStatic('404.html');
            return;
        }
        $row = $this->mapper->doSelect((int)$body['id']);
        if (!$row) {
            Application::$app->getRouter()->renderStatic('404.html');
            return;
        }
        /** @var Note $note */
        $note = $this->mapper->createObject($row);
        Application::$app->getRouter()->renderTemplate('notes/form', [
            'action' => '/notes/edit',
            'title' => $note->getTitle(),
            'description' => $note->getDescription(),
            'color' => $note->getColor(),
            'tags' => $note->getTags(),
            'note_id' => $note->getId(),
            'is_edit' => true,
        ]);
    }

    public function edit(): void
    {
        $body = Application::$app->getRequest()->getBody();
        if (!isset($body['id'])) {
            Application::$app->getRouter()->renderStatic('404.html');
            return;
        }
        $note = new Note(
            id: (int)$body['id'],
            title: $body['title'] ?? '',
            description: $body['description'] ?? '',
            color: $body['color'] ?? '',
            tags: $body['tags'] ?? ''
        );
        $this->mapper->Update($note);
        Application::$app->getRouter()->renderTemplate('notes/success', []);
    }

    public function delete(): void
    {
        $body = Application::$app->getRequest()->getBody();
        if (isset($body['id'])) {
            $note = new Note((int)$body['id'], '', '', '', '');
            $this->mapper->Delete($note);
        }
        Application::$app->getRouter()->renderTemplate('notes/success', []);
    }
}
