<?php

/*** CONFIG DATABASE ***/
require("db_config.php");

/*** CONNECT TO THE DATABASE ***/
require("db_connect.php");


// Ajax calls this EMAIL CHECK code to execute
if (isset($_POST["emailcheck"])) {

    $email1 = preg_replace('#[^a-z0-9@.-_]#i', '', $_POST['emailcheck']);

    $sql = "SELECT id FROM  tbl_customer WHERE email='$email1' LIMIT 1";

    $query = mysqli_query($db_connect, $sql);
    $e_check = mysqli_num_rows($query);

    if ($e_check > 0) {
        echo '<strong style="color:#F00;">That email address is already in use in the system</strong>';
        exit();
    } else {
        echo '<strong style="color:#009900;">' . $email1 . ' is OK </strong>';
        exit();
    }
}
?>


<?php
// Ajax calls this FIRST NAME CHECK code to execute
/*if (isset($_POST["fname"])) {

    echo isset($_POST["fname"]);
    $fname = preg_replace('#[^a-zA-Z]#i', '', $_POST['fname']);

    if (strlen($fname) < 3 || strlen($fname) > 16) {
        echo '<strong style="color:#F00;">Min. 3 characters please</strong>';
        exit();
    }else{
        echo '<strong style="color:#009900;">' . $fname . ' is OK</strong>';
        exit();
    }
}*/
?>


<?php
// Ajax calls this LAST NAME CHECK code to execute
/*if (isset($_POST["lname"])) {

    $lname = preg_replace('#[^a-zA-Z]#i', '', $_POST['$lname']);

    if (strlen($lname) < 3 || strlen($lname) > 16) {
        echo '<strong style="color:#F00;">Min. 3 characters please</strong>';
        exit();
    }else{
        echo '<strong style="color:#009900;">' . $lname . ' is OK</strong>';
        exit();
    }
}*/
?>
<?php

?>

<?php
// Ajax calls this REGISTRATION code to execute
if( isset($_POST["email1"]) && isset($_POST["email2"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["address1"]) && isset($_POST["address2"]) && isset($_POST["country"]) && isset($_POST["county"]) && isset($_POST["town"]) && isset($_POST["postal_code"]) && isset($_POST["mobile"]) && isset($_POST["dob"]) && isset($_POST["gender"]) && isset($_POST["checkBoxMail"]) && isset($_POST["checkBoxTxt"]) && isset($_POST["checkBoxTerms"])){


//if (isset($_POST["email1"])) {
    // CONNECT TO THE DATABASE

    // GATHER THE POSTED DATA INTO LOCAL VARIABLES
    $email1 = mysqli_real_escape_string($db_connect, $_POST['email1']);
    $email2 = mysqli_real_escape_string($db_connect, $_POST['email2']);
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
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

    // DUPLICATE DATA CHECKS FOR EMAIL
    $sql = "SELECT id FROM  tbl_customer WHERE email='$email1' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
    $e_check = mysqli_num_rows($query);

    // FORM DATA ERROR HANDLING
    //if ($u == "" || $e == "" || $p == "" || $g == "" || $c == "") {
    if($email1 == ""){
        echo "The form submission is missing values.";
        exit();
    } else if ($e_check > 0) {
        echo "That email address is already in use in the system";
        exit();
    } else if (strlen($fname) < 3) {
        echo "First name must be min 3 characters";
        exit();
    } else if (strlen($lname) < 3) {
        echo "First name must be min 3 characters";
        exit();
    } else if (is_numeric($fname[0])) {
        echo 'First name cannot begin with a number';
        exit();
    } else if (is_numeric($lname[0])) {
        echo 'Last name cannot begin with a number';
        exit();
    } else {

        // END FORM DATA ERROR HANDLING
        // Begin Insertion of data into the database
        // Hash the password and apply your own mysterious unique salt
        $cryptpass = crypt($password1);
        include_once ("randStrGen.php");
        $p_hash = randStrGen(20)."$cryptpass".randStrGen(20);

        $sql = "INSERT INTO tbl_customer (email, password, first_name, last_name, gender, address_1, address_2, town, county_id, postal_code, mobile, ipv4, country_id, birthday, change_passwd, not_txt_msg, not_emails, create_at, activated, activation_on, active) VALUES ($email1, $password1, $fname, $lname, $gender, $address1, $address2, $town, $county, $postal_code, $mobile, $ipv4, $country, $dob, 1, $checkBoxTxt, $checkBoxMail, now(), 0, '', 0)";
        $query = mysqli_query($db_connect, $sql);
        $uid = mysqli_insert_id($db_connect);

        if($query == true){
            echo 'insert :)';
        } else {
            echo "insert :(";
        }

        echo "uid: ".$uid;
        // -------------------------------------------
        $sql = "SELECT * FROM tbl_customer WHERE email='$email1' LIMIT 1";
        $query = mysqli_query($db_connect, $sql);

        while ($row = mysqli_fetch_array($query)) {
            $uid = $row["id"];
            $fn = $row["first_name"];
            $ln = $row["last_name"];
            $email_ins = $row["email"];
            $pass = $row["password"];

            $u = $fn.' '.$ln;

            // Email the user their activation link
            $to = "$email_ins";
            $from = "auto-respond@eloyals.com";
            $subject = 'eLoyals Account Activation';
            $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>eLoyals Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.eloyals.webmojo.eu/index.php"><img src="http://www.eloyals.webmojo.eu/img/eloyals-logo-50x55.png" alt="eLoyals" style="border:none; float:left;"></a>eLoyals Account Activation</div><div style="padding:24px; font-size:17px;">Hello ' . $u . ',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="http://www.eloyals.webmojo.eu/activation.php?id=' . $uid . '&u=' . $u . '&e=' . $email_ins . '&p=' . $pass . '">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>' . $email_ins . '</b></div></body></html>';
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
?>