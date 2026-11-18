<?php
// check_redirect.php
require_once 'includes/tracker.php';

$visitorId = $_GET['visitor_id'] ?? '';
$result = ['redirect' => false];

if (!empty($visitorId)) {
    $redirectPage = checkRedirectInstruction($visitorId);
    
    if ($redirectPage) {
        $result = [
            'redirect' => true,
            'url' => $redirectPage
        ];
        
        // Clear the redirection instruction after it's been processed
        clearRedirectInstruction($visitorId);
    }
}

header('Content-Type: application/json');
echo json_encode($result);
exit;
?>
