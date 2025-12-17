<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userType   = $_SESSION['user_type'] ?? 'guest';

/* ---------- Nav Logic ---------- */
// Defaults (Guest)
$secondText = "Find Developers";
$secondLink = "/php-dev-marketplace/developers/list";

$thirdText  = "Post a Project";
$thirdLink  = "/php-dev-marketplace/auth/login";

// Client
if ($isLoggedIn && $userType === 'client') {
    $secondText = "Find Developers";
    $secondLink = "/php-dev-marketplace/developers/list";

    $thirdText  = "Post a Project";
    $thirdLink  = "/php-dev-marketplace/clients/create_project";
}

// Developer
if ($isLoggedIn && $userType === 'developer') {
    $secondText = "Find Projects";
    $secondLink = "/php-dev-marketplace/developers/list";

    $thirdText  = "Dashboard";
    $thirdLink  = "/php-dev-marketplace/dashboard";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'PHP Dev Marketplace' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicons -->
    <link rel="icon" href="/php-dev-marketplace/assets/images/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32"
          href="/php-dev-marketplace/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="/php-dev-marketplace/assets/images/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon"
          href="/php-dev-marketplace/assets/images/favicon/apple-touch-icon.png">

    <!-- CSS -->
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/profile.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/contact.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>

<body>

<header class="site-header">
    <div class="container header-flex">

        <!-- Logo -->
        <a href="/php-dev-marketplace/" class="logo">
            <img src="/php-dev-marketplace/assets/images/logo.png" alt="PHP Market">
        </a>

        <!-- Mobile Menu Toggle -->
        <div class="menu-toggle" id="menuToggle">☰</div>

        <!-- Navigation -->
        <nav class="main-nav" id="mainNav">
            <a href="/php-dev-marketplace/">Home</a>
            <a href="<?= $secondLink ?>"><?= $secondText ?></a>
            <a href="<?= $thirdLink ?>"><?= $thirdText ?></a>
            <a href="/php-dev-marketplace/pages/how-it-works">How It Works</a>
            <a href="/php-dev-marketplace/pages/about">About Us</a>
            <a href="/php-dev-marketplace/join">Join</a>

            <!-- Mobile Auth -->
            <div class="mobile-auth">
                <?php if ($isLoggedIn): ?>
                    <a href="/php-dev-marketplace/dashboard">Dashboard</a>
                    <a href="/php-dev-marketplace/auth/logout">Logout</a>
                <?php else: ?>
                    <a href="/php-dev-marketplace/auth/login">Login</a>
                    <a href="/php-dev-marketplace/auth/signup">Signup</a>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Right Side -->
        <div class="auth-links desktop-auth">

            <!-- 🌗 THEME TOGGLE -->
            <span id="themeToggle"
                    class="theme-toggle"
                    title="Toggle dark / light mode"
                    aria-label="Toggle theme">
                <img id="themeIcon"
                     src="/php-dev-marketplace/assets/images/theme/moon.png"
                     alt="Theme toggle">
            </span>

            <?php if ($isLoggedIn): ?>
                <a href="/php-dev-marketplace/dashboard">Dashboard</a>
                <a href="/php-dev-marketplace/auth/logout" class="btn-outline">Logout</a>
            <?php else: ?>
                <a href="/php-dev-marketplace/auth/login">Login</a>
                <a href="/php-dev-marketplace/auth/signup" class="btn-primary">Signup</a>
            <?php endif; ?>
        </div>

    </div>
</header>

<!-- Mobile Menu Script -->
<script>
document.getElementById('menuToggle').onclick = function () {
    document.getElementById('mainNav').classList.toggle('open');
};
</script>

<!-- 🌗 THEME TOGGLE SCRIPT -->
<script>
(function () {
    const root = document.documentElement;
    const toggle = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");

    if (!toggle || !icon) return;

    const sunIcon  = "/php-dev-marketplace/assets/images/theme/sun.png";
    const moonIcon = "/php-dev-marketplace/assets/images/theme/moon.png";

    // Load saved theme
    const savedTheme = localStorage.getItem("theme") || "dark";
    root.setAttribute("data-theme", savedTheme);
    icon.src = savedTheme === "dark" ? sunIcon : moonIcon;

    // Toggle theme
    toggle.addEventListener("click", () => {
        const nextTheme =
            root.getAttribute("data-theme") === "dark" ? "light" : "dark";

        root.setAttribute("data-theme", nextTheme);
        localStorage.setItem("theme", nextTheme);
        icon.src = nextTheme === "dark" ? sunIcon : moonIcon;
    });
})();
</script>

