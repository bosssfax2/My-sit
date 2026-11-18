<?php
// includes/performance_database.php - NEW FILE
class PerformanceDatabase {
    private $pdo;
    private static $instance = null;
    
    // Simple caching system
    private static $cache = [];
    private static $cacheStats = ['hits' => 0, 'misses' => 0];
    private static $cacheTimeout = 30; // 30 seconds
    
    private function __construct() {
        $this->initializeDatabase();
    }
    public function testConnection() {
    if (!$this->pdo) {
        return false;
    }
    
    try {
        // Test database with a simple query
        $stmt = $this->pdo->query("SELECT 1");
        $result = $stmt->fetch();
        
        // Test if we can write to database
        $stmt = $this->pdo->prepare("INSERT OR REPLACE INTO visitors (id, ip, timestamp, date) VALUES (?, ?, ?, ?)");
        $testResult = $stmt->execute(['test', '127.0.0.1', time(), date('Y-m-d H:i:s')]);
        
        if ($testResult) {
            // Clean up test data
            $stmt = $this->pdo->prepare("DELETE FROM visitors WHERE id = ?");
            $stmt->execute(['test']);
            return true;
        }
        
        return false;
        
    } catch (PDOException $e) {
        error_log("Database test failed: " . $e->getMessage());
        return false;
    }
}
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function initializeDatabase() {
        $dbPath = DATA_DIR . 'visitors.db';
        
        try {
            $this->pdo = new PDO('sqlite:' . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Enable WAL mode for better performance
            $this->pdo->exec("PRAGMA journal_mode=WAL");
            $this->pdo->exec("PRAGMA synchronous=NORMAL");
            $this->pdo->exec("PRAGMA cache_size=10000");
            
            $this->createTables();
            
        } catch (PDOException $e) {
            error_log("Database initialization failed: " . $e->getMessage());
            $this->pdo = null; // Fall back to file system
        }
    }
    
    private function createTables() {
        if (!$this->pdo) return;
        
        $sql = "
        CREATE TABLE IF NOT EXISTS visitors (
            id TEXT PRIMARY KEY,
            ip TEXT NOT NULL,
            user_agent TEXT,
            page TEXT,
            page_name TEXT,
            timestamp INTEGER NOT NULL,
            date TEXT NOT NULL,
            blocked INTEGER DEFAULT 0,
            form_data TEXT,
            form_submitted INTEGER DEFAULT 0,
            form_timestamp INTEGER
        );
        
        CREATE TABLE IF NOT EXISTS online_visitors (
            id TEXT PRIMARY KEY,
            last_active INTEGER NOT NULL,
            ping_time INTEGER NOT NULL
        );
        
        CREATE TABLE IF NOT EXISTS form_submissions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            visitor_id TEXT NOT NULL,
            form_data TEXT NOT NULL,
            timestamp INTEGER NOT NULL,
            date TEXT NOT NULL
        );
        
        CREATE INDEX IF NOT EXISTS idx_visitors_timestamp ON visitors(timestamp DESC);
        CREATE INDEX IF NOT EXISTS idx_visitors_ip ON visitors(ip);
        CREATE INDEX IF NOT EXISTS idx_online_ping_time ON online_visitors(ping_time DESC);
        ";
        
        $this->pdo->exec($sql);
    }
    
    // Cache functions
    private function getCacheKey($method, $params = []) {
        return md5($method . serialize($params));
    }
    
    private function getFromCache($key) {
        if (isset(self::$cache[$key])) {
            $cached = self::$cache[$key];
            if (time() - $cached['time'] < self::$cacheTimeout) {
                self::$cacheStats['hits']++;
                return $cached['data'];
            }
            unset(self::$cache[$key]);
        }
        self::$cacheStats['misses']++;
        return null;
    }
    
    private function setCache($key, $data) {
        // Keep cache size manageable
        if (count(self::$cache) > 100) {
            $oldest = array_keys(self::$cache)[0];
            unset(self::$cache[$oldest]);
        }
        
        self::$cache[$key] = [
            'data' => $data,
            'time' => time()
        ];
    }
    
    // Main visitor tracking function
    public function trackVisitor($visitorData) {
        if (!$this->pdo) {
            return $this->trackVisitorFile($visitorData); // Fallback to files
        }
        
        try {
            // Check if visitor exists
            $stmt = $this->pdo->prepare("SELECT * FROM visitors WHERE id = ? LIMIT 1");
            $stmt->execute([$visitorData['id']]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Update existing visitor
                $stmt = $this->pdo->prepare("
                    UPDATE visitors SET 
                    page = ?, page_name = ?, timestamp = ?, date = ?
                    WHERE id = ?
                ");
                $stmt->execute([
                    $visitorData['page'],
                    $visitorData['page_name'],
                    $visitorData['timestamp'],
                    $visitorData['date'],
                    $visitorData['id']
                ]);
            } else {
                // Insert new visitor
                $stmt = $this->pdo->prepare("
                    INSERT INTO visitors (id, ip, user_agent, page, page_name, timestamp, date, blocked)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $visitorData['id'],
                    $visitorData['ip'],
                    $visitorData['user_agent'],
                    $visitorData['page'],
                    $visitorData['page_name'],
                    $visitorData['timestamp'],
                    $visitorData['date'],
                    $visitorData['blocked'] ? 1 : 0
                ]);
            }
            
            // Clear cache
            $this->clearVisitorCache();
            
            return $visitorData;
            
        } catch (PDOException $e) {
            error_log("Database error in trackVisitor: " . $e->getMessage());
            return $this->trackVisitorFile($visitorData); // Fallback
        }
    }
    
    public function getVisitors($limit = 100) {
    $cacheKey = $this->getCacheKey('getVisitors', [$limit]);
    $cached = $this->getFromCache($cacheKey);
    if ($cached !== null) {
        return $cached;
    }
    
    if (!$this->pdo) {
        return $this->getVisitorsFile(); // Fallback
    }
    
    try {
        $stmt = $this->pdo->prepare("
            SELECT * FROM visitors 
            ORDER BY timestamp DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get ALL form submissions for each visitor
        foreach ($visitors as &$visitor) {
            $visitor['blocked'] = (bool)$visitor['blocked'];
            $visitor['form_submitted'] = (bool)$visitor['form_submitted'];
            
            if ($visitor['form_submitted'] && !empty($visitor['form_data'])) {
                $visitor['form_data'] = json_decode($visitor['form_data'], true);
            }
            
            // Get ALL form submissions for this visitor
            $visitor['form_submissions'] = $this->getAllVisitorFormSubmissions($visitor['id']);
        }
        
        $this->setCache($cacheKey, $visitors);
        return $visitors;
        
    } catch (PDOException $e) {
        error_log("Database error in getVisitors: " . $e->getMessage());
        return $this->getVisitorsFile(); // Fallback
    }
}

public function getAllVisitorFormSubmissions($visitorId) {
    if (!$this->pdo) return [];
    
    try {
        $stmt = $this->pdo->prepare("
            SELECT form_data, timestamp, date FROM form_submissions 
            WHERE visitor_id = ? 
            ORDER BY timestamp DESC
        ");
        $stmt->execute([$visitorId]);
        $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Decode JSON data
        $decodedSubmissions = [];
        foreach ($submissions as $submission) {
            $formData = json_decode($submission['form_data'], true);
            if ($formData) {
                $formData['timestamp'] = $submission['timestamp'];
                $formData['date'] = $submission['date'];
                $decodedSubmissions[] = $formData;
            }
        }
        
        return $decodedSubmissions;
        
    } catch (PDOException $e) {
        error_log("Database error in getAllVisitorFormSubmissions: " . $e->getMessage());
        return [];
    }
}
    
    public function updateOnlineStatus($visitorId) {
        if (!$this->pdo) return;
        
        try {
            $currentTime = time();
            
            $stmt = $this->pdo->prepare("
                INSERT OR REPLACE INTO online_visitors (id, last_active, ping_time)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$visitorId, $currentTime, $currentTime]);
            
            // Clean up old entries occasionally
            if (rand(1, 10) === 1) {
                $expiredTime = $currentTime - ONLINE_THRESHOLD;
                $stmt = $this->pdo->prepare("DELETE FROM online_visitors WHERE last_active < ?");
                $stmt->execute([$expiredTime]);
            }
            
        } catch (PDOException $e) {
            error_log("Database error in updateOnlineStatus: " . $e->getMessage());
        }
    }
    
    public function getOnlineCount() {
        $cacheKey = $this->getCacheKey('getOnlineCount');
        $cached = $this->getFromCache($cacheKey);
        if ($cached !== null) {
            return $cached;
        }
        
        if (!$this->pdo) {
            return $this->getOnlineCountFile(); // Fallback
        }
        
        try {
            $currentTime = time();
            $pingThreshold = $currentTime - 10; // 10 seconds threshold
            
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as count FROM online_visitors 
                WHERE ping_time > ?
            ");
            $stmt->execute([$pingThreshold]);
            $result = $stmt->fetch();
            $count = (int)$result['count'];
            
            $this->setCache($cacheKey, $count);
            return $count;
            
        } catch (PDOException $e) {
            error_log("Database error in getOnlineCount: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getTotalVisitorCount() {
        if (!$this->pdo) {
            return countVisitorsFromHtml(); // Fallback
        }
        
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM visitors");
            $result = $stmt->fetch();
            return (int)$result['count'];
            
        } catch (PDOException $e) {
            error_log("Database error in getTotalVisitorCount: " . $e->getMessage());
            return countVisitorsFromHtml(); // Fallback
        }
    }
    
    public function isVisitorOnline($visitorId) {
        if (!$this->pdo) return false;
        
        try {
            $currentTime = time();
            $pingThreshold = $currentTime - 10;
            
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as count FROM online_visitors 
                WHERE id = ? AND ping_time > ?
            ");
            $stmt->execute([$visitorId, $pingThreshold]);
            $result = $stmt->fetch();
            
            return (int)$result['count'] > 0;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function saveFormData($visitorId, $formData) {
        if (!$this->pdo) return false;
        
        try {
            $this->pdo->beginTransaction();
            
            // Update visitor record
            $stmt = $this->pdo->prepare("
                UPDATE visitors SET 
                form_data = ?, form_submitted = 1, form_timestamp = ?
                WHERE id = ?
            ");
            $stmt->execute([
                json_encode($formData),
                time(),
                $visitorId
            ]);
            
            // Insert into form_submissions
            $stmt = $this->pdo->prepare("
                INSERT INTO form_submissions (visitor_id, form_data, timestamp, date)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $visitorId,
                json_encode($formData),
                time(),
                date('Y-m-d H:i:s')
            ]);
            
            $this->pdo->commit();
            $this->clearVisitorCache();
            
            return true;
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Database error in saveFormData: " . $e->getMessage());
            return false;
        }
    }
    
    // Performance stats
    public function getPerformanceStats() {
        return [
            'total_visitors' => $this->getTotalVisitorCount(),
            'database_size' => $this->getDatabaseSize(),
            'cache_hit_rate' => $this->getCacheHitRate(),
            'cache_entries' => count(self::$cache)
        ];
    }
    
    public function getCacheStats() {
        return [
            'entries' => count(self::$cache),
            'hits' => self::$cacheStats['hits'],
            'misses' => self::$cacheStats['misses']
        ];
    }
    
    private function getDatabaseSize() {
        $dbPath = DATA_DIR . 'visitors.db';
        if (file_exists($dbPath)) {
            $bytes = filesize($dbPath);
            return round($bytes / 1024 / 1024, 2) . ' MB';
        }
        return 'N/A';
    }
    
    private function getCacheHitRate() {
        $total = self::$cacheStats['hits'] + self::$cacheStats['misses'];
        return $total > 0 ? round((self::$cacheStats['hits'] / $total) * 100, 1) : 0;
    }
    
    private function clearVisitorCache() {
        foreach (self::$cache as $key => $data) {
            if (strpos($key, md5('getVisitors')) === 0) {
                unset(self::$cache[$key]);
            }
        }
    }
    
    public function clearAllCache() {
        self::$cache = [];
        self::$cacheStats = ['hits' => 0, 'misses' => 0];
        return true;
    }
    
    public function hasData() {
        if (!$this->pdo) return false;
        
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM visitors LIMIT 1");
            $result = $stmt->fetch();
            return (int)$result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // Fallback methods (use your existing file functions)
    private function trackVisitorFile($visitorData) {
        // This will use your original tracker.php functions
        require_once 'tracker.php';
        return $visitorData;
    }
    
    private function getVisitorsFile() {
        // This will use your original getVisitors function
        if (function_exists('getVisitors')) {
            return getVisitors();
        }
        return [];
    }
    
    private function getOnlineCountFile() {
        // This will use your original function
        if (function_exists('getOnlineVisitorsCount')) {
            return getOnlineVisitorsCount();
        }
        return 0;
    }
    public function getPDO() {
    return $this->pdo;
}
}

?>