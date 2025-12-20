<?php
// index.php
session_start();
require_once __DIR__ . '/config/db.php';
$pageTitle = "Hire PHP Developers | PHP Dev Marketplace";
require_once __DIR__ . '/includes/header.php';

// Fetch recent 3 developers from database
$devStmt = $pdo->prepare("
    SELECT u.id, u.name, u.email, dp.primary_skill, dp.skills, dp.experience, dp.rate, dp.avatar
    FROM users u
    INNER JOIN developer_profiles dp ON dp.user_id = u.id
    WHERE u.user_type = 'developer'
    ORDER BY u.id DESC
    LIMIT 3
");
$devStmt->execute();
$featuredDevelopers = $devStmt->fetchAll();
?>
<!-- ================= HERO SECTION ================= -->

<?php require_once __DIR__ . '/includes/hero.php'; ?>

<!-- ================= HOW IT WORKS ================= -->
<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2><i class="fa-solid fa-gear"></i> How It Works</h2>
            <p class="section-subtitle">Simple steps to connect with the best PHP developers</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-icon">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span class="step-number">1</span>
                </div>
                <h3>Post a Project</h3>
                <p>
                    Describe your project, required PHP skills, budget, and timeline. Our platform makes it easy to get started.
                </p>
            </div>

            <div class="step">
                <div class="step-icon">
                    <i class="fa-solid fa-users"></i>
                    <span class="step-number">2</span>
                </div>
                <h3>Get Developer Matches</h3>
                <p>
                    Receive proposals from verified and rated PHP developers. Review profiles, portfolios, and expertise.
                </p>
            </div>

            <div class="step">
                <div class="step-icon">
                    <i class="fa-solid fa-handshake"></i>
                    <span class="step-number">3</span>
                </div>
                <h3>Hire & Build</h3>
                <p>
                    Choose the best developer and start building immediately. Collaborate seamlessly through our platform.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FEATURED DEVELOPERS ================= -->
<section class="featured-devs">
    <div class="container">
        <h2><i class="fa-solid fa-laptop-code"></i> Featured PHP Developers</h2>
        <p class="section-subtitle">Connect with our latest registered developers</p>

        <div class="dev-grid">
            <?php if (empty($featuredDevelopers)): ?>
                <p>No developers available at the moment. Check back soon!</p>
            <?php else: ?>
                <?php foreach ($featuredDevelopers as $dev): ?>
                    <?php
                    $skills = json_decode($dev['skills'], true) ?? [];
                    $skillsText = !empty($skills) ? implode(', ', array_slice($skills, 0, 3)) : ($dev['primary_skill'] ?? 'PHP Developer');
                    ?>
                    <div class="dev-card">
                        <div class="dev-info">
                            <?php if (!empty($dev['avatar'])): ?>
                                <img src="/php-dev-marketplace/uploads/avatars/<?= htmlspecialchars($dev['avatar']) ?>"
                                    alt="Developer Avatar">
                            <?php else: ?>
                                <div class="dev-avatar-placeholder">
                                    <?= strtoupper(substr($dev['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <h3><i class="fa-solid fa-user-graduate"></i> <?= htmlspecialchars($dev['name']) ?></h3>
                        </div>
                        <p><?= htmlspecialchars(ucfirst($dev['primary_skill'] ?? 'PHP')) ?> Developer</p>
                        <?php if ($dev['rate']): ?>
                            <span>₹<?= (int)$dev['rate'] ?>/hr</span>
                        <?php endif; ?>
                        <?php if ($dev['experience']): ?>
                            <p>
                                <strong>Experience:</strong>
                                <span><?= (int)$dev['experience'] ?> years</span>
                            </p>
                        <?php endif; ?>
                        <?php if ($skillsText): ?>
                            <p style="margin-top:0.5rem;font-size:0.9em;color:var(--text-muted);">
                                <strong>Skills:</strong>
                                <span><?= htmlspecialchars($skillsText) ?></span>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= BROWSE BY SKILL ================= -->
<section class="categories">
    <div class="container">
        <div class="section-header">
            <h2><i class="fa-solid fa-code"></i> Browse Developers by Skill</h2>
            <p class="section-subtitle">Find developers specialized in the technologies you need</p>
        </div>

        <div class="category-grid">
            <a href="/php-dev-marketplace/developers/list.php?q=php" class="skill-card skill-php">
                <div class="skill-icon">
                    <i class="fa-brands fa-php"></i>
                </div>
                <h3>PHP Core</h3>
                <p>Core PHP developers</p>
            </a>

            <a href="/php-dev-marketplace/developers/list.php?q=laravel" class="skill-card skill-laravel">
                <div class="skill-icon">
                    <i class="fa-brands fa-laravel"></i>
                </div>
                <h3>Laravel</h3>
                <p>Laravel framework experts</p>
            </a>

            <a href="/php-dev-marketplace/developers/list.php?q=wordpress" class="skill-card skill-wordpress">
                <div class="skill-icon">
                    <i class="fa-brands fa-wordpress"></i>
                </div>
                <h3>WordPress</h3>
                <p>WordPress specialists</p>
            </a>

            <a href="/php-dev-marketplace/developers/list.php?q=api" class="skill-card skill-api">
                <div class="skill-icon">
                    <i class="fa-solid fa-plug"></i>
                </div>
                <h3>API Development</h3>
                <p>REST API & integrations</p>
            </a>

            <a href="/php-dev-marketplace/developers/list.php?q=mysql" class="skill-card skill-mysql">
                <div class="skill-icon">
                    <i class="fa-solid fa-database"></i>
                </div>
                <h3>MySQL</h3>
                <p>Database experts</p>
            </a>
        </div>
    </div>
</section>

<!-- ================= RANKING & TRUST ================= -->
<section class="trust-section">
    <div class="container">
        <div class="section-header">
            <h2><i class="fa-solid fa-shield-halved"></i> Trusted & Ranked Platform</h2>
            <p class="section-subtitle">Why businesses and developers trust our marketplace</p>
        </div>

        <div class="trust-grid">
            <div class="trust-card">
                <div class="trust-icon">
                    <i class="fa-solid fa-award"></i>
                </div>
                <h3>Top Ranked</h3>
                <p class="trust-stat">#1 PHP Marketplace</p>
                <p>Ranked among the best platforms for connecting PHP talent with projects</p>
            </div>

            <div class="trust-card">
                <div class="trust-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3>100% Verified</h3>
                <p class="trust-stat">All Developers Verified</p>
                <p>Every developer profile is verified to ensure authenticity and quality</p>
            </div>

            <div class="trust-card">
                <div class="trust-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h3>Secure Platform</h3>
                <p class="trust-stat">SSL Encrypted</p>
                <p>Your data and transactions are protected with enterprise-grade security</p>
            </div>

            <div class="trust-card">
                <div class="trust-icon">
                    <i class="fa-solid fa-star"></i>
                </div>
                <h3>Trusted by 1000+</h3>
                <p class="trust-stat">Active Users</p>
                <p>Join thousands of developers and clients building successful projects</p>
            </div>
        </div>
    </div>
</section>

<?php if (!isset($_SESSION['user_id'])): ?>
<section class="join-section">
    <div class="join-container">

        <h2>Join PHP Dev Marketplace</h2>
        <p class="join-subtitle">
            Choose how you want to use the platform
        </p>

        <div class="join-cards">

            <!-- DEVELOPER -->
            <div class="join-card developer">
                <div class="join-icon"><i class="fa-solid fa-laptop-code"></i></div>

                <h3>I'm a Developer</h3>
                <p>
                    Showcase your PHP skills, get discovered, and apply to real-world projects.
                </p>

                <a href="/php-dev-marketplace/auth/signup.php?type=developer"
                   class="btn-primary full-width">
                    Create Developer Profile
                </a>
            </div>

            <!-- BUSINESS -->
            <div class="join-card business">
                <div class="join-icon"><i class="fa-solid fa-building"></i></div>

                <h3>I'm a Business</h3>
                <p>
                    Post projects, browse verified developers, and hire the right talent all at one place.
                </p>

                <a href="/php-dev-marketplace/auth/signup.php?type=client"
                   class="btn-primary full-width">
                    Create Business Account
                </a>
            </div>

        </div>

        <p class="join-footer">
            Already have an account?
            <a href="/php-dev-marketplace/auth/login.php">Log in</a>
        </p>

    </div>
</section>
<?php endif; ?>

<!-- ================= FINAL CTA ================= -->
<section class="final-cta">
    <div class="container">
        <h2>Ready to Start Your PHP Project?</h2>
        <p>
            Join now and connect with skilled PHP developers today.
        </p>

        <a href="/php-dev-marketplace/join" class="btn-primary">
            Get Started <i class="fa-solid fa-boxes-packing"></i>
        </a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
