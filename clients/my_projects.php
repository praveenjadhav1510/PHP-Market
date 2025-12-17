<?php
$pageTitle = "My Projects | Dashboard";
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-layout">

    <?php require_once __DIR__ . '/../dashboard/sidebar.php'; ?>

    <main class="dashboard-content">

        <h1>My Projects</h1>
        <p class="dash-subtitle">
            Manage projects you have posted and boost them for more visibility.
        </p>

        <div class="projects-grid">

            <?php
            // ---------- STATIC CLIENT PROJECT DATA ----------
            $projects = [
                [
                    'title' => 'HR Management System',
                    'company' => 'BusinessLabs',
                    'budget' => '₹1,80,000',
                    'location' => 'Hyderabad',
                    'skills' => ['PHP', 'Laravel', 'MySQL'],
                ],
                [
                    'title' => 'Company Website Revamp',
                    'company' => 'BusinessLabs',
                    'budget' => '₹75,000',
                    'location' => 'Remote',
                    'skills' => ['PHP', 'WordPress'],
                ],
                [
                    'title' => 'REST API Development',
                    'company' => 'BusinessLabs',
                    'budget' => '₹1,20,000',
                    'location' => 'Remote',
                    'skills' => ['PHP', 'API', 'Backend'],
                ],
                [
                    'title' => 'CRM System',
                    'company' => 'BusinessLabs',
                    'budget' => '₹2,50,000',
                    'location' => 'Bangalore',
                    'skills' => ['Laravel', 'MySQL'],
                ],
                [
                    'title' => 'E-commerce Backend',
                    'company' => 'BusinessLabs',
                    'budget' => '₹3,00,000',
                    'location' => 'Remote',
                    'skills' => ['PHP', 'Laravel', 'API'],
                ],
                [
                    'title' => 'Company Website Revamp',
                    'company' => 'BusinessLabs',
                    'budget' => '₹75,000',
                    'location' => 'Remote',
                    'skills' => ['PHP', 'WordPress'],
                ],
                [
                    'title' => 'REST API Development',
                    'company' => 'BusinessLabs',
                    'budget' => '₹1,20,000',
                    'location' => 'Remote',
                    'skills' => ['PHP', 'API', 'Backend'],
                ],
                [
                    'title' => 'CRM System',
                    'company' => 'BusinessLabs',
                    'budget' => '₹2,50,000',
                    'location' => 'Bangalore',
                    'skills' => ['Laravel', 'MySQL'],
                ]
            ];
            ?>

            <?php foreach ($projects as $project): ?>
                <div class="project-card">

                    <div class="project-header">
                        <img
                            src="/php-dev-marketplace/uploads/logos/6942460741d4b.jpg"
                            alt="Company Logo"
                            class="company-logo"
                        >
                        <div>
                            <h3><?= htmlspecialchars($project['title']) ?></h3>
                            <p class="company-name"><?= htmlspecialchars($project['company']) ?></p>
                        </div>
                    </div>

                    <div class="project-meta">
                        <span><strong>Budget:</strong> <?= $project['budget'] ?></span>
                        <span><strong>Location:</strong> <?= $project['location'] ?></span>
                    </div>

                    <div class="project-skills">
                        <?php foreach ($project['skills'] as $skill): ?>
                            <span class="skill-tag"><?= $skill ?></span>
                        <?php endforeach; ?>
                    </div>

                    <!-- CLIENT ACTIONS -->
                    <div class="project-actions">
                        <a href="#" class="btn-primary">🚀 Boost</a>
                        <a href="#" class="btn-danger">🗑 Delete</a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    </main>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
