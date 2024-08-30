<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';

$btn_value=" SEARCH";
$btn_name="submit";

if(isset($_REQUEST['company_id'])){ 
$selected_cpid=$_REQUEST['company_id'];

}
if(isset($_REQUEST['submit'])){ //When form Submits
		$company_name=$_REQUEST['company_id'];
		$model_name=$_REQUEST['model_id'];
		$product_cat_id1=$_REQUEST['prod_cat_id'];
		
		$sale_btn='<td><a href="./prod-sale.php?prd_cat_id='.$product_cat_id1.'&prd_comp_id='.$company_name.'&pr_model_id='.$model_name.'" ><b>SALE</b></a></td>';
		
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
                

	    }
			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				}
			}
			
			
		function SelectRedirect(copany_id){
		window.location="./view-inventory.php?company_id="+copany_id;
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
			<div class="page_title_div"><h1>VIEW PRODUCTS INVENTORY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;View Products Inventory&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="product_add_inv" method="post" action="./view-inventory.php" onsubmit="return validate()">
					<div class="txt_lable">Company:</div>
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
					</div>

					<div class="txt_lable">Model Name:</div>
					<div>
					
					<?php
					
					?>
						<select name="model_id" >
													<option value="">-- SELECT --</option>
													<?php
														$sql_model_names="SELECT * FROM `adm_ph_models` WHERE `status`=1 AND `company_id`=".$selected_cpid;

														$query_model_names=mysql_query($sql_model_names);
														while($result_model_names=mysql_fetch_array($query_model_names)){
														
														if($model_name==$result_model_names['mod_id']){
														echo '<option value="'.$result_model_names['mod_id'].'" selected >'.$result_model_names['model_name'].'</option>';
														}else{
														echo '<option value="'.$result_model_names['mod_id'].'" >'.$result_model_names['model_name'].'</option>';
														}
														
															
														}
													?>
													</select>
					</div>
					
					
					<div class="txt_lable">Product Name:</div>
					<div>
					
					<?php
					
					?>
						<select name="prod_cat_id" >
													<option value="">-- SELECT --</option>
													<?php
														$sql_prod_names="SELECT * FROM `adm_product_category` WHERE `status`=1";

														$query_prod_names=mysql_query($sql_prod_names);
														while($result_prod_names=mysql_fetch_array($query_prod_names)){
														
														if($product_cat_id1==$result_prod_names['p_cat_id']){
														echo '<option value="'.$result_prod_names['p_cat_id'].'" selected>'.$result_prod_names['category_name'].'</option>';
														}else{
														echo '<option value="'.$result_prod_names['p_cat_id'].'" >'.$result_prod_names['category_name'].'</option>';
														}
														
															
														}
													?>
													</select>
					</div>


					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>
				
				
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														
														<td><b>Brand Name</b></td>
														<td><b>Model No</b></td>
														<td><b>Product Name</b></td>
														<td><b>Quantity</b></td>
														<td><b></b></td>
													</tr>
											<?php
												//$sql_com="SELECT a.mod_id,(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),a.model_no,a.model_name,a.added_date,a.status FROM `adm_ph_models` a where status='1'";
												//$sql_com="SELECT a.inv_cr_id,(SELECT b.company_name FROM adm_companies b AS CPM where b.cp_id=a.company_id ),(SELECT c.model_name FROM adm_ph_models c where c.mod_id=a.model_id),(SELECT d.category_name FROM `adm_product_category` d WHERE d.p_cat_id=a.prod_cat_id),a.inv_prod_qty,a.comments, a.comments FROM `adm_prod_inv_cr_tran` a ";
												//$sql_com="SELECT `inv_cr_id`, `company_id`, `model_id`, `prod_cat_id`, `inv_prod_qty`, `added_date`, `comments` FROM `adm_prod_inv_cr_tran` ORDER BY inv_cr_id DESC ";
												$sql_com="SELECT `company_id`, `model_id`, `prod_cat_id`, SUM(inv_prod_qty) as prod_stock FROM `adm_prod_inv_cr_tran` WHERE company_id='".$company_name."' AND model_id='".$model_name."' AND prod_cat_id='".$product_cat_id1."' ";
												
												//echo $sql_com;
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
												if($result_com['prod_stock']!=0 ){
												
												$sql_sale_qty="SELECT SUM(sale_qty) AS sale_qty FROM adm_prod_sale_tran WHERE company_id='".$company_name."'AND model_id='".$model_name."' AND prod_cat_id='".$product_cat_id1."' ";
												$query_sale_qty=mysql_query($sql_sale_qty);
												$result_sale_qty=mysql_fetch_array($query_sale_qty);
												$sale_qty_sum=$result_sale_qty['sale_qty'];
												$available_qty=$result_com['prod_stock']-$sale_qty_sum;
												//echo $sale_qty_sum;
												echo '<tr>
															
															<td>'.$result_get_company_name['company_name'].'</td>
															<td>'.$result_get_model_name['model_name'].'</td>
															<td>'.$result_get_product_name['category_name'].'</td>
															<td>'.$available_qty.'</td>
															'.$sale_btn.'
														
													</tr>';
												}else{
												echo '<tr><td colspan="5"><b>No Stock</b></td></tr>';
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