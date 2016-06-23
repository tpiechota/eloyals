<?php
/*
 * Set up a constant to your main application path
 */

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");
define("MAILER_PATH", "app/inc/PHPMailer");

//for menu item highlighting
$activeContact = "active";

require(APPLICATION_PATH . "/inc/PHPMailer/class.phpmailer.php");
require(APPLICATION_PATH . "/inc/PHPMailer/mailer.conf.inc.php");

/*
* Send email to eLoyals and a confirmation email to the sender
*/

if(isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["comment"])){

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $comment = $_POST["comment"];
    $status = "";

    $mail = new PHPMailer;

    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $host;                                  // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $username;                          // SMTP username
    $mail->Password = $password;                          // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

    $mail->From = 'auto-respond@eloyals.com';
    $mail->FromName = 'eLoyals.com';
    $mail->AddAddress($email, $first_name . ' ' . $last_name);  // Add a recipient
    $mail->AddAddress('');                                		// Name is optional
    $mail->AddReplyTo($email);
    $mail->AddCC('');
    $mail->AddBCC('eloyals-respond@eloyals.com');

    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->AddAttachment('');        					  // Add attachments
    $mail->AddAttachment('');    						  // Optional name
    $mail->IsHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = '<!DOCTYPE html><html style="height:100%;"><head><meta charset="UTF-8"><title>eLoyals - Feedback</title></head><body style="height: 100%;margin:0;font-family:Arial,sans-serif;color:#333333;background-image:url(\'http://www.eloyals.com/img/bg.png\');"><div style="margin:0;padding:0;background-image:url(\'http://www.eloyals.com/img/swirls2.png\');background-position:left top;background-repeat:no-repeat;width:100%;height:100%;background-size:100% 100%;"><div style="padding:0;background-image:url(\'http://www.eloyals.com/img/qr_bg.png\');background-position:80% -80px;background-repeat:no-repeat;width:100%;min-height:100%;height:auto !important;margin:0 auto;"><div style="padding:10px;font-size:24px;margin-bottom:30px;margin-left:auto;margin-right:auto;text-align:left;width:80%;"><div><a href="http://www.eloyals.com"><img src="http://www.eloyals.com/img/eloyals-logo.png" alt="eLoyals" style="border:none;vertical-align:middle;"/></a><span style="margin-left:20px;color:#F9AC40;"><img src="http://www.eloyals.com/img/logo-text.png" alt="eLoyals" style="width:50%;"/></span></div></div><div style="font-size:14px;background:#fefefe;width:80%;margin-left:auto;margin-right:auto;border: 5px solid #E26236;"><div style="padding:24px;text-align:justify;">Hi '.$first_name.' '.$last_name.',<br/><br/><hr/><br/>You wrote:<br/>"<i>'.$comment.'</i>"<br/><br/><br/>Thank you for your feedback. We will answer to your query as soon as possible.<br/><br/>Regards<br/>eLoyals</div></div><div style="text-align:center;font-size:10px;width:80%;margin-left:auto;margin-right:auto;">This is an auto-generated confirmation message. Please do not reply to this email.</div></div></div></body></html>';
    $mail->AltBody = 'Hi '.$first_name.' '.$last_name.'.
                        You wrote: "'.$comment.'"
                        Thank you for your feedback. We will answer to your query as soon as possible.
                        Regards
                        eLoyals
                        -- This is an auto-generated confirmation message. Please do not reply to this email. --';

    if(!$mail->Send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit();
    }
    echo "Thank you &#9786;";
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
    <link href="css/sticky-footer.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="css/contact.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">

<!-- Send email ajax script -->
    <script>
        function sendMail(){

            var first_name = _("first_name").value;
            var last_name = _("last_name").value;
            var email = _("email").value;
            var subject = _("subject").value;
            var comment = _("message").value;

            var status = _("status");
            var fnameInfo = _("fnameInfo");
            var lnameInfo = _("lnameInfo");
            var emailInfo = _("emailInfo");
            var subjectInfo = _("subjectInfo");
            var messageInfo = _("messageInfo");

            if(first_name == "" || last_name == "" || email == "" || subject == "" || comment == ""){
                if(first_name == ""){
                    document.getElementById('first_name').style.border= '1px solid red';
                    fnameInfo.style.display = 'block';
                    fnameInfo.innerHTML = "Enter your first name!";
                    status.innerHTML = "Fill out all of the form data!";
                }
                if(last_name == ""){
                    document.getElementById('last_name').style.border= '1px solid red';
                    lnameInfo.style.display = 'block';
                    lnameInfo.innerHTML = "Enter your last name!";
                    status.innerHTML = "Fill out all of the form data";
                }
                if(email == ""){
                    document.getElementById('email').style.border= '1px solid red';
                    emailInfo.style.display = 'block';
                    emailInfo.innerHTML = "Enter your email address!";
                    status.innerHTML = "Fill out all of the form data";
                }
                if(subject == ""){
                    document.getElementById('subject').style.border= '1px solid red';
                    subjectInfo.style.display = 'block';
                    subjectInfo.innerHTML = "Enter subject!";
                    status.innerHTML = "Fill out all of the form data";
                }
                if(comment == ""){
                    document.getElementById('message').style.border= '1px solid red';
                    messageInfo.style.display = 'block';
                    messageInfo.innerHTML = "Enter message!";
                    status.innerHTML = "Fill out all of the form data";
                }
            } else {
                _("send").disabled = false;
                status.innerHTML = '<span class="sending-msg"><img src="img/spinner.png" alt="" /> Sending...</span>';
                var ajax = ajaxObj("POST", "contact.php");

                ajax.onreadystatechange = function () {
                    if (ajaxReturn(ajax) == true) {
                        if (ajax.responseText != "Thank you &#9786;") {
                            status.innerHTML = ajax.responseText;
                            //_("contactform").disabled = false;
                        } else {
                            <!--window.scrollTo(0,0);-->
                            _("status").innerHTML = "Thank you &#9786;";
                        }
                    }
                };
                ajax.send("first_name="+first_name+"&last_name="+last_name+"&email="+email+"&subject="+subject+"&comment="+comment);
            }
        }
    </script>
</head>

<body>
<div id="map-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Location</h3>
    </div>
    <div class="modal-body">
        <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ie/maps/ms?ctz=0&amp;num=10&amp;ie=UTF8&amp;msa=0&amp;msid=207699944019758295145.0004b2794935a6a2be425&amp;t=m&amp;source=embed&amp;ll=53.345543,-6.258945&amp;spn=0.002242,0.003111&amp;output=embed"></iframe>
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
                    <div class="span8">
                        <form name="contactform" id="contactform"  onsubmit="return false;">
                                <!-- PERSIONAL INFORMATION SECTION -->
<!--                        <fieldset>-->
                                <div class="row-fluid">
                                    <div class="offset1 span5">
                                        <label for="first_name">First Name: </label>
                                        <input class="input-block-level" type="text" id="first_name" name="first_name" placeholder="Enter your first name"/>
                                        <div class="contact-status" id="fnameInfo"></div>
                                    </div>
                                    <div class="span5">
                                        <label class="control-label" for="last_name">Last Name: </label>
                                        <input class="input-block-level" type="text" id="last_name" name="last_name" placeholder="Enter your last name"/>
                                        <div class="contact-status" id="lnameInfo"></div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="offset1 span10">
                                        <label for="email">Email address: </label>
                                        <input class="input-block-level" type="text" id="email" name="email" placeholder="Enter your email address"/>
                                        <div class="contact-status" id="emailInfo" class="span12"></div>
                                    </div>

                                </div>

                                <div class="row-fluid">
                                    <div class="offset1 span10">
                                        <label for="subject">Subject: </label>
                                        <input class="input-block-level" type="text" id="subject" name="subject" placeholder="Enter subject"/>
                                        <div class="contact-status" id="subjectInfo" class="span12"></div>
                                    </div>

                                </div>
                                <div class="row-fluid">
                                    <div class="offset1 span10">
                                        <label for="message">Message: </label>
                                        <textarea class="input-block-level" name="message" rows="3" id="message" placeholder="Enter message..."></textarea>
                                        <div class="contact-status" id="messageInfo" class="span12"></div>
                                    </div>

                                </div>
                                <div class="row-fluid">
                                    <div class="offset2 span4">
                                        <button class="btn btn-warning input-block-level" id="send" onclick="sendMail();">send</button>
                                    </div>
                                    <div class="span4">
                                        <button type="reset" id="reset" class="btn input-block-level">reset</button>
                                    </div>
                                </div>
<!--                        </fieldset>-->
                            <div class="row-fluid">
                                <div class="span12 status">
                                    <span id="status"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="span4 contact-info">
                        <div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <span>eLoyals</span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <span>
                                        <img src="img/tsar_logo.png" style="vertical-align: middle" />
                                        TSAR Technologies
                                    </span><br />
                                    <span>30-34 Westmoreland St.</span><br />
                                    <span>Dublin 2</span><br />
                                    <span>Ireland</span>
                                    <hr />
                                    <span>Tel: +353 0 000 0000</span><br />
                                    <span>Email: <a href="mailto:eloyals-respond@eloyals.com">eloyals-respond@eloyals.com</a></span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <button class="btn btn-primary btn-small" type="button" data-toggle="modal" data-target="#map-modal">Location</button>
                                </div>
                            </div>
                        </div>
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
<!--<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/modal-responsive/modal-responsive-fix.js"></script>
<script src="js/modal-responsive/touchscroll.js"></script>-->


<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script src="js/jquery.js"></script>
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
    /*
    * Reset all warnings in the form
    */
    $("#reset").on('click', function() {

        var status = _("status");
        var fnameInfo = _("fnameInfo");
        var lnameInfo = _("lnameInfo");
        var emailInfo = _("emailInfo");
        var subjectInfo = _("subjectInfo");
        var messageInfo = _("messageInfo");

        document.getElementById('first_name').style.border= '';
        fnameInfo.style.display = 'none';
        status.innerHTML = "";

        document.getElementById('last_name').style.border= '';
        lnameInfo.style.display = 'none';
        status.innerHTML = "";

        document.getElementById('email').style.border= '';
        emailInfo.style.display = 'none';
        status.innerHTML = "";

        document.getElementById('subject').style.border= '';
        subjectInfo.style.display = 'none';
        status.innerHTML = "";

        document.getElementById('message').style.border= '';
        messageInfo.style.display = 'none';
        status.innerHTML = "";
    });
</script>
<script>
    $('#map-modal').on('shown', function () {
        google.maps.event.trigger(map, "resize");
        map.setCenter(myLatlng);
    });
</script>
</body>
</html>