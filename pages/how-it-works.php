<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>How It Works | PHP Dev Marketplace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
</head>
<body>

<!-- ================= PAGE HERO ================= -->
<section class="page-hero">
    
    <div class="container">
        <div class="cover-image">
            <img src="/php-dev-marketplace/assets/images/how-it-works.jpg" alt="privacy-image"/>
            <h1> How It Works <i class="fa-solid fa-stairs"></i></h1>
            <p class="updated">Last updated: <?= date('F Y') ?></p>
        </div>
        <h1>How PHP Dev Marketplace Works</h1>
        <p>
            A simple, transparent process to connect clients with skilled PHP developers
            and deliver projects efficiently.
        </p>
    </div>
</section>

<!-- ================= WORKFLOW ================= -->
<section class="how-it-works">
    <div class="container">
        <h2>Simple Workflow</h2>

        <div class="steps">
            <div class="step">
                <h3>1. Create an Account</h3>
                <p>
                    Sign up as a client or developer. Clients can post projects,
                    while developers can showcase skills and apply for work.
                </p>
            </div>

            <div class="step">
                <h3>2. Post a Project</h3>
                <p>
                    Clients describe project requirements, PHP technologies needed
                    (Laravel, WordPress, APIs, MySQL), budget, and timeline.
                </p>
            </div>

            <div class="step">
                <h3>3. Get Developer Proposals</h3>
                <p>
                    Verified PHP developers review your project and submit proposals
                    with pricing, timelines, and expertise.
                </p>
            </div>

            <div class="step">
                <h3>4. Hire & Collaborate</h3>
                <p>
                    Choose the best developer, communicate directly, and start
                    building your PHP project with confidence.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= BENEFITS ================= -->
<section class="benefits">
    <div class="container">
        <h2>Why Choose PHP Dev Marketplace?</h2>

        <div class="benefit-grid">
            <div class="benefit">
                <h3>Verified Developers</h3>
                <p>
                    All developers are reviewed and rated, ensuring quality,
                    reliability, and professional expertise.
                </p>
            </div>

            <div class="benefit">
                <h3>Fast Hiring Process</h3>
                <p>
                    Post a project and receive proposals quickly without long
                    hiring cycles or middlemen.
                </p>
            </div>

            <div class="benefit">
                <h3>Flexible Engagement</h3>
                <p>
                    Hire developers for hourly work, fixed-price projects,
                    or long-term collaborations.
                </p>
            </div>

            <div class="benefit">
                <h3>Secure & Transparent</h3>
                <p>
                    Clear communication, project visibility, and secure
                    authentication make collaboration safe and smooth.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOR CLIENTS ================= -->
<section class="audience">
    <div class="container">
        <h2>For Clients</h2>
        <p>
            PHP Dev Marketplace helps businesses and individuals find the right
            PHP talent without technical complexity. Whether you need a small
            website update or a large-scale backend system, our platform connects
            you with skilled professionals who match your requirements.
        </p>
    </div>
</section>

<!-- ================= FOR DEVELOPERS ================= -->
<section class="audience alt">
    <div class="container">
        <h2>For Developers</h2>
        <p>
            Developers can discover relevant projects, apply based on skills,
            and build long-term client relationships. The platform provides
            visibility, flexibility, and opportunities to grow your PHP career.
        </p>
    </div>
</section>

<!-- ================= FINAL CTA ================= -->
<section class="final-cta">
    <div class="container">

        <?php
        $ctaText = "Create an Account";
        $ctaLink = "/php-dev-marketplace/auth/signup.php";
        $ctaNote = "New here? Join for free.";

        if (isset($_SESSION['user_id'])) {
            $ctaText = "Go to Dashboard";
            $ctaLink = "/php-dev-marketplace/dashboard";
            $ctaNote = "You’re already logged in.";
        }
        ?>

        <h2>Ready to Continue?</h2>
        <p>
            Connect with PHP developers or manage your projects easily.
        </p>

        <div class="cta-row">
            <a href="<?= $ctaLink ?>" class="btn-primary">
                <?= $ctaText ?>
            </a>

            <span class="cta-note">
                <?= $ctaNote ?>
            </span>
        </div>

    </div>
</section>


<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
