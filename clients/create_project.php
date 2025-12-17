<?php
require_once __DIR__ . '/../dashboard/guard.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$userId = $_SESSION['user_id'];

/* ================= FETCH USER EMAIL ================= */
$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found");
}

$userEmail = $user['email'];

$success = false;
$error = "";

/* ================= HANDLE FORM SUBMIT ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = trim($_POST['project_title'] ?? '');
    $description = trim($_POST['project_description'] ?? '');
    $skills      = isset($_POST['skills']) ? implode(',', $_POST['skills']) : '';
    $budgetMin   = (int) ($_POST['budget_min'] ?? 0);
    $budgetMax   = (int) ($_POST['budget_max'] ?? 0);
    $deadline    = $_POST['deadline'] ?? null;

    if (!$title || !$description || !$skills || !$deadline) {
        $error = "Please fill all required fields";
    } elseif ($budgetMin >= $budgetMax) {
        $error = "Budget max must be greater than budget min";
    }

    /* ================= LOGO UPLOAD ================= */
    $logoName = null;

    if (!$error && !empty($_FILES['logo']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Invalid logo format";
        } else {
            $logoName = uniqid('logo_') . '.' . $ext;
            $uploadPath = __DIR__ . '/../uploads/logos/' . $logoName;

            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
                $error = "Logo upload failed";
            }
        }
    }

    /* ================= INSERT PROJECT ================= */
    if (!$error) {
        $insert = $pdo->prepare("
            INSERT INTO projects
            (user_id, email, project_title, project_description, skills, budget_min, budget_max, deadline, logo_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $insert->execute([
            $userId,
            $userEmail,
            $title,
            $description,
            $skills,
            $budgetMin,
            $budgetMax,
            $deadline,
            $logoName
        ]);

        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Project</title>
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/style.css">
    <link rel="stylesheet" href="/php-dev-marketplace/assets/css/create-form.css">
</head>
<body>
<div class="container">
<!-- ================= PAGE INTRO ================= -->
<section class="page-intro ">
    <div class="intro-content">
        <h1>Post a New Project</h1>
        <p>
            Tell us about your project and connect with skilled PHP developers
            who are ready to build, fix, or scale your product.
        </p>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="how-it-works">
    <div class="steps">
        <div class="step">
            <span>1</span>
            <h4>Describe Your Project</h4>
            <p>Share requirements, skills, budget, and timeline.</p>
        </div>
        <div class="step">
            <span>2</span>
            <h4>Get Developer Responses</h4>
            <p>Qualified PHP developers apply to your project.</p>
        </div>
        <div class="step">
            <span>3</span>
            <h4>Hire & Start Building</h4>
            <p>Choose the best match and begin development.</p>
        </div>
    </div>
</section>

<!-- ================= FORM CARD ================= -->
<div class="form-card">

    <h2>Create New Project</h2>
    <p class="form-subtitle">
        Fill in the details below. Clear projects get better developers.
    </p>

    <?php if ($success): ?>
        <div class="success-msg">✅ Project posted successfully</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error-msg">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Project Title *</label>
            <input type="text" name="project_title" placeholder="e.g. Build Laravel Admin Panel" required>
        </div>

        <div class="form-group">
            <label>Project Description *</label>
            <textarea name="project_description" rows="5" placeholder="Describe your requirements, features, and expectations..." required></textarea>
        </div>

        <div class="form-group">
            <label>Required Skills *</label>
            <select name="skills[]" multiple required>
                <option value="PHP">PHP</option>
                <option value="Laravel">Laravel</option>
                <option value="MySQL">MySQL</option>
                <option value="WordPress">WordPress</option>
                <option value="API">API Development</option>
            </select>
            <small>Select one or more skills</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Budget Min (₹)</label>
                <input type="number" name="budget_min" placeholder="5000" required>
            </div>
            <div class="form-group">
                <label>Budget Max (₹)</label>
                <input type="number" name="budget_max" placeholder="15000" required>
            </div>
        </div>

        <div class="form-group">
            <label>Deadline *</label>
            <input type="date" name="deadline" required>
        </div>

        <div class="form-group">
            <label>Company / Client Logo</label>
            <input type="file" name="logo" accept="image/*">
            <small>This helps developers recognize your brand</small>
        </div>

        <button type="submit" class="btn-primary">Post Project</button>
    </form>

</div>

<!-- ================= WHAT HAPPENS NEXT ================= -->
<section class="next-steps">
    <h3>What happens after you post?</h3>
    <ul>
        <li>Your project becomes visible to verified PHP developers</li>
        <li>Developers can apply with proposals & timelines</li>
        <li>You review, chat, and hire — all in one place</li>
    </ul>
</section>

<!-- ================= TRUST / TIPS ================= -->
<section class="tips-section">
    <h3>Tips for getting better proposals</h3>
    <ul>
        <li>Be specific about features and expectations</li>
        <li>Add a realistic budget range</li>
        <li>Upload references or a logo if available</li>
    </ul>
</section>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>
