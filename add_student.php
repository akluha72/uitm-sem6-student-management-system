<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();   // only admin may add

$error   = '';
$student = [];     // empty form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and trim input (student_id is auto-generated, not taken from the form).
    $fields = ['name','address1','address2','postcode','city',
               'gender','race','religion','contact','email'];
    foreach ($fields as $f) {
        $student[$f] = trim($_POST[$f] ?? '');
    }

    // Generate the Student ID server-side so it is always unique and current.
    $student['student_id'] = get_next_student_id($conn);

    // Basic validation.
    if ($student['name'] === '' || $student['email'] === '') {
        $error = 'Name and Email are required.';
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

// Show a preview of the ID that will be assigned.
$student['student_id'] = get_next_student_id($conn);

$page_title   = 'Add Student';
$submit_label = 'Add Student';
$autogen_id   = true;   // render Student ID as read-only / auto-generated
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
