<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$pageTitle = "Marketplace | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';

$query = strtolower(trim($_GET['q'] ?? ''));
$userType = $_SESSION['user_type'] ?? 'guest';
$userId = $_SESSION['user_id'] ?? null;
$message = '';
$error = '';

// Handle invite submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'invite' && $userType === 'client' && $userId) {
    $projectId = (int) ($_POST['project_id'] ?? 0);
    $developerId = (int) ($_POST['developer_id'] ?? 0);
    $inviteMessage = trim($_POST['message'] ?? '');
    
    if (!$projectId || !$developerId) {
        $error = "Please select a project and developer.";
    } else {
        // Verify project belongs to client
        $checkProject = $pdo->prepare("SELECT id FROM projects WHERE id = ? AND user_id = ?");
        $checkProject->execute([$projectId, $userId]);
        if (!$checkProject->fetch()) {
            $error = "Invalid project selected.";
        } else {
            // Check if invitation already exists
            $checkInvite = $pdo->prepare("SELECT id FROM project_invitations WHERE project_id = ? AND developer_id = ?");
            $checkInvite->execute([$projectId, $developerId]);
            if ($checkInvite->fetch()) {
                $error = "You have already sent an invitation to this developer for this project.";
            } else {
                // Insert invitation
                $insert = $pdo->prepare("
                    INSERT INTO project_invitations (project_id, developer_id, client_id, message, status)
                    VALUES (?, ?, ?, ?, 'pending')
                ");
                $insert->execute([$projectId, $developerId, $userId, $inviteMessage ?: null]);
                $message = "Invitation sent successfully!";
            }
        }
    }
}

function matchesText($text, $query) {
    if (!$query) return true;
    return strpos(strtolower($text), $query) !== false;
}

// If developer: show available projects from DB (exclude only closed projects)
if ($userType === 'developer') {
    $stmt = $pdo->prepare("
        SELECT p.id,
               p.project_title,
               p.skills,
               p.budget_min,
               p.budget_max,
               p.status,
               p.logo_image
        FROM projects p
        WHERE (p.status IS NULL OR p.status != 'closed')
        ORDER BY p.id DESC
    ");
    $stmt->execute();
    $projects = $stmt->fetchAll();
} elseif ($userType === 'client' && $userId) {
    // If client: show developers from DB
    $stmt = $pdo->prepare("
        SELECT u.id,
               u.name,
               u.email,
               dp.primary_skill,
               dp.skills,
               dp.experience,
               dp.rate,
               dp.location,
               dp.portfolio,
               dp.avatar
        FROM users u
        INNER JOIN developer_profiles dp ON dp.user_id = u.id
        WHERE u.user_type = 'developer'
        ORDER BY u.id DESC
    ");
    $stmt->execute();
    $developers = $stmt->fetchAll();
    
    // Fetch client's projects for invite dropdown
    $projectsStmt = $pdo->prepare("
        SELECT id, project_title, status
        FROM projects
        WHERE user_id = ? AND (status IS NULL OR status = 'open')
        ORDER BY id DESC
    ");
    $projectsStmt->execute([$userId]);
    $clientProjects = $projectsStmt->fetchAll();
} else {
    $projects = [];
    $developers = [];
    $clientProjects = [];
}
?>

<?php require_once __DIR__ . '/../includes/hero.php'; ?>

<section class="featured-devs">
    <div class="container">

        <?php if ($userType === 'developer'): ?>
            <h2>Available Projects</h2>

            <div class="dev-grid">
                <?php foreach ($projects as $p): ?>
                    <?php
                    $skillsText = $p['skills'] ?? '';
                    if (!matchesText($p['project_title'] . ' ' . $skillsText, $query)) {
                        continue;
                    }
                    ?>
                    <div class="dev-card">
                        <div class="dev-info">
                            <?php if (!empty($p['logo_image'])): ?>
                                <img src="/php-dev-marketplace/uploads/logos/<?= htmlspecialchars($p['logo_image']) ?>"
                                    alt="Project Logo"
                                    class="">
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($p['project_title']) ?></h3>
                        </div>
                        <?php 
                        $projectStatus = $p['status'] ?? 'open';
                        if ($projectStatus !== 'open' && $projectStatus !== null): 
                        ?>
                            <p class="in-process">
                                Status: <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $projectStatus))) ?>
                            </p>
                        <?php endif; ?>
                        <p>Skills: <?= htmlspecialchars(strtoupper($skillsText)) ?></p>
                        <span>₹<?= (int)$p['budget_min'] ?> - ₹<?= (int)$p['budget_max'] ?></span>
                        <a href="/php-dev-marketplace/projects/detail.php?id=<?= $p['id'] ?>" class="btn-outline cd-btn">
                            View & Apply
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php if (!$projects): ?>
                    <p>No projects are currently open. Please check back later.</p>
                <?php endif; ?>
            </div>

        <?php elseif ($userType === 'client'): ?>
            <?php if ($message): ?>
                <div class="success-msg">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error-msg">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <h2>PHP Developers</h2>
            <p>Search and invite developers to your projects</p>

            <div class="dev-grid">
                <?php foreach ($developers as $dev): ?>
                    <?php
                    $skills = json_decode($dev['skills'], true) ?? [];
                    $skillsText = implode(' ', $skills);
                    $searchText = strtolower($dev['name'] . ' ' . $dev['email'] . ' ' . ($dev['primary_skill'] ?? '') . ' ' . $skillsText . ' ' . ($dev['location'] ?? ''));
                    
                    if (!matchesText($searchText, $query)) {
                        continue;
                    }
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
                        <p><strong>Primary Skill:</strong><span> <?= htmlspecialchars($dev['primary_skill'] ?? 'N/A') ?></span></p>
                        <p><strong>Experience:</strong><span> <?= (int)$dev['experience'] ?> years</span></p>
                        <p><strong>Rate:</strong><span> ₹<?= (int)$dev['rate'] ?>/hr</span></p>
                        <?php if ($dev['location']): ?>
                            <p><strong>Location:</strong><span> <?= htmlspecialchars($dev['location']) ?></span></p>
                        <?php endif; ?>
                        <?php if ($skills): ?>
                            <p><strong>Skills:</strong><span> <?= htmlspecialchars(implode(', ', $skills)) ?></span></p>
                        <?php endif; ?>
                        
                        <!-- Invite Button -->
                        <?php if (empty($clientProjects)): ?>
                            <a href="/php-dev-marketplace/clients/create_project" class="btn-outline" style="margin-top: auto;">
                                Create Project First
                            </a>
                        <?php else: ?>
                            <button 
                                type="button" 
                                class="btn-primary" 
                                onclick="openInviteModal(<?= $dev['id'] ?>, '<?= htmlspecialchars(addslashes($dev['name'])) ?>')"
                                style="margin-top: auto;">
                                Send Invite <i class="fa-solid fa-link"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php if (!$developers): ?>
                    <p>No developers found. Please check back later.</p>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <h2>PHP Developers</h2>
            <p>Please <a href="/php-dev-marketplace/auth/login">login</a> to search developers or projects.</p>
        <?php endif; ?>

    </div>
</section>

<!-- Invite Modal -->
<?php if ($userType === 'client' && $userId): ?>
<div id="inviteModal" class="invite-modal">
    <div class="invite-modal-content">
        <h2>Send Invitation</h2>
        <p>Invite <strong id="devName"></strong> to work on one of your projects.</p>
        
        <form method="POST" id="inviteForm">
            <input type="hidden" name="action" value="invite">
            <input type="hidden" name="developer_id" id="developer_id">
            
            <div class="form-group">
                <label>Select Project *</label>
                <select name="project_id" required>
                    <option value="">-- Select a Project --</option>
                    <?php foreach ($clientProjects as $proj): ?>
                        <option value="<?= $proj['id'] ?>">
                            <?= htmlspecialchars($proj['project_title']) ?> 
                            (<?= htmlspecialchars(ucfirst($proj['status'] ?? 'open')) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <?php if (!$clientProjects): ?>
                <p class="error-msg" style="margin-bottom: 1rem;">
                    You need to create a project first. 
                    <a href="/php-dev-marketplace/clients/create_project">Create Project</a>
                </p>
            <?php endif; ?>
            
            <div class="form-group">
                <label>Message (Optional)</label>
                <textarea name="message" rows="4" placeholder="Add a personal message to your invitation..."></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary" <?= !$clientProjects ? 'disabled' : '' ?>>
                    Send Invitation <i class="fa-solid fa-link"></i>
                </button>
                <button type="button" class="btn-outline" onclick="closeInviteModal()">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openInviteModal(developerId, developerName) {
    document.getElementById('developer_id').value = developerId;
    document.getElementById('devName').textContent = developerName;
    document.getElementById('inviteModal').classList.add('active');
}

function closeInviteModal() {
    document.getElementById('inviteModal').classList.remove('active');
    document.getElementById('inviteForm').reset();
}

// Close modal when clicking outside
document.getElementById('inviteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInviteModal();
    }
});
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
