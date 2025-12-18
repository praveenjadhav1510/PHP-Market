<?php
// payment/downgrade.php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];
$plan = $_GET['plan'] ?? 'free';

if ($plan !== 'free') {
    header("Location: /php-dev-marketplace/dashboard/upgrade");
    exit;
}

// Get current plan
$stmt = $pdo->prepare("SELECT plan FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
$currentPlan = $user['plan'] ?? 'free';

if ($currentPlan === 'free') {
    header("Location: /php-dev-marketplace/dashboard/upgrade");
    exit;
}

// Downgrade to free
try {
    $stmt = $pdo->prepare("UPDATE users SET plan = 'free' WHERE id = ?");
    $stmt->execute([$userId]);
    
    $_SESSION['plan'] = 'free';
    
    header("Location: /php-dev-marketplace/dashboard/upgrade?success=downgraded");
    exit;
} catch (Exception $e) {
    header("Location: /php-dev-marketplace/dashboard/upgrade?error=" . urlencode($e->getMessage()));
    exit;
}



