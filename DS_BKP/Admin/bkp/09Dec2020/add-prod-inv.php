<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';

$btn_value=" Add ";
$btn_name="submit";

if(isset($_REQUEST['company_id'])){ 
$selected_cpid=$_REQUEST['company_id'];

}
if(isset($_REQUEST['submit'])){ //When form Submits
		$company_name=$_REQUEST['company_id'];
		$model_name=$_REQUEST['model_id'];
		$product_cat_id1=$_REQUEST['prod_cat_id'];
		$product_qty=$_REQUEST['inv_prod_qty'];
		$product_comments=$_REQUEST['inv_comments'];
		$product_act_pr=$_REQUEST['inv_prod_act_price'];
		$product_sale_pr=$_REQUEST['inv_prod_sale_price'];
		

		//Inserting Data
		
		$sql_ins="INSERT INTO `adm_prod_inv_cr_tran`(`company_id`, `model_id`, `prod_cat_id`, `inv_prod_qty`, `comments`, `added_date`,`actual_price`,`sale_price`) VALUES 
		('".$company_name."','".$model_name."','".$product_cat_id1."','".$product_qty."','".$product_comments."', NOW(),'".$product_act_pr."','".$product_sale_pr."')";
		//echo $sql_ins; exit;
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Product Added to Inventory..</font>";
			$barcode_str=mysql_insert_id();
			
			header('Location: ./barcode/index.php?barcode_str='.$barcode_str.'&qty='.$product_qty.''); 
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
		if (document.product_add_inv.company_id.value == "")
                {
                    document.product_add_inv.company_id.focus();
                    alert("Select Company Name");
					return false;
                }
                
                if (document.product_add_inv.model_id.value == "")
                {
                    document.product_add_inv.model_id.focus();
                    alert("Select Model Name");
					return false;
                }
                
                if (document.product_add_inv.prod_cat_id.value == "")
                {
                    document.product_add_inv.prod_cat_id.focus();
                    alert("Select Product Name");
					return false;
                }
                
                if (document.product_add_inv.inv_prod_qty.value == "")
                {
                    document.product_add_inv.inv_prod_qty.focus();
                    alert("Please Enter Product Quantity");
					return false;
                }
                if (document.product_add_inv.inv_prod_act_price.value == "")
                {
                    document.product_add_inv.inv_prod_act_price.focus();
                    alert("Please Enter Product Actual Price");
					return false;
                }
                if (document.product_add_inv.inv_prod_sale_price.value == "")
                {
                    document.product_add_inv.inv_prod_sale_price.focus();
                    alert("Please Enter Product Sale Price");
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
			
			
		function SelectRedirect(copany_id){
		window.location="./add-prod-inv.php?company_id="+copany_id;
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
			<div class="page_title_div"><h1>ADD PRODUCTS INVENTORY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Add Products to Inventory&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="product_add_inv" method="post" action="./add-prod-inv.php" onsubmit="return validate()">
				<table cellspacing="10">
				
					<tr>
					<td><div class="txt_lable">Company:</div>
					<div>
						<select name="company_id"  onChange="SelectRedirect(this.value);">
													<option value="">-- SELECT --</option>
													<?php
														$sql_cp_names="SELECT * FROM `adm_companies` WHERE `status`=1";
														$query_cp_names=mysql_query($sql_cp_names);
														while($result_cp_names=mysql_fetch_array($query_cp_names)){
														if($selected_cpid==$result_cp_names['cp_id']){
														
														
														echo '<option value="'.$result_cp_names['cp_id'].'" selected>'.$result_cp_names['company_name'].'</option>';
														}else{
														echo '<option value="'.$result_cp_names['cp_id'].'">'.$result_cp_names['company_name'].'</option>';
														}
															
														}
													?>
													</select>
					</div></td>
					
					<td><div class="txt_lable">&nbsp;&nbsp;&nbsp;&nbsp;Model Name:</div>
					<div>
					
					<?php
					
					?>
						&nbsp;&nbsp;&nbsp;&nbsp;<select name="model_id" >
													<option value="">-- SELECT --</option>
													<?php
														$sql_model_names="SELECT * FROM `adm_ph_models` WHERE `status`=1 AND `company_id`=".$selected_cpid;

														$query_model_names=mysql_query($sql_model_names);
														while($result_model_names=mysql_fetch_array($query_model_names)){
														echo '<option value="'.$result_model_names['mod_id'].'" >'.$result_model_names['model_name'].'</option>';
															
														}
													?>
													</select>
					</div></td></tr>
					
					<tr>
					<td><div class="txt_lable">Product Name:</div>
					<div>
					
					<?php
					
					?>
						<select name="prod_cat_id" >
													<option value="">-- SELECT --</option>
													<?php
														$sql_prod_names="SELECT * FROM `adm_product_category` WHERE `status`=1";

														$query_prod_names=mysql_query($sql_prod_names);
														while($result_prod_names=mysql_fetch_array($query_prod_names)){
														echo '<option value="'.$result_prod_names['p_cat_id'].'" >'.$result_prod_names['category_name'].'</option>';
															
														}
													?>
													</select>
					</div></td>
					<td><div class="txt_lable">&nbsp;&nbsp;&nbsp;&nbsp;Product Quantity:</div>
					<div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="inv_prod_qty" value="" ></div>
					</td></tr>
					<tr><td>
					<div class="txt_lable">Product Actual Price:</div>
					<div><input type="text" name="inv_prod_act_price" value="" ></div>
					</td><td>
					<div class="txt_lable">&nbsp;&nbsp;&nbsp;&nbsp;Product Sale Price:</div>
					<div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="inv_prod_sale_price" value="" ></div>
					</td></tr>
					<tr><td>
					<div class="txt_lable">Comments:</div>
					<div><input type="text" name="inv_comments" value="" ></div>
					</td></tr>
					</table>
					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>
				
				
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														<td><b>Entry ID</b></td>
														<td><b>Brand Name</b></td>
														<td><b>Model No</b></td>
														<td><b>Product Name</b></td>
														<td><b>Quantity</b></td>
														<td><b>Act Price</b></td>
														<td><b>Sale Price</b></td>
														<td><b>Added Date</b></td>
														<td><b>Comments</b></td>
														<td><b>Edit</b></td>
														<td><b>Delete</b></td>
													</tr>
											<?php
												//$sql_com="SELECT a.mod_id,(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												//$sql_com="SELECT a.inv_cr_id,(SELECT b.company_name FROM adm_companies b AS CPM where b.cp_id=a.company_id ),(SELECT c.model_name FROM adm_ph_models c where c.mod_id=a.model_id),(SELECT d.category_name FROM `adm_product_category` d WHERE d.p_cat_id=a.prod_cat_id),a.inv_prod_qty,a.comments, a.comments FROM `adm_prod_inv_cr_tran` a ";
												$sql_com="SELECT `inv_cr_id`, `company_id`, `model_id`, `prod_cat_id`, `inv_prod_qty`, `added_date`, `comments`,`actual_price`,`sale_price` FROM `adm_prod_inv_cr_tran` ORDER BY inv_cr_id DESC ";
												$query_com=mysql_query($sql_com);
												while($result_com=mysql_fetch_array($query_com)){
												//print_r($result_com); exit;						
												
												
												$sql_get_company_name="SELECT company_name FROM adm_companies WHERE cp_id=".$result_com['company_id'];
												$query_get_company_name=mysql_query($sql_get_company_name);
												$result_get_company_name=mysql_fetch_array($query_get_company_name);
												
												$sql_get_model_name="SELECT model_name FROM adm_ph_models WHERE mod_id=".$result_com['model_id'];
												//echo $sql_get_model_name;exit;
												$query_get_model_name=mysql_query($sql_get_model_name);
												$result_get_model_name=mysql_fetch_array($query_get_model_name);
												//print_r($result_get_model_name);
												
												$sql_get_product_name="SELECT category_name FROM adm_product_category WHERE p_cat_id=".$result_com['prod_cat_id']; //echo $sql_get_product_name;
												$query_get_product_name=mysql_query($sql_get_product_name);
												$result_get_product_name=mysql_fetch_array($query_get_product_name);
												
												//print_r($result_get_product_name);
												
													echo '<tr>
															<td>'.$result_com['inv_cr_id'].'</td>
															<td>'.$result_get_company_name['company_name'].'</td>
															<td>'.$result_get_model_name['model_name'].'</td>
															<td>'.$result_get_product_name['category_name'].'</td>
															<td>'.$result_com['inv_prod_qty'].'</td>
															<td>'.$result_com['actual_price'].'</td>
															<td>'.$result_com['sale_price'].'</td>
															<td>'.$result_com['added_date'].'</td>
															<td>'.$result_com['comments'].'</td>
															<td><a href="#"><img style="border:none; width:15px; height:15px;" src="./img/edit-icon.jpg"/></a></td>
															<td><a href="#"><img style="border:none; width:15px; height:15px;"src="./img/delete-icon.jpg"/></a></td>
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