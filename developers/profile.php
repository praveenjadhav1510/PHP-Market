<?php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';


$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT u.name, u.email, d.*
    FROM users u
    JOIN developer_profiles d ON d.user_id = u.id
    WHERE u.id = ?
");
$stmt->execute([$userId]);
$dev = $stmt->fetch();

if (!$dev) {
    header("Location: /php-dev-marketplace/dashboard/profile");
    exit;
}

$skills = json_decode($dev['skills'], true) ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Developer Profile</title>

    <!-- FORCE LOAD PROFILE CSS -->
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/profile.css?v=3">
</head>
<body>

<!-- THIS WRAPS INSIDE YOUR DASHBOARD GREY AREA -->
<div class="profile-container ghost-ui">

    <!-- HEADER -->
    <div class="ghost-header">
        <div class="ghost-avatar">
            <img 
              src="/php-dev-marketplace/uploads/avatars/<?= $dev['avatar'] ?: 'default.png' ?>" 
              alt="Profile Avatar"
            >
        </div>

        <div class="ghost-head-info">
            <h2><?= htmlspecialchars($dev['name']) ?></h2>
            <p><?= htmlspecialchars($dev['email']) ?></p>

            <a href="/php-dev-marketplace/dashboard/profile.php" class="ghost-btn">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- INFO GRID -->
    <div class="ghost-grid">

        <div class="ghost-card">
            <h4>Primary Skill</h4>
            <p><?= htmlspecialchars($dev['primary_skill']) ?></p>
        </div>

        <div class="ghost-card">
            <h4>Experience</h4>
            <p><?= (int)$dev['experience'] ?> years</p>
        </div>

        <div class="ghost-card">
            <h4>Hourly Rate</h4>
            <p>₹<?= (int)$dev['rate'] ?>/hr</p>
        </div>

        <div class="ghost-card">
            <h4>Location</h4>
            <p><?= htmlspecialchars($dev['location']) ?></p>
        </div>

        <!-- SKILLS -->
        <div class="ghost-card ghost-wide">
            <h4>Skills</h4>
            <div class="ghost-skills">
                <?php foreach ($skills as $s): ?>
                    <span><?= htmlspecialchars($s) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- PORTFOLIO -->
        <?php if (!empty($dev['portfolio'])): ?>
        <div class="ghost-card ghost-wide">
            <h4>Portfolio</h4>
            <a href="<?= htmlspecialchars($dev['portfolio']) ?>" target="_blank">
                <?= htmlspecialchars($dev['portfolio']) ?>
            </a>
        </div>
        <?php endif; ?>

        <!-- CERTIFICATE -->
        <?php if (!empty($dev['certification_pdf'])): ?>
        <div class="ghost-card ghost-wide">
            <h4>Certification</h4>
            <iframe 
              src="/php-dev-marketplace/uploads/certificates/<?= $dev['certification_pdf'] ?>">
            </iframe>
        </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
