<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">

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
                    <?php
		    $job_variable_display='';
		    if($session_user_subscription_plan == 'annual'){
		        $sql_store_job_count="SELECT COUNT(entry_id) AS `store_job_count` FROM `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `delete_status`='0' AND `added_date` > '".$subscription_date."' ";
		        $query_store_job_count=mysql_query($sql_store_job_count);
		        $result_store_job_count=mysql_fetch_array($query_store_job_count); 
		        
		        $job_variable_display="<span style='color:green'> ".$result_store_job_count['store_job_count']." Jobs Consumed out of 2700.</span>";
		    }
		    ?>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Plan Details</h4>

                                </div>
                            </div>
                            <div><h1><?php echo $mess; ?></h1></div>
                        </div>
                        <!-- end page title -->
                        
                <div class="row">
                    <div class="col-xl-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    
                                <table id="customers" class="table table-bordered">
                                    <tr>
                                        <td>Store ID:</td><td><?php echo ucfirst($_SESSION['session_store_id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Store Name:</td><td><?php echo ucfirst($_SESSION['session_store_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Subscription Plan:</td><td><?php echo ucfirst($subscription_plan); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Subscription Activated Date:</td><td><?php echo date('d/m/Y',strtotime($subscription_date)); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Subscription Ends on:</td><td><?php echo $subscription_end_date; ?> , Days Left : <?php echo $days_left?></td>
                                    </tr>
                                    <tr>
                                        <td>Jobs Consumed:</td><td><?php echo $job_variable_display;?></td>
                                    </tr>
                                </table>
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
                function validate()
            {
				if (document.model_add.defect_name.value == "")
                {
                    document.model_add.defect_name.focus();
                    alert("Enter Dfeect Name");
					return false;
                }

			}
			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				}
			}

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