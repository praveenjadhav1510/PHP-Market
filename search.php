<?php
$pageTitle = "Search Results | PHP Dev Marketplace";
require_once __DIR__ . '/includes/header.php';

$query = strtolower(trim($_GET['q'] ?? ''));
?>

<section class="page-hero">
    <div class="container">
        <h1>Search Results</h1>
        <?php if ($query): ?>
            <p>Results for <strong><?= htmlspecialchars($query) ?></strong></p>
        <?php else: ?>
            <p>Please enter a search term.</p>
        <?php endif; ?>
    </div>
</section>

<?php
/* ================= STATIC DATA ================= */

// Developers (10)
$developers = [
    ["name"=>"Rahul Sharma","skills"=>"php laravel mysql","rate"=>"₹800/hr","rating"=>4.9],
    ["name"=>"Neha Patel","skills"=>"php api backend","rate"=>"₹1200/hr","rating"=>5.0],
    ["name"=>"Amit Verma","skills"=>"wordpress php","rate"=>"₹600/hr","rating"=>4.7],
    ["name"=>"Suresh Iyer","skills"=>"php laravel vue","rate"=>"₹900/hr","rating"=>4.8],
    ["name"=>"Kiran Desai","skills"=>"php symfony","rate"=>"₹1000/hr","rating"=>4.6],
    ["name"=>"Anjali Mehta","skills"=>"php api mysql","rate"=>"₹850/hr","rating"=>4.9],
    ["name"=>"Vikas Rao","skills"=>"php wordpress","rate"=>"₹700/hr","rating"=>4.5],
    ["name"=>"Pooja Kulkarni","skills"=>"php laravel api","rate"=>"₹950/hr","rating"=>4.8],
    ["name"=>"Manoj Singh","skills"=>"php backend","rate"=>"₹780/hr","rating"=>4.6],
    ["name"=>"Ritu Agarwal","skills"=>"php mysql","rate"=>"₹650/hr","rating"=>4.4],
];

// Clients (10)
$clients = [
    ["name"=>"TechNova Pvt Ltd","need"=>"php laravel developer"],
    ["name"=>"Startup Hub","need"=>"wordpress php site"],
    ["name"=>"FinEdge Solutions","need"=>"secure php backend"],
    ["name"=>"EduSmart","need"=>"php mysql application"],
    ["name"=>"RetailPro","need"=>"api development php"],
    ["name"=>"HealthPlus","need"=>"php system upgrade"],
    ["name"=>"MediaWorks","need"=>"wordpress customization"],
    ["name"=>"CloudServe","need"=>"php api integration"],
    ["name"=>"LogiTrack","need"=>"backend php developer"],
    ["name"=>"TravelEase","need"=>"php booking system"],
];

// Simple search function
function matches($text, $query) {
    return strpos(strtolower($text), $query) !== false;
}
?>

<!-- ================= DEVELOPERS RESULTS ================= -->
<section class="featured-devs">
    <div class="container">
        <h2>Developers</h2>

        <div class="dev-grid">
            <?php
            $foundDev = false;
            foreach ($developers as $dev):
                if (!$query || matches($dev['skills'], $query)):
                    $foundDev = true;
            ?>
                <div class="dev-card">
                    <h3><?= $dev['name'] ?></h3>
                    <p><?= strtoupper($dev['skills']) ?></p>
                    <span><?= $dev['rate'] ?> · ★ <?= $dev['rating'] ?></span>
                </div>
            <?php endif; endforeach; ?>

            <?php if (!$foundDev): ?>
                <p>No developers found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= CLIENTS RESULTS ================= -->
<section class="categories">
    <div class="container">
        <h2>Clients Looking for Developers</h2>

        <div class="category-grid">
            <?php
            $foundClient = false;
            foreach ($clients as $client):
                if (!$query || matches($client['need'], $query)):
                    $foundClient = true;
            ?>
                <div class="dev-card">
                    <h3><?= $client['name'] ?></h3>
                    <p>Looking for: <?= ucfirst($client['need']) ?></p>
                </div>
            <?php endif; endforeach; ?>

            <?php if (!$foundClient): ?>
                <p>No client requirements found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
