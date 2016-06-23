<?php
session_start();
// If user is logged in, header them away
if (isset($_SESSION["username"])) {
    header("location: message.php?msg=NO to that looser");
    exit();
}

/*
 * Set up a constant to your main application path
 */

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

//for menu item highlighting
$activeRegister = "active";

// CONNECT TO THE DATABASE
include_once(APPLICATION_PATH . "/inc/db_connect.php");

?>
<?php
// Ajax calls this NAME CHECK code to execute
if (isset($_POST["usernamecheck"])) {
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
    $sql = "SELECT id FROM users_test WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
        echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
        exit();
    }
    if (is_numeric($username[0])) {
        echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
        exit();
    }
    if ($uname_check < 1) {
        echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
        exit();
    } else {
        echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
        exit();
    }
}
?>
<?php
// Ajax calls this EMAIL CHECK code to execute
if (isset($_POST["emailcheck"])) {
    $email = preg_replace('#[^a-z0-9@.-_]#i', '', $_POST['emailcheck']);
    $sql = "SELECT id FROM users_test WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
    $e_check = mysqli_num_rows($query);
    if ($e_check > 0) {
        echo '<strong style="color:#F00;">That email address is already in use in the system</strong>';
        exit();
    } else {
        echo '<strong style="color:#009900;">' . $email . ' is OK</strong>';
        exit();
    }
}
?>
<?php
// Ajax calls this REGISTRATION code to execute
if (isset($_POST["u"])) {
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
    if ($u == "" || $e == "" || $p == "" || $g == "" || $c == "") {
        echo "The form submission is missing values.";
        exit();
    } else if ($u_check > 0) {
        echo "The username you entered is alreay taken";
        exit();
    } else if ($e_check > 0) {
        echo "That email address is already in use in the system";
        exit();
    } else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit();
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
        // END FORM DATA ERROR HANDLING
        // Begin Insertion of data into the database
        // Hash the password and apply your own mysterious unique salt
        $cryptpass = crypt($p);
        $p_hash = randStrGen(20) . "$cryptpass" . randStrGen(20);
        // Add user info into the database table for the main site table
        $sql = "INSERT INTO users_test (username, email, password, gender, country, ip, signup, lastlogin)
			   VALUES('$u','$e','$p_hash','$g','$c','$ip',now(),now())";
        $query = mysqli_query($db_connect, $sql);
        $uid = mysqli_insert_id($db_connect);

        // -------------------------------------------
        $sql = "SELECT * FROM users_test WHERE email='$e' LIMIT 1";
        $query = mysqli_query($db_connect, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $uid = $row["id"];
            $user = $row["username"];
            $email_ins = $row["email"];
            $pass = $row["password"];

            // Email the user their activation link
            $to = "$email_ins";
            $from = "auto-respond@webmojo.eu";
            $subject = 'eLoyals Account Activation';
            $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>eLoyals Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.eloyals.webmojo.eu/index.php"><img src="http://www.eloyals.webmojo.eu/img/eloyals-logo-50x55.png" alt="eLoyals" style="border:none; float:left;"></a>eLoyals Account Activation</div><div style="padding:24px; font-size:17px;">Hello ' . $u . ',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.eloyals.webmojo.eu/activation.php?id=' . $uid . '&u=' . $user . '&e=' . $email_ins . '&p=' . $pass . '">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>' . $e . '</b></div></body></html>';
            $headers = "From: $from\n";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            if (mail($to, $subject, $message, $headers)) {
                echo 'OK';
            } else {
                echo 'Something went wrong with the mailing thing.';
            };
            echo "signup_success";
            exit();
        }
    }
    exit();
}

/*** INCLUDE REGISTRATION FUNCTIONS ***/
include(APPLICATION_PATH . "/inc/register.inc.php");

?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="eLoyals">
    <meta name="author" content="Tomasz Piechota">
    <title>eLoyals - Your one stop Loyalty System</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/bootstrap-formhelpers.css" rel="stylesheet">
    <link href="css/sticky-footer.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet">
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="css/old.register.css" rel="stylesheet">

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
    <div class="row-fluid">
        <div class="span12 content">
            <form method="POST" action="">
                <div class="span8 offset2">

                    <!-- PASSWORD SECTION -->
                    <fieldset>
                        <legend>Password</legend>
                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="password">Password: </label>
                                <input type="text" id="password" name="password"/>
                            </div>
                            <div class="span5">
                                <label for="password1">Confirm Password: </label>
                                <input type="text" id="password1" name="password1"/>
                            </div>
                            <div class="reg-password-info" class="span12"></div>
                        </div>
                    </fieldset>

                    <!-- EMAIL SECTION -->
                    <fieldset>
                        <legend>Email</legend>
                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="email">Email: </label>
                                <input type="text" id="email" name="email"/>
                            </div>
                            <div class="span5">
                                <label for="email1">Confirm Email: </label>
                                <input type="text" id="email1" name="email1"/>
                            </div>
                            <div class="reg-email-info" class="span12"></div>
                        </div>
                    </fieldset>

                    <!-- PERSIONAL INFORMATION SECTION -->
                    <fieldset>
                        <legend>Personal Information</legend>

                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="first_name">First Name: </label>
                                <input type="text" id="first_name" name="first_name"/>
                            </div>
                            <div class="span5">
                                <label class="control-label" for="last_name">Last Name: </label>
                                <input type="text" id="last_name" name="last_name"/>
                            </div>
                            <div class="reg-name-info" class="span12"></div>
                        </div>

                        <div class="row-fluid">
                            <div class="offset1 span10">
                                <label for="address_1">Address 1: </label>
                                <input class="input-block-level" type="text" id="address_1" name="address_1"/>
                                <label for="address_2">Address 2: </label>
                                <input class="input-block-level" type="text" id="address_2" name="address_2"/>
                            </div>
                            <div class="reg-address-info" class="span12"></div>
                        </div>

                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="town">Town: </label>
                                <input name="town" type="text" id="town" name="town"/>

                                <div class="reg-town-info" class="span12"></div>
                            </div>
                            <div class="span5">
                                <label for="county">County: </label>
                                <select id="county" name="county">
                                    <option value=""> --</option>
                                    <?php echo getCounty(); ?>
                                </select>
                            </div>
                            <div class="reg-county-info" class="span12"></div>
                        </div>

                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="postal_code">Postal Code: </label>
                                <input type="text" id="postal_code" name="postal_code"/>

                                <div class="reg-postal-info" class="span12"></div>
                            </div>
                            <div class="span5">
                                <label for="country">Country: </label>
                                <select id="country" name="country">
                                    <?php echo getCountry(); ?>
                                </select>

                                <div class="reg-country-info" class="span12"></div>
                            </div>
                        </div>

                        <div class="row-fluid" style="text-align: center">
                            <fieldset class="birthday">
                                <legend>Date of Birth</legend>
                                <div class="span12">
                                    <!--<div class="span1"><label for="day">Day</label>
                                        <select id="day" name="day">
                                            <?php /*echo get_bDay(); */?>
                                        </select>
                                    </div>
                                    <div class="span2">
                                        <label for="month">Month</label>
                                        <select id="month" name="month">
                                            <option value="0"> --</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select></div>
                                    <div class="span2">
                                        <label for="year">Year</label>
                                        <select id="year" name="year">
                                            <?php /*echo get_bYear(); */?>
                                        </select>
                                    </div>
                                    <input id="datetext" class="mypicker" readonly="true" />-->
                                    <div class="bfh-datepicker" data-format="d-m-y" data-date="17-06-1979">
                                        <div class="input-prepend bfh-datepicker-toggle" data-toggle="bfh-datepicker">
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                            <input type="text" class="input-medium" readonly>
                                        </div>
                                        <div class="bfh-datepicker-calendar">
                                            <table class="calendar table table-bordered">
                                                <thead>
                                                <tr class="months-header">
                                                    <th class="month" colspan="4">
                                                        <a class="previous" href="#"><i class="icon-chevron-left"></i></a>
                                                        <span></span>
                                                        <a class="next" href="#"><i class="icon-chevron-right"></i></a>
                                                    </th>
                                                    <th class="year" colspan="3">
                                                        <a class="previous" href="#"><i class="icon-chevron-left"></i></a>
                                                        <span></span>
                                                        <a class="next" href="#"><i class="icon-chevron-right"></i></a>
                                                    </th>
                                                </tr>
                                                <tr class="days-header">
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="reg-dob-info" class="span12"></div>
                            </fieldset>
                        </div>
                        <div class="row-fluid">
                            <fieldset class="birthday">
                                <legend>Gender</legend>
                                <div class="offset3 span3">
                                    <label class="radio">
                                        <input type="radio" name="sex" id="sex0" value="0" checked>
                                        Male
                                    </label>
                                </div>
                                <div class="offset1 span3">
                                    <label class="radio">
                                        <input type="radio" name="sex" id="sex1" value="1">
                                        Female
                                    </label>
                                </div>
                                <div class="reg-gender-info" class="span12"></div>
                            </fieldset>
                        </div>
                    </fieldset>
                    <div class="row-fluid">
                        <div class="span12">
                            <button class="btn btn-success btn-register">Register</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row-fluid"><!-- hero-unit bottom shadow -->
        <div class="span12 hero-unit-shadow-bottom"></div>
    </div>

    <!-- REGISTRATION FORM -->

    <!--

            email         VARCHAR(100) NOT NULL,
            password      VARCHAR(50)  NOT NULL,
            first_name    VARCHAR(50)  NOT NULL,
            last_name     VARCHAR(50)  NOT NULL,
            gender        BOOLEAN      NOT NULL DEFAULT '0',
            address_1     VARCHAR(50)  NOT NULL,
            address_2     VARCHAR(50)  NOT NULL,
            town          VARCHAR(50)  NOT NULL,
            county        VARCHAR(50)  NOT NULL,
            postal_code   VARCHAR(10)  NOT NULL,
            country       VARCHAR(25)  NOT NULL,
        mobile        VARCHAR(15)  NOT NULL,
        ipv4          VARCHAR(15)  NOT NULL,
        country_id    INT(3)       NOT NULL,
        birthday      DATE         NOT NULL,
        change_passwd BOOLEAN      NOT NULL DEFAULT '0',
        not_txt_msg   BOOLEAN      NOT NULL DEFAULT '0',
        not_emails    BOOLEAN      NOT NULL DEFAULT '0',

    -->

    <!--/ REGISTRATION FORM -->

    <!-- PARTNERS -->
    <?php include(TEMPLATE_PATH . "/public/partners-main.php") ?>
    <!-- / PARTNERS -->
</div>
<!--/.container -->

<div id="push"></div>

</div>
<!--/#wrap -->

<!-- FOOTER MENU -->
<?php require(TEMPLATE_PATH . "/public/footer-main.php") ?>
<!-- / FOOTER MENU -->


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
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-formhelpers-datepicker.js"></script>
<script src="js/bootstrap-formhelpers-datepicker.en_US.js"></script>
<!-- controlls modals -->
<script>
    $(function () {
        $('.modal').modalResponsiveFix({ debug: true });
        $('.modal').touchScroll();
    })
</script>
<script src="js/modal-responsive/modal-responsive-fix.js"></script>
<script src="js/modal-responsive/touchscroll.js"></script>

<!-- include jQuery + carouFredSel plugin -->
<script type="text/javascript" language="javascript" src="js/carouFredSel/jquery-1.8.2.min.js"></script>
<script type="text/javascript" language="javascript" src="js/carouFredSel/jquery.carouFredSel-6.2.0-packed.js"></script>

<!-- optionally include helper plugins -->
<script src="js/carouFredSel/helper-plugins/jquery.mousewheel.min.js"></script>
<script src="js/carouFredSel/helper-plugins/jquery.touchSwipe.min.js"></script>
<script src="js/carouFredSel/helper-plugins/jquery.transit.min.js"></script>
<script src="js/carouFredSel/helper-plugins/jquery.ba-throttle-debounce.min.js"></script>

<!-- controlls modals -->


<!-- fire plugin onDocumentReady -->
<script type="text/javascript" language="javascript">
    $(function () {
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
    function myCollapse() {
        document.getElementById('NavDisplayButton').click();
    }
</script>
</body>
</html>