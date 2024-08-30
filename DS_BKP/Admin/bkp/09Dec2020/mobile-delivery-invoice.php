<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$customer_name=''; $mobile_name=''; $cust_contact=''; $mobile_defect=''; $exp_delivery='';
$est_amount=''; $adv_amount=''; $remarks='';


if(isset($_REQUEST['rslt'])){
	if($_REQUEST['rslt']=="success")
		$mess="<font color='#F4FA58'>Query Added/Updated Succesfully..</font>";
	elseif($_REQUEST['rslt']=="failed")
		$mess="Failed to Add/Update..";
}

if(isset($_REQUEST['delivery-id'])){ 

	
	$sql_disp="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$_REQUEST['delivery-id'];
	$query_disp=mysql_query($sql_disp);
	$result_disp=mysql_fetch_array($query_disp);
	
	$entry_id=$result_disp['entry_id'];
	$customer_name=$result_disp['customer_name'];
	$mobile_name=$result_disp['mobile_name'];
	$cust_contact=$result_disp['cust_contact'];
	$mobile_defect=$result_disp['mobile_defect'];
	$exp_delivery=$result_disp['exp_delivery'];
	$est_amount=$result_disp['est_amount'];
	$adv_amount=$result_disp['adv_amount'];
	$remarks=$result_disp['remarks'];
	$repair_by=$result_disp['repair_by'];
	$sparecost=$result_disp['spare_cost'];
	
	$mobile_def_sql='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$mobile_defect;
	$mob_def_query=mysql_query($mobile_def_sql);
	$mob_def_result=mysql_fetch_array($mob_def_query);
	
	if ($result_disp['mobile_defect_2']!=''){
	$mobile_def_sql2='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_disp['mobile_defect_2'];
	$mob_def_query2=mysql_query($mobile_def_sql2);
	$mob_def_result2=mysql_fetch_array($mob_def_query2);	
												
	$defect_2=', '.$mob_def_result2['defect_name'];
	}else{
	$defect_2='';
	}	
								
	if ($result_disp['mobile_defect_3']!=''){
	$mobile_def_sql3='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_disp['mobile_defect_3'];
	$mob_def_query3=mysql_query($mobile_def_sql3);
	$mob_def_result3=mysql_fetch_array($mob_def_query3);	
												
	$defect_3=', '.$mob_def_result3['defect_name'];
	}else{
	$defect_3='';
	}	
} 
if(isset($_REQUEST['submit'])){ 
		$entry_id=$_REQUEST['entry_id_cust'];
		$act_amount=$_REQUEST['actual_amount'];
		$adjustment=$_REQUEST['adjustments'];
		$remarks=$_REQUEST['remarks'];
		$payment_mode=$_REQUEST['payment_mode'];
		$entry_status_upd="Delivered";
		$send_invoice_cust=$_REQUEST['send_invoice_cust'];
		$mob_repair_by_name=$_REQUEST['repair_by_name'];
		$mob_spare_cost=$_REQUEST['spare_cost'];
		
		
	$sql_disp_msg="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$entry_id;
	$query_disp_msg=mysql_query($sql_disp_msg);
	$result_disp_msg=mysql_fetch_array($query_disp_msg);
	
	$customer_name_msg=$result_disp_msg['customer_name'];
	$mobile_name_msg=$result_disp_msg['mobile_name'];
	$cust_contact_msg=$result_disp_msg['cust_contact'];
	$cur_time = date('Y-m-d H:i:s');

		//Updating Data
		$sql_upd="UPDATE `adm_cust_mob_add` SET
									`actual_amount`='".$act_amount."',
									`adjustments`='".$adjustment."',
									`status`='".$entry_status_upd."',
									`remarks`='".$remarks."',
									`payment_mode`='".$payment_mode."',
									`deliver_by`='".$_SESSION['session_username']."',
									`repair_by`='".$mob_repair_by_name."',
									`spare_cost`='".$mob_spare_cost."',
									`repair_date`='".$cur_time ."',
									`delivered_date`='".$cur_time ."'
									WHERE entry_id=".$entry_id;
		//echo $sql_upd; exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){ 
		
		if($send_invoice_cust=='send_receipt'){
			$message='Dear '.$customer_name_msg.', your mobile '.$mobile_name_msg.', handed over to you. We have received Payment of Rs.'.$act_amount.' towards your order '.$entry_id.'. Now you are preferred customer to Kolors Mobile Services. Thank you and visit again.';
		}elseif($send_invoice_cust=='dontsend_receipt'){
			$message='Hello '.$customer_name_msg.', your mobile '.$mobile_name_msg.', handed over to you. Now you are preferred customer to Kolors Mobile Services. Thank you and visit again.';
			//echo "Message Not Sent";
		}
		
		
		
		//echo $message; exit;
		
function PostRequest($url, $referer, $_data) {
// convert variables array to string:
$data = array(); while(list($n,$v) =
each($_data)){
$data[] = "$n=$v";
}
$data = implode('&', $data);
// format --> test1=a&test2=b etc.
// parse the given URL
$url = parse_url($url);
if ($url['scheme'] != 'http') {
die('Only HTTP request are supported !');
}
// extract host and path:
$host = $url['host'];
$path = $url['path'];
// open a socket connection on port 80
$fp = fsockopen($host, 80);
// send the request headers:
fputs($fp, "POST $path HTTP/1.1\r\n");
fputs($fp, "Host: $host\r\n");
fputs($fp, "Referer: $referer\r\n");
fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
fputs($fp, "Content-length: ". strlen($data) ."\r\n");
fputs($fp, "Connection: close\r\n\r\n");
fputs($fp, $data);
$result = '';
while(!feof($fp)) {
// receive the results of the request
$result .= fgets($fp, 128);
}
// close the socket connection:
fclose($fp);
// split the result header from the content
$result = explode("\r\n\r\n", $result, 2);
$header = isset($result[0]) ? $result[0] : '';
$content = isset($result[1]) ? $result[1] : '';
// return as array:
return array($header, $content);
}
$data = array(
'user' => "kolorsmobileservices@gmail.com",
'password' => "Vinay@9246",
'msisdn' => "91".$cust_contact_msg,
'sid' => "KOLORS",
'msg' => $message,
'fl' =>"0",
'gwid' => "2"
);
list($header, $content) = PostRequest( "http://www.smslane.com//vendorsms/pushsms.aspx",
// the url to post to
"http://www.kolorsmobileservices.com/Unlocks/Admin/add-cust-mobile.php", // its your url
$data
);
echo $content;


			//header('Location: ./mobile-delivery.php?rslt=success');
			//$mess="<font color='#fff'>Category Added Succesfully..</font>";
		}else{
			header('Location: ./mobile-delivery.php?rslt=failed');
			//$mess="Failed to Add..";
		}
}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.category_add.customer_name.value == "")
                {
                    document.category_add.customer_name.focus();
                    alert("Enter Customer Name");
					return false;
                }
				if (document.category_add.mobile_name.value == "")
                {
                    document.category_add.mobile_name.focus();
                    alert("Enter Mobile Name");
					return false;
                }
				if (document.category_add.mobile_defect.value == "")
                {
                    document.category_add.mobile_defect.focus();
                    alert("Enter Mobile Defect");
					return false;
                }
				if (document.category_add.mobile_name.value == "")
                {
                    document.category_add.mobile_name.focus();
                    alert("Enter Category Name");
					return false;
                }
				if (document.category_add.mobile_name.value == "")
                {
                    document.category_add.mobile_name.focus();
                    alert("Enter Category Name");
					return false;
                }

				if (document.category_add.payment_mode.value == "")
                {
                    document.category_add.mobile_name.focus();
                    alert("Select Payment Mode");
					return false;
                }
                if (document.category_add.repair_by_name.value == "")
                {
                    document.category_add.repair_by_name.focus();
                    alert("Select Repeired By");
					return false;
                }
                
               // if (document.category_add.spare_cost.value == "")
               // {
                  //  document.category_add.spare_cost.focus();
                  //  alert("Enter Spare Cost");
				//	return false;
               // }
                
                
                
			}
			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				alert('Numbers Only');
				}
			}
			
			function isNumberKey(evt)
      			{
        			 var charCode = (evt.which) ? evt.which : event.keyCode
         			if (charCode > 31 && (charCode < 48 || charCode > 57))
           		 return false;

        		 return true;
     			 }

			function cal_bal() {
				var act_amt = document.getElementById("actual_amount").value;
				var adjustments = document.getElementById("adjustments").value;
				var adv_amt = document.getElementById("adv_amount").value;
				var v1=Number(adjustments)+Number(adv_amt);
				var bal=Number(act_amt)-Number(adjustments)-Number(adv_amt);
				document.getElementById("bal_amt").value=bal;
			}

	</script>
</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>CUSTOMER MOBILE DELIVERY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Delivery Invoice &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="category_add" method="post" action="./mobile-delivery-invoice.php" onsubmit="return validate()">
				
				<?php
				if(isset($_REQUEST['del_type']) && $_REQUEST['del_type']=="inst"){
					echo '<input type="hidden" name="del_type_form" value="inst_del_yes" >';
				}
				?>
				
					<table>
						<tr>
							<td class="txt_lable">Customer&nbsp;Name:</td>
							<td class="txt_lable">Mobile name & Model No:</td>
						</tr>
						<tr>
							<td><input type="text" disabled="yes" name="customer_name" value="<?php echo $customer_name ?>" >&nbsp;&nbsp;</td>
							<td><input type="text" disabled="yes" name="mobile_name" value="<?php echo $mobile_name ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Defect:</td> 
							<td class="txt_lable">Expected Delivery: YYYY-MM-DD</td>
						</tr>
						<tr>
							<td><input type="text" disabled="yes" name="mobile_defect" value="<?php echo $mob_def_result['defect_name'].$defect_2.$defect_3?>" >&nbsp;&nbsp;</td>
							<td><input  type="text" disabled="yes" name="exp_delivery" value="<?php echo $exp_delivery ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Contact No:</td>
							<td class="txt_lable">Remarks:</td>
							
						</tr>
						<tr>
							<td><input type="text" disabled="yes" name="contact_no" value="<?php echo $cust_contact ?>" >&nbsp;&nbsp;</td>
							<td><input  type="text" name="remarks" value="<?php echo $remarks ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Estimated Amount:</td>
							<td class="txt_lable">Advance Amount:</td>
							
						</tr>
						<tr>
							<td><input  type="text" disabled="yes" name="est_amount" value="<?php echo $est_amount ?>" ></td>
							<td><input type="text" disabled="yes" id="adv_amount" name="adv_amount" value="<?php echo $adv_amount ?>" >&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td class="txt_lable">Actual / Final Amount:</td>
							<!--<td class="txt_lable">Adjustments:</td>-->
							<td class="txt_lable">Reference Id</td>
							
						</tr>
						<tr>
							<td><input  type="text" id="actual_amount" onblur="cal_bal()" name="actual_amount" value="<?php echo $est_amount ?>" ></td>
							<!--<td><input type="text"  id="adjustments" onblur="cal_bal()" name="adjustments" value="" >&nbsp;&nbsp;</td> -->
							<td><input type="text" readonly="yes" name="entry_id_cust" value="<?php echo $entry_id;?>" ></td>
						</tr>
						<tr>
							
							<td class="txt_lable">Balance Amount:</td>
							
							
						</tr>
						<tr>
							
							<?php $bal=$est_amount-$adv_amount; ?>
							<td><input  type="text" id="bal_amt" name="bal_amt" value="<?php echo $bal;?>" ></td>
						</tr>

						<tr>
							<td class="txt_lable">Payment Mode</td>
							<td class="txt_lable">Send Receipt To Customer</td>
						</tr>
						<tr>
							<td>
							<select name='payment_mode'>
							<option value="">--SELECT--</option>
							<option value="cash">Cash</option>
							<option value="card">Credit/Debit Card</option>
							<option value="googlepay">Google Pay</option>
							<option value="phonepe">Phone Pe</option>
							<option value="paytm">Paytm</option>
							<option value="mobiqwik">Mobiqwik</option>
							<option value="freecharge">Freecharge</option>
							<option value="wallet">Other Mobile Wallet</option>
							<option value="none">None</option>
							</select>
							</td>
							<td>
								<input type='radio' name='send_invoice_cust' value='send_receipt'> YES
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='send_invoice_cust' value='dontsend_receipt' checked> NO
							</td>
						</tr>
						
						<tr>
							<td class="txt_lable">Mobile Repair Done By</td>
							
							<td class="txt_lable">Spare Cost</td>
							
							
						</tr>
						<tr>
						<td>
						
						<?php
						if($repair_by==''){
						?>
							<select name='repair_by_name'>
							<option value="">--SELECT--</option>
							<option value="admin">Admin</option>
							<option value="vinay">Vinay</option>
							<option value="vasu">Vasu</option>
							<option value="sandeep">Sandeep</option>
							</select>
							</td>
						<?php
						}elseif($repair_by=='vinay'){
						?>
						<select name='repair_by_name'>
							
							<option value="vinay" selected="yes">Vinay</option>
							<option value="vasu">Vasu</option>
							<option value="sandeep">Sandeep</option>
							<option value="admin">Admin</option>
							</select>
							</td>
						<?php
						}elseif($repair_by=='vasu'){
						?>
						<select name='repair_by_name'>
							
							<option value="vinay" >Vinay</option>
							<option value="vasu" selected="yes">Vasu</option>
							<option value="sandeep">Sandeep</option>
							<option value="admin">Admin</option>
							</select>
						<?php
						}elseif($repair_by=='admin'){
						?>
						
						
						<select name='repair_by_name'>
							
							<option value="vinay" >Vinay</option>
							<option value="vasu" >Vasu</option>
							<option value="sandeep">Sandeep</option>
							<option value="admin" selected="yes">Admin</option>
							</select>
						<?php
						}elseif($repair_by=='sandeep'){
						?>
						<select name='repair_by_name'>
							
							<option value="vinay" >Vinay</option>
							<option value="vasu" >Vasu</option>
							<option value="sandeep" selected="yes">Sandeep</option>
							<option value="admin" >Admin</option>
							</select>
						<?php
						}
						?>
						
						
							<td><input type="text" name="spare_cost" value="<?php echo $sparecost;?>" onkeypress="return isNumberKey(event)" ></td>
						
						
						</tr>
						
					</table>
					<!--
					<div class="txt_lable">Customer Name:</div>
					<div><input type="text" name="customer_name" value="" ></div>
					
					<div class="txt_lable">Mobile name & Model No:</div>
					<div><input type="text" name="mobile_name" value="" ></div>
					
					<div class="txt_lable">Defect:</div>
					<div><input type="text" name="mobile_defect" value="" ></div>
					
					<div class="txt_lable">Expected Delivery: YYYY-MM-DD</div> 
					<div><input  type="text" class="small_textbox_new" name="exp_delivery" value="" ></div>
					
					<div class="txt_lable">Contact No:</div>
					<div><input type="text" name="contact_no" value="" ></div>
					
					<div class="txt_lable">Estimated Amount:</div>
					<div><input type="text" name="est_amount" value="" ></div>
					
					<div class="txt_lable">Advance Amount:</div>
					<div><input type="text" name="adv_amount" value="" ></div>
					
					<div class="txt_lable">Remarks:</div>
					<div><input type="text" name="remarks" value="" ></div>
					-->
					<br>

					<div class="submit_button_div"><input  type="submit" name="submit" value="Proceed for Delivery" /></div>
				</form>
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