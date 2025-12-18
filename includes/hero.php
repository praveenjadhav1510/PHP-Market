<section class="hero">
    <div class="container hero-grid">
        <div class="hero-text">

            <?php
            $isLoggedIn = isset($_SESSION['user_id']);
            $userType  = $_SESSION['user_type'] ?? 'guest';

            /* ================= DEFAULT (GUEST) ================= */
            $heroTitle    = "Find Skilled PHP Developers Instantly";
            $heroSubtitle = "Login to post projects or connect with verified PHP developers.";
            $searchAction = "/php-dev-marketplace/auth/login";
            $searchName   = "redirect";
            $searchPlaceholder = "Login to search developers or projects";
            $primaryCtaText = "Signup to Continue";
            $primaryCtaLink = "/php-dev-marketplace/auth/signup";

            /* ================= CLIENT ================= */
            if ($isLoggedIn && $userType === 'client') {
                $heroTitle    = "Post Your Project & Hire PHP Developers";
                $heroSubtitle = "Share your requirements and receive proposals from experienced PHP developers.";
                $searchAction = "/php-dev-marketplace/developers/list";
                $searchName   = "q";
                $searchPlaceholder = "Search developers by skill, experience, or budget...";
                $primaryCtaText = "Post a Project";
                $primaryCtaLink = "/php-dev-marketplace/clients/create_project";
            }

            /* ================= DEVELOPER ================= */
            if ($isLoggedIn && $userType === 'developer') {
                $heroTitle    = "Find PHP Projects That Match Your Skills";
                $heroSubtitle = "Browse live projects, apply instantly, and grow your freelance career.";
                $searchAction = "/php-dev-marketplace/projects/list";
                $searchName   = "q";
                $searchPlaceholder = "Search projects by PHP, Laravel, or budget...";
                $primaryCtaText = "Browse Projects";
                $primaryCtaLink = "/php-dev-marketplace/developers/list";
            }
            ?>

            <!-- HERO CONTENT -->
            <h1><?= htmlspecialchars($heroTitle) ?></h1>
            <p><?= htmlspecialchars($heroSubtitle) ?></p>

            <!-- SEARCH -->
            <form action="<?= $searchAction ?>" method="GET" class="hero-search">
                <input
                    type="text"
                    name="<?= $searchName ?>"
                    placeholder="<?= htmlspecialchars($searchPlaceholder) ?>"
                    <?= !$isLoggedIn ? 'disabled' : '' ?>
                >
                <button type="submit">
                    <?= $isLoggedIn ? 'Search' : 'Login' ?>
                </button>
            </form>

            <!-- CTA -->
            <div class="hero-cta">
                <a href="<?= $primaryCtaLink ?>" class="btn-primary">
                    <?= $primaryCtaText ?>
                </a>

                <?php if ($isLoggedIn && $userType === 'client'): ?>
                    <a href="/php-dev-marketplace/developers/list" class="btn-outline">
                        Browse Developers
                    </a>
                <?php elseif ($isLoggedIn && $userType === 'developer'): ?>
                    <a href="/php-dev-marketplace/dashboard" class="btn-outline">
                        Go to Dashboard
                    </a>
                <?php endif; ?>
            </div>

        </div>

        <!-- IMAGE -->
        <div class="hero-image">
            <img
                src="/php-dev-marketplace/assets/images/hero-dev.png"
                alt="PHP Marketplace"
            >
        </div>
    </div>
</section>
