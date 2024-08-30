<?php
session_start();
extract($_REQUEST);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$mess='';$filter='';
include("./dbconnect.php");

	if(isset($_REQUEST['submit'])){
	
		$order_id=$_REQUEST['order_id'];
		$order_status=$_REQUEST['order_status'];
		$order_comments=$_REQUEST['order_comments'];
		$order_amount=$_REQUEST['order_amount'];
		$retailer_id=$_REQUEST['retailer_ac_id'];
		$retailer_email=$_REQUEST['retailer_email'];
		$order_service_name=$_REQUEST['order_service_name'];
		$retailer_name=$_REQUEST['retailer_name'];
	
		
		//print("<pre>");print_r($_REQUEST);exit;
		if($order_status==2){ //For Rejected Orders
					$sql_stat_upd="UPDATE `cust_retail_unlock_orders` SET 
		`order_status`='".$order_status."',`comments`='".$order_comments."' WHERE `order_id`=".$order_id."";
		
		$query_stat_upd=mysql_query($sql_stat_upd);
			if($query_stat_upd){
				$mess="Order Details Updated..";
				
				//Getting Retailer Credits
				$sql_retailer_credits_new="SELECT `retailer_credits` FROM `cust_kolors_retailer_credits` WHERE `retailer_id`=".$retailer_id;
				$query_retailer_credits_new=mysql_query($sql_retailer_credits_new);
				$result_retailer_credits_new=mysql_fetch_array($query_retailer_credits_new);
					$available_retailer_credits=$result_retailer_credits_new['retailer_credits'];
					
					$new_credits_after_refund=$available_retailer_credits+$order_amount;
				//Refund Retailer

				$sql_refund="UPDATE `cust_kolors_retailer_credits` SET `retailer_credits`='".$new_credits_after_refund."' WHERE `retailer_id`='".$retailer_id."'";
				//echo $sql_refund;exit;
				$query_refund=mysql_query($sql_refund);
				
				if($query_refund){
					//UPDATING TRANSACTION IN cust_kolors_retailer_credits_transactions table
					$sql_trans_ins="INSERT INTO `cust_kolors_retailer_credits_transactions`(`retailer_id`, `transaction_amount`, `transaction_date`,`status`,`transaction_type`) VALUES 
					(".$retailer_id.",'".$order_amount."',NOW(),'success','Refund')";
					//echo $sql_trans_ins;exit;
					$query_trans_ins=mysql_query($sql_trans_ins);
					$credit_tr_id=mysql_insert_id();
					
					//UPDATING CREDIT TRANSACTION ID IN cust_retail_unlock_orders TABLE
					$sql_upd_cr_tr_id="UPDATE `cust_retail_unlock_orders` SET `credit_transaction_id`='".$credit_tr_id."' WHERE `order_id`=".$order_id;
					$query_upd_cr_tr_id=mysql_query($sql_upd_cr_tr_id);
				
					//SENDING USER AN Email
								require '../PHPMailer/PHPMailerAutoload.php';
								
								$mail = new PHPMailer;
								
								$mail->isSMTP();                                      // Set mailer to use SMTP
								$mail->Host = 'fiesta.websitewelcome.com';  // Specify main and backup server
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = 'admin@kolorsmobileservices.com';                            // SMTP username
								$mail->Password = 'Nandu@9c';                           // SMTP password
								$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
							
								$mail->From = 'admin@kolorsmobileservices.com'; 
								$mail->FromName = 'ADMIN Kolors Mobile Services';
								$mail->addAddress($retailer_email);  // Add a recipient
								$mail->addReplyTo('');
								$mail->addCC('');
								$mail->addBCC('');
							
								$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
								//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
								//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
								$mail->isHTML(true);                                  // Set email format to HTML
								
								$mail->Subject = 'Your Order Rejected.';
								$mail->Body    = 'Dear '.$retailer_name.', <br><br>Greetings From Kolors Mobile Services. 
												<br><br>Your Unlock Order with "Order Id: '.$order_id.' - '.$order_service_name.'" was Rejected By Admin <br>
												<br>
												Your Order Amount : '.$order_amount.' INR was refunded to your account.
												<br>
												Please Check Your Order History and Let us know any issue persists.
												 
												<br>
												
												<br><br>Thank You.. <br>
												Kolors Mobile Services Team.
												';
								//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
								
								if(!$mail->send()) {
									$mess="<font color='green'><b>Order Placed.. </b></font>";
								}else{
									$mess="<font color='green'><b>Order Rejected, Refund Success.</b></font>";
								}
				}
				
			}else{
				$mess="Failed To Update..";
			}
		}else{ // for Approve, In Process and all
		
			$sql_stat_upd="UPDATE `cust_retail_unlock_orders` SET 
			`order_status`='".$order_status."',`comments`='".$order_comments."' WHERE `order_id`=".$order_id."";
		
			$query_stat_upd=mysql_query($sql_stat_upd);
			if($query_stat_upd){
				
					if($order_status=='1'){
						$mail_body=" is approved by admin.";
					}else if($order_status=='3'){
						$mail_body=" is approved and in process.";
					}else if($order_status=='4'){
						$mail_body=" is Completed.";
					}
			
							//SENDING USER AN Email
								require '../PHPMailer/PHPMailerAutoload.php';
								
								$mail = new PHPMailer;
								
								$mail->isSMTP();                                      // Set mailer to use SMTP
								$mail->Host = 'mail.kolorsmobileservices.com';  // Specify main and backup server
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = 'admin@kolorsmobileservices.com';                            // SMTP username
								$mail->Password = 'Nandu@9c';                           // SMTP password
								$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
							
								$mail->From = 'admin@kolorsmobileservices.com'; 
								$mail->FromName = 'ADMIN Kolors Mobile Services';
								$mail->addAddress($retailer_email);  // Add a recipient
								$mail->addReplyTo('');
								$mail->addCC('');
								$mail->addBCC('');
							
								$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
								//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
								//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
								$mail->isHTML(true);                                  // Set email format to HTML
								
								$mail->Subject = 'Your Order Update..';
								$mail->Body    = 'Dear '.$retailer_name.', <br><br>Greetings From Kolors Mobile Services. 
												<br><br>Your Unlock Order with "Order Id: '.$order_id.' - '.$order_service_name.'" '.$mail_body.'<br>
												<br>
												
												<br>
												Please Check Your Order History to track your order completely..
												 
												<br>
												
												<br><br>Thank You.. <br>
												Kolors Mobile Services Team.
												';
								//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
								
								if(!$mail->send()) {
									$mess="<font color='green'><b>Order Placed.. </b></font>";
								}else{
									$mess="<font color='green'><b>Order Rejected, Refund Success.</b></font>";
								}
			$mess="Order Details Updated..";
			}
		}
		

	}
	
	if(isset($_REQUEST['filter'])){
		$filter=$_REQUEST['filter'];
	}else{
		$filter='all';
	}
	
	if($filter=='all')
	{
		$sql_orders="SELECT * FROM `cust_retail_unlock_orders` ORDER BY order_id DESC";
		$query_orders=mysql_query($sql_orders);
	}else{
		$sql_orders="SELECT * FROM `cust_retail_unlock_orders` WHERE `order_status`='".$filter."' ORDER BY order_id DESC";
		$query_orders=mysql_query($sql_orders);
	}
?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
		function filterRecords(filterVar){
			var filter=filterVar;
			//alert(filter);
			 window.location="./orders.php?filter="+filter;
		}
		
		function disabled_alert(){
			alert('Order Already Rejected.. Leave It');
		}
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
			<div class="page_title_div"><h1>Current Orders</h1></div>

											<table>
												<tr> 
													<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status: 
													<?php $array_status=array (
																		 
																		//"0"=>"Waiting for Confirmation",
																		//"1"=>"Approved Orders", 
																		"3"=>"In Process Orders",
																		"4"=>"Completed Orders",
																		"2"=>"Rejected Orders", 
																		"all"=>"All");
													?>
														<select style="width:300px;" onchange="filterRecords(this.value)">
															<?php
																foreach ($array_status as $key => $value){
																	if($filter==$key){
																		echo "<option selected value=".$key.">".$value."</option>";
																	}else{
																		echo "<option value=".$key.">".$value."</option>";
																	}
																}
															?>
														</select>&nbsp;&nbsp;&nbsp;
													</td>
													<td>&nbsp;&nbsp;&nbsp;IMEI NO: <input type="text" style="width:300px;" name="imei_search" value="">&nbsp;&nbsp;&nbsp;<input type="submit" name="Search" value="Search">
													</td>
												</tr>
											</table>
											<br>
											<table class="order_hisory_table">
												<tr class="table_heading">
												<td><b>Order&nbsp;Id</b></td>
												<td><b>Price</b></td>
												<td width="200px"><b>Service&nbsp;Name</b></td>
												<td><b>IMEI&nbsp;No</b></td>
												<td><b>Customer&nbsp;Name</b></td>
												<td><b>Customer&nbsp;Id</b></td>
												<td><b>Email</b></td>
												<!--<td><b>Phone</b></td>
												
												<td><b>Payment</b></td>-->
												<td><b>Cust/Ret</b></td>
												<td><b>Status</b></td>
												<td><b>Change Status</b></td>
												<td><b>Comments</b></td>
											</tr>
											<?php
											
												while($result_orders=mysql_fetch_array($query_orders)){
												
												$sql_ser_name="SELECT service_name FROM cust_kolors_services_list WHERE service_id=".$result_orders['service_id'];
												$query_ser_name=mysql_query($sql_ser_name);
												$res_ser_name=mysql_fetch_array($query_ser_name);
												$ordered_ser_name=$res_ser_name['service_name'];
													if($result_orders['order_status']=="0"){
														$order_status_new="<font color='orange'>Waiting for Confirmation</font>";
													}else if($result_orders['order_status']=="1"){
														$order_status_new="<font color='green'>Order Approved</font>";
													}else if($result_orders['order_status']=="2"){
														$order_status_new="<font color='red'>Order Rejected</font>";
													}else if($result_orders['order_status']=="3"){
														$order_status_new="<font color='green'>In Process</font>";
													}else if($result_orders['order_status']=="4"){
														$order_status_new="<font color='green'>Completed</font>";
													}else{
														$order_status_new='Pending';
													}
													echo '<tr>
															<form name="change_status" action="./orders.php" method="post">
																<td>'.$result_orders['order_id'].'</td>
																<td>'.$result_orders['order_amount'].'</td>
																	<input type="hidden" name="order_id" value="'.$result_orders['order_id'].'" />
																	<input type="hidden" name="order_amount" value="'.$result_orders['order_amount'].'" />
																	<input type="hidden" name="order_service_name" value="'.$ordered_ser_name.'" />
																	<input type="hidden" name="retailer_ac_id" value="'.$result_orders['retailer_id'].'" />
																	<input type="hidden" name="retailer_name" value="'.$result_orders['cust_name'].'" />
																	<input type="hidden" name="retailer_email" value="'.$result_orders['email'].'" />
																<td width="200px">'.$ordered_ser_name.'</td>
																<td>'.$result_orders['imei_no'].'</td>
																<td>'.$result_orders['cust_name'].'</td>
																<td>'.$result_orders['retailer_id'].'</td>
																<td>'.$result_orders['email'].'</td>

																<td>'.$result_orders['customer/retailer'].'</td>
																<td>'.$order_status_new.'</td>
																<td>';
																$array_status=array (
																		//"1"=>"Approve Orders", 
																		"2"=>"Reject Order", 
																		//"3"=>"In Process",
																		"4"=>"Complete Order");
																		if($result_orders['order_status']=='2' || $result_orders['order_status']=='4' ){
																			echo "<select class='select_small' disabled name='order_status'>";
																		}else{
																			echo "<select class='select_small' name='order_status'>";
																		}
																		
																			foreach ($array_status as $key1 => $value1){
																				if($result_orders['order_status']==$key1){
																					echo "<option selected value=".$key1.">".$value1."</option>";
																				}else{
																					echo "<option value=".$key1.">".$value1."</option>";
																				}
																			}
																		echo "</select>";
															
															echo '</td>
																<td><textarea class="textarea_small" name="order_comments">'.$result_orders['comments'].'</textarea></td>
																'; 
																if($result_orders['order_status']=='2'){
																	echo '<td><input onsubmit="return disabled_alert();" disabled type="submit" name="submit" value="Submit" /></td>';
																}else{
																	echo '<td><input type="submit" name="submit" value="Submit" /></td>';
																}
															
															echo '
															</form>
														 </tr>';
												}
											?>
											
											</table>
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