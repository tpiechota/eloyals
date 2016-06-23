<footer id="footer">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span8">
                <div class="nav-footer">
                    <ul class="nav-footer">
                        <li <?php if (isset($activeIndex)) {
                            echo "class=\"$activeIndex\"";
                        } ?> ><a onClick="myCollapse();" href="index.php"><i class="icon-home icon-white"></i> Home</a>
                        </li>
                        <li class="divider-vertical"></li>
                        <li <?php if (isset($activeRetailers)) {
                            echo "class=\"$activeRetailers\"";
                        } ?> ><a onClick="myCollapse();" href="retailers.php">Retailers</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if (isset($activeCustomers)) {
                            echo "class=\"$activeCustomers\"";
                        } ?> ><a onClick="myCollapse();" href="customers.php">Customers</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if (isset($activeAbout)) {
                            echo "class=\"$activeAbout\"";
                        } ?> ><a onClick="myCollapse();" href="about.php">About</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if (isset($activeContact)) {
                            echo "class=\"$activeContact\"";
                        } ?> ><a onClick="myCollapse();" href="contact.php">Contact</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if (isset($activeFaq)) {
                            echo "class=\"$activeFaq\"";
                        } else {
                            echo "";
                        } ?>><a onClick="myCollapse();" href="faq.php">FAQ</a></li>

                        <li class="divider-vertical"></li>
                        <li><a onClick="myCollapse();" href="#" data-toggle="modal"
                               data-target="#privacy-modal">Privacy</a></li>
                        <!--

                                                <li><a onClick="myCollapse();" href="register.php" class="btn btn-warning hidden-desktop">Register</a></li>
                                                <li class="divider-vertical"></li>
                                                <li><a onClick="myCollapse();" href="login-main.php" class="btn btn-warning hidden-desktop">&nbsp;Sign In&nbsp;</a>
                                                </li>-->
                        <!--<li><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="retailers.php">Retailers</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="customers.php">Customers</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="about.php">About</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="faq.php">FAQ</a></li>-->
                    </ul>
                </div>
                <!--/.nav-footer -->
            </div>
            <div class="span4">
                <div class="social-footer">
                    <a href="https://www.facebook.com/eloyals" target="_blank"><i class="icon-my-facebook"></i></a>
                    <a href="https://twitter.com/eloyals" target="_blank"><i class="icon-my-twitter"></i></a>
                    <a href="http://www.youtube.com/eloyals" target="_blank"><i class="icon-my-you"></i></a>
                    <a href="#"><i class="icon-my-rss" target="_blank"></i></a>
                    <a href="skype:eloyals?userinfo" target="_blank"><i class="icon-my-skype"></i></a>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row-fluid">
            <div class="span12">
                <div class="copy">Copyright &copy; 2013 <a href="#">eLoyals</a></div>
            </div>
        </div>
    </div>
    <!--/.container footer -->
</footer>
<!-- PRIVACY POLICY MODAL -->
<div id="privacy-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Privacy Policy</h3>
    </div>
    <div class="modal-body">
        <?php include(APPLICATION_PATH . "/inc/privacy-policy.inc.php"); ?>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<!-- REGISTER MODAL -->
<div id="register-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Register</h3>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row-fluid" style="text-align: center">
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="regHeader">I am a retailer</div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <a class="btn btn-inverse" href="#">Register &raquo;</a>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="regHeader">I am a customer</div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <a class="btn btn-primary" href="register.php">Register &raquo;</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>