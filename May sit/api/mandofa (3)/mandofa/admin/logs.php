<?php

require_once '../includes/tracker.php';
require_once '../includes/functions.php'; 
require_once 'auth.php';


if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}
$totalCount = countVisitorsFromHtml();

function parseVisitorHtmlFile() {
    $htmlFile = DATA_DIR . getSiteName() . '.html';
    
    if (!file_exists($htmlFile) || filesize($htmlFile) === 0) {
        return [];
    }
    
  
    $lines = file($htmlFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $visitors = [];
    foreach ($lines as $line) {

        if (strpos($line, '<tr><td') === false) {
            continue;
        }
        

        $data = [];
        
    
        $line = str_replace('</td><td', '</td>|<td', $line);
     
        $cleanLine = strip_tags($line);
        

        $parts = explode('|', $cleanLine);
        
   
        $parts = array_map('trim', $parts);
        
   
        if (count($parts) >= 5) {
            $visitors[] = [
                'ip' => $parts[0] ?? 'Unknown',
                'browser' => $parts[1] ?? 'Unknown', 
                'os' => $parts[2] ?? 'Unknown',
                'country' => $parts[3] ?? 'Unknown',
                'date' => $parts[4] ?? 'Unknown'
            ];
        }
    }
    
    return array_reverse($visitors);
}

function extractVisitorData() {
    $htmlFile = DATA_DIR . getSiteName() . '.html';
    
    if (!file_exists($htmlFile)) {
        return [];
    }
    
    $content = file_get_contents($htmlFile);
    $visitors = [];
    

    preg_match_all('/<td[^>]*>(.*?)<\/td>/si', $content, $matches);
    
    if (!empty($matches[1])) {
        $cells = $matches[1];
        

        $cellCount = count($cells);
        for ($i = 0; $i < $cellCount; $i += 5) {
            if ($i + 4 < $cellCount) {
                $visitors[] = [
                    'ip' => strip_tags($cells[$i]),
                    'browser' => strip_tags($cells[$i+1]),
                    'os' => strip_tags($cells[$i+2]),
                    'country' => strip_tags($cells[$i+3]),
                    'date' => strip_tags($cells[$i+4])
                ];
            }
        }
    }
    
    return array_reverse($visitors);
}

$visitors = function_exists('parseVisitorHtmlFile') ? parseVisitorHtmlFile() : 
           (function_exists('extractVisitorData') ? extractVisitorData() : []);

$blockedIps = explode(',', getConfig('blocked_ips') ?? '');
$blockedIps = array_filter($blockedIps); 

if (isset($_POST['action']) && $_POST['action'] === 'clear_logs') {
    if (isset($_POST['confirm_clear']) && $_POST['confirm_clear'] === 'yes') {
      
        $htmlFile = DATA_DIR . getSiteName() . '.html';
        file_put_contents($htmlFile, '');
        
        $successMessage = 'Visitor logs have been cleared successfully.';
        $visitors = []; 
    }
}


$itemsPerPage = 50;
$totalVisitors = count($visitors);
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalPages = max(1, ceil($totalVisitors / $itemsPerPage));
$currentPage = min($currentPage, $totalPages);

$pageVisitors = array_slice($visitors, ($currentPage - 1) * $itemsPerPage, $itemsPerPage);


$themeMode = getThemeMode();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($themeMode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Logs - <?php echo htmlspecialchars(gurl()); ?></title>
 <link rel="stylesheet" type="text/css" href="./assets/admin.css">
 <link rel="shortcut icon" href="https://i.imgur.com/YCruwNh.png">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Visitor Logs</h1>
            <div class="header-buttons">
    <a href="dashboard.php" class="settings-btn">Dashboard</a>
    <a href="" class="settings-btn2">Visitor Logs</a>
    <a href="data_manager.php" class="settings-btn">Results</a>
    <a href="settings.php" class="settings-btn">Settings</a>
    <a href="?action=logout" class="logout-btn">Logout</a>
            </div>
        </div>

        <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        
        <div class="card">
    <h2>Visitor Data</h2>
	 <div class="action-bar">
                <button class="btn btn-danger" onclick="showClearLogsModal()">Clear Visitor Logs</button>
                <div>
                    <span>Total visitors: <strong><?php echo $totalCount; ?></strong></span>
                </div>
            </div>
    <?php
    $htmlFile = DATA_DIR . getSiteName() . '.html';
    if (file_exists($htmlFile) && filesize($htmlFile) > 0): 
        $content = file_get_contents($htmlFile);
        
        
        echo '<div class="table-container">';
        echo '<table class="data-table">';
        echo '<tr>
            <th>IP Address</th>
            <th>Browser</th>
            <th>OS</th>
            <th>Country</th>
            <th>Date/Time</th>
        </tr>';
        
      
        $rows = preg_split('/<\/tr>/', $content);
        
        foreach ($rows as $row) {
            if (empty(trim($row))) continue;
        
            $row = str_replace(['<tr>', '</tr>'], '', $row);
            echo '<tr>' . $row . '</tr>';
        }
        
        echo '</table>';
        echo '</div>';
    else:
    ?>
    <div class="empty-state">
        <p>No visitor logs found.</p>
    </div>
    <?php endif; ?>
</div>
        
        <div class="card">
            <h2>Blocked IP Addresses</h2>
            
            <?php if (empty($blockedIps)): ?>
            <div class="empty-state">
                <p>No blocked IP addresses found.</p>
            </div>
            <?php else: ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blockedIps as $ip): ?>
                        <?php if (!empty(trim($ip))): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(trim($ip)); ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="unblockIp('<?php echo htmlspecialchars(trim($ip)); ?>')">Unblock</button>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    
    <div id="clearLogsModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">Clear Visitor Logs</h3>
            <p class="warning-text">Warning: This action cannot be undone!</p>
            <p>Are you sure you want to clear all visitor logs?</p>
            
            <form method="post" action="">
                <input type="hidden" name="action" value="clear_logs">
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="confirm_clear" value="yes" required>
                        I confirm that I want to clear all visitor logs
                    </label>
                </div>
                
                <div class="modal-buttons">
                    <button type="button" class="btn" onclick="hideClearLogsModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Clear Logs</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    
        function showClearLogsModal() {
            document.getElementById('clearLogsModal').style.display = 'flex';
        }
        
        function hideClearLogsModal() {
            document.getElementById('clearLogsModal').style.display = 'none';
        }
        
        
        function blockIp(ip) {
            if (confirm('Are you sure you want to block IP: ' + ip + '?')) {
         
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'settings.php';
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'update_blocked_ips';
                
                const ipInput = document.createElement('input');
                ipInput.type = 'hidden';
                ipInput.name = 'new_blocked_ip';
                ipInput.value = ip;
                
                form.appendChild(actionInput);
                form.appendChild(ipInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
   
        function unblockIp(ip) {
            if (confirm('Are you sure you want to unblock IP: ' + ip + '?')) {
            
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'settings.php';
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'update_blocked_ips';
        
                const blockedIps = <?php echo json_encode($blockedIps); ?>;
                const updatedIps = blockedIps.filter(blockedIp => blockedIp !== ip);
                
                const ipsInput = document.createElement('input');
                ipsInput.type = 'hidden';
                ipsInput.name = 'blocked_ips';
                ipsInput.value = updatedIps.join(',');
                
                form.appendChild(actionInput);
                form.appendChild(ipsInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
 
        window.onclick = function(event) {
            const modal = document.getElementById('clearLogsModal');
            if (event.target === modal) {
                hideClearLogsModal();
            }
        }
    </script>
</body>
</html>
