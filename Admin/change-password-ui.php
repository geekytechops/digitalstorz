<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">

<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$session_store_name=$_SESSION['session_store_name'];
if(isset($_REQUEST['submit'])){ //When form Submits
		$user_name=$_SESSION['session_username'];
		$old_passwd=$_REQUEST['current_passwd'];

		$new_password=$_REQUEST['new_passwd'];
		$hashed_password_new = password_hash($new_password,PASSWORD_DEFAULT);
		
		//echo $hashed_password_new;
		$sql1="SELECT * FROM `cust_kolors_users_list` WHERE username='".$user_name."'";
        //echo $sql1; exit;
		$query1=mysql_query($sql1);
		$result1=mysql_fetch_array($query1);

			$og_password=$result1['password'];
			$verify = password_verify($old_passwd, $og_password);
			if($verify){ // when old password Supplied and old password in DB are same
			//echo "passwords matched"; exit;
               $sql_upd="update cust_kolors_users_list set
                                `password`='".$hashed_password_new."'
                                 WHERE username='".$user_name."'";
               $query_upd=mysql_query($sql_upd);
               if($query_upd){ 
                   $mess="Password Updated Successfully..";
               }else{
                   $mess="Password Update Failed..";
               }
				
			}else{
			    $mess="Old Password is Not Correct..";	
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
                                    <h4 class="mb-sm-0">Change Password</h4>

                                </div>
                            </div>
                            <div class="content_holder_heading"> <?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
                <div class="row">
                    <div class="col-xl-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    
                                <form name="change_pass" method="post" action="./change-password.php" onsubmit="return validate()">
                                <table style="margin-left:30px">
                                    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter Current Password&nbsp;&nbsp;</td> <td><input type="password" name="current_passwd" class="form-control" value=""></td></tr>
                                    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Enter New Password&nbsp;&nbsp;</td> <td><input type="password" name="new_passwd" class="form-control" value=""></td></tr>
                                    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Re-Enter New Password&nbsp;&nbsp;</td> <td><input type="password" name="new_passwd1" class="form-control" value=""></td></tr>
                                    <tr><td>&nbsp;</td></td></tr>
                                    <tr><td>&nbsp;</td></td><td><input type="submit" class="btn btn-primary" name="submit" value="Change Password"></td></tr>
                                </table>
                                </form>
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
				if (document.change_pass.current_passwd.value == "")
                {
                    document.change_pass.current_passwd.focus();
                    alert("Enter Current Password..");
					return false;
                }
                if (document.change_pass.new_passwd.value == "")
                {
                    document.change_pass.new_passwd.focus();
                    alert("Enter New Password..");
					return false;
                }
                
                if (document.change_pass.new_passwd.value != ''){
                    if(document.change_pass.new_passwd.value.length < 8){
                        document.change_pass.new_passwd.focus();
                        alert("New Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                if (document.change_pass.new_passwd1.value == "")
                {
                    document.change_pass.new_passwd1.focus();
                    alert("Re-Enter New Password..");
					return false;
                }
                if (document.change_pass.new_passwd1.value != ''){
                    if(document.change_pass.new_passwd1.value.length < 8){
                        document.change_pass.new_passwd1.focus();
                        alert("Re Enter Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                if (document.change_pass.new_passwd.value != document.change_pass.new_passwd1.value){
                        document.change_pass.new_passwd1.focus();
                        alert("Passwords Do Not Match..");
                        return false;
                }
                
            }

</script>
    </body>
</html>
<?php
mysql_close($connection);

}//admin page Ends
else{
header('Location: ./index.php');
}