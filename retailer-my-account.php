<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
$page_no=4;
include("./Admin/dbconnect.php");
 $mess='';
if(isset($_REQUEST['submit'])){
	$ret_name=$_REQUEST['ret_name'];
	$ret_contact=$_REQUEST['ret_contact'];
	$ret_outlet=$_REQUEST['ret_outlet'];
	$ret_outlet_addr=$_REQUEST['ret_outlet_addr'];

	$sql1="UPDATE `cust_kolors_retail_users` SET
									`retailer_name`='".$ret_name."',
									`contact_no`='".$ret_contact."',
									`outlet_name`='".$ret_outlet."',
									`outlet_address`='".$ret_outlet_addr."' WHERE `email_id`='".$_SESSION['session_retail_username']."'";
	$query1=mysql_query($sql1);
	if($query1){
		$mess="Details Updated Succesfully..";
	}else{
		$mess="Failed To Update..";
	}
	
}
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="../js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
		<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

				if (document.ret_ac_det.ret_name.value == "")
                {
                    document.ret_ac_det.ret_name.focus();
					alert("Enter Name.");
                    return false;
                }
				if (document.ret_ac_det.ret_contact.value == "")
                {
                    document.ret_ac_det.ret_contact.focus();
					alert("Enter Contact No.");
                    return false;
                }
				if (document.ret_ac_det.ret_outlet.value == "")
                {
                    document.ret_ac_det.ret_outlet.focus();
					alert("Enter Outlet Name.");
                    return false;
                }
				if (document.ret_ac_det.ret_outlet_addr.value == "")
                {
                    document.ret_ac_det.ret_outlet_addr.focus();
					alert("Enter Outlet address.");
                    return false;
                }
				
				if(document.ret_ac_det.new_password1.value != document.ret_ac_det.new_password2.value){
					document.ret_ac_det.new_password2.focus();
					alert("Password Do Not Matched.");
                    return false;
				}
			}
	</script>
</head>
<body>
	<div class="header">
		<a href="./retailer-home.php">&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services</a>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<div class="left_container">
			<?php include("./retailer-menu.php");?>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>My Account</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Your Account and Transactional Details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
										<?php 
											$sql_user_data="SELECT * FROM `cust_kolors_retail_users` WHERE `email_id`='".$_SESSION['session_retail_username']."'";
											$query_user_data=mysql_query($sql_user_data);
											$result_user_data=mysql_fetch_array($query_user_data);
											?>
											<form name="ret_ac_det" action="./retailer-my-account.php" method="post" onsubmit="return validate()">
											<table>
												<tr>
													<td width="120px" style="text-align:right">Name&nbsp;&nbsp;:&nbsp;&nbsp;</td>
													<td ><input style="width:250px;" type="text" name="ret_name" value="<?php echo $result_user_data['retailer_name']; ?>" /></td>
												
													<td width="120px" style="text-align:right">Contact No&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:250px;" type="text" maxlength="10" name="ret_contact" value="<?php echo $result_user_data['contact_no']; ?>" /></td>
												</tr>
												<tr><td>&nbsp;</td></tr>
												<tr>
													<td width="120px" style="text-align:right">Email Id&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:250px;" type="text" name="ret_email" disabled="yes" value="<?php echo $result_user_data['email_id']; ?>" /></td>
												
													<td width="120px" style="text-align:right">Outlet Name&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:250px;" type="text" name="ret_outlet" value="<?php echo $result_user_data['outlet_name']; ?>" /></td>
												</tr>
												<tr><td>&nbsp;</td></tr>
												<tr>
													<td width="120px" style="text-align:right">Outlet Address&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:350px;" type="text" name="ret_outlet_addr" value="<?php echo $result_user_data['outlet_address']; ?>" /></td>
												</tr>
												<tr><td>&nbsp;</td></tr> 
												<tr>
													<td width="120px" style="text-align:right">Account&nbsp;Created&nbsp;&nbsp;:&nbsp;&nbsp;</td> 
													<td><input style="width:350px;" type="text" name="ret_account_date" disabled="yes" value="<?php echo $result_user_data['add_date']; ?>" /> (YYYY-MM-DD)</td>
												</tr>
												<tr><td>&nbsp;</td></tr>
												<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="&nbsp;&nbsp;Update&nbsp;&nbsp;"></td></tr>
											</table>
											</form>
											<br><br>
											<h1 class="page-title">Credit Transactions</h1>
											<table class="order_hisory_table">
											<tr bgcolor="#578EBE"><td><b>Transaction Id</b></td><td><b>Amount (INR)</b></td><td><b>Date (yyyy-mm-dd)</b></td><td><b>Type</b></td><td><b>Status</b></td></tr>
											<?php
											$sql_my_trans="SELECT `transaction_id`, `transaction_amount`,`transaction_date`, `status`,`transaction_type` FROM `cust_kolors_retailer_credits_transactions` WHERE `retailer_id`=".$_SESSION['session_retailer_account_id']." ORDER BY `transaction_id` DESC";
											$query_my_trans=mysql_query($sql_my_trans);
											$td_var=1;
											while($result_my_trans=mysql_fetch_array($query_my_trans)){
												if($td_var % 2 == 0){
														$td_color="#FFFFFF";
													}else{
														$td_color="#F2F2F2";
													}
												if($result_my_trans['transaction_type']=='Refund'){
													$result_my_trans['status']="Rejected Order Refunded";
												}
												echo '<tr bgcolor="'.$td_color.'">
														<td>'.$result_my_trans['transaction_id'].'</td>
														<td>'.$result_my_trans['transaction_amount'].'</td>
														<td>'.$result_my_trans['transaction_date'].'</td>
														<td>'.$result_my_trans['transaction_type'].'</td>
														<td>'.$result_my_trans['status'].'</td>
												</tr>';
												$td_var++;
											}
											?>		
											</table>
											<br><br>
											<h1 class="page-title">Debit Transactions (Placed Orders Transactions )</h1>
											<table class="order_hisory_table">
											<tr bgcolor="#578EBE"><td><b>Transaction Id</b></td><td><b>Amount (INR)</b></td><td><b>Date (yyyy-mm-dd)</b></td><td><b>Status</b></td></tr>
											<?php
											$sql_my_trans="SELECT `transaction_id`, `transaction_amount`,`transaction_date`, `status` FROM `cust_kolors_retailer_debits_transactions` WHERE `retailer_id`=".$_SESSION['session_retailer_account_id']." ORDER BY `transaction_id` DESC";
											$query_my_trans=mysql_query($sql_my_trans);
											$td_var=1;
											while($result_my_trans=mysql_fetch_array($query_my_trans)){
												if($td_var % 2 == 0){
														$td_color="#FFFFFF";
													}else{
														$td_color="#F2F2F2";
													} 
												$sql_order_det="SELECT `order_id`, `order_amount`, `order_status` FROM `cust_retail_unlock_orders` WHERE `debit_transaction_id`='".$result_my_trans['transaction_id']."'";
												//echo $sql_order_det;exit;
												$query_order_det=mysql_query($sql_order_det);
												$result_order_det=mysql_fetch_array($query_order_det);
												
												if($result_order_det['order_status']==2){
													$order_status_by_admin="Order Rejected. ".$result_order_det['order_amount']." INR Refunded.";
												}else{
													$order_status_by_admin="Success.";
												}
												echo '<tr bgcolor="'.$td_color.'">
														<td>'.$result_my_trans['transaction_id'].'</td>
														<td>'.$result_my_trans['transaction_amount'].'</td>
														<td>'.$result_my_trans['transaction_date'].'</td>
														<td>'.$order_status_by_admin.'</td>
												</tr>';
												$td_var++;
											} 
											?>		
											</table>				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		Copyright © 2015, <a href="#">KolorsMobileServices.com</a>
	</div>
	
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./retail-login.php');
}
?>