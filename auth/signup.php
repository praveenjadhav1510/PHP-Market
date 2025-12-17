<?php
// auth/signup.php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/theme-script.php';
require_once __DIR__ . '/../includes/head-common.php';

$authTitle = "Create Your Account";
$authSubtitle = "Join the PHP Dev Marketplace and start building today.";

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $userType = $_POST['user_type'] ?? '';

    if (!$name || !$email || !$password || !$userType) {
        $errors[] = "All fields are required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if (empty($errors)) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $errors[] = "Email already registered";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("
                INSERT INTO users (name, email, password, user_type, plan)
                VALUES (?, ?, ?, ?, 'free')
            ");
            $stmt->execute([$name, $email, $hashedPassword, $userType]);

            $success = "Signup successful! You can login now.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup | PHP Dev Marketplace</title>
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">
<div class="php-logo animate-text"><img src="/php-dev-marketplace/assets/images/logo.png" alt="PHP_LOGO"/></div>
    <!-- LEFT SIDE (OPTIONAL / ANIMATED) -->
    <div class="auth-left">
        <div class="auth-left-content">
            <h1 class="auth-title animate-text"><?= $authTitle ?></h1>
            <p class="auth-subtitle animate-text"><?= $authSubtitle ?></p>
        </div>
    </div>

    <!-- RIGHT SIDE (FORM) -->
    <div class="auth-right">
        <div class="auth-card">

            <h2>Create Account</h2>
            <p class="subtitle">Join as Client or PHP Developer</p>

            <?php if (!empty($errors)): ?>
                <div class="msg error">
                    <?php foreach ($errors as $e) echo "<p>$e</p>"; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="msg success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($name ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required minlength="6">
                </div>

                <div class="form-group">
                    <label>User Type</label>
                    <select name="user_type" required>
                        <option value="">Select</option>
                        <option value="client" <?= ($userType ?? '') === 'client' ? 'selected' : '' ?>>Client</option>
                        <option value="developer" <?= ($userType ?? '') === 'developer' ? 'selected' : '' ?>>Developer</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Sign Up</button>

                <p class="switch-link">
                    Already have an account?
                    <a href="/php-dev-marketplace/auth/login">Login</a>
                </p>
                <p class="switch-link">
                    <a href="/php-dev-marketplace/pages/privacy">Privacy Policy</a>
                    <a href="/php-dev-marketplace/pages/terms">Terms & Conditions</a>
                </p>
            </form>

        </div>
    </div>

</div>

</body>
</html>
