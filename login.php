<?php
require_once __DIR__ . '/includes/auth.php';

// Already logged in? Go home.
if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $user = get_user_by_username($conn, $username);
        if ($user && password_verify($password, $user['password'])) {
            // Set up session.
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['username']  = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];
            header('Location: index.php');
            exit;
        }
        $error = 'Invalid username or password.';
    }
}

$page_title = 'Login';
require_once __DIR__ . '/includes/header.php';
?>
<div class="login-wrap">
    <div class="card">
        <h1>Login</h1>
        <p class="muted">Sign in to access the system.</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group" style="margin-top:1rem;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn" style="width:100%;">Login</button>
            </div>
        </form>

        <p class="login-hint">
            Demo accounts:<br>
            <strong>admin</strong> / admin123 &nbsp;·&nbsp; <strong>student</strong> / student123
        </p>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
