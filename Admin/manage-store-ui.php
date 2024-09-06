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
$action='';
if(isset($_REQUEST['submit'])){
    //echo "here";exit;
    $store_name=$_REQUEST['store_name'];
    $store_contact=$_REQUEST['store_contact'];
    $store_address1=$_REQUEST['store_address1'];
    $store_address2=$_REQUEST['store_address2'];
    $store_gst_no=$_REQUEST['store_gst_no'];
    
    $sql_update_store_data="UPDATE `stores` SET 
        `store_contact`='".$store_contact."',
        `store_address1`='".$store_address1."',
        `store_address2`='".$store_address2."',
        `store_gst_no`='".$store_gst_no."',
        `last_update_date`=now() WHERE store_id=".$session_store_id;
    
    $query_update_store_data=mysql_query($sql_update_store_data);
		if($query_update_store_data){ 
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Store Details Updated Succesfully..<h1>";
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:red'>Failed to Update Store Details..<h1>";
		}
		
}

if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit'){
    $store_id_upd=$_REQUEST['store_id'];
    $action="edit";
    $sql_get_details="SELECT * FROM stores WHERE store_id=".$store_id_upd." AND admin_user=".$_SESSION['session_user_id'];
    //echo $sql_get_details;    exit;
    $query_get_details=mysql_query($sql_get_details);
    $rowcount = mysql_num_rows( $query_get_details );
    if($rowcount==0){
        $transaction='illegal';
    }
    $result_get_details=mysql_fetch_array($query_get_details);
    $note="Please note that these details will be displayed to customer in Printing invoice and SMS.";
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
                                    <h4 class="mb-sm-0">Manage Store</h4>

                                </div>
                            </div>
                            <div class="page_title_div"><?php echo $mess.' '.$mess1?></div>
                        </div>
                        <!-- end page title -->
                        
                <div class="row">
                    <div class="col-xl-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                <div class="card-title">&#8803;&nbsp;&nbsp;<?php echo $head_value?> User Account&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
                                <?php
				    if($action=='edit'){
				      if($transaction=='legal'){
				    ?>
				    <form name="create_user" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./manage-store-ui.php" onsubmit="return validate()">
				        <h6>*<?php echo $note; ?></h6><br>
					<table style="margin-left:30px">
					    <input type="hidden" name="user_id_for_update" value="<?php echo $user_id_upd;?>">
					 
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Name&nbsp;&nbsp;</td> <td><input type="text" disabled=yes name="store_name" class="form-control" value="<?php echo $result_get_details['store_name'];?>"></td><td style="color:red; font-size:12px;padding-left:15px;">Contact Admin for Store Name Change.</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Contact Number&nbsp;&nbsp;</td> <td><input class="form-control" type="number" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);" required name="store_contact" value="<?php echo $result_get_details['store_contact'];?>" ondrop="return false;" autocomplete="off" required required pattern="[0-9]{10}" maxlength='11' onkeypress="if(this.value.length==11) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Address Line 1&nbsp;&nbsp;</td> <td><input class="form-control" type="text" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);" required name="store_address1" value="<?php echo $result_get_details['store_address1'];?>"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Address Line 2&nbsp;&nbsp;</td> <td><input class="form-control" type="text" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);" required name="store_address2" value="<?php echo $result_get_details['store_address2'];?>"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store GST No&nbsp;&nbsp;</td> <td><input class="form-control" type="text" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);"  name="store_gst_no" value="<?php echo $result_get_details['store_gst_no'];?>"></td><td style="color:red; font-size:15px;padding-left:15px;"></td></tr>
					    <tr><td>&nbsp;</td></td></tr>
					    <tr><td>&nbsp;</td></td><td><input class="btn btn-primary" type="submit" name="submit" value="Update"></td></tr>
					</table>
					</form>
                    <?php
				        
				      }elseif($transaction='illegal'){
				          echo "<h1>Store Details Not Found.<h1>";
				      }
				    }
                    ?>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                <table class="order_hisory_table table table-bordered">
													<tr class="table_heading">
														<td><b>Store Id </b></td>
														<td><b>Store Name</b></td>
														<td><b>Store Contact</b></td>
														<td><b>Address Line1</b></td>
														<td><b>Address Line2</b></td>
														<td><b>Store GST No</b></td>
                                                        <td><b>Referred By</b></td>
                                                        <td><b>Store Added Date</b></td>
                                                        <td><b>Last Updated Date</b></td>
                                                        <td><b>Edit</b></td>
													</tr>
											<?php
                                                if($_SESSION['session_user_role']=='admin'){
											       $sql_com="SELECT * FROM `stores` where `store_id`=".$_SESSION['session_store_id']; 
											    }
										
												//echo $sql_com;exit;
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print('<pre>');print_r($result_com);
												    
											?>
													<tr>
															<td><?php echo $result_com['store_id'];?></td>
															<td><?php echo $result_com['store_name'];?></td>
															<td><?php echo $result_com['store_contact'];?></td>
															<td><?php echo $result_com['store_address1']?></td>
															<td><?php echo $result_com['store_address2']?></td>
															<td><?php echo $result_com['store_gst_no']?></td>
															<td><?php echo $result_com['referal_code']?></td>
															<td><?php echo $result_com['added_date'];?></td>
															<td><?php echo $result_com['last_update_date'];?></td>
															<td><a href="./manage-store-ui.php?mode=edit&store_id=<?php echo $result_com['store_id']?>"> EDIT </a></td>
															
													</tr>
											<?php
												}
											?>
												</table>
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


if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
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
    }else{
        echo "<div style='margin-left:auto; font-size:20px;margin-top:200px;text-align:center; margin-right:auto; color:red; font-weight:bold;'>You Are not authorized to see this page..</div>";
        echo "<div style='margin-left:auto; font-size:20px;text-align:center; margin-right:auto; color:red; font-weight:bold;'><a href='../Admin/admin-home.php'>Goto Home Page</a></div>";
    }
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>