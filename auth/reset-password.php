<?php
// auth/reset-password.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/theme-script.php';
require_once __DIR__ . '/../includes/head-common.php';

// Fix timezone issues
date_default_timezone_set('Asia/Kolkata');

$token = $_GET['token'] ?? '';
$msg = "";

// Validate token
$stmt = $pdo->prepare("
    SELECT id FROM users 
    WHERE reset_token = ?
");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("Invalid or expired reset link");
}

// Handle new password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = $_POST['password'] ?? '';

    if (strlen($password) < 6) {
        $msg = "Password must be at least 6 characters";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // Update password & clear token
        $update = $pdo->prepare("
            UPDATE users 
            SET password = ?, reset_token = NULL, reset_expires = NULL 
            WHERE id = ?
        ");
        $update->execute([$hashed, $user['id']]);

        header("Location: /php-dev-marketplace/auth/login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/auth.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Reset Password</h2>
        <p class="subtitle">Enter a new password</p>

        <?php if ($msg): ?>
            <div class="msg error"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" required minlength="6">
            </div>

            <button class="btn-primary">Update Password</button>
        </form>
    </div>
</div>

</body>
</html>
