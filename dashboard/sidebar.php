<aside class="dashboard-sidebar">
    <h2 class="dash-logo">Dashboard</h2>

    <nav>
        <a href="/php-dev-marketplace/dashboard">Overview</a>
        <a href="/php-dev-marketplace/dashboard/profile">Edit Profile</a>

        <?php if ($_SESSION['user_type'] === 'client'): ?>
            <a href="/php-dev-marketplace/clients/my_projects">My Projects</a>
            <a href="/php-dev-marketplace/clients/create_project">Post Project</a>
        <?php else: ?>
            <a href="/php-dev-marketplace/developers/list">Browse Projects</a>
            <a href="/php-dev-marketplace/developers/my_applications">My Applications</a>
        <?php endif; ?>

        <a href="/php-dev-marketplace/dashboard/upgrade">Plans</a>
        <a href="/php-dev-marketplace/auth/logout" class="danger">
            Logout
        </a>
    </nav>
</aside>
