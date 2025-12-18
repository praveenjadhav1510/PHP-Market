<?php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';

if (($_SESSION['user_type'] ?? null) !== 'developer') {
    header("Location: /php-dev-marketplace/dashboard");
    exit;
}

$pageTitle = "My Applications | Dashboard";
require_once __DIR__ . '/../includes/header.php';

$developerId = $_SESSION['user_id'];

// Fetch all applications for this developer
$stmt = $pdo->prepare("
    SELECT pa.id,
           pa.status,
           pa.created_at,
           p.id   AS project_id,
           p.project_title,
           p.status AS project_status
    FROM project_applications pa
    JOIN projects p ON pa.project_id = p.id
    WHERE pa.developer_id = ?
    ORDER BY pa.created_at DESC
");
$stmt->execute([$developerId]);
$applications = $stmt->fetchAll();
?>

<div class="dashboard-layout">

    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>

    <main class="dashboard-content">

        <h1>My Applications</h1>
        <p class="dash-subtitle">
            Track the projects you have applied for and their current status.
        </p>

        <div class="applications-list">

            <?php if (!$applications): ?>
                <p>You haven’t applied for any projects yet. Browse projects and start applying.</p>
            <?php endif; ?>

            <?php foreach ($applications as $app): ?>
                <div class="application-card">

                    <div class="application-info">
                        <h3><?= htmlspecialchars($app['project_title']) ?></h3>
                        <p class="company-name">
                            Project status: <?= htmlspecialchars(ucfirst($app['project_status'] ?? 'open')) ?>
                        </p>
                    </div>

                    <div class="application-card">
                        <div class="application-status status-<?= strtolower($app['status']) ?>">
                            <?= ucfirst($app['status']) ?>
                        </div>
                        <div class="application-actions">
                            <a href="/php-dev-marketplace/projects/detail.php?id=<?= $app['project_id'] ?>" class="btn-outline">
                                View Project
                            </a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </main>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
