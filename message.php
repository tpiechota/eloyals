<?php
$message = "";
$msg = preg_replace('#[^a-z 0-9.:_()]#i', '', $_GET['msg']);
if ($msg == "activation_failure") {
    $message = '<h2>Activation Error</h2> Sorry, there was a problem activating your account. We have already notified ourselves of this issue and we will contact you via email when we fix the issue.';
} else if ($msg == "activation_success") {
    $message = '<h2>Activation Success</h2> Your account is now activated. <a href="index.php">Click here to log in</a>';
} else {
    $message = $msg;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="eLoyals">
    <meta name="author" content="Tomasz Piechota">
    <title>eLoyals - Activation</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/sticky-footer.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
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
<body
    style="height: 100%;margin:0;font-family:Arial,sans-serif;color:#333333;background-image:url(\'http://www.eloyals.com/img/bg.png\');">
<div class="swirls">
    <div id="wrap">
        <!-- HEADER MENU -->
        <?php require("app/view/public/header-main.php") ?>
        <!-- / HEADER MENU -->
        <div class="container-fluid">
        <div
            style="margin:0;padding:0;background-image:url(\'http://www.eloyals.com/img/swirls2.png\');background-position:left top;background-repeat:no-repeat;width:100%;height:100%;background-size:100% 100%;">
            <div
                style="padding:0;background-image:url(\'http://www.eloyals.com/img/qr_bg.png\');background-position:80% -80px;background-repeat:no-repeat;width:100%;min-height:100%;height:auto !important;margin:0 auto;">
                <div
                    style="padding:10px;font-size:24px;margin-bottom:30px;margin-left:auto;margin-right:auto;text-align:left;width:80%;">

                </div>
                <div
                    style="font-size:14px;background:#fefefe;width:80%;margin-left:auto;margin-right:auto;border: 5px solid #E26236;">
                    <div style="padding:10px; background:#333; font-size:24px; color:#CCC;">eLoyals Account Activation
                    </div>
                    <div style="padding:24px;text-align:justify;">
                        <div><?php echo $message; ?></div>

                        <br/><br/>Regards<br/>eLoyals
                    </div>
                </div>
            </div>
        </div>

    </div><!--/.container -->
    <div id="push"></div>
    </div><!--/#wrap -->

    <!-- FOOTER MENU -->
    <?php require("app/view/public/footer-main.php") ?>
    <!-- / FOOTER MENU -->

</div><!--/.swirls -->
</body>
</html>