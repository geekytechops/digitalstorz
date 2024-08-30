<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){

if($_SESSION['session_username']=='superadmin'){
    
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$mess='';
if($_REQUEST['mode'] == "approve"){
    $store_id_appr=$_REQUEST['store_id'];
    $sql_kyc_appr="UPDATE `stores` SET `kyc_status`='Completed' WHERE `store_id`=".$store_id_appr;
    $query_kyc_appr=mysql_query($sql_kyc_appr);
    if($query_kyc_appr){
        $sql_get_email="SELECT `staff_email`,`staff_name`,`store_name` from `cust_kolors_users_list` WHERE `store_id`=".$store_id_appr." AND `user_role`='admin' ";
        //echo $sql_get_email;
        $query_get_email=mysql_query($sql_get_email);
        $result_get_email=mysql_fetch_array($query_get_email);
        $customer_store_email=$result_get_email['staff_email'];
        $customer_store_staff=$result_get_email['staff_name'];
        $customer_store_name=$result_get_email['store_name'];
        
        //echo $customer_store_email; exit;
         $mess="Store KYC Approved Successfully..";
         // This is for sending otp to email
				require './PHPMailer/PHPMailerAutoload.php';
				
				$mail = new PHPMailer;
				
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'mail.digitalstorz.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'transactions@digitalstorz.com';                            // SMTP username
				$mail->Password = '!nfo@d!g!+@l';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			
				$mail->From = 'transactions@digitalstorz.com'; 
				$mail->FromName = 'Admin DigitalStorz.';
				$mail->addAddress($customer_store_email);  // Add a recipient
				$mail->addReplyTo('');
				$mail->addCC('');
				$mail->addBCC('');
			
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->addAttachment('');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML
				
				$mail->Subject = 'KYC Approved';
				$mail->Body    = 'Dear '.$customer_store_staff.', <br><br> KYC is Approved for your store ID - '.$store_id_appr.' - '.$customer_store_name.', 
								<br> <br>
								You can Login into your dashboard and explore.
								<br> <br> <br> 
							    Thank You,
							    Admin, DigitalStorz.<br> 
							    Phone: +91 9703939944 (Works 09:00 AM tp 06:00 PM All Days)<br> 
							    email: info@digitalstorz.com<br> <br> <br> <br> <br> 
								<b>Please do not reply to this email. This is an auto generated email from DigitalStorz, and this mailbox will not be monitored.<br>
								
								';
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				//print_r($mail);	exit;
				$mail->send();
    }else{
         $mess="Error In Updating KYC..";
    }
}

if($_REQUEST['mode'] == "reject"){
    $store_id_appr=$_REQUEST['store_id'];
    $sql_kyc_appr="UPDATE `stores` SET `kyc_status`='Rejected' WHERE `store_id`=".$store_id_appr;
    $query_kyc_appr=mysql_query($sql_kyc_appr);
    if($query_kyc_appr){
         $mess="Store KYC Rejected..";
    }else{
         $mess="Error In Updating KYC..";
    }
}




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
    <!-- Script for preventing reload submit entry-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
	<div class="header">
	    
		<span>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span></span>
		
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold;  font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
		
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
		    <h1>&nbsp;&nbsp;&nbsp;&nbsp;APPROVE KYC OF CUSTOMER STORE</h1>
			<div class="content_holder">
			    <h1 style="color:green;text-align:center"> <?php echo $mess;?></h1>
                        <table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Store ID</b></td>
														<td><b>Store Name</b></td>
														<td><b>Store Contact</b></td>
														<td><b>Store Address 1</b></td>
														<td><b>Store Address 2</b></td>
														<td><b>Store Added Date</b></td>
														<td><b>Store Registration Certificate</b></td>
														<!--<td><b>Store Owner ID Proof</b></td>-->
														<td><b>Approve</b></td>
														<td><b>Reject</b></td>
														
													</tr>
				<?php
					$sql_kyc="SELECT * FROM `stores` where `kyc_status`='submitted'";
					$query_kyc=mysql_query($sql_kyc);
					while($result_kyc=mysql_fetch_array($query_kyc)){

													echo '<tr>
															<td>'.$result_kyc['store_id'].'</td>
															<td>'.$result_kyc['store_name'].'</td>
															<td>'.$result_kyc['store_contact'].'</td>
															<td>'.$result_kyc['store_address1'].'</td>
															<td>'.$result_kyc['store_address2'].'</td>
															<td>'.$result_kyc['added_date'].'</td>
															<td><a href="./kyc/'.$result_kyc['store_reg_certificate'].' " target=_blank>View Document<a></td>
															
															<td><a href="./approve-kyc.php?mode=approve&store_id='.$result_kyc["store_id"].'">APPROVE</a></td>
															<td><a href="./approve-kyc.php?mode=reject&store_id='.$result_kyc["store_id"].'">REJECT</a></td>
															
													</tr>';

												}
			
					?>
				<div class="content_holder"></div>
				<div class="content_holder_body">

												
							
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