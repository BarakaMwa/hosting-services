<div class="sidebar-logo">
    <a href="index.php">
        <img src="assets/img/logo-icon-2.png" class="img-fluid" alt>
    </a>
</div>
<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="<?php echo $dashboard;?>">
                <a href="index.php"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
            </li>
            <li class="<?php echo $products;?>">
                <a href="products.php"><i class="fas fa-layer-group"></i> <span>Products</span></a>
            </li>
            <li class="<?php echo $invoices;?>">
                <a href="invoices.php"><i class="fas fa-layer-group"></i> <span>Invoices</span></a>
            </li>
            <li class="<?php echo $categories;?>">
                <a href="categories.php"><i class="fas fa-layer-group"></i> <span>Categories</span></a>
            </li>
            <li class="<?php echo $subcategories;?>">
                <a href="subcategories.php"><i class="fab fa-buffer"></i> <span>Sub Categories</span></a>
            </li>
            <li class="<?php echo $servicelist;?>">
                <a href="service-list.php"><i class="fas fa-bullhorn"></i> <span> Services</span></a>
            </li>
            <li class="<?php echo $totalreport;?>">
                <a href="total-report.php"><i class="far fa-calendar-check"></i> <span> Booking List</span></a>
            </li>
            <li class="<?php echo $payment_list;?>">
                <a href="payment_list.php"><i class="fas fa-hashtag"></i> <span>Payments</span></a>
            </li>
            <li class="<?php echo $ratingstype;?>">
                <a href="ratingstype.php"><i class="fas fa-star-half-alt"></i> <span>Rating Type</span></a>
            </li>
            <li class="<?php echo $reviewreports;?>">
                <a href="review-reports.php"><i class="fas fa-star"></i> <span>Ratings</span></a>
            </li>
            <li class="<?php echo $subscriptions;?>">
                <a href="subscriptions.php"><i class="far fa-calendar-alt"></i> <span>Subscriptions</span></a>
            </li>
            <li class="<?php echo $wallet;?>">
                <a href="wallet.php"><i class="fas fa-wallet"></i> <span> Wallet</span></a>
            </li>
            <li class="<?php echo $serviceproviders;?>">
                <a href="service-providers.php"><i class="fas fa-user-tie"></i> <span> Service Providers</span></a>
            </li>
            <li class="<?php echo $settings;?>">
                <a href="settings.php"><i class="fas fa-cog"></i> <span> Settings</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-border-all"></i> <span> Application</span> <span
                        class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li class="<?php echo $chat;?>"><a href="chat.php">Chat</a></li>
                    <li class="<?php echo $calendar;?>"><a href="calendar.php">Calendar</a></li>
                    <li class="<?php echo $inbox;?>"><a href="inbox.php">Email</a></li>
                </ul>
            </li>
            <li class="menu-title">
                <span>Pages</span>
            </li>
            <li class="<?php echo "";?>">
                <a href="admin-profile.php"><i class="fas fa-user-plus"></i> <span>Profile</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-user-lock"></i> <span> Authentication </span> <span
                        class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li class="<?php echo "";?>"><a href="login.php"> Login </a></li>
                    <li class="<?php echo "";?>"><a href="register.php"> Register </a></li>
                    <li class="<?php echo "";?>"><a href="forgot-password.php"> Forgot Password </a></li>
                    <li class="<?php echo "";?>"><a href="lock-screen.php"> Lock Screen </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-exclamation-circle"></i> <span> Error Pages </span> <span
                        class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li class="<?php echo "";?>"><a href="error-404.php">404 Error </a></li>
                    <li class="<?php echo "";?>"><a href="error-500.php">500 Error </a></li>
                </ul>
            </li>
            <li class="<?php echo "";?>">
                <a href="users.php"><i class="fas fa-users"></i> <span>Users</span></a>
            </li>
            <li class="<?php echo "";?>">
                <a href="blank-page.php"><i class="far fa-file"></i> <span>Blank Page</span></a>
            </li>
            <li class="<?php echo "";?>">
                <a href="maps-vector.php"><i class="far fa-map"></i> <span>Vector Maps</span></a>
            </li>
            <li class="menu-title">
                <span>UI Interface</span>
            </li>
            <li class="<?php echo "";?>">
                <a href="components.php"><i class="fas fa-vector-square"></i> <span>Components</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fab fa-wpforms"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li class="<?php echo "";?>"><a href="form-basic-inputs.php">Basic Inputs </a></li>
                    <li class="<?php echo "";?>"><a href="form-input-groups.php">Input Groups </a></li>
                    <li class="<?php echo "";?>"><a href="form-horizontal.php">Horizontal Form </a></li>
                    <li class="<?php echo "";?>"><a href="form-vertical.php"> Vertical Form </a></li>
                    <li class="<?php echo "";?>"><a href="form-mask.php"> Form Mask </a></li>
                    <li class="<?php echo "";?>"><a href="form-validation.php"> Form Validation </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fas fa-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li class="<?php echo "";?>"><a href="tables-basic.php">Basic Tables </a></li>
                    <li class="<?php echo "";?>"><a href="data-tables.php">Data Table </a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);"><i class="fas fa-code"></i> <span>Multi Level</span> <span
                        class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li class="submenu">
                        <a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="<?php echo "";?>"><a href="javascript:void(0);"><span>Level 2</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"> <span> Level 2</span> <span
                                        class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li class="<?php echo "";?>"><a href="javascript:void(0);">Level 3</a></li>
                                    <li class="<?php echo "";?>"><a href="javascript:void(0);">Level 3</a></li>
                                </ul>
                            </li>
                            <li class="<?php echo "";?>"><a href="javascript:void(0);"> <span>Level 2</span></a></li>
                        </ul>
                    </li>
                    <li class="<?php echo "";?>">
                        <a href="javascript:void(0);"> <span>Level 1</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>