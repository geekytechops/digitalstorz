<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$session_store_name=$_SESSION['session_store_name'];    

$mess='';
	if(isset($_REQUEST['q'])){
		$m=$_REQUEST['q'];	
		if($m=='Success'){
			$mess="<span style='color:green'>&nbsp;&nbsp;Email Sent Successfully..</span>";
		}else if($m="Error"){
			$mess="<span style='color:red'>&nbsp;&nbsp;Error In Sending Email.. Contact Admin Digital Storz.</span>";
		}
	}
	
	
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
                                    <h4 class="mb-sm-0">View GST Transactions</h4>

                                </div>
                            </div>
                            <div><h1><?php echo $mess; ?></h1></div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-12 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">                                
                                                                    

                                        <a href="./send-invoice-by-phone-ui.php"><div style="color:#E4E5E8; background:#0202C2;text-align:center; border:1px solid #154FF5; border-radius:3px; width:220px; margin:20px;padding:20px; font-size:25px; float:left;">PRINT</div></a>
                                        <a href="./send-email-invoice-ui.php"><div style="color:#E4E5E8; background:#0202C2;text-align:center; border:1px solid #154FF5; border-radius:3px; width:200px; margin:20px;padding:20px; font-size:25px; float:left;">SEND EMAIL</div></a>

                                        </div>
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
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>