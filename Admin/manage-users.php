<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'] )){
    //print_r($_SESSION);
    if(isset($_SESSION['session_user_role']) && $_SESSION['session_user_role'] == ('admin' || 'superadmin' )){
include("./dbconnect.php");
$btn_value="Create Account";
$head_value="Create New";
$btn_name="submit";
$transaction='legal';
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];


if(isset($_REQUEST['submit'])){ //When form Submits

$sql_check_users="SELECT * FROM `cust_kolors_users_list` where `store_id`=".$_SESSION['session_store_id']." AND `status`=1";
$query_check_users=mysql_query($sql_check_users);
$user_accounts_for_store=mysql_num_rows($query_check_users);

$sql_check_dates="SELECT * FROM `cust_kolors_users_list` where `username`=".$_SESSION['session_username']." AND `status`=1";
$query_check_dates=mysql_query($sql_check_dates);
$result_check_dates=mysql_fetch_array($query_check_dates);

$subscription_plan_upd=$result_check_dates['subscription_plan'];
$subscription_date_upd=$result_check_dates['subscription_date'];


//echo '-----------------'.$user_accounts_for_store;
    if($user_accounts_for_store <3){ //restricting 3 users per store
    
    $sql_check_username="SELECT * FROM `cust_kolors_users_list` where `username`=".$_REQUEST['store_user_name'];
    $query_check_username=mysql_query($sql_check_username);
    $user_account_count=mysql_num_rows($query_check_username);
    
    //echo $user_account_count; exit;
    if($user_account_count < 1 ){
    //print ('<pre>'); print_r($_REQUEST);exit;
    $user_role="staff";
	$store_user_name=$_REQUEST['store_user_name'];
	$staff_name=$_REQUEST['staff_name'];
	$store_passwd=$_REQUEST['store_passwd'];
	$hashed_password = password_hash($store_passwd,PASSWORD_DEFAULT); //encrypting password
	$store_reenter_passwd=$_REQUEST['store_reenter_passwd'];
	$staff_dob=$_REQUEST['staff_dob'];
	$staff_mobile=$store_user_name;
	$staff_email=$_REQUEST['staff_email'];
	$staff_residence=$_REQUEST['staff_residence'];
	$store_id=$_SESSION['session_store_id'];
	$admin_id=$_SESSION['session_user_id'];
	$store_name=$_SESSION['session_store_name'];
	$subscription_plan_upd_staff=$subscription_plan_upd;
	$subscription_date_upd_staff=$subscription_date_upd;
		
	$sql_ins="INSERT INTO `cust_kolors_users_list`(`user_role`,`store_id`,`store_name`,`admin_id`, `username`, `password`, `staff_name`, `staff_dob`, `staff_mobile`, `staff_email`, `staff_residence`, `status`, `subscription_plan`,`subscription_date`,`add_date`) VALUES 
	('".$user_role."','".$store_id."','".$store_name."','".$admin_id."','".$store_user_name."','".$hashed_password."','".$staff_name."','".$staff_dob."','".$staff_mobile."','".$staff_email."','".$staff_residence."',1, '".$subscription_plan_upd_staff."', '".$subscription_date_upd_staff."',NOW())";
   //echo $sql_ins;exit;
    $query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>User Created Succesfully..<h1></font>";
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Failed to Add User..<h1>";
		}
    }else{
        $mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>User Already Exists..<h1>";
    }
    }else{
        $mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>You Can Not add More than 3 users per store. If you want to add another user, please disable one of the staff user.<h1>";
    }
    
} 

if(isset($_REQUEST['update'])){ //When form Submits
    //print_r($_REQUEST);exit;

    $staff_name=$_REQUEST['staff_name'];
    $staff_dob=$_REQUEST['staff_dob'];
    $staff_mobile=$_REQUEST['staff_mobile'];
    $staff_email=$_REQUEST['staff_email'];
    $staff_residence=$_REQUEST['staff_residence'];
    $user_id_for_update=$_REQUEST['user_id_for_update'];
    $store_passwd=$_REQUEST['store_passwd'];
    if($store_passwd !=''){
        if(strlen($store_passwd) >= 8){
            $hashed_password = password_hash($store_passwd,PASSWORD_DEFAULT); //encrypting password
        $sql_update_user_data="UPDATE `cust_kolors_users_list` SET 
        `staff_name`='".$staff_name."',
        `password`='".$hashed_password."',
        `staff_dob`='".$staff_dob."',
        `staff_mobile`='".$staff_mobile."',
        `staff_email`='".$staff_email."',
        `staff_residence`='".$staff_residence."',
        `last_update_date`=now() WHERE user_id=".$user_id_for_update;
        }else{
            $mess1="<h1 style='color:red'>Message: </h1><h1 style='color:green'> Password Length is less than 8 characters.<h1>";
        }
        
    }else{
        $sql_update_user_data="UPDATE `cust_kolors_users_list` SET 
        `staff_name`='".$staff_name."',
        `staff_dob`='".$staff_dob."',
        `staff_mobile`='".$staff_mobile."',
        `staff_email`='".$staff_email."',
        `staff_residence`='".$staff_residence."',
        `last_update_date`=now() WHERE user_id=".$user_id_for_update;
    }
    //echo $sql_update_user_data;     echo $mess;     exit;
    
    
    //echo $sql_update_user_data;exit;
    $query_update_user_data=mysql_query($sql_update_user_data);
		if($query_update_user_data){ 
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>User Updated Succesfully..<h1>";
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Failed to Update User..<h1>";
		}
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit'){
    $user_id_upd=$_REQUEST['user_id'];
    $sql_get_details="SELECT * FROM cust_kolors_users_list WHERE user_id=".$user_id_upd." AND store_id=".$session_store_id;
    //echo $sql_get_details;
    $query_get_details=mysql_query($sql_get_details);
    $rowcount = mysql_num_rows( $query_get_details );
    if($rowcount==0){
        $transaction='illegal';
    }
    $result_get_details=mysql_fetch_array($query_get_details);
    $btn_value="Update User Entry";
    $head_value="Update ";
    $btn_name="update";
}

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='disable'){
    $user_id_upd=$_REQUEST['user_id'];
    $sql_delete_user="UPDATE `cust_kolors_users_list` SET `status`=0 WHERE user_id=".$user_id_upd;
    $query_delete_user=mysql_query($sql_delete_user);
    if($query_delete_user){ 
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>User Disabled Succesfully..</h1>";
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Failed to Disable User..</h1>";
		}
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='enable'){
    $user_id_upd=$_REQUEST['user_id'];
    
    $sql_check_users="SELECT * FROM `cust_kolors_users_list` where `store_id`=".$_SESSION['session_store_id']." AND `status`=1";
    $query_check_users=mysql_query($sql_check_users);
    $user_accounts_for_store=mysql_num_rows($query_check_users);
    //echo '-----------------'.$user_accounts_for_store;
    if($user_accounts_for_store <3){ //restricting 3 users per store
    
    $sql_enable_user="UPDATE `cust_kolors_users_list` SET `status`=1 WHERE user_id=".$user_id_upd;
    $query_enable_user=mysql_query($sql_enable_user);
    if($query_enable_user){ 
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>User Enabled Succesfully..</h1>";
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Failed to Enable User..<h1>";
		}
    }else{
        $mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>You Can Not Have More than 3 Active users per store. Please disable one of the staff user and try again.</h1>";
    }
    
}

?>
<html>
<head>
            <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

				if (document.create_user.store_user_name.value == "")
                {
                    document.create_user.store_user_name.focus();
                    alert("Enter User Name..");
					return false;
                }
                if (document.create_user.staff_name.value == "")
                {
                    document.create_user.staff_name.focus();
                    alert("Enter Staff Name..");
					return false;
                }
                if (document.create_user.store_passwd.value == "")
                {
                    document.create_user.store_passwd.focus();
                    alert("Enter New Password..");
					return false;
                }
                
                if (document.create_user.store_passwd.value != ''){
                    if(document.create_user.store_passwd.value.length < 8){
                        document.create_user.store_passwd.focus();
                        alert("Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                if (document.create_user.store_reenter_passwd.value == "")
                {
                    document.create_user.store_reenter_passwd.focus();
                    alert("Re-Enter Password..");
					return false;
                }
                if (document.create_user.store_reenter_passwd.value != ''){
                    if(document.create_user.store_reenter_passwd.value.length < 8){
                        document.create_user.store_reenter_passwd.focus();
                        alert("Re Enter Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                
                if (document.create_user.store_passwd.value != document.create_user.store_reenter_passwd.value){
                        document.create_user.store_reenter_passwd.focus();
                        alert("Passwords Do Not Match..");
                        return false;
                }
                if (document.create_user.staff_mobile.value == "")
                {
                    document.create_user.staff_mobile.focus();
                    alert("Enter Staff Mobile Number..");
					return false;
                }
                if (document.create_user.staff_email.value == "")
                {
                    document.create_user.staff_email.focus();
                    alert("Enter Staff Email..");
					return false;
                }
                
            }

<!-- Script for preventing reload submit entry-->

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script type="text/javascript">
function numbersonly(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.create_user.staff_mobile.value < 10)
				return false //disable key press
				}
			}
function numbersonly1(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.create_user.store_user_name.value < 10)
				return false //disable key press
				}
			}

</script>

<script>
function ShowPassword() {
  var x = document.getElementById("store_passwd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function ShowPassword2() {
    
  var y = document.getElementById("store_reenter_passwd");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}
</script>


</head>
<body>
	<div class="header">
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
		    <div class="page_title_div"><h1>MANAGE STORE USERS</h1></div>
		    <div class="page_title_div"><?php echo $mess.' '.$mess1?></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;<?php echo $head_value?> User Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
				
				<div class="content_holder_body">
				    <?php
				      if($transaction=='legal'){
				    ?>
				    <form name="create_user" method="post" action="./manage-users.php" onsubmit="return validate()">
					<table style="margin-left:30px">
					    <input type="hidden" name="user_id_for_update" value="<?php echo $user_id_upd;?>">
					 <?php
					        if($_REQUEST['mode']!='edit'){
					    ?>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter User ID (Mobile Number)&nbsp;&nbsp;</td> <td><input type="number"  required name="store_user_name" id="store_user_name" value="<?php echo $result_get_details['username'];?>" maxlength=10 onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'" /></td><td style="color:red; font-size:17px;padding-left:15px;">&#x2731;</td></tr>
					     <?php
					        }
					    ?>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Staff Name&nbsp;&nbsp;</td> <td><input type="text" name="staff_name" required value="<?php echo $result_get_details['staff_name'];?>"></td><td style="color:red; font-size:17px;padding-left:15px;">&#x2731;</td></tr>
			
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter password&nbsp;&nbsp;</td> <td><input type="password" name="store_passwd"  required id="store_passwd"value=""></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td><td><input type="checkbox" onclick="ShowPassword()">Show Password</td></tr>
					    <?php
					        if($_REQUEST['mode']!='edit'){
					    ?>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Re-Enter Password&nbsp;&nbsp;</td> <td><input type="password" required name="store_reenter_passwd" id="store_reenter_passwd" value="" ></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td><td><input type="checkbox" onclick="ShowPassword2()">Show Password</td></tr>
			            <?php
					        }
					    ?>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Date of Birth&nbsp;&nbsp;</td> <td><input type="date" name="staff_dob"  value="<?php echo $result_get_details['staff_dob'];?>"></td></tr>
					    <!--<tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Staff Mobile Number&nbsp;&nbsp;</td> <td><input type="number" name="staff_mobile" required value="<?php echo $result_get_details['staff_mobile'];?>" maxlength=10 onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>-->
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Staff Email Address&nbsp;&nbsp;</td> <td><input type="email" name="staff_email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $result_get_details['staff_email'];?>"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Staff Residence Address&nbsp;&nbsp;</td> <td><input type="text" name="staff_residence" value="<?php echo $result_get_details['staff_residence'];?>"></td></tr>
					    <tr><td>&nbsp;</td></td></tr>
					    <tr><td>&nbsp;</td></td><td><input type="submit" name="<?php echo $btn_name?>" value="<?php echo $btn_value?>"></td></tr>
					</table>
					</form>
                    <?php
				      }elseif($transaction='illegal'){
				          echo "No Such User Found.";
				      }
                    ?>
					<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>User ID</b></td>
														<td><b>Role</b></td>
														<td><b>Store Id & Nme</b></td>
														<td><b>Current Plan</b></td>
														<td><b>Refered By</b></td>
														<td><b>Username</b></td>
														<td><b>Staff Name</b></td>
														<td><b>Mobile No</b></td>
														<td><b>Email</b></td>
														<td><b>Staff Address</b></td>
														<td><b>Store Address</b></td>
														<td><b>DOB</b></td>
														<td><b>Status</b></td>
														<td><b>Added Date</b></td>
														<td><b>Edit</b></td>
														<td><b>Disable </b></td>
														<td><b>Enable</b></td>

													</tr>
											<?php
											    if($_SESSION['session_user_role']=='superadmin'){
											        $sql_com="SELECT * FROM `cust_kolors_users_list` ORDER BY `user_id` ASC";
											    }elseif($_SESSION['session_user_role']=='admin'){
											       $sql_com="SELECT * FROM `cust_kolors_users_list` where `store_id`=".$_SESSION['session_store_id']." ORDER BY `user_id` DESC"; 
											    }
										
												//echo $sql_com;exit;
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print('<pre>');print_r($result_com);
												    if($result_com['status']=='1'){
												        $status="Active";
												    }else{
												        $status="Blocked";
												    }
												    
												    $sql_store_address="SELECT `store_address1`,`store_address2`,`referal_code` FROM stores WHERE store_id=".$result_com['store_id'];
												    $query_store_address=mysql_query($sql_store_address);
												    $result_store_address=mysql_fetch_array($query_store_address)
											?>
													<tr>
															<td><?php echo $result_com['user_id'];?></td>
															<td><?php echo $result_com['user_role'];?></td>
															<td><?php echo $result_com['store_id'].' - '.$result_com['store_name']  ?></td>
															<td><?php echo $result_com['subscription_plan'];?></td>
															<td><?php echo $result_store_address['referal_code']?></td>
															<td><?php echo $result_com['username'];?></td>
															<td><?php echo $result_com['staff_name'];?></td>
															<td><?php echo $result_com['staff_mobile'];?></td>
															<td><?php echo $result_com['staff_email'];?></td>
															<td><?php echo $result_com['staff_residence'];?></td>
															<td><?php echo $result_store_address['store_address1'].' ,'.$result_store_address['store_address2']?></td>
															<td><?php echo $result_com['staff_dob'];?></td>
															
															<td><?php echo $status;?></td>
															<td><?php echo $result_com['add_date'];?></td>
														<?php
														  if($result_com['status']=='1'){
														?>
															<td><a href="./manage-users.php?mode=edit&user_id=<?php echo $result_com['user_id']?>"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
															
															<?php
															if($result_com['user_role']!='admin'){
															?>
															<td><a href="./manage-users.php?mode=disable&user_id=<?php echo $result_com['user_id']?>"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
															<td>NA</td>
														<?php
															}
														  }
														  if($result_com['status']!='1'){
														?>	<td>NA</td>
														    <td>NA</td>
															<td><a href="./manage-users.php?mode=enable&user_id=<?php echo $result_com['user_id']?>"><img style="border:none; width:20px; height:20px;"src="./img/enable.png"/></a></td>
												        <?php } ?>
													</tr>
											<?php
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
    }else{
        echo "<div style='margin-left:auto; font-size:20px;margin-top:200px;text-align:center; margin-right:auto; color:red; font-weight:bold;'>You Are not authorized to see this page..</div>";
        echo "<div style='margin-left:auto; font-size:20px;text-align:center; margin-right:auto; color:red; font-weight:bold;'><a href='../Admin/admin-home.php'>Goto Home Page</a></div>";
    }
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>