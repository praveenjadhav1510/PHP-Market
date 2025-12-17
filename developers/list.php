<?php
session_start();

$pageTitle = "Marketplace | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';

$query = strtolower(trim($_GET['q'] ?? ''));
$userType = $_SESSION['user_type'] ?? 'guest';

/* ================= HELPER FUNCTION ================= */
function matches($fields, $query) {
    if (!$query) return true;

    foreach ($fields as $field) {
        if (strpos(strtolower($field), $query) !== false) {
            return true;
        }
    }
    return false;
}

/* ================= STATIC IMAGES ================= */
$devImages = [
    "https://randomuser.me/api/portraits/men/11.jpg",
    "https://randomuser.me/api/portraits/women/12.jpg",
    "https://randomuser.me/api/portraits/men/13.jpg",
    "https://randomuser.me/api/portraits/women/14.jpg",
    "https://randomuser.me/api/portraits/men/15.jpg",
    "https://randomuser.me/api/portraits/women/16.jpg",
    "https://randomuser.me/api/portraits/men/17.jpg",
    "https://randomuser.me/api/portraits/women/18.jpg",
    "https://randomuser.me/api/portraits/men/19.jpg",
    "https://randomuser.me/api/portraits/women/20.jpg",
];

$companyLogos = [
    "https://dummyimage.com/80x80/7495c2/ffffff&text=Tech",
    "https://dummyimage.com/80x80/87c19a/ffffff&text=Corp",
    "https://dummyimage.com/80x80/c62742/ffffff&text=Biz",
    "https://dummyimage.com/80x80/555/ffffff&text=IT",
];

/* ================= DEVELOPERS (20) ================= */
$developers = [];
$skillsPool = ["php", "laravel", "wordpress", "api", "mysql", "backend"];

for ($i = 1; $i <= 20; $i++) {
    $developers[] = [
        "name" => "Developer $i",
        "skills" => $skillsPool[array_rand($skillsPool)] . " php",
        "rate" => "₹" . rand(600, 1200) . "/hr",
        "rating" => number_format(rand(40, 50) / 10, 1),
        "image" => $devImages[array_rand($devImages)],
    ];
}

/* ================= PROJECTS (20) ================= */
$projects = [];
$projectTitles = [
    "CRM System", "Booking Platform", "E-commerce Backend", "REST API",
    "Admin Dashboard", "Payment Gateway", "CMS System", "ERP Module"
];

for ($i = 1; $i <= 20; $i++) {
    $projects[] = [
        "title" => $projectTitles[array_rand($projectTitles)] . " #" . $i,
        "skills" => $skillsPool[array_rand($skillsPool)] . " php",
        "budget" => "₹" . rand(15000, 60000),
        "type" => ["Freelance", "Contract", "Full-time"][array_rand([0,1,2])],
        "logo" => $companyLogos[array_rand($companyLogos)],
    ];
}
?>

<?php require_once __DIR__ . '/../includes/hero.php'; ?>

<section class="featured-devs">
    <div class="container">

        <?php if ($userType === 'developer'): ?>
            <h2>Available Projects</h2>

            <div class="dev-grid">
                <?php foreach ($projects as $p): ?>
                    <?php if (matches([$p['title'], $p['skills']], $query)): ?>
                        <div class="dev-card">
                            <img src="<?= $p['logo'] ?>" alt="Company Logo" style="width:60px;border-radius:8px;">
                            <h3><?= htmlspecialchars($p['title']) ?></h3>
                            <p>Skills: <?= strtoupper($p['skills']) ?></p>
                            <span><?= $p['budget'] ?> · <?= $p['type'] ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <h2>PHP Developers</h2>

            <div class="dev-grid">
                <?php foreach ($developers as $d): ?>
                    <?php if (matches([$d['name'], $d['skills']], $query)): ?>
                        <div class="dev-card">
                            <img src="<?= $d['image'] ?>" alt="<?= $d['name'] ?>" style="width:70px;border-radius:50%;">
                            <h3><?= htmlspecialchars($d['name']) ?></h3>
                            <p><?= strtoupper($d['skills']) ?></p>
                            <span><?= $d['rate'] ?> · ★ <?= $d['rating'] ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
