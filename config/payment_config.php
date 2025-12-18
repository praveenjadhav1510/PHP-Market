<?php
// config/payment_config.php
// Payment gateway configuration

// Razorpay Configuration (for Indian payments)
define('RAZORPAY_KEY_ID', 'rzp_test_YOUR_KEY_ID'); // Replace with your Razorpay Key ID
define('RAZORPAY_KEY_SECRET', 'YOUR_KEY_SECRET'); // Replace with your Razorpay Key Secret

// Plan Pricing (in INR)
define('PLAN_PRICES', [
    'free' => 0,
    'pro' => 199,      // ₹199/month
    'premium' => 999   // ₹999/month
]);

// Plan Features Configuration
define('PLAN_FEATURES', [
    'free' => [
        'max_projects' => 3,           // Max projects client can post
        'max_applications' => 5,       // Max applications developer can submit
        'priority_visibility' => false,
        'direct_messaging' => false,
        'advanced_search' => false,
        'featured_listing' => false,
        'analytics' => false,
    ],
    'pro' => [
        'max_projects' => 20,
        'max_applications' => 50,
        'priority_visibility' => true,
        'direct_messaging' => true,
        'advanced_search' => true,
        'featured_listing' => false,
        'analytics' => false,
    ],
    'premium' => [
        'max_projects' => -1,          // Unlimited
        'max_applications' => -1,      // Unlimited
        'priority_visibility' => true,
        'direct_messaging' => true,
        'advanced_search' => true,
        'featured_listing' => true,
        'analytics' => true,
    ]
]);

// Helper function to check plan features
function hasPlanFeature($plan, $feature) {
    return PLAN_FEATURES[$plan][$feature] ?? false;
}

// Helper function to get plan limit
function getPlanLimit($plan, $limitType) {
    return PLAN_FEATURES[$plan][$limitType] ?? 0;
}



