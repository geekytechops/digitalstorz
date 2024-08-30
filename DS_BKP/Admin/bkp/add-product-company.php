<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';

$btn_value=" Add Company ";
$btn_name="submit";
if(isset($_REQUEST['submit'])){ //When form Submits
		$company_name=$_REQUEST['company_name'];

		//Inserting Data
		$sql_ins="INSERT INTO `adm_companies`(`company_name`, `added_date`,`status`) VALUES 
		('".$company_name."',NOW(),1)";
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Company Added Succesfully..</font>";
		}else{
			$mess="Failed to Add..";
		}
} 
if(isset($_REQUEST['update'])){ //When Edit form submits
		
		//print('<pre>');print_r($_REQUEST);exit;
		
		$cp_id_hidden_upd=$_REQUEST['hidden_cp_id'];
		$cp_name_edit=$_REQUEST['company_name'];
		
		
		$sql_upd="	UPDATE `adm_companies` SET  
							`company_name`='".$cp_name_edit."'							
					WHERE 	`cp_id`=".$cp_id_hidden_upd;
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font color='#fff'>Company Updated Succesfully..</font>";
		}else{
			$mess="Failed to Update..";
		}
}
if(isset($_REQUEST['mode'])){
	$cp_id_ed=$_REQUEST['cp_id'];
	
	if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
		$sql_upd_cp="SELECT * FROM `adm_companies` WHERE `cp_id`=".$cp_id_ed;
		$query_upd_cp=mysql_query($sql_upd_cp);
		$result_upd_cp=mysql_fetch_array($query_upd_cp);
		
		$upd_cp_id=$result_upd_cp['cp_id'];
		$upd_cp_name=$result_upd_cp['company_name'];

		$btn_value=" UPDATE ";
		$btn_name="update";
		
		
	}else if($_REQUEST['mode']=='del'){ // Action Delete
		$sql_disable_cp_id="UPDATE `adm_companies` SET `status`='0' WHERE cp_id=".$cp_id_ed;
		$query_disable_cp_id=mysql_query($sql_disable_cp_id);
		if($query_disable_cp_id){
			$mess="Product Company Disabled Succesfully..";
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
				if (document.company_add.company_name.value == "")
                {
                    document.company_add.company_name.focus();
                    alert("Enter Category Name");
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
		<?php include("products-menu.php");?>
		<div class="right_container">
			<div class="page_title_div"><h1>ADD PRODUCT COMPANY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add / Update Product Company &nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="company_add" method="post" action="./add-product-company.php" onsubmit="return validate()">
					<div class="txt_lable">Product Company Name:</div>
					<input type="hidden" name="hidden_cp_id" value="<?php echo $upd_cp_id;?>">
					<div><input type="text" name="company_name" value="<?php echo $upd_cp_name;?>" ></div>

					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Company ID</b></td>
														<td><b>Company Name</b></td>
														<td><b>Added Date</b></td>
														<td><b>Status</b></td>
														<td><b>Edit</b></td>
														<td><b>Delete</b></td>
													</tr>
											<?php
												$sql_com="SELECT * FROM `adm_companies` where status='1'";
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print_r($result_com);
													echo '<tr>
															<td>'.$result_com['cp_id'].'</td>
															<td>'.$result_com['company_name'].'</td>
															<td>'.$result_com['added_date'].'</td>
															<td>'.$result_com['status'].'</td>
															<td><a href="./add-product-company.php?mode=edit&cp_id='.$result_com['cp_id'].'"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
															<td><a href="./add-product-company.php?mode=del&cp_id='.$result_com['cp_id'].'"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
													</tr>';
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