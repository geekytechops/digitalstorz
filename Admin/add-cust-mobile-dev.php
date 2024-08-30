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


if(isset($_REQUEST['submit'])){ //When form Submits

		$cust_name_temp=$_REQUEST['customer_name'];
		if($cust_name_temp==''){
			$cust_name='Customer';
		}else{
			$cust_name_temp1=$cust_name_temp;
			$cust_name=ucwords($cust_name_temp1);
		}
		$adv_amount_temp=$_REQUEST['adv_amount'];
		$adv_payment_mode=$_REQUEST['adv_payment_mode'];
		if($adv_amount_temp==''){
			$adv_amount='';
		}else{
			$adv_amount=$adv_amount_temp;
		}
		$mobile_name_temp=$_REQUEST['mobile_name'];
		$mobile_name=ucwords($mobile_name_temp);

		$mobile_defect=json_encode($_REQUEST['mobile_defect']);

		// $mobile_defect2=$_REQUEST['mobile_defect_2'];
		// $mobile_defect3=$_REQUEST['mobile_defect_3'];
		// $mobile_defect4=$_REQUEST['mobile_defect_4'];

		//echo $mobile_defect;exit;
		$contact_no=$_REQUEST['contact_no'];
		$alt_contact_no=$_REQUEST['alt_contact_no'];
		$send_sms_alt_cont=$_REQUEST['send_sms_alt_cont'];
		if($send_sms_alt_cont=="sendalt"){
		    $sms_send_cont=$alt_contact_no;
		}else{
		    $sms_send_cont=$contact_no;
		}

		$imei_sn=$_REQUEST['imei_sn'];
		$exp_delivery=$_REQUEST['exp_delivery'];
		$gst_transaction=$_REQUEST['gst_bill'];
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
		$sql_ins="INSERT INTO `adm_cust_mob_add`(`customer_name`, `mobile_name`,`cust_contact`,`cust_alt_contact`,`send_sms_to_alt`,`imei_serial_num`,`mobile_defect`,`mobile_defect_2`,`mobile_defect_3`,`mobile_defect_4`,`exp_delivery`,`est_amount`,`adv_amount`,`remarks`,`added_date`,`status`,`rejected`,`delete_status`,`added_by`,`store_id`,`adv_payment_mode`,`gst`,`customer_gst_no`) VALUES 
		('".$cust_name."','".$mobile_name."','".$contact_no."','".$alt_contact_no."','".$send_sms_alt_cont."','".$imei_sn."','".$mobile_defect."','','','','".$exp_delivery."','".$est_amount."','".$adv_amount."','".$remarks."','".$cur_time ."','Pending', '0','0','".$added_by."','".$store_id."','".$adv_payment_mode."','".$gst_transaction."','".$cust_gst_no."')";
		//echo $sql_ins; exit;
		
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
		if($query_ins){
		    /*if($mobile_defect_name1 !='' && $mobile_defect_name2 !=''){
		        //$message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name1.', '.$mobile_defect_name2.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		    }else{
		        $message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name1.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 9703939944 - KOLORS MOBILE SERVICES.';
		    }*/
		
		   $message='Dear '.$cust_name.', We have received your Device '.$mobile_name.', with defect: '.$mobile_defect_name.', on '.$cur_time.'. Estimated charges Rs.'.$est_amount_1.', Adv Recd Rs.'.$adv_amount.'. Thank you for Visiting '.$session_store_name.'. Ph:'.$get_store_contact.'. - DigitalStorz';
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
            header('Location: ./view-cust-mobile-entry.php?result_key=pend&dmsg=jas');
		}else{
		    //echo "sms expired";exit;
		    header('Location: ./view-cust-mobile-entry.php?result_key=pend&dmsg=jas');
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
        header('Location: ./view-cust-mobile-entry.php?result_key=pend&dmsg=jas');
	}
		}else{
			header('Location: ./add-cust-mobile-dev.php?rslt=failed');
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
	$send_sms_to_alt=$result_disp['send_sms_to_alt'];
	$mobile_defect=$result_disp['mobile_defect'];
	$mobile_defect2=$result_disp['mobile_defect_2'];
	$mobile_defect3=$result_disp['mobile_defect_3'];
	$mobile_defect4=$result_disp['mobile_defect_4'];
	$imei_serial_num=$result_disp['imei_serial_num'];
	$exp_delivery=$result_disp['exp_delivery'];
	$est_amount=$result_disp['est_amount'];
	$adv_amount=$result_disp['adv_amount'];
	$gst_transaction=$result_disp['gst'];
	$cust_gst_no=$result_disp['customer_gst_no'];
	$remarks=$result_disp['remarks'];
	$spare_cost_1=$result_disp['spare_cost'];
	$status=$result_disp['status'];
	$advpay_mode=$result_disp['adv_payment_mode'];
	
	//echo $advpay_mode;
	//exit;
	if($status=='Pending')	
	$status_radio="	<input type='radio' name='entry_status_upd' value='Pending' checked > <font style='font-size:14px'>Pending</font>
	                
			        <input type='radio' name='entry_status_upd' value='Completed'> <font style='font-size:14px'>Completed</font>
			        <input type='radio' name='entry_status_upd' value='Rejected' onclick=generateRow() > <font style='font-size:14px'>Rejected</font> <br>
			        <input type='checkbox' id='notify_user' name='notify_user' value='notify_user_yes'>
                    <label for='notify_user' style='font-size:12px'> Notify Changes to customer<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Only for Pending Updates)</label>";

	elseif($status=='Completed')
	$status_radio="	<input type='radio' name='entry_status_upd' value='Pending'> Pending
			        <input type='radio' name='entry_status_upd' value='Completed' checked> Completed 
			        <input type='radio' name='entry_status_upd' value='Rejected'> Rejected ";
	elseif($status=='Rejected')
	$status_radio="	<input type='radio' name='entry_status_upd' value='Pending'> Pending
			        <input type='radio' name='entry_status_upd' value='Completed'> Completed 
			        <input type='radio' name='entry_status_upd' value='Rejected' checked> Rejected ";
			
	
					
} 
if(isset($_REQUEST['update'])){ //When form Submits for Update

//print_r($_REQUEST);exit;
		$entry_id=$_REQUEST['hidden_entry_id'];
		$cust_name=$_REQUEST['customer_name'];
		$mobile_name=$_REQUEST['mobile_name'];
		$contact_no=$_REQUEST['contact_no'];
		$cust_alt_contact=$_REQUEST['alt_contact_no'];
		$send_sms_to_alt=$_REQUEST['send_sms_alt_cont'];
		if($send_sms_to_alt=="sendalt"){
		    $sms_send_cont=$cust_alt_contact;
		}else{
		    $sms_send_cont=$contact_no;
		}
		$imei_serial_num=$_REQUEST['imei_sn'];
		$mobile_defect=$_REQUEST['mobile_defect'];
		$mobile_defect2=$_REQUEST['mobile_defect_2'];
		$mobile_defect3=$_REQUEST['mobile_defect_3'];
		$mobile_defect4=$_REQUEST['mobile_defect_4'];
		$exp_delivery=$_REQUEST['exp_delivery'];
		$est_amount=$_REQUEST['est_amount'];
		$gst_transaction=$_REQUEST['gst_bill'];
		$cust_gst_no=$_REQUEST['customer_gst_no'];
		$adv_amount=$_REQUEST['adv_amount']; 
		$spare_cost=$_REQUEST['spare_cost'];
		$remarks=$_REQUEST['remarks'];
		$entry_status_upd=$_REQUEST['entry_status_upd'];
		$adv_payment_mode =$_REQUEST['adv_payment_mode'];
		
		
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
									`send_sms_to_alt`='".$send_sms_to_alt."',
									`imei_serial_num`='".$imei_serial_num."',
									`mobile_defect`='".$mobile_defect."',
									`mobile_defect_2`='".$mobile_defect2."',
									`mobile_defect_3`='".$mobile_defect3."',
									`mobile_defect_4`='".$mobile_defect4."',
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
									`gst`='".$gst_transaction."',
									`customer_gst_no`='".$cust_gst_no."'
									WHERE entry_id=".$entry_id;

		//echo $sql_upd; exit;
		$query_upd=mysql_query($sql_upd);
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
            header('Location: ./view-cust-mobile-entry.php?result_key=pend&dmsg=jus');
		}else{
		    header('Location: ./view-cust-mobile-entry.php?result_key=pend&dmsg=jus');
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
        header('Location: ./view-cust-mobile-entry.php?result_key=pend&dmsg=jus');
	}

		}else{
			header('Location: ./add-cust-mobile-dev.php?rslt=failed');
			//$mess="Failed to Add..";
		}
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">

	<link href="../css/style.css" rel="stylesheet" type="text/css"/>

		        <!-- Bootstrap Css -->
				<link href="../panel-assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../panel-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../panel-assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

		<link href="../panel-assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">

		<link href="../panel-assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />


	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	<!-- For Date Picker-->
	<link href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet" type="text/css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- For Date Picker-->
	<script type="text/javascript">
            // Form validation code for SIGN UP
        function validate()
            {
		
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
                }select2-multiple

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
			
	</script>
	
	<!--check customer name-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript">
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
        </script>
	<!--check customer name-->


<script>
function generateRow() {
var c=document.getElementById("reject_reason_lable");
var d=document.getElementById("reject_reason");

c.innerHTML+="Reject Reason:";
d.innerHTML+="<input type='text' name='rejected_reason' value=''>";

}

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
</script>

<!-- Script for preventing reload submit entry-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  	<script>
	  		$( function() {
	   			$( "#date_picker" ).datepicker({
	   				minDate: 0,
	   				dateFormat: 'yy-mm-dd'
	   			});
	  		});
	  	</script>

</head>
<body>
	<div class="header">
		
        <span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold; font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
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
			<div class="page_title_div"><h1>JOB SHEET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php // echo $job_variable_display;?></h1></div>
			<div class="page_title_div"><h1 ><span style="color:red"><?php echo $mess;?></span></h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#10039;&nbsp;&nbsp;Add Customer Information </div>
				
				<div class="content_holder_body">
				<?php
				      if($transaction=='legal'){
				    ?>
				<form name="category_add" method="post" action="./add-cust-mobile-dev.php" onsubmit="return validate()">
					<div class="d-flex">	
						<div class="form-check">
						<input class="form-check-input" type="radio" name="customer_type" id="customer_type1" checked>
						<label class="form-check-label" for="customer_type1">
							Walk In
						</label>
						</div>
						<div class="form-check ms-3">
						<input class="form-check-input" type="radio" name="customer_type" id="customer_type2">
						<label class="form-check-label" for="customer_type2">
							Pick Up
						</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<label for="contact_no" maxlength="10" class="form-label">Contact No: <b style="color:red">&#10035;</b></label>
							<input type="number" class="form-control" name="contact_no" id="contact_no" value="<?php echo $cust_contact ?>" onchange="getData(this.value, 'customer_name')"   ondrop="return false;" autocomplete="off" required required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true">
						</div>
						<div class="col-md-2">
							<label for="customer_name" class="form-label">Customer Name <b style="color:red">&#10035;</b></label>
							<input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name ?>">
						</div>
						<div class="col-md-2">
							<label for="alt_contact_no" class="form-label">Alternate Contact No: </label>
							<input type="text" class="form-control" name="alt_contact_no" id="alt_contact_no" value="<?php echo $cust_alt_contact ?>"   onpaste="return false;" ondrop="return false;" autocomplete="off" pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true">
						</div>
						<div class="mt-3 form-group col-md-2">
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
						</div>
						</div>
						<div class="row mt-4">
						<div class="col-md-2">
							<label for="alt_contact_no" class="form-label">Device Brand & Model No: </label>
							<input type="text" name="mobile_name" class="form-control" value="<?php echo $mobile_name ?>" >
						</div>
						<div class="col-md-2">
							<label for="alt_contact_no" class="form-label">Estimated Amount: </label>
							<input  type="number" name="est_amount" class="form-control" value="<?php echo $est_amount ?>" onkeypress="return onlyNumberKey(event)" onkeydown="return event.keyCode !== 69" onpaste="return false;" ondrop="return false;" autocomplete="off">
						</div>
						<div class="col-md-2">
							<label for="alt_contact_no" class="form-label">IMEI/SN: </label>
							<input type="text" name="imei_sn" class="form-control" maxlength="15" value="<?php echo $imei_serial_num; ?>" >
						</div>			
						<div class="col-md-2">
							<label class="form-label">Defect Select</label>
							<select class="select2 form-control select2-multiple" multiple="multiple" name="mobile_defect[]" multiple data-placeholder="Choose ...">
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
							if ($mobile_defect ==$result_query_defect_sql['defect_id']){
								echo "<option selected ='yes' value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}else{
								echo "<option value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}
						}						

					?>							
									<option value="AK">Alaska</option>
									<option value="HI">Hawaii</option>
							</select>
						</div>	
						</div>	
						<div class="row mt-4">
						<div class="col-md-2">
							<label class="form-label">Advance Amount:</label>
							<input type="text" name="adv_amount" class="form-control" value="<?php echo $adv_amount ?>" onkeypress="return onlyNumberKey(event)" onpaste="return false;" ondrop="return false;" autocomplete="off">
						</div>	
						<div class="col-md-2">
							<label class="form-label">Remarks:</label>
							<input  type="text" name="remarks" class="form-control" value="<?php echo $remarks ?>" >
						</div>	
						<div class="row mt-4">
						<?php
					$adv_pay_modes = array(""=>"--SELECT--", "cash"=>"Cash", "card"=>"Credit/Debit Card", "googlepay"=>"Google Pay", "phonepe"=>"Phone Pe", "paytm"=>"Paytm", "otherwallet"=>"Other Wallet", "none"=>"None");

					?>
						<div class="col-md-2">
							<label class="form-label">Advance Payment Mode:</label>
							<select name='adv_payment_mode' class="form-select">
							<?php
							foreach($adv_pay_modes as $pmt_opt_value => $pmt_mod_lable) 
							{
							    if($advpay_mode==$pmt_opt_value){
                               echo '<option value="'.$pmt_opt_value.'" selected>'.$pmt_mod_lable.'</option>';
							    }else{
							      echo '<option value="'.$pmt_opt_value.'">'.$pmt_mod_lable.'</option>';  
							    }

                            }
							?>
							</select>
						</div>	
						<div class="col-md-2">
							<label class="form-label">Estimated Delivery:</label>
							<input  type="text" id="date_picker" name="exp_delivery" class="form-control" value="<?php echo $exp_delivery ?>" >
						</div>			
						<div><?php echo $status_radio; ?></div>
					<div class="mt-4"><input class="btn btn-primary" type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value;?>" /></div>												
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
	<script src="../panel-assets/libs/select2/js/select2.min.js"></script>
	<script src="../panel-assets/js/app.js"></script>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>