<?php

// Set up a constant to your main application path
define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view/public");
define("TEMPLATE_PATH_PRIVATE", APPLICATION_PATH . "/view/private");

//for menu item highlighting
$activeManageLoyaltyPrograms = "active";

/*** CONFIG DATABASE ***/
require(APPLICATION_PATH . "/inc/db_config.php");

/*** CONNECT TO THE DATABASE ***/
include_once(APPLICATION_PATH . "/inc/db_connect.php");
?>
<?php

if (isset($_GET["id"])) {

    $uid = $_GET["id"];
    $bus_list = "";
    $note = "";


    $sql = "SELECT * FROM tbl_business";
    $query = mysqli_query($db_connect, $sql);
    $numrows = mysqli_num_rows($query);

    while ($row = mysqli_fetch_array($query)) {

        $bus_id = $row['id'];
        $bus_trade_name = $row['trade_name'];
        $bus_address_1 = $row['address_1'];
        $bus_address_2 = $row['address_2'];
        $bus_town = $row['town'];
        $bus_county = $row['county'];
        $bus_postal_code = $row['postal_code'];
        $bus_country = $row['country'];
        $bus_phone = $row['phone'];
		$bus_logo = ($row['logo'] === null) ? 'http://placehold.it/187&text='.$bus_trade_name : $row['logo'];

        $sql1 = "SELECT customer_id, business_id, active FROM tbl_bus_cus WHERE customer_id='$uid' AND business_id='$bus_id'";
        $query1 = mysqli_query($db_connect, $sql1);
        $row1 = mysqli_fetch_array($query1);

        $bus_cus_customer_id = $row1['customer_id'];
        $bus_cus_business_id = $row1['business_id'];
        $bus_cus_active = $row1['active'];


        if($bus_id == $bus_cus_business_id && $bus_cus_active == '1'){
            $note = "disjoin";
            $join = "disabled";
            $disjoin = "";
        }else{
            $note = "join";
            $join = "";
            $disjoin = "disabled";
        }


        $bus_list .= '<div class="accordion-group">';
        $bus_list .= '  <div class="accordion-heading arr">';
        $bus_list .= '    <table style="width: 100%;"><tr><td>';
        $bus_list .= '      <a class="accordion-toggle bus_list" data-toggle="collapse" data-parent="#" href="#collapse'.$numrows.'"><span>'.$bus_trade_name.'</span></a>';
        $bus_list .= '      <td style="text-align: right">';
        $bus_list .= '        <button class="btn btn-success" '.$join.'><i class="icon-ok icon-white"></i>&nbsp;Join</button>';
        $bus_list .= '        <button class="btn btn-danger" '.$disjoin.'><i class="icon-remove icon-white"></i>&nbsp;Disjoin</button>';
        $bus_list .= '      </td>';
        $bus_list .= '     </tr>';
        $bus_list .= '   </table>';
        $bus_list .= '  </div>';
        $bus_list .= '  <div id="collapse'.$numrows--.'" class="accordion-body collapse">';
        $bus_list .= '      <div class="accordion-inner">';
        $bus_list .= '        <div class="span5">';
        $bus_list .= '        <img class="bus-cus-logo" src="'.$bus_logo.'" alt="'.$bus_trade_name.'" />';
        $bus_list .= '        </div>';
        $bus_list .= '        <div class="span7">';
        $bus_list .= '          <table class="table-condensed">';
        $bus_list .= '              <tbody>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>Address 1</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_address_1.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>Address 2</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_address_2.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>Country</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_country.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>County</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_county.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>Town</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_town.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>Postal code</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_postal_code.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '                  <tr>';
        $bus_list .= '                      <td>Phone</td>';
        $bus_list .= '                      <td>&nbsp;-&nbsp;</td>';
        $bus_list .= '                      <td>'.$bus_phone.'</td>';
        $bus_list .= '                  </tr>';
        $bus_list .= '              </tbody>';
        $bus_list .= '          </table>';
        $bus_list .= '        </div>';
        $bus_list .= '      </div>';
        $bus_list .= '  </div>';
        $bus_list .= '</div>';

    }



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
<style>
    #faq-accordion a {
        margin: 20px;
        padding: 0;
        color: #E24E35;
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.10);

    }
    div.details-qr > div {
        margin: 30px 45px 10px 0;
        padding: 10px;
        border: 5px solid rgba(226, 98, 54, 0.70);
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
    }
    div.details-qr div div:first-child div {
        font-family: "walker bot ldr";
        text-align: center;
        color: rgba(226, 98, 54, 0.90);
        font-size: 2em;
        font-weight: bold;
    }
    div.prog-button a {
        margin: 0 !important;

    }
    #faq-accordion .accordion-heading button {
        margin: 0 10px 0 10px;
    }
    #faq-accordion .accordion-heading button {
        margin: 0 10px 0 10px;
    }
    a.accordion-toggle.bus_list span {
        font-weight: normal;
        font-size: 110%;
        padding-left: 50px;
    }
    #faq-accordion .accordion-heading.ard .accordion-toggle {
        background-position: 0 1px;
    }

    #faq-accordion .accordion-heading.arr .accordion-toggle {
        background-position: 0 1px;
    }
    .accordion-inner, .accordion-body {
        background-color: #fafafa;
        -webkit-border-bottom-right-radius: 3px;
        -webkit-border-bottom-left-radius: 3px;
        -moz-border-radius-bottomright: 3px;
        -moz-border-radius-bottomleft: 3px;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
    #faq-accordion a.btn {
        color: #ffffff;
        width: 65px;
    }


</style>


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
                                       href="#">
                                        Join or disjoin loyalty program
                                    </a>
                                </div>
                            </div>
                            <?php echo $bus_list; ?>
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