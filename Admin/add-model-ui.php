<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">
<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';

$btn_value=" Add Model ";
$btn_name="submit";
if(isset($_REQUEST['submit'])){ //When form Submits
		$model_name=$_REQUEST['model_name'];
		$company_id=$_REQUEST['company_id'];
		$model_no=$_REQUEST['model_no'];

		//Inserting Data
		$sql_ins="INSERT INTO `adm_ph_models`(`company_id`,`model_no`,`model_name`, `added_date`,`status`) VALUES 
		($company_id,'".$model_no."','".$model_name."',NOW(),1)";
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Model Added Succesfully..</font>";
		}else{
			$mess="Failed to Add..";
		}
} 
if(isset($_REQUEST['update'])){ //When Edit form submits
		
		//print('<pre>');print_r($_REQUEST);exit;
		
		$model_id_hidden_upd=$_REQUEST['hidden_mod_id'];
		$model_no_edit=$_REQUEST['model_no'];
		$model_name_edit=$_REQUEST['model_name'];
		$company_id_edit=$_REQUEST['company_id'];
		
		
		$sql_upd="	UPDATE `adm_ph_models` SET 
							`company_id`='".$company_id_edit."',		
							`model_no`='".$model_no_edit."',		
							`model_name`='".$model_name_edit."'							
					WHERE 	`mod_id`=".$model_id_hidden_upd;
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font color='#fff'>Model Updated Succesfully..</font>";
		}else{
			$mess="Failed to Update..";
		}
}
if(isset($_REQUEST['mode'])){
	$mod_id=$_REQUEST['mod_id'];
	
	if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
		$sql_upd_model="SELECT * FROM `adm_ph_models` WHERE `mod_id`=".$mod_id;
		$query_upd_model=mysql_query($sql_upd_model);
		$result_upd_model=mysql_fetch_array($query_upd_model);
		
		$upd_model_id=$result_upd_model['mod_id'];
		$upd_model_name=$result_upd_model['model_name'];
		$upd_model_no=$result_upd_model['model_no'];
		$upd_company_id=$result_upd_model['company_id'];

		$btn_value=" UPDATE ";
		$btn_name="update";
		
		
	}else if($_REQUEST['mode']=='del'){ // Action Delete
		$sql_disable_model_id="UPDATE `adm_ph_models` SET `status`='0' WHERE mod_id=".$mod_id;
		$query_disable_model_id=mysql_query($sql_disable_model_id);
		if($query_disable_model_id){
			$mess="Product Model Disabled Succesfully..";
		}else{
			$mess="Failed to Disable..";
		}
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
                                    <h4 class="mb-sm-0">Add Product Model</h4>

                                </div>
                            </div>
							<div style="color:green" class="page_title_div"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                <div class="card">
                    <div class="card-body">
                           
                    <form name="model_add" class="col-md-4" method="post" action="./add-model-ui.php" onsubmit="return validate()">
					<div class="txt_lable">Company:</div>
					<div>
						<select name="company_id" class="form-select">
													<option value="">-- SELECT --</option>
													<?php
														$sql_cp_names="SELECT * FROM `adm_companies` WHERE `status`=1";
														$query_cp_names=mysql_query($sql_cp_names);
														while($result_cp_names=mysql_fetch_array($query_cp_names)){
														if($upd_company_id==$result_cp_names['cp_id']){
														echo '<option value="'.$result_cp_names['cp_id'].'" selected>'.$result_cp_names['company_name'].'</option>';
														}else{
														echo '<option value="'.$result_cp_names['cp_id'].'">'.$result_cp_names['company_name'].'</option>';
														}
															
														}
													?>
													</select>
					</div>
					<div class="txt_lable">Model No:</div>
					<input type="hidden" name="hidden_mod_id" value="<?php echo $upd_model_id;?>">
					
					<div><input type="text" class="form-control" name="model_no" value="<?php echo $upd_model_no;?>" ></div>
					<div class="txt_lable">Model Name:</div>
					<div><input type="text" class="form-control" name="model_name" value="<?php echo $upd_model_name;?>" ></div>

					<div class="submit_button_div mt-2"><input class="btn btn-primary" type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>	
                    
                    </div>
                </div>
		    </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                           
                    <table class="order_hisory_table table table-bordered">
													<tr class="table_heading">
														<td><b>Model ID</b></td>
														<td><b>Company Name</b></td>
														<td><b>Model No</b></td>
														<td><b>Model Name</b></td>
														<td><b>Added Date</b></td>
														<td><b>Status</b></td>
														<td><b>Edit</b></td>
														<td><b>Delete</b></td>
													</tr>
											<?php
												//$sql_com="SELECT a.mod_id,(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												$sql_com="SELECT a.mod_id,a.company_id,a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print_r($result_com);
												
												$sql_get_company_name="SELECT company_name FROM adm_companies WHERE cp_id=".$result_com['company_id'];
												$query_get_company_name=mysql_query($sql_get_company_name);
												$result_get_company_name=mysql_fetch_array($query_get_company_name);
												//print_r($result_get_company_name);
													echo '<tr>
															<td>'.$result_com['mod_id'].'</td>
															<td>'.$result_get_company_name['company_name'].'</td>
															<td>'.$result_com['model_no'].'</td>
															<td>'.$result_com['model_name'].'</td>
															<td>'.$result_com['added_date'].'</td>
															<td>'.$result_com['status'].'</td>
															<td><a class="btn btn-info btn-sm" href="./add-model-ui.php?mode=edit&mod_id='.$result_com['mod_id'].'">Edit</a></td>
															<td><a class="btn btn-danger btn-sm" href="./add-model-ui.php?mode=del&mod_id='.$result_com['mod_id'].'">Delete</a></td>
													</tr>';
												}
											?>
												</table>
                            
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
				if (document.model_add.model_no.value == "")
                {
                    document.model_add.model_no.focus();
                    alert("Enter Model Number");
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
    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>