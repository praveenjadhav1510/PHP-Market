<?php
session_start();
$pageTitle = "Contact Us | PHP Dev Marketplace";
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container"><div class="cover-image container">
    <img src="/php-dev-marketplace/assets/images/contact.jpg" alt="contact-image"/>
    <h1>Contact Us <i class="fa-solid fa-phone"></i></h1>
    <p class="updated">Last updated: <?= date('F Y') ?></p>
</div>
<section class="contact-hero">
        <p>
            Have a question, feedback, or need support?  
            We’re here to help you build better PHP projects.
        </p>
    </div>
</section>

<section class="contact-section">
    <div class="container contact-grid">

        <!-- CONTACT INFO -->
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <p>
                Reach out to us through any of the following channels.
                Our team usually responds within 24 hours.
            </p>

            <div class="contact-card">
                <span><i class="fa-solid fa-envelope"></i></span>
                <div>
                    <strong>Email</strong>
                    <p>support@phpdevmarketplace.com</p>
                </div>
            </div>

            <div class="contact-card">
                <span><i class="fa-solid fa-phone"></i></span>
                <div>
                    <strong>Phone</strong>
                    <p>+91 98765 43210</p>
                </div>
            </div>

            <div class="contact-card">
                <span><i class="fa-solid fa-location-dot"></i></span>
                <div>
                    <strong>Location</strong>
                    <p>India · Remote First</p>
                </div>
            </div>

            <div class="contact-note">
                <p>
                    For business inquiries, partnerships, or enterprise support,
                    please mention <strong>“Business Inquiry”</strong> in the subject.
                </p>
            </div>
        </div>

        <!-- CONTACT FORM -->
        <div class="contact-form-wrapper">
            <h2>Send us a message</h2>

            <form class="contact-form" method="POST">
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="How can we help?" required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea rows="5" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" class="btn-primary">
                    Send Message <i class="fa-solid fa-paper-plane"></i>
                </button>

                <p class="form-hint">
                    By submitting this form, you agree to our Privacy Policy.
                </p>
            </form>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
