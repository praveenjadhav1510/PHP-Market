<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$pageTitle = "Marketplace | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';

$query = strtolower(trim($_GET['q'] ?? ''));
$userType = $_SESSION['user_type'] ?? 'guest';
$userId   = $_SESSION['user_id'] ?? null;

/**
 * Helper: search filter
 */
function matchesText($text, $query) {
    if (!$query) return true;
    return strpos(strtolower($text), $query) !== false;
}

/**
 * Fetch projects
 * - Developers & guests: all open / in-progress projects
 * - Clients: only their own projects
 */
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

$projects = $stmt->fetchAll();
?>

<?php require_once __DIR__ . '/../includes/hero.php'; ?>

<section class="featured-devs">
    <div class="container">

        <h2>Available Projects</h2>
        <p>Browse projects posted by clients</p>

        <div class="dev-grid">
            <?php foreach ($projects as $p): ?>
                <?php
                $skillsText = $p['skills'] ?? '';
                if (!matchesText($p['project_title'] . ' ' . $skillsText, $query)) {
                    continue;
                }
                ?>

                <div class="dev-card">
                    <?php if (!empty($p['logo_image'])): ?>
                        <img src="/php-dev-marketplace/uploads/logos/<?= htmlspecialchars($p['logo_image']) ?>"
                             alt="Project Logo">
                    <?php endif; ?>

                    <h3><?= htmlspecialchars($p['project_title']) ?></h3>

                    <?php if (!empty($p['status']) && $p['status'] !== 'open'): ?>
                        <p class="in-process">
                            Status: <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $p['status']))) ?>
                        </p>
                    <?php endif; ?>

                    <p><strong>Skills:</strong> <?= htmlspecialchars(strtoupper($skillsText)) ?></p>
                    <span><strong>Budget:</strong> ₹<?= (int)$p['budget_min'] ?> – ₹<?= (int)$p['budget_max'] ?></span>

                    <?php if ($userType === 'developer'): ?>
                        <a href="/php-dev-marketplace/projects/detail.php?id=<?= $p['id'] ?>"
                           class="btn-outline cd-btn">
                            View & Apply
                        </a>
                    <?php elseif ($userType === 'guest'): ?>
                        <a href="/php-dev-marketplace/auth/login"
                           class="btn-outline cd-btn">
                            Login to Apply
                        </a>
                    <?php else: ?>
                        <a href="/php-dev-marketplace/projects/detail.php?id=<?= $p['id'] ?>"
                           class="btn-outline cd-btn">
                            View Project
                        </a>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

            <?php if (!$projects): ?>
                <p>No projects available right now.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
