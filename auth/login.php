<?php
// auth/login.php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/theme-script.php';
require_once __DIR__ . '/../includes/head-common.php';

$authTitle = "Welcome Back";
$authSubtitle = "Login to manage your projects and connect with developers.";

// Auto-login via cookie
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $stmt = $pdo->prepare("
        SELECT id, name, user_type FROM users WHERE remember_token = ?
    ");
    $stmt->execute([$_COOKIE['remember_token']]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        header("Location: /dashboard");
        exit;
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (!$email || !$password) {
        $errors[] = "Email and password are required";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            SELECT id, name, password, user_type FROM users WHERE email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = "Invalid login credentials";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_type'] = $user['user_type'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie("remember_token", $token, time() + 604800, "/", "", false, true);

                $update = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                $update->execute([$token, $user['id']]);
            }

            header("Location: /php-dev-marketplace/");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | PHP Dev Marketplace</title>
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/auth.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="php-logo animate-text"><img src="/php-dev-marketplace/assets/images/logo.png" alt="PHP_LOGO"/></div>
    <!-- LEFT SIDE (OPTIONAL / ANIMATED) -->
    <div class="auth-left">
        <div class="auth-left-content">
            <h1 class="auth-title animate-text"><i class="fa-solid fa-door-open fa-ic"></i><?= $authTitle ?></h1>
            <p class="auth-subtitle animate-text"><?= $authSubtitle ?></p>
        </div>
    </div>

    <!-- RIGHT SIDE (FORM) -->
    <div class="auth-right">
        <div class="auth-card">

            <h2>Login</h2>
            <p class="subtitle">Welcome back</p>

            <?php if ($errors): ?>
                <div class="msg error">
                    <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <p class="switch-link">
                    <a href="/php-dev-marketplace/auth/forgot-password">Forgot password</a>
                </p>
                <div class="form-group remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me (7 days)</label>
                </div>

                <button class="btn-primary">Login <i class="fa-solid fa-arrow-right-to-bracket"></i></button>

                <p class="switch-link">
                    Don’t have an account?
                    <a href="/php-dev-marketplace/auth/signup">Signup</a>
                </p>
            </form>

        </div>
    </div>

</div>

</body>
</html>
