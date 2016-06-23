<?php
/***Set up a constant to your main application path ***/
define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

/*** for menu item highlighting ***/
$activeRegister = "active";

/*** CONFIG DATABASE ***/
require(APPLICATION_PATH . "/inc/db_config.php");

/*** CONNECT TO THE DATABASE ***/
include_once(APPLICATION_PATH . "/inc/db_connect.php");

/*** CONNECT TO THE DATABASE ***/
//require(APPLICATION_PATH . "/inc/randStrGen.php");

require(APPLICATION_PATH . "/inc/PHPMailer/class.phpmailer.php");
require(APPLICATION_PATH . "/inc/PHPMailer/mailer.conf.inc.php");

/*** INCLUDE REGISTRATION FORM VALIDATION FUNCTIONS ***/
//include(APPLICATION_PATH . "/inc/registrationFormValidation.php");

/*** INCLUDE REGISTRATION FUNCTIONS ***/
include(APPLICATION_PATH . "/inc/register.inc.php");
?>
<?php
// Ajax calls this EMAIL CHECK code to execute
if(isset($_POST["emailcheck"])){
    //include_once("php_includes/db_connect.php");
    $email = preg_replace('#[^a-z0-9@.-_]#i', '', $_POST['emailcheck']);
    $sql = "SELECT id FROM tbl_customer WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
    $e_check = mysqli_num_rows($query);
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if ($e_check > 0){
        echo '<strong style="color:#F00;">That email address is already in use in the system</strong>';
        exit();
    }else{
        if (preg_match($regex, $email)) {
            echo '<strong style="color:#009900;">' . $email . ' is OK</strong>';
            exit();
        } else {
            echo '<strong style="color:#ff0000;">Invalid format</strong>';
            exit();
        }
    }
}
?>
<?php
// Ajax calls this REGISTRATION code to execute
if( isset($_POST["email1"]) && isset($_POST["password1"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["address1"]) && isset($_POST["address2"]) && isset($_POST["country"]) && isset($_POST["county"]) && isset($_POST["town"]) && isset($_POST["postal_code"]) && isset($_POST["mobile"]) && isset($_POST["dob"]) && isset($_POST["gender"]) && isset($_POST["checkBoxMail"]) && isset($_POST["checkBoxTxt"]) && isset($_POST["checkBoxTerms"])){
    // CONNECT TO THE DATABASE
    //include_once("php_includes/db_connect.php");
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
/*    $u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
    $e = mysqli_real_escape_string($db_connect, $_POST['e']);
    $p = $_POST['p'];
    $g = preg_replace('#[^a-z]#', '', $_POST['g']); // only lowercase
    $c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')); // Only numbers and '.'*/

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $email1 = mysqli_real_escape_string($db_connect, $_POST['email1']);
    $password1 = $_POST['password1'];
    $fname = preg_replace('#[^a-zA-Z]#i', '', $_POST['fname']);
    $lname = preg_replace('#[^a-zA-Z]#i', '', $_POST['lname']);
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $country = preg_replace('#[^0-9]#', '', $_POST['country']);
    $county = preg_replace('#[^0-9]#', '', $_POST['county']);
    $town = preg_replace('#[^a-zA-Z]#i', '', $_POST['town']);
    $postal_code = $_POST['postal_code'];
    $mobile = preg_replace('#[^0-9]#', '', $_POST['mobile']);
    $dob = preg_replace('#[^0-9-]#', '', $_POST['dob']);
    $gender = preg_replace('#[^0-1]#', '', $_POST['gender']);
    $checkBoxMail = preg_replace('#[^0-1]#', '', $_POST['checkBoxMail']);
    $checkBoxTxt = preg_replace('#[^0-1]#', '', $_POST['checkBoxTxt']);
    $checkBoxTerms = preg_replace('#[^0-1]#', '', $_POST['checkBoxTerms']);
    $ipv4 = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')); // Only numbers and '.'


    // DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
    $sql = "SELECT id FROM tbl_customer WHERE email='$email1' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
    $e_check = mysqli_num_rows($query);


    // FORM DATA ERROR HANDLING
    if($fname == "" || $email1 == "" || $password1 == "" || $gender == "" || $county == ""){
        echo "The form submission is missing values.";
        echo '$fname'.$fname.'$email1'.$email1.'$password1'.$password1.'$gender'.$gender.'$county'.$county;
        exit();
    }else if($e_check > 0){
        echo "That email address is already in use in the system";
        exit();
    }else if(strlen($fname) < 3 || strlen($fname) > 16){
        echo "Username must be between 3 and 16 characters";
        exit();
    }else if(is_numeric($fname[0])){
        echo 'Username cannot begin with a number';
        exit();
    }else{
        // END FORM DATA ERROR HANDLING
        // Begin Insertion of data into the database
        // Hash the password and apply your own mysterious unique salt
        $cryptpass = crypt($password1);
        include_once (APPLICATION_PATH . "/inc/randStrGen.php");

        $p_hash = randStrGen(20)."$cryptpass".randStrGen(20);
        // Add user info into the database table for the main site table
        $sql = "INSERT INTO tbl_customer (email, password, first_name, last_name, gender, address_1, address_2, town, county_id, postal_code, mobile, ipv4, country_id, birthday, not_txt_msg, not_emails, create_at) VALUES ('$email1', '$password1', '$fname', '$lname', '$gender', '$address1', '$address2', '$town', '$county', '$postal_code', '$mobile', '$ipv4', '$country', '$dob', '$checkBoxTxt', '$checkBoxMail', now())";
        //$sql = "INSERT INTO users_test (username, email, password, gender, country, ip, signup, lastlogin)	   VALUES('$u','$e','$p_hash','$g','$c','$ip',now(),now())";

        $query = mysqli_query($db_connect, $sql);
        $uid = mysqli_insert_id($db_connect);

        // -------------------------------------------
        $sql = "SELECT * FROM tbl_customer WHERE email='$email1' LIMIT 1";
        $query = mysqli_query($db_connect, $sql);
        while($row = mysqli_fetch_array($query)){
            $uid = $row["id"];
            $user = $row["first_name"];
            $user2 = $row["last_name"];
            $email_ins = $row["email"];
            $pass = $row["password"];

            $u = $user.' '.$user2;

            // Email the user their activation link
            $mail = new PHPMailer;

            $mail->IsSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $host;                                  // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $username;                          // SMTP username
            $mail->Password = $password;                          // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

            $mail->From = 'auto-respond@eloyals.com';
            $mail->FromName =  'eLoyals.com';
            $mail->AddAddress($email_ins, $fname . ' ' . $lname);  // Add a recipient
            $mail->AddAddress('');                                // Name is optional
            $mail->AddReplyTo($email_ins);
            //$mail->AddCC('cc@example.com');
            $mail->AddBCC('eloyals-respond@eloyals.com');

            $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
            $mail->AddAttachment('');                             // Add attachments
            $mail->AddAttachment('');                             // Optional name
            $mail->IsHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'eLoyals Account Activation';
            $mail->Body = '<!DOCTYPE html><html style="height:100%;"><head><meta charset="UTF-8"><title>eLoyals - Feedback</title></head><body style="height:100%;margin:0;font-family:Arial,sans-serif;color:#333333;background-image:url(\'http://www.eloyals.com/img/bg.png\');"><div style="margin:0;padding:0;background-image:url(\'http://www.eloyals.com/img/swirls2.png\');background-position:left top;background-repeat:no-repeat;width:100%;height:100%;background-size:100% 100%;"><div style="padding:0;background-image:url(\'http://www.eloyals.com/img/qr_bg.png\');background-position:80% -80px;background-repeat:no-repeat;width:100%;min-height:100%;height:auto !important;margin:0 auto;"><div style="padding:10px;font-size:24px;margin-bottom:30px;margin-left:auto;margin-right:auto;text-align:left;width:80%;"><div><a href="http://www.eloyals.com"><img src="http://www.eloyals.com/img/eloyals-logo.png" alt="eLoyals" style="border:none;vertical-align:middle;"/></a><span style="margin-left:20px;color:#F9AC40;"><img src="http://www.eloyals.com/img/logo-text.png" alt="eLoyals" style="width:50%;"/></span></div></div><div style="font-size:14px;background:#fefefe;width:80%;margin-left:auto;margin-right:auto;border: 5px solid #E26236;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;">eLoyals Account Activation</div><div style="padding:24px;text-align:justify;"><br />Hi '.$u.',<br/><br/><hr/><br/>Click the link below to activate your account when ready:<br /><br /><a href="http://www.eloyals.com/activation.php?id='.$uid.'&u='.$user.'&e='.$email_ins.'&p='.$pass.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$email1.'</b><br/><br/>Regards<br/>eLoyals</div></div><div style="text-align:center;font-size:10px;width:80%;margin-left:auto;margin-right:auto;">This is an auto-generated confirmation message. Please do not reply to this email.</div></div></div></body></html>';

            if(!$mail->Send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                exit();
            }
            echo "signup_success";
            exit();

/*            $headers = "From: $from\n";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\n";
            if(mail($to, $subject, $message, $headers)){
                echo 'OK';
            }else{
                echo 'Something went wrong with the mailing thing.';
            };
            echo "signup_success";
            exit();*/
        }
    }
    exit();
}
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
    <link href="css/modal.css" rel="stylesheet">
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="css/register.css" rel="stylesheet">
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">

    <script src="js/regFormValidation.js"></script>
<script>
    /***
     * Check the country field and change the caounty field accordingly.
     * If country id = 80 (Ireland) than insert county list else enable input field.
     ***/
    function checkCountry() {

        // Value that comes from the form (Select country drop-down)
        var selectedCountry = _("country").value;

        // div that creates space for return code
        var countyStatus = _("countyStatus");

        if (selectedCountry == '0') {

            // If no country selected disable county field
            _("county").disabled = true;

        }else{

            var ajax = ajaxObj("POST", "app/inc/reg.country.inc.php");

            ajax.onreadystatechange = function () {

                if (ajaxReturn(ajax) == true) {

                    if (ajax.responseText == true) {
                        _("countyStatus").innerHTML = '<label for=\"county\">County:</label><select id=\"county\" name=\"county\" class="input-block-level"><option value=\"\">Select county</option><?php echo $county_list; ?></select><div class=\"reg-status\" id=\"countyInfo\"></div>';
                    }else{
                        _("countyStatus").innerHTML = '<label class=\"control-label\" for=\"county\">County:</label><input class=\"input-block-level\" type=\"text\" id=\"county\" name=\"county\" placeholder=\"Enter county name\"/><div class=\"reg-status\" id=\"countyInfo\"></div>';
                    }

                }

            };

            ajax.send("selectedCountry=" + selectedCountry);

        }
    }
</script>
<script>
function restrict(elem) {
    var tf = _(elem);
    var rx = new RegExp;
    if (elem == "email") {
        rx = /[' "]/gi;
    } else if (elem == "username") {
        rx = /[^a-z0-9]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}
function checkpassword() {

    var password1Info = _("password1Info");
    var password2Info = _("password2Info");
    var passwordInfo = _("passwordInfo");

    var p1 = _("password1").value;
    var p2 = _("password2").value;

    if (p2 != p1) {
        passwordInfo.style.display = 'block';
        password2Info.style.display = 'block';
        _("password2Info").innerHTML = '&nbsp;';
        _("passwordInfo").innerHTML = 'Passwords do not match!';
    } else if(p1 == ""){
        password1Info.style.display = 'block';
        _("password1Info").innerHTML = 'Enter password!';
    } else if(p2 == ""){
        password2Info.style.display = 'block';
        _("password2Info").innerHTML = 'Confirm password!';
    } else {
        passwordInfo.style.display = 'block';
        _("passwordInfo").innerHTML = '<strong style="color:#009900;">OK</strong>';
    }
}
function checkemail() {

    var email1Info = _("email1Info");
    var emailInfo = _("emailInfo");

    var e = _("email1").value;

    if (e != "") {
        _("email1Info").innerHTML = '<img src="img/spinner.png" alt="checking" /> Checking...';
        var ajax = ajaxObj("POST", "register.php");
        ajax.onreadystatechange = function () {
            if (ajaxReturn(ajax) == true) {
                email1Info.style.display = 'block';
                emailInfo.style.display = 'block';
                _("email1Info").innerHTML = ajax.responseText;
            }
        };
        ajax.send("emailcheck=" + e);
    }
}
function signup() {

    var email1 = _("email1").value;
    var email2 = _("email2").value;
    var password1 = _("password1").value;
    var password2 = _("password2").value;
    var fname = _("fname").value;
    var lname = _("lname").value;
    var address1 = _("address1").value;
    var address2 = _("address2").value;
    var country = _("country").value;
    var county = _("county").value;
    var town = _("town").value;
    var postal_code = _("postal_code").value;
    var mobile = _("mobile").value;
    var dob = _("dob").value;
    var gender = _("gender").value;
    var checkBoxMail = _("checkBoxMail").value;
    var checkBoxTxt = _("checkBoxTxt").value;
    var checkBoxTerms = _("checkBoxTerms").value;

    // INFO BOXES
    var email1Info = _("email1Info");
    var email2Info = _("email2Info");
    var emailInfo = _("emailInfo");
    var password1Info = _("password1Info");
    var password2Info = _("password2Info");
    var passwordInfo = _("passwordInfo");
    var fnameInfo = _("fnameInfo");
    var lnameInfo = _("lnameInfo");
    var nameInfo = _("nameInfo");
    var address1Info = _("address1Info");
    var address2Info = _("address2Info");
    var addressInfo = _("addressInfo");
    var countryInfo = _("countryInfo");
    var countyInfo = _("countyInfo");
    var countryCountyInfo = _("countryCountyInfo");
    var townInfo = _("townInfo");
    var postalInfo = _("postalInfo");
    var townPostInfo = _("townPostInfo");
    var mobileInfo = _("mobileInfo");
    var dobInfo = _("dobInfo");
    var genderInfo = _("genderInfo");
    var dobGenderInfo = _("dobGenderInfo");
    var termsInfo = _("termsInfo");
    var status = _("status");

    //alert(email1 + "\n" + email2 + "\n" + password1 + "\n" + password2 + "\n" + fname + "\n" + lname + "\n" + address1 + "\n" + address2 + "\n" + country + "\n" + county + "\n" + town + "\n" + postal_code + "\n" + mobile + "\n" + dob + "\n" + gender + "\n" + checkBoxMail + "\n" + checkBoxTxt + "\n" + checkBoxTerms);


    if(email1 == "" || email2 == "" || password1 == "" || password2 == "" || fname == "" || lname == "" || address1 == "" || country == "" || country == 0 || county == "" || county == 0 || town == "" || postal_code == "" || mobile == "" || dob == "" || gender == "" || checkBoxTerms == ""){

        // EMAIL VALIDATION
        if (email1 == "") {
            document.getElementById('email1').style.border = '1px solid red';
            email1Info.style.display = 'block';
            email1Info.innerHTML = "Enter your email address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (email2 == "") {
            document.getElementById('email2').style.border = '1px solid red';
            email2Info.style.display = 'block';
            email2Info.innerHTML = "Confirm email address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (email1 != email2) {
            document.getElementById('email1').style.border = '1px solid red';
            document.getElementById('email2').style.border = '1px solid red';
            emailInfo.style.display = 'block';
            emailInfo.innerHTML = "Email addresses don't match!";
        }
        // PASSWORD VALIDATION
        if (password1 == "") {
            document.getElementById('password1').style.border = '1px solid red';
            password1Info.style.display = 'block';
            password1Info.innerHTML = "Enter password!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (password2 == "") {
            document.getElementById('password2').style.border = '1px solid red';
            password2Info.style.display = 'block';
            password2Info.innerHTML = "Confirm password!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (password1 != password2) {
            document.getElementById('password1').style.border = '1px solid red';
            document.getElementById('password2').style.border = '1px solid red';
            passwordInfo.style.display = 'block';
            passwordInfo.innerHTML = "Passwords don't match!";
        }

        // NAME VALIDATION
        if (fname == "") {
            document.getElementById('fname').style.border = '1px solid red';
            fnameInfo.style.display = 'block';
            fnameInfo.innerHTML = "Enter first name!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if (lname == "") {
            document.getElementById('lname').style.border = '1px solid red';
            lnameInfo.style.display = 'block';
            lnameInfo.innerHTML = "Enter last name!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // ADDRESS VALIDATION
        if (address1 == "") {
            document.getElementById('address1').style.border = '1px solid red';
            address1Info.style.display = 'block';
            address1Info.innerHTML = "Enter address!";
            status.innerHTML = "Fill out all of the form data!";
        }
        if(address2 == ""){
         document.getElementById('address2').style.border= '1px solid red';
         address2Info.style.display = 'block';
         address2Info.innerHTML = "Enter last name!";
         status.innerHTML = "Fill out all of the form data!";
         }

        // COUNTRY VALIDATION
        if (country == "" || country == 0) {
            document.getElementById('country').style.border = '1px solid red';
            countryInfo.style.display = 'block';
            countryInfo.innerHTML = "Select country!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // COUNTY VALIDATION
        if (county == "" || county == 0) {
            document.getElementById('county').style.border = '1px solid red';
            countyInfo.style.display = 'block';
            countyInfo.innerHTML = "Select (enter) county!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // TOWN VALIDATION
        if (town == "") {
            document.getElementById('town').style.border = '1px solid red';
            townInfo.style.display = 'block';
            townInfo.innerHTML = "Enter town name!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // MOBILE PHONE VALIDATION
        if (mobile == "") {
            document.getElementById('mobile').style.border = '1px solid red';
            mobileInfo.style.display = 'block';
            mobileInfo.innerHTML = "Enter mobile phone number!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // POSTAL CODE VALIDATION
        if (postal_code == "") {
            document.getElementById('postal_code').style.border = '1px solid red';
            postalInfo.style.display = 'block';
            postalInfo.innerHTML = "Enter postal code!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // DATE OF BIRTH VALIDATION
        if (dob == "") {
            document.getElementById('dob').style.border = '1px solid red';
            dobInfo.style.display = 'block';
            dobInfo.innerHTML = "Enter date of birth!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // GENDER VALIDATION
        if (gender == "") {
            document.getElementById('gender-group').style.border = '1px solid red';
            genderInfo.style.display = 'block';
            genderInfo.innerHTML = "Select gender!";
            status.innerHTML = "Fill out all of the form data!";
        }

        // TERMS & CONDITION VALIDATION
        if (checkBoxTerms == "") {
            document.getElementById('checkBoxTerms').style.border = '1px solid red';
            termsInfo.style.display = 'block';
            termsInfo.innerHTML = "You have to agree to the Terms &amp; Conditions to continue!";
            status.innerHTML = "Fill out all of the form data!";
        }

    } else {

        _("registerBtn").disabled = false;

        status.innerHTML = '<img src="img/spinner.png" alt="checking" />Checking...';

        var ajax = ajaxObj("POST", "register.php");

        ajax.onreadystatechange = function () {

            if (ajaxReturn(ajax) == true) {

                if (ajax.responseText != "signup_success") {

                    status.innerHTML = ajax.responseText;
                    _("registerBtn").disabled = false;

                } else {

                    <!--window.scrollTo(0,0);-->
                    _("registrationform").innerHTML = "OK " + fname + ", check your email inbox and junk mail box at <a>" + email1 + "</a> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";

                }
            }
        };
        ajax.send("email1=" + email1 + "&email2=" + email2 + "&password1=" + password1 + "&password2=" + password2 + "&fname=" + fname + "&lname=" + lname + "&address1=" + address1 + "&address2=" + address2 + "&country=" + country + "&county=" + county + "&town=" + town + "&postal_code=" + postal_code + "&mobile=" + mobile + "&dob=" + dob + "&gender=" + gender + "&checkBoxMail=" + checkBoxMail + "&checkBoxTxt=" + checkBoxTxt + "&checkBoxTerms=" + checkBoxTerms);

    }
}
function openTerms() {
    _("terms").style.display = "block";
    emptyElement("status");
}
</script>

</head>

<body>
<div id="termsAndConditions-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Terms & Conditions</h3>
    </div>
    <div class="modal-body">
        <?php include(APPLICATION_PATH . "/inc/terms-conditions.inc.php"); ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<div class="swirls">
<div id="wrap">

<!-- HEADER MENU -->
<?php require(TEMPLATE_PATH . "/public/header-main.php") ?>
<!-- / HEADER MENU -->


<!-- MAIN MENU -->
<?php require(TEMPLATE_PATH . "/public/menu-main.php") ?>
<!-- / MAIN MENU -->

<div class="container-fluid">


<!-------------------------------------------------------------------->

<!-- Page content -->
<div class="row-fluid">
    <div class="span12 content">
        <div class="span8 offset2">
            <form name="registrationform" id="registrationform" onsubmit="return false;">

                <!-- <fieldset>-->


                <!-- EMAIL ADDRESS -->
                <fieldset>
                    <legend>Email Address</legend>
                    <div class="row-fluid">
                        <div class="offset1 span5">
                            <label for="email1">Email address: </label>
                            <input class="input-block-level" type="text" id="email1" name="email1"
                                   placeholder="Enter email address"  onblur="checkemail()" onfocus="emptyElement('status')" onkeyup="restrict('email1')" maxlength="88"/>
                            <div class="reg-status" id="email1Info"></div>
                        </div>
                        <div class="span5">
                            <label class="control-label" for="email2">Confirm email: </label>
                            <input class="input-block-level" type="text" id="email2" name="email2"
                                   placeholder="Confirm email address" onblur="checkemails();" onfocus="emptyElement('emailInfo')" />
                            <div class="reg-status" id="email2Info"></div>
                        </div>
                    </div>
                    <div class="reg-status-big" id="emailInfo"></div>
                </fieldset>


                <!-- PASSWORD -->
                <fieldset>
                    <legend>Password</legend>
                    <div class="row-fluid">
                        <div class="offset1 span5">
                            <label for="password1">Password: </label>
                            <input class="input-block-level" type="password" id="password1" name="password1" placeholder="Enter password" "/>
                            <div class="reg-status" id="password1Info"></div>
                        </div>
                        <div class="span5">
                            <label class="control-label" for="password2">Confirm password: </label>
                            <input class="input-block-level" type="password" id="password2" name="password2" placeholder="Confirm password" onblur="checkpassword();" onfocus="emptyElement('passwordInfo')" "/>
                            <div class="reg-status" id="password2Info"></div>
                        </div>
                    </div>
                    <div class="reg-status-big" id="passwordInfo"></div>
                </fieldset>


                <!-- FIRST NAME & LAST NAME -->
                <fieldset>
                    <legend>Name & Address</legend>
                    <div class="row-fluid">
                        <div class="offset1 span5">
                            <label for="fname">First Name: </label>
                            <input class="input-block-level" type="text" id="fname" name="fname"
                                   placeholder="Enter your first name" "/>
                            <div class="reg-status" id="fnameInfo"></div>
                        </div>
                        <div class="span5">
                            <label class="control-label" for="lname">Last Name: </label>
                            <input class="input-block-level" type="text" id="lname" name="lname"
                                   placeholder="Enter your last name"/>
                            <div class="reg-status" id="lnameInfo"></div>
                        </div>
                        <div class="reg-status-big" id="nameInfo"></div>


                        <!-- ADDRESS INFORMATION -->
                        <div class="row-fluid">
                            <div class="offset1 span10">

                                <label for="address1">Address 1: </label>
                                <input class="input-block-level" type="text" id="address1" name="address1"
                                       placeholder="Enter your address..."/>
                                <div class="reg-status" id="address1Info"></div>

                                <label for="address2">Address 2: </label>
                                <input class="input-block-level" type="text" id="address2" name="address2"
                                       placeholder="Enter your address..."/>
                                <div class="reg-status" id="address2Info"></div>

                            </div>
                            <div class="reg-status-big" id="addressInfo"></div>
                        </div>


                        <!-- COUNTRY & COUNTY -->
                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="country">Country: </label>
                                <select class="input-block-level" id="country" name="country"
                                        onclick="checkCountry();">
                                    <option value="0" selected>Select country</option>
                                    <?php echo $country_list; ?>
                                </select>
                                <div class="reg-status" id="countryInfo"></div>
                            </div>
                            <div class="span5" id="countyStatus">
                                <label class="control-label" for="county">County:</label>
                                <input class="input-block-level" type="text" id="county" name="county"
                                       placeholder="Enter county name" disabled="disabled"/>

                                <div class="reg-status" id="countyInfo"></div>
                            </div>
                            <div class="reg-status-big" id="countryCountyInfo"></div>
                        </div>


                        <!-- TOWN & POSTAL CODE -->
                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="town">Town: </label>
                                <input class="input-block-level" type="text" id="town" name="town"
                                       placeholder="Enter town name"/>
                                <div class="reg-status" id="townInfo"></div>
                            </div>
                            <div class="span5">
                                <label for="postal_code">Postal Code: </label>
                                <input class="input-block-level" type="text" id="postal_code" name="postal_code"
                                       placeholder="Enter postal code"/>
                                <div class="reg-status" id="postalInfo"></div>
                            </div>
                            <div class="reg-status-big" id="townPostInfo"></div>
                        </div>

                        <!-- MOBILE -->
                        <div class="row-fluid">
                            <div class="offset1 span5">
                                <label for="mobile">Mobile: </label>
                                <input type="text" class="input-medium bfh-phone input-block-level" id="mobile" name="mobile" placeholder="Mobile number (e.g. 0861234567)" data-country="IE">
                                <div class="reg-status" id="mobileInfo"></div>
                            </div>
                            <div class="span5">
                                <label for="reg-example">&nbsp;</label>
                               <span id="reg-example" class="input-block-level">(e.g. 0861234567)</span>
                            </div>
                            <div class="reg-status-big" id="mobilePhoneInfo"></div>
                        </div>

                </fieldset>

                <!-- DATE OF BIRTH -->
                <fieldset>
                    <legend>Date of Birth & Gender</legend>
                    <div class="row-fluid">
                        <div class="offset1 span5">
                            <label for="dob">Date of Birth: </label>

                            <div class="bfh-datepicker" data-format="y-m-d" data-date="1979-06-17">
                                <div class="input-prepend bfh-datepicker-toggle" data-toggle="bfh-datepicker">
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                    <input id="dob" name="dob" type="text" class="input-block-level" readonly>
                                </div>
                                <div class="reg-status" id="dobInfo"></div>
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

                        <!-- GENDER -->
                        <div class="span5">
                            <label class="control-label" for="gender">Gender:</label>
                            <div id="gender-group" class="btn-group" data-toggle-name="gender" data-toggle="buttons-radio" >
                                <button type="button" value="0" class="btn btn-gender" data-toggle="button">&nbsp;<img src="img/male.png" />&nbsp;Male&nbsp;</button>
                                <button type="button" value="1" class="btn btn-gender" data-toggle="button"><img src="img/female.png" />&nbsp;Female</button>
                            </div>
                            <div class="reg-status" id="genderInfo"></div>
                            <input id="gender" type="hidden" name="gender" value="" />
                        </div>
                    </div>
                </fieldset>

                <!-- FEATURES (emails & txt) -->
                <fieldset>
                    <legend>Features</legend>
                    <div class="row-fluid">
                        <div class="offset1 span10">
                            <input type="checkbox" id="checkBoxMail" name="checkBoxMail" value="1" />
                            <label class="checkbox" for="checkBoxMail"><span></span>I want to receive email messages from eLoyals.</label>
                            <div class="reg-status" id="termsInfo"></div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="offset1 span10">
                            <input type="checkbox" id="checkBoxTxt" name="checkBoxTxt" value="1" />
                            <label class="checkbox" for="checkBoxTxt"><span></span>I want to receive text messages from eLoyals.</label>
                            <div class="reg-status" id="termsInfo"></div>
                    </div>
                </fieldset>


                <!-- TERMS & CONDITIONS -->
                <fieldset>
                    <legend>Terms & Conditions</legend>
                    <div class="row-fluid">
                        <div class="offset1 span10">

                                <input type="checkbox" id="checkBoxTerms" name="checkBoxTerms" onclick="SubmitButtonToggle();" />
                            <label class="checkbox" for="checkBoxTerms"><span></span>I have read
                                and agree to the <a href="#" data-toggle="modal"
                                                    data-target="#termsAndConditions-modal">Terms and Conditions</a></label>
                            <div class="reg-status" id="termsInfo"></div>
                        </div>
                    </div>
                </fieldset>


                <!-- SUBMIT AND RESET -->
                <div class="row-fluid">
                    <div class="offset2 span4">
                        <button class="btn btn-warning input-block-level" name="registerBtn" id="registerBtn"
                                disabled="disabled" onclick="validateFormFields();">Register
                        </button>
                    </div>
                    <div class="span4">
                        <button type="reset" id="reset" class="btn input-block-level" onclick="resetButtonCheckBox();">Reset</button>
                    </div>
                </div>
                <!-- </fieldset> -->
                <div class="row-fluid">
                    <div class="span12 status">
                        <span id="status"></span>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- hero-unit bottom shadow -->
<div class="row-fluid">
    <div class="span12 hero-unit-shadow-bottom"></div>
</div>

<!-------------------------------------------------------------------->

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

<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script src="js/jquery.js"></script>

<script src="js/bootstrap-formhelpers-datepicker.js"></script>
<script src="js/bootstrap-formhelpers-datepicker.en_US.js"></script>
<script src="js/bootstrap-formhelpers-phone.format.js"></script>
<script src="js/bootstrap-formhelpers-phone.js"></script>

<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap-affix.js"></script>


<script src="js/holder/holder.js"></script>
<script src="js/google-code-prettify/prettify.js"></script>

<script src="assets/js/application.js"></script>

<script>
    $(function () {
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

<!-- PARTNERS - fire plugin onDocumentReady -->
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
    $(".ard, .arr").on("click", function () {
        var $this = $(this);
        if ($this.hasClass("ard")) {
            $this.removeClass("ard").addClass("arr");
        }
        else {
            $this.removeClass("arr").addClass("ard");
        }
    });
</script>
<script>
    function myCollapse() {
        document.getElementById('NavDisplayButton').click();
    }
</script>
<script>
    $('#map-modal').on('shown', function () {
        google.maps.event.trigger(map, "resize");
        map.setCenter(myLatlng);
    });
</script>
<script>
    // group radio btn (gender)
/*    $('div.btn-group .btn').click(function(){
        $(this).find('button:gender').attr('checked', true);
        alert($('input[name=gender]:checked').val());
    });*/

        $('div.btn-group[data-toggle-name]').each(function() {
            var group = $(this);
            var form = group.parents('form').eq(0);
            var name = group.attr('data-toggle-name');
            var hidden = $('input[name="' + name + '"]', form);
            $('button', group).each(function() {
                var button = $(this);
                button.on('click', function() {
                    hidden.val($(this).val());
                    //alert(button.val());
                });
                if (button.val() == hidden.val()) {
                    button.addClass('active');
                }
            });

        });

</script>
<script>
    // Set the value of the checkboxes (mail & txt) to 0 and 1 on change event
    $('#checkBoxMail').change(function(){
        if($(this).attr('checked')){
            $(this).val('0');
        }else{
            $(this).val('1');
        }
    });
    $('#checkBoxTxt').change(function(){
        if($(this).attr('checked')){
            $(this).val('0');
        }else{
            $(this).val('1');
        }
    });
    $('#checkBoxTerms').change(function(){
        if($(this).attr('checked')){
            $(this).val('1');
        }else{
            $(this).val('0');
        }
    });

</script>
</body>
</html>