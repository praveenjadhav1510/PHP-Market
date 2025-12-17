<?php
session_start();
$pageTitle = "Join PHP Dev Marketplace";
require_once __DIR__ . '/includes/header.php';

$isLoggedIn = isset($_SESSION['user_id']);
$currentPlan = $_SESSION['plan'] ?? 'free';
?>
<div class="cover-image container">
    <img src="/php-dev-marketplace/assets/images/pricing.jpg" alt="privacy-image"/>
    <h1>Join now!</h1>
    <p class="updated">Last updated: <?= date('F Y') ?></p>
</div>
<!-- ================= HERO ================= -->
<section class="page-hero">
    <div class="container">
        <h1>Join PHP Dev Marketplace</h1>
        <p>
            A modern platform to hire skilled PHP developers or find
            high-quality PHP projects.
        </p>
    </div>
</section>

<!-- ================= ABOUT ================= -->
<section class="content-section">
    <div class="container">
        <h2>What is PHP Dev Marketplace?</h2>
        <p>
            PHP Dev Marketplace connects clients and PHP developers on a single
            platform. Clients can post projects and hire talent, while developers
            can showcase skills and work on real-world projects.
        </p>
        <p>
            The platform supports Core PHP, Laravel, WordPress, REST APIs,
            MySQL-based systems, and more.
        </p>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="content-section alt">
    <div class="container">
        <h2>How It Works</h2>
        <ol class="workflow">
            <li>Create a free account</li>
            <li>Complete your profile</li>
            <li>Post projects or browse listings</li>
            <li>Connect and collaborate</li>
        </ol>
    </div>
</section>

<!-- ================= PRICING ================= -->
<section class="pricing">
    <div class="container">
        <h2 class="pricing-title">Choose Your Plan</h2>
        <p class="pricing-subtitle">
            Start free, upgrade anytime as your needs grow
        </p>

        <div class="pricing-grid">

            <!-- FREE -->
            <div class="plan-card">
                <h3>Free</h3>
                <p class="plan-price">₹0<span>/month</span></p>
                <p class="plan-desc">Best for getting started</p>

                <ul class="plan-features">
                    <li>✔ Basic profile</li>
                    <li>✔ Browse developers/projects</li>
                    <li>✔ Limited search</li>
                    <li>✖ Direct messaging</li>
                    <li>✖ Priority visibility</li>
                </ul>

                <?php if ($currentPlan === 'free'): ?>
                    <button class="btn-outline" disabled>Current Plan</button>
                <?php else: ?>
                    <button class="btn-outline">Downgrade</button>
                <?php endif; ?>
            </div>

            <!-- PRO -->
            <div class="plan-card featured">
                <span class="badge">Most Popular</span>
                <h3>Pro</h3>
                <p class="plan-price">₹199<span>/month</span></p>
                <p class="plan-desc">For active clients & developers</p>

                <ul class="plan-features">
                    <li>✔ Full profile access</li>
                    <li>✔ Unlimited search</li>
                    <li>✔ Direct messaging</li>
                    <li>✔ Higher visibility</li>
                    <li>✔ Faster responses</li>
                </ul>

                <?php if ($currentPlan === 'pro'): ?>
                    <button class="btn-primary" disabled>Current Plan</button>
                <?php else: ?>
                    <a href="#" class="btn-primary">Upgrade to Pro</a>
                <?php endif; ?>
            </div>

            <!-- PREMIUM -->
            <div class="plan-card">
                <h3>Premium</h3>
                <p class="plan-price">₹999<span>/month</span></p>
                <p class="plan-desc">For agencies & power users</p>

                <ul class="plan-features">
                    <li>✔ Everything in Pro</li>
                    <li>✔ Featured listings</li>
                    <li>✔ Priority support</li>
                    <li>✔ Advanced analytics</li>
                    <li>✔ Early access features</li>
                </ul>

                <?php if ($currentPlan === 'premium'): ?>
                    <button class="btn-primary" disabled>Current Plan</button>
                <?php else: ?>
                    <a href="#" class="btn-primary">Go Premium</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<!-- ================= FINAL CTA ================= -->
<section class="final-cta">
    <div class="container">
        <?php if (!$isLoggedIn): ?>
            <h2>Ready to Get Started?</h2>
            <p>Create your free account and explore the marketplace.</p>
            <a href="/php-dev-marketplace/auth/signup.php" class="btn-primary">
                Create Free Account
            </a>
        <?php else: ?>
            <h2>Welcome Back 👋</h2>
            <p>Continue exploring the marketplace from your dashboard.</p>
            <a href="/php-dev-marketplace/" class="btn-primary">
                Go to Dashboard
            </a>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
