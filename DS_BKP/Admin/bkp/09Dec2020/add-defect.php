<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';

$btn_value=" Add Defect ";
$btn_name="submit";
if(isset($_REQUEST['submit'])){ //When form Submits
		$defect_name=$_REQUEST['defect_name'];

		//Inserting Data
		$sql_ins="INSERT INTO `adm_mobile_defects`(`defect_name`) VALUES ('".$defect_name."')";
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
</head>
<body>
	<div class="header">
		<!--&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services-->
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
			<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>ADD DEFECT</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add Defect &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="model_add" method="post" action="./add-defect.php" onsubmit="return validate()">
					
					<div class="txt_lable">Defect Name:</div>
					<div><input type="text" name="defect_name" value="" ></div>

					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Defect ID</b></td>
														<td><b>Defect Name</b></td>
														
													</tr>
											<?php
												//$sql_com="SELECT a.mod_id,(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												//$sql_com="SELECT a.mod_id,a.company_id,a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												$sql_com="SELECT * FROM `adm_mobile_defects` WHERE 1 ORDER BY defect_id DESC";
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print_r($result_com);
												
												//print_r($result_get_company_name);
													echo '<tr>
															<td>'.$result_com['defect_id'].'</td>
															<td>'.$result_com['defect_name'].'</td>
															
															
													</tr>';
													
													//echo '<td><a href="./add-model.php?mode=edit&mod_id='.$result_com['mod_id'].'"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>';
															//echo '<td><a href="./add-model.php?mode=del&mod_id='.$result_com['mod_id'].'"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>';
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