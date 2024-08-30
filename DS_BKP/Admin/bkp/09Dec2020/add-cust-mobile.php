<?php 
date_default_timezone_set("Asia/Kolkata");

session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$customer_name=''; $mobile_name=''; $cust_contact=''; $mobile_defect=''; $exp_delivery=date("Y-m-d", strtotime("tomorrow"));
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
		$mess="<font color='#F4FA58'>Query Added/Updated Succesfully..</font>";
	elseif($_REQUEST['rslt']=="failed")
		$mess="Failed to Add/Update..";
}

if(isset($_REQUEST['submit'])){ //When form Submits
		$cust_name_temp=$_REQUEST['customer_name'];
		if($cust_name_temp==''){
			$cust_name='Customer';
		}else{
			$cust_name=$cust_name_temp;
		}
		$adv_amount_temp=$_REQUEST['adv_amount'];
		$adv_payment_mode=$_REQUEST['adv_payment_mode'];
		if($adv_amount_temp==''){
			$adv_amount='00';
		}else{
			$adv_amount=$adv_amount_temp;
		}
		$mobile_name=$_REQUEST['mobile_name'];
		
		$mobile_defect=$_REQUEST['mobile_defect'];
		$mobile_defect2=$_REQUEST['mobile_defect_2'];
		$mobile_defect3=$_REQUEST['mobile_defect_3'];
		//echo $mobile_defect;exit;
		$contact_no=$_REQUEST['contact_no'];
		$exp_delivery=$_REQUEST['exp_delivery'];
		$est_amount=$_REQUEST['est_amount'];
		//$adv_amount=$_REQUEST['adv_amount'];
		$remarks=$_REQUEST['remarks'];
		$added_by=$_SESSION['session_username'];
		//$cur_time=date();
		$cur_time = date('Y-m-d H:i:s');

		//Inserting Data
		$sql_ins="INSERT INTO `adm_cust_mob_add`(`customer_name`, `mobile_name`,`cust_contact`,`mobile_defect`,`mobile_defect_2`,`mobile_defect_3`,`exp_delivery`,`est_amount`,`adv_amount`,`remarks`,`added_date`,`status`,`rejected`,`delete_status`,`added_by`,`adv_payment_mode`) VALUES 
		('".$cust_name."','".$mobile_name."','".$contact_no."','".$mobile_defect."','".$mobile_defect2."','".$mobile_defect3."','".$exp_delivery."','".$est_amount."','".$adv_amount."','".$remarks."','".$cur_time ."','Pending', '0','0','".$added_by."','".$adv_payment_mode."')";
		//echo $sql_ins; echo $mobile_defect;exit;
		
		$mob_def_sql1="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect;
		$mob_def_query1=mysql_query($mob_def_sql1);
		$result_def_query1=mysql_fetch_array($mob_def_query1);
		$mobile_defect_name1=$result_def_query1['defect_name'];
		
		if($mobile_defect2!=''){
		$mob_def_sql2="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect2;
		$mob_def_query2=mysql_query($mob_def_sql2);
		$result_def_query2=mysql_fetch_array($mob_def_query2);
		$mobile_defect_name2=', '.$result_def_query2['defect_name'];
		
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
		}
		
		$mobile_defect_name=$mobile_defect_name1.$mobile_defect_name2.$mobile_defect_name3;
		//echo $mobile_defect_name;exit;
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
		
		$message='Dear '.$cust_name.', We have received your mobile '.$mobile_name.', with defect: '.$mobile_defect_name.' on '.$cur_time.'. Estimated charges-Rs.'.$est_amount.',Adv Recd - Rs. '.$adv_amount.', Expected Delivery- '.$exp_delivery.'. Thank you for Visiting Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 040-65149944.';
		
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
'msisdn' => "91".$contact_no,
'sid' => "KOLMOB",
'msg' => $message,
'fl' =>"0",
'gwid' => "2"
);
list($header, $content) = PostRequest( "http://www.smslane.com//vendorsms/pushsms.aspx",
// the url to post to
"http://www.kolorsmobileservices.com/Unlocks/Admin/view-cust-mobile-entry.php", // its your url
$data
);
echo $content;
		

			//header('Location: ./add-cust-mobile.php?rslt=success');

		}else{
			header('Location: ./add-cust-mobile.php?rslt=failed');
			//$mess="Failed to Add..";
		}
}

if(isset($_REQUEST['entry_id'])){ 
	$sql_disp="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$_REQUEST['entry_id'];
	$query_disp=mysql_query($sql_disp);
	$result_disp=mysql_fetch_array($query_disp);
	
	$action=$_REQUEST['action'];
	$entry_id=$result_disp['entry_id'];
	$customer_name=$result_disp['customer_name'];
	$mobile_name=$result_disp['mobile_name'];
	$cust_contact=$result_disp['cust_contact'];
	$mobile_defect=$result_disp['mobile_defect'];
	$mobile_defect2=$result_disp['mobile_defect_2'];
	$mobile_defect3=$result_disp['mobile_defect_3'];
	$exp_delivery=$result_disp['exp_delivery'];
	$est_amount=$result_disp['est_amount'];
	$adv_amount=$result_disp['adv_amount'];
	$remarks=$result_disp['remarks'];
	$spare_cost_1=$result_disp['spare_cost'];
	$status=$result_disp['status'];
	$advpay_mode=$result_disp['adv_payment_mode'];
	
	//echo $advpay_mode;
	//exit;
	if($status=='Pending')	
	$status_radio="	<input type='radio' name='entry_status_upd' value='Pending' checked> Pending
			<input type='radio' name='entry_status_upd' value='Completed'> Completed 
			<input type='radio' name='entry_status_upd' value='Rejected' onclick=generateRow()> Rejected ";
	elseif($status=='Completed')
	$status_radio="	<input type='radio' name='entry_status_upd' value='Pending'> Pending
			<input type='radio' name='entry_status_upd' value='Completed' checked> Completed 
			<input type='radio' name='entry_status_upd' value='Rejected'> Rejected ";
	elseif($status=='Rejected')
	$status_radio="	<input type='radio' name='entry_status_upd' value='Pending'> Pending
			<input type='radio' name='entry_status_upd' value='Completed'> Completed 
			<input type='radio' name='entry_status_upd' value='Rejected' checked> Rejected ";
					
} 
if(isset($_REQUEST['update'])){ //When form Submits

		$entry_id=$_REQUEST['hidden_entry_id'];
		$cust_name=$_REQUEST['customer_name'];
		$mobile_name=$_REQUEST['mobile_name'];
		$mobile_defect=$_REQUEST['mobile_defect'];
		$mobile_defect2=$_REQUEST['mobile_defect_2'];
		$mobile_defect3=$_REQUEST['mobile_defect_3'];
		$contact_no=$_REQUEST['contact_no'];
		$exp_delivery=$_REQUEST['exp_delivery'];
		$est_amount=$_REQUEST['est_amount'];
		$adv_amount=$_REQUEST['adv_amount'];
		$remarks=$_REQUEST['remarks'];
		$entry_status_upd=$_REQUEST['entry_status_upd'];
		$spare_cost=$_REQUEST['spare_cost'];
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
		$cur_time = date('Y-m-d H:i:s');
		//Inserting Data
		$sql_upd="UPDATE `adm_cust_mob_add` SET
									`customer_name`='".$cust_name."', 
									`mobile_name`='".$mobile_name."',
									`cust_contact`='".$contact_no."',
									`mobile_defect`='".$mobile_defect."',
									`mobile_defect_2`='".$mobile_defect2."',
									`mobile_defect_3`='".$mobile_defect3."',
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
									`adv_payment_mode`='".$adv_payment_mode."'
									WHERE entry_id=".$entry_id;

		//echo $sql_upd; exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){ 
		
		
		$rem_amt=$est_amount-$adv_amount;
		
		$mob_def_sql="SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`=".$mobile_defect;
		$mob_def_query=mysql_query($mob_def_sql);
		$result_def_query=mysql_fetch_array($mob_def_query);
		$mobile_defect_name=$result_def_query['defect_name'];
		
		if($entry_status_upd=="Completed"){
		$message='Hello '.$cust_name.', Your mobile '.$mobile_name.', is ready for delivery. Please visit our store and collect your mobile. Remaining amount to pay is '.$rem_amt.'. Thank you, Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 040-65149944.';
		}elseif($entry_status_upd=="Rejected"){
		//$message='Hello '.$cust_name.', Your mobile '.$mobile_name.', with defect: '.$mobile_defect_name.' is not resolvable, Please Visit out store and collect your mobile. Thank you, Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 040-65149944.';
		$message='Dear '.$cust_name.', Your mobile '.$mobile_name.', with defect: '.$mobile_defect_name.' is not resolvable, Please Visit out store and collect your mobile. Thank you, Kolors Mobile Services. www.kolorsmobileservices.com. Ph: 9032339944 / 040-65149944.';
		}

		//echo $message;exit;
	//if(($entry_status_upd=="Completed") || ($entry_status_upd=="Rejected")){ //message loop now message wont send in pending state
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
'msisdn' => "91".$contact_no,
'sid' => "KOLMOB",
'msg' => $message,
'fl' =>"0",
'gwid' => "2"
);
list($header, $content) = PostRequest( "http://www.smslane.com//vendorsms/pushsms.aspx",
// the url to post to
"http://www.kolorsmobileservices.com/Unlocks/Admin/mobile-delivery-invoice.php", // its your url
$data
);
echo $content;

//} //message loop
		
			//header('Location: ./view-cust-mobile-entry.php?result_key=pend');
			//$mess="<font color='#fff'>Category Added Succesfully..</font>";
		}else{
			header('Location: ./add-cust-mobile.php?rslt=failed');
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
                
                var val = document.category_add.contact_no.value;
		if (/^\d{10}$/.test(val)) {
    		return true
		} else {
    		alert("Invalid Mobile Number.. Must be 10 digits")
    		document.category_add.contact_no.focus()
    		return false
		}
		/*if (document.category_add.contact_no.value == "")
                {
                    document.category_add.contact_no.focus();
                    alert("Enter Contact Number");
		    return false;
                }
                
                if(document.category_add.contact_no.value != 10) {
                	document.category_add.contact_no.value.focus();
    			alert("Phone number must be 10 digits.");
   			return false;
		}*/
                
                
                
				if (document.category_add.mobile_name.value == "")
                {
                    document.category_add.mobile_name.focus();
                    alert("Enter Category Name");
					return false;
                }

			}
			

	

			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.category_add.contact_no.value < 10)
				return false //disable key press
				}
			}
		



	</script>
	
	<!--check customer name-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript">
            function getData(empid, divid){
           
                $.ajax({
                    url: 'retail_usernname_check_ajax.php?empid='+empid, //call storeemdata.php to store form data
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
var d=document.getElementById("reject_reason");
d.innerHTML+="Reason : <input type='text' name='rejected_reason' value='' >";

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
			<div class="page_title_div"><h1>CUSTOMER MOBILE ENTRY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add Customer Mobile Info &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="category_add" method="post" action="./add-cust-mobile.php" onsubmit="return validate()">
					<table>
						<tr>
						<td class="txt_lable">Contact No:</td>
						<td class="txt_lable">Customer&nbsp;Name:</td>
						</tr>
						<tr>
						<td><input type="text" maxlength="10" name="contact_no" value="<?php echo $cust_contact ?>" onchange="getData(this.value, 'customer_name')"  onkeypress="return numbersonly(event)" >&nbsp;&nbsp;</td>
						<td><input type="text" id="customer_name" name="customer_name" value="<?php echo $customer_name ?>" >&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<input type="hidden" name="hidden_entry_id" value="<?php echo $entry_id?>">
							
							<td class="txt_lable">Mobile Brand & Model No:</td>
							<td class="txt_lable">Estimated Amount:</td>
						</tr>
						<tr>
							
							<td><input type="text" name="mobile_name" value="<?php echo $mobile_name ?>" ></td>
							<td><input  type="text" name="est_amount" value="<?php echo $est_amount ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Defect 1:</td>
							<td class="txt_lable">Expected Delivery: YYYY-MM-DD</td>
						</tr>
						
						<tr>
						
					<?php
						$defect_sql="SELECT * FROM `adm_mobile_defects` ORDER BY `defect_name` ASC";
						$query_defect_sql=mysql_query($defect_sql);
						echo "<td><select name='mobile_defect'>";
						echo "<option value=''> -- SEELCT --</option>";
						while($result_query_defect_sql=mysql_fetch_array($query_defect_sql)){ 
							if ($mobile_defect ==$result_query_defect_sql['defect_id']){
								echo "<option selected ='yes' value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}else{
								echo "<option value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}
						}
						echo "</select></td>";
						
					
					?>
							<!--<td><input type="text" name="mobile_defect" value="<?php echo $mobile_defect ?>" >&nbsp;&nbsp;</td>-->
							<td><input  type="text" name="exp_delivery" value="<?php echo $exp_delivery ?>" ></td>
						</tr>
						<tr>
							<td class="txt_lable">Defect 2:</td>
							<td class="txt_lable">Defect 3:</td>
						</tr>
						<tr>
						
					<?php
						$defect_sql="SELECT * FROM `adm_mobile_defects` ORDER BY `defect_name` ASC";
						$query_defect_sql=mysql_query($defect_sql);
						echo "<td ><select name='mobile_defect_2'>";
						echo "<option value=''> -- SEELCT --</option>";
						while($result_query_defect_sql=mysql_fetch_array($query_defect_sql)){ 
							if ($mobile_defect2 ==$result_query_defect_sql['defect_id']){
								echo "<option selected ='yes' value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}else{
								echo "<option value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}
						}
						echo "</select></td>";
						
					
					?>
							<!--<td><input type="text" name="mobile_defect" value="<?php echo $mobile_defect ?>" >&nbsp;&nbsp;</td>-->
							
							<?php
						$defect_sql="SELECT * FROM `adm_mobile_defects` ORDER BY `defect_name` ASC";
						$query_defect_sql=mysql_query($defect_sql);
						echo "<td ><select name='mobile_defect_3'>";
						echo "<option value=''> -- SEELCT --</option>";
						while($result_query_defect_sql=mysql_fetch_array($query_defect_sql)){ 
							if ($mobile_defect3 ==$result_query_defect_sql['defect_id']){
								echo "<option selected ='yes' value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}else{
								echo "<option value=".$result_query_defect_sql['defect_id'].">".$result_query_defect_sql['defect_name']."</option>";
							}
						}
						echo "</select></td>";
						
					
					?>
							
							</td>
						</tr>
						
					<?php
					$adv_pay_modes = array(""=>"--SELECT--", "cash"=>"Cash", "card"=>"Credit/Debit Card", "googlepay"=>"Google Pay", "phonepe"=>"Phone Pe", "paytm"=>"Paytm", "mobiqwik"=>"Mobiqwik", "freecharge"=>"Freecharge", "wallet"=>"Other Mobile Wallet", "none"=>"None");
					
					
					
					?>
						
						<tr>
							<td class="txt_lable">Advance Amount:</td>
							<td class="txt_lable">Remarks:</td>
							<td class="txt_lable">Advance Payment Mode </td>
						</tr>
						<tr>
							<td><input type="text" name="adv_amount" value="<?php echo $adv_amount ?>" >&nbsp;&nbsp;</td>
							<td><input  type="text" name="remarks" value="<?php echo $remarks ?>" ></td>
							<td>
							<select name='adv_payment_mode'>
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
							</td>
						</tr>
						
						<?php
						if(isset($_REQUEST['entry_id'])){
						?>
						<tr>
							<td class="txt_lable">Spare Cost:</td>
							<td class="txt_lable">&nbsp;</td>
						</tr>
						
						<tr>
							<td><input type="text" name="spare_cost" value="<?php echo $spare_cost_1; ?>" >&nbsp;&nbsp;</td>
							<td class="txt_lable" id="reject_reason"></td>
						</tr>
						<?php
						}
						?>
						
					</table>
				
					<br>
					<div><?php echo $status_radio; ?></div>
					<!--<div id="reject_reason"></div>-->
					
					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value;?>" /></div>
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