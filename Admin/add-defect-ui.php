<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">

<?php

$mess='';
$upd_ser_id='';
$upd_ser_name='';
$defect_id='';
$btn_value=" Add Defect ";
$btn_name="submit";
//print_r($_REQUEST);

if(isset($_REQUEST['use_custom_defects'])){ //When Preloaded Defects check box submits
//echo $_REQUEST['use_custom_defects'];exit;
    if($_REQUEST['use_custom_defects']=="yes"){
        $use_custom_defects=$_REQUEST['use_custom_defects'];
        $sql_upd_custom_defects="UPDATE `stores` SET `use_preloaded_defects`='yes' WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_upd_custom_defects=mysql_query($sql_upd_custom_defects);    
    }elseif($_REQUEST['use_custom_defects']=="no"){
        $use_custom_defects=$_REQUEST['use_custom_defects'];
        $sql_upd_custom_defects="UPDATE `stores` SET `use_preloaded_defects`='no' WHERE `store_id`=".$_SESSION['session_store_id'];
        $query_upd_custom_defects=mysql_query($sql_upd_custom_defects);        
    }

}
if(isset($_REQUEST['submit'])){ //When form Submits
		$defect_name=$_REQUEST['defect_name'];
        $store_id=$_SESSION['session_store_id'];
		//Inserting Data
		$sql_ins="INSERT INTO `adm_mobile_defects`(`defect_name`,`store_id`) VALUES ('".$defect_name."','".$store_id."')";
		//echo $sql_ins;exit;
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Defect Added Succesfully..</font>";
		}else{
			$mess="Failed to Add..";
		}
} 
if(isset($_REQUEST['update'])){ //When Edit form submits
		
		//print('<pre>');print_r($_REQUEST);exit;
		
		$defect_id_hidden_upd=$_REQUEST['defeci_id_hidden'];
		$defect_name_edit=$_REQUEST['defect_name'];
		
		$sql_upd="	UPDATE `adm_mobile_defects` SET 
							`defect_name`='".$defect_name_edit."'		
					WHERE 	`defect_id`=".$defect_id_hidden_upd;
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font color='#fff'>Defect Updated Succesfully..</font>";
		}else{
			$mess="Failed to Update Defect..";
		}
}
if(isset($_REQUEST['mode'])){
	$defect_id=$_REQUEST['defect_id'];
	
	if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
		$sql_upd_model="SELECT * FROM `adm_mobile_defects` WHERE `defect_id`=".$defect_id;
		$query_upd_model=mysql_query($sql_upd_model);
		$result_upd_model=mysql_fetch_array($query_upd_model);
		//echo $sql_upd_model; 		exit;
		$upd_model_id=$result_upd_model['$defect_id'];
		$upd_model_name=$result_upd_model['defect_name'];

		$btn_value=" UPDATE ";
		$btn_name="update";
		
		
	}else if($_REQUEST['mode']=='del'){ // Action Delete
	    $defect_id=$_REQUEST['defect_id'];
	    
	    $defect_used_check_sql="select * from adm_cust_mob_add where mobile_defect='".$defect_id."' OR mobile_defect_2='".$defect_id."' OR mobile_defect_3='".$defect_id."' OR mobile_defect_4='".$defect_id."'";
		$query_defect_used_check_sql=mysql_query($defect_used_check_sql);
		$defect_used_count=mysql_num_rows ( $query_defect_used_check_sql );
		//echo $defect_used_count;exit;
		if($defect_used_count){
		    $mess="This Defect is used in $defect_used_count Orders, can not be Deleted..";
		}else{
		 $sql_delete_defect_id="DELETE FROM `adm_mobile_defects` WHERE `defect_id`=".$defect_id;
		//echo $sql_delete_defect_id; 		exit;
		$query_delete_defect_id=mysql_query($sql_delete_defect_id);
		if($query_delete_defect_id){
			$mess="Defect Deleted Succesfully..";
		}else{
			$mess="Failed to Delete Defect..";
		}   
		}
		
		
	}
}
?>

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
                                    <h4 class="mb-sm-0">Add Defect</h4>

                                </div>
                            </div>
							<div style="color:green" class="page_title_div"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
            <div class="row">
                <div class="card">
                    <div class="card-body">
                            <div class="row">            
                                <form name="model_add" class="col-md-4" method="post" action="./add-defect-ui.php" onsubmit="return validate()">
                                    <input type="hidden" name="defeci_id_hidden" value="<?php echo $defect_id; ?>">
                                    <div class="txt_lable">Defect Name:</div>
                                    <div class="d-flex"><input type="text" name="defect_name" class="form-control" value="<?php echo $upd_model_name; ?>" maxlength=25><input class="btn btn-primary ms-2" type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>   
                                    <div>*Max Length is 25 Characters only.</div>                                 
                                </form>
                            </div>
				<br><br>
				<?php			
				if($_SESSION['session_user_role'] =='admin'){
				?>				
                </div></div>
                <div class="card">
                <div class="card-body">
                <p class="card-title">CUSTOM DEFECTS</p>
				<table class="table table-bordered order_hisory_table">
													<tr class="table_heading">
														<td><b>Defect ID</b></td>
														<td><b>Defect Name</b></td>
														<td><b>Edit</b></td>
														<td><b>Delete</b></td>
														
													</tr>
											<?php
												//$sql_com="SELECT a.mod_id,(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												//$sql_com="SELECT a.mod_id,a.company_id,a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												$sql_com1="SELECT * FROM `adm_mobile_defects` WHERE `store_id`=".$_SESSION['session_store_id']."  ORDER BY defect_id DESC";
												$query_com1=mysql_query($sql_com1);
												while($result_com1=mysql_fetch_array($query_com1)){
												//print_r($result_com);
												
												//print_r($result_get_company_name);
													echo '<tr>
															<td>'.$result_com1['defect_id'].'</td>
															<td>'.$result_com1['defect_name'].'</td>
															<td><a href="./add-defect-ui.php?mode=edit&defect_id='.$result_com1["defect_id"].'" class="btn btn-outline-success">Edit</a></td>
															<td><a href="./add-defect-ui.php?mode=del&defect_id='.$result_com1["defect_id"].'" class="btn btn-outline-danger">Delete</a></td>
															
													</tr>';

												}
											?>
				</table>
				
				<br><br>
                </div>
                </div>
                <div class="card">
                <div class="card-body">
				<?php
				    $sql_get_pre_def="SELECT `use_preloaded_defects` FROM `stores` WHERE `store_id`=".$_SESSION['session_store_id'];
				    $query_get_pre_def=mysql_query($sql_get_pre_def);
		            $result_get_pre_def=mysql_fetch_array($query_get_pre_def);
		            
		            $use_custom_defects_value=$result_get_pre_def['use_preloaded_defects'];
		            //echo $use_custom_defects_value;
		            
				?>
				<!--<form name="use_custom_defects" method=post action="add-defect-ui.php"><b>PRELOADED DEFECTS</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="use_custom_defects" name="use_custom_defects" value="yes" <?php echo $checked_button;?> onclick="this.form.submit()" ></form>-->
				
				<form name="use_custom_defects" class="row g-0" method=post action="add-defect-ui.php">				    
				    <div class="col-md-4 d-flex align-items-center">
                    <b class="w-50">PRE-LOADED DEFECTS</b>    
                    <select name="use_custom_defects" class="form-select" onchange="this.form.submit()">
				        <?php
				        if ($use_custom_defects_value=='yes'){
				        ?>
				        <option value="yes" selected>I Want to Use</option>
                        <option value="no">I Dont Want</option>
				        <?php
				        }elseif($use_custom_defects_value=='no'){
				        ?>
				        <option value="yes">I Want to Use</option>
                        <option value="no" selected>I Dont Want</option>
				        <?php
				        }
				        ?>
                        
                    </select>
                    </div>
                </form>
                <?php
				}
				if($_SESSION['session_user_role'] =='superadmin'){
				    echo '<b>PRE-LOADED DEFECTS</b>&nbsp;&nbsp;&nbsp;';
				}
                ?>
				<br><br>
				<table class="table table-bordered">
				                            <?php
				                            if($_SESSION['session_username'] =='superadmin'){
				                            ?>
													<tr class="table_heading">
														<td><b>Defect ID</b></td>
														<td><b>Defect Name</b></td>
														<td><b>Edit</b></td>
														<td><b>Del</b></td>
														
													</tr>
											<?php
				                            }else{
											?>
											<tr class="table_heading">
														<td><b>Defect ID</b></td>
														<td><b>Defect Name</b></td>
													</tr>
											<?php
				                            }
											?>
											<?php
												//$sql_com="SELECT a.mod_id,(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												//$sql_com="SELECT a.mod_id,a.company_id,a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												$sql_com="SELECT * FROM `adm_mobile_defects` WHERE `default_defect`='yes' ORDER BY defect_id DESC";
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print_r($result_com);
												
												//print_r($result_get_company_name);
													if($_SESSION['session_username'] =='superadmin'){
													echo '<tr>
															<td>'.$result_com['defect_id'].'</td>
															<td>'.$result_com['defect_name'].'</td>
															<td><a href="./add-defect-ui.php?mode=edit&defect_id='.$result_com["defect_id"].'" class="btn btn-outline-success">Edit</a></td>
															<td><a href="./add-defect-ui.php?mode=del&defect_id='.$result_com["defect_id"].'" class="btn btn-outline-danger">Delete</a></td>
															
													</tr>';   
													}else{
													echo '<tr>
															<td>'.$result_com['defect_id'].'</td>
															<td>'.$result_com['defect_name'].'</td>
					
															
													</tr>';    
													}
													

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
				if (document.model_add.defect_name.value == "")
                {
                    document.model_add.defect_name.focus();
                    alert("Enter Dfeect Name");
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
