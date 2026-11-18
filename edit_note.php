<?php
require 'config.php';

$categories = ['Personal', 'Work', 'Study', 'Ideas', 'Shopping'];
$colors = ['yellow', 'green', 'blue', 'pink', 'purple'];

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
$stmt->execute([$id]);
$note = $stmt->fetch();

if (!$note) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = $_POST['category'];
    $color = $_POST['color'];

    $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, category = ?, color = ? WHERE id = ?");
    $stmt->execute([$title, $content, $category, $color, $id]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note - NoteKeeper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">&#128221; NoteKeeper</a>
        <div class="d-flex align-items-center gap-2">
            <span class="avatar-circle">HK</span>
            <span class="text-white fw-semibold">Hammad Khan</span>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card form-card p-4">
                <h3 class="fw-bold mb-3">Edit Note</h3>
                <form method="POST" action="edit_note.php?id=<?php echo $note['id']; ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required maxlength="255" value="<?php echo htmlspecialchars($note['title']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required><?php echo htmlspecialchars($note['content']); ?></textarea>
                        <small id="wordCount" class="text-muted">0 words</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category; ?>" <?php echo $note['category'] === $category ? 'selected' : ''; ?>><?php echo $category; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Color</label>
                            <input type="hidden" id="color" name="color" value="<?php echo htmlspecialchars($note['color']); ?>">
                            <div class="d-flex gap-2 pt-1">
                                <?php foreach ($colors as $color): ?>
                                    <span class="color-option <?php echo $note['color'] === $color ? 'selected' : ''; ?>" data-color="<?php echo $color; ?>" style="background: <?php echo $color === 'yellow' ? '#ffc107' : ($color === 'green' ? '#198754' : ($color === 'blue' ? '#0d6efd' : ($color === 'pink' ? '#d63384' : '#6f42c1'))); ?>"></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
