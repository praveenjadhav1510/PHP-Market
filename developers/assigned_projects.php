<?php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';

if (($_SESSION['user_type'] ?? null) !== 'developer') {
    header("Location: /php-dev-marketplace/dashboard");
    exit;
}

$pageTitle = "Assigned Projects | Dashboard";
require_once __DIR__ . '/../includes/header.php';

$developerId = $_SESSION['user_id'];

// Fetch projects where this developer is assigned
$stmt = $pdo->prepare("
    SELECT pa.id AS assignment_id,
           pa.status AS assignment_status,
           pa.started_at,
           pa.completed_at,
           p.id   AS project_id,
           p.project_title,
           p.project_description,
           p.budget_min,
           p.budget_max,
           p.deadline,
           p.status AS project_status,
           p.logo_image
    FROM project_assignments pa
    JOIN projects p ON pa.project_id = p.id
    WHERE pa.developer_id = ?
    ORDER BY pa.started_at DESC
");
$stmt->execute([$developerId]);
$assignedProjects = $stmt->fetchAll();
?>

<div class="dashboard-layout">

    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>

    <main class="dashboard-content">
        <h1>Assigned Projects</h1>
        <p class="dash-subtitle">
            Projects you are currently working on or have completed.
        </p>

        <div class="projects-grid">
            <?php if (!$assignedProjects): ?>
                <p>You do not have any assigned projects yet.</p>
            <?php endif; ?>

            <?php foreach ($assignedProjects as $ap): ?>
                <div class="project-card">
                    <div class="project-header">
                        <?php if (!empty($ap['logo_image'])): ?>
                            <img
                                src="/php-dev-marketplace/uploads/logos/<?= htmlspecialchars($ap['logo_image']) ?>"
                                alt="Project Logo"
                                class="company-logo"
                            >
                        <?php endif; ?>
                        <div>
                            <h3><?= htmlspecialchars($ap['project_title']) ?></h3>
                            <p class="company-name">
                                Project status: <?= htmlspecialchars(ucfirst($ap['project_status'] ?? 'open')) ?>
                            </p>
                            <p>
                                Assignment status: <?= htmlspecialchars(ucfirst($ap['assignment_status'])) ?>
                            </p>
                        </div>
                    </div>

                    <div class="project-meta">
                        <span><strong>Budget:</strong> ₹<?= (int)$ap['budget_min'] ?> - ₹<?= (int)$ap['budget_max'] ?></span>
                        <span><strong>Deadline:</strong> <?= htmlspecialchars($ap['deadline']) ?></span>
                    </div>

                    <p><?= nl2br(htmlspecialchars($ap['project_description'])) ?></p>

                    <div class="project-actions">
                        <a href="/php-dev-marketplace/projects/detail.php?id=<?= $ap['project_id'] ?>" class="btn-outline">
                            View Details
                        </a>
                        <?php if ($ap['assignment_status'] === 'in_progress'): ?>
                            <a href="/php-dev-marketplace/projects/detail.php?id=<?= $ap['project_id'] ?>" class="btn-primary">
                                Mark Completed
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>




