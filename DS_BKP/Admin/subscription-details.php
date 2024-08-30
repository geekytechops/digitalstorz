<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
if($_SESSION['session_username'] == 'superadmin'){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];

$sql_plan="SELECT * FROM `cust_kolors_users_list` WHERE `user_role`='admin' ORDER BY `user_id` DESC";
$query_plan=mysql_query($sql_plan);
//echo mysql_num_rows($query_plan);
//echo $sql_plan;
?>
<html>
<head>
	<link href="https://digitalstorz.com/css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>


</style>

</head>
<body>
	<div class="header">
	    
		<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span></span>
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold;  font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="content_holder">
				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Users Subscription Details</div>
				<div class="content_holder_body">
				<table class="order_hisory_table">
				<tr class="table_heading">
														<td><b>User ID</b></td>
														<td><b>Store ID</b></td>
														<td><b>Store Name</b></td>
														<td><b>Username</b></td>
														<td><b>Staff Name</b></td>
														<td><b>Status</b></td>
														<td><b>Referal</b></td>
														<td><b>Subscription Plan</b></td>
														<td><b>Subscription Date</b></td>
														<td><b>Subscription Ends on</b></td>
														<td><b>Days Left</b></td>
													</tr>    
				<?php
				while($result_plan=mysql_fetch_array($query_plan)){
//print_r($result_plan);
$subscription_plan=$result_plan['subscription_plan'];
$subscription_date=$result_plan['subscription_date'];

if($subscription_plan=="trail"){
    $active_days=30;
}elseif($subscription_plan=="quarterly"){
    $active_days=90;
}elseif($subscription_plan=="halfyearly"){
    $active_days=183;
}elseif($subscription_plan=="annual"){
    $active_days=365;
}

$subscription_end_date=date('d-m-Y', strtotime($subscription_date. ' + '.$active_days.' days'));
$subscription_end_date_temp=date('y-m-d', strtotime($subscription_date. ' + '.$active_days.' days'));

$date1=date_create(date("Y/m/d"));
$date2=date_create($subscription_end_date_temp);
$diff=date_diff($date1,$date2);
$days_left= $diff->format("%a days left");

$sql_referal="SELECT `referal_code` FROM stores WHERE `store_id`=".$result_plan['store_id'];
$query_referal=mysql_query($sql_referal);
$result_referal=mysql_fetch_array($query_referal);

                    echo '<tr>
							<td>'.$result_plan['user_id'].'</td>
							<td>'.$result_plan['store_id'].'</td>
							<td>'.$result_plan['store_name'].'</td>
							<td>'.$result_plan['username'].'</td>
							<td>'.$result_plan['staff_name'].'</td>
							<td>'.$result_plan['status'].'</td>
							<td>'.$result_referal['referal_code'].'</td>
							<td>'.$result_plan['subscription_plan'].'</td>
							<td>'.$result_plan['subscription_date'].'</td>
							<td>'.$subscription_end_date.'</td>
							<td>'.$days_left.'</td>
						</tr>';                    
				}				    
				?>
				</table>
				<div class="clear"></div>			
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
mysql_close($connection);
}
}else{
header('Location: ./index.php');
}
?>