<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
	<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$session_store_contact=$_SESSION['session_store_contact'];
$session_user_subscription_plan=$_SESSION['session_user_subscription_plan'];
//echo $session_user_subscription_plan;
$transaction='legal';
include("./dbconnect.php");
$mess='';
$active="active";
$customer_name=''; $mobile_defect='';$mobile_defect2=''; $mobile_defect3='';$mobile_defect4=''; $mobile_name=''; $cust_contact=''; $mobile_defect=''; $exp_delivery=date("Y-m-d", strtotime("tomorrow"));
$est_amount=''; $adv_amount=''; $remarks=''; 

if(isset($_REQUEST['entry_id'])){
	$btn_value=" Update Entry ";
	$btn_name="update";
	
}else{
	$btn_value=" Add Entry ";
	$btn_name="submit";
	$status_radio="";
}

if(isset($_REQUEST['rslt'])){
	if($_REQUEST['rslt']=="success")
		$mess="<font color='#FFF'>Query Added/Updated Succesfully..</font>";
	elseif($_REQUEST['rslt']=="failed")
		$mess="Failed to Add/Update..";
}


if(isset($_REQUEST['submit'])){

		$cust_name_temp=$_REQUEST['customer_name'];
		if($cust_name_temp==''){
			$cust_name='Customer';
		}else{
			$cust_name_temp1=$cust_name_temp;
			$cust_name=ucwords($cust_name_temp1);
		}
		$adv_amount_temp=$_REQUEST['adv_amount'];
		$adv_payment_mode=json_encode($_REQUEST['adv_payment_mode']);
		if($adv_amount_temp==''){
			$adv_amount='';
		}else{
			$adv_amount=$adv_amount_temp;
		}
		$mobile_name_temp=$_REQUEST['mobile_name'];
		$mobile_name=ucwords($mobile_name_temp);

		$mobile_defect=$_REQUEST['mobile_defect'][0];
		$mobile_defect2=$_REQUEST['mobile_defect'][1];
		$mobile_defect3=$_REQUEST['mobile_defect'][2];
		$mobile_defect4=$_REQUEST['mobile_defect'][3];

		//echo $mobile_defect;exit;
		$contact_no=$_REQUEST['contact_no'];
		$alt_contact_no=$_REQUEST['alt_contact_no'];
		$email=$_REQUEST['email'];
		$send_sms_alt_cont=$_REQUEST['send_sms_alt_cont'];
		if($send_sms_alt_cont=="sendalt"){
		    $sms_send_cont=$alt_contact_no;
		}else{
		    $sms_send_cont=$contact_no;
		}

		$tagsInputValues = json_encode($_REQUEST['tags-input-values']);
		$damage_images_save = json_encode($_REQUEST['damage_images_save']);
		$multi_pay = json_encode($_REQUEST['multi_pay']);
		

		$imei_sn=$_REQUEST['imei_sn'];
		$exp_delivery=$_REQUEST['exp_delivery'];
		$gst_transaction=$_REQUEST['gst_bill'];
		$defect_description=$_REQUEST['defect_description'];
		$customer_type=$_REQUEST['customer_type'];
		$screenlock_type=$_REQUEST['screenlock_type'];

		// if($screenlock_type==0){
			$screen_lock1 = $_REQUEST['patternlock_data'];
		// }else{
			$screen_lock2 = $_REQUEST['pin-lock'];
		// }

		$defect_type=$_REQUEST['defect_type'];
		$pickup_address=json_encode($_REQUEST['pickup_address']);
		$cust_gst_no=$_REQUEST['customer_gst_no'];
		$est_amount=$_REQUEST['est_amount'];
		//$adv_amount=$_REQUEST['adv_amount'];
		$remarks_temp=$_REQUEST['remarks'];
		$remarks=ucwords($remarks_temp);
		$added_by=$_SESSION['session_username'];
		$store_id=$_SESSION['session_store_id'];
		//$cur_time=date();
		$cur_time = date('Y-m-d H:i:s');

		//Inserting Data
		$sql_ins="INSERT INTO `adm_cust_mob_add`(`customer_name`, `mobile_name`,`cust_contact`,`cust_alt_contact`,`cust_email`,`send_sms_to_alt`,`imei_serial_num`,`mobile_defect`,`mobile_defect_2`,`mobile_defect_3`,`mobile_defect_4`,`damage_description`,`damage_images`,`screenlock_type`,`screen_lock`,`screen_lock2`,`defect_type`,`pickup_address`,`customer_fulfillment_type`,`defect_description`,`actual_amount`,`rejected_reason`,`exp_delivery`,`est_amount`,`adv_amount`,`remarks`,`added_date`,`status`,`rejected`,`delete_status`,`added_by`,`store_id`,`adv_payment_mode`,`gst`,`customer_gst_no` ,`multi_payment`) VALUES 
		('".$cust_name."','".$mobile_name."','".$contact_no."','".$alt_contact_no."','".$email."','".$send_sms_alt_cont."','".$imei_sn."','".$mobile_defect."','".$mobile_defect2."','".$mobile_defect3."','".$mobile_defect4."','".$tagsInputValues."','".$damage_images_save."',".$screenlock_type.",'".$screen_lock1."','".$screen_lock2."',".$defect_type.",'".$pickup_address."',".$customer_type.",'".$defect_description."','0','".$rejected_reason."','".$exp_delivery."','".$est_amount."','".$adv_amount."','".$remarks."','".$cur_time ."','Pending', '0','0','".$added_by."','".$store_id."','".$adv_payment_mode."','".$gst_transaction."','".$cust_gst_no."','".$multi_pay."')";
		
		$mob_def_sql1="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect;
		$mob_def_query1=mysql_query($mob_def_sql1);
		$result_def_query1=mysql_fetch_array($mob_def_query1);
		$mobile_defect_name1=$result_def_query1['defect_name'];
		
		/*if($mobile_defect2!=''){
		$mob_def_sql2="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect2;
		$mob_def_query2=mysql_query($mob_def_sql2);
		$result_def_query2=mysql_fetch_array($mob_def_query2);
		$mobile_defect_name2=$result_def_query2['defect_name'];
		
		}else{
		$mobile_defect_name2='';
		}
		
		if($mobile_defect3!=''){
		$mob_def_sql3="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect3;
		$mob_def_query3=mysql_query($mob_def_sql3);
		$result_def_query3=mysql_fetch_array($mob_def_query3);
		$mobile_defect_name3=', '.$result_def_query3['defect_name'];
		}else{
		$mobile_defect_name3='';
		}*/
		if( $mobile_defect2 !='' || $mobile_defect3 !='' || $mobile_defect4 !=''){
		    $mobile_defect_name=$mobile_defect_name1.' and others.';
		}else{
		    $mobile_defect_name=$mobile_defect_name1;
		}
		
		if($gst_transaction == 'yes'){
		    $est_amount_1=$est_amount.'+GST';
		}else{
		    $est_amount_1=$est_amount;
		}
		$sql_store_cont="SELECT * FROM `stores` WHERE `store_id`=".$session_store_id;
		$query_store_cont=mysql_query($sql_store_cont);
		$result_store_cont=mysql_fetch_array($query_store_cont);
		$get_store_contact=$result_store_cont['store_contact'];

		//echo $mobile_defect_name;exit;
		
		$query_ins=mysql_query($sql_ins);
		// echo mysql_error();
		// die;
		if($query_ins){
			$lastInsertedId = mysql_insert_id();
		    /*if($mobile_defect_name1 !='' && $mobile_defect_name2 !=''){
		        //$message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name1.', '.$mobile_defect_name2.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		    }else{
		        $message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name1.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		    }*/
		
		   $message='Dear '.$cust_name.', We have received your Device '.$mobile_name.', with defect: '.$mobile_defect_name.', on '.$cur_time.'. Estimated charges Rs.'.$est_amount_1.', Adv Recd Rs.'.$adv_amount.'. Thank you for Visiting '.$session_store_name.'. Ph:'.$get_store_contact.'. Please click on the link to download the Job Sheet http://localhost/projectss/digitalstorz/Admin/print-job.php?job_id='.$lastInsertedId.' - DigitalStorz';

			if($email!=''){		
				
				// echo "<script>
				
				//          $.ajax({
				// 			url: './send-email-job.php?job_id=".$lastInsertedId."&email_id=".$email."', 
				// 			success: function(html) {
				// 				cosnole.log('test');
				// 			}
				// 		});

				// </script>";
				// die;

				$url = "http://localhost/projectss/digitalstorz/Admin/send-email-job.php?job_id=" . $lastInsertedId . "&email_id=" . $email;

				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Optional: disable SSL verification
				curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout for the request (in seconds)
				

				// Execute the cURL session and store the response
				$response = curl_exec($ch);

				// Check for cURL errors
				if (curl_errno($ch)) {
					echo 'cURL Error: ' . curl_error($ch);
				} else {
					print_r($lastInsertedId . $response . $email);
					echo 'Response from the server: ' . $response;
				}

				// Close the cURL session
				curl_close($ch);

			}
		 //$message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		//echo $message; exit;
		
        
        $sql_store_id="SELECT `store_id` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect;
		$mob_def_query1=mysql_query($mob_def_sql1);
		$result_def_query1=mysql_fetch_array($mob_def_query1);
		$mobile_defect_name1=$result_def_query1['defect_name'];
        
        $sql_sentmessages_count="SELECT `message_sent_count` FROM `stores` WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_sentmessages_count=mysql_query($sql_sentmessages_count);
		$result_sentmessages_count=mysql_fetch_array($query_sentmessages_count);

		
	if($session_user_subscription_plan == 'trail' || $session_user_subscription_plan == 'trail-mobialive'){
		if($result_sentmessages_count['message_sent_count'] < 200){
        
		//updating message count in stores.
		$message_length=strlen($message);
        $no_of_messages=ceil($message_length/160);
        //echo $no_of_messages;
        $sql_msg_cnt_upd="UPDATE `stores` SET message_sent_count = message_sent_count + ".$no_of_messages." WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_msg_cnt_upd=mysql_query($sql_msg_cnt_upd);

		//SMS SENDING CODE for Adding Mobile
		
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$sms_send_cont,
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

        //echo $response;
        //sleep (1);
        //exit;
        //echo 'sms less than 200'; exit;
		// $_REQUEST['job_id'] = 13; 
		// include('print-job.php');
		// header('Location: print-job.php?job_id='.$lastInsertedId);
		header('Location: ./view-cust-mobile-entry-ui.php?result_key=pend&dmsg=jas');

		}else{
		    //echo "sms expired";exit;
		    header('Location: ./view-cust-mobile-entry-ui.php?result_key=pend&dmsg=jas');
		}
	}else{
	    //updating message count in stores.
		$message_length=strlen($message);
        $no_of_messages=ceil($message_length/160);
        //echo $no_of_messages;
        $sql_msg_cnt_upd="UPDATE `stores` SET message_sent_count = message_sent_count + ".$no_of_messages." WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_msg_cnt_upd=mysql_query($sql_msg_cnt_upd);

		//SMS SENDING CODE for Adding Mobile
		
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$sms_send_cont,
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

        //echo $response;
        //sleep (1);
        //exit;	 
		// include('print-job.php?entry_id='.$lastInsertedId);
        // header('Location: print-job.php?job_id='.$lastInsertedId);
        header('Location: ./view-cust-mobile-entry-ui.php?result_key=pend&dmsg=jas');
	}
		}else{
			header('Location: ./add-cust-mobile-ui.php?rslt=failed');
			//$mess="Failed to Add..";
		}
}

if(isset($_REQUEST['entry_id'])){ 
	$sql_disp="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$_REQUEST['entry_id']." AND store_id=".$session_store_id;
	$query_disp=mysql_query($sql_disp);
	$rowcount = mysql_num_rows( $query_disp );
	if($rowcount==0){
        $transaction='illegal';
    }
	$result_disp=mysql_fetch_array($query_disp);
	
	$action=$_REQUEST['action'];
	$entry_id=$result_disp['entry_id'];
	$customer_name=$result_disp['customer_name'];
	
	$mobile_name=$result_disp['mobile_name'];
	$cust_contact=$result_disp['cust_contact'];
	$cust_alt_contact=$result_disp['cust_alt_contact'];
	$email=$result_disp['cust_email'];
	$send_sms_to_alt=$result_disp['send_sms_to_alt'];
	$mobile_defect=$result_disp['mobile_defect'];
	$mobile_defect2=$result_disp['mobile_defect_2'];
	$mobile_defect3=$result_disp['mobile_defect_3'];
	$mobile_defect4=$result_disp['mobile_defect_4'];
	$imei_serial_num=$result_disp['imei_serial_num'];
	$exp_delivery=$result_disp['exp_delivery'];
	$defect_description=$result_disp['defect_description'];
	$est_amount=$result_disp['est_amount'];
	$adv_amount=$result_disp['adv_amount'];
	$gst_transaction=$result_disp['gst'];
	$cust_gst_no=$result_disp['customer_gst_no'];
	$remarks=$result_disp['remarks'];
	$spare_cost_1=$result_disp['spare_cost'];
	$status=$result_disp['status'];
	$pickup_address=json_decode(trim($result_disp['pickup_address'],'"'));
	$advpay_mode=$result_disp['adv_payment_mode'];
	$customer_fulfillment_type=$result_disp['customer_fulfillment_type'];
	$multi_payment=$result_disp['multi_payment'];
	
	//echo $advpay_mode;
	//exit;
	if ($status == 'Pending' || $status == 'in-process' || $status == 'customer-approval' || $status == 'customer-approved' || $status == 'spare-part') {

			if($status == 'Pending'){

				$pending = 'checked';
				$process='';
				$approval='';
				$approved='';
				$spareParts='';

			}else if($status == 'in-processs'){

				$pending = '';
				$process='checked';
				$approval='';
				$approved='';
				$spareParts='';

			}else if($status == 'customer-approval'){

				$pending = '';
				$process='';
				$approval='checked';
				$approved='';
				$spareParts='';

			}else if($status == 'customer-approved'){

				$pending = '';
				$process='';
				$approval='';
				$approved='checkeds';
				$spareParts='';

			}else if($status == 'spare-parts'){

				$pending = '';
				$process='';
				$approval='';
				$approved='';
				$spareParts='checkeds';

			}


		$status_radio = "
		<div class='d-flex col-md- mb-2 mt-4'>
			<div class='form-check'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Pending' id='entry_status_upd1' ".$pending.">
				<label class='form-check-label' for='entry_status_upd1'>
					Pending
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='in-process' id='entry_status_upd4' ".$process.">
				<label class='form-check-label' for='entry_status_upd4'>
					In Process
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='customer-approval' id='entry_status_upd5' ".$approval.">
				<label class='form-check-label' for='entry_status_upd5'>
					Waiting for Customer Approval
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='customer-approved' id='entry_status_upd6' ".$approved.">
				<label class='form-check-label' for='entry_status_upd6'>
					Customer Approved
				</label>
			</div>		
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='spare-part' id='entry_status_upd7' ".$spareParts.">
				<label class='form-check-label' for='entry_status_upd7'>
					Waiting for Spare Part
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Completed' id='entry_status_upd2'>
				<label class='form-check-label' for='entry_status_upd2'>
					Completed
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Rejected' onclick='generateRow()' id='entry_status_upd3'>
				<label class='form-check-label' for='entry_status_upd3'>
					Rejected
				</label>
			</div>
		</div>
		<div class='form-check'>
			<input class='form-check-input' type='checkbox' id='notify_user' name='notify_user' value='notify_user_yes'>
			<label class='form-check-label' for='notify_user' style='font-size:12px'>
				Notify Changes to customer<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Only for Pending Updates)
			</label>
		</div>";
	} elseif ($status == 'Completed') {
		$status_radio = "
		<div class='d-flex col-md-6 mb-2'>
			<div class='form-check'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Pending' id='entry_status_upd1'>
				<label class='form-check-label' for='entry_status_upd1'>
					Pending
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Completed' id='entry_status_upd2' checked>
				<label class='form-check-label' for='entry_status_upd2'>
					Completed
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Rejected' id='entry_status_upd3'>
				<label class='form-check-label' for='entry_status_upd3'>
					Rejected
				</label>
			</div>
		</div>";
	} elseif ($status == 'Rejected') {
		$status_radio = "
		<div class='d-flex col-md-6 mb-2'>
			<div class='form-check'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Pending' id='entry_status_upd1'>
				<label class='form-check-label' for='entry_status_upd1'>
					Pending
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Completed' id='entry_status_upd2'>
				<label class='form-check-label' for='entry_status_upd2'>
					Completed
				</label>
			</div>
			<div class='form-check ms-3'>
				<input class='form-check-input' type='radio' name='entry_status_upd' value='Rejected' id='entry_status_upd3' checked>
				<label class='form-check-label' for='entry_status_upd3'>
					Rejected
				</label>
			</div>
		</div>";
	}
	
			
	
					
} 
if(isset($_REQUEST['update'])){ //When form Submits for Update

//print_r($_REQUEST);exit;
		$entry_id=$_REQUEST['hidden_entry_id'];
		$cust_name=$_REQUEST['customer_name'];
		$mobile_name=$_REQUEST['mobile_name'];
		$contact_no=$_REQUEST['contact_no'];
		$cust_alt_contact=$_REQUEST['alt_contact_no'];
		$email=$_REQUEST['email'];
		$send_sms_to_alt=$_REQUEST['send_sms_alt_cont'];
		if($send_sms_to_alt=="sendalt"){
		    $sms_send_cont=$cust_alt_contact;
		}else{
		    $sms_send_cont=$contact_no;
		}
		$imei_serial_num=$_REQUEST['imei_sn'];
		$mobile_defect=$_REQUEST['mobile_defect'][0];
		$mobile_defect2=$_REQUEST['mobile_defect'][1];
		$mobile_defect3=$_REQUEST['mobile_defect'][2];
		$mobile_defect4=$_REQUEST['mobile_defect'][3];
		$exp_delivery=$_REQUEST['exp_delivery'];
		$est_amount=$_REQUEST['est_amount'];
		$gst_transaction=$_REQUEST['gst_bill'];
		$cust_gst_no=$_REQUEST['customer_gst_no'];
		$adv_amount=$_REQUEST['adv_amount']; 
		$spare_cost=$_REQUEST['spare_cost'];
		$remarks=$_REQUEST['remarks'];		
		$entry_status_upd=$_REQUEST['entry_status_upd'];
		$adv_payment_mode =json_encode($_REQUEST['adv_payment_mode']);

		$defect_description=$_REQUEST['defect_description'];
		$customer_type=$_REQUEST['customer_type'];
		// $screenlock_type=$_REQUEST['screenlock_type'];

		// if($screenlock_type==0){
			$screen_lock1 = $_REQUEST['patternlock_data'];
		// }else{
			$screen_lock2 = $_REQUEST['pin-lock'];
		// }

		$defect_type=$_REQUEST['defect_type'];
		$pickup_address=json_encode($_REQUEST['pickup_address']);
		
		
		if(isset($_REQUEST['rejected_reason'])){
		  $rejected_reason=$_REQUEST['rejected_reason'];
		}else{
		  $rejected_reason='';
		}
		
		if($entry_status_upd=='Rejected'){
			$reject_status='1';
		}else{
			$reject_status='0';
		}
		$repair_by=$_SESSION['session_username'];
		//echo $repair_by;
		//exit;
		$cur_time = date('Y-m-d H:i:s');
		//Inserting Data
		$sql_upd="UPDATE `adm_cust_mob_add` SET
									`customer_name`='".$cust_name."', 
									`mobile_name`='".$mobile_name."',
									`cust_contact`='".$contact_no."',
									`cust_alt_contact`='".$cust_alt_contact."',
									`cust_email`='".$email."',
									`send_sms_to_alt`='".$send_sms_to_alt."',
									`imei_serial_num`='".$imei_serial_num."',
									`mobile_defect`='".$mobile_defect."',
									`mobile_defect_2`='".$mobile_defect2."',
									`mobile_defect_3`='".$mobile_defect3."',
									`mobile_defect_4`='".$mobile_defect4."',
									`defect_type`= ".$defect_type.",
									`screen_lock`= ".$screen_lock1.",
									`screen_lock2`= ".$screen_lock2.",
									`pickup_address`= '".$pickup_address."',
									`customer_fulfillment_type`= ".$customer_type.",
									`defect_description`= '".$defect_description."', 
									`exp_delivery`='".$exp_delivery."',
									`est_amount`='".$est_amount."',
									`adv_amount`='".$adv_amount."',
									`spare_cost`='".$spare_cost."',
									`status`='".$entry_status_upd."',
									`rejected`='".$reject_status."',
									`rejected_reason`='".$rejected_reason."',
									`remarks`='".$remarks."',
									`repair_by`='".$repair_by."',
									`repair_date`='".$cur_time ."',
									`adv_payment_mode`='".$adv_payment_mode."',
									`multi_payment`='".json_encode($_REQUEST['multi_pay'])."',
									`gst`='".$gst_transaction."',
									`customer_gst_no`='".$cust_gst_no."'
									WHERE entry_id=".$entry_id;

		//echo $sql_upd; exit;
		$query_upd=mysql_query($sql_upd);
		// echo mysql_error();
		// die;
		if($query_upd){ 
		
		
		$rem_amt=$est_amount-$adv_amount;
		
		$mob_def_sql="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect;
		$mob_def_query=mysql_query($mob_def_sql);
		$result_def_query=mysql_fetch_array($mob_def_query);
		$mobile_defect_name=$result_def_query['defect_name'];

		$sql_store_cont="SELECT * FROM `stores` WHERE `store_id`=".$session_store_id;
		$query_store_cont=mysql_query($sql_store_cont);
		$result_store_cont=mysql_fetch_array($query_store_cont);
		$get_store_contact=$result_store_cont['store_contact'];
		
	
		if($entry_status_upd=="Completed"){
		    //$message='Hello '.$cust_name.', Your mobile '.$mobile_name.', is ready for delivery. Please visit our store and collect your mobile. Remaining amount to pay is '.$rem_amt.'. Thank you, Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES';
		    $message='Dear '.$cust_name.',Your Device '.$mobile_name.',is ready for delivery. Please visit our store. Bal amt to pay is '.$rem_amt.'. Thank you, '.$session_store_name.'. Ph: '.$get_store_contact.'. - DigitalStorz';
		}elseif($entry_status_upd=="Rejected"){
		    //$message='Hello '.$cust_name.', Your mobile '.$mobile_name.', with defect: '.$mobile_defect_name.' is not resolvable, Please Visit out store and collect your mobile. Thank you, Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 040-65149944.';
		    //$message='Dear '.$cust_name.', Your mobile '.$mobile_name.', with defect: '.$mobile_defect_name.' is not resolvable, Please Visit out store and collect your mobile. Thank you, Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		    $message='Dear '.$cust_name.', Your Device '.$mobile_name.', was not resolvable, Please Visit our store and collect your Device. Thank you, '.$session_store_name.'. Ph: '.$get_store_contact.'. - DigitalStorz';
		    
		}elseif($entry_status_upd=="Pending" && $_REQUEST['notify_user']=='notify_user_yes'){
		    //$message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name1.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		    $message='Dear '.$cust_name.', We have received your Device '.$mobile_name.', with defect: '.$mobile_defect_name.', on '.$cur_time.'. Estimated charges Rs.'.$est_amount.', Adv Recd Rs.'.$adv_amount.'. Thank you for Visiting '.$session_store_name.'. Ph:'.$get_store_contact.'. - DigitalStorz';
		}
		
		$sql_sentmessages_count="SELECT `message_sent_count` FROM `stores` WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_sentmessages_count=mysql_query($sql_sentmessages_count);
		$result_sentmessages_count=mysql_fetch_array($query_sentmessages_count);

	if($session_user_subscription_plan == 'trail' || $session_user_subscription_plan == 'trail-mobialive'){
		if($result_sentmessages_count['message_sent_count'] < 200){
		
		//echo $message;exit;
		//updating message count in stores.
		$message_length=strlen($message);
        $no_of_messages=ceil($message_length/160);
        //echo $no_of_messages;
        $sql_msg_cnt_upd="UPDATE `stores` SET message_sent_count = message_sent_count + ".$no_of_messages." WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_msg_cnt_upd=mysql_query($sql_msg_cnt_upd);
		//SMS SENDING CODE for Completed and Rejected
		
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$sms_send_cont,
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
        //echo $response;
        //exit;
            header('Location: ./view-cust-mobile-entry-ui.php?result_key=pend&dmsg=jus');
		}else{
		    header('Location: ./view-cust-mobile-entry-ui.php?result_key=pend&dmsg=jus');
		}
	}else{
	    //echo $message;exit;
		//updating message count in stores.
		$message_length=strlen($message);
        $no_of_messages=ceil($message_length/160);
        //echo $no_of_messages;
        $sql_msg_cnt_upd="UPDATE `stores` SET message_sent_count = message_sent_count + ".$no_of_messages." WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_msg_cnt_upd=mysql_query($sql_msg_cnt_upd);
		//SMS SENDING CODE for Completed and Rejected
		
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$sms_send_cont,
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
        //echo $response;
        //exit;
        //echo "Non Trail plan"; exit;
        header('Location: ./view-cust-mobile-entry-ui.php?result_key=pend&dmsg=jus');
	}

		}else{
			header('Location: ./add-cust-mobile-ui.php?rslt=failed');
			//$mess="Failed to Add..";
		}
}
?>

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

                       

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('header.php') ?>
            <?php include('sidebar.php') ?>
            <!-- Left Sidebar End -->

			<style>

						.select2-container--default .select2-selection--multiple {
            border: 1px solid #000 !important; 
            border-radius: 4px; 
        }

        .select2-container--default .select2-selection--multiple:focus {
            border-color: #000 !important;
        }

		/* .main-content{
			width:100%;
		} */
			</style>


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
                                    <h4 class="mb-sm-0">Job Sheet</h4>

                                </div>
                            </div>
							<div style="color:green" class="page_title_div"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
            <div class="row">
            <div class="card">
            <div class="card-body">
            <div class="right_container">
		    <?php
		    $job_variable_display='';
		    if($session_user_subscription_plan == 'annual'){
		        $sql_store_job_count="SELECT COUNT(entry_id) AS `store_job_count` FROM `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `delete_status`='0'";
		        $query_store_job_count=mysql_query($sql_store_job_count);
		        $result_store_job_count=mysql_fetch_array($query_store_job_count); 
		        
		        $job_variable_display="<span style='color:green'> ".$result_store_job_count['store_job_count']." Jobs Consumed out of 2700.</span>";
		    }
		    
		    //;
		    ?>
			<div class="content_holder">
				
				<div class="content_holder_body">
				<?php
				      if($transaction=='legal'){
				    ?>
				<form name="category_add" method="post" action="./add-cust-mobile-ui.php" onsubmit="return validate()">
					<div class="row">
						<div class="col-md-6">
					<div class="row mb-2 d-flex flex-column">	
						<div class="d-flex col-md-6 mb-2">	
							<div class="form-check">
							<input class="form-check-input" type="radio" name="customer_type" value='0' id="customer_type1" onclick="toggleAddress()" <?= $customer_fulfillment_type==0 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer_type1">
								Walk In
							</label>
							</div>
							<div class="form-check ms-3">
							<input class="form-check-input" type="radio" value='1' name="customer_type" id="customer_type2" onclick="toggleAddress()" <?= $customer_fulfillment_type==1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="customer_type2">
								Pick Up
							</label>
							</div>
						</div>

						<?php
						
						if(isset($_REQUEST['entry_id'])){
							$state=$pickup_address[0];
							$city=$pickup_address[1];
							$street=$pickup_address[2];
							$pincode=$pickup_address[3];
						}else{
							$state='';
							$city='';
							$street='';
							$pincode='';
						}

						?>

						<div class="col-md-12" id="pickup_address_div" style="display:<?= $customer_fulfillment_type==1 ? '' : 'none' ?>;">
							<div class="row">
								<div class="col-md-3">
									<label for="street_name">Street & Door No</label>
									<input type="text" class="form-control" name="pickup_address[]" id="street_name" value="<?=$state?>">
								</div>
								<div class="col-md-3">
									<label for="state_name">State</label>
									<input type="text" class="form-control" name="pickup_address[]" id="state_name"  value="<?=$city?>">
								</div>
								<div class="col-md-3">
									<label for="city_name">City</label>
									<input type="text" class="form-control" name="pickup_address[]" id="city_name" value="<?=$street?>">
								</div>
								<div class="col-md-3">
									<label for="pincode">Pincode</label>
									<input type="text" class="form-control" name="pickup_address[]" id="pincode" value="<?=$pincode?>">
								</div>
							</div>
							<!-- <label for="pickup_address">Address</label>
							<textarea name="pickup_address" id="pickup_address" class="form-control"></textarea> -->
						</div>
					</div>
					<div class="row align-items-center">
						<div class="col-md-3">
							<label for="contact_no" maxlength="10" class="form-label">Contact No: <b style="color:red">&#10035;</b></label>
							<input type="number" class="form-control" name="contact_no" id="contact_no" value="<?php echo $cust_contact ?>" onchange="getData(this.value, 'customer_name')"   ondrop="return false;" autocomplete="off" required required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true">
							
						</div>
						<div class="col-md-3">
							<label for="customer_name" class="form-label">Customer Name <b style="color:red">&#10035;</b></label>
							<input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name ?>">
						</div>
						<div class="col-md-3" >
							<div>
								<input type="checkbox" class="form-check-input" name="alt_contact_no_check" id="alt_contact_no_check" onclick="$(this).is(':checked') ? $('#alt_contact_no').parent('div').show() : $('#alt_contact_no').parent('div').hide()" <?= $cust_alt_contact!='' ? 'checked' : '' ?>>
								<label for="alt_contact_no_check" class="form-check-label">Alternate Contact No:</label>
							</div>
							<div style="display:<?= $cust_alt_contact!='' ? 'block' : 'none' ?>">
								<!-- <label for="alt_contact_no" class="form-label">Alternate Contact No: </label> -->
								<input type="text" class="form-control" name="alt_contact_no" id="alt_contact_no" value="<?php echo $cust_alt_contact ?>"   onpaste="return false;" ondrop="return false;" autocomplete="off" pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true">
							</div>
						</div>
						<div class="col-md-3" >
							<div>
								<input type="checkbox" class="form-check-input" name="email_check" id="email_check" onclick="$(this).is(':checked') ? $('#email').parent('div').show() : $('#email').parent('div').hide()" <?= $email!='' ? 'checked' : '' ?>>
								<label for="email_check" class="form-check-label">Email: </label>
							</div>
							<div style="display:<?= $email!='' ? 'block' : 'none' ?>">
								<!-- <label for="email" class="form-label">Email: </label> -->
								<input type="text" class="form-control" name="email" id="email" value="<?php echo $email ?>" autocomplete="off" >
							</div>
						</div>
						<!-- <div class="col-md-3">							

						</div> -->
						<!-- <div class="mt-3 form-group col-md-3">
						<?php
						    if($send_sms_to_alt=="sendalt"){
						?>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="send_sms_alt_cont" value="sendalt" checked id="send_sms_alt_cont">
							<label class="form-check-label" for="send_sms_alt_cont">
								Send SMS
							</label>
						</div>
						<?php
						    }else{
						?>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="sendalt" name="send_sms_alt_cont" id="send_sms_alt_cont">
							<label class="form-check-label" for="send_sms_alt_cont">
								Send SMS
							</label>
						</div>						    
						<?php
						    }
						?>
						</div> -->
					</div>
					<div class="mt-1"><i class="fas fa-info-circle"></i> SMS will be sent to Primary Contact Number</div>
						<div class="row mt-4">
						<div class="col-md-4">
						<input type="hidden" name="hidden_entry_id" value="<?php echo $entry_id?>">
							<label for="alt_contact_no" class="form-label">Device Brand & Model No: </label>
							<input type="text" name="mobile_name" class="form-control" value="<?php echo $mobile_name ?>" >
						</div>
						<div class="col-md-4">
							<label for="alt_contact_no" class="form-label">Estimated Amount: </label>
							<input  type="number" name="est_amount" class="form-control" value="<?php echo $est_amount ?>" onkeypress="return onlyNumberKey(event)" onkeydown="return event.keyCode !== 69" onpaste="return false;" ondrop="return false;" autocomplete="off">
						</div>
						<div class="col-md-4">
							<label for="alt_contact_no" class="form-label">IMEI/SN: </label>
							<input type="text" name="imei_sn" class="form-control" maxlength="15" value="<?php echo $imei_serial_num; ?>" >
						</div>
						</div>
						
							<?php 
							
							$selectDefectType = "SELECT defect_type from `adm_cust_mob_add` WHERE store_id = ".$_SESSION['session_store_id']."  order by entry_id DESC LIMIT 1";
							$selectDefectTypeQry = mysql_query($selectDefectType);
							$selectDefectTypeRes = mysql_fetch_array($selectDefectTypeQry);
							?>

						<div class="row mt-4">
						<div class="col-md-12 d-flex mb-4">
							<div class="form-check">
							<input class="form-check-input" type="radio" name="defect_type" value='0' id="defect_type1" onclick="toggleDefect()" <?= $selectDefectTypeRes['defect_type']==0 ? 'checked' : '' ?>>
							<label class="form-check-label" for="defect_type1">
								Defect Dropdowns
							</label>
							</div>
							<div class="form-check ms-3">
							<input class="form-check-input" type="radio" value='1' name="defect_type" id="defect_type2" onclick="toggleDefect()" <?= $selectDefectTypeRes['defect_type']==1 ? 'checked' : '' ?>>
							<label class="form-check-label" for="defect_type2">
								Manual Entry
							</label>
							</div>
						</div>
						<div class="col-md-6" id="defectSelect_div" style="display:<?= $selectDefectTypeRes['defect_type']==0 ? 'block' : 'none' ?>">
							<label class="form-label">Defect Select</label>
							<select class="select2 form-control select2-multiple" multiple="multiple" name="mobile_defect[]" id="defectSelect" multiple data-placeholder="Choose ...">
						<?php
					$sql_get_pre_def="SELECT `use_preloaded_defects` FROM `stores` WHERE `store_id`=".$_SESSION['session_store_id'];
				    $query_get_pre_def=mysql_query($sql_get_pre_def);
		            $result_get_pre_def=mysql_fetch_array($query_get_pre_def);
		            
		            $use_custom_defects_value=$result_get_pre_def['use_preloaded_defects'];
					?>
					<?php
					if ($use_custom_defects_value=='yes'){
					  $defect_sql="SELECT * FROM `adm_mobile_defects` WHERE `default_defect` LIKE 'yes' OR `store_id` LIKE ".$_SESSION['session_store_id']."  ORDER BY `defect_name` ASC";  
					}elseif($use_custom_defects_value=='no'){
					  $defect_sql="SELECT * FROM `adm_mobile_defects` WHERE `store_id`=".$_SESSION['session_store_id']."  ORDER BY `defect_name` ASC";
					}
						$query_defect_sql=mysql_query($defect_sql);
						while($result_query_defect_sql=mysql_fetch_array($query_defect_sql)){ 									
							if ($mobile_defect ==$result_query_defect_sql['defect_id'] || $mobile_defect2 ==$result_query_defect_sql['defect_id'] || $mobile_defect3 ==$result_query_defect_sql['defect_id'] || $mobile_defect4 ==$result_query_defect_sql['defect_id']){
								echo "<option selected ='selected' value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}else{
								echo "<option value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}
						}						

					?>							
									<option value="AK">Alaska</option>
									<option value="HI">Hawaii</option>
							</select>
						</div>
						<div class="col-md-6" style="display:<?= $selectDefectTypeRes['defect_type']==1 ? 'block' : 'none' ?>" id="defect_description_div">
							<label for="defect_description">Enter the Defect Description</label>
							<textarea rows="4" name="defect_description" id="defect_description" class="form-control" ><?=$defect_description?></textarea>
						</div>
						<div class="col-md-6">
							<label class="form-label">Remarks:</label>
							<textarea rows="4" type="text" name="remarks" class="form-control" value="<?php echo $remarks ?>" ></textarea>
						</div>	
						</div>	
						<div class="row mt-4">
						<div class="row mt-4">
						<?php
					$adv_pay_modes = array("cash"=>"Cash", "card"=>"Credit/Debit Card", "googlepay"=>"Google Pay", "phonepe"=>"Phone Pe", "paytm"=>"Paytm", "otherwallet"=>"Other Wallet",  "none"=>"None");

					?>
						
					</div>
					</div>
					</div>
					

						<div class="col-md-6 mb-4">
							<div class="row">
							<div class="col-md-4">
							<label class="form-label">Advance Amount:</label>
							<input type="text" name="adv_amount" class="form-control" value="<?php echo $adv_amount ?>" onkeypress="return onlyNumberKey(event)" onpaste="return false;" ondrop="return false;" autocomplete="off">
						</div>	
						<div class="col-md-4">
							<label class="form-label">Advance Payment Mode:</label>
							<select name='adv_payment_mode[]' id="adv_payment_mode" class="form-select select2 select2-multiple" onchange="paymentHandle()" multiple="multiple"  multiple data-placeholder="Choose Payment Mode...">
							<?php
							$countnew=0;
							
							foreach($adv_pay_modes as $pmt_opt_value => $pmt_mod_lable) 
							{
								
							    if(in_array($pmt_opt_value,json_decode(trim($advpay_mode,'"')) )){
                              	 echo '<option value="'.$pmt_opt_value.'" data-id="'.$countnew.'" selected>'.$pmt_mod_lable.'</option>';
							    }else{
							      echo '<option value="'.$pmt_opt_value.'" data-id="'.$countnew.'">'.$pmt_mod_lable.'</option>';  
							    }
								$countnew++;
                            }
							?>
							</select>
						</div>	
						<div class="col-md-4">
							<label class="form-label">Estimated Delivery:</label>
							<input  type="date" id="date_picker" name="exp_delivery" class="form-control" value="<?php echo $exp_delivery ?>" >
						</div>
						<?php 
						
						if(isset($_REQUEST['entry_id']) && count(json_decode(trim($advpay_mode,'"')))!=0 ){

							$multiPayData = json_decode(trim($multi_payment,'"'));
							$showMultiData = '';

						}else{
							$multiPayData = array('','','','','','');
							$showMultiData = 'none';
						}

						?>
						<div class="col-md-12 mt-2">
							<div class="row" id="payment_multi" style="display:<?=$showMultiData?>">
								<div class="col-md-4 payment_multi0" style="display:<?=$multiPayData[0]=='' ? 'none' : ''?>">
									<label class="form-label" for="cash_pay">Cash</label>
									<input type="text" class="form-control" name="multi_pay[]" id="cash_pay" value="<?=$multiPayData[0]?>">
								</div>
								<div class="col-md-4 payment_multi1" style="display:<?=$multiPayData[1]=='' ? 'none' : ''?>">
									<label class="form-label" for="cash_pay">Credit/Debit Card</label>
									<input type="text" class="form-control" name="multi_pay[]" id="card_pay" value="<?=$multiPayData[1]?>">
								</div>
								<div class="col-md-4 payment_multi2" style="display:<?=$multiPayData[2]=='' ? 'none' : ''?>">
									<label class="form-label" for="cash_pay">Google Pay</label>
									<input type="text" class="form-control" name="multi_pay[]" id="g_pay" value="<?=$multiPayData[2]?>">
								</div>
								<div class="col-md-4 payment_multi3" style="display:<?=$multiPayData[3]=='' ? 'none' : ''?>">
									<label class="form-label" for="cash_pay">Phone Pe</label>
									<input type="text" class="form-control" name="multi_pay[]" id="phonepe_pay" value="<?=$multiPayData[3]?>">
								</div>
								<div class="col-md-4 payment_multi4" style="display:<?=$multiPayData[4]=='' ? 'none' : ''?>">
									<label class="form-label" for="cash_pay">Paytm</label>
									<input type="text" class="form-control" name="multi_pay[]" id="paytm_pay" value="<?=$multiPayData[4]?>">
								</div>
								<div class="col-md-4 payment_multi5" style="display:<?=$multiPayData[5]=='' ? 'none' : ''?>">
									<label class="form-label" for="cash_pay">Other Wallet</label>
									<input type="text" class="form-control" name="multi_pay[]" id="other_pay" value="<?=$multiPayData[5]?>">
								</div>
							</div>
						</div>
						<?php
						if(isset($_REQUEST['entry_id'])){
						?>
						<div class="col-md-6">
							<div class="txt_lable">Spare Cost:</div>
							<input type="text" class="form-control" name="spare_cost" value="<?php echo $spare_cost_1; ?>" onkeypress="return onlyNumberKey(event)" >
						
						</div>
						<div class="col-md-6">			
						<div class="txt_lable" id="reject_reason_lable"></div>				
							<div id="reject_reason"></div>							
						</div>
						<?php
						}
						?>
						<div><?php echo $status_radio; ?></div>					
					
					</div>

							<!-- <div>
								<h5 class="text-center">Add Screen Lock</h5>
								<h6 class="text-center">Screen Lock Type</h6>
							</div>
							<div style="display: flex;justify-content: center;">
								<div class="form-check">
								<input class="form-check-input" type="radio" name="screenlock_type" value='0' id="screenlock_type1" onclick="toggleScreenlock()" checked>
								<label class="form-check-label" for="screenlock_type1">
									Pattern
								</label>
								</div>
								<div class="form-check ms-3">
								<input class="form-check-input" type="radio" value='1' name="screenlock_type" id="screenlock_type2" onclick="toggleScreenlock()" >
								<label class="form-check-label" for="screenlock_type2">
									Pin
								</label>
								</div>
							</div>
							<div class="row flex-column align-items-center" style="height:390px;">
							<div class="col-md-6 pattern_lock" id="pattern_lock">
								<svg class="patternlock" id="lock" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
									<g class="lock-actives"></g>
									<g class="lock-lines"></g>
									<g class="lock-dots">
										<circle cx="20" cy="20" r="1"/>
										<circle cx="50" cy="20" r="1"/>
										<circle cx="80" cy="20" r="1"/>

										<circle cx="20" cy="50" r="1"/>
										<circle cx="50" cy="50" r="1"/>
										<circle cx="80" cy="50" r="1"/>

										<circle cx="20" cy="80" r="1"/>
										<circle cx="50" cy="80" r="1"/>
										<circle cx="80" cy="80" r="1"/>
									</g>
								<svg>
							</div>
							<div class="col-md-6 text-center mt-4 mb-4" id="pin_lock" style="display:none">
								<input type="text" name="pin-lock" id="pin-lock" class="form-control mt-4" name="screen_lock">
								<input type="hidden" name="patternlock_data" id="patternlock_data">
							</div>							
						</div> -->
						<?php if(!isset($_REQUEST['entry_id'])){ ?>
						<div class="col-md-12">
							<div class="accordion" id="accordionExample">                                            
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingThree">
											<button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
												 Device Damages
											</button>
										</h2>
										<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<div class="text-muted">
												<label for="tags-input">Enter the Damages</label>
												<input type="hidden" name="tags-input-values" id="tags-input-values">
													<div class="tags-input-wrapper">														
														<input type="text" name="tags-input" id="tags-input" placeholder="Add a tag...">
													</div>
													<div class="col-md-12 mt-2">
														<div class="d-flex flex-column">
															<label for="upload_damages">Upload Device Damage Images</label>
															<input type="file" name="upload_damages" id="upload_damages" multiple accept=".jpeg, .jpg, .png">
														</div>
														<div>
															<div id="error-message" class="text-danger mt-2"></div>
															<div id="preview-images" class="mt-3"></div>
															<input type="hidden" name="damage_images_save" id="damage_images_save">
														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
                                </div>
							</div>
							<div class="col-md-12"><label for="pin-lock">Password:</label></div>
							<div class="col-md-12 mb-2 d-flex mt-2"> 
								<input type="hidden" name="patternlock_data" id="patternlock_data">
								<input type="hidden" name="screenlock_type" value="0" id="screenlock_type"> 
								<input type="hidden" name="screen_lock" id="screen_lock"> 								
								<input type="text" name="pin-lock" id="pin-lock" class="form-control" style="width:80%">
								<button type="button" id="patternOpen" class="btn btn-dark ms-3" name="patternOpen" onclick="openPatternModel()">Pattern Lock</button>
							</div>
							<?php } ?>	
							</div>
							</div>
									
						<div class="mt-4">
							<input class="btn btn-info" type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value;?>" />
						
						
						<?php if(isset($_REQUEST['entry_id'])){

							?>
							<a class="btn btn-outline-dark btn-sm" href="print-job.php?job_id=<?=$_REQUEST['entry_id']?>">Print</a>
							<a class="btn btn-secondary" href="mobile-delivery-invoice-ui.php?delivery-id=<?=$_REQUEST['entry_id']?>" >Instant Delivery</a>
							<a class="btn btn-outline-danger btn-sm" href="mobile-delivery-instant-reject-ui.php?delivery-id=<?=$_REQUEST['entry_id']?>&action=inst_rej_del">Instant Reject</a>

							<?php
						} ?>
						</div>	

						<div id="pickupAddressModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="pickupAddressModelLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="pickupAddressModelLabel">Pick Up Address</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
									<form id="address_create_model">
									<div class="form-group">
										<label for="pickup_address">Address</label>
										<input type="text" class="form-control" id="pickup_address" name="pickup_address[]" required>
									</div>
									<div class="form-group">
										<label for="address_aprt">Apartment, Suite , etc.</label>
										<input type="text" class="form-control" id="address_aprt" name="pickup_address[]" required>
									</div>
									<div class="form-group">
										<label for="address_city">City</label>
										<input type="text" class="form-control" id="address_city" name="pickup_address[]" required>
									</div>
									<div class="form-group">
										<label for="address_state">State / Province</label>
										<input type="text" class="form-control" id="address_state" name="pickup_address[]" required>
									</div>
									<div class="form-group">
										<label for="address_country">Country</label>
										<input type="text" class="form-control" id="address_country" name="pickup_address[]" required>
									</div>
									<div class="form-group">
										<label for="address_zip">Zip Code</label>
										<input type="text" class="form-control" id="address_zip" name="pickup_address[]" required>
									</div>
									<div class="form-group">
									<label for="Mobile">Mobile Number</label>
									<input type="tel" class="form-control" id="pickup_address_contact" required>
									</div>
									<button type="button" class="btn btn-success mt-2" onclick="addPickupAdress()">Add Address</button>
								</form>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->

				</form>
                <?php
				      }elseif($transaction='illegal'){
				          echo "No Such Transaction Found.";
				      }
                ?>
				</div>
			</div>
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

    var selectedPattern = p.getPattern();
    $('#patternlock_data').val(selectedPattern);

    console.log($('#tags-input').val());

if (document.category_add.contact_no.value == "")
    {
        document.category_add.contact_no.focus();
        alert("Enter Customer Mobile Number");
return false;
    }
    
if (document.category_add.contact_no.value != "")
    {
        var y = document.category_add.contact_no.value;
        if(!y.match(/^\d+/))
        {
            alert("This Field allows only Numbers.");
            document.category_add.contact_no.focus();
            return false;
        }
        
        if ( ! (/^\d{10}$/.test(y)) ) {
            alert("Invalid Mobile Number.. Must be 10 digits");
            document.category_add.contact_no.focus();
            return false;
        }
    }
if (document.category_add.alt_contact_no.value != "")
    {
        var y = document.category_add.alt_contact_no.value;
        if(!y.match(/^\d+/))
        {
            alert("This Field allows only Numbers.");
            document.category_add.alt_contact_no.focus();
            return false;
        }
        
        if ( ! (/^\d{10}$/.test(y)) ) {
            alert("Invalid Mobile Number.. Must be 10 digits");
            document.category_add.alt_contact_no.focus();
            return false;
        }
    }
    
/*var val = document.category_add.contact_no.value;
if (/^\d{10}$/.test(val)) {
return true
} else {
alert("Invalid Mobile Number.. Must be 10 digits")
document.category_add.contact_no.focus()
return false
}*/


if (document.category_add.mobile_name.value == "")
    {
        document.category_add.mobile_name.focus();
        alert("Enter Mobile Name");
return false;
    }

if (document.category_add.est_amount.value != "")
    {
        var y = document.category_add.est_amount.value;
        if(!y.match(/^\d+/))
        {
            alert("This Field allows only Numbers.");
            document.category_add.est_amount.focus();
            return false;
        }
    }        
if (document.category_add.mobile_defect.value == "")
    {
        document.category_add.mobile_defect.focus();
        alert("Enter Mobile Defect");
return false;
    }

if (document.category_add.adv_amount.value != "" && document.category_add.adv_payment_mode.value == "")
    {
        alert("Please Select Advance Payment Mode when Advance is entered.");
        document.category_add.adv_payment_mode.focus();
         return false;
    }

    

}

function numbersonly(e){
    //alert("hi");
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    if (unicode<48||unicode>57) //if not a number
    if (document.category_add.contact_no.value < 10)
    return false //disable key press
    }
}
function numbersonly2(e){
    //alert("hi");
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    if (unicode<48||unicode>57) //if not a number
    if (document.category_add.alt_contact_no.value < 10)
    return false //disable key press
    }
}
function numbersonly3(e){
    //alert("hi");
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    if (unicode<48||unicode>57) //if not a number
    if (document.category_add.est_amount.value < 10)
    return false //disable key press
    }
}
function numbersonly4(e){
    //alert("hi");
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    if (unicode<48||unicode>57) //if not a number
    if (document.category_add.imei_sn.value < 10)
    return false //disable key press
    }
}
function numbersonly5(e){
    //alert("hi");
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    if (unicode<48||unicode>57) //if not a number
    if (document.category_add.adv_amount.value < 10)
    return false //disable key press
    }
}
function numbersonly6(e){
    //alert("hi");
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
    if (unicode<48||unicode>57) //if not a number
    if (document.category_add.spare_cost.value < 10)
    return false //disable key press
    }
}

    function onlyNumberKey(evt) {

// Only ASCII character in that range allowed
var ASCIICode = (evt.which) ? evt.which : evt.keyCode
if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
return false;
return true;
}

function getData(empid, divid){
    //alert(divid);
         $.ajax({
             url: './retail_usernname_check_ajax.php?empid='+empid, //call storeemdata.php to store form data
             success: function(html) {
                 var ajaxDisplay = document.getElementById(divid);
                 //ajaxDisplay.innerHTML = html;
                 document.getElementById(divid).value= html;
                 
             }
         });
     }

    function generateRow() {
    var c=document.getElementById("reject_reason_lable");
    var d=document.getElementById("reject_reason");
    c.innerHTML='';
	d.innerHTML='';
    c.innerHTML+="Reject Reason:";
    d.innerHTML+="<input type='text' class='form-control' name='rejected_reason' value=''>";
    
    }


	$('input[name="entry_status_upd"]').click(function(){
		if($(this).attr('id')!='entry_status_upd3'){
			$('#reject_reason').html('');
			$('#reject_reason_lable').html('');
		}

	})
    
    function showServiceDetails(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","getSerDetails.php?q="+str,true);
            xmlhttp.send();
        }
    }

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

    $( function() {
        $( "#date_picker" ).datepicker({
            minDate: 0,
            dateFormat: 'yy-mm-dd'
        });
   });

   const addPickupAdress = () =>{
	$('#pickupAddressModel').modal('hide');
   }

   const toggleAddress = () =>{			

	if($('input[name="customer_type"]:checked').val()==1){
		$('#pickupAddressModel').modal('show');
	}

    // if($('input[name="customer_type"]:checked').val()==1){
    //     $('#pickup_address_div').show();
    // }else{
    //     $('#pickup_address_div').hide();
    // }
}

const toggleDefect = () =>{			
    if($('input[name="defect_type"]:checked').val()==1){
        $('#defectSelect_div').hide();
        $('#defect_description_div').show();
    }else{
        $('#defect_description_div').hide();
        $('#defectSelect_div').css('display','flex');
    }
}

var e = document.getElementById('lock')
var p = new PatternLock(e, {
onPattern: function(pattern) {
    this.pattern = pattern;
}
});

let imagesArray = [];

const fileInput = document.getElementById('upload_damages');
const errorMessage = document.getElementById('error-message');
const previewImages = document.getElementById('preview-images');

fileInput.addEventListener('change', function() {
// Clear previous error messages and image previews
errorMessage.textContent = '';
previewImages.innerHTML = '';

const files = fileInput.files;

// Check if files are selected
if (files.length === 0) {
errorMessage.textContent = 'Please select at least one image.';
return;
}

// Validate file types and store images in the array
for (let i = 0; i < files.length; i++) {
const file = files[i];

// Check for valid image formats
if (!['image/jpeg', 'image/png'].includes(file.type)) {
    errorMessage.textContent = 'Only JPEG and PNG formats are allowed.';
    return;
}

// Add the image file to the array
imagesArray.push(file);

// Preview the selected images
const reader = new FileReader();
reader.onload = function(e) {
    const imgElement = document.createElement('img');
    imgElement.src = e.target.result;
    imgElement.alt = file.name;
    imgElement.style.width = '100px';
    imgElement.style.marginRight = '10px';
    previewImages.appendChild(imgElement);
};
reader.readAsDataURL(file);
}

// Send images to the backend via AJAX
sendImagesToBackend(imagesArray);
});

// Function to send images to the backend
function sendImagesToBackend(images) {
const formData = new FormData();
images.forEach((image, index) => {
formData.append('images[]', image, image.name);
});

$.ajax({
url: 'uploads.php', // Change this to your PHP file path
type: 'POST',
data: formData,
processData: false,
contentType: false,
success: function(response) {
    $('#damage_images_save').val(response);
},
error: function(jqXHR, textStatus, errorThrown) {
    console.error('Error uploading images:', textStatus, errorThrown);
}
});
}

const paymentHandle = () =>{

	let dataOptions = [];


$('#adv_payment_mode').find(':selected').each(function() {
	let dataId = $(this).attr('data-id');
	dataOptions.push(dataId); 
});	
	if(dataOptions.length>1){
		$('#payment_multi').show();
		$('#payment_multi div').hide();
		dataOptions.forEach(function(value,index){		
			<!-- console.log($('#payment_multi').find('#payment_multi'+value)); -->
			$('#payment_multi').find('.payment_multi'+value).show();
		})

	}else{
		$('#payment_multi').hide();
	}
}

const openPatternModel = () => {
	$('#patternModel').modal('show')
}

</script>

    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>