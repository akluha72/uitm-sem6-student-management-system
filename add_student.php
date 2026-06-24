<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();   // only admin may add

$error   = '';
$student = [];     // empty form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and trim input.
    $fields = ['student_id','name','address1','address2','postcode','city',
               'gender','race','religion','contact','email'];
    foreach ($fields as $f) {
        $student[$f] = trim($_POST[$f] ?? '');
    }

    // Basic validation.
    if ($student['student_id'] === '' || $student['name'] === '' || $student['email'] === '') {
        $error = 'Student ID, Name and Email are required.';
    } elseif (student_id_exists($conn, $student['student_id'])) {
        $error = 'That Student ID already exists.';
    } else {
        try {
            $student['photo'] = handle_photo_upload('photo');
            $newId = add_student($conn, $student);
            header('Location: view_student.php?msg=' . urlencode('Student added successfully.'));
            exit;
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }
    }
}

$page_title   = 'Add Student';
$submit_label = 'Add Student';
require_once __DIR__ . '/includes/header.php';
?>
<h1>Add Student</h1>
<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>
<div class="card" style="margin-top:1rem;">
    <?php require __DIR__ . '/includes/student_form.php'; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
