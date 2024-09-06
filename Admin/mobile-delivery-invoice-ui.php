<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$store_id=$_SESSION['session_store_id'];
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$session_user_subscription_plan=$_SESSION['session_user_subscription_plan'];
include("./dbconnect.php");
$mess='';
$customer_name=''; $mobile_name=''; $cust_contact=''; $mobile_defect=''; $exp_delivery='';
$est_amount=''; $adv_amount=''; $remarks='';
$return_amount='';
$rejected='0';
$mode_of_operation='';
$transaction='legal';

if(isset($_REQUEST['rslt'])){
	if($_REQUEST['rslt']=="success")
		$mess="<font color='#F4FA58'>Query Added/Updated Succesfully..</font>";
	elseif($_REQUEST['rslt']=="failed")
		$mess="Failed to Add/Update..";
}

if(isset($_REQUEST['delivery-id'])){ 

	
	$sql_disp="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$_REQUEST['delivery-id']." AND store_id=".$session_store_id;;
	$query_disp=mysql_query($sql_disp);
	$rowcount = mysql_num_rows( $query_disp );
	$result_disp=mysql_fetch_array($query_disp);
	if($rowcount==0){
        $transaction='illegal';
    }
	$entry_id=$result_disp['entry_id'];
	$customer_name=$result_disp['customer_name'];
	$mobile_name=$result_disp['mobile_name'];
	$cust_contact=$result_disp['cust_contact'];
	$mobile_defect=$result_disp['mobile_defect'];
	$exp_delivery=$result_disp['exp_delivery'];
	$order_status=$result_disp['status'];
	if(isset($_REQUEST['action']) && $_REQUEST['action']='inst_rej_del'){ 
	    $order_status="Rejected";
	    $rejected=1;
	}
	if($order_status=="Rejected"){
	  $adv_amount='Return Advance in Cash Rs - '.$result_disp['adv_amount'];
	  $return_amount=$adv_amount;
	  $est_amount=0;
	  $adv_amount=0; 
	}else{
	  $est_amount=$result_disp['est_amount'];
	  $adv_amount=$result_disp['adv_amount'];
	}
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
		$adv_amount=$_REQUEST['adv_amount_hidden'];
		$act_amount=$_REQUEST['actual_amount'];
		$adjustment=$_REQUEST['adjustments'];
		$remarks=$_REQUEST['remarks'];
		$payment_mode=$_REQUEST['payment_mode'];
		$entry_status_upd="Delivered";
		$rejected_in_db=$_REQUEST['rejected_in_db'];
		$inst_rej_reason=$_REQUEST['inst_rej_reason'];
		//$send_invoice_cust=$_REQUEST['send_invoice_cust'];
		$send_invoice_cust='send_receipt';
		$mob_repair_by_name=$_REQUEST['repair_by_name'];
		$mob_spare_cost=$_REQUEST['spare_cost'];
		$gst_enabled_bill=$_REQUEST['gst_enabled_bill'];
		$customer_gst_number=$_REQUEST['customer_gst_number'];
		//echo $gst_enabled_bill;
		
		if($gst_enabled_bill=='on'){
		    $gst_amount=($act_amount*18)/100;
		    $gst="yes";
		}else{
		    $gst_amount=0;
		    $gst="no";
		}
		//echo $gst_amount;
		//print ('<pre>');print_r($_REQUEST);exit;
		//echo $adv_amount; exit;
	$sql_disp_msg="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$entry_id;
	$query_disp_msg=mysql_query($sql_disp_msg);
	$result_disp_msg=mysql_fetch_array($query_disp_msg);
	
	$customer_name_msg=$result_disp_msg['customer_name'];
	$mobile_name_msg=$result_disp_msg['mobile_name'];
	$cust_contact_msg=$result_disp_msg['cust_contact'];
	$cur_time = date('Y-m-d H:i:s');
	

		//Updating Data
		$sql_upd="UPDATE `adm_cust_mob_add` SET
		                            `adv_amount`='".$adv_amount."',
									`actual_amount`='".$act_amount."',
									`adjustments`='".$adjustment."',
									`gst_amount`='".$gst_amount."',
									`gst`='".$gst."',
									`customer_gst_no`='".$customer_gst_number."',
									`status`='".$entry_status_upd."',
									`rejected`='".$rejected_in_db."',
									`rejected_reason`='".$inst_rej_reason."',									
									`remarks`='".$remarks."',
									`payment_mode`='".$payment_mode."',
									`deliver_by`='".$_SESSION['session_username']."',
									`repair_by`='".$mob_repair_by_name."',
									`spare_cost`='".$mob_spare_cost."',
									`delivered_date`='".$cur_time ."'
									WHERE entry_id=".$entry_id;
		//echo $sql_upd; exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){ 
		
		if($send_invoice_cust=='send_receipt'){
			//$message='Dear '.$customer_name_msg.', your mobile '.$mobile_name_msg.', handed over to you. We have received Payment of Rs.'.$act_amount.' towards your order '.$entry_id.'. Now you are preferred customer to Kolors Mobile Services. Thank you and visit again. - KOLORS MOBILE SERVICES.';
			$message='Dear '.$customer_name_msg.', your Device '.$mobile_name_msg.', handed over to you. We have recd pmt of Rs.'.$act_amount.'. Thank you and visit again. '.$session_store_name.'. - DigitalStorz';
		}elseif($send_invoice_cust=='dontsend_receipt'){
			//$message='Hello '.$customer_name_msg.', your mobile '.$mobile_name_msg.', handed over to you. Now you are preferred customer to Kolors Mobile Services. Thank you and visit again - KOLORS MOBILE SERVICE';
			//echo "Message Not Sent";
		}

		//echo $message; exit;
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
		
		//SMS SENDING CODE
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$cust_contact_msg,
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
            header('Location: view-cust-mobile-entry.php?result_key=pend&dmsg=mds');
		}else{
		    header('Location: view-cust-mobile-entry.php?result_key=pend&dmsg=mds');
		}
    }else{
        //updating message count in stores.
		$message_length=strlen($message);
        $no_of_messages=ceil($message_length/160);
        //echo $no_of_messages;
        $sql_msg_cnt_upd="UPDATE `stores` SET message_sent_count = message_sent_count + ".$no_of_messages." WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_msg_cnt_upd=mysql_query($sql_msg_cnt_upd);
		
		//SMS SENDING CODE
		$curl = curl_init();
        $data = array(
        "SenderId" => "DigStz",
        "Is_Unicode" => false,
        "Is_Flash" => false,
        "Message" => $message,
        "MobileNumbers" => "91".$cust_contact_msg,
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
        //echo "in paid plan";exit;
    	    header('Location: view-cust-mobile-entry.php?result_key=pend&dmsg=mds');
    }

		}else{
			header('Location: ./mobile-delivery.php?rslt=failed');
			//$mess="Failed to Add..";
		}
}
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">CUSTOMER JOB DELIVERY</h4>

                                </div>
                            </div>
                            <div class="content_holder_heading"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-12 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">                                
                                                                    
                                        <?php
				      if($transaction=='legal'){
				?>
				<form name="category_add" method="post" action="./mobile-delivery-invoice.php" onsubmit="return validate()">
				
				<?php
				if(isset($_REQUEST['del_type']) && $_REQUEST['del_type']=="inst"){
					echo '<input type="hidden" name="del_type_form" value="inst_del_yes" >';
				}
				?>
				
					<table class="table w-50">
						<tr>
							<td class="txt_lable">Customer&nbsp;Name:</td>
							<td class="txt_lable">Mobile name & Model No:</td>
						</tr>
						<tr>
							<td><input type="text" disabled="yes" class="form-control" name="customer_name" value="<?php echo $customer_name ?>" >&nbsp;&nbsp;</td>
							<td><input type="text" disabled="yes" class="form-control" name="mobile_name" value="<?php echo $mobile_name ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Defect:</td> 
							<td class="txt_lable">Expected Delivery: YYYY-MM-DD</td>
						</tr>
						<tr>
							<td><input type="text" disabled="yes" class="form-control" name="mobile_defect" value="<?php echo $mob_def_result['defect_name'].$defect_2.$defect_3?>" >&nbsp;&nbsp;</td>
							<td><input  type="text" disabled="yes" class="form-control" name="exp_delivery" value="<?php echo $exp_delivery ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Contact No:</td>
							<td class="txt_lable">Remarks:</td>
							
						</tr>
						<tr>
							<td><input type="text" class="form-control" disabled="yes" name="contact_no" value="<?php echo $cust_contact ?>" >&nbsp;&nbsp;</td>
							<td><input  type="text" class="form-control" name="remarks" value="<?php echo $remarks ?>" ></td>
						</tr>
						
						<tr>
							<td class="txt_lable">Estimated Amount:</td>
							<td class="txt_lable">Advance Amount:</td>
							
						</tr>
						<tr>
						    <input type="hidden" name="adv_amount_hidden" value="<?php echo $adv_amount ?>" >
							<td><input  type="text" class="form-control" disabled="yes" name="est_amount" value="<?php echo $est_amount ?>" ></td>
							<td><input type="text" class="form-control" disabled="yes" id="adv_amount" name="adv_amount" value="<?php echo $adv_amount ?>" >&nbsp;&nbsp;</td><td><span style="color:red;"><b><?php echo  $return_amount; ?></b></span></td>
						</tr>
						<tr>
							<td class="txt_lable">Actual / Final Amount:</td>
							<!--<td class="txt_lable">Adjustments:</td>-->
							<td class="txt_lable">JOB ID</td>
							
						</tr>
						<tr>
							<td><input  type="number" class="form-control" id="actual_amount" onblur="cal_bal()" name="actual_amount" value="<?php echo $est_amount ?>" onpaste="return false;" ondrop="return false;" autocomplete="off" onkeypress="return onlyNumberKey(event)"></td>
							<!--<td><input type="text"  id="adjustments" onblur="cal_bal()" name="adjustments" value="" >&nbsp;&nbsp;</td> -->
							<td><input type="text" readonly="yes" class="form-control" name="entry_id_cust" value="<?php echo $entry_id;?>" ></td>
						</tr>
						<tr>
							<td class="txt_lable">Balance Amount:</td>
							<?php
							if(isset($_REQUEST['action']) && $_REQUEST['action']='inst_rej_del'){ 
							?>
							<td class="txt_lable">Reject Reason:</td>
							<?php
							}
							?>
						</tr>
						<tr>
							
							<?php $bal=$est_amount-$adv_amount; ?>
							<td><input  type="text" class="form-control" id="bal_amt" disabled="yes" name="bal_amt" value="<?php echo $bal;?>" onkeypress="return numbersonly3(event)"></td>
							<?php
							if(isset($_REQUEST['action']) && $_REQUEST['action']='inst_rej_del'){ 
							?>
							<td><input  type="text" class="form-control" id="inst_rej_reason" name="inst_rej_reason" value="" ></td>
							<?php
							}
							?>
						</tr>
						<input type="hidden" name="rejected_in_db" value="<?php echo $rejected;?>">
                        <?php
                        
                            if($order_status !="Rejected"){
                        ?>
						<tr>
							<td class="txt_lable">Payment Mode</td>
							<!--<td class="txt_lable">Send Receipt To Customer</td>-->
						</tr>
                        
						<tr>
							<td>
							<select name='payment_mode' class="form-select">
							<option value="">--SELECT--</option>
							<option value="cash">Cash</option>
							<option value="card">Credit/Debit Card</option>
							<option value="googlepay">Google Pay</option>
							<option value="phonepe">Phone Pe</option>
							<option value="paytm">Paytm</option>
							<option value="otherwallet">Other Wallet</option>
							<option value="none">None</option>
							</select>
							</td>
							<!--<td>
								<input type='radio' name='send_invoice_cust' value='send_receipt' checked> YES
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='send_invoice_cust' value='dontsend_receipt' > NO
							</td>-->
						</tr>
						<?php
                            }
                        ?>
						<tr>
							<td class="txt_lable">Device Repair Done By</td>
							<td class="txt_lable">Spare Cost</td>
						</tr>
						<tr>
						<td>
						
						
						<?php
						$sql_users_list="SELECT * FROM `cust_kolors_users_list` WHERE `status`=1 AND `store_id`=".$store_id;
						//echo $sql_users_list;
	                    $query_users_list=mysql_query($sql_users_list);
	                    echo "<select name='repair_by_name' class='form-select'>";
	                    echo "<option value=''>--SELECT--</option>";
	                    while($result_users_list=mysql_fetch_array($query_users_list)){
	                        if($repair_by==$result_users_list['username']){
	                        ?>
	                            <option value="<?php echo $result_users_list['username']; ?>" selected><?php echo $result_users_list['staff_name']; ?> </option>
	                        <?php     
	                        }else{
	                        ?>
	                            <option value="<?php echo $result_users_list['username']; ?>"><?php echo $result_users_list['staff_name']; ?> </option>
	                        <?php 
	                        }
	                    
	                    }
						echo "</select>";
						?>
						</td>
							<td><input type="number" class="form-control" name="spare_cost" onpaste="return false;" ondrop="return false;" autocomplete="off" value="<?php echo $sparecost;?>" onkeypress="return isNumberKey(event)" ></td>

						</tr>
						<tr>
						    <td></td>
						    <td class="txt_lable">Customer GST number</td>
						</tr>
						<tr>
						    <td class="txt_lable" align="right"><input class="form-check-input" type="checkbox" onclick='calculate_gst();' name="gst_enabled_bill" id="gst_enabled_bill"><label style="color:red;font-size:16px;">GST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
						    <td class="txt_lable"><input type="text" class="form-control" name="customer_gst_number" ></td>
						</tr>
    
					</table>

					<br>

					<div class="submit_button_div"><input class="btn btn-primary"  type="submit" name="submit" value="Proceed for Delivery" /></div>
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
				/*if (document.category_add.est_amount.value == "")
                {
                    document.category_add.est_amount.focus();
                    alert("Enter Estimated Amount");
					return false;
                }*/
				if (document.category_add.actual_amount.value == "")
                {
                    document.category_add.actual_amount.focus();
                    alert("Enter Actual Amount");
					return false;
                }
                
                if (document.category_add.actual_amount.value != "")
                {
					var y = document.category_add.actual_amount.value;
                    if(!y.match(/^\d+/))
                    {
                        alert("This Field allows Numbers only.");
                        document.category_add.actual_amount.focus();
                        return false;
                    }
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
                
                if (document.category_add.spare_cost.value == "")
                {
                    document.category_add.spare_cost.focus();
                    alert("Enter Spare Cost");
					return false;
                }
                
                if (document.category_add.spare_cost.value != "")
                {
					var z = document.category_add.spare_cost.value;
                    if(!z.match(/^\d+/))
                    {
                        alert("This Field allows Numbers only.");
                        document.category_add.spare_cost.focus();
                        return false;
                    }
                }
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
			function calculate_gst() {
			    if(document.getElementById("gst_enabled_bill").checked == true){
			        var act_amt = document.getElementById("actual_amount").value;
			        var gst_amount= (act_amt*18)/100;
			        var balamt = document.getElementById("bal_amt").value;
			        var bal_amt_with_gst= parseInt(balamt) + parseInt(gst_amount);
			        document.getElementById("bal_amt").value=bal_amt_with_gst;
			    }else{
			        var act_amt = document.getElementById("actual_amount").value;
			        var adv_amt_tmp = document.getElementById("adv_amount").value;
			        if(adv_amt_tmp==''){
			            var adv_amt=0;
			        }else{
			            var adv_amt=document.getElementById("adv_amount").value;
			        }
			        var bal_amt_without_gst= parseInt(act_amt) - parseInt(adv_amt);
			        document.getElementById("bal_amt").value=bal_amt_without_gst;
			    }
			    
			}
            function numbersonly2(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.category_add.actual_amount.value < 10)
				return false //disable key press
				}
			}
			function numbersonly3(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.category_add.bal_amt.value < 10)
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
    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>