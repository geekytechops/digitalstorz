<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
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
	$staff_salary=$_REQUEST['staff_salary'];
    $staff_salaryMain = preg_replace('/[^0-9.]/', '', $staff_salary);
	$startTime=$_REQUEST['startTime'];
	$endTime=$_REQUEST['endTime'];    
	$store_id=$_SESSION['session_store_id'];
	$admin_id=$_SESSION['session_user_id'];
	$store_name=$_SESSION['session_store_name'];
	$subscription_plan_upd_staff=$subscription_plan_upd;
	$subscription_date_upd_staff=$subscription_date_upd;
		
	$sql_ins="INSERT INTO `cust_kolors_users_list`(`user_role`,`store_id`,`store_name`,`admin_id`, `username`, `password`, `staff_name`, `staff_dob`, `staff_mobile`, `staff_email`, `staff_residence`, `status`, `subscription_plan`,`subscription_date`,`add_date`,`staff_currency`) VALUES 
	('".$user_role."','".$store_id."','".$store_name."','".$admin_id."','".$store_user_name."','".$hashed_password."','".$staff_name."','".$staff_dob."','".$staff_mobile."','".$staff_email."','".$staff_residence."',1, '".$subscription_plan_upd_staff."', '".$subscription_date_upd_staff."',NOW(),".$staff_salaryMain.")";
   //echo $sql_ins;exit;
    $query_ins=mysql_query($sql_ins);
    // echo mysql_error();
    // die;
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

if(isset($_GET['date'])){
    $dateTime = $_GET['date'];
}else{
    $dateTime = 0;
}

?>
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
                                    <h4 class="mb-sm-0">Mark Attendance</h4>

                                </div>
                            </div>
                            <div><h1><?php echo $mess; ?></h1></div>
                        </div>                       

                        <?php 
                        
                        if($dateTime==0){
                            $dateMain = date('Y-m-d');
                        }else{
                            $dateMain =$dateTime;
                        }

                        $countQuery = "SELECT 
  SUM(CASE WHEN staff_type = 1 THEN 1 ELSE 0 END) AS count_status_1,
  SUM(CASE WHEN staff_type = 2 THEN 1 ELSE 0 END) AS count_status_2
FROM 
  attendance WHERE att_date = '$dateMain' AND attendance=1";
                        $countQueryExec = mysql_query($countQuery);                        
                        $countQueryExecRes = mysql_fetch_array($countQueryExec);
                        ?>
                        
                        <div class="row">                    
                            <div class="col-xl-6 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div><strong>Staff Present</strong> : <?=$countQueryExecRes['count_status_1']?></div>
                                            <div><strong>Other Staff Present</strong> : <?=$countQueryExecRes['count_status_2']?></div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                <div class="row">                    
                    <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                
                                <div class="section-heading">
                                    <div>
                                        Staff
                                    </div>
                                    <div>
                                    <a class="btn btn-primary" href="manage-users-ui.php">Create Staff</a>
                                    </div>
                                </div>
                                <ul class="staff-list">
                                <?php
											    if($_SESSION['session_user_role']=='superadmin'){
											        $sql_com="SELECT * FROM `cust_kolors_users_list` ORDER BY `user_id` ASC";											        
											    }elseif($_SESSION['session_user_role']=='admin'){
											       $sql_com="SELECT * FROM `cust_kolors_users_list` where `store_id`=".$_SESSION['session_store_id']." ORDER BY `user_id` DESC"; 
											    }

                                                $sql_com2="SELECT * FROM `other_staff` WHERE status=0 ORDER BY `staff_id` ASC";
										
												$query_com=mysql_query($sql_com);
												$query_com2=mysql_query($sql_com2);
												while($result_com=mysql_fetch_array($query_com)){
                                                    $userId = $result_com['user_id'];
                                                    if($dateTime==0){
                                                        $today = date('Y-m-d');
                                                    }else{
                                                        $today = $dateTime;
                                                    }
                                                    
                                                   $attRec = "SELECT * FROM attendance WHERE att_staff_id = $userId AND staff_type = 1 AND att_date = '$today'";
                                                    $attRecExec=mysql_query($attRec);
                                                    $attRecExecRes=mysql_num_rows($attRecExec);

												    if($result_com['status']=='1'){
												        $status="Active";
												    }else{
												        $status="Blocked";
												    }
												    
												    $sql_store_address="SELECT `store_address1`,`store_address2`,`referal_code` FROM stores WHERE store_id=".$result_com['store_id'];
												    $query_store_address=mysql_query($sql_store_address);
												    $result_store_address=mysql_fetch_array($query_store_address);

                                                    if($result_com['user_role']!='admin'){
											?>
                                    <li><?php echo $result_com['staff_name'];?> <div>
                                        
                                   
                                    <?php if($attRecExecRes!=0){
                                        $attRecExecRows=mysql_fetch_array($attRecExec);
                                        if($attRecExecRows['attendance']==1){

                                        
                                     ?>
                                     <button class="btn btn-info" onclick="openAttendanceModal(<?php echo $attRecExecRows['att_id'];?>,1,'<?=$attRecExecRows['att_in_time']?>')">Edit Time</button>
                                    <?php 
                                   }else{
                                    ?>
                                     <button class="btn btn-danger" onclick="addAttendance(<?php echo $result_com['user_id'];?>,1,0)" disabled>Absent</button>


                                    <?php

                                   } }else{

                                        ?>
                                        
                                        <button class="btn btn-success" onclick="addAttendance(<?php echo $result_com['user_id'];?>,1,1)">Present</button> <button class="btn btn-danger" onclick="addAttendance(<?php echo $result_com['user_id'];?>,1,0)">Absent</button> 
                                        <?php
                                    }
                                     ?>
                                    </div> </li>
                                    <?php
												}}
											?>
                                </ul>

                                </div>
                            </div>                            
                    </div>
                    <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                
                                <div class="section-heading">

                                <div>
                                      Other  Staff
                                    </div>
                                    <div>
                                    <button class="btn btn-primary" onclick="openCreateStaff()">Create Staff</button>
                                    </div>

                                </div>
                                <ul class="staff-list">
                                <?php

                                                $sql_com2="SELECT * FROM `other_staff` WHERE status=0 ORDER BY `staff_id` ASC";
										
												$query_com2=mysql_query($sql_com2);
												while($result_com2=mysql_fetch_array($query_com2)){
                                                    $userId = $result_com2['staff_id'];
                                                    if($dateTime==0){
                                                        $today = date('Y-m-d');
                                                    }else{
                                                        $today = $dateTime;
                                                    }
                                                   $attRec = "SELECT * FROM attendance WHERE att_staff_id = $userId AND staff_type = 2 AND att_date = '$today'";
                                                    $attRecExec=mysql_query($attRec);
                                                    $attRecExecRes=mysql_num_rows($attRecExec);

												
											?>
                                    <li><?php echo $result_com2['staff_name'];?> <div>
                                        
                                   
                                    <?php if($attRecExecRes!=0){
                                        $attRecExecRows=mysql_fetch_array($attRecExec);
                                        if($attRecExecRows['attendance']==1){

                                        
                                     ?>
                                     <button class="btn btn-info" onclick="openAttendanceModal(<?php echo $attRecExecRows['att_id'];?>,2,'<?=$attRecExecRows['att_in_time']?>')">Edit Time</button>
                                    <?php 
                                   }else{
                                    ?>
                                     <button class="btn btn-danger" onclick="addAttendance(<?php echo $result_com2['staff_id'];?>,1,0)" disabled>Absent</button>


                                    <?php

                                   } }else{

                                        ?>
                                        
                                        <button class="btn btn-success" onclick="addAttendance(<?php echo $result_com2['staff_id'];?>,2,1)">Present</button> <button class="btn btn-danger" onclick="addAttendance(<?php echo $result_com2['staff_id'];?>,2,0)">Absent</button> 
                                        <?php
                                    }
                                     ?>
                                    </div> </li>
                                    <?php
												}
											?>
                                </ul>

                                </div>
                            </div>                            
                    </div>
                </div>
            
                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <input type="hidden" name="staff_id" id="staff_id">
                    <input type="hidden" name="att_id" id="att_id">
                    <input type="hidden" name="staff_type" id="staff_type">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Modal Heading</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form id="attendanceForm">
                            <div class="form-group">
                            <label for="startTime">Start Time</label>
                            <input type="time" class="form-control" id="startTime" value="<?=date('H:i')?>" required>
                            </div>
                            <div class="form-group">
                            <label for="endTime">End Time</label>
                            <input type="time" class="form-control" id="endTime" value="<?=date('H:i')?>" required>
                            </div>
                            <button type="button" class="btn btn-success mt-2" onclick="markAttendance()">Mark Attendance</button>
                        </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


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
 
 function openAttendanceModal(id , type,startTime) {
    $('#att_id').val(id);
    $('#staff_type').val(type);
    $('#startTime').val(startTime);
      document.getElementById('myModalLabel').textContent = 'Mark Attendance for ' + name;

      $('#myModal').modal('show');
    }

    function openCreateStaff() {
        $('#otherStaffModel').modal('show');      
    }

    // document.getElementById('attendanceForm').addEventListener('submit', function(event) {
    //   event.preventDefault();      
    //   $('#myModal').modal('hide');
    // });

    const markAttendance = () =>{
        let staffId =  $('#staff_id').val();
        let attId =  $('#att_id').val();
        let staffType = $('#staff_type').val();
        let startTime = $('#startTime').val();
        let endTime = $('#endTime').val();
        let dateTime = '<?php echo $dateTime; ?>';
        $.ajax({
            type:'post',
            url:'manage-update.php',
            data:{staffId:staffId,attId:attId, staffType:staffType , startTime: startTime ,endTime:endTime , dateTime:dateTime ,formName:'mark_attendance'  },
            success:function(data){

                $('.toast-success').css('left','unset');   
            $('.toast-success').css('right','2rem');
            $('.toast-success .toast-body').html(JSON.parse(data).message);
         setTimeout(() => {
             $('.toast-success').css('left','100%');   
             $('.toast-success').css('right','unset');   
         }, 2000);

                if(JSON.parse(data).status=='success'){
                    $('#myModal').modal('hide');
                }else{
                    $('#myModal').modal('hide');
                }
            }
        })
    }

    const addAttendance = (id , type , attendance) =>{
        let dateTime = '<?php echo $dateTime; ?>';
        $.ajax({
            type:'post',
            url:'manage-update.php',
            data:{staffId:id, staffType:type , dateTime:dateTime , attendance:attendance ,formName:'attendance'  },
            success:function(data){
                if(JSON.parse(data).status=='success'){
                    location.reload();
                }else{
                    location.reload();
                }
            }
        })
    }
</script>
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