<?php class_exists('app\core\Template') or exit; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Note</title>
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

<h2 class="mb-3"><?php if ($is_edit) { ?>Edit<?php } else { ?>Create<?php } ?> Note</h2>
<form method="post" action="<?= $action ?>">
    <input type="hidden" name="id" value="<?= $note_id ?>">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input class="form-control" type="text" name="title" value="<?= $title ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?= $description ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Color</label>
        <input class="form-control" type="text" name="color" value="<?= $color ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Tags</label>
        <input class="form-control" type="text" name="tags" value="<?= $tags ?>">
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
</form>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




