<?php

require_once 'auth.php';
require_once '../includes/functions.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$themeMode = getThemeMode();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($themeMode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="./assets/admin.css">
    <link rel="shortcut icon" href="https://i.imgur.com/YCruwNh.png">
</head>
<body><center>
    <div class="login-container">

        <div class="site-name"><center><img src="https://i.imgur.com/5KaISac.gif" width="100px"></center></div>
        
        <?php if (isset($loginError)): ?>
        <div class="error-message"><?php echo $loginError; ?></div>
        <?php endif; ?>
        
        <form method="post" action="">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password"  class="form-control" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>