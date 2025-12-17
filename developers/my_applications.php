<?php
$pageTitle = "My Applications | Dashboard";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">

    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>

    <main class="dashboard-content">

        <h1>My Applications</h1>
        <p class="dash-subtitle">
            Track the projects you have applied for and their current status.
        </p>

        <div class="applications-list">

            <?php
            // ---------- STATIC APPLICATION DATA ----------
            $applications = [
                ['title' => 'HR Management System', 'company' => 'BusinessLabs', 'status' => 'Pending'],
                ['title' => 'Company Website Revamp', 'company' => 'BusinessLabs', 'status' => 'Reviewed'],
                ['title' => 'REST API Development', 'company' => 'BusinessLabs', 'status' => 'Accepted'],
                ['title' => 'CRM System', 'company' => 'BusinessLabs', 'status' => 'Pending'],
                ['title' => 'E-commerce Backend', 'company' => 'BusinessLabs', 'status' => 'Rejected'],
                ['title' => 'Payroll Management Tool', 'company' => 'BusinessLabs', 'status' => 'Reviewed'],
                ['title' => 'Custom Admin Dashboard', 'company' => 'BusinessLabs', 'status' => 'Pending'],
                ['title' => 'WordPress Plugin Development', 'company' => 'BusinessLabs', 'status' => 'Accepted'],
                ['title' => 'API Integration Project', 'company' => 'BusinessLabs', 'status' => 'Reviewed'],
                ['title' => 'Internal Tool Automation', 'company' => 'BusinessLabs', 'status' => 'Pending'],
            ];
            ?>

            <?php foreach ($applications as $app): ?>
                <div class="application-card">

                    <div class="application-info">
                        <h3><?= htmlspecialchars($app['title']) ?></h3>
                        <p class="company-name"><?= htmlspecialchars($app['company']) ?></p>
                    </div>
                    <div class="application-card">
                        <div class="application-status status-<?= strtolower($app['status']) ?>">
                            <?= $app['status'] ?>
                        </div>
                        <div class="application-actions">
                            <a href="#" class="btn-outline">View Project</a>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </main>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
