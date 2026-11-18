<?php
require 'config.php';

// Fetch all notes, pinned first, newest first
$stmt = $pdo->query("SELECT * FROM notes ORDER BY pinned DESC, updated_at DESC");
$notes = $stmt->fetchAll();

// Stats
$totalNotes = count($notes);
$pinnedNotes = 0;
$categories = [];
$totalWords = 0;
foreach ($notes as $note) {
    if ($note['pinned']) $pinnedNotes++;
    $categories[$note['category']] = true;
    $totalWords += str_word_count(strip_tags($note['content']));
}
$totalCategories = count($categories);

// Category list for filters
$allCategories = $pdo->query("SELECT DISTINCT category FROM notes ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteKeeper - Simple Note Taking App</title>
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
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">My Notes</h2>
            <p class="text-muted mb-0">Capture ideas fast, find them faster.</p>
        </div>
        <a href="add_note.php" class="btn btn-primary mt-2 mt-md-0">+ New Note</a>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 text-center">
                <div class="stat-value text-primary"><?php echo $totalNotes; ?></div>
                <div class="stat-label">Total Notes</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 text-center">
                <div class="stat-value text-warning"><?php echo $pinnedNotes; ?></div>
                <div class="stat-label">Pinned Notes</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 text-center">
                <div class="stat-value text-success"><?php echo $totalCategories; ?></div>
                <div class="stat-label">Categories</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card p-3 text-center">
                <div class="stat-value text-info"><?php echo $totalWords; ?></div>
                <div class="stat-label">Total Words</div>
            </div>
        </div>
    </div>

    <!-- Search and filters -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Search notes by title or content...">
        </div>
        <div class="col-md-6">
            <div class="btn-group flex-wrap" role="group">
                <button type="button" class="btn btn-outline-primary active" data-filter="All">All</button>
                <?php foreach ($allCategories as $category): ?>
                    <button type="button" class="btn btn-outline-primary" data-filter="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Notes grid -->
    <div class="row g-3" id="notesGrid">
        <?php if (empty($notes)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No notes yet. Click "New Note" to write your first one.</div>
            </div>
        <?php endif; ?>
        <?php foreach ($notes as $note): ?>
            <div class="col-md-6 col-lg-4 note-item" data-category="<?php echo htmlspecialchars($note['category']); ?>">
                <div class="card note-card color-<?php echo htmlspecialchars($note['color']); ?>">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($note['category']); ?></span>
                            <?php if ($note['pinned']): ?>
                                <span class="badge bg-warning text-dark pin-badge">&#128204; Pinned</span>
                            <?php endif; ?>
                        </div>
                        <h5 class="card-title"><?php echo htmlspecialchars($note['title']); ?></h5>
                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars($note['content']); ?></p>
                        <small class="text-muted d-block mb-3">Updated <?php echo date('M d, Y', strtotime($note['updated_at'])); ?></small>
                        <div class="d-flex gap-2">
                            <a href="toggle_pin.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-outline-warning"><?php echo $note['pinned'] ? 'Unpin' : 'Pin'; ?></a>
                            <a href="edit_note.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="delete_note.php?id=<?php echo $note['id']; ?>" class="btn btn-sm btn-outline-danger delete-note">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="emptyState" class="alert alert-info text-center mt-3" style="display: none;">No notes match your search or filter.</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
