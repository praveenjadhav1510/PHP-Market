<?php
// payment/success.php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];
$paymentId = $_GET['payment_id'] ?? '';
$plan = $_GET['plan'] ?? '';

$pageTitle = "Payment Successful";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">
    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>
    
    <main class="dashboard-content">
        <div style="max-width: 600px; margin: 2rem auto; text-align: center;">
            <div style="font-size: 4rem; color: #10b981; margin-bottom: 1rem;">✅</div>
            <h1>Payment Successful!</h1>
            <p class="dash-subtitle">Your plan has been upgraded to <?= ucfirst($plan) ?></p>

            <div style="background: var(--card-bg); padding: 2rem; border-radius: 12px; margin: 2rem 0; text-align: left;">
                <h3>Payment Details</h3>
                <p><strong>Account Type:</strong> <?= ucfirst($_SESSION['user_type'] ?? 'user') ?></p>
                <p><strong>Payment ID:</strong> <?= htmlspecialchars($paymentId) ?></p>
                <p><strong>Plan:</strong> <?= ucfirst($plan) ?></p>
                <p><strong>Status:</strong> <span style="color: #10b981;">Active</span></p>
                <p style="margin-top: 1rem; color: #666; font-size: 0.9rem;">
                    ✅ Your <?= ucfirst($plan) ?> plan benefits are now active. You can start using all premium features immediately!
                </p>
            </div>

            <div style="margin-top: 2rem;">
                <a href="/php-dev-marketplace/dashboard" class="btn-primary">Go to Dashboard</a>
                <a href="/php-dev-marketplace/dashboard/upgrade" class="btn-outline" style="margin-left: 1rem;">View Plans</a>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

