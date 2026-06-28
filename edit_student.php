<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();   

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$existing = $id ? get_student_by_id($conn, $id) : null;

if (!$existing) {
    $page_title = 'Edit Student';
    require_once __DIR__ . '/includes/header.php';
    echo '<div class="alert alert-error">Student not found.</div>';
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$error   = '';
$student = $existing;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['student_id','name','address1','address2','postcode','city','state',
               'gender','race','religion','contact','email'];
    foreach ($fields as $f) {
        $student[$f] = trim($_POST[$f] ?? '');
    }

    if ($student['student_id'] === '' || $student['name'] === '' || $student['email'] === '') {
        $error = 'Student ID, Name and Email are required.';
    } elseif (student_id_exists($conn, $student['student_id'], $id)) {
        $error = 'That Student ID is already used by another student.';
    } else {
        try {
            $newPhoto = handle_photo_upload('photo');
            
            $student['photo'] = $newPhoto !== '' ? $newPhoto : ($existing['photo'] ?? '');
            update_student($conn, $id, $student);
            header('Location: view_student.php?msg=' . urlencode('Student updated successfully.'));
            exit;
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }
    }
}

$page_title   = 'Edit Student';
$submit_label = 'Update Student';
require_once __DIR__ . '/includes/header.php';
?>
<h1>Edit Student</h1>
<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>
<div class="card" style="margin-top:1rem;">
    <?php require __DIR__ . '/includes/student_form.php'; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
