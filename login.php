<?php
/*
* Set up a constant to your main application path
*/

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

/*** CONFIG DATABASE ***/
require(APPLICATION_PATH . "/inc/db_config.php");

/*** CONNECT TO THE DATABASE ***/
include_once(APPLICATION_PATH . "/inc/db_connect.php");

if(isset($_POST['username']) && isset($_POST['password'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $cryptpass = crypt($password);
    include_once (APPLICATION_PATH . "/inc/randStrGen.php");
    $p_hash = randStrGen(20)."$cryptpass".randStrGen(20);

    $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    $sqlQuery = "SELECT id, email, password FROM tbl_customer WHERE email='$username' AND password='$password' LIMIT 1";


    $query = mysqli_query($db_connect, $sqlQuery);
    $numrows = mysqli_num_rows($query);

    if($numrows == 0){
        echo ':(';
    }else{

        $sql = "SELECT id FROM tbl_customer WHERE email='$username' AND password='$password' LIMIT 1";
        $query = mysqli_query($db_connect, $sql);
        while($row = mysqli_fetch_array($query)){
            $id = $row['id'];
            header("location: details.php?id=$id");
        }
    }

}
?>

<!doctype html>
<html id="htmlLogin">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="eLoyals">
		<meta name="author" content="Tomasz Piechota">
		<title>eLoyals - Your one stop Loyalty System</title>
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<link href="css/custom-shop.css" rel="stylesheet">
		<!-- HTML5 shim for IE backwards compatibility -->
		<!--[if lt IE 9]>
			  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->		
    <link rel="stylesheet" href="css/shop-login.css" type="text/css" media="screen" />
	<link href="css/custom.css" rel="stylesheet">

<!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="img/ico/favicon.png">
</head>

<body id="login">
	<div class="swirls">
		<div id="wrap">
			<div class="container header">
				<div class="row-fluid">
					<div id="shop-login" class="divFormWidthLogin">
						<ul id="shop-login-form">
							<li>
                                <form action='login.php' method="POST" name="login">
                                    <div class="shop-login-form-fields">

                                        <div class="shop-form">
                                            <div class="row-fluid shop-form-brand">
                                                <div class="span3"><img src="img/logo_v8.jpg" alt="eLoyals Logo"></div>
                                                <div class="span9"><span>eLoyals</span></div>
                                            </div>
                                            <hr />

                                            <?php

                                            if ( isset($_GET['errno'])) {

                                                require( "./inc/errno.inc.php" );

                                                echo "<div class=\"row-fluid\" >";

                                                echo "<div class=\"span10 offset2\" id=\"msg\"><br />";

                                                echo errno( $_GET['errno'] );

                                                echo "</div>";

                                                echo "</div>";

                                            }

                                            ?>
                                            <div class="block">
                                                <label for="shop_user_id">Username:&nbsp;</label>
                                                <input type="text" id="username" name="username" placeholder="Enter your username"/>
                                            </div>
                                            <div class="block">
                                                <label for="shop_user_password">Password:&nbsp;</label>
                                                <input type="password" id="password" name="password" placeholder="Enter your password"/></div>
                                        </div>
                                        <div class="shop-footer">
                                            <div>
                                                <button class="btn btn-success btn-go" onclick="return checkLogin();">Sign In</button>
                                                <!--Remember me
                                                <input type="checkbox" id="remember" name="remember" class="regular-checkbox" /><label for="remember"></label>-->
                                            </div>
                                        </div>
                                    </div>
                                </form>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
    </div>

<!--/.swirls --> 

<!-- Le javascript ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script src="js/fade_effects.js"></script>
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-carousel.js"></script> 
<script src="js/bootstrap-transition.js"></script><!-- controlls modals --> 
<!--<script src="js/bootstrap-alert.js"></script> 
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script> 
<script src="js/bootstrap-scrollspy.js"></script> 
<script src="js/bootstrap-tab.js"></script> 
<script src="js/bootstrap-tooltip.js"></script> 
<script src="js/bootstrap-popover.js"></script> 
<script src="js/bootstrap-button.js"></script> 
<script src="js/bootstrap-collapse.js"></script> 
<script src="js/bootstrap-typeahead.js"></script>-->
<script src="js/modal-responsive/modal-responsive-fix.js"></script>
<script src="js/modal-responsive/touchscroll.js"></script>
<script>
$(function() {
	$('.modal').modalResponsiveFix({ debug: true })
	$('.modal').touchScroll();
})
</script>

<!-- include jQuery + carouFredSel plugin -->
<script type="text/javascript" language="javascript" src="js/carouFredSel/jquery-1.8.2.min.js"></script>
<script type="text/javascript" language="javascript" src="js/carouFredSel/jquery.carouFredSel-6.2.0-packed.js"></script>

<!-- optionally include helper plugins -->
<script type="text/javascript" language="javascript" src="js/carouFredSel/helper-plugins/jquery.mousewheel.min.js"></script>
<script type="text/javascript" language="javascript" src="js/carouFredSel/helper-plugins/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" language="javascript" src="js/carouFredSel/helper-plugins/jquery.transit.min.js"></script>
<script type="text/javascript" language="javascript" src="js/carouFredSel/helper-plugins/jquery.ba-throttle-debounce.min.js"></script>

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
function myCollapse(){
	document.getElementById('NavDisplayButton').click();
}
</script>
</body>
</html>