<div class="container-fluid">
    <nav class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a id="NavDisplayButton" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a><!-- <a class="brand brand-font" href="#">eloyals</a>-->
                <div class="nav-collapse collapse">
                    <ul class="nav pull-left">
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeIndex)){ echo "class=\"$activeIndex\""; } ?>><a onClick="myCollapse();" href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeRetailers)){ echo "class=\"$activeRetailers\""; } ?> ><a onClick="myCollapse();" href="retailers.php">Retailers</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeCustomers)){ echo "class=\"$activeCustomers\""; } ?> ><a onClick="myCollapse();" href="customers.php">Customers</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeAbout)){ echo "class=\"$activeAbout\""; } ?> ><a onClick="myCollapse();" href="about.php">About</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeContact)){ echo "class=\"$activeContact\""; } ?> ><a onClick="myCollapse();" href="contact.php">Contact</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeFaq)){ echo "class=\"$activeFaq\""; } ?>><a onClick="myCollapse();" href="faq.php">FAQ</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeRegister)){ echo "class=\"$activeRegister\""; } ?> ><a onClick="myCollapse();" class="btn btn-warning hidden-desktop" data-toggle="modal" data-target="#register-modal">Register</a></li>
                        <li class="divider-vertical"></li>
                        <li><a onClick="myCollapse();" href="login-main.php" class="btn btn-warning hidden-desktop">&nbsp;Sign In&nbsp;</a>
                        </li>
                    </ul>
                    <ul class="nav pull-right visible-desktop">
                        <li >
                            <!--<button type="button" class="btn btn-warning pull-right btn-reg <?php /*if(isset($activeRegister)){ echo $activeRegister; } */?>"
                                    onClick="parent.location='register.php'">Register
                            </button>-->
                            <button type="button" class="btn btn-warning pull-right btn-reg <?php if(isset($activeRegister)){ echo $activeRegister; } ?>" data-toggle="modal" data-target="#register-modal">Register</button>
                        </li>
                        <li>&nbsp;&nbsp;&nbsp;</li>
                        <li>
                            <button type="button" class="btn btn-warning pull-right"
                                    onClick="parent.location='login.php'">&nbsp;Sign In&nbsp;</button>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </div><!--/.navbar-inner -->
    </nav><!--/.navbar -->
</div><!--/.container-fluid -->