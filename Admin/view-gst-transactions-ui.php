<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$from_date=date("Y-m-d");
$to_date=date("Y-m-d");
$tech_name='';
$sql_advance_amt_pend_trans=0;
$pend_adv_card_tot=0;
$pend_adv_cash_tot=0;
$store_id=$_SESSION['session_store_id'];
if(isset($_REQUEST['submit'])){ //When form Submits

	$tech_name=$_REQUEST['tech_name'];
	
	//echo $_REQUEST['from_date'];	echo $_REQUEST['to_date']; 	exit;
	$from_date=$_REQUEST['from_date'].' 00:00:00';
	$to_date=$_REQUEST['to_date'].' 23:59:59';
	//echo $tech_name;exit;
	
	if($tech_name=='all'){
		$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE gst='yes' AND rejected='0' AND delete_status='0' AND `store_id`='".$store_id."' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY delivered_date DESC";
	}else{
		$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE gst='yes' AND  repair_by='".$tech_name."' AND rejected='0' AND delete_status='0' AND `store_id`='".$store_id."' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."'  ORDER BY delivered_date DESC";
	}
	//echo $sql_view_trans;exit;
	$query_view_trans=mysql_query($sql_view_trans);
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
                                
                                <form name="view_transactions" method="post" action="./view-gst-transactions-ui.php" onsubmit="return validate()">
				<table class="order_hisory_table">
					<tr class="table_heading">
						<td>Select&nbsp;User:</td>
						
						<td>
						<?php
						$sql_users_list="SELECT * FROM `cust_kolors_users_list` WHERE `status`=1 AND `store_id`=".$store_id;
						//echo $sql_users_list;
	                    $query_users_list=mysql_query($sql_users_list);
	                    echo "<select name='tech_name' class='form-select' id='tech_name'>";
	                    echo "<option value=''>--SELECT--</option>";
	                    while($result_users_list=mysql_fetch_array($query_users_list)){
	                        if($tech_name==$result_users_list['username']){
	                        ?>
	                            <option value="<?php echo $result_users_list['username']; ?>" selected><?php echo $result_users_list['staff_name']; ?> </option>
	                        <?php     
	                        }else{
	                        ?>
	                            <option value="<?php echo $result_users_list['username']; ?>"><?php echo $result_users_list['staff_name']; ?> </option>
	                        <?php 
	                        }
	                    
	                    }
	                    echo "<option value='all'>ALL</option>";
						echo "</select>";
						?>
						</td>
						<td>From&nbsp;Date:</td>
						<td><input type="date" class='form-control' name="from_date" value="<?php echo $from_date;?>"></td>
						<td>To&nbsp;Date:</td>
						<td><input type="date" class='form-control' name="to_date" value="<?php echo $to_date;?>"></td>
						<td><input type="submit" class='btn btn-primary' name="submit" value="Submit"></td>
						<td></td>
                        <td></td>
                        </tr>

                    </table>
                    </div>
                    </div>
                    </div>
                    </div>
                    
                <div class="row">
                    <div class="col-xl-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">       
                                    <h3 class="card-title">GST Transactions</h3> 
                    <table class="table table-bordered">
                        <?php
						if(isset($_REQUEST['submit'])){
						echo '<tr class="table_heading">
							<td><b>Order ID</b></td>
							<td><b>Received Date</b></td>
							<td><b>Delivered Date</b></td>
							<td><b>Mobile Name</b></td>
							<td><b>Defect</b></td>
							<td><b>Final/Actual Amount</b></td>
							<td><b>Customer GST No</b></td>
							<td><b>GST</b></td>
							<td><b>Payment Mode</b></td>
							
						</tr>';
						$total_final=0; 
						$total_gst=0;
						$cash_total=0; 
						$card_total=0;
						$gpay_total=0;
						$phonepe_total=0;
						$paytm_total=0;
						$mobiqwik_total=0;
						$freecharge_total=0;
						$wallet_total=0;
						$total_spare=0;
						$Advance_amt=0;
						while($result_view_trans=mysql_fetch_array($query_view_trans)){
						
						$mobile_def_sql='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_view_trans['mobile_defect'];
						$mob_def_query=mysql_query($mobile_def_sql);
						$mob_def_result=mysql_fetch_array($mob_def_query);	
						
						$total_final=$total_final+$result_view_trans['actual_amount'];
						$total_gst=$total_gst+$result_view_trans['gst_amount'];
						$total_spare=$total_spare+$result_view_trans['spare_cost'];
						
						
						$sql_username="SELECT `staff_name` FROM `cust_kolors_users_list` WHERE `username`=".$result_view_trans['repair_by'];
						//echo $sql_users_list;
	                    $query_username=mysql_query($sql_username);
	                    $result_username_repairby=mysql_fetch_array($query_username);
	                    
						echo '<tr>';
						echo '<td>'.$result_view_trans['entry_id'].'</td>';
						echo '<td>'.$result_view_trans['added_date'].'</td>';
						echo '<td>'.$result_view_trans['delivered_date'].'</td>';
						echo '<td>'.$result_view_trans['mobile_name'].'</td>';
						echo '<td>'.$mob_def_result['defect_name'].'</td>';
						echo '<td>'.$result_view_trans['actual_amount'].'</td>';
						echo '<td>'.$result_view_trans['customer_gst_no'].'</td>';
						echo '<td>'.$result_view_trans['gst_amount'].'</td>';
						echo '<td>'.$result_view_trans['payment_mode'].'</td>';
						echo '</tr>';

						}
						echo '<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td style="color: green;font-size:15px; font-weight:bold">&nbsp;Total&nbsp;GST&nbsp-&nbsp;'.$total_gst.'&nbsp;</td>
							<td></td>
						</tr>';
						}

					?>
                        </table>
                    </form>

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
        // Form validation code for SIGN UP
        function validate()
            {
		if (document.view_transactions.tech_name.value == "")
                {
                    document.view_transactions.tech_name.focus();
                    alert("Select Technician Name");
		    return false;
                }
                if (document.view_transactions.from_date.value == "")
                {
                    document.view_transactions.from_date.focus();
                    alert("Select From Date");
		    return false;
                }
                if (document.view_transactions.to_date.value == "")
                {
                    document.view_transactions.to_date.focus();
                    alert("Select To Date");
		    return false;
                }
            }
</script>
    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>