<?php
session_start();
//print_r($_SESSION);
include("./dbconnect.php");
$mess='';
$sql_plan="SELECT * FROM `cust_kolors_users_list` WHERE `username`=".$_SESSION['session_username'];
//echo $sql_plan;
$query_plan=mysql_query($sql_plan);
$result_plan=mysql_fetch_array($query_plan);
//print "pre"; print_r($result_plan);exit;
$mobile_verify_status=$result_plan['mobile_no_verified'];
$session_user_subscription_plan=$_SESSION['session_user_subscription_plan'];
//echo $mobile_verify_status;exit;
if($mobile_verify_status == ''){ //redirecting user to verify otp through mobile
    $otp_kol=rand(100000,999999);
    $otp_kol_send=strval($otp_kol);
    $message='Dear Customer, OTP for Mobile number verification is '.$otp_kol_send.'. Thank you. - DigitalStorz';
    session_start();
    $_SESSION['sess_start_time'] = time();
    $_SESSION['otp_sent_for_verification']=$otp_kol_send;
        //SMS SENDING CODE for OTP
		
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$_SESSION['session_username'],
        "ApiKey" => "7BuFBODK3Xs/WqDhRgUCaWpUVndUszaBT5HZEbP0K40=",
        "ClientId" => "344a995d-c0f6-4ded-96b3-992e4b5dbeb6"
        );
        $payload = json_encode($data);
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.smslane.com/api/v2/SendSMS",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>$payload,
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($curl);
        curl_close($curl);
        
        header('Location: ./verify-mobile-num.php');
}
else{ //if user has mobile verified starts

        $sql_kyc="SELECT `kyc_status` FROM `stores` where `store_id`=".$_SESSION['session_store_id'];
	    //echo $sql_kyc;
		$query_kyc=mysql_query($sql_kyc);
		$result_kyc=mysql_fetch_array($query_kyc);
		//echo $result_kyc['kyc_status'];exit;
        if($result_kyc['kyc_status']=='Completed'){
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){  //admin page starts

$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$subscription_plan=$result_plan['subscription_plan'];
$subscription_date=$result_plan['subscription_date'];


if(isset($_REQUEST['status'])){
		$m=$_REQUEST['status'];	
		if($m=='mobile_verified'){
		$mess="<span style='color:green; margin-left:250px;'>MOBILE NUMBER VERIFIED SUCCESSFULLY..</span>";
        }
}
		
if($subscription_plan=="trail"){
    $active_days=7;
}elseif($subscription_plan=="monthly"){
    $active_days=30;
}elseif($subscription_plan=="quarterly"){
    $active_days=90;
}elseif($subscription_plan=="halfyearly"){
    $active_days=183;
}elseif($subscription_plan=="annual"){
    $active_days=365;
}elseif($subscription_plan=="trail-mobialive"){
    $active_days=30;
}

$subscription_end_date=date('d-m-Y', strtotime($subscription_date. ' + '.$active_days.' days'));
//$subscription_end_date_temp=date('y-m-d', strtotime($subscription_date. ' + '.$active_days.' days'));
$subscription_end_date_temp=date('y-m-d', strtotime($subscription_date. ' + '.$active_days.' days'));
$date1=date_create(date("Y/m/d"));
$date2=date_create($subscription_end_date_temp);
$diff=date_diff($date1,$date2);
$days_left= $diff->format("%a days left");


$date_sub = $subscription_date;
$date_end= date('Y-m-d', strtotime($subscription_date. ' + '.$active_days.' days'));
$date_now = date("Y-m-d");

//echo $date_end;
//echo $date_now;
//if ($date_end > $date_now) {
//echo 'You have active plan';
//} else {
  //echo 'Plan Expired';
//}

?>
<html>
<head>
            <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
	<link href="https://digitalstorz.com/css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>
#grad {
  text-transform: uppercase;
	background: linear-gradient(to right, #EDD106 0%, #06DFED 100%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}

</style>

</head>
<body>
	<div class="header">
	    
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold;  font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
		
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
		    <div><h1><?php echo $mess; ?></h1></div>
			<div class="page_title_div"><h1 style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:20px;">Welcome <?php echo $_SESSION['session_staff_name'];?>, </h1></div>
			<div class="page_title_div"><h1 style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:20px;">
			    Store Name - <?php echo $_SESSION['session_store_name'];?>, 
			    Store Id - <?php echo $_SESSION['session_store_id'];?>, 
			    <span style="color:green">Mobile Number Vierified: <?php echo ucfirst($mobile_verify_status);?></span></h1>
			    
			    <?php 
			        if($subscription_plan=='trail' || $subscription_plan=='trail-mobialive'){
			        $sql_sms_count="SELECT `message_sent_count` FROM `stores` WHERE `store_id`=".$_SESSION['session_store_id']; 
			        //echo $sql_sms_count;
			        $query_sms_count=mysql_query($sql_sms_count);
			        $result_sms_count=mysql_fetch_array($query_sms_count);
			            echo '<span style="color:green;float:right;font-weight:bold;padding-right:20px;">SMS Consumed : '.$result_sms_count["message_sent_count"].' Out of 200.</span>';
			        }
			    ?>
			</div>
            <?php
            //if($_SESSION['session_user_role']=='admin'){
            ?>
            <?php
		    $job_variable_display='';
		    if($session_user_subscription_plan == 'annual'){
		        $sql_store_job_count="SELECT COUNT(entry_id) AS `store_job_count` FROM `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `delete_status`='0'";
		        $query_store_job_count=mysql_query($sql_store_job_count);
		        $result_store_job_count=mysql_fetch_array($query_store_job_count); 
		        
		        $job_variable_display="<span style='color:green'> ".$result_store_job_count['store_job_count']." Jobs Consumed out of 2700.</span>";
		    }
		    ?>
            <div class="page_title_div">
                <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">Subscription Plan: <?php echo ucfirst($subscription_plan); ?> <span style="color:#F5D149">&#10041;</span> </span>
		        <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">Ends on: <?php echo $subscription_end_date; ?> <span style="color:#F5D149">&#10041;</span> <?php echo $days_left?></span>
		        <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">&nbsp;<span style="color:#F5D149">&#10041;</span><?php //echo $job_variable_display;?></span>
			</div>
			<div class="page_title_div">
                <!--<span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8"> <?php echo $mobile_no_verify_status ?> <span style="color:#F5D149"> Verify Now</span> </span>-->
		      
			</div>
			
			<?php
            //}
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
                <?php
                //$ua = strtolower($_SERVER["HTTP_USER_AGENT"]);
                //$isMob = is_numeric(strpos($ua, "mobile"));
                //echo $isMob;
                //echo $_SERVER["HTTP_USER_AGENT"];
                
                //echo $session_id;
                ?>
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
											</div><br>
											
											<div style="margin-left:25%;">
											  
											    <iframe width="560" height="315" src="https://www.youtube.com/embed/UG0HTlYeRVI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											    
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

}//admin page Ends
else{
header('Location: ./index.php');
}
}
else{
    header('Location: ./kyc-complete.php');
}
}
?>