<?php
// auth/forgot-password.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/theme-script.php';
require_once __DIR__ . '/../includes/head-common.php';

// Fix timezone issues
date_default_timezone_set('Asia/Kolkata');

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    if ($email) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate secure token
            $token = bin2hex(random_bytes(32));

            // Set expiry (30 minutes)
            $expires = date("Y-m-d H:i:s", strtotime("+30 minutes"));

            // Save token
            $update = $pdo->prepare("
                UPDATE users 
                SET reset_token = ?, reset_expires = ? 
                WHERE email = ?
            ");
            $update->execute([$token, $expires, $email]);

            // Reset link (email simulation)
            $resetLink = "http://localhost/php-dev-marketplace/auth/reset-password.php?token=$token";

            $msg = "Password reset link (for demo):<br>
                    <a href='$resetLink'>reset with token</a>";
        } else {
            // Security: do not reveal if email exists
            $msg = "If this email exists, a reset link has been sent.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/auth.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="php-logo animate-text"><img src="/php-dev-marketplace/assets/images/logo.png" alt="PHP_LOGO"/></div>
<div class="auth-container">
    <div class="auth-card">
        <h2>Forgot Password <i class="fa-solid fa-person-harassing"></i></h2>
        <p class="subtitle">Enter your registered email</p>

        <?php if ($msg): ?>
            <div class="msg success"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <button class="btn-primary">Send Reset Link <i class="fa-solid fa-link"></i></button>

            <p class="switch-link">
                <a href="/php-dev-marketplace/auth/login">Back to Login <i class="fa-solid fa-people-pulling"></i></a>
            </p>
        </form>
    </div>
</div>

</body>
</html>
