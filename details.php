<?php

// Set up a constant to your main application path
define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view/public");
define("TEMPLATE_PATH_PRIVATE", APPLICATION_PATH . "/view/private");

//for menu item highlighting
$activeDetails = "active";

/*** CONFIG DATABASE ***/
require(APPLICATION_PATH . "/inc/db_config.php");

/*** CONNECT TO THE DATABASE ***/
include_once(APPLICATION_PATH . "/inc/db_connect.php");
?>
<?php

if (isset($_GET["id"])) {

    $uid = $_GET["id"];

    $sql = "SELECT * FROM tbl_customer WHERE id='$uid' LIMIT 1";
    $query = mysqli_query($db_connect, $sql);
    $numrows = mysqli_num_rows($query);

    if ($numrows == 0) {
        echo "Something wrong with the user record!";
        exit();
    }




    while ($row = mysqli_fetch_array($query)) {

        $id = $uid;
        $email = $row['email'];
        $password = $row['password'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $address_1 = $row['address_1'];
        $address_2 = $row['address_2'];
        $town = $row['town'];
        $county_id = $row['county_id'];
        $postal_code = $row['postal_code'];
        $mobile = $row['mobile'];
        $ipv4 = $row['ipv4'];
        $country_id = $row['country_id'];
        $birthday = $row['birthday'];
        $change_passwd = $row['change_passwd'];
        $not_txt_msg = $row['not_txt_msg'];
        $not_emails = $row['not_emails'];
        $create_at = $row['create_at'];
        $activated = $row['activated'];
        $activation_on = $row['activation_on'];
        $active = $row['active'];
        $qr = 'qr_img/' . $id . '_qr.png';
        $qr_download = $id . '_qr.png';
        $class = "";
        /* features */
        if ($not_txt_msg == 0) {
            $class1 = "checked-usr";
        } else {
            $class1 = "unchecked-usr";
        }

        if ($not_emails == 0) {
            $class2 = "checked-usr";
        } else {
            $class2 = "unchecked-usr";
        }

        /* get the county name */
        $sql = "SELECT * FROM tbl_county WHERE id='$county_id' LIMIT 1";
        $query = mysqli_query($db_connect, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $county = $row['name'];
        }

        /* get the country & county name */
        $sql = "SELECT * FROM tbl_country WHERE id='$country_id' LIMIT 1";
        $query = mysqli_query($db_connect, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $country = $row['name'];
        }


        if ($active == 0 && $activated == 0) {
            echo "You must activate your account to manage your account!";
            exit();
        }
    }
} else {
    echo "Something went wrong. Try to log in again :( <a href=\"login.php\">LOGIN</a>";
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
    <link href="css/faq.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <!-- HTML5 shim for IE backwards compatibility -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="css/register.css" rel="stylesheet">
    <link href="css/details.css" rel="stylesheet">

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">

</head>

<body>
<div id="map-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Location</h3>
    </div>
    <div class="modal-body">
        <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://maps.google.ie/maps/ms?ctz=0&amp;num=10&amp;ie=UTF8&amp;msa=0&amp;msid=207699944019758295145.0004b2794935a6a2be425&amp;t=m&amp;source=embed&amp;ll=53.345543,-6.258945&amp;spn=0.002242,0.003111&amp;output=embed"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<div class="swirls">
    <div id="wrap">

        <!-- HEADER MENU -->
        <?php require(TEMPLATE_PATH . "/header-main.php") ?>
        <!-- / HEADER MENU -->


        <!-- MAIN MENU -->
        <?php require(TEMPLATE_PATH_PRIVATE . "/menu-main.php") ?>
        <!-- / MAIN MENU -->

        <div class="container-fluid">


            <!-------------------------------------------------------------------->
            <!-- Page content -->
            <div class="row-fluid">
                <div class="span12 content">
                    <div class="span8">
                        <div id="faq-accordion" class="accordion details-usr">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle user-name" data-toggle="collapse" data-parent="#"
                                       href="#collapse1">
                                        <?php echo $first_name . ' ' . $last_name; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading ard">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                       href="#collapse2">
                                        Address
                                    </a>
                                </div>
                                <div id="collapse2" class="accordion-body collapse in">
                                    <div class="accordion-inner">
                                        <table class="table-condensed">
                                            <tbody>
                                            <tr>
                                                <td>Address 1</td>
                                                <td>&nbsp;-&nbsp;</td>
                                                <td><?php echo $address_1; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Address 2</td>
                                                <td>&nbsp;-&nbsp;</td>
                                                <td><?php echo $address_2; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Country</td>
                                                <td>&nbsp;-&nbsp;</td>
                                                <td><?php echo $country; ?></td>
                                            </tr>
                                            <tr>
                                                <td>County</td>
                                                <td>&nbsp;-&nbsp;</td>
                                                <td><?php echo $county; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Postal code</td>
                                                <td>&nbsp;-&nbsp;</td>
                                                <td><?php echo $postal_code; ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading ard">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                       href="#collapse3">
                                        Mobile phone
                                    </a>
                                </div>
                                <div id="collapse3" class="accordion-body collapse in">
                                    <div class="accordion-inner">
                                        <ul>
                                            <li><?php echo $mobile; ?></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading ard">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                       href="#collapse5">
                                        Features
                                    </a>
                                </div>
                                <div id="collapse5" class="accordion-body collapse in">
                                    <div class="accordion-inner">
                                        <ul>
                                            <li class="<?php echo $class1; ?>">Text messages (<?php echo $mobile; ?>)</li>
                                            <li class="<?php echo $class2; ?>">Email messages</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span4 details-qr">
                        <div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <span>eLoyals</span>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <img src="/<?php echo $qr; ?>"
                                         alt="<?php echo $first_name . ' ' . $last_name; ?> QR code"/>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <form action="force_download.php" method="post" name="downloadform">
                                        <input name="file_name" value="<?php echo $qr_download; ?>" type="hidden">
                                        <button class="btn btn-primary" type="submit"><i class="icon-download-alt icon-white"></i>&nbsp;Download Image</button>
                                    </form>
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
            <?php include(TEMPLATE_PATH . "/partners-main.php") ?>
            <!-- / PARTNERS -->


        </div>
        <!--/.container -->
        <div id="push"></div>
    </div>
    <!--/#wrap -->

    <!-- FOOTER MENU -->
    <?php require(TEMPLATE_PATH . "/footer-main.php") ?>
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
<script src="js/modal-responsive/modal-responsive-fix.js"></script>
<script src="js/modal-responsive/touchscroll.js"></script>
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
</body>
</html>