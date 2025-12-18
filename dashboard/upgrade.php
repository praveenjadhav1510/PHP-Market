<?php
require_once __DIR__ . '/guard.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/payment_config.php';
require_once __DIR__ . '/../includes/plan-check.php';

$userId = $_SESSION['user_id'];
$currentPlan = getCurrentPlan();

$pageTitle = "Upgrade Your Plan | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">
    
<?php require_once __DIR__ . '/sidebar.php'; ?>

<main class="dashboard-content">
    <section class="pricing">
        <div class="container">
            <h1 class="pricing-title">Your Current Plan - <?= strtoupper($currentPlan) ?></h1>
            <p class="pricing-subtitle">
                Choose a plan that fits your needs and unlock more features.
            </p>

            <?php if (isset($_GET['error'])): ?>
                <div style="background: #fee; color: #c33; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <div class="pricing-grid">

                <!-- FREE PLAN -->
                <div class="plan-card <?= $currentPlan === 'free' ? 'current-plan' : '' ?>">
                    <h3>Free</h3>
                    <p class="plan-price">₹0<span>/month</span></p>
                    <p class="plan-desc">Best for getting started</p>

                    <ul class="plan-features">
                        <li>✔ Basic profile</li>
                        <li>✔ Browse developers / projects</li>
                        <li>✔ Up to 3 projects (clients)</li>
                        <li>✔ Up to 5 applications (developers)</li>
                        <li>✔ Limited search</li>
                        <li>✖ Priority visibility</li>
                        <li>✖ Direct messaging</li>
                    </ul>

                    <?php if ($currentPlan === 'free'): ?>
                        <button class="btn-outline" disabled>
                            Current Plan
                        </button>
                    <?php else: ?>
                        <a href="/php-dev-marketplace/payment/downgrade.php?plan=free" class="btn-outline">
                            Downgrade to Free
                        </a>
                    <?php endif; ?>
                </div>

                <!-- PRO PLAN (HIGHLIGHTED) -->
                <div class="plan-card featured <?= $currentPlan === 'pro' ? 'current-plan' : '' ?>">
                    <span class="badge">Most Popular</span>
                    <h3>Pro</h3>
                    <p class="plan-price">₹199<span>/month</span></p>
                    <p class="plan-desc">For active clients & developers</p>

                    <ul class="plan-features">
                        <li>✔ Full profile access</li>
                        <li>✔ Up to 20 projects (clients)</li>
                        <li>✔ Up to 50 applications (developers)</li>
                        <li>✔ Unlimited search</li>
                        <li>✔ Direct messaging</li>
                        <li>✔ Higher visibility</li>
                        <li>✔ Faster responses</li>
                    </ul>

                    <?php if ($currentPlan === 'pro'): ?>
                        <button class="btn-primary" disabled>Current Plan</button>
                    <?php elseif ($currentPlan === 'premium'): ?>
                        <button class="btn-outline" disabled>Downgrade Available</button>
                    <?php else: ?>
                        <a href="/php-dev-marketplace/payment/payment.php?plan=pro" class="btn-primary">
                            Upgrade to Pro
                        </a>
                    <?php endif; ?>
                </div>

                <!-- PREMIUM PLAN -->
                <div class="plan-card <?= $currentPlan === 'premium' ? 'current-plan' : '' ?>">
                    <h3>Premium</h3>
                    <p class="plan-price">₹999<span>/month</span></p>
                    <p class="plan-desc">For agencies & power users</p>

                    <ul class="plan-features">
                        <li>✔ Everything in Pro</li>
                        <li>✔ Unlimited projects</li>
                        <li>✔ Unlimited applications</li>
                        <li>✔ Featured listing</li>
                        <li>✔ Priority support</li>
                        <li>✔ Advanced analytics</li>
                        <li>✔ Early access to features</li>
                    </ul>

                    <?php if ($currentPlan === 'premium'): ?>
                        <button class="btn-primary" disabled>Current Plan</button>
                    <?php else: ?>
                        <a href="/php-dev-marketplace/payment/payment.php?plan=premium" class="btn-primary">
                            Go Premium
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
</main>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

