<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/plan-check.php';
require_once __DIR__ . '/../includes/header.php';

$projectId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($projectId <= 0) {
    echo "<p>Invalid project.</p>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$isLoggedIn = isset($_SESSION['user_id']);
$userId     = $_SESSION['user_id'] ?? null;
$userType   = $_SESSION['user_type'] ?? 'guest';
$currentPlan = $isLoggedIn ? getCurrentPlan() : 'free';

$message = '';
$error   = '';

// ---------- FETCH PROJECT ----------
$stmt = $pdo->prepare("
    SELECT p.*, u.name AS client_name
    FROM projects p
    JOIN users u ON p.user_id = u.id
    WHERE p.id = ?
");
$stmt->execute([$projectId]);
$project = $stmt->fetch();

if (!$project) {
    echo "<p>Project not found.</p>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$isOwner = $isLoggedIn && $userType === 'client' && $project['user_id'] == $userId;

// ---------- HANDLE POST ACTIONS ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $action = $_POST['action'] ?? '';

    // Developer applies for project
    if ($action === 'apply' && $userType === 'developer') {
        // Check plan limit first
        if (!canPerformAction('apply_project', $userId)) {
            $remaining = getRemainingApplications($userId, $currentPlan);
            $error = "You've reached your application limit for the " . ucfirst($currentPlan) . " plan. ";
            if ($remaining !== 'Unlimited') {
                $error .= "Upgrade to Pro or Premium for more applications.";
            }
        } else {
            $proposal       = trim($_POST['proposal'] ?? '');
            $expectedBudget = (int) ($_POST['expected_budget'] ?? 0);
            $expectedDays   = (int) ($_POST['expected_days'] ?? 0);

            if (!$proposal) {
                $error = "Proposal is required.";
            } elseif ($project['user_id'] == $userId) {
                $error = "You cannot apply to your own project.";
            } else {
                // Check if already applied
                $check = $pdo->prepare("
                    SELECT id FROM project_applications
                    WHERE project_id = ? AND developer_id = ?
                ");
                $check->execute([$projectId, $userId]);
                if ($check->fetch()) {
                    $error = "You have already applied to this project.";
                } else {
                    $insert = $pdo->prepare("
                        INSERT INTO project_applications
                        (project_id, developer_id, proposal, expected_budget, expected_days)
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $insert->execute([$projectId, $userId, $proposal, $expectedBudget ?: null, $expectedDays ?: null]);
                    $message = "Application submitted successfully.";
                }
            }
        }
    }

    // Client approves developer application
    if ($action === 'approve' && $isOwner) {
        $applicationId = (int) ($_POST['application_id'] ?? 0);

        // Get application, ensure belongs to this project
        $appStmt = $pdo->prepare("
            SELECT * FROM project_applications
            WHERE id = ? AND project_id = ?
        ");
        $appStmt->execute([$applicationId, $projectId]);
        $app = $appStmt->fetch();

        if (!$app) {
            $error = "Application not found.";
        } else {
            // Check if assignment already exists
            $assignCheck = $pdo->prepare("SELECT id FROM project_assignments WHERE project_id = ?");
            $assignCheck->execute([$projectId]);
            if ($assignCheck->fetch()) {
                $error = "A developer is already assigned to this project.";
            } else {
                // Approve this application, reject others
                $pdo->beginTransaction();
                try {
                    $pdo->prepare("
                        UPDATE project_applications
                        SET status = 'approved'
                        WHERE id = ?
                    ")->execute([$applicationId]);

                    $pdo->prepare("
                        UPDATE project_applications
                        SET status = 'rejected'
                        WHERE project_id = ? AND id != ?
                    ")->execute([$projectId, $applicationId]);

                    // Create assignment
                    $pdo->prepare("
                        INSERT INTO project_assignments (project_id, developer_id)
                        VALUES (?, ?)
                    ")->execute([$projectId, $app['developer_id']]);

                    // Update project status
                    $pdo->prepare("
                        UPDATE projects SET status = 'in_progress' WHERE id = ?
                    ")->execute([$projectId]);

                    $pdo->commit();
                    $message = "Developer approved and project marked as in progress.";
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $error = "Failed to approve developer.";
                }
            }
        }
    }

    // Developer marks project completed
    if ($action === 'mark_completed' && $userType === 'developer') {
        $assignStmt = $pdo->prepare("
            SELECT * FROM project_assignments
            WHERE project_id = ? AND developer_id = ? AND status = 'in_progress'
        ");
        $assignStmt->execute([$projectId, $userId]);
        $assignment = $assignStmt->fetch();

        if (!$assignment) {
            $error = "You are not assigned to this project or it's already completed.";
        } else {
            $pdo->beginTransaction();
            try {
                $pdo->prepare("
                    UPDATE project_assignments
                    SET status = 'completed', completed_at = NOW()
                    WHERE id = ?
                ")->execute([$assignment['id']]);

                $pdo->prepare("
                    UPDATE projects SET status = 'completed' WHERE id = ?
                ")->execute([$projectId]);

                $pdo->commit();
                $message = "You marked this project as completed. Waiting for client confirmation.";
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Failed to mark project as completed.";
            }
        }
    }

    // Client confirms completion
    if ($action === 'confirm_completion' && $isOwner) {
        $pdo->prepare("
            UPDATE projects SET status = 'closed' WHERE id = ?
        ")->execute([$projectId]);
        $message = "Project closed successfully.";
    }

    // Re-fetch project after updates
    $stmt->execute([$projectId]);
    $project = $stmt->fetch();
}

// ---------- FETCH APPLICATIONS (FOR CLIENT VIEW) ----------
$applications = [];
if ($isOwner) {
    $appsStmt = $pdo->prepare("
        SELECT pa.*, u.name AS developer_name, u.email AS developer_email
        FROM project_applications pa
        JOIN users u ON pa.developer_id = u.id
        WHERE pa.project_id = ?
        ORDER BY pa.created_at DESC
    ");
    $appsStmt->execute([$projectId]);
    $applications = $appsStmt->fetchAll();
}

// ---------- FETCH ASSIGNMENT ----------
$assignmentStmt = $pdo->prepare("
    SELECT pa.*, u.name AS developer_name
    FROM project_assignments pa
    JOIN users u ON pa.developer_id = u.id
    WHERE pa.project_id = ?
");
$assignmentStmt->execute([$projectId]);
$assignment = $assignmentStmt->fetch();

// ---------- CHECK DEV APPLICATION (for current dev) ----------
$devApplication = null;
if ($isLoggedIn && $userType === 'developer') {
    $devAppStmt = $pdo->prepare("
        SELECT * FROM project_applications
        WHERE project_id = ? AND developer_id = ?
    ");
    $devAppStmt->execute([$projectId, $userId]);
    $devApplication = $devAppStmt->fetch();
}
?>

<section class="project-detail">
    <div class="container">
        <h1><?= htmlspecialchars($project['project_title']) ?></h1>
        <p class="company-name">Client: <?= htmlspecialchars($project['client_name']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars(ucfirst($project['status'] ?? 'open')) ?></p>
        <p><strong>Budget:</strong> ₹<?= (int)$project['budget_min'] ?> - ₹<?= (int)$project['budget_max'] ?></p>
        <p><strong>Deadline:</strong> <?= htmlspecialchars($project['deadline']) ?></p>

        <div class="project-description">
            <?= nl2br(htmlspecialchars($project['project_description'])) ?>
        </div>

        <?php if ($message): ?>
            <div class="success-msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- ASSIGNMENT SUMMARY -->
        <?php if ($assignment): ?>
            <div class="assignment-box">
                <h2>Assigned Developer</h2>
                <p><?= htmlspecialchars($assignment['developer_name']) ?></p>
                <p>Status: <?= htmlspecialchars(ucfirst($assignment['status'])) ?></p>
            </div>
        <?php endif; ?>

        <!-- DEVELOPER ACTIONS -->
        <?php if ($userType === 'developer'): ?>
            <h2>Developer Actions</h2>

            <?php if ($project['user_id'] == $userId): ?>
                <p>You are the client for this project.</p>
            <?php else: ?>
                <?php 
                $remainingApps = $isLoggedIn ? getRemainingApplications($userId, $currentPlan) : 0;
                $canApply = $isLoggedIn && canPerformAction('apply_project', $userId);
                ?>
                <?php if (!$devApplication && ($project['status'] ?? 'open') === 'open'): ?>
                    <?php if (!$canApply): ?>
                        <div style="background: #fff3cd; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #ffc107;">
                            <strong>⚠ Application Limit Reached</strong>
                            <p>You've reached your application limit for the <?= ucfirst($currentPlan) ?> plan.</p>
                            <a href="/php-dev-marketplace/dashboard/upgrade" class="btn-primary" style="margin-top: 0.5rem;">Upgrade Plan</a>
                        </div>
                    <?php else: ?>
                        <?php if ($remainingApps !== 'Unlimited'): ?>
                            <div style="background: #e3f2fd; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; color: #1e1e1e;">
                                <strong>Plan Limit:</strong> You have <?= $remainingApps ?> application<?= $remainingApps != 1 ? 's' : '' ?> remaining on your <?= ucfirst($currentPlan) ?> plan.
                            </div>
                        <?php endif; ?>
                        <h2>Apply to this project</h2>
                        <form method="POST">
                            <input type="hidden" name="action" value="apply">
                            <div class="form-group">
                                <label>Your Proposal *</label>
                                <textarea name="proposal" rows="4" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Expected Budget (₹)</label>
                                    <input type="number" name="expected_budget">
                                </div>
                                <div class="form-group">
                                    <label>Expected Days</label>
                                    <input type="number" name="expected_days">
                                </div>
                            </div>
                            <button type="submit" class="btn-primary">Submit Application</button>
                        </form>
                    <?php endif; ?>
                <?php elseif ($devApplication): ?>
                    <p>Your application status: <strong><?= htmlspecialchars(ucfirst($devApplication['status'])) ?></strong></p>
                <?php endif; ?>

                <?php if ($assignment && $assignment['developer_id'] == $userId && $assignment['status'] === 'in_progress'): ?>
                    <form method="POST" style="margin-top:1rem;">
                        <input type="hidden" name="action" value="mark_completed">
                        <button type="submit" class="btn-primary">
                            Mark as Completed
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- CLIENT ACTIONS / APPLICATIONS -->
        <?php if ($isOwner): ?>
            <h2>Applications</h2>

            <?php if (!$applications): ?>
                <p>No applications yet.</p>
            <?php endif; ?>

            <?php foreach ($applications as $app): ?>
                <div class="application-card">
                    <div>
                        <h3><?= htmlspecialchars($app['developer_name']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($app['proposal'])) ?></p>
                        <p>
                            Budget: <?= $app['expected_budget'] ? '₹' . (int)$app['expected_budget'] : 'Not specified' ?>
                            · Days: <?= $app['expected_days'] ?: 'Not specified' ?>
                        </p>
                        <p>Status: <strong><?= htmlspecialchars(ucfirst($app['status'])) ?></strong></p>
                    </div>

                    <?php if (!$assignment && $app['status'] === 'applied' && ($project['status'] ?? 'open') === 'open'): ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="approve">
                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                            <button type="submit" class="btn-primary">Approve & Assign</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if ($assignment && ($project['status'] ?? '') === 'completed'): ?>
                <form method="POST" style="margin-top:1rem;">
                    <input type="hidden" name="action" value="confirm_completion">
                    <button type="submit" class="btn-primary">
                        Confirm Completion & Close Project
                    </button>
                </form>
            <?php endif; ?>

        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
            <p style="margin-top:2rem;">
                <a href="/php-dev-marketplace/auth/login" class="btn-primary">Login to apply</a>
            </p>
        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


