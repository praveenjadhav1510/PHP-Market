<?php
// includes/plan-check.php
// Helper functions for plan-based feature checks

require_once __DIR__ . '/../config/payment_config.php';
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Get current user's plan
 */
function getCurrentPlan() {
    if (!isset($_SESSION['user_id'])) {
        return 'free';
    }
    
    global $pdo;
    $stmt = $pdo->prepare("SELECT plan FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['plan'] = $user['plan'];
        return $user['plan'] ?? 'free';
    }
    
    return 'free';
}

/**
 * Check if user can perform an action based on plan
 */
function canPerformAction($action, $userId = null) {
    if ($userId === null) {
        $userId = $_SESSION['user_id'] ?? null;
    }
    
    if (!$userId) {
        return false;
    }
    
    $plan = getCurrentPlan();
    
    switch ($action) {
        case 'create_project':
            return checkProjectLimit($userId, $plan);
        case 'apply_project':
            return checkApplicationLimit($userId, $plan);
        case 'priority_visibility':
            return hasPlanFeature($plan, 'priority_visibility');
        case 'direct_messaging':
            return hasPlanFeature($plan, 'direct_messaging');
        case 'advanced_search':
            return hasPlanFeature($plan, 'advanced_search');
        case 'featured_listing':
            return hasPlanFeature($plan, 'featured_listing');
        case 'analytics':
            return hasPlanFeature($plan, 'analytics');
        default:
            return false;
    }
}

/**
 * Check if user has reached project limit
 */
function checkProjectLimit($userId, $plan) {
    global $pdo;
    
    $maxProjects = getPlanLimit($plan, 'max_projects');
    
    // Unlimited for premium
    if ($maxProjects === -1) {
        return true;
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM projects WHERE user_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    
    return ($result['count'] ?? 0) < $maxProjects;
}

/**
 * Check if user has reached application limit
 */
function checkApplicationLimit($userId, $plan) {
    global $pdo;
    
    $maxApplications = getPlanLimit($plan, 'max_applications');
    
    // Unlimited for premium
    if ($maxApplications === -1) {
        return true;
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM project_applications WHERE developer_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    
    return ($result['count'] ?? 0) < $maxApplications;
}

/**
 * Get remaining project slots
 */
function getRemainingProjects($userId, $plan) {
    global $pdo;
    
    $maxProjects = getPlanLimit($plan, 'max_projects');
    
    if ($maxProjects === -1) {
        return 'Unlimited';
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM projects WHERE user_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    $used = $result['count'] ?? 0;
    
    return max(0, $maxProjects - $used);
}

/**
 * Get remaining application slots
 */
function getRemainingApplications($userId, $plan) {
    global $pdo;
    
    $maxApplications = getPlanLimit($plan, 'max_applications');
    
    if ($maxApplications === -1) {
        return 'Unlimited';
    }
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM project_applications WHERE developer_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    $used = $result['count'] ?? 0;
    
    return max(0, $maxApplications - $used);
}



