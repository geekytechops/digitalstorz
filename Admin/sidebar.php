<?php  $url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
<div class="vertical-menu">
                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="admin-home-ui" class="waves-effect <?=strpos($url, 'admin-home-ui') !== false ? 'mm-active' : ''?>">
                                    <i class="mdi mdi-home-variant-outline"></i>
                                    <span>Home</span>
                                </a>
                            </li>

                            <li class="<?=strpos($url, 'add-cust-mobile-ui') !== false ? 'mm-active' : ''?>">
                                <a href="add-cust-mobile-ui" class="waves-effect <?=strpos($url, $searchString) !== false ? 'active' : ''?>">
                                    <i class="mdi mdi-briefcase-plus-outline"></i>
                                    <span>Add Job</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'view-cust-mobile-entry-ui') !== false ? 'mm-active' : ''?>">
                                <a href="view-cust-mobile-entry-ui" class="waves-effect">
                                    <i class="mdi mdi-clipboard-list-outline"></i>
                                    <span>View Jobs</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'transactions-ui') !== false && strpos($url, 'view-gst-transactions-ui') == false ? 'mm-active' : ''?>">
                                <a href="transactions-ui" class="waves-effect">
                                    <i class="mdi mdi-view-list-outline"></i>
                                    <span>View Transactions</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'view-gst-transactions-ui') !== false ? 'mm-active' : ''?>">
                                <a href="view-gst-transactions-ui" class="waves-effect">
                                <i class="mdi mdi-book-account-outline"></i>
                                    <span>GST Reports</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'generate-invoice-ui') !== false ? 'mm-active' : ''?>">
                                <a href="generate-invoice-ui" class="waves-effect">
                                    <i class="mdi mdi-billboard"></i>
                                    <span>Invoices</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'add-defect-ui') !== false ? 'mm-active' : ''?>">
                                <a href="add-defect-ui" class="waves-effect">
                                    <i class="mdi mdi-image-broken"></i>
                                    <span>Add Defect</span>
                                </a>
                            </li>
                            <li class="<?=strpos($url, 'attendance') !== false ? 'mm-active' : ''?>">
                                <a href="attendance" class="waves-effect">
                                    <i class="mdi mdi-account-circle-outline"></i>
                                    <span>Mark Attendance</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-share-line"></i>
                                    <span>Inventory</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="javascript: void(0);" class="has-arrow">New Devices</a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li class="<?=strpos($url, 'add-product-categories-ui') !== false ? 'mm-active' : ''?>"><a href="add-product-categories-ui?type=new">Add Category</a></li>                                            
                                            <li class="<?=strpos($url, 'add-product-company-ui') !== false ? 'mm-active' : ''?>"><a href="add-product-company-ui">Add Company</a></li>
                                            <li class="<?=strpos($url, 'add-model-ui') !== false ? 'mm-active' : ''?>"><a href="add-model-ui">Add Model</a></li>
                                            <li><a href="javascript: void(0);">Add Product</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">Second Hand Devices</a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li class="<?=strpos($url, 'add-product-categories-ui') !== false ? 'mm-active' : ''?>"><a href="add-product-categories-ui?type=old">Add Category</a></li>
                                            <li class="<?=strpos($url, 'add-product-company-ui') !== false ? 'mm-active' : ''?>"><a href="add-product-company-ui">Add Company</a></li>
                                            <li class="<?=strpos($url, 'add-model-ui') !== false ? 'mm-active' : ''?>"><a href="add-model-ui">Add Model</a></li>
                                            <li><a href="javascript: void(0);">Add Product</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript: void(0);" class="has-arrow">Accessories</a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li class="<?=strpos($url, 'add-product-categories-ui') !== false ? 'mm-active' : ''?>"><a href="add-product-categories-ui?type=accessories">Add Category</a></li>                                            
                                            <li class="<?=strpos($url, 'add-product-company-ui') !== false ? 'mm-active' : ''?>"><a href="add-product-company-ui">Add Company</a></li>
                                            <li class="<?=strpos($url, 'add-model-ui') !== false ? 'mm-active' : ''?>"><a href="add-model-ui">Add Model</a></li>
                                            <li><a href="javascript: void(0);">Add Product</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>