<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$keyword = trim($_GET['keyword'] ?? '');
$results = null;
if ($keyword !== '') {
    $results = search_students($conn, $keyword);
}

$page_title = 'Search Students';
require_once __DIR__ . '/includes/header.php';
?>
<h1>Search Students</h1>
<p class="muted">Search by Student ID or Name.</p>

<form method="get" action="search_student.php" class="search-bar" style="margin-top:1rem;">
    <input type="text" name="keyword" placeholder="Enter Student ID or Name..."
           value="<?= e($keyword) ?>" autofocus>
    <button type="submit" class="btn"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
</form>

<?php if ($results !== null): ?>
    <?php if (empty($results)): ?>
        <div class="alert alert-info">No students match "<?= e($keyword) ?>".</div>
    <?php else: ?>
        <p class="muted"><?= count($results) ?> result(s) found.</p>
        <div class="table-wrap card" style="padding:0;">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $s): ?>
                    <tr>
                        <td><?= e($s['student_id']) ?></td>
                        <td><?= e($s['name']) ?></td>
                        <td><?= e($s['city']) ?></td>
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
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
