<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){

if($_SESSION['session_username']=='superadmin'){
    
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$mess='';
if(isset($_REQUEST['submit'])){ //When form Submits
    //print_r($_REQUEST);
    $admin_user_name=$_REQUEST['admin_user_name'];
    $subscription_plan=$_REQUEST['subscription_plan'];
    $payment_transaction_no=$_REQUEST['payment_transaction_no'];
    
    $sql_admin_plan="UPDATE `cust_kolors_users_list` SET 
                        `status`='1',
                        `subscription_plan`='".$subscription_plan."',
                        `payment_transaction_no`='".$payment_transaction_no."',
                        `subscription_date`=NOW(),
                        `last_update_date`=NOW()
                        WHERE username=".$admin_user_name;
   //echo $sql_admin_plan; exit;
   $query_admin_plan=mysql_query($sql_admin_plan);
   
   if($query_admin_plan){
       $sql_get_admin_id="SELECT `user_id` FROM `cust_kolors_users_list` WHERE `username`=".$admin_user_name;
       $query_get_admin_id=mysql_query($sql_get_admin_id);
       $result_get_admin_id=mysql_fetch_array($query_get_admin_id);
       $admin_user_id=$result_get_admin_id['user_id'];
       
        $sql_upd_plan_staff="UPDATE `cust_kolors_users_list` SET
                                        `subscription_plan`='".$subscription_plan."',
                                        `payment_transaction_no`='".$payment_transaction_no."',
                                        `subscription_date`=NOW(),
                                        `last_update_date`=NOW()
                                        WHERE admin_id=".$admin_user_id;
        $query_upd_plan_staff=mysql_query($sql_upd_plan_staff);
        
        $mess="</h1><h1 style='color:green'>Message: Subscription Details Updated Successfully..<h1></font>"; 
        
        $sql_update_subscription_history="INSERT INTO `subscription_plan_history`(`store_username`, `subscription_plan`, `payment_transaction_no`, `start_date`, `added_date`) VALUES 
        ('".$admin_user_name."','".$subscription_plan."','".$payment_transaction_no."',NOW(),NOW()) ";
        //echo $sql_update_subscription_history;         exit;
        $query_update_subscription_history=mysql_query($sql_update_subscription_history);
        
   }else{
    $mess="<h1 style='color:red'>Message: Failed to Add Subscription Details..<h1></font>";   
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
			<div class="page_title_div"><h1 style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:20px;">Welcome <?php echo $_SESSION['session_staff_name'];?>,</h1></div>
            <?php
            if($_SESSION['session_user_role']=='admin'){
            ?>
            <div class="page_title_div">
                <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">Subscription Plan: <?php echo ucfirst($subscription_plan); ?> <span style="color:#F5D149">&#10041;</span> </span>
		        <span style="font-family: 'Trebuchet MS', sans-serif; font-weight:bold;font-size:17px; color:#0F08D8">Ends on: <?php echo $subscription_end_date; ?> <span style="color:#F5D149">&#10041;</span> <?php echo $days_left?></span>
			</div>
			<?php
            }
            ?>
			<div class="content_holder">
				<!--<?php
					$sql_inprocess="SELECT COUNT(order_id) as inp_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=3";
					$query_inprocess=mysql_query($sql_inprocess);
					$result_inprocess=mysql_fetch_array($query_inprocess);

					$sql_completed="SELECT COUNT(order_id) as cmp_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=4";
					$query_completed=mysql_query($sql_completed);
					$result_completed=mysql_fetch_array($query_completed);
					
					$sql_rej="SELECT COUNT(order_id) as rj_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=2";
					$query_rej=mysql_query($sql_rej);
					$result_rej=mysql_fetch_array($query_rej);
					?>
				<div style="color:red; font-size:16px; padding:10px;">Order Summary</div>
				<div style="color:blue; font-size:13px; padding:10px;">&nbsp;&nbsp;&nbsp;In Process Orders - <?php echo $result_inprocess['inp_count'];?></div>
				<div style="color:green; font-size:13px; padding:10px;">&nbsp;&nbsp;Completed Orders - <?php echo $result_completed['cmp_count'];?></div>
				<div style="color:red; font-size:13px; padding:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rejected Orders - <?php echo $result_rej['rj_count'];?></div> -->


				<?php
					$sql_all="SELECT COUNT(entry_id) as all_order_count FROM `adm_cust_mob_add` where `store_id`='".$session_store_id."' AND `delete_status`='0'";
					$query_all=mysql_query($sql_all);
					$result_all=mysql_fetch_array($query_all);
			
					$sql_inprocess="SELECT COUNT(entry_id) as pend_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `status`='Pending' AND `delete_status`='0'";
					$query_inprocess=mysql_query($sql_inprocess);
					$result_inprocess=mysql_fetch_array($query_inprocess);

					$sql_completed="SELECT COUNT(entry_id) as cmp_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `status`='Completed' AND `delete_status`='0'";
					$query_completed=mysql_query($sql_completed);
					$result_completed=mysql_fetch_array($query_completed);
					
					$sql_rej="SELECT COUNT(entry_id) as rj_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `rejected`='1' AND `delete_status`='0'";
					$query_rej=mysql_query($sql_rej);
					$result_rej=mysql_fetch_array($query_rej);
					
					$sql_del="SELECT COUNT(entry_id) as del_count FROM  `adm_cust_mob_add` WHERE `store_id`='".$session_store_id."' AND `status`='Delivered'";
					$query_del=mysql_query($sql_del);
					$result_del=mysql_fetch_array($query_del);
					?>
					
					
                <div class="page_title_div"><h1>ACTIVATE PLANS TO ADMIN USERS</h1></div>
				<div class="content_holder">
                <div><?php echo $mess;?></div><br>
				<form name="admin_plans" method="post" action="./activate-plans.php">
				    <table>
				        <tr>
				            <td>SELECT ADMIN USER&nbsp;&nbsp;:&nbsp;&nbsp;</td>
				            <?php
				                $sql_get_admin="SELECT * FROM `cust_kolors_users_list` WHERE `user_role`='admin' ";
				                $query_get_admin=mysql_query($sql_get_admin);
				                echo "<td><select required name='admin_user_name'>";
						        echo "<option value=''> -- SELECT --</option>";
						        while($result_get_admin=mysql_fetch_array($query_get_admin)){ 
								    echo "<option value=".$result_get_admin['username'].">".$result_get_admin['username']." - ".$result_get_admin['staff_name']." - ".$result_get_admin['store_name']." - ( Plan ".$result_get_admin['subscription_plan']." )</option>";
						        }
						        echo "</select></td>";
				            ?>
				        </tr>
				        <tr><td>&nbsp;</td></tr>
				        <tr>
				            <td>SELECT PLAN&nbsp;&nbsp;:&nbsp;&nbsp;</td>
				            <td>
				            <select required name="subscription_plan" id="cars">
                                <option value="">--SELECT--</option>
                                <option value="trail">Trail</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="halfyearly">Half Yearly</option>
                                <option value="annual">Yearly</option>
                            </select>
				            </td>
				        </tr>
				        <tr><td>&nbsp;</td></tr>
				        <tr>
				            <td>Payment Reference&nbsp;&nbsp;:&nbsp;&nbsp;</td>
				            <td><input required type=text name="payment_transaction_no" value="" ></td>
				        </tr>
				        <tr><td>&nbsp;</td></tr>
				        <tr><td>&nbsp;</td><td><input type="submit" name="submit" value="ADD SUBSCRIPTION"></td></tr>
				    </table>
				</form>
				

												
							
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