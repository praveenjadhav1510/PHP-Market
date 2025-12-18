<?php
// payment/process.php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/payment_config.php';

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /php-dev-marketplace/dashboard/upgrade");
    exit;
}

$plan = $_POST['plan'] ?? '';
$amount = (float)($_POST['amount'] ?? 0);
$cardNumber = $_POST['card_number'] ?? '';
$expiry = $_POST['expiry'] ?? '';
$cvv = $_POST['cvv'] ?? '';
$cardName = $_POST['card_name'] ?? '';

// Validate
if (!in_array($plan, ['pro', 'premium']) || $amount <= 0) {
    header("Location: /php-dev-marketplace/payment/payment.php?plan=$plan&error=invalid");
    exit;
}

// In production, validate payment with Razorpay/Stripe here
// For demo, we'll simulate a successful payment

$paymentId = 'pay_' . uniqid() . '_' . time();
$transactionId = 'txn_' . uniqid() . '_' . time();
$paymentStatus = 'success'; // In production, get from payment gateway

try {
    // Check if payments table exists
    $tableCheck = $pdo->query("SHOW TABLES LIKE 'payments'");
    if ($tableCheck->rowCount() == 0) {
        throw new Exception("Payments table not found. Please run: /php-dev-marketplace/config/setup_tables.php");
    }

    $pdo->beginTransaction();

    // Insert payment record (works for both clients and developers)
    $stmt = $pdo->prepare("
        INSERT INTO payments 
        (user_id, plan, amount, payment_id, payment_status, payment_method, transaction_id)
        VALUES (?, ?, ?, ?, ?, 'card', ?)
    ");
    $stmt->execute([$userId, $plan, $amount, $paymentId, $paymentStatus, $transactionId]);

    // Update user plan (works for both clients and developers)
    $stmt = $pdo->prepare("UPDATE users SET plan = ? WHERE id = ?");
    $stmt->execute([$plan, $userId]);

    // Update session
    $_SESSION['plan'] = $plan;

    $pdo->commit();

    // Redirect to success page
    header("Location: /php-dev-marketplace/payment/success.php?payment_id=$paymentId&plan=$plan");
    exit;

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $errorMsg = $e->getMessage();
    if (strpos($errorMsg, "Base table or view not found") !== false) {
        $errorMsg = "Database tables not set up. Please visit: /php-dev-marketplace/config/setup_tables.php";
    }
    header("Location: /php-dev-marketplace/payment/failure.php?error=" . urlencode($errorMsg));
    exit;
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    header("Location: /php-dev-marketplace/payment/failure.php?error=" . urlencode($e->getMessage()));
    exit;
}

