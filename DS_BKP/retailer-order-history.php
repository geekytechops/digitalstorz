<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
$page_no=3;
include("./Admin/dbconnect.php");
$imei_no_ser='';
	if(isset($_REQUEST['submit'])){
		$imei_no_ser=$_REQUEST['imei_search'];
		
		$sql_ser="SELECT * FROM `cust_retail_unlock_orders` WHERE `email`='".$_SESSION['session_retail_username']."' AND `imei_no`='".$imei_no_ser."'";
		$query_ser=mysql_query($sql_ser);
		
	}else{
		if(isset($_REQUEST['filter'])){
		$filter=$_REQUEST['filter'];
	}else{
		$filter='all';
	}
	
	if($filter=='all')
	{
		$sql_ser="SELECT * FROM `cust_retail_unlock_orders` WHERE `email`='".$_SESSION['session_retail_username']."' ORDER BY `order_placed_date` DESC";
		$query_ser=mysql_query($sql_ser);
	}else{
		$sql_ser="SELECT * FROM `cust_retail_unlock_orders` WHERE `email`='".$_SESSION['session_retail_username']."' AND `order_status`='".$filter."' ORDER BY order_id DESC";
		$query_ser=mysql_query($sql_ser);
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
		function filterRecords(filterVar){
			var filter=filterVar;
			//alert(filter);
			 window.location="retailer-order-history.php?filter="+filter;
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
			<div class="page_title_div"><h1>Order History</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Detailed Order Details</div>
				
				<div class="content_holder_body">
											<table> 
												<tr>
													<td>Status: 
													<?php $array_status=array (
																		 
																		//"0"=>"Waiting for Confirmation",
																		//"1"=>"Approved Orders", 
																		"3"=>"In Process Orders",
																		"4"=>"Completed Orders",
																		"2"=>"Rejected Orders",
																		"all"=>"All");
													?>
														<select style="width:250px;" class="search_form_select" onchange="filterRecords(this.value)">
															<?php
																foreach ($array_status as $key => $value){
																	if($filter==$key){
																		echo "<option selected value=".$key.">".$value."</option>";
																	}else{
																		echo "<option value=".$key.">".$value."</option>";
																	}
																}
															?>
														</select>
													</td>
													
													<td><form name="imei_search_form" method="post" onsubmit="validate_imei();";>&nbsp;&nbsp;IMEI Search&nbsp;&nbsp;:&nbsp;<input type="text" style="width:250px;" name="imei_search" value="<?php echo $imei_no_ser; ?>" />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Search"/></form></td>
												</tr>
											</table>
											<br><br>
											<table class="order_hisory_table">
													<tr class="table_heading">
														<td>Order&nbsp;No</td>
														<td>Service&nbsp;Name</td>
														<td>IMEI&nbsp;No</td></td>
	
														<td>Order&nbsp;Date</td>
														<td>Status</td>
														<td>Additional&nbsp;Info</td>
													</tr>
											<?php 
												$td_var=1;
												while($result_ser=mysql_fetch_array($query_ser)){
								
													if($td_var % 2 == 0){
														$td_color="#fff";
													}else{
														$td_color="#fff";
													}
												$sql_ser_name="SELECT service_name FROM cust_kolors_services_list WHERE service_id=".$result_ser['service_id'];
												$query_ser_name=mysql_query($sql_ser_name);
												$res_ser_name=mysql_fetch_array($query_ser_name);
												$unlock_ser_name=$res_ser_name['service_name'];
													
													if($result_ser['order_status']=="0"){
														$order_status_new="Waiting for Confirmation";
													}else if($result_ser['order_status']=="1"){
														$order_status_new="In Process";
													}else if($result_ser['order_status']=="2"){
														$order_status_new="Order Rejected";
													}else if($result_ser['order_status']=="3"){
														$order_status_new="In Process";
													}else if($result_ser['order_status']=="4"){
														$order_status_new='Order Completed';
													}else{
														$order_status_new='';
													}
												
												//Comment Code for Status
												/*
													if($result_ser['order_status']=="1"){
														$stat_var='<p style="height:20px;  border:1px solid #5882FA; background:#5882FA;color:#fff; padding:2px; border-radius:2px;">Approved</p>';
														//echo '<tr bgcolor=#ACFA58>'; //In process Blue
													}else if($result_ser['order_status']=="2"){
														$stat_var='<p style="height:20px; border:1px solid #FA5858; background:#FA5858; color:#fff;  padding:2px; border-radius:2px;">Rejected</p>';
														//echo '<tr bgcolor=#F8E0E0>'; // Order Rejected red
													}else if($result_ser['order_status']=="0"){
														$stat_var='<p style="height:20px; border:1px solid #F7D358; background:#F7D358; padding:2px; border-radius:2px;">Waiting</p>';
														//echo '<tr bgcolor=#F7D358>'; // waiting for conf yellow
													}else if($result_ser['order_status']=="3"){
														$stat_var='<p style="height:20px;  border:1px solid #5882FA; background:#5882FA;color:#fff; padding:2px; border-radius:2px;">In Process</p>';
														//echo '<tr bgcolor=#ACFA58>'; //In process Blue
													}
													
													else if($result_ser['order_status']=="4"){
														$stat_var='<p style="height:20px; border:1px solid #5FB404; color:#fff; background:#5FB404; padding:2px; border-radius:2px;">Completed</p>';
														//echo '<tr bgcolor=#F2F2F2>'; // order completed Green
													}
												
												*/
													if($result_ser['order_status']=="1"){
														$stat_var_imei='<td style="height:20px; background:#5882FA;color:#fff; padding:2px; ">'.$result_ser['imei_no'].'</td>';
														//echo '<tr bgcolor=#ACFA58>'; //In process Blue
													}else if($result_ser['order_status']=="2"){
														$stat_var_imei='<td style="height:20px; background:#FEBFBF; color:#000;  padding:2px; ">'.$result_ser['imei_no'].'</td>';
														//echo '<tr bgcolor=#F8E0E0>'; // Order Rejected red
													}else if($result_ser['order_status']=="0"){
														$stat_var_imei='<td style="height:20px; background:#F7D358; padding:2px; ">'.$result_ser['imei_no'].'</td>';
														//echo '<tr bgcolor=#F7D358>'; // waiting for conf yellow
													}else if($result_ser['order_status']=="3"){
														$stat_var_imei='<td style="height:20px; background:#D9E3FE;color:#000; padding:2px; ">'.$result_ser['imei_no'].'</td>';
														//echo '<tr bgcolor=#ACFA58>'; //In process Blue
													}
													
													else if($result_ser['order_status']=="4"){
														$stat_var_imei='<td style="height:20px; color:#000; background:#D9FBB5; padding:2px; ">'.$result_ser['imei_no'].'</td>';
														//echo '<tr bgcolor=#F2F2F2>'; // order completed Green
													}

													echo '<tr bgcolor="'.$td_color.'">
																<td>'.$result_ser['order_id'].'</td>
																
																<td>'.$unlock_ser_name.'</td>
								
																'.$stat_var_imei.'
																<td>'.$result_ser['order_placed_date'].'</td>
																<td>'.$order_status_new.'</td>
																<td>'.$result_ser['comments'].'</td>
																
														 </tr>';  
														 $td_var++;
												}
											?>
										</table>
				</div>
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