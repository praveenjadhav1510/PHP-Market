<?php
$pageTitle = "FAQ | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';
?>

<section class="legal-page">
  <div class="container">
    <div class="cover-image">
        <img src="/php-dev-marketplace/assets/images/faq-bg.jpg" alt="faq-bg-image"/>
        <h1>Frequently Asked Questions (FAQ)</h1>
        <p class="updated">Last updated: <?= date('F Y') ?></p>
    </div>

    <h2>What is PHP Dev Marketplace?</h2>
    <p>
    PHP Dev Marketplace is a platform that connects businesses and individuals with
    PHP developers for freelance, contract, and project-based work.
    </p>

    <h2>Who can join the platform?</h2>
    <p>
    Anyone can join as a client or developer. Clients post projects, while developers
    apply based on skills and availability.
    </p>

    <h2>Is registration free?</h2>
    <p>
    Yes, registration is completely free. Optional premium features may be introduced
    in the future.
    </p>

    <h2>How do clients hire developers?</h2>
    <p>
    Clients can post project requirements and receive proposals from developers.
    They may review profiles and choose the best fit.
    </p>

    <h2>How are payments handled?</h2>
    <p>
    Payments are handled directly between clients and developers. PHP Dev Marketplace
    does not process or manage payments.
    </p>

    <h2>Is my data secure?</h2>
    <p>
    We use secure authentication and password hashing to protect user data. However,
    users should follow best practices such as using strong passwords.
    </p>

    <h2>Can I delete my account?</h2>
    <p>
    Yes, you may request account deletion by contacting support.
    </p>

    <h2>What happens if there is a dispute?</h2>
    <p>
    Disputes must be resolved directly between the client and developer. The platform
    does not mediate disputes.
    </p>

    <h2>Can these policies change?</h2>
    <p>
    Yes, policies may be updated periodically to reflect platform changes or legal
    requirements.
    </p>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
