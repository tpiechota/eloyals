<?php
/*
 * Set up a constant to your main application path
 */

define("APPLICATION_PATH", "app");
define("TEMPLATE_PATH", APPLICATION_PATH . "/view");

//for menu item highlighting
$activeFaq = "active";

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


            <!-------------------------------------------------------------------->

            <!-- Page content -->
            <div class="row-fluid">
                <div class="span12 content">
                    <div class="span8">
                        <div id="faq-accordion" class="accordion">
                            <div class="accordion-group">
                                <div class="accordion-heading arr">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                           href="#collapse1">
                                        How do I change my password?
                                        </a>
                                </div>
                                <div id="collapse1" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        You can change your password by going under profile.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading arr">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                           href="#collapse2">
                                        What should I do if my eLoyals card is lost?
                                        </a>
                                </div>
                                <div id="collapse2" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        Please inform TSAR Technologies by using the contact menu.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading arr">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                           href="#collapse3">
                                        How can I check my balance?
                                        </a>
                                </div>
                                <div id="collapse3" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        After you login, select check balance from the menu.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading arr">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                           href="#collapse4">
                                        Can I get cash instead of free stuffs?
                                        </a>
                                </div>
                                <div id="collapse4" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        No, you can only redeem what is being offered to you.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-group">
                                <div class="accordion-heading arr">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#"
                                           href="#collapse5">
                                        Can I transfer my redeemable balance to my friends or family?
                                        </a>
                                </div>
                                <div id="collapse5" class="accordion-body collapse">
                                    <div class="accordion-inner">
                                        No, balance is not transferable.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="span4 faq-advert pull-right">
                        <div class="row-fluid"><div class="span12"><img src="img/ads/signup.png" alt="Sign Up Now!" /></div></div>
<!--                        <div class="row-fluid"><div class="span12"><img src="img/ads/business-boost.png" alt="Boost Your Business!" /></div></div>-->
                        <div class="row-fluid">
                            <div class="span12">
                                <p>Register now and enjoy the benefits of having only ONE loyalty card!</p>
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
</body>
</html>