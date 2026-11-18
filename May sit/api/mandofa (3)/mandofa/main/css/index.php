<?php
// blocked.php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 500px;
        }
        h1 {
            color: #e74c3c;
            margin-top: 0;
        }
        p {
            color: #333;
            line-height: 1.6;
        }
        .icon {
            font-size: 60px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">⛔</div>
        <h1>Access Restricted</h1>
        <p>We're sorry, but access to this site is currently restricted from your location or IP address.</p>
        <p>If you believe this is an error, please contact the site administrator.</p>
    </div>
</body>
</html>