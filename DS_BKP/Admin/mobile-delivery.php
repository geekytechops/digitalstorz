<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$mess='';
$cust_mob_no='';
if(isset($_REQUEST['rslt'])){
	if($_REQUEST['rslt']=="success")
		$mess="<font color='#F4FA58'>Delivery Updated Succesfully.. Handover Mobile to Customer..</font>";
	elseif($_REQUEST['rslt']=="failed")
		$mess="Failed to Update Delivery.. Wait for some time..";
}
if(isset($_REQUEST['submit'])){ //When form Submits
		$cust_mob_no=$_REQUEST['cust_mob_no'];
		$sql_get_details="SELECT * FROM `adm_cust_mob_add` WHERE `cust_contact`=".$cust_mob_no." AND delete_status!=1 AND (status='Completed' OR status='Rejected')";
		
		$query_get_details=mysql_query($sql_get_details);
		$num_rows = mysql_num_rows($query_get_details);
		//echo $num_rows;
		$sql_get_cust_hist="SELECT * FROM `adm_cust_mob_add` WHERE `cust_contact`=".$cust_mob_no." order by `entry_id` DESC";
		$query_get_cust_hist=mysql_query($sql_get_cust_hist);
		
}
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.delivery.cust_mob_no.value == "")
                {
                    document.delivery.cust_mob_no.focus();
                    alert("Enter Mobile No");
					return false;
                }
			}
	</script>
</head>
<body>
	<div class="header">
		<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span></span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>CUSTOMER DEVICE DELIVERY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Customer Mobile Delivery Form&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="delivery" method="post" action="./mobile-delivery.php" onsubmit="return validate()">
					<div class="txt_lable">Customer Mobile No:</div>
					<div><input type="text" name="cust_mob_no" maxlength="10" value="<?php echo $cust_mob_no;?>" >&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Get Details" /></div>
					<?php
						if(isset($_REQUEST['submit'])){ 
						echo '</br>';
						echo '<tr><td style="color:red;"><b> CURRENT ORDERS BY CUSTOMER </b></td></tr>';
						echo '<br>';
							echo '<table class="order_hisory_table">';
							echo '<tr class="table_heading">
										<td>Entry Id</td>
										<td>Received By</td>
										<td>Received Date</td>
										<td>Customer Name</td>
										<td>Mobile Given</td>
										<td>Defect</td>
										<td>Repaired By</td>
										<td>Completed Date</td>
										<td>Estimated Amt</td>
										<td>Advance</td>
										<td>Remarks</td>
										<td>Status</td>
										<td>Action</td>
								</tr>';
								
						if ($num_rows > 0){	
							while ($result_get_details=mysql_fetch_array($query_get_details)){
						$mobile_def_sql='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_get_details['mobile_defect'];
						$mob_def_query=mysql_query($mobile_def_sql);
						$mob_def_result=mysql_fetch_array($mob_def_query);
							//print_r($result_get_details);
								echo '<tr >
										<td>'.$result_get_details['entry_id'].'</td>
										<td>'.$result_get_details['added_by'].'</td>
										<td>'.$result_get_details['added_date'].'</td>
										<td>'.$result_get_details['customer_name'].'</td>
										<td>'.$result_get_details['mobile_name'].'</td>
										<td>'.$mob_def_result['defect_name'].'</td>
										<td>'.$result_get_details['repair_by'].'</td>
										<td>'.$result_get_details['repair_date'].'</td>
										<td>'.$result_get_details['est_amount'].'</td>
										<td>'.$result_get_details['adv_amount'].'</td>
										<td>'.$result_get_details['remarks'].'</td>
										<td>'.$result_get_details['status'].'</td>
										<td><a style="color:green;" href="./mobile-delivery-invoice.php?delivery-id='.$result_get_details['entry_id'].'">&nbsp;&nbsp;&nbsp;<b>Proceed</b></a></td>
	
									</tr>'; 
							}
							}else{
							echo '<tr >
										<td colspan="13" style="color:green;">FOR THIS CUSTOMER, NO MOBILES ARE READY FOR DELIVERY.. Please check Oders Tab.</td>
										
							</tr>';
							}
							
							echo '<table>';
							echo '<tr><td style="color:red;"><b> OLD ORDERS BY CUSTOMER </b></td></tr>';
							echo '<br> <br><br> <br>';
							echo '<table class="order_hisory_table">';
							echo '<tr class="table_heading">
										<td>Entry Id</td>
										<td>Received By</td>
										<td>Received Date</td>
										<td>Customer Name</td>
										<td>Mobile Given</td>
										<td>Defect</td>
										<td>Repair By</td>
										<td>Completed Date</td>
										<td>Delivered Date</td>
										<td>Estimated Amt</td>
										<td>Actual Amt</td>
										<td>Re Open This</td>
										
								</tr>';
							
							while ($result_get_cust_hist=mysql_fetch_array($query_get_cust_hist)){
							//print_r($result_get_details);
							$mobile_def_sql='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_get_cust_hist['mobile_defect'];
						$mob_def_query=mysql_query($mobile_def_sql);
						$mob_def_result=mysql_fetch_array($mob_def_query);
								echo '<tr >
										<td>'.$result_get_cust_hist['entry_id'].'</td>
										<td>'.$result_get_cust_hist['added_by'].'</td>
										<td>'.$result_get_cust_hist['added_date'].'</td>
										<td>'.$result_get_cust_hist['customer_name'].'</td>
										<td>'.$result_get_cust_hist['mobile_name'].'</td>
										<td>'.$mob_def_result['defect_name'].'</td>
										<td>'.$result_get_cust_hist['repair_by'].'</td>
										<td>'.$result_get_cust_hist['repair_date'].'</td>
										<td>'.$result_get_cust_hist['delivered_date'].'</td>
										<td>'.$result_get_cust_hist['est_amount'].'</td>
										<td>'.$result_get_cust_hist['actual_amount'].'</td>
										<!--<td><a href="./add-cust-mobile.php?entry_id='.$result_get_cust_hist['entry_id'].'&action=reopen">Re Open</a></td>-->
										
									</tr>';
								
									
									
							}
							echo '<table>';
						}
					?>
				</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>