<?php

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

/*** CONFIG DATABASE ***/


require(APPLICATION_PATH . "/inc/PHPMailer/class.phpmailer.php");
require(APPLICATION_PATH . "/inc/PHPMailer/mailer.conf.inc.php");

if (isset($_GET['id']) && isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])) {
// Connect to database and sanitize incoming $_GET variables
// include_once("php_includes/db_connect.php");
    require(APPLICATION_PATH . "/inc/db_config.php");
    include(APPLICATION_PATH . "/inc/db_connect.php");

    $id = preg_replace('#[^0-9]#i', '', $_GET['id']);
    $u = preg_replace('#[^a-zA-Z]#i', '', $_GET['u']);
    $e = mysqli_real_escape_string($db_connect, $_GET['e']);
    $p = mysqli_real_escape_string($db_connect, $_GET['p']);

   /* $id = preg_replace('#[^0-9]#i', '', $_GET['id']);
	$fname = preg_replace('#[^a-zA-Z]#i', '', $_GET['fname']);
	$email1 = $_GET['email1'];
	$password1 = $_GET['password1'];*/

	// Evaluate the lengths of the incoming $_GET variable
	if($id == "" || strlen($u) < 3 || strlen($e) < 5 || strlen($p) == ""){
        // Log this issue into a text file and email details to yourself
        header("location: message.php?msg=activation_string_length_issues");
        exit();
    }
// Check their credentials against the database
	$sql = "SELECT * FROM tbl_customer WHERE id='$id' AND first_name='$u' AND email='$e' AND password='$p' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
	$numrows = mysqli_num_rows($query);

	// Evaluate for a match in the system (0 = no match, 1 = match)
	if($numrows == 0){
	    // Log this potential "hack" attempt to text file and email details to yourself
		header("location: message.php?msg=Your credentials are not matching anything in our system");
    	exit();
	}

	// Match was found, you can activate them
	$sql = "UPDATE tbl_customer SET activated='1', activation_on = now(), active='1' WHERE id='$id' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
	// Optional double check to see if activated in fact now = 1
	$sql = "SELECT * FROM tbl_customer WHERE id='$id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
	$numrows = mysqli_num_rows($query);
	// Evaluate the double check
    if($numrows == 0){
	// Log this issue of no switch of activation field to 1
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
		$mail->AddAddress($e);  // Add a recipient
		$mail->AddAddress('');                                // Name is optional
		$mail->AddReplyTo('');
		//$mail->AddCC('cc@example.com');
		$mail->AddBCC('eloyals-respond@eloyals.com');

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->AddAttachment('');                             // Add attachments
		$mail->AddAttachment('');                             // Optional name
		$mail->IsHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'eLoyals Account Activation ERROR!!!';
		$mail->Body = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>eLoyals Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;">eLoyals Account Activation ERROR</div><div style="padding:24px; font-size:17px;">Problem with activation of user:<br />ID: [$id]<br />Username: [$u]<br />Email: [$e]</div><div>Activation field to switch value 0 -> 1</div></body></html>';

		if(!$mail->Send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit();
		}

        header("location: message.php?msg=activation_failure");
   		exit();
		
    }else if($numrows == 1) {
		// Great everything went fine with activation!
		// Barcode create function
		include(APPLICATION_PATH . "/inc/eloyals.php");
        // the function code($id) returns the string to generate the barcode	
		qrtoimage(code($id), 250, $id);
		
		header("location: message.php?msg=activation_success");
    	exit();
    }	
	
} else {
	// Log this issue of missing initial $_GET variables
	$mail = new PHPMailer;

	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $host;                                  // Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $username;                          // SMTP username
	$mail->Password = $password;                          // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

	$mail->From = 'auto-respond@eloyals.com';
	$mail->FromName =  'eLoyals.com';
	$mail->AddAddress('eloyals-respond@eloyals.com');  // Add a recipient
	$mail->AddAddress('');                                // Name is optional
	$mail->AddReplyTo('');
	//$mail->AddCC('cc@example.com');
	$mail->AddBCC('eloyals-respond@eloyals.com');

	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	$mail->AddAttachment('');                             // Add attachments
	$mail->AddAttachment('');                             // Optional name
	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'eLoyals Account Activation ERROR!!!';
	$mail->Body = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>eLoyals Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;">eLoyals Account Activation ERROR</div><div style="padding:24px; font-size:17px;">Problem with activation of user:<br />ID: [$id]<br />Username: [$u]<br />Email: [$e]</div><div>Missing initial $_GET variables.</div></body></html>';

	if(!$mail->Send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		exit();
	}
		
	header("location: message.php?msg=missing_GET_variables");
    exit(); 
	
}
?>