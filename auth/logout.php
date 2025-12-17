<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("
        UPDATE users SET remember_token = NULL WHERE id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
}

setcookie("remember_token", "", time() - 3600, "/");
session_destroy();

header("Location: /php-dev-marketplace/auth/login");
exit;
