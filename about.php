<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$page_title = 'About';
require_once __DIR__ . '/includes/header.php';
?>
<h1>About This System</h1>
<div class="card" style="margin-top:1rem;">
    <p>
        The <strong>Student Management System</strong> is a database-driven web
        application built with <strong>PHP</strong> and <strong>MySQL</strong> for the
        ICT600 Web Technology &amp; Application course. It allows authorised users to
        manage student records through full CRUD operations.
    </p>

    <h2>Features</h2>
    <ul style="margin-left:1.2rem;">
        <li>User login authentication with session management</li>
        <li>Role-based access control (Admin vs Student)</li>
        <li>Add, View, Edit, Delete and Search student records</li>
        <li>Detailed single-student view</li>
        <li>Student photo upload</li>
        <li>Responsive design for desktop and mobile</li>
    </ul>

    <h2>Access Roles</h2>
    <ul style="margin-left:1.2rem;">
        <li><strong>Admin</strong> - full access: add, edit, delete and view students.</li>
        <li><strong>Student</strong> - read-only: may view student details only.</li>
    </ul>

    <h2>Technology</h2>
    <p class="muted">PHP 8 · MySQL · MySQLi prepared statements · Plain HTML/CSS (responsive).</p>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
