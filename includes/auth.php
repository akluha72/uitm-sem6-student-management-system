<?php
/**
 * Session management + access-control helpers.
 * (No SQL here — all queries live in includes/queries.php.)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/queries.php';

/** Is someone logged in? */
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

/** Is the logged-in user an admin? */
function is_admin(): bool
{
    return is_logged_in() && ($_SESSION['role'] ?? '') === 'admin';
}

/** Redirect to login page if not authenticated. */
function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Block non-admins from admin-only actions (add/edit/delete).
 * Students may only view.
 */
function require_admin(): void
{
    require_login();
    if (!is_admin()) {
        header('Location: view_student.php?error=denied');
        exit;
    }
}

/** Escape output for safe HTML rendering. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Handle an optional photo upload from $_FILES[$field].
 * Returns the stored filename, or '' if no file was uploaded.
 * Throws RuntimeException on a real upload error.
 */
function handle_photo_upload(string $field): string
{
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Photo upload failed (error code ' . $file['error'] . ').');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Invalid image type. Allowed: JPG, PNG, GIF, WEBP.');
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Photo too large (max 2 MB).');
    }

    $dir = __DIR__ . '/../uploads';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $name = 'student_' . uniqid('', true) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
        throw new RuntimeException('Could not save uploaded photo.');
    }
    return $name;
}
