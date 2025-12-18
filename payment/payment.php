<?php
// payment/payment.php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/payment_config.php';

$userId = $_SESSION['user_id'];
$plan = $_GET['plan'] ?? '';

// Validate plan
$allowedPlans = ['pro', 'premium'];
if (!in_array($plan, $allowedPlans)) {
    header("Location: /php-dev-marketplace/dashboard/upgrade");
    exit;
}

// Get current user plan
$stmt = $pdo->prepare("SELECT plan FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
$currentPlan = $user['plan'] ?? 'free';

// Don't allow downgrade
if ($plan === 'pro' && $currentPlan === 'premium') {
    header("Location: /php-dev-marketplace/dashboard/upgrade?error=downgrade_not_allowed");
    exit;
}

$amount = PLAN_PRICES[$plan];
$pageTitle = "Payment - Upgrade to " . ucfirst($plan);
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">
    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>
    
    <main class="dashboard-content">
        <h1>Complete Payment</h1>
        <p class="dash-subtitle">Upgrade to <?= ucfirst($plan) ?> Plan</p>

        <div class="payment-container" style="max-width: 600px; margin: 2rem auto;">
            <div class="payment-card" style="background: var(--card-bg); padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h2>Payment Details</h2>
                
                <div style="margin: 1.5rem 0;">
                    <p><strong>Account Type:</strong> <?= ucfirst($_SESSION['user_type'] ?? 'user') ?></p>
                    <p><strong>Plan:</strong> <?= ucfirst($plan) ?></p>
                    <p><strong>Amount:</strong> ₹<?= number_format($amount) ?>/month</p>
                    <p><strong>Current Plan:</strong> <?= ucfirst($currentPlan) ?></p>
                </div>

                <form method="POST" action="/php-dev-marketplace/payment/process.php" id="paymentForm">
                    <input type="hidden" name="plan" value="<?= htmlspecialchars($plan) ?>">
                    <input type="hidden" name="amount" value="<?= $amount ?>">
                    <input type="hidden" name="user_id" value="<?= $userId ?>">

                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label>Card Number</label>
                        <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="text" name="expiry" placeholder="MM/YY" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" name="cvv" placeholder="123" maxlength="4" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label>Cardholder Name</label>
                        <input type="text" name="card_name" placeholder="John Doe" required>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">
                        Pay ₹<?= number_format($amount) ?>
                    </button>
                </form>

                <div style="margin-top: 1.5rem; padding: 1rem; background: var(--bg-secondary); border-radius: 8px; font-size: 0.9rem;">
                    <p><strong>✅ Test Mode:</strong> This is a demo payment page. No real payment will be processed.</p>
                    <p style="margin-top: 0.5rem;"><strong>For Testing:</strong> Use any card number (e.g., 4111 1111 1111 1111), any future expiry date (e.g., 12/25), and any CVV (e.g., 123).</p>
                    <p style="margin-top: 0.5rem;"><strong>Note:</strong> Both clients and developers can purchase any plan. Your plan will be activated immediately after payment.</p>
                </div>

                <div style="margin-top: 1rem; text-align: center;">
                    <a href="/php-dev-marketplace/dashboard/upgrade" class="btn-outline">Cancel</a>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
// Format card number
document.querySelector('input[name="card_number"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '');
    let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formatted;
});

// Format expiry date
document.querySelector('input[name="expiry"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

