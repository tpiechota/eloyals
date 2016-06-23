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
                        <li <?php if(isset($activeDetails)){ echo "class=\"$activeDetails\""; } ?>>
						<a onClick="myCollapse();" href="details.php?id=<?php echo $uid ?>">My Profile</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeManageLoyaltyPrograms)){ echo "class=\"$activeManageLoyaltyPrograms\""; } ?> ><a onClick="myCollapse();" href="programs.php?id=<?php echo $uid ?>">Manage Loyalty Programs</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeBalancet)){ echo "class=\"$activeBalancet\""; } ?> ><a onClick="myCollapse();" href="balance.php?id=<?php echo $uid ?>">Check Balance</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeFaq)){ echo "class=\"$activeFaq\""; } ?>><a onClick="myCollapse();" href="faq.php">Update Profile</a></li>
                        <li class="divider-vertical"></li>
                        <li <?php if(isset($activeRegister)){ echo "class=\"$activeRegister\""; } ?> ><a onClick="myCollapse();" class="btn btn-warning hidden-desktop" data-toggle="modal" data-target="#register-modal">Register</a></li>
                        <li class="divider-vertical"></li>
                        <li><a onClick="myCollapse();" href="login-main.php" class="btn btn-warning hidden-desktop">&nbsp;Sign In&nbsp;</a>
                        </li>
                    </ul>
                    <ul class="nav pull-right visible-desktop">

                        <li>
                            <button type="button" class="btn btn-warning pull-right"
                                    onClick="parent.location='login.php'">&nbsp;Sign Out&nbsp;</button>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </div><!--/.navbar-inner -->
    </nav><!--/.navbar -->
</div><!--/.container-fluid -->