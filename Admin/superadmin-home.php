<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){

if($_SESSION['session_username']=='superadmin'){
    
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


				<?php
					$sql_store_all="SELECT COUNT(store_id) as all_store_count FROM `stores`";
					$query_store_all=mysql_query($sql_store_all);
					$result_store_all=mysql_fetch_array($query_store_all);
			
					$sql_paid_users="SELECT COUNT(user_id) as paid_store_count FROM `cust_kolors_users_list` WHERE `user_role`='admin' AND `status`='1' AND (`subscription_plan`='quarterly' OR `subscription_plan`='halfyearly' OR `subscription_plan`='annual')";
					$query_paid_users=mysql_query($sql_paid_users);
					$result_paid_users=mysql_fetch_array($query_paid_users);

					$sql_admin_users_count="SELECT COUNT(user_id) as admin_users_count FROM `cust_kolors_users_list` WHERE `user_role`='admin'";
					$query_admin_users_count=mysql_query($sql_admin_users_count);
					$result_admin_users_count=mysql_fetch_array($query_admin_users_count);
					
					$sql_active_admin_users_count="SELECT COUNT(user_id) as active_admin_users_count FROM `cust_kolors_users_list` WHERE `user_role`='admin' AND `status`='1'";
					$query_active_admin_users_count=mysql_query($sql_active_admin_users_count);
					$result_active_admin_users_count=mysql_fetch_array($query_active_admin_users_count);
					
					$sql_inactive_admin_users_count="SELECT COUNT(user_id) as inactive_admin_users_count FROM `cust_kolors_users_list` WHERE `user_role`='admin' AND `status`='0'";
					$query_inactive_admin_users_count=mysql_query($sql_inactive_admin_users_count);
					$result_inactive_admin_users_count=mysql_fetch_array($query_inactive_admin_users_count);
					
					$sql_staff_users_count="SELECT COUNT(user_id) as staff_users_count FROM `cust_kolors_users_list` WHERE `user_role`='staff' AND `status`='1'";
					$query_staff_users_count=mysql_query($sql_staff_users_count);
					$result_staff_users_count=mysql_fetch_array($query_staff_users_count);
					
					
					?>
					
					

				<div class="content_holder">

				
				
				<div class="content_holder_body">
											<div class="widget2">
												<div class="widget2_heading">&#10064;&nbsp;&nbsp;Total Stores </div>
											<div class="widget2_body">
													<p style="text-align:center; font-size:45px;"><?php echo $result_store_all['all_store_count'];?></p>	
												</div>
											</div>
											
											<div class="widget2">
												<div class="widget2_heading">&#x2668;&nbsp;&nbsp;Total Admin Users</div>
												<div class="widget2_body">
												    <p style="text-align:center; font-size:45px;"><?php echo $result_admin_users_count['admin_users_count'];?></p>	
												</div>
											</div>
											<div class="widget2">
												<div class="widget2_heading">&#x2668;&nbsp;&nbsp;Active Admin Users</div>
												<div class="widget2_body">
												    <p style="text-align:center; font-size:45px;"><?php echo $result_active_admin_users_count['active_admin_users_count'];?></p>	
												</div>
											</div>
											<div class="widget2">
												<div class="widget2_heading">&#x2668;&nbsp;&nbsp;InActive Admin Users</div>
												<div class="widget2_body">
												    <p style="text-align:center; font-size:45px;"><?php echo $result_inactive_admin_users_count['inactive_admin_users_count'];?></p>	
												</div>
											</div>
                                            <div class="widget2">
												<div class="widget2_heading">&#10064;&nbsp;&nbsp;Paid Stores/Admins </div>
											<div class="widget2_body">
													<p style="text-align:center; font-size:45px;"><?php echo $result_paid_users['paid_store_count'];?></p>	
												</div>
											</div>
											
											<div class="widget2">
												<div class="widget2_heading">&#9734;&nbsp;&nbsp;Staff Users</div>
												<div class="widget2_body">
												<p style="text-align:center; font-size:45px;"><?php echo $result_staff_users_count['staff_users_count'];?></p>	
						
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
}
}else{
header('Location: ./index.php');
}
?>