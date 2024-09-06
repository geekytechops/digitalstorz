<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
<?php 



?>
        <!-- Begin page -->
        <div id="layout-wrapper">

                       

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('header.php') ?>
            <?php include('sidebar.php') ?>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <!-- <h4 class="mb-sm-0">Settings</h4> -->

                                </div>
                            </div>
                            <div class="content_holder_heading"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                                                 
                                                                    
                                        <div class="container settings-container">
                                                <div class="settings-header">
                                                    <h3>Settings</h3>
                                                    <button class="btn save-button">
                                                        <i class="fas fa-save"></i> Save
                                                    </button>
                                                </div>

                                                <!-- Settings Options -->
                                                <div class="setting-option">
                                                    <span>IMEI Display</span>
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                                                        <label class="form-check-label" for="SwitchCheckSizemd"></label>
                                                    </div>
                                                </div>

                                                <div class="setting-option">
                                                    <span>Show Customer Name</span>
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                                                        <label class="form-check-label" for="SwitchCheckSizemd"></label>
                                                    </div>
                                                </div>

                                                <div class="setting-option">
                                                    <span>Enable Notifications</span>
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                                                        <label class="form-check-label" for="SwitchCheckSizemd"></label>
                                                    </div>
                                                </div>

                                                <div class="setting-option">
                                                    <span>Show Serial Number</span>
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                                                        <label class="form-check-label" for="SwitchCheckSizemd"></label>
                                                    </div>
                                                </div>

                                                <div class="setting-option">
                                                    <span>Dark Mode</span>
                                                    <div class="form-check form-switch form-switch-md" dir="ltr">
                                                        <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                                                        <label class="form-check-label" for="SwitchCheckSizemd"></label>
                                                    </div>
                                                </div>
                                            </div>


                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                <?php include('footer.php') ?>
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        


        <!-- JAVASCRIPT -->
         
        <?php include('footer-includes.php') ?>


<script>
  
</script>
    </body>
</html>
