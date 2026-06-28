<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();   

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$student = $id ? get_student_by_id($conn, $id) : null;

if (!$student) {
    $page_title = 'Delete Student';
    require_once __DIR__ . '/includes/header.php';
    echo '<div class="alert alert-error">Student not found.</div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['confirm'] ?? '') === 'yes') {
    
    if (!empty($student['photo'])) {
        $path = __DIR__ . '/uploads/' . $student['photo'];
        if (is_file($path)) {
            @unlink($path);
        }
    }
    delete_student($conn, $id);
    header('Location: view_student.php?msg=' . urlencode('Student deleted successfully.'));
    exit;
}

$page_title = 'Delete Student';
require_once __DIR__ . '/includes/header.php';
?>
<h1>Delete Student</h1>
<div class="card" style="margin-top:1rem;">
    <div class="alert alert-error" style="margin-bottom:1rem;">
        <i class="fa-solid fa-triangle-exclamation"></i> Are you sure you want to delete this student? This action cannot be undone.
    </div>
    <table class="detail-table">
        <tr><th>Student ID</th><td><?= e($student['student_id']) ?></td></tr>
        <tr><th>Name</th><td><?= e($student['name']) ?></td></tr>
        <tr><th>Email</th><td><?= e($student['email']) ?></td></tr>
    </table>
    <form method="post" action="delete_student.php" style="margin-top:1.25rem;">
        <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">
        <input type="hidden" name="confirm" value="yes">
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="view_student.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
