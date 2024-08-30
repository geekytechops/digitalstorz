<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';
$upd_ser_country='';
$upd_ser_cust_pr='';
$upd_ser_ret_pr='';
$upd_ser_dur='';
$btn_value=" Add Service ";
$btn_name="submit";

if(isset($_REQUEST['submit'])){ //When form Submits
		$service_name=$_REQUEST['service_name'];
		$service_category=$_REQUEST['service_category'];
		$customer_price=$_REQUEST['cust_service_price'];
		$retail_price=$_REQUEST['retail_service_price'];
		$duration=$_REQUEST['duration'];
		
		//Inserting Data
		$sql_ins="INSERT INTO `cust_kolors_services_list`(`service_name`, `service_category`,`customer_price`, `retail_price`, `duration`, `add_date`, `status`) VALUES 
		('".$service_name."','".$service_category."','".$customer_price."','".$retail_price."','".$duration."',NOW(),1)";
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Service Added Succesfully..</font>";
		}else{
			$mess="Failed to Add..";
		}
} 
if(isset($_REQUEST['update'])){ //When Edit form submits
		
		//print('<pre>');print_r($_REQUEST);exit;
		
		$service_id_hidden_upd=$_REQUEST['hidden_service_id'];
		$service_name_edit=$_REQUEST['service_name'];
		$service_category_edit=$_REQUEST['service_category'];
		$customer_price_edit=$_REQUEST['cust_service_price'];
		$retail_price_edit=$_REQUEST['retail_service_price'];
		$duration_edit=$_REQUEST['duration'];
		
		$sql_upd="	UPDATE `cust_kolors_services_list` SET  
							`service_name`='".$service_name_edit."',
							`service_category`='".$service_category_edit."',
							`customer_price`='".$customer_price_edit."',
							`retail_price`='".$retail_price_edit."',
							`duration`='".$duration_edit."' 
					WHERE 	`service_id`=".$service_id_hidden_upd;
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font color='#fff'>Service Updated Succesfully..</font>";
		}else{
			$mess="Failed to Update..";
		}
}
if(isset($_REQUEST['mode'])){
	$service_id_ed=$_REQUEST['ser_id'];
	if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
		$sql_upd_ser="SELECT * FROM `cust_kolors_services_list` WHERE `service_id`=".$service_id_ed;
		$query_upd_ser=mysql_query($sql_upd_ser);
		$result_upd_ser=mysql_fetch_array($query_upd_ser);
		
		$upd_ser_id=$result_upd_ser['service_id'];
		$upd_ser_name=$result_upd_ser['service_name'];
		$upd_ser_category=$result_upd_ser['service_category'];
		$upd_ser_cust_pr=$result_upd_ser['customer_price'];
		$upd_ser_ret_pr=$result_upd_ser['retail_price'];
		$upd_ser_dur=$result_upd_ser['duration'];
		$btn_value=" UPDATE ";
		$btn_name="update";
		
		
	}else if($_REQUEST['mode']=='del'){ // Action Delete
		$sql_disable_ser_id="UPDATE `cust_kolors_services_list` SET `status`='0' WHERE service_id=".$service_id_ed;
		$query_disable_ser_id=mysql_query($sql_disable_ser_id);
		if($query_disable_ser_id){
			$mess="Service Disabled Succesfully..";
		}else{
			$mess="Failed to Disable..";
		}
	}
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
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.service_add.service_name.value == "")
                {
                    document.service_add.service_name.focus();
                    alert("Enter Service Name");
					return false;
                }
				if (document.service_add.service_category.value == "")
                {
                    document.service_add.service_category.focus();
                    alert("Select Service Category");
					return false;
                }
				if (document.service_add.cust_service_price.value == "")
                {
                    document.service_add.cust_service_price.focus();
					alert("Enter Customer Price");
                    return false;
                }
				if (document.service_add.retail_service_price.value == "")
                {
                    document.service_add.retail_service_price.focus();
					alert("Enter Retail Price");
                    return false;
                }
				if (document.service_add.duration.value == "")
                {
                    document.service_add.duration.focus();
					alert("Enter Duration");
                    return false;
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
</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("admin-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>ADD UNLOCK SERVICES</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add / Update Services &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="service_add" method="post" action="./add-services.php" onsubmit="return validate()">
					<div class="txt_lable">Service Name:</div>
					<input type="hidden" name="hidden_service_id" value="<?php echo $upd_ser_id;?>">
					<div><input type="text" name="service_name" value="<?php echo $upd_ser_name;?>" ></div>
				
					<div class="txt_lable">Category :</div>
					<div>
					
						<select name="service_category" id="service_category">
							<option > -- SELECT -- </option>
							<?php
															$service_categories=array("BB5, SL3 & LUMIA UNLOCK BY IMEI"=>"BB5, SL3 & LUMIA UNLOCK BY IMEI",
																					 "IPHONE FACTORY UNLOCK"=>"IPHONE FACTORY UNLOCK",
																					 "IPHONE TOOLS"=>"IPHONE TOOLS",
																					 "UNLOCK BY BRAND SERVICE"=>"UNLOCK BY BRAND SERVICE",
																					 "UNLOCK BY OPERATOR SERVICE"=>"UNLOCK BY OPERATOR SERVICE");
															foreach($service_categories as $key=>$value){
																if($key==$upd_ser_category){
																	echo '<option value="'.$key.'" selected>'.$value.'</option>';
																}else{
																	echo '<option value="'.$key.'">'.$value.'</option>';
																}
								
															}
														?>
						</select>
					</div>
					<div class="txt_lable">Cust Price :</div>
					<div><input MAXLENGTH="5"  onkeypress="return numbersonly(event)" type="text" name="cust_service_price" value="<?php echo $upd_ser_cust_pr;?>" ></div>

					<div class="txt_lable">Retail Price:</div>
					<div><input MAXLENGTH="5"  onkeypress="return numbersonly(event)" type="text" name="retail_service_price" value="<?php echo $upd_ser_ret_pr;?>" ></div>

					<div class="txt_lable">Duration:</div>
					<div><input type="text" name="duration" value="<?php echo $upd_ser_dur;?>" ></div>

					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Service Name</b></td>
														<td><b>Customer Price (INR)</b></td>
														<td><b>Retailer Price (INR)</b></td>
														<td><b>Duration (Hrs)</b></td>
														<td><b>Edit</b></td>
														<td><b>Delete</b></td>
													</tr>
											<?php
												$sql_countries_avail="SELECT DISTINCT(service_category) FROM `cust_kolors_services_list`";
												$query_countries_avail=mysql_query($sql_countries_avail);
												while($result_countries_avail=mysql_fetch_array($query_countries_avail)){
													$sql_ser="SELECT * FROM cust_kolors_services_list WHERE `service_category`='".$result_countries_avail['service_category']."' ";
													//echo $sql_ser;exit;
													$query_ser=mysql_query($sql_ser);
													echo '<tr bgcolor="#F2F5A9"><td colspan=6>'.$result_countries_avail['service_category'].'</td></tr>';
													while($result_ser=mysql_fetch_array($query_ser)){
														if($result_ser['status']==0){
															$tr_color="#F6D8CE";
														}else{
															$tr_color="#FFFFFF";
														} 
														
														echo '<tr bgcolor="'.$tr_color.'">
																	<td style="width:350px;;">'.$result_ser['service_name'].'</td>
																	<td style="width:90px;">'.$result_ser['customer_price'].'</td>
																	<td style="width:90px;">'.$result_ser['retail_price'].'</td>
																	<td style="width:90px;">'.$result_ser['duration'].'</td>
																	<td><a href="./add-services.php?mode=edit&ser_id='.$result_ser['service_id'].'"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
																	<td><a href="./add-services.php?mode=del&ser_id='.$result_ser['service_id'].'"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
															 </tr>';
													}
												}
												
											?>
												</table>
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