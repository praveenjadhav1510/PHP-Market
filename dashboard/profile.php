<?php
require_once __DIR__ . '/guard.php';
require_once __DIR__ . '/../config/db.php';

$pageTitle = "Complete Profile | Dashboard";
require_once __DIR__ . '/../includes/header.php';

$userType = $_SESSION['user_type'];
$userId   = $_SESSION['user_id'];

$profile = [];
$success = "";

/* ================= FILE UPLOAD HELPER ================= */
function uploadFile($file, $allowedExt, $uploadDir) {
    if (!$file || $file['error'] !== 0) return null;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) return null;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid() . '.' . $ext;
    move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

    return $filename;
}

/* ================= LOAD PROFILE ================= */
if ($userType === 'developer') {
    $stmt = $pdo->prepare("SELECT * FROM developer_profiles WHERE user_id = ?");
    $stmt->execute([$userId]);
    $profile = $stmt->fetch() ?: [];
    $profile['skills'] = !empty($profile['skills']) ? json_decode($profile['skills'], true) : [];
} else {
    $stmt = $pdo->prepare("SELECT * FROM client_profiles WHERE user_id = ?");
    $stmt->execute([$userId]);
    $profile = $stmt->fetch() ?: [];
}

/* ================= SAVE PROFILE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($userType === 'developer') {

        $skills = json_encode($_POST['skills'] ?? []);

        $avatar = uploadFile($_FILES['avatar'] ?? null, ['jpg','jpeg','png'], __DIR__ . '/../uploads/avatars/');
        $certPdf = uploadFile($_FILES['certification_pdf'] ?? null, ['pdf'], __DIR__ . '/../uploads/certificates/');

        $stmt = $pdo->prepare("
            INSERT INTO developer_profiles
            (user_id, gender, primary_skill, skills, experience, rate, location, portfolio, avatar, certification_pdf)
            VALUES
            (:user_id, :gender, :primary_skill, :skills, :experience, :rate, :location, :portfolio, :avatar, :cert_pdf)
            ON DUPLICATE KEY UPDATE
                gender = VALUES(gender),
                primary_skill = VALUES(primary_skill),
                skills = VALUES(skills),
                experience = VALUES(experience),
                rate = VALUES(rate),
                location = VALUES(location),
                portfolio = VALUES(portfolio),
                avatar = COALESCE(:avatar, avatar),
                certification_pdf = COALESCE(:cert_pdf, certification_pdf)
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':gender' => $_POST['gender'] ?? null,
            ':primary_skill' => $_POST['primary_skill'] ?? null,
            ':skills' => $skills,
            ':experience' => $_POST['experience'] ?? null,
            ':rate' => $_POST['rate'] ?? null,
            ':location' => $_POST['location'] ?? null,
            ':portfolio' => $_POST['portfolio'] ?? null,
            ':avatar' => $avatar,
            ':cert_pdf' => $certPdf,
        ]);

    } else {

        $logoImage = uploadFile($_FILES['logo_image'] ?? null, ['jpg','jpeg','png','svg'], __DIR__ . '/../uploads/logos/');

        $stmt = $pdo->prepare("
            INSERT INTO client_profiles
            (user_id, company_name, logo_image, contact_person, business_name, description, budget, location, website)
            VALUES
            (:user_id, :company_name, :logo_image, :contact_person, :business_name, :description, :budget, :location, :website)
            ON DUPLICATE KEY UPDATE
                company_name = VALUES(company_name),
                logo_image = COALESCE(:logo_image, logo_image),
                contact_person = VALUES(contact_person),
                business_name = VALUES(business_name),
                description = VALUES(description),
                budget = VALUES(budget),
                location = VALUES(location),
                website = VALUES(website)
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':company_name' => $_POST['company_name'] ?? null,
            ':logo_image' => $logoImage,
            ':contact_person' => $_POST['contact_person'] ?? null,
            ':business_name' => $_POST['business_name'] ?? null,
            ':description' => $_POST['description'] ?? null,
            ':budget' => $_POST['budget'] ?? null,
            ':location' => $_POST['location'] ?? null,
            ':website' => $_POST['website'] ?? null,
        ]);
    }

    $_SESSION['profile_completed'] = true;
    if ($userType === 'developer') {
        header("Location: /php-dev-marketplace/developers/profile.php");
        exit;
    } else {
        header("Location: /php-dev-marketplace/clints/profile.php");
        exit;        
    }
}
?>

<div class="dashboard-layout">
<?php require_once __DIR__ . '/sidebar.php'; ?>

<main class="dashboard-content">
<h1>Complete Your Profile</h1>
<p class="dash-subtitle">This information helps unlock marketplace features.</p>

<!-- ================= DEVELOPER ================= -->
<?php if ($userType === 'developer'): ?>
<form method="POST" enctype="multipart/form-data" class="profile-form">

<div class="form-group">
<label>Full Name</label>
<input type="text" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" disabled>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" disabled>
</div>

<?php if (!empty($profile['avatar'])): ?>
<img src="/uploads/avatars/<?= $profile['avatar'] ?>" height="80">
<?php endif; ?>

<div class="form-group">
<label>Avatar</label>
<input type="file" name="avatar" accept="image/*">
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender">
<option value="">Select</option>
<option <?= ($profile['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
<option <?= ($profile['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
<option <?= ($profile['gender'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
</select>
</div>

<div class="form-group">
<label>Primary Skill</label>
<select name="primary_skill">
<?php
$skillsArr = ["php","laravel","wordpress","api","mysql","backend"];
foreach ($skillsArr as $s) {
    $sel = (($profile['primary_skill'] ?? '') === $s) ? 'selected' : '';
    echo "<option $sel>$s</option>";
}
?>
</select>
</div>

<div class="form-group">
<label>More Skills</label>
<div class="skill-input">
<input type="text" id="skillInput">
<button type="button" onclick="addSkill()">Add</button>
</div>
<div id="skillList">
<?php foreach ($profile['skills'] as $s): ?>
<span class="skill-tag">
<?= htmlspecialchars($s) ?>
<input type="hidden" name="skills[]" value="<?= htmlspecialchars($s) ?>">
<button type="button" onclick="this.parentElement.remove()">×</button>
</span>
<?php endforeach; ?>
</div>
</div>

<div class="form-group">
<label>Experience (Years)</label>
<input type="number" name="experience" value="<?= $profile['experience'] ?? '' ?>">
</div>

<div class="form-group">
<label>Hourly Rate (₹)</label>
<input type="number" name="rate" value="<?= $profile['rate'] ?? '' ?>">
</div>

<div class="form-group">
<label>Location</label>
<input type="text" name="location" value="<?= $profile['location'] ?? '' ?>">
</div>

<div class="form-group">
<label>Portfolio</label>
<input type="url" name="portfolio" value="<?= $profile['portfolio'] ?? '' ?>">
</div>

<?php if (!empty($profile['certification_pdf'])): ?>
<a href="/uploads/certificates/<?= $profile['certification_pdf'] ?>" target="_blank">View Certificate</a>
<?php endif; ?>

<div class="form-group">
<label>Certification PDF</label>
<input type="file" name="certification_pdf" accept="application/pdf">
</div>

<button class="btn-primary">Save Profile</button>
</form>
<?php endif; ?>

<!-- ================= CLIENT ================= -->
<?php if ($userType === 'client'): ?>
<form method="POST" enctype="multipart/form-data" class="profile-form">

<?php if (!empty($profile['logo_image'])): ?>
<img src="/uploads/logos/<?= $profile['logo_image'] ?>" height="60">
<?php endif; ?>

<div class="form-group">
<label>Company Logo</label>
<input type="file" name="logo_image" accept="image/*">
</div>

<div class="form-group">
<label>Company Name</label>
<input type="text" name="company_name" value="<?= $profile['company_name'] ?? '' ?>">
</div>

<div class="form-group">
<label>Contact Person</label>
<input type="text" name="contact_person" value="<?= $profile['contact_person'] ?? '' ?>">
</div>

<div class="form-group">
<label>Business Name</label>
<input type="text" name="business_name" value="<?= $profile['business_name'] ?? '' ?>">
</div>

<div class="form-group">
<label>Description</label>
<textarea name="description"><?= $profile['description'] ?? '' ?></textarea>
</div>

<div class="form-group">
<label>Budget</label>
<input type="text" name="budget" value="<?= $profile['budget'] ?? '' ?>">
</div>

<div class="form-group">
<label>Location</label>
<input type="text" name="location" value="<?= $profile['location'] ?? '' ?>">
</div>

<div class="form-group">
<label>Website</label>
<input type="url" name="website" value="<?= $profile['website'] ?? '' ?>">
</div>

<button class="btn-primary">Save Profile</button>
</form>
<?php endif; ?>

</main>
</div>

<script>
function addSkill() {
    const input = document.getElementById('skillInput');
    const val = input.value.trim();
    if (!val) return;

    const tag = document.createElement('span');
    tag.className = 'skill-tag';
    tag.innerHTML = `${val}
        <input type="hidden" name="skills[]" value="${val}">
        <button type="button" onclick="this.parentElement.remove()">×</button>`;

    document.getElementById('skillList').appendChild(tag);
    input.value = '';
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
