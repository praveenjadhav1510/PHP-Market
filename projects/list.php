<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$pageTitle = "Projects | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';

$userType = $_SESSION['user_type'] ?? 'guest';
$userId   = $_SESSION['user_id'] ?? null;
$query    = strtolower(trim($_GET['q'] ?? ''));

/* Fetch projects */
if ($userType === 'client' && $userId) {
    $stmt = $pdo->prepare("
        SELECT id, project_title, skills, budget_min, budget_max, status, logo_image 
        FROM projects 
        WHERE user_id = ? 
        ORDER BY id DESC
    ");
    $stmt->execute([$userId]);
} else {
    $stmt = $pdo->prepare("
        SELECT id, project_title, skills, budget_min, budget_max, status, logo_image 
        FROM projects 
        WHERE status IS NULL OR status != 'closed' 
        ORDER BY id DESC
    ");
    $stmt->execute();
}

$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once __DIR__ . '/../includes/hero.php'; ?>

<section class="projects-section">
    <div class="container">
        
        <div class="projects-header">
            <h2>Available Projects</h2>
            <p>Connect with top clients and start your next PHP project.</p>
        </div>

        <div class="project-grid">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $p): ?>
                    <?php
                        $skillsText = $p['skills'] ?? '';
                        if ($query && stripos($p['project_title'] . ' ' . $skillsText, $query) === false) {
                            continue;
                        }
                        
                        // Clean up skills into an array
                        $skillsArray = array_filter(array_map('trim', explode(',', $skillsText)));
                    ?>

                    <article class="project-card">
                        <div class="project-logo-wrap">
                            <?php if (!empty($p['logo_image'])): ?>
                                <img src="/php-dev-marketplace/uploads/logos/<?= htmlspecialchars($p['logo_image']) ?>" 
                                     class="project-logo" alt="Company Logo">
                            <?php else: ?>
                                <div style="width:40px; height:40px; background: var(--color-bg-secondary); border-radius: 8px;"></div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($p['status']) && $p['status'] !== 'open'): ?>
                            <span class="status-badge">
                                <?= htmlspecialchars(strtoupper(str_replace('_', ' ', $p['status']))) ?>
                            </span>
                        <?php endif; ?>

                        <h3 class="project-title">
                            <?= htmlspecialchars($p['project_title']) ?>
                        </h3>

                        <div class="project-skills">
                            <?php foreach ($skillsArray as $skill): ?>
                                <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="project-footer">
                            <span class="project-budget">
                                ₹<?= number_format($p['budget_min']) ?> – ₹<?= number_format($p['budget_max']) ?>
                            </span>

                            <?php 
                                $link = "/php-dev-marketplace/projects/detail.php?id=" . $p['id'];
                                $btnText = "View & Apply";

                                if ($userType === 'guest') {
                                    $link = "/php-dev-marketplace/auth/login";
                                    $btnText = "Login to Apply";
                                } elseif ($userType === 'client') {
                                    $btnText = "Manage Project";
                                }
                            ?>
                            <a href="<?= $link ?>" class="project-btn"><?= $btnText ?></a>
                        </div>
                    </article>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-projects">
                    <p>No projects available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>