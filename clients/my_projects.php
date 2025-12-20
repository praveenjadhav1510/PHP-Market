<?php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';

// Only clients can access this page
if (($_SESSION['user_type'] ?? null) !== 'client') {
    header("Location: /php-dev-marketplace/dashboard");
    exit;
}

$pageTitle = "My Projects | Dashboard";
require_once __DIR__ . '/../includes/header.php';

$userId = $_SESSION['user_id'];
$message = '';
$error = '';

// ---------- HANDLE DELETE ----------
if (isset($_GET['delete'])) {
    $projectId = (int) $_GET['delete'];

    // Ensure project belongs to this client
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ? AND user_id = ?");
    $stmt->execute([$projectId, $userId]);

    if ($stmt->rowCount() > 0) {
        $message = "Project deleted successfully.";
    } else {
        $error = "Unable to delete project.";
    }
}

// ---------- HANDLE UPDATE ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    $projectId = (int) $_POST['project_id'];

    $title       = trim($_POST['project_title'] ?? '');
    $description = trim($_POST['project_description'] ?? '');
    $budgetMin   = (int) ($_POST['budget_min'] ?? 0);
    $budgetMax   = (int) ($_POST['budget_max'] ?? 0);
    $deadline    = $_POST['deadline'] ?? null;

    if (!$title || !$description || !$deadline) {
        $error = "Please fill all required fields.";
    } elseif ($budgetMin >= $budgetMax) {
        $error = "Budget max must be greater than budget min.";
    } else {
        $update = $pdo->prepare("
            UPDATE projects
            SET project_title = ?, project_description = ?, budget_min = ?, budget_max = ?, deadline = ?
            WHERE id = ? AND user_id = ?
        ");
        $update->execute([$title, $description, $budgetMin, $budgetMax, $deadline, $projectId, $userId]);

        if ($update->rowCount() > 0) {
            $message = "Project updated successfully.";
        } else {
            $error = "No changes were made or you are not allowed to edit this project.";
        }
    }
}

// ---------- FETCH CLIENT PROJECTS ----------
$stmt = $pdo->prepare("
    SELECT id, project_title, project_description, budget_min, budget_max, deadline, status, logo_image
    FROM projects
    WHERE user_id = ?
    ORDER BY id DESC
");
$stmt->execute([$userId]);
$projects = $stmt->fetchAll();

$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
?>

<div class="dashboard-layout">

    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>

    <main class="dashboard-content">

        <h1>My Projects</h1>
        <p class="dash-subtitle">
            Manage projects you have posted, review applications and track progress.
        </p>

        <?php if ($message): ?>
            <div class="success-msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="projects-grid">
            <?php if (!$projects): ?>
                <p>You haven’t posted any projects yet. <a href="/php-dev-marketplace/clients/create_project">Post your first project</a>.</p>
            <?php endif; ?>

            <?php foreach ($projects as $project): ?>
                <div class="project-card">

                    <div class="project-header">
                        <?php if (!empty($project['logo_image'])): ?>
                            <img
                                src="/php-dev-marketplace/uploads/logos/<?= htmlspecialchars($project['logo_image']) ?>"
                                alt="Company Logo"
                                class="company-logo"
                            >
                        <?php endif; ?>
                        <div>
                            <h3><?= htmlspecialchars($project['project_title']) ?></h3>
                            <p class="company-name">
                                Status: <?= htmlspecialchars(ucfirst($project['status'] ?? 'open')) ?>
                            </p>
                        </div>
                    </div>

                    <div class="project-meta">
                        <span><strong>Budget:</strong> ₹<?= (int)$project['budget_min'] ?> - ₹<?= (int)$project['budget_max'] ?></span>
                        <span><strong>Deadline:</strong> <?= htmlspecialchars($project['deadline']) ?></span>
                    </div>

                    <p><?= nl2br(htmlspecialchars($project['project_description'])) ?></p>

                    <!-- CLIENT ACTIONS -->
                    <div class="project-actions">
                        <a href="/php-dev-marketplace/projects/detail.php?id=<?= $project['id'] ?>" class="btn-outline">
                            View & Applications
                        </a>
                        <a href="/php-dev-marketplace/clients/my_projects.php?edit=<?= $project['id'] ?>" class="btn-primary">
                            Edit
                        </a>
                        <a href="/php-dev-marketplace/clients/my_projects.php?delete=<?= $project['id'] ?>"
                           class="btn-danger"
                           onclick="return confirm('Are you sure you want to delete this project?');">
                            Delete
                        </a>
                    </div>

                    <?php if ($editId === (int)$project['id']): ?>
                        <hr>
                        <h4>Edit Project</h4>
                        <form method="POST" class="edit-project">
                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">

                            <div class="form-group">
                                <label>Project Title *</label>
                                <input type="text" name="project_title"
                                       value="<?= htmlspecialchars($project['project_title']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Project Description *</label>
                                <textarea name="project_description" rows="4" required><?= htmlspecialchars($project['project_description']) ?></textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Budget Min (₹)</label>
                                    <input type="number" name="budget_min"
                                           value="<?= (int)$project['budget_min'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Budget Max (₹)</label>
                                    <input type="number" name="budget_max"
                                           value="<?= (int)$project['budget_max'] ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deadline *</label>
                                <input type="date" name="deadline"
                                       value="<?= htmlspecialchars($project['deadline']) ?>" required>
                            </div>

                            <button type="submit" class="btn-primary">Save Changes</button>
                            <button class="btn-primary x-mark"><a class="x-mark" href="/php-dev-marketplace/clients/my_projects.php">Close <i class="fa-solid fa-xmark"></i></a></button>
                        </form>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>

    </main>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
