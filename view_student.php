<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$students = get_all_students($conn);

$page_title = 'View Students';
require_once __DIR__ . '/includes/header.php';
?>
<div class="page-head">
    <h1>Student Records</h1>
    <?php if (is_admin()): ?>
        <a href="add_student.php" class="btn"><i class="fa-solid fa-plus"></i> Add Student</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success"><?= e($_GET['msg']) ?></div>
<?php endif; ?>
<?php if (($_GET['error'] ?? '') === 'denied'): ?>
    <div class="alert alert-error">Access denied. Students may only view records.</div>
<?php endif; ?>

<?php if (empty($students)): ?>
    <div class="alert alert-info">No student records found.</div>
<?php else: ?>
<div class="table-wrap card" style="padding:0;">
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $s): ?>
            <tr>
                <td>
                    <?php if (!empty($s['photo'])): ?>
                        <img class="photo-thumb" src="uploads/<?= e($s['photo']) ?>" alt="photo">
                    <?php else: ?>
                        <img class="photo-thumb" src="<?= e(default_avatar($s['name'], $s['gender'])) ?>" alt="photo">
                    <?php endif; ?>
                </td>
                <td><?= e($s['student_id']) ?></td>
                <td><?= e($s['name']) ?></td>
                <td><?= e($s['city']) ?></td>
                <td><?= e($s['contact']) ?></td>
                <td><?= e($s['email']) ?></td>
                <td>
                    <div class="actions">
                        <a class="btn btn-sm btn-secondary" href="view_detail.php?id=<?= (int)$s['id'] ?>">View</a>
                        <?php if (is_admin()): ?>
                            <a class="btn btn-sm btn-success" href="edit_student.php?id=<?= (int)$s['id'] ?>">Edit</a>
                            <a class="btn btn-sm btn-danger" href="delete_student.php?id=<?= (int)$s['id'] ?>">Delete</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
