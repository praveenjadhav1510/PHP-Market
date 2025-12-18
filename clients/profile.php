<?php

require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: /php-dev-marketplace/auth/login.php");
    exit;
}

/* FETCH CLIENT PROFILE */
$stmt = $pdo->prepare("
    SELECT 
        u.name,
        u.email,
        c.company_name,
        c.contact_person,
        c.description,
        c.budget,
        c.location,
        c.website,
        c.logo_image
    FROM users u
    INNER JOIN client_profiles c ON c.user_id = u.id
    WHERE u.id = ?
");
$stmt->execute([$userId]);
$client = $stmt->fetch();

if (!$client) {
    header("Location: /php-dev-marketplace/dashboard/profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Client Profile</title>
<link rel="stylesheet" href="/php-dev-marketplace/assets/css/profile.css?v=1">
</head>

<body>

<div class="profile-container ghost-ui">

  <!-- HEADER -->
  <div class="ghost-header">
    <div class="ghost-avatar">
      <img 
        src="/php-dev-marketplace/uploads/logos/<?= $client['logo_image'] ?: 'default.png' ?>" 
        alt="Company Logo">
    </div>

    <div class="ghost-head-info">
      <h2><?= htmlspecialchars($client['company_name']) ?></h2>
      <p><?= htmlspecialchars($client['email']) ?></p>

      <a href="/php-dev-marketplace/dashboard/profile" class="ghost-btn">
        Edit Profile
      </a>
    </div>
  </div>

  <!-- INFO GRID -->
  <div class="ghost-grid">

    <div class="ghost-card">
      <h4>Contact Person <i class="fa-solid fa-user"></i></h4>
      <p><?= htmlspecialchars($client['contact_person']) ?></p>
    </div>

    <div class="ghost-card">
      <h4>Budget <i class="fa-solid fa-indian-rupee-sign"></i></h4>
      <p><i class="fa-solid fa-indian-rupee-sign"></i><?= number_format($client['budget']) ?></p>
    </div>

    <div class="ghost-card">
      <h4>Location <i class="fa-solid fa-location-dot"></i></h4>
      <p><?= htmlspecialchars($client['location']) ?></p>
    </div>

    <div class="ghost-card ghost-wide">
      <h4>Description <i class="fa-solid fa-align-left"></i></h4>
      <p><?= nl2br(htmlspecialchars($client['description'])) ?></p>
    </div>

    <?php if (!empty($client['website'])): ?>
    <div class="ghost-card ghost-wide">
      <h4>Website <i class="fa-brands fa-pagelines"></i></h4>
      <a href="<?= htmlspecialchars($client['website']) ?>" target="_blank">
        <?= htmlspecialchars($client['website']) ?>
      </a>
    </div>
    <?php endif; ?>

  </div>
</div>

</body>
</html>
