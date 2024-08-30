<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];

$sql_plan="SELECT * FROM `cust_kolors_users_list` WHERE `username`=".$_SESSION['session_username'];
$query_plan=mysql_query($sql_plan);
$result_plan=mysql_fetch_array($query_plan);

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
			<div class="page_title_div"><h1 style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:20px;">Welcome <?php echo $_SESSION['session_staff_name'];?>,</h1></div>
			<div class="page_title_div"><h1 style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:20px;">Store Name - <?php echo $_SESSION['session_store_name'];?>, Store Id - <?php echo $_SESSION['session_store_id'];?></h1></div>
            <?php
            if($_SESSION['session_user_role']=='admin'){
            ?>
            <div class="page_title_div">
                <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">Subscription Plan: <?php echo ucfirst($subscription_plan); ?> <span style="color:#F5D149">&#10041;</span> </span>
		        <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">Ends on: <?php echo $subscription_end_date; ?> <span style="color:#F5D149">&#10041;</span> <?php echo $days_left?></span>
			</div>
			<?php
            }
            ?>
			<div class="content_holder">
				<!--<?php
					$sql_inprocess="SELECT COUNT(order_id) as inp_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=3";
					$query_inprocess=mysql_query($sql_inprocess);
					$result_inprocess=mysql_fetch_array($query_inprocess);

					$sql_completed="SELECT COUNT(order_id) as cmp_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=4";
					$query_completed=mysql_query($sql_completed);
					$result_completed=mysql_fetch_array($query_completed);
					
					$sql_rej="SELECT COUNT(order_id) as rj_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=2";
					$query_rej=mysql_query($sql_rej);
					$result_rej=mysql_fetch_array($query_rej);
					?>
				<div style="color:red; font-size:16px; padding:10px;">Order Summary</div>
				<div style="color:blue; font-size:13px; padding:10px;">&nbsp;&nbsp;&nbsp;In Process Orders - <?php echo $result_inprocess['inp_count'];?></div>
				<div style="color:green; font-size:13px; padding:10px;">&nbsp;&nbsp;Completed Orders - <?php echo $result_completed['cmp_count'];?></div>
				<div style="color:red; font-size:13px; padding:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rejected Orders - <?php echo $result_rej['rj_count'];?></div> -->


				<?php
					$sql_all="SELECT COUNT(entry_id) as all_order_count FROM `adm_cust_mob_add` where `store_id`='".$session_store_id."' AND `delete_status`='0'";
					$query_all=mysql_query($sql_all);
					$result_all=mysql_fetch_array($query_all);
			
					$sql_inprocess="SELECT COUNT(entry_id) as pend_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `status`='Pending' AND `delete_status`='0'";
					$query_inprocess=mysql_query($sql_inprocess);
					$result_inprocess=mysql_fetch_array($query_inprocess);

					$sql_completed="SELECT COUNT(entry_id) as cmp_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `status`='Completed' AND `delete_status`='0'";
					$query_completed=mysql_query($sql_completed);
					$result_completed=mysql_fetch_array($query_completed);
					
					$sql_rej="SELECT COUNT(entry_id) as rj_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `rejected`='1' AND `delete_status`='0'";
					$query_rej=mysql_query($sql_rej);
					$result_rej=mysql_fetch_array($query_rej);
					
					$sql_del="SELECT COUNT(entry_id) as del_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `status`='Delivered'";
					$query_del=mysql_query($sql_del);
					$result_del=mysql_fetch_array($query_del);
					?>
					
					

				<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Dashboard</div>
				
				<div class="content_holder_body">
											<div class="widget2">
												<div class="widget2_heading">&#10064;&nbsp;&nbsp;Total Orders</div>
											<div class="widget2_body">
													<p style="text-align:center; font-size:45px;"><?php echo $result_all['all_order_count'];?></p>	
												</div>
											</div>
											
											<div class="widget2">
												<div class="widget2_heading">&#x2668;&nbsp;&nbsp;Pending Orders</div>
												<div class="widget2_body">
												    <p style="text-align:center; font-size:45px;"><?php echo $result_inprocess['pend_count'];?></p>	
												</div>
											</div>

											
											<div class="widget2">
												<div class="widget2_heading">&#9734;&nbsp;&nbsp;Comp & Pend For Delivery</div>
												<div class="widget2_body">
												<p style="text-align:center; font-size:45px;"><?php echo $result_completed['cmp_count'];?></p>	
						
												</div>
											</div>
												
											<div class="widget2">
												<div class="widget2_heading">&#10008;&nbsp;&nbsp;Rejected Orders</div>
												<div class="widget2_body">
												<p style="text-align:center; font-size:45px;"><?php echo $result_rej['rj_count'];?></p>	
						
												</div>
											</div>
										
											<div class="widget2">
												<div class="widget2_heading">&#9730;&nbsp;&nbsp;Delivered Orders</div>
												<div class="widget2_body">
												<p style="text-align:center; font-size:45px;"><?php echo $result_del['del_count'];?></p>	
						
												</div>
											</div>
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
}else{
header('Location: ./index.php');
}
?>