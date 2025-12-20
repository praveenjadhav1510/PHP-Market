<?php
// payment/failure.php
require_once __DIR__ . '/../dashboard/guard.php';

$error = $_GET['error'] ?? 'Payment failed';
$pageTitle = "Payment Failed";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">
    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>
    
    <main class="dashboard-content">
        <div style="max-width: 600px; margin: 2rem auto; text-align: center;">
            <div style="font-size: 4rem; color: #ef4444; margin-bottom: 1rem;">❌</div>
            <h1>Payment Failed</h1>
            <p class="dash-subtitle"><?= htmlspecialchars($error) ?></p>

            <div style="margin-top: 2rem;">
                <a href="/php-dev-marketplace/dashboard/upgrade" class="btn-primary">Try Again</a>
                <a href="/php-dev-marketplace/dashboard" class="btn-outline" style="margin-left: 1rem;">Go to Dashboard</a>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>




