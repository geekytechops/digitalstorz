<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
	$mess='';

	if(isset($_REQUEST['submit'])){
		$retailer_id=$_REQUEST['retailer_name'];
		$amount=$_REQUEST['retailer_add_amount'];
		

		$sql_rt_bal_check="SELECT `retailer_id`, `retailer_credits` FROM `cust_kolors_retailer_credits` WHERE `retailer_id`=".$retailer_id;
		$query_rt_bal_check=mysql_query($sql_rt_bal_check);
		$num_rows_rt=mysql_num_rows($query_rt_bal_check);
		
		if($num_rows_rt>0){ // for existing retailer
			$result_rt_bal_check=mysql_fetch_array($query_rt_bal_check);
			$old_credits=$result_rt_bal_check['retailer_credits']; //Previous Balance
			$new_credits=$old_credits+$amount; // Adding current balance to previous balance
			
			//UPDATING TRANSACTION IN cust_kolors_retailer_credits_transactions table
			$sql_trans_ins="INSERT INTO `cust_kolors_retailer_credits_transactions`(`retailer_id`, `transaction_amount`, `transaction_date`,`transaction_type`) VALUES (".$retailer_id.",'".$amount."',NOW(),'Deposit')";
			$query_trans_ins=mysql_query($sql_trans_ins);
			
			$transaction_id=mysql_insert_id(); // GETTING TRANSACTION ID

			if($query_trans_ins){ // if transaction was updated in transactions table
	
				//UPDATING RETAILER CREDIT BALANCE
				$sql_rt_upd="UPDATE `cust_kolors_retailer_credits` SET `retailer_credits`='".$new_credits."' WHERE `retailer_id`=".$retailer_id;
				$query_rt_upd=mysql_query($sql_rt_upd);
				
				if($query_rt_upd){ // if retailer credit balance is updated
					$sql_trans_suc_upd="UPDATE `cust_kolors_retailer_credits_transactions` SET `status`='success'";
					$query_trans_suc_upd=mysql_query($sql_trans_suc_upd);
					
				//SENDING USER AN Email
				require '../PHPMailer/PHPMailerAutoload.php';
				
				//Getting retailer email_id
				$sql_retailer_email="SELECT `email_id` , `retailer_name` FROM `cust_kolors_retail_users` WHERE `retailer_id`=".$retailer_id;
				$query_retailer_email=mysql_query($sql_retailer_email);
				$result_retailer_email=mysql_fetch_array($query_retailer_email);
				
				$retailer_email=$result_retailer_email['email_id'];
				$retailer_name=$result_retailer_email['retailer_name'];

	
				$mail = new PHPMailer;
				
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'fiesta.websitewelcome.com';  // Specify main and backup server
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'admin@kolorsmobileservices.com';                            // SMTP username
				$mail->Password = 'Nandu@9c';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			
				$mail->From = 'admin@kolorsmobileservices.com'; 
				$mail->FromName = 'Kolors Mobile Services';
				$mail->addAddress($retailer_email);  // Add a recipient
				$mail->addReplyTo('');
				$mail->addCC('');
				$mail->addBCC('');
			
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
				$mail->isHTML(true);                                  // Set email format to HTML
				
				$mail->Subject = 'Funds Added Succesfully..';
				$mail->Body    = 'Hi '.$retailer_name.', <br> 
								<br><br> Your <b>Account Id: '.$retailer_id.'</b> is Credited with '.$amount.' INR<br>
								Your Available Account Balance is: '.$new_credits.' INR.
								<br><br>
								Check <b>My Account</b> from your Login for Transaction Details with Transaction Id: '.$transaction_id.'.
								<br><br>
								Contact Admin from your Account for any queries.
								<br><br>Thank You.. <br>
								Kolors Mobile Services.
								<br><br>
								<font color=red>This email consists of confidential and secure data. Please do not share with anyone.</font>
								';
					//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
					
					if(!$mail->send()) {
						$mess="<font color=#fff><b>Balance Added to Retailer.. Transaction Id: ".$transaction_id.". Email Not Sent</b></font>";
					}else{
						$mess="<font color=#fff><b>Balance Added to Retailer.. Transaction Id: ".$transaction_id.". Email sent</b></font>";
					}
				}else{
					$sql_trans_suc_upd="UPDATE `cust_kolors_retailer_credits_transactions` SET `status`='failed'";
					$query_trans_suc_upd=mysql_query($sql_trans_suc_upd);
					
					$mess="<font color=#fff><b>Transaction Failed Transaction Id: ".$transaction_id."</b></font>";
				}
			}else{
				$mess="<font color=#fff><b>Transaction Failed Transaction Id: ".$transaction_id."</b></font>";
			}
		}else{ // for new retailer
		
			//UPDATING TRANSACTION IN cust_kolors_retailer_credits_transactions table
			$sql_trans_ins="INSERT INTO `cust_kolors_retailer_credits_transactions`(`retailer_id`, `transaction_amount`, `transaction_date`,`transaction_type`) VALUES (".$retailer_id.",'".$amount."',NOW(),'Deposit')";
			$query_trans_ins=mysql_query($sql_trans_ins);
			
			$transaction_id=mysql_insert_id(); // GETTING TRANSACTION ID
			
			
			if($query_trans_ins){ // if transaction success inserting new retailer credits
				$sql_rt_ins="INSERT INTO `cust_kolors_retailer_credits`(`retailer_id`, `retailer_credits`) VALUES (".$retailer_id.",'".$amount."')";
				$query_rt_ins=mysql_query($sql_rt_ins);
				
				if($query_rt_ins){ // if credits inserted updating transaction as success
					$sql_trans_suc_upd="UPDATE `cust_kolors_retailer_credits_transactions` SET `status`='success'";
					$query_trans_suc_upd=mysql_query($sql_trans_suc_upd);
					
					//SENDING USER AN Email
					require '../PHPMailer/PHPMailerAutoload.php';
					
					//Getting retailer email_id
					$sql_retailer_email="SELECT `email_id` , `retailer_name` FROM `cust_kolors_retail_users` WHERE `retailer_id`=".$retailer_id;
					$query_retailer_email=mysql_query($sql_retailer_email);
					$result_retailer_email=mysql_fetch_array($query_retailer_email);
					
					$retailer_email=$result_retailer_email['email_id'];
					$retailer_name=$result_retailer_email['retailer_name'];

		
					$mail = new PHPMailer;
					
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'mail.kolorsmobileservices.com';  // Specify main and backup server
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'admin@kolorsmobileservices.com';                            // SMTP username
					$mail->Password = 'Nandu@9c';                           // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
				
					$mail->From = 'admin@kolorsmobileservices.com'; 
					$mail->FromName = 'Kolors Mobile Services';
					$mail->addAddress($retailer_email);  // Add a recipient
					$mail->addReplyTo('');
					$mail->addCC('');
					$mail->addBCC('');
				
					$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
					//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
					//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
					$mail->isHTML(true);                                  // Set email format to HTML
					
					$mail->Subject = 'Funds Added Succesfully..';
					$mail->Body    = 'Hi '.$retailer_name.', <br> 
									<br><br> Your <b>Account Id: '.$retailer_id.'</b> is Credited with '.$amount.' INR<br>
									Your Available Account Balance is: '.$amount.' INR.
									<br><br>
									Check <b>My Account</b> from your Login for Transaction Details with Transaction Id: '.$transaction_id.'.
									<br><br>
									Contact Admin from your Account for any queries.
									<br><br>Thank You.. <br>
									Kolors Mobile Services.
									<br><br>
									<font color=red>This email consists of confidential and secure data. Please do not share with anyone.</font>
									';
						//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
						
						if(!$mail->send()) {
							$mess="<font color=#fff><b>Balance Added to Retailer.. Transaction Id: ".$transaction_id.". Email Not Sent</b></font>";
						}else{
							$mess="<font color=#fff><b>Balance Added to Retailer.. Transaction Id: ".$transaction_id.". Email sent</b></font>";
						}

				}else{ // if credits are not inserted updating transaction as failed
					$sql_trans_suc_upd="UPDATE `cust_kolors_retailer_credits_transactions` SET `status`='failed'";
					$query_trans_suc_upd=mysql_query($sql_trans_suc_upd);
					
					$mess="<font color=#fff><b>Transaction Failed Transaction Id: ".$transaction_id."</b></font>";
				}
			}else{
				$mess="<font color=#fff><b>Transaction Failed Transaction Id: ".$transaction_id."</b></font>";
			}
			
		}
	}
	
	if(isset($_REQUEST['block'])){
		$retailer_id=$_REQUEST['hidden_retailer_id'];
		$sql_block_ret="UPDATE `cust_kolors_retail_users` SET `status`=0 WHERE `retailer_id`=".$retailer_id;
		$query_block_ret=mysql_query($sql_block_ret);
		if($query_block_ret){
			$mess="User Blocked";
		}else{
			$mess="Operation Failed.";
		}
	}
	if(isset($_REQUEST['activate'])){
		$retailer_id=$_REQUEST['hidden_retailer_id'];
		$sql_block_ret="UPDATE `cust_kolors_retail_users` SET `status`=1 WHERE `retailer_id`=".$retailer_id;
		$query_block_ret=mysql_query($sql_block_ret);
		if($query_block_ret){
			$mess="User Activated";
		}else{
			$mess="Operation Failed.";
		}
	}

?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	<script type="text/javascript"> 

			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				}
			}
			function validate()
            {
				if (document.retailer_credit_add.retailer_name.value == "")
                {
                    document.retailer_credit_add.retailer_name.focus();
                    alert("Select Retailer Name");
					return false;
                }
				if (document.retailer_credit_add.retailer_add_amount.value == "")
                {
                    document.retailer_credit_add.retailer_add_amount.focus();
                    alert("Enter Amount");
					return false;
                }
			}
			
</script>
	<!-- disabling right click-->
<script language=JavaScript>
<!--

//Disable right mouse click Script

	var message="Right Click Function Disabled!";

	///////////////////////////////////
	function clickIE4(){
	if (event.button==2){
	alert(message);
	return false;
	}
	}

	function clickNS4(e){
	if (document.layers||document.getElementById&&!document.all){
	if (e.which==2||e.which==3){
	alert(message);
	return false;
	}
	}
	}

	if (document.layers){
	document.captureEvents(Event.MOUSEDOWN);
	document.onmousedown=clickNS4;
	}
	else if (document.all&&!document.getElementById){
	document.onmousedown=clickIE4;
	}

	document.oncontextmenu=new Function("alert(message);return false")

	// --> 
	</script>
</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
                <?php include("admin-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>Add Retailer Credits</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add Retailer Credits &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="retailer_credit_add" method="post" action="./add-retailer-credits.php" onsubmit="return validate()">
									
					<div class="txt_lable">Retailer: :</div>
					<div>
						<select name="retailer_name">
													<option value="">-- SELECT --</option>
													<?php
														$sql_retailer_names="SELECT `retailer_id`, `retailer_name`, `outlet_name`,`username`, `contact_no`, `email_id` FROM `cust_kolors_retail_users` WHERE `status`=1";
														$query_retailer_names=mysql_query($sql_retailer_names);
														while($result_retailer_names=mysql_fetch_array($query_retailer_names)){
															echo '<option value="'.$result_retailer_names['retailer_id'].'">'.$result_retailer_names['username'].' - '.$result_retailer_names['outlet_name'].'</option>';
														}
													?>
													</select>
					</div>
					
					<div class="txt_lable">Amount: &#8377;</div>
					<div><input type="text" onkeypress="return numbersonly(event)" maxlength=5 name="retailer_add_amount" width="100px" value="" /> </div>

					<div class="submit_button_div"><input type="submit" name="submit" value="&nbsp;&nbsp;Add Credit&nbsp;&nbsp;" /></div>
				</form>
				</div>
				<div>
					<table class="order_hisory_table">
												<tr class="table_heading">
													<td>Retailer Id</td>
													<td>Retailer Name</td>
													<td>Username</td>
													<td>Password</td>
													<td>Credits</td>
													<td>Outlet Name</td>
													<td>Contact No</td>
													<td>Email</td>
													<td>Verified</td>
													<td>Adderss</td>
													
												</tr>
					<?php
						$sql_user_list="SELECT * FROM `cust_kolors_retail_users` ORDER BY `retailer_id` DESC";
						$query_user_list=mysql_query($sql_user_list);
						while($result_user_list=mysql_fetch_array($query_user_list)){
							
							if($result_user_list['status']==1){
								$block_btn='<input type="submit" style="background:red;" name="block" value="&nbsp;&nbsp;Block&nbsp;&nbsp;">';
							}else if($result_user_list['status']==0){
								$block_btn='<input type="submit" name="activate" value="&nbsp;&nbsp;Activate&nbsp;&nbsp;">';
							} 
							
							$sql_ret_cr="SELECT `retailer_credits` FROM `cust_kolors_retailer_credits` WHERE `retailer_id`=".$result_user_list['retailer_id'];
							$query_ret_cr=mysql_query($sql_ret_cr);
							$res_ret_cr=mysql_fetch_array($query_ret_cr);
							echo '<form name="" action="./add-retailer-credits.php" method="post">
									<input type="hidden" name="hidden_retailer_id" value="'.$result_user_list['retailer_id'].'">
									<tr>
									<td>'.$result_user_list['retailer_id'].'</td>
									<td>'.$result_user_list['retailer_name'].'</td>
									<td>'.$result_user_list['username'].'</td>
									<td>'.$result_user_list['password'].'</td>
									<td>'.$res_ret_cr['retailer_credits'].'</td>
									<td>'.$result_user_list['outlet_name'].'</td>
									<td>'.$result_user_list['contact_no'].'</td>
									<td>'.$result_user_list['email_id'].'</td>
									<td>'.$result_user_list['email_verified'].'</td>
									<td>'.$result_user_list['outlet_address'].'</td>
									<td>'.$block_btn.'</td>
								</tr>
								</form>
								';
						}
					?>
				</div>
				<div>
					
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