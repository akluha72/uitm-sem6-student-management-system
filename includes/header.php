<?php


require_once __DIR__ . '/auth.php';
$page_title = $page_title ?? 'Student Management System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="brand"><i class="fa-solid fa-user-graduate"></i> Student Management System</div>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>
    <nav class="nav" id="mainNav">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <?php if (is_logged_in()): ?>
            <a href="view_student.php">View Students</a>
            <a href="search_student.php">Search</a>
            <?php if (is_admin()): ?>
                <a href="add_student.php">Add Student</a>
            <?php endif; ?>
            <span class="nav-user">
                <?= e($_SESSION['full_name']) ?>
                <small class="badge <?= is_admin() ? 'badge-admin' : 'badge-student' ?>">
                    <?= e($_SESSION['role']) ?>
                </small>
            </span>
            <a href="logout.php" class="nav-logout">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
