<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$session_store_name=$_SESSION['session_store_name'];
//print_r($_SESSION);
include("./dbconnect.php");
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
<html>
<head>
            <link rel="icon" type="image/x-icon" href="./css/favicon1.jpeg">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
            // Form validation code for SIGN UP
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
	<!-- Script for preventing reload submit entry-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
	<div class="header">
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $session_store_name;?></span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		<div style="float:right; font-family: 'Trebuchet MS', sans-serif; font-weight:bold; font-size:17px; color:#ECFA12; padding-right:15px; padding-top:10px;" ><?php echo $_SESSION['session_staff_name'];?> (<?php echo $_SESSION['session_user_role']?>)</div>
	</div>
	
	<div class="main_container">
			<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>ADD DEFECT</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add Defect &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">

				<form name="model_add" method="post" action="./add-defect.php" onsubmit="return validate()">
					<input type="hidden" name="defeci_id_hidden" value="<?php echo $defect_id; ?>">
					<div class="txt_lable">Defect Name:</div>
					<div><input type="text" name="defect_name" value="<?php echo $upd_model_name; ?>" maxlength=25>&nbsp;&nbsp;Max Length is 25 Characters only.</div>

					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>

				<br><br>
				<?php			
				if($_SESSION['session_user_role'] =='admin'){
				?>
				<b>CUSTOM DEFECTS</b>
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Defect ID</b></td>
														<td><b>Defect Name</b></td>
														<td><b>Edit</b></td>
														<td><b>Del</b></td>
														
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
															<td><a href="./add-defect.php?mode=edit&defect_id='.$result_com1["defect_id"].'"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
															<td><a href="./add-defect.php?mode=del&defect_id='.$result_com1["defect_id"].'"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
															
													</tr>';

												}
											?>
				</table>
				
				<br><br>
				<?php
				    $sql_get_pre_def="SELECT `use_preloaded_defects` FROM `stores` WHERE `store_id`=".$_SESSION['session_store_id'];
				    $query_get_pre_def=mysql_query($sql_get_pre_def);
		            $result_get_pre_def=mysql_fetch_array($query_get_pre_def);
		            
		            $use_custom_defects_value=$result_get_pre_def['use_preloaded_defects'];
		            //echo $use_custom_defects_value;
		            
				?>
				<!--<form name="use_custom_defects" method=post action="add-defect.php"><b>PRELOADED DEFECTS</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="use_custom_defects" name="use_custom_defects" value="yes" <?php echo $checked_button;?> onclick="this.form.submit()" ></form>-->
				
				<form name="use_custom_defects" method=post action="add-defect.php">
				    <b>PRE-LOADED DEFECTS</b>&nbsp;&nbsp;&nbsp;
				    <select name="use_custom_defects" onchange="this.form.submit()">
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
                </form>
                <?php
				}
				if($_SESSION['session_user_role'] =='superadmin'){
				    echo '<b>PRE-LOADED DEFECTS</b>&nbsp;&nbsp;&nbsp;';
				}
                ?>
				<br><br>
				<table class="order_hisory_table">
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
															<td><a href="./add-defect.php?mode=edit&defect_id='.$result_com["defect_id"].'"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
															<td><a href="./add-defect.php?mode=del&defect_id='.$result_com["defect_id"].'"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
															
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
	</div>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>