<?php  $url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
<div class="vertical-menu">
                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="admin-home-ui.php" class="waves-effect <?=strpos($url, 'admin-home-ui') !== false ? 'mm-active' : ''?>">
                                    <i class="mdi mdi-home-variant-outline"></i>
                                    <span>Home</span>
                                </a>
                            </li>

                            <li class="<?=strpos($url, 'add-cust-mobile-ui') !== false ? 'mm-active' : ''?>">
                                <a href="add-cust-mobile-ui.php" class="waves-effect <?=strpos($url, $searchString) !== false ? 'active' : ''?>">
                                    <i class="mdi mdi-briefcase-plus-outline"></i>
                                    <span>Add Job</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'view-cust-mobile-entry-ui') !== false ? 'mm-active' : ''?>">
                                <a href="view-cust-mobile-entry-ui.php" class="waves-effect active">
                                    <i class="mdi mdi-clipboard-list-outline"></i>
                                    <span>View Jobs</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'transactions-ui') !== false && strpos($url, 'view-gst-transactions-ui') == false ? 'mm-active' : ''?>">
                                <a href="transactions-ui.php" class="waves-effect active">
                                    <i class="mdi mdi-view-list-outline"></i>
                                    <span>View Transactions</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'view-gst-transactions-ui') !== false ? 'mm-active' : ''?>">
                                <a href="view-gst-transactions-ui.php" class="waves-effect active">
                                <i class="mdi mdi-book-account-outline"></i>
                                    <span>GST Reports</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'generate-invoice-ui') !== false ? 'mm-active' : ''?>">
                                <a href="generate-invoice-ui.php" class="waves-effect active">
                                    <i class="mdi mdi-billboard"></i>
                                    <span>Invoices</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'add-defect-ui') !== false ? 'mm-active' : ''?>">
                                <a href="add-defect-ui.php" class="waves-effect active">
                                    <i class="mdi mdi-image-broken"></i>
                                    <span>Add Defect</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'attendance') !== false ? 'mm-active' : ''?>">
                                <a href="attendance.php" class="waves-effect active">
                                    <i class="mdi mdi-account-circle-outline"></i>
                                    <span>Mark Attendance</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>