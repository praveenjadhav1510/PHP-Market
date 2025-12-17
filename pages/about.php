<?php
session_start();
$pageTitle = "About Us | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';
?>

<!-- ================= HERO SPLIT ================= -->
<section class="about-hero">
    <div class="container about-hero-grid">

        <div class="about-hero-text">
            <h1>About Us</h1>
            <p class="tagline">
                A focused PHP talent marketplace built by developers, for developers.
            </p>
        </div>

        <div class="about-hero-image">
            <img
                src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=800"
                alt="Praveen Jadhav"
            >
            <div class="founder-label">
                <strong>Praveen Jadhav</strong>
                <span>Co-Founder & Lead Developer</span>
            </div>
        </div>

    </div>
</section>

<!-- ================= FOUNDER MESSAGE ================= -->
<section class="content-section">
    <div class="container narrow">
        <p>
            PHP Dev Marketplace was created with a clear vision — to build a simple,
            transparent, and skill-focused platform where PHP developers and clients
            can connect without unnecessary complexity.
        </p>

        <p>
            As developers ourselves, we understand the challenges of finding the
            right projects and the right talent. This platform is our solution to
            that problem.
        </p>

        <p class="signature">
            — Praveen Jadhav<br>
            <span>Co-Founder & Lead Developer</span>
        </p>
    </div>
</section>

<!-- ================= LEADERSHIP ================= -->
<section class="leaders">
    <div class="container">
        <h2>Our Leadership</h2>

        <div class="leaders-list">

            <div class="leader-card">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400" alt="Praveen Jadhav">
                <div>
                    <h3>Praveen Jadhav</h3>
                    <span>Co-Founder & Full Stack Developer</span>
                    <p>
                        Responsible for architecture, backend systems,
                        frontend design, and overall platform development.
                    </p>
                </div>
            </div>

            <div class="leader-card">
                <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=400" alt="Samart G">
                <div>
                    <h3>Samart G</h3>
                    <span>Co-Founder</span>
                    <p>
                        Contributes to product planning, feature ideation,
                        and platform strategy.
                    </p>
                </div>
            </div>

            <div class="leader-card">
                <img src="https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?w=400" alt="Kartik R">
                <div>
                    <h3>Kartik R</h3>
                    <span>Co-Founder</span>
                    <p>
                        Focuses on testing, workflows, and improving
                        user experience.
                    </p>
                </div>
            </div>

            <div class="leader-card">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400" alt="Ganesh S">
                <div>
                    <h3>Ganesh S</h3>
                    <span>Co-Founder</span>
                    <p>
                        Supports documentation, research, and
                        operational improvements.
                    </p>
                </div>
            </div>

            <div class="leader-card">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400" alt="Vaishnavi J">
                <div>
                    <h3>Vaishnavi J</h3>
                    <span>Co-Founder</span>
                    <p>
                        Provides UX feedback, design insights,
                        and quality review.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="journey">
    <div class="container journey-grid">
        <div>
            <h2>Start your journey</h2>
            <p>
                Whether you’re hiring PHP developers or looking for meaningful
                projects, PHP Dev Marketplace is built for you.
            </p>

            <div class="journey-actions">
                <a href="/php-dev-marketplace/developers/list.php" class="btn-primary">
                    Find Developers
                </a>
                <a href="/php-dev-marketplace/auth/signup.php" class="btn-outline">
                    Join Now
                </a>
            </div>
        </div>

        <div class="journey-image">
            <img
                src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800"
                alt="Work together"
            >
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
