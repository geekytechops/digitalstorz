<?php
extract($_REQUEST);
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
$page_no=2;
include("./Admin/dbconnect.php");
	$mess='';
	if(isset($_REQUEST['submit'])){

		$service_id_selected=$_REQUEST['service_selected'];
		
		$sql_service_id_check = ("SELECT COUNT(*) FROM `cust_kolors_services_list` WHERE `service_id`=".$service_id_selected);
		$query_service_id_check=mysql_query($sql_service_id_check);
		$count_ser_id = count($query_service_id_check);
		//$count_ser_id;  exit;
		if($query_service_id_check && $count_ser_id==1){
		 
			//GETTING SERVICE CHARGES
			$sql_service_details="SELECT `service_name`,`duration`,`retail_price` FROM `cust_kolors_services_list` WHERE `service_id`=".$service_id_selected;
			$query_service_details=mysql_query($sql_service_details);
			$result_service_details=mysql_fetch_array($query_service_details);
				$service_charges=$result_service_details['retail_price'];
				$service_name=$result_service_details['service_name'];
				$service_duration=$result_service_details['duration'];
			
			//GETTING RETAILER CREDIT BALANCE
			$sql_retailer_credits_new="SELECT `retailer_credits` FROM `cust_kolors_retailer_credits` WHERE `retailer_id`=".$_SESSION['session_retailer_account_id'];
			$query_retailer_credits_new=mysql_query($sql_retailer_credits_new);
			$result_retailer_credits_new=mysql_fetch_array($query_retailer_credits_new);
				$available_retailer_credits=$result_retailer_credits_new['retailer_credits'];
		
			if($service_charges <= $available_retailer_credits){ //Checking Service Charges is less than or equal to customer credits
						
						$imei_fst_dgts=$_REQUEST['imei_no'];
						$imei_lst_dgt=$_REQUEST['imei_last_digit_value'];
						$imei_no=$imei_fst_dgts.$imei_lst_dgt;
						//echo $imei_no;exit;
						$customer_name=$_REQUEST['customer_name'];
						$customer_phone_no=$_REQUEST['customer_phone_no'];
						$customer_email_id=$_REQUEST['customer_email_id'];
	
						$customer_type=1; //RETAILER
						$cur_date= date('Y-m-d H:i:s');
						if(isset($_REQUEST['retailer_comments'])){
							$retailer_comments=$_REQUEST['retailer_comments'];
						}else{
							$retailer_comments='NA';
						}
					
						$new_credit_bal=$available_retailer_credits - $service_charges;
					
						//echo 'Avail-'.$available_retailer_credits;echo '   CHARGES-'.$service_charges; echo '   REMAINING-'.$new_credit_bal;exit;
					
						$sql_ins="INSERT INTO `cust_retail_unlock_orders`(`service_id`, `imei_no`, `retailer_id`,`cust_name`, `phone`, `email`, `order_amount`, `order_placed_date`, `customer/retailer`, `order_status`,`retailer_comments`) 
						VALUES (".$service_id_selected.",'".$imei_no."','".$_SESSION['session_retailer_account_id']."','".$customer_name."','".$customer_phone_no."','".$customer_email_id."','".$service_charges."','".$cur_date."','".$customer_type."', '3','".$retailer_comments."')";
						
						$query_ins=mysql_query($sql_ins);
						$order_id=mysql_insert_id();
						if($query_ins){

							//Debit Retailer Account
							$sql_debit_retailer_acc="UPDATE `cust_kolors_retailer_credits` SET `retailer_credits`='".$new_credit_bal."' WHERE `retailer_id`=".$_SESSION['session_retailer_account_id'];
							$query_debit_retailer_acc=mysql_query($sql_debit_retailer_acc);
							$mess="<font color=green>Order Placed Succesfully..</font>";
							
							//UPDATING TRANSACTION IN cust_kolors_retailer_debits_transactions table
							$sql_trans_ins="INSERT INTO `cust_kolors_retailer_debits_transactions`(`retailer_id`, `transaction_amount`, `transaction_date`, `status`) VALUES 
							(".$_SESSION['session_retailer_account_id'].",'".$service_charges."',NOW(),'success')";
							$query_trans_ins=mysql_query($sql_trans_ins);
							$debit_trans_id=mysql_insert_id();
							
							//UPDATING DEBIT TRANSACTION ID IN CUST_KOLORD_RETAIL_ORDERS
							
							$sql_upd_dbt_tr_id="UPDATE `cust_retail_unlock_orders` SET `debit_transaction_id`='".$debit_trans_id."' WHERE `order_id`=".$order_id;
							$query_upd_dbt_tr_id=mysql_query($sql_upd_dbt_tr_id);
							
							
							//SENDING USER AN Email
							require './PHPMailer/PHPMailerAutoload.php';
							
							$email=$_SESSION['session_retail_username'];

							$mail = new PHPMailer;
							
							$mail->isSMTP();                                      // Set mailer to use SMTP
							$mail->Host = 'mail.kolorsmobileservices.com';  // Specify main and backup server
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = 'admin@kolorsmobileservices.com';                            // SMTP username
							$mail->Password = 'Nandu@9c';                           // SMTP password
							$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
						
							$mail->From = 'admin@kolorsmobileservices.com'; 
							$mail->FromName = 'ADMIN Kolors Mobile Services';
							$mail->addAddress($email);  // Add a recipient
							$mail->addReplyTo('');
							$mail->addCC('');
							$mail->addBCC('');
						
							$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
							//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
							//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
							$mail->isHTML(true);                                  // Set email format to HTML
							
							$mail->Subject = 'Your Order Details.';
							$mail->Body    = 'Dear Customer, <br><br>Greetings From Kolors Mobile Services. 
											<br><br>Your Unlock Order Placed Successfully and is in Process. <br>
											<br><br>You will get an update once order completes. <br>
											<br>
											<b>Your Order Details:</b><br>
											<table border="1px">
												<tr>
													<td style="text-align:right;">Order Id:</td>
													<td>'.$order_id.'</td>
												</tr>
												<tr>
													<td style="text-align:right;">Unlock Service:</td>
													<td>'.$service_name.'</td>
												</tr>
												<tr>
													<td style="text-align:right;">Charges:</td>
													<td>'.$service_charges.'</td>
												</tr>
												<tr>
													<td style="text-align:right;">Duration:</td>
													<td>'.$service_duration.'</td>
												</tr>
											</table>
											 
											<br>
											You can check the order details at Order History after Login to your account. 
											<br><br>Thank You.. <br>
											Kolors Mobile Services Team.
											';
							//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
							
							if(!$mail->send()) {
								$mess="<font color='#fff'>Order Placed.. </font>";
							}else{
								$mess="<font color='#fff'>Order Placed, Pls Check Your Email.</font>";
							}
						}else{
							$mess="<font color='#fff'>Order Not Placed.. Please Contact Admin.</font>";
						}
			}else{ // if service charge is greater than credits avail. (No balance) 
				header("location:./imortant-mesage.php?q=fail");
			}
		}else{
			$mess="<font color='#fff'>Invalid Unlock Service</font>";
		}		
	}
?>

<html lang="en" dir="ltr"
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<link rel="stylesheet" href="./ServiceAuto/chosen.css">
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.unlock_form.service_selected.value == "Type Service Name Here" || document.unlock_form.service_selected.value == '')
                {
					alert("Select Service");
                    document.unlock_form.service_selected.focus();
					return false;
                }
				if (document.unlock_form.imei_no.value == "")
                {
					//alert(document.unlock_form.service_selected.value);
					alert("Provide Valid IMEI");
                    document.unlock_form.imei_no.focus();
					return false;
                }else{
					var imei_no=document.unlock_form.imei_no.value;
					var imei_len=imei_no.length;
					//alert(imei_no);
					//alert(imei_len);
					if(imei_len != 14){
						alert("Provide Valid IMEI");
						document.unlock_form.imei_no.focus();
						return false;
					}  
				}
			}
			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				}
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
			
			function calculateImei(str_imei){
				//alert(str_imei);
				if(str_imei.length <14){
					//alert("Provide 14 digits of your IMEI");
					document.unlock_form.imei_no.focus();
				}else{
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							//document.getElementById("last_digit_imei").innerHTML = xmlhttp.responseText;
							document.getElementById("last_digit_imei").value=xmlhttp.responseText;
						}
					}
					xmlhttp.open("GET","getLastDigitOfImei.php?q="+str_imei,true);
					xmlhttp.send();
				}
				
			}

	</script>


</head>
<body>
	<div class="header">
		<a href="./retailer-home.php">&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services</a>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<div class="left_container">
			<?php include("./retailer-menu.php");?>
		</div>
		<div class="right_container">
			<div class="page_title_div"><h1>Now Mobile Unlocks at a Click</h1></div>
			<div class="content_holder_small">
				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Place IMEI Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess; ?></div>
				
				<div class="content_holder_body">
				<form name="unlock_form" method="post" action="./mobile-unlocks-retail.php" onsubmit="return validate()">
					        
					<div class="txt_lable">Unlock Service :</div>
					<div>
						<select name="service_selected" id="service_selected" onChange="showServiceDetails(this.value);" data-placeholder="Please Select An Unlock Service.." class="chosen-select" tabindex="2">
							<option value=""></option>
							<?php
							$sql_countries_avail="SELECT DISTINCT(service_category) FROM `cust_kolors_services_list`";
							$query_countries_avail=mysql_query($sql_countries_avail);
								while($result_countries_avail=mysql_fetch_array($query_countries_avail)){
									$ser_list_sql="SELECT `service_id`,`service_name`, `retail_price` FROM cust_kolors_services_list WHERE `service_category`='".$result_countries_avail['service_category']."' ";
									$query_list_sql=mysql_query($ser_list_sql);
									
									echo '<optgroup label="'.$result_countries_avail['service_category'].'">';
									while($result_ser_list=mysql_fetch_array($query_list_sql)){
										echo '<option value="'.$result_ser_list['service_id'].'">'.$result_ser_list['service_name'].' - INR '.$result_ser_list['retail_price'].'</option>';
									}
									echo ' </optgroup>';
								}
							?>
						</select>
					</div>
						  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
						  <script src="./ServiceAuto/chosen.jquery.js" type="text/javascript"></script>
						  <script src="./ServiceAuto/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
						  <script type="text/javascript">
							var config = {
							  '.chosen-select'           : {},
							  '.chosen-select-deselect'  : {allow_single_deselect:true},
							  '.chosen-select-no-single' : {disable_search_threshold:10},
							  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
							  '.chosen-select-width'     : {width:"95%"}
							}
							for (var selector in config) {
							  $(selector).chosen(config[selector]);
							}
						  </script>
						  
					<div class="txt_lable">IMEI No :</div>
					<div style="float:left; position:relative;"><input type="text" style="width:300px;" onkeyup="calculateImei(this.value)" name="imei_no" id="imei_no" onkeypress="return numbersonly(event)" value="" maxlength="14"/>
						<input type="text" style="width:47px;" disabled="yes" name="imei_last_digit_value" value="" id="last_digit_imei" >
					</div>
					
					<!--<div id="last_digit_imei" style="width:50px; border:1px solid #a9a9a9; height:28px; float:left; position:relative;"></div>-->
					  
					<div style="clear:both; padding-top:15px; font-size:16px; color:green">Contact Details</div>
					<div class="txt_lable">Your Name :</div>
					<div><input type="text" name="customer_name" readonly="yes" value="<?php echo $_SESSION['session_retailer_name'];?>"/></div>
					
					<div class="txt_lable">Contact No :</div>
					<div><input type="text" readonly="yes" name="customer_phone_no" value="<?php echo $_SESSION['session_retailer_contact'];?>"/></div>
					
					<div class="txt_lable">Email Id :</div>
					<div><input type="text" name="customer_email_id" readonly="yes" value="<?php echo $_SESSION['session_retail_username'];?>"/></div>
					
					<div class="txt_lable">Leave Comments :</div>
					<div><textarea name="retailer_comments"></textarea></div>
					
					<div class="submit_button_div"><input type="submit" name="submit" value="&nbsp;&nbsp;Place Order&nbsp;&nbsp;"/>&nbsp;(Confirm IMEI No and Contact Details before submitting)</div>
				</form>
				</div>
			</div>
			<div id="txtHint">
			
			</div>
		</div>
	</div>
	<div class="footer">
		Copyright © 2015, <a href="#">KolorsMobileServices.com</a>
	</div>
	
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./retail-login.php');
}
?>