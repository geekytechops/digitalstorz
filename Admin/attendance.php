<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
<?php 

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


?>

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
                                    <h4 class="mb-sm-0">Attendance</h4>

                                </div>
                            </div>
                            <div><h1><?php echo $mess; ?></h1></div>
                        </div>                       
                        
                <div class="row">                    
                    <div class="col-xl-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">

                                <div id="calendar" style="width:500px;"></div>

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
 

</script>
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