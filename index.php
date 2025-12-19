<?php
// index.php
$pageTitle = "Hire PHP Developers | PHP Dev Marketplace";
require_once __DIR__ . '/includes/header.php';
?>
<!-- ================= HERO SECTION ================= -->

<?php require_once __DIR__ . '/includes/hero.php'; ?>

<!-- ================= HOW IT WORKS ================= -->
<section class="how-it-works">
    <div class="container">
        <h2><i class="fa-solid fa-person-digging"></i> How It Works</h2>

        <div class="steps">
            <div class="step">
                <h3>1. Post a Project</h3>
                <p>
                    Describe your project, required PHP skills, budget, and timeline.
                </p>
            </div>

            <div class="step">
                <h3>2. Get Developer Matches</h3>
                <p>
                    Receive proposals from verified and rated PHP developers.
                </p>
            </div>

            <div class="step">
                <h3>3. Hire & Build</h3>
                <p>
                    Choose the best developer and start building immediately.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FEATURED DEVELOPERS ================= -->
<section class="featured-devs">
    <div class="container">
        <h2><i class="fa-solid fa-laptop-code"></i> Featured PHP Developers</h2>

        <div class="dev-grid">
            <!-- Static for now, dynamic later -->
            <div class="dev-card">
                <h3>Rahul Sharma</h3>
                <p>Senior PHP & Laravel Developer</p>
                <span>₹800/hr · ★ 4.9</span>
            </div>

            <div class="dev-card premium">
                <h3>Neha Patel</h3>
                <p>Backend & API Specialist</p>
                <span>₹1200/hr · ★ 5.0</span>
            </div>

            <div class="dev-card">
                <h3>Amit Verma</h3>
                <p>WordPress & PHP Developer</p>
                <span>₹600/hr · ★ 4.7</span>
            </div>
        </div>
    </div>
</section>

<!-- ================= BROWSE BY SKILL ================= -->
<section class="categories">
    <div class="container">
        <h2><i class="fa-solid fa-fill-drip"></i> Browse Developers by Skill</h2>

        <div class="category-grid">
            <a href="/php-dev-marketplace/developers/list.php?q=php">PHP Core</a>
            <a href="/php-dev-marketplace/developers/list.php?q=laravel">Laravel</a>
            <a href="/php-dev-marketplace/developers/list.php?q=wordpress">WordPress</a>
            <a href="/php-dev-marketplace/developers/list.php?q=api">API Development</a>
            <a href="/php-dev-marketplace/developers/list.php?q=mysql">MySQL</a>
        </div>
    </div>
</section>

<!-- ================= TESTIMONIALS ================= -->
<section class="testimonials">
    <div class="container">
        <h2><i class="fa-solid fa-ear-listen"></i> What Clients Say</h2>

        <div class="testimonial-grid">
            <div class="testimonial">
                <p>
                    “We hired a Laravel developer within 24 hours. 
                    The process was smooth and transparent.”
                </p>
                <strong>— Startup Founder</strong>
            </div>

            <div class="testimonial">
                <p>
                    “Clear pricing, skilled developers, and fast delivery. 
                    Highly recommended marketplace.”
                </p>
                <strong>— Project Manager</strong>
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
