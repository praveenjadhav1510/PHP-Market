<?php
session_start();
$pageTitle = "Upgrade Your Plan | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">
    
<?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>

<main class="dashboard-content">
    <section class="pricing">
        <div class="container">
            <h1 class="pricing-title">Your Current Plan - FREE (Upgrade Your Plan)</h1>
            <p class="pricing-subtitle">
                Choose a plan that fits your needs and unlock more features.
            </p>

            <div class="pricing-grid">

                <!-- FREE PLAN -->
                <div class="plan-card">
                    <h3>Free</h3>
                    <p class="plan-price">₹0<span>/month</span></p>
                    <p class="plan-desc">Best for getting started</p>

                    <ul class="plan-features">
                        <li>✔ Basic profile</li>
                        <li>✔ Browse developers / projects</li>
                        <li>✔ Limited search</li>
                        <li>✖ Priority visibility</li>
                        <li>✖ Direct messaging</li>
                    </ul>

                    <button class="btn-outline" disabled>
                        Current Plan
                    </button>
                </div>

                <!-- PRO PLAN (HIGHLIGHTED) -->
                <div class="plan-card featured">
                    <span class="badge">Most Popular</span>
                    <h3>Pro</h3>
                    <p class="plan-price">₹1,999<span>/month</span></p>
                    <p class="plan-desc">For serious clients & developers</p>

                    <ul class="plan-features">
                        <li>✔ Full profile access</li>
                        <li>✔ Unlimited search</li>
                        <li>✔ Direct messaging</li>
                        <li>✔ Higher visibility</li>
                        <li>✔ Faster responses</li>
                    </ul>

                    <a href="#" class="btn-primary">
                        Upgrade to Pro
                    </a>
                </div>

                <!-- PREMIUM PLAN -->
                <div class="plan-card">
                    <h3>Premium</h3>
                    <p class="plan-price">₹9,999<span>/month</span></p>
                    <p class="plan-desc">For agencies & power users</p>

                    <ul class="plan-features">
                        <li>✔ Everything in Pro</li>
                        <li>✔ Featured listing</li>
                        <li>✔ Priority support</li>
                        <li>✔ Advanced analytics</li>
                        <li>✔ Early access to features</li>
                    </ul>

                    <a href="#" class="btn-primary">
                        Go Premium
                    </a>
                </div>

            </div>
        </div>
    </section>
</main>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

