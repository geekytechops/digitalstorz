<?php
extract($_REQUEST);
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
$page_no=2;
include("./Admin/dbconnect.php");
	$mess='';
	if(isset($_REQUEST['submit'])){
	
		$service_id_selected_temp=$_REQUEST['service_selected'];
		$ser_explode=explode("-",$service_id_selected_temp);
		$service_id_selected=$ser_explode[0];
		
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
						$imei_no=$_REQUEST['imei_no'];
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
						VALUES (".$service_id_selected.",'".$imei_no."','".$_SESSION['session_retailer_account_id']."','".$customer_name."','".$customer_phone_no."','".$customer_email_id."','".$service_charges."','".$cur_date."','".$customer_type."', '0','".$retailer_comments."')";
						
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
											<br><br>Your Unlock Order Placed Successfully and awaiting confirmation from Admin. <br>
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
	<script src="../js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<!-- AUTO COMPLETE CODE-->
	<link href="./css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="./css/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="./js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript" src="./js/jquery.autocomplete.pack.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
	<link href="./css.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="./jquery-ui-1.8.2.custom.min.js"></script> 
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
					if(imei_len != 16){
						alert("Provide 16 Digit Valid IMEI");
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
		
	</script>
	
	<!-- AUTO COMPLETE -->
	<script type="text/javascript"> 
		$(function() {

		$("#service_selected").autocomplete({
		source: "global_search.php",
		minLength: 0,
		select: function(event, ui){
		var getUrl = ui.item.id;
		if(getUrl != '#') {
		location.href = getUrl;
		}
		},
		html: true, 

		open: function(event, ui) {
		$(".ui-autocomplete").css("z-index", 1000);
		}
		});

		});
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
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Place IMEI Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess; ?></div>
				
				<div class="content_holder_body">
				<form name="unlock_form" method="post" action="./mobile-unlocks-retail.php" onsubmit="return validate()">
						
					<div class="txt_lable">Select Service :</div>
					<div><input id="service_selected" type="text" name="service_selected" onblur="if(this.value=='')this.value=this.defaultValue;" onfocus="if(this.value==this.defaultValue)this.value='';" value="Type Service Name Here"/> </div>
					
					<div class="txt_lable">IMEI No :</div>
					<div><input type="text" name="imei_no" onkeypress="return numbersonly(event)" value="" maxlength="16"/></div>
					
					<div>Your Contact Details</div>
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