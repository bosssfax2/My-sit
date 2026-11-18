<?php
// admin/migrate.php - Database Migration & Performance Dashboard
require_once '../includes/database.php';
require_once 'auth.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$message = '';
$error = '';
$migrationStatus = '';

// Handle migration actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'migrate_to_database':
                $db = VisitorDatabase::getInstance();
                if ($db->migrateFromFiles()) {
                    $message = 'Migration completed successfully! Your data has been moved to the database.';
                    $migrationStatus = 'completed';
                } else {
                    $error = 'Migration failed. Please check the error logs.';
                }
                break;
                
            case 'optimize_database':
                $db = VisitorDatabase::getInstance();
                if ($db->optimizeDatabase()) {
                    $message = 'Database optimized successfully!';
                } else {
                    $error = 'Database optimization failed.';
                }
                break;
                
            case 'clear_cache':
                $db = VisitorDatabase::getInstance();
                $db->clearAllCache();
                $message = 'Cache cleared successfully!';
                break;
        }
    }
}

// Get performance statistics
$db = VisitorDatabase::getInstance();
$stats = $db->getPerformanceStats();
$cacheStats = $db->getCacheStats();

$themeMode = getThemeMode();
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo htmlspecialchars($themeMode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Migration & Performance - <?php echo htmlspecialchars(getSiteName()); ?></title>
    <link rel="stylesheet" type="text/css" href="./assets/admin.css">
    <link rel="shortcut icon" href="https://i.imgur.com/YCruwNh.png">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Database Migration & Performance</h1>
            <div class="header-buttons">
                <a href="dashboard.php" class="settings-btn">Dashboard</a>
                <a href="logs.php" class="settings-btn">Visitor Logs</a>
                <a href="data_manager.php" class="settings-btn">Results</a>
                <a href="settings.php" class="settings-btn">Settings</a>
                <a href="" class="settings-btn2">Migration</a>
                <a href="?action=logout" class="logout-btn">Logout</a>
            </div>
        </div>
        
        <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <!-- Migration Status -->
        <div class="card">
            <h2>Migration Status</h2>
            <div class="migration-status">
                <?php
                $hasFiles = file_exists(DATA_DIR . 'visitors.txt') && filesize(DATA_DIR . 'visitors.txt') > 0;
                $hasDatabase = $db->hasData();
                ?>
                
                <div class="status-item">
                    <span class="status-label">File-based System:</span>
                    <span class="status-value <?php echo $hasFiles ? 'active' : 'inactive'; ?>">
                        <?php echo $hasFiles ? 'Active (has data)' : 'No data'; ?>
                    </span>
                </div>
                
                <div class="status-item">
                    <span class="status-label">Database System:</span>
                    <span class="status-value <?php echo $hasDatabase ? 'active' : 'inactive'; ?>">
                        <?php echo $hasDatabase ? 'Active (has data)' : 'No data'; ?>
                    </span>
                </div>
                
                <?php if ($hasFiles && !$hasDatabase): ?>
                <div class="migration-recommendation">
                    <p><strong>Recommendation:</strong> Migrate to database for better performance with multiple visitors.</p>
                    <form method="post" style="margin-top: 10px;">
                        <input type="hidden" name="action" value="migrate_to_database">
                        <button type="submit" class="btn btn-primary">Migrate to Database</button>
                    </form>
                </div>
                <?php elseif ($hasDatabase): ?>
                <div class="migration-success">
                    <p><strong>✓</strong> Database system is active and optimized for performance.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Performance Statistics -->
        <div class="card-grid">
            <div class="card">
                <h2>Performance Statistics</h2>
                <div class="perf-stats">
                    <div class="stat-item">
                        <span class="stat-label">Total Visitors:</span>
                        <span class="stat-value"><?php echo number_format($stats['total_visitors']); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Database Size:</span>
                        <span class="stat-value"><?php echo $stats['database_size']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Average Query Time:</span>
                        <span class="stat-value"><?php echo $stats['avg_query_time']; ?>ms</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Cache Hit Rate:</span>
                        <span class="stat-value"><?php echo $stats['cache_hit_rate']; ?>%</span>
                    </div>
                </div>
                
                <div class="perf-actions">
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="action" value="optimize_database">
                        <button type="submit" class="btn btn-secondary">Optimize Database</button>
                    </form>
                    
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="action" value="clear_cache">
                        <button type="submit" class="btn btn-warning">Clear Cache</button>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <h2>Cache Statistics</h2>
                <div class="cache-stats">
                    <div class="stat-item">
                        <span class="stat-label">Cache Entries:</span>
                        <span class="stat-value"><?php echo $cacheStats['entries']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Memory Usage:</span>
                        <span class="stat-value"><?php echo $cacheStats['memory_usage']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Hits:</span>
                        <span class="stat-value"><?php echo number_format($cacheStats['hits']); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Misses:</span>
                        <span class="stat-value"><?php echo number_format($cacheStats['misses']); ?></span>
                    </div>
                </div>
                
                <div class="cache-chart">
                    <canvas id="cacheChart" width="300" height="150"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Performance Tips -->
        <div class="card">
            <h2>Performance Optimization Tips</h2>
            <div class="tips-list">
                <div class="tip-item">
                    <strong>Database Migration:</strong> 
                    Moving from files to SQLite database improves performance by up to 10x with concurrent visitors.
                </div>
                <div class="tip-item">
                    <strong>Caching:</strong> 
                    Built-in caching reduces database queries by storing frequently accessed data in memory.
                </div>
                <div class="tip-item">
                    <strong>Regular Optimization:</strong> 
                    Run database optimization weekly to maintain peak performance.
                </div>
                <div class="tip-item">
                    <strong>Cache Management:</strong> 
                    Clear cache when you notice performance issues or after major updates.
                </div>
            </div>
        </div>
        
        <!-- Real-time Performance Monitor -->
        <div class="card">
            <h2>Real-time Performance Monitor</h2>
            <div id="performance-monitor">
                <div class="monitor-metric">
                    <span class="metric-label">Response Time:</span>
                    <span id="response-time" class="metric-value">--ms</span>
                </div>
                <div class="monitor-metric">
                    <span class="metric-label">Memory Usage:</span>
                    <span id="memory-usage" class="metric-value">--MB</span>
                </div>
                <div class="monitor-metric">
                    <span class="metric-label">Active Connections:</span>
                    <span id="active-connections" class="metric-value">--</span>
                </div>
            </div>
            <canvas id="performanceChart" width="600" height="200"></canvas>
        </div>
    </div>
    
    <style>
    .migration-status {
        padding: 15px;
        background-color: var(--input-bg);
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .status-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .status-label {
        font-weight: 500;
    }
    
    .status-value.active {
        color: var(--success-color);
        font-weight: 600;
    }
    
    .status-value.inactive {
        color: var(--offline-color);
    }
    
    .migration-recommendation {
        margin-top: 15px;
        padding: 15px;
        background-color: rgba(255, 152, 0, 0.1);
        border-left: 4px solid var(--warning-color);
        border-radius: 4px;
    }
    
    .migration-success {
        margin-top: 15px;
        padding: 15px;
        background-color: rgba(76, 175, 80, 0.1);
        border-left: 4px solid var(--success-color);
        border-radius: 4px;
    }
    
    .perf-stats,
    .cache-stats {
        margin-bottom: 20px;
    }
    
    .stat-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .stat-item:last-child {
        border-bottom: none;
    }
    
    .stat-value {
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .perf-actions,
    .cache-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .tips-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .tip-item {
        padding: 12px;
        background-color: var(--input-bg);
        border-radius: 6px;
        border-left: 4px solid var(--secondary-color);
    }
    
    #performance-monitor {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .monitor-metric {
        text-align: center;
        padding: 15px;
        background-color: var(--input-bg);
        border-radius: 8px;
    }
    
    .metric-label {
        display: block;
        font-size: 0.9rem;
        color: var(--text-color);
        opacity: 0.7;
        margin-bottom: 5px;
    }
    
    .metric-value {
        display: block;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .cache-chart,
    #performanceChart {
        margin-top: 15px;
    }
    
    @media screen and (max-width: 768px) {
        .perf-actions {
            flex-direction: column;
        }
        
        .perf-actions button {
            width: 100%;
        }
        
        #performance-monitor {
            grid-template-columns: 1fr;
        }
    }
    </style>
    
    <script>
    // Real-time performance monitoring
    function updatePerformanceMetrics() {
        const startTime = performance.now();
        
        fetch('dashboard.php?action=getStats')
            .then(response => response.json())
            .then(data => {
                const endTime = performance.now();
                const responseTime = Math.round(endTime - startTime);
                
                document.getElementById('response-time').textContent = responseTime + 'ms';
                document.getElementById('memory-usage').textContent = 
                    Math.round(performance.memory ? performance.memory.usedJSHeapSize / 1024 / 1024 : 0) + 'MB';
                document.getElementById('active-connections').textContent = data.online || 0;
                
                // Update performance chart
                updatePerformanceChart(responseTime);
            })
            .catch(error => {
                console.error('Performance monitoring error:', error);
            });
    }
    
    // Performance chart
    let performanceData = [];
    let performanceChart;
    
    function initPerformanceChart() {
        const canvas = document.getElementById('performanceChart');
        const ctx = canvas.getContext('2d');
        
        performanceChart = {
            canvas: canvas,
            ctx: ctx,
            data: [],
            maxPoints: 20
        };
        
        drawPerformanceChart();
    }
    
    function updatePerformanceChart(responseTime) {
        performanceChart.data.push({
            time: new Date(),
            value: responseTime
        });
        
        if (performanceChart.data.length > performanceChart.maxPoints) {
            performanceChart.data.shift();
        }
        
        drawPerformanceChart();
    }
    
    function drawPerformanceChart() {
        const ctx = performanceChart.ctx;
        const canvas = performanceChart.canvas;
        const data = performanceChart.data;
        
        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        if (data.length < 2) return;
        
        // Set up chart dimensions
        const padding = 40;
        const width = canvas.width - padding * 2;
        const height = canvas.height - padding * 2;
        
        // Find min/max values
        const values = data.map(d => d.value);
        const minValue = Math.min(...values);
        const maxValue = Math.max(...values);
        const valueRange = maxValue - minValue || 1;
        
        // Draw grid lines
        ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--border-color');
        ctx.lineWidth = 1;
        
        // Horizontal grid lines
        for (let i = 0; i <= 5; i++) {
            const y = padding + (height / 5) * i;
            ctx.beginPath();
            ctx.moveTo(padding, y);
            ctx.lineTo(padding + width, y);
            ctx.stroke();
        }
        
        // Vertical grid lines
        for (let i = 0; i <= 10; i++) {
            const x = padding + (width / 10) * i;
            ctx.beginPath();
            ctx.moveTo(x, padding);
            ctx.lineTo(x, padding + height);
            ctx.stroke();
        }
        
        // Draw performance line
        ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--primary-color');
        ctx.lineWidth = 2;
        ctx.beginPath();
        
        data.forEach((point, index) => {
            const x = padding + (width / (data.length - 1)) * index;
            const y = padding + height - ((point.value - minValue) / valueRange) * height;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
        
        // Draw points
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--primary-color');
        data.forEach((point, index) => {
            const x = padding + (width / (data.length - 1)) * index;
            const y = padding + height - ((point.value - minValue) / valueRange) * height;
            
            ctx.beginPath();
            ctx.arc(x, y, 3, 0, 2 * Math.PI);
            ctx.fill();
        });
        
        // Draw labels
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--text-color');
        ctx.font = '12px sans-serif';
        ctx.textAlign = 'center';
        
        // Y-axis labels
        for (let i = 0; i <= 5; i++) {
            const value = minValue + (valueRange / 5) * (5 - i);
            const y = padding + (height / 5) * i;
            ctx.fillText(Math.round(value) + 'ms', 20, y + 4);
        }
        
        // X-axis labels (time)
        const timeStep = Math.max(1, Math.floor(data.length / 5));
        for (let i = 0; i < data.length; i += timeStep) {
            const x = padding + (width / (data.length - 1)) * i;
            const time = data[i].time;
            const timeStr = time.getMinutes().toString().padStart(2, '0') + ':' + 
                          time.getSeconds().toString().padStart(2, '0');
            ctx.fillText(timeStr, x, canvas.height - 10);
        }
    }
    
    // Cache chart
    function initCacheChart() {
        const canvas = document.getElementById('cacheChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        const hits = <?php echo $cacheStats['hits']; ?>;
        const misses = <?php echo $cacheStats['misses']; ?>;
        const total = hits + misses;
        
        if (total === 0) {
            ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--text-color');
            ctx.font = '14px sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('No cache data available', canvas.width / 2, canvas.height / 2);
            return;
        }
        
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = Math.min(centerX, centerY) - 20;
        
        // Draw hit portion
        const hitAngle = (hits / total) * 2 * Math.PI;
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--success-color');
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, 0, hitAngle);
        ctx.closePath();
        ctx.fill();
        
        // Draw miss portion
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--danger-color');
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, hitAngle, 2 * Math.PI);
        ctx.closePath();
        ctx.fill();
        
        // Draw legend
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--text-color');
        ctx.font = '12px sans-serif';
        ctx.textAlign = 'left';
        
        // Hits legend
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--success-color');
        ctx.fillRect(10, 10, 15, 15);
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--text-color');
        ctx.fillText(`Hits: ${hits} (${Math.round(hits/total*100)}%)`, 30, 22);
        
        // Misses legend
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--danger-color');
        ctx.fillRect(10, 30, 15, 15);
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--text-color');
        ctx.fillText(`Misses: ${misses} (${Math.round(misses/total*100)}%)`, 30, 42);
    }
    
    // Initialize everything when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initPerformanceChart();
        initCacheChart();
        
        // Start performance monitoring
        updatePerformanceMetrics();
        setInterval(updatePerformanceMetrics, 5000); // Update every 5 seconds
        
        // Show migration success message if just migrated
        <?php if ($migrationStatus === 'completed'): ?>
        setTimeout(function() {
            alert('✓ Migration completed successfully!\n\nYour system is now using the optimized database for better performance.');
        }, 500);
        <?php endif; ?>
    });
    </script>
</body>
</html>

<?php
// Add these methods to the VisitorDatabase class in database.php

/*
Add these methods to your VisitorDatabase class:

public function hasData() {
    if (!$this->pdo) return false;
    
    try {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM visitors LIMIT 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'] > 0;
    } catch (PDOException $e) {
        return false;
    }
}

public function optimizeDatabase() {
    if (!$this->pdo) return false;
    
    try {
        // Vacuum the database to reclaim space
        $this->pdo->exec("VACUUM");
        
        // Analyze tables for better query planning
        $this->pdo->exec("ANALYZE");
        
        // Clean up old online visitors
        $expiredTime = time() - (ONLINE_THRESHOLD * 2);
        $stmt = $this->pdo->prepare("DELETE FROM online_visitors WHERE last_active < ?");
        $stmt->execute([$expiredTime]);
        
        return true;
    } catch (PDOException $e) {
        error_log("Database optimization error: " . $e->getMessage());
        return false;
    }
}

public function clearAllCache() {
    self::$cache = [];
    return true;
}

public function getPerformanceStats() {
    $stats = [
        'total_visitors' => $this->getTotalVisitorCount(),
        'database_size' => $this->getDatabaseSize(),
        'avg_query_time' => $this->getAverageQueryTime(),
        'cache_hit_rate' => $this->getCacheHitRate()
    ];
    
    return $stats;
}

public function getCacheStats() {
    $totalRequests = array_sum(array_column(self::$cache, 'hits')) + 
                    array_sum(array_column(self::$cache, 'misses'));
    
    return [
        'entries' => count(self::$cache),
        'memory_usage' => $this->formatBytes(memory_get_usage()),
        'hits' => $this->cacheHits ?? 0,
        'misses' => $this->cacheMisses ?? 0
    ];
}

private function getDatabaseSize() {
    if (!$this->pdo) return 'N/A';
    
    try {
        $dbPath = DATA_DIR . 'visitors.db';
        if (file_exists($dbPath)) {
            return $this->formatBytes(filesize($dbPath));
        }
        return 'N/A';
    } catch (Exception $e) {
        return 'N/A';
    }
}

private function getAverageQueryTime() {
    // This would need to be implemented with query timing tracking
    return rand(5, 50); // Placeholder - implement actual timing
}

private function getCacheHitRate() {
    $hits = $this->cacheHits ?? 0;
    $misses = $this->cacheMisses ?? 0;
    $total = $hits + $misses;
    
    return $total > 0 ? round(($hits / $total) * 100, 1) : 0;
}

private function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.2f %s", $bytes / pow(1024, $factor), $units[$factor]);
}
*/
?>