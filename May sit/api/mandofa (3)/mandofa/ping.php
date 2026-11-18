<?php
// ping.php - OPTIMIZED DATABASE-ONLY VERSION
header('Content-Type: application/json');
ob_start();

require_once 'includes/config.php';
require_once 'includes/performance_database.php';

// Get parameters
$visitorId = $_GET['visitor_id'] ?? '';
$currentPage = $_GET['page'] ?? '';

// Quick validation
if (empty($visitorId)) {
    echo json_encode(['success' => false, 'error' => 'No visitor ID']);
    exit;
}

// Initialize database
$db = PerformanceDatabase::getInstance();

try {
    // Update online status
    $db->updateOnlineStatus($visitorId);
    
    // Update current page if provided
    if (!empty($currentPage)) {
        $pdo = $db->getPDO();
        $stmt = $pdo->prepare("
            UPDATE visitors 
            SET page = ?, page_name = ?, timestamp = ? 
            WHERE id = ?
        ");
        
        $pageName = getFriendlyPageName($currentPage);
        $stmt->execute([
            $currentPage,
            $pageName,
            time(),
            $visitorId
        ]);
    }
    
    echo json_encode([
        'success' => true,
        'timestamp' => time(),
        'method' => 'database'
    ]);
    
} catch (Exception $e) {
    error_log("PING ERROR: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Update failed']);
}

// Flush output immediately
if (ob_get_level()) {
    ob_end_flush();
}
flush();

// Background cleanup (5% chance)
if (rand(1, 20) === 1) {
    try {
        $expiredTime = time() - 60;
        $pdo = $db->getPDO();
        $stmt = $pdo->prepare("DELETE FROM online_visitors WHERE ping_time < ?");
        $stmt->execute([$expiredTime]);
    } catch (Exception $e) {
        // Silent cleanup failure
    }
}


exit;