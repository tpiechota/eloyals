<?php
/*
 * Set up a constant to your main application path
 */

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

//for menu item highlighting
$activeRetailers = "active";

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

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="img/ico/favicon.png">

    <style>
        a.accordion-toggle span {
            font-weight: bold;
            font-size: 110%;
        }
        a.accordion-toggle {
            padding: 0 !important;
            margin: 12px !important;
        }
        #faq-accordion .accordion-heading.ard .accordion-toggle{
            background-position: 98% 10px;
        }
        #faq-accordion .accordion-heading.arr .accordion-toggle {
            background-position: 98% 10px;
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
                        <div id="faq-accordion" class="accordion">
                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle"><strong>Retailers</strong></a>
                                    <p class="cusRet">Through the eLoyals business portal, businesses could sign up for the service, set their parameters accordingly with the type of loyalty program they use, and have access to different types of reports and information about transactions made by the customers in their stores, along with different marketing tools.<br/>&nbsp;</p>
                                </div>
                            </div>
                        </div>
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