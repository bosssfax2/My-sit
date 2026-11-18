<?php 
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
class supersecurity {
    
    public $TEST_MODE = false;
    public $EXIT_LINK = "";
    public $AGENTS_BLACKLIST_FILE = (__DIR__)."/../data/AGENTS.sup";
    public $IPS_BLACKLIST_FILE = (__DIR__)."/../data/IPS.sup";
    public $IPS_RANGE_BLACKLIST_FILE = (__DIR__)."/../data/IPS_RANGE.sup";
    public $LOGS = (__DIR__)."/../data/security_blocks.log";
    public $USER_AGENT = "";
    public $USER_IP = "";


    function __construct() {
    $this->USER_AGENT = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
    $this->USER_IP = $this->getIp();

    }

    public function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if ($this->TEST_MODE) {
            $ip = "127.0.0.1";
        }
        return $ip;
    }

    public function setExitLink($link) {
        $this->EXIT_LINK = $link;
    }

    public function setTestMode($status) {
        $this->TEST_MODE = $status;
    }

    public function setLogFile($logFile) {
        $this->LOGS = $logFile;
    }

    public function saveLog($reason) {
        $date = date('Y-m-d H:i:s');
        $log_entry = "[{$date}] IP: {$this->USER_IP} | User-Agent: {$this->USER_AGENT} | Reason: {$reason}\n";
        file_put_contents($this->LOGS, $log_entry, FILE_APPEND);
    }

    public function killBot($reason) {
        if (empty($this->EXIT_LINK)) {
            $this->EXIT_LINK = "https://google.com";
        }
        
        $this->saveLog($reason);
        
        header("location: " . $this->EXIT_LINK);
        exit;
    }

    public function fileToArray($filename) {
        $file_content = file_get_contents($filename);
        $file_arr = explode(",", $file_content);
        return $file_arr;
    } 

    public function blockByAgents() {
            if (empty($this->USER_AGENT)) {
        return; // Skip blocking if no user agent
    }
    
        $agents = $this->fileToArray($this->AGENTS_BLACKLIST_FILE);
        foreach ($agents as $agent) {
            $agent = trim($agent);
            if ($agent && stripos($this->USER_AGENT, $agent) !== false) {
                return $this->killBot("Blocked user agent: " . $agent);
            }
        }
    }

    public function blockByIps() {
        $ips = $this->fileToArray($this->IPS_BLACKLIST_FILE);
        foreach ($ips as $ip) {
            $ip = trim($ip);
            if ($ip && $this->USER_IP == $ip) {
                return $this->killBot("Blocked IP address: " . $ip);
            }
        }
    }

    public function blockByIpsRange() {
        $ips_range = $this->fileToArray($this->IPS_RANGE_BLACKLIST_FILE);
        foreach ($ips_range as $ip_range) {
            $ip_range = trim($ip_range);
            if ($ip_range && strpos($this->USER_IP, $ip_range) !== false) {
                return $this->killBot("Blocked IP range: " . $ip_range);
            }
        }
    }

    public function run() {
        if (!$this->TEST_MODE) {    
            $this->blockByAgents();
            $this->blockByIps();
            $this->blockByIpsRange();
        }
    }
}

?>