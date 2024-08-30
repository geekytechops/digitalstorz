<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
include("./Admin/dbconnect.php");
$page_no=1;
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="../js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
</head>
<body>
	<div class="header">
		<a href="./retailer-home.php">&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services</a>
		<!--<a href="#"><img class="logo_img" src="../images/logo.png"></a>-->
	</div> 
	
	<div class="main_container">
		<div class="left_container">
			<?php include("./retailer-menu.php");?>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Hi <?php echo $_SESSION['session_retailer_name'];?>, Welcome..</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Dashboard</div>
				
				<div class="content_holder_body">
											<div class="widget2">
												<div class="widget2_heading">Account Details</div>
												<div class="widget2_body">
														<table>
														<tr>
															<td style="text-align:right"><font color="#0B610B">Name&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $_SESSION['session_retailer_name'];?></td>
														</tr>
														<tr>
															<td style="text-align:right"><font color="#0000FF">Email&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $_SESSION['session_retail_username'];?></td>
														</tr>
														<tr>
															<td style="text-align:right"><font color="#0B610B">Username&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $_SESSION['session_retail_username_login'];?></td>
														</tr> 
														<tr>
															<td style="text-align:right"><font color="#0000FF">Account Id&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $_SESSION['session_retailer_account_id'];?></td>
														</tr>
														</table>
						
												</div>
											</div>
											<div class="widget2">
												<div class="widget2_heading">Your Credits</div>
												<div class="widget2_body">
													<p>
														<?php
															$sql_inprocess_bal="SELECT SUM(order_amount) AS in_process_amt FROM `cust_retail_unlock_orders` WHERE `retailer_id`='".$_SESSION['session_retailer_account_id']."' AND (`order_status` =0 OR `order_status` =1 OR `order_status` =3);";
															$query_inprocess_bal=mysql_query($sql_inprocess_bal);
															$result_inprocess_bal=mysql_fetch_array($query_inprocess_bal);
															if(isset($result_inprocess_bal['in_process_amt'])){
																$in_process_credit_bal=$result_inprocess_bal['in_process_amt'];
															}else{
																$in_process_credit_bal=0;
															} 
														?>
														<table>
														<tr>
															<td style="text-align:right"><font color="#0B610B">Available Credits&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $ret_credits_avail;?>&nbsp;INR</td>
														</tr>
														<tr>
															<td style="text-align:right"><font color="#0000FF">Credits in Process&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $in_process_credit_bal;?>&nbsp;INR</td>
														</tr>
														</table>
													
													</p>
												</div>
											</div>
											
											<?php
												$sql_inprocess="SELECT COUNT(order_id) as inp_count FROM  `cust_retail_unlock_orders` WHERE `retailer_id`='".$_SESSION['session_retailer_account_id']."' AND `order_status`=3";
												$query_inprocess=mysql_query($sql_inprocess);
												$result_inprocess=mysql_fetch_array($query_inprocess);

												$sql_completed="SELECT COUNT(order_id) as cmp_count FROM  `cust_retail_unlock_orders` WHERE `retailer_id`='".$_SESSION['session_retailer_account_id']."' AND `order_status`=4";
												$query_completed=mysql_query($sql_completed);
												$result_completed=mysql_fetch_array($query_completed);
												
												$sql_rej="SELECT COUNT(order_id) as rj_count FROM  `cust_retail_unlock_orders` WHERE `retailer_id`='".$_SESSION['session_retailer_account_id']."' AND `order_status`=2";
												$query_rej=mysql_query($sql_rej);
												$result_rej=mysql_fetch_array($query_rej);
												
												//echo $sql_rej;
											?>
											
											<div class="widget2">
												<div class="widget2_heading">Orders Summary</div>
												<div class="widget2_body">
													<table>
														<tr>
															<td style="text-align:right"><font color="blue">In Process Orders&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $result_inprocess['inp_count'];?></td>
															<td><a href="http://www.kolorsmobileservices.com/Unlocks/retailer-order-history.php?filter=3"><font color="green">&nbsp;&nbsp;&nbsp;View</font></a></td>
														</tr>
														<tr>
															<td style="text-align:right"><font color="green">Completed Orders&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $result_completed['cmp_count'];?></td>
															<td><a href="http://www.kolorsmobileservices.com/Unlocks/retailer-order-history.php?filter=4"><font color="green">&nbsp;&nbsp;&nbsp;View</font></a></td>
														</tr>
														<tr> 
															<td style="text-align:right"><font color="blue">Rejected Orders&nbsp;&nbsp;:&nbsp;&nbsp;</font></td>
															<td><?php echo $result_rej['rj_count'];?></td>
															<td><a href="http://www.kolorsmobileservices.com/Unlocks/retailer-order-history.php?filter=2"><font color="green">&nbsp;&nbsp;&nbsp;View</font></a></td>
														</tr>
													</table>
						
												</div>
											</div>
								<div class="clear"></div>			
				</div>
				
			</div><div class="clear"></div>
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