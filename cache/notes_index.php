<?php class_exists('app\core\Template') or exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/notes">Notes App</a>
    </div>
</nav>
<div class="container mb-5">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Notes</h2>
    <a class="btn btn-primary" href="/notes/create">Add note</a>
</div>

<form class="row g-2 mb-4" method="get" action="/notes">
    <div class="col-md-4">
        <input class="form-control" type="text" name="q" placeholder="search" value="<?= $filters['q'] ?>">
    </div>
    <div class="col-md-3">
        <input class="form-control" type="text" name="tag" placeholder="tag" value="<?= $filters['tag'] ?>">
    </div>
    <div class="col-md-3">
        <input class="form-control" type="text" name="color" placeholder="color" value="<?= $filters['color'] ?>">
    </div>
    <div class="col-md-2">
        <button class="btn btn-secondary w-100" type="submit">Filter</button>
    </div>
</form>

<div class="row row-cols-1 g-3">
<?php foreach ($notes as $note) { ?>
    <div class="col">
        <div class="card" style="border-left: 6px solid <?= $note->getColor() ?>;">
            <div class="card-body">
                <h5 class="card-title"><?= $note->getTitle() ?></h5>
                <p class="card-text"><?= $note->getDescription() ?></p>
                <p class="card-text"><small class="text-muted">Tags: <?= $note->getTags() ?> | Created: <?= $note->getCreatedAt() ?></small></p>
                <a class="btn btn-sm btn-outline-primary" href="/notes/edit?id=<?= $note->getId() ?>">Edit</a>
                <a class="btn btn-sm btn-outline-danger" href="/notes/delete?id=<?= $note->getId() ?>">Delete</a>
            </div>
        </div>
    </div>
<?php } ?>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




