<?php
session_start();
// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: message.php?msg=NO to that looser");
    exit();
}
/*
 * Set up a constant to your main application path
 */

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

//for menu item highlighting
$activeIndex = "active";


/*** CONFIG DATABASE ***/
require(APPLICATION_PATH . "/inc/db_config.php");

/*** CONNECT TO THE DATABASE ***/
include_once(APPLICATION_PATH . "/inc/db_connect.php");
?>
<?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["usernamecheck"])){
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users_test WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_connect, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
		echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
		exit();
	}
	if(is_numeric($username[0])){
	   echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	   exit();
	}
	if($uname_check < 1){
		echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
		exit();
	}else{
		echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
		exit();
	}
}
?>
<?php
// Ajax calls this EMAIL CHECK code to execute
if(isset($_POST["emailcheck"])){
	$email = preg_replace('#[^a-z0-9@.-_]#i', '', $_POST['emailcheck']);
	$sql = "SELECT id FROM users_test WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_connect, $sql); 
	$e_check = mysqli_num_rows($query);
    if ($e_check > 0){
		echo '<strong style="color:#F00;">That email address is already in use in the system</strong>';
   		exit();
	}else{
		echo '<strong style="color:#009900;">' . $email . ' is OK</strong>';
	   	exit();
	}
}
?>
<?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["u"])){
	// CONNECT TO THE DATABASE
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_connect, $_POST['e']);
	$p = $_POST['p'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']); // only lowercase
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')); // Only numbers and '.'
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users_test WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_connect, $sql); 
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users_test WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_connect, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($u == "" || $e == "" || $p == "" || $g == "" || $c == ""){
		echo "The form submission is missing values.";
    	exit();
	}else if($u_check > 0){ 
		echo "The username you entered is alreay taken";
		exit();
	}else if($e_check > 0){ 
		echo "That email address is already in use in the system";
		exit();
	}else if(strlen($u) < 3 || strlen($u) > 16){
		echo "Username must be between 3 and 16 characters";
		exit(); 
	}else if(is_numeric($u[0])){
		echo 'Username cannot begin with a number';
		exit();
	}else{
		// END FORM DATA ERROR HANDLING
		// Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		$cryptpass = crypt($p);
		$p_hash = randStrGen(20)."$cryptpass".randStrGen(20);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users_test (username, email, password, gender, country, ip, signup, lastlogin)       
			   VALUES('$u','$e','$p_hash','$g','$c','$ip',now(),now())";
		$query = mysqli_query($db_connect, $sql); 
		$uid = mysqli_insert_id($db_connect);
		
		// -------------------------------------------
		$sql = "SELECT * FROM users_test WHERE email='$e' LIMIT 1";
    	$query = mysqli_query($db_connect, $sql);
		while($row = mysqli_fetch_array($query)){
			$uid = $row["id"];
			$user = $row["username"];
			$email_ins = $row["email"];
			$pass = $row["password"];
		
		// Email the user their activation link
		$to = "$email_ins";	 
		$from = "auto-respond@webmojo.eu";
		$subject = 'eLoyals Account Activation';		
		$message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>eLoyals Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.eloyals.webmojo.eu/index.php"><img src="http://www.eloyals.webmojo.eu/img/eloyals-logo-50x55.png" alt="eLoyals" style="border:none; float:left;"></a>eLoyals Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.eloyals.webmojo.eu/activation.php?id='.$uid.'&u='.$user.'&e='.$email_ins.'&p='.$pass.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
		$headers = "From: $from\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		if(mail($to, $subject, $message, $headers)){
			echo 'OK';
		}else{
			echo 'Something went wrong with the mailing thing.';
		};
		echo "signup_success";
		exit();
		}
	}
	exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="eLoyals">
<meta name="author" content="Tomasz Piechota">
<title>eLoyals - Your one stop Loyalty System</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/sticky-footer.css" rel="stylesheet" type="text/css">
<link href="css/custom.css" rel="stylesheet">
<link href="css/modal.css" rel="stylesheet">


<script>
function restrict(elem){
var tf = _(elem);
var rx = new RegExp;
if(elem == "email"){
rx = /[' "]/gi;
} else if(elem == "username"){
rx = /[^a-z0-9]/gi;
}
tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
_(x).innerHTML = "";
}

function checkusername(){
var u = _("username").value;
if(u != ""){
_("unamestatus").innerHTML = '<img src="img/spinners/loadinfo.net.gif" alt="checking" />';
var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           _("unamestatus").innerHTML = ajax.responseText;
       }
        }
        ajax.send("usernamecheck="+u);
}
}

function checkpassword(){
var p1 = _("pass1").value;
var p2 = _("pass2").value;

if (p2 != p1) {
	_("pwdstatus1").innerHTML = '<strong style="color:#F00;">Passwords do not match!</strong>';
	_("pwdstatus2").innerHTML = '<strong style="color:#F00;">Passwords do not match!</strong>';
}else{
	_("pwdstatus1").innerHTML = '<strong style="color:#009900;">OK</strong>';
	_("pwdstatus2").innerHTML = '<strong style="color:#009900;">OK</strong>';
}
}

function checkemail(){
var e = _("email").value;

if(e != ""){
_("emailstatus").innerHTML = '<img src="img/spinners/loadinfo.net.gif" alt="checking" />';
var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           _("emailstatus").innerHTML = ajax.responseText;
       }
        }
        ajax.send("emailcheck="+e);
}
}

function signup(){
var u = _("username").value;
var e = _("email").value;
var p1 = _("pass1").value;
var p2 = _("pass2").value;
var c = _("country").value;
var g = _("gender").value;
var status = _("status");
if(u == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == ""){
status.innerHTML = "Fill out all of the form data";
} else if(p1 != p2){
status.innerHTML = "Your password fields do not match";
} else if( _("terms").style.display == "none"){
status.innerHTML = "<strong style=\"color:#F00;\">Please view the terms of use</strong>";
} else {
_("signupbtn").disabled = false;
status.innerHTML = '<img src="img/spinners/loadinfo.net2.gif" alt="checking" />';
var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
       if(ajaxReturn(ajax) == true) {
           if(ajax.responseText != "signup_success"){
status.innerHTML = ajax.responseText;
_("signupbtn").disabled = false;
} else {
<!--window.scrollTo(0,0);-->
_("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
}
       }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1+"&c="+c+"&g="+g);
}
}
function openTerms(){
_("terms").style.display = "block";
emptyElement("status");
}
/* function addEvents(){
_("elemID").addEventListener("click", func, false);
}
window.onload = addEvents; */
</script>
<!-- HTML5 shim for IE backwards compatibility -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
<!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="img/ico/favicon.png">
</head>

<body>
<div class="swirls">
  <div id="wrap">

  <!-- HEADER MENU -->
  <?php require(TEMPLATE_PATH . "/public/header-main.php") ?>
  <!-- / HEADER MENU -->


  <!-- MAIN MENU -->
  <?php require(TEMPLATE_PATH . "/public/menu-main.php") ?>
  <!-- / MAIN MENU -->
    
    <div class="container-fluid">
      <div class="hero-unit">
        <div class="carousel slide" id="myCarousel">
          <div class="carousel-inner">
            <div class="item active"><img src="img/carousel/slide-04.jpg" height="550px" alt=""> 
              <!--<div class="carousel-caption">
                <h4>Slide 1</h4>
                <p>In reprehenderit in voluptate quis nostrud exercitation consectetur adipisicing elit. Ut labore et dolore magna aliqua. Ut aliquip ex ea commodo consequat.</p
              </div>>--> 
            </div>
            <div class="item"> <img src="img/carousel/slide-01.jpg" alt="">
              <div class="carousel-caption">
                <h4>Slide 1</h4>
                <p>In reprehenderit in voluptate quis nostrud exercitation consectetur adipisicing elit. Ut labore et dolore magna aliqua. Ut aliquip ex ea commodo consequat.</p>
              </div>
            </div>
            <div class="item"> <img src="img/carousel/slide-02.jpg" alt="">
              <div class="carousel-caption">
                <h4>Slide 2</h4>
                <p>In reprehenderit in voluptate quis nostrud exercitation consectetur adipisicing elit. Ut labore et dolore magna aliqua. Ut aliquip ex ea commodo consequat.</p>
              </div>
            </div>
            <div class="item"> <img src="img/carousel/slide-03.jpg" alt="">
              <div class="carousel-caption">
                <h4>Slide 3</h4>
                <p>In reprehenderit in voluptate quis nostrud exercitation consectetur adipisicing elit. Ut labore et dolore magna aliqua. Ut aliquip ex ea commodo consequat.</p>
              </div>
            </div>
          </div>
          
          <!--        <a href="#myCarousel" class="left carousel-control-x" data-slide="prev"></a> <a href="#myCarousel" class="right carousel-control-x" data-slide="next"></a>--> 
          <a href="#myCarousel" class="left carousel-control" data-slide="prev">&lsaquo;</a> <a href="#myCarousel" class="right carousel-control" data-slide="next">&rsaquo;</a> </div>
        <!--/.hero-unit --> 
      </div>
      <div class="row-fluid"><!-- hero-unit bottom shadow -->
        <div class="span12 hero-unit-shadow-bottom"></div>
      </div>
      <div class="row-fluid">
        <div class="span4">
          <div class="content advert">
<!--            <h2>Heading</h2>-->
            <p><img src="img/ads/business-boost.png" alt="Boost your business" width="200px" /></p>
            <p><a class="btn btn-primary" href="retailers.php#">Read more &raquo;</a></p>
          </div>
          <div class="row-fluid"><!-- content-box bottom shadow -->
            <div class="content-box-shadow-bottom"></div>
          </div>
        </div>
        <div class="span4">
          <div class="content advert">
<!--            <h1>Heading</h1>-->
            <p><img src="img/ads/faq-ad.png" alt="Boost your business" width="154px" /></p>
            <p><a class="btn btn-primary" href="customers.php">Read more &raquo;</a></p>
          </div>
          <div class="row-fluid"><!-- content-box bottom shadow -->
            <div class="content-box-shadow-bottom"></div>
          </div>
        </div>
        <div class="span4">
          <div class="content advert">
<!--            <h2>Heading</h2>-->
            <p><img src="img/ads/signup.png" alt="Boost your business" width="194px" /></p>
            <p><a class="btn btn-primary" href="register.php">Read more &raquo;</a></p>
          </div>
          <div class="row-fluid"><!-- content-box bottom shadow -->
            <div class="content-box-shadow-bottom"></div>
          </div>
        </div>
      </div>
      
        <!-- PARTNERS -->
        <?php include(TEMPLATE_PATH . "/public/partners-main.php") ?>
        <!-- / FPARTNERS -->

    </div><!--/.container -->
    
    <div id="push"></div>
    
  </div><!--/#wrap -->

<!-- FOOTER MENU -->
<?php require(TEMPLATE_PATH . "/public/footer-main.php") ?>
<!-- / FOOTER MENU -->

</div><!--/.swirls -->




<!-- Le javascript ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script src="js/fade_effects.js"></script>
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-carousel.js"></script> 
<script src="js/bootstrap-transition.js"></script><!-- controlls modals --> 
<script src="js/modal-responsive/modal-responsive-fix.js"></script>
<script src="js/modal-responsive/touchscroll.js"></script>

<script>
$(function() {
	$('.modal').modalResponsiveFix({ debug: true });
	$('.modal').touchScroll();
})
</script>

<!-- include jQuery + carouFredSel plugin -->
<script src="js/carouFredSel/jquery-1.8.2.min.js"></script>
<script src="js/carouFredSel/jquery.carouFredSel-6.2.0-packed.js"></script>

<!-- optionally include helper plugins -->
<script src="js/carouFredSel/helper-plugins/jquery.mousewheel.min.js"></script>
<script src="js/carouFredSel/helper-plugins/jquery.touchSwipe.min.js"></script>
<script src="js/carouFredSel/helper-plugins/jquery.transit.min.js"></script>
<script src="js/carouFredSel/helper-plugins/jquery.ba-throttle-debounce.min.js"></script>

<!-- fire plugin onDocumentReady -->

<script type="text/javascript" language="javascript">
$(function() {
	//	Responsive layout, resizing the items
	$('#partners').carouFredSel({
		responsive: true,
		width: '100%',
		scroll: 1,
		items: {
			width: 100,
			//height: '30%',	//	optionally resize item-height
			visible: {
				min: 2,
				max: 6
			}
		}
	});
});
</script>

<script type="text/javascript">
/*$('li a').click(function (e) {
		$('#NavDisplayButton').click();
		 return false;
});
this.click( function() {  } );*/

</script>
<script>
// Collapse menu after click action on the menu link when in responsive mode
function myCollapse(){
	document.getElementById('NavDisplayButton').click();
}
</script>
</body>
</html>