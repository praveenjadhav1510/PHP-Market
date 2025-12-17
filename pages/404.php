<?php
$pageTitle = "404 – Page Not Found";
require_once __DIR__ . '/includes/header.php';
?>

<section class="error-404">
    <div class="error-container">

        <h1>404</h1>
        <h2>Page Not Found</h2>

        <p>
            The page you are looking for doesn’t exist or has been moved.
        </p>

        <div class="error-actions">
            <a href="/php-dev-marketplace/" class="btn-primary">
                Go Home
            </a>
            <a href="/php-dev-marketplace/developers/list" class="btn-outline">
                Browse Developers
            </a>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
