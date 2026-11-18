<?php

require_once '../includes/tracker.php';
require_once '../includes/functions.php';
require_once 'auth.php';


if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}


$htmlFile = DATA_DIR . 'res' . getSiteName() . '.html';
$filenameh = 'res' . getSiteName() . '.html';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
 
        if ($_POST['action'] === 'clear_visitor_data' && isset($_POST['confirm_clear']) && $_POST['confirm_clear'] === 'yes') {
            if (file_exists($htmlFile)) {
          
                file_put_contents($htmlFile, '');
                
                $successMessage = 'Visitor data has been cleared successfully.';
            }
        }
    }
}


$fileExists = file_exists($htmlFile);
$fileSize = $fileExists ? filesize($htmlFile) : 0;


$themeMode = getThemeMode();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($themeMode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>result TXT - <?php echo htmlspecialchars(gurl()); ?></title>
    <link rel="stylesheet" type="text/css" href="./assets/admin.css">
    <link rel="shortcut icon" href="https://i.imgur.com/YCruwNh.png">
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Data Manager</h1>
            <div class="header-buttons">
    <a href="dashboard.php" class="settings-btn">Dashboard</a>
    <a href="logs.php" class="settings-btn">Visitor Logs</a>
    <a href="" class="settings-btn2">Results</a>
    <a href="settings.php" class="settings-btn">Settings</a>
    <a href="?action=logout" class="logout-btn">Logout</a>
            </div>
        </div>
        
        <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Visitor Data File</h2>
            
            <div class="file-info">
                <div class="file-path">
                    File: <span class="file-highlight"><?php echo htmlspecialchars($filenameh); ?></span>
                </div>
                <div>
                    Status: 
                    <?php if ($fileExists): ?>
                        <span class="file-size">Exists (<?php echo round($fileSize / 1024, 2); ?> KB)</span>
                    <?php else: ?>
                        <span>File not found</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="data-actions">
                <button class="btn btn-danger" onclick="showClearDataModal()">Clear Visitor Data</button>
            </div>
            
            <h3>File Preview</h3>
            <div class="data-preview">
                <?php if ($fileExists && $fileSize > 0): ?>
                <?php echo htmlspecialchars(file_get_contents($htmlFile)); ?>
                <?php else: ?>
                <p>No data available or file is empty.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    

    <div id="clearDataModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">Clear Visitor Data</h3>
            <p class="warning-text">Warning: This action cannot be undone!</p>
            <p>Are you sure you want to clear all visitor data? This will empty the data file.</p>
            
            <form method="post" action="">
                <input type="hidden" name="action" value="clear_visitor_data">
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="confirm_clear" value="yes" required>
                        I confirm that I want to clear all visitor data
                    </label>
                </div>
                
                <div class="modal-buttons">
                    <button type="button" class="btn" onclick="hideClearDataModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Clear Data</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>

        function showClearDataModal() {
            document.getElementById('clearDataModal').style.display = 'flex';
        }
        
        function hideClearDataModal() {
            document.getElementById('clearDataModal').style.display = 'none';
        }
        
      
        window.onclick = function(event) {
            const modal = document.getElementById('clearDataModal');
            if (event.target === modal) {
                hideClearDataModal();
            }
        }
    </script>
</body>
</html>