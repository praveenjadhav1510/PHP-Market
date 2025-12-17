<?php
require_once __DIR__ . '/guard.php';
$pageTitle = "Dashboard | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth-check.php';


$userType = $_SESSION['user_type'];
?>

<div class="dashboard-layout">

    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <main class="dashboard-content">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h1>

        <p class="dash-subtitle">
            Complete your profile to unlock all features.
        </p>

        <div class="dash-cards">
            <div class="dash-card">
                <h3>Profile Status</h3>
                <p>100% completed</p>
            </div>

            <div class="dash-card">
                <h3>Current Plan</h3>
                <p><?= ucfirst($_SESSION['plan'] ?? 'free') ?></p>
            </div>

            <div class="dash-card">
                <h3>Account Type</h3>
                <p><?= ucfirst($_SESSION['user_type']) ?></p>
            </div>
        </div>
        <?php
        if ($userType === 'developer') {
            require_once __DIR__ . '/../developers/profile.php';
        } else {
            require_once __DIR__ . '/../clients/profile.php';
        }
        ?>
    </main>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
