<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$page_title = 'Home';
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-head">
    <div>
        <h1>Welcome, <?= e($_SESSION['full_name']) ?> 👋</h1>
        <p class="muted">
            You are logged in as
            <strong><?= e($_SESSION['role']) ?></strong>.
            <?php if (is_admin()): ?>
                You have full access to manage student records.
            <?php else: ?>
                You may view student records only.
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="tiles">
    <a class="tile" href="view_student.php">
        <div class="icon">📋</div>
        <h3>View Students</h3>
        <p class="muted">Browse all student records.</p>
    </a>
    <a class="tile" href="search_student.php">
        <div class="icon">🔍</div>
        <h3>Search</h3>
        <p class="muted">Find a student by ID or name.</p>
    </a>
    <?php if (is_admin()): ?>
        <a class="tile" href="add_student.php">
            <div class="icon">➕</div>
            <h3>Add Student</h3>
            <p class="muted">Create a new student record.</p>
        </a>
    <?php endif; ?>
    <a class="tile" href="about.php">
        <div class="icon">ℹ️</div>
        <h3>About</h3>
        <p class="muted">Learn about this system.</p>
    </a>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
