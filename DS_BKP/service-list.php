<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
include("./Admin/dbconnect.php");
$page_no=6;
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
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<div class="left_container">
			<?php include("./retailer-menu.php");?>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Unlock Services Available Currently</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;List Of Services</div>
				
				<div class="content_holder_body">
											<table class="order_hisory_table">
													<tr class="table_heading">
														<td>Service Category</td>
														<td>Service Name</td>
														<td>Price (INR)</td>
														<td>Duration</td>
													</tr>
										
											<?php
												$sql_countries_avail="SELECT DISTINCT(service_category) FROM `cust_kolors_services_list`";
												$query_countries_avail=mysql_query($sql_countries_avail);
												while($result_countries_avail=mysql_fetch_array($query_countries_avail)){
													$sql_ser="SELECT * FROM cust_kolors_services_list WHERE `service_category`='".$result_countries_avail['service_category']."' ";
													//echo $sql_ser;exit;
													$query_ser=mysql_query($sql_ser);
													echo '<tr style="background:#BE70E9; color:#fff;"><td colspan=6>'.$result_countries_avail['service_category'].'</td></tr>';
													while($result_ser=mysql_fetch_array($query_ser)){
														
														echo '<tr>
																	<td style="width:350px;;">'.$result_ser['service_name'].'</td>
																	<td style="width:90px;">'.$result_ser['customer_price'].'</td>
																	<td style="width:90px;">'.$result_ser['retail_price'].'</td>
																	<td style="width:90px;">'.$result_ser['duration'].'</td>
													
															 </tr>';
													}
												}
												
											?>
											
											
											
											<?php
											/*	$sql_ser="SELECT * FROM cust_kolors_services_list";
												$query_ser=mysql_query($sql_ser);
												while($result_ser=mysql_fetch_array($query_ser)){
													echo '<tr>
																<td>'.$result_ser['service_category'].'</td>
																<td>'.$result_ser['service_name'].'</td>
																<td>'.$result_ser['customer_price'].'</td>
																<td>'.$result_ser['duration'].'</td>
																
														 </tr>';
												}
												//<td><a href="http://www.kolorsmobileservices.com/Unlocks/unlock-process.php?un_id='.$result_ser['service_id'].'">BUY</a></td>
											*/
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