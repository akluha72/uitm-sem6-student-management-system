<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$student = $id ? get_student_by_id($conn, $id) : null;

$page_title = 'Student Detail';
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-head">
    <h1>Student Detail</h1>
    <a href="view_student.php" class="btn btn-secondary">&larr; Back to list</a>
</div>

<?php if (!$student): ?>
    <div class="alert alert-error">Student not found.</div>
<?php else: ?>
<div class="card">
    <div style="display:flex; gap:1.5rem; flex-wrap:wrap; align-items:flex-start;">
        <div>
            <?php if (!empty($student['photo'])): ?>
                <img class="photo-lg" src="uploads/<?= e($student['photo']) ?>" alt="student photo">
            <?php else: ?>
                <img class="photo-lg" src="<?= e(default_avatar($student['name'], $student['gender'])) ?>" alt="student photo">
            <?php endif; ?>
        </div>
        <div style="flex:1; min-width:260px;">
            <div class="table-wrap">
            <table class="detail-table">
                <tr><th>Student ID</th><td><?= e($student['student_id']) ?></td></tr>
                <tr><th>Name</th><td><?= e($student['name']) ?></td></tr>
                <tr><th>Address 1</th><td><?= e($student['address1']) ?></td></tr>
                <tr><th>Address 2</th><td><?= e($student['address2']) ?></td></tr>
                <tr><th>Postcode</th><td><?= e($student['postcode']) ?></td></tr>
                <tr><th>City</th><td><?= e($student['city']) ?></td></tr>
                <tr><th>State</th><td><?= e($student['state']) ?></td></tr>
                <tr><th>Gender</th><td><?= e($student['gender']) ?></td></tr>
                <tr><th>Race</th><td><?= e($student['race']) ?></td></tr>
                <tr><th>Religion</th><td><?= e($student['religion']) ?></td></tr>
                <tr><th>Contact Number</th><td><?= e($student['contact']) ?></td></tr>
                <tr><th>Email</th><td><?= e($student['email']) ?></td></tr>
            </table>
            </div>
            <?php if (is_admin()): ?>
                <div class="form-actions">
                    <a class="btn btn-success" href="edit_student.php?id=<?= (int)$student['id'] ?>">Edit</a>
                    <a class="btn btn-danger" href="delete_student.php?id=<?= (int)$student['id'] ?>">Delete</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
