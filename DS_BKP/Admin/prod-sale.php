<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
$session_id=session_id();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';
$btn_value=" Add to Cart ";
$btn_name="submit";

if(isset($_REQUEST['prod_bardode_sub'])){ 
$barcode_str=$_REQUEST['prod_barcode'];

$sql_bar_sale="SELECT * FROM `adm_prod_inv_cr_tran` WHERE `inv_cr_id`=".$barcode_str;
$query_bar_sale=mysql_query($sql_bar_sale);
$result_bal_sale=mysql_fetch_array($query_bar_sale);

$company_id_bar=$result_bal_sale['company_id'];
$model_bar=$result_bal_sale['model_id'];
$prod_cat_bar=$result_bal_sale['prod_cat_id'];
$sale_qty=1;
$sale_price_1=$result_bal_sale['sale_price'];

//echo $company_id_bar;
//echo $model_bar;
//echo $prod_cat_bar;
//exit;
}else{
    $barcode_str='';
    $sale_qty='';
}




if(isset($_REQUEST['prd_comp_id'])){ 
$selected_cpid=$_REQUEST['prd_comp_id'];
$seected_pr_id=$_REQUEST['prd_cat_id'];
$seected_model_id=$_REQUEST['pr_model_id'];

}

/*if(isset($_REQUEST['submit'])){ //When form Submits
		$company_name=$_REQUEST['company_id'];
		$model_name=$_REQUEST['model_id'];
		$product_cat_id1=$_REQUEST['prod_cat_id'];
		$sale_qty=$_REQUEST['sale_qty'];
		$sale_price=$_REQUEST['sale_price'];
		$cust_name=$_REQUEST['cust_name'];
		$cust_contact=$_REQUEST['cust_contact'];
		$remarks=$_REQUEST['remarks'];
		$payment_mode=$_REQUEST['payment_mode'];
		$sold_by=$_SESSION['session_username'];

		//Inserting Data
		$sql_ins="INSERT INTO `adm_prod_sale_tran`(`company_id`, `model_id`, `prod_cat_id`, `sale_qty`, `sale_price`, `cust_name`, `cust_contact`, `remarks` ,`payment_mode`,`sold_by`, `added_date`) VALUES
		('".$company_name."','".$model_name."','".$product_cat_id1."','".$sale_qty."','".$sale_price."','".$cust_name."','".$cust_contact."','".$remarks."','".$payment_mode."','".$sold_by."', NOW()) ";
		
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Sale Completed..</font>";
			echo "<script type='text/javascript'>alert('SALE COMPLETED');</script>";
			//header("Location: ./prod-sale.php");
			$sale_qty='';
		}else{
			$mess="Failed to Add..";
		}
} */

if(isset($_REQUEST['submit'])){ //Adding to cart
        //print_r($_SESSION);
        //print_r($_REQUEST);
        
        //echo $session_id;
        $sql_cartid="SELECT * FROM `prod_cart_temp` WHERE `session_id`='".$session_id."' ";
        $query_cart_id=mysql_query($sql_cartid);
		$num_rows_cart_id=mysql_num_rows($query_cart_id);

        if($num_rows_cart_id==0){
            $session_username=$_SESSION['session_username'];
            $added_barcode=$_REQUEST['added_barcode'];
            $sql_cart_ins="INSERT INTO `prod_cart_temp`( `session_id`, `barcode_id1`) VALUES ('".$session_id."','".$added_barcode."')  ";
            $query_cart_ins=mysql_query($sql_cart_ins);
        }else{
            $session_username=$_SESSION['session_username'];
            $added_barcode=$_REQUEST['added_barcode'];
            $result_cart_id=mysql_fetch_array($query_cart_id);
            $prev_barcode=$result_cart_id['barcode_id1'];
            $added_barcode1=$prev_barcode.'|'.$_REQUEST['added_barcode'];
            
            $sql_cartid_upd="UPDATE `prod_cart_temp` SET `barcode_id1`='".$added_barcode1."'
                                                     WHERE `session_id`='".$session_id."' ";
            $query_cart_id=mysql_query($sql_cartid_upd);
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
            
        function validate_bar()
            {
		if (document.product_sale_barcode.prod_barcode.value == "")
                {
                    document.product_sale_barcode.prod_barcode.focus();
                    alert("Enter Barcode or Scan Barcode..");
					return false;
                }
            }
    
            function validate()
            {
		if (document.product_sale_barcode.prod_barcode.value == "")
                {
                    document.product_sale_barcode.prod_barcode.focus();
                    alert("Enter Barcode or Scan Barcode..");
					return false;
                }
                
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
                
                if (document.product_add_inv.sale_qty.value == "")
                {
                    document.product_add_inv.sale_qty.focus();
                    alert("Please Enter Sale Quantity");
					return false;
                }
                if (document.product_add_inv.sale_price.value == "")
                {
                    document.product_add_inv.sale_price.focus();
                    alert("Please Enter Sale Price");
					return false;
                }
                if (document.product_add_inv.payment_mode.value == "")
                {
                    document.product_add_inv.payment_mode.focus();
                    alert("Please Select Payment Mode");
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
			
			
		//function SelectRedirect(copany_id){
		//window.location="./add-prod-inv.php?company_id="+copany_id;
		//}

	</script>

</head>
<body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<?php 
		if($_SESSION['session_username']=="admin")
		include("products-menu.php");
		else
		include("kol-mob-entry-menu.php");
		
		?>
		<div class="right_container">
			<div class="page_title_div"><h1>PRODUCT SALE</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Products Sale&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				
				<form name="product_sale_barcode" method="post" action="./prod-sale.php" onsubmit="return validate_bar()">
				<table>
				<tr>
					<td align="right"  class="txt_lable">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BARCODE :&nbsp;&nbsp;</td>
					<td><input type="text" name="prod_barcode" value="<?php echo $barcode_str;?>" autofocus ></td>
					
					<td  align="right" class="txt_lable">&nbsp;&nbsp;&nbsp;</td>
					<td><input type="submit" name="prod_bardode_sub" value="Get Details" ></td>
					
					</tr>
				</table>
				</form>
				
				<form name="product_add_inv" method="post" action="./prod-sale.php" onsubmit="return validate()">
				<table>
				
				<input type="hidden" name="added_barcode" value="<?php echo $barcode_str;?>">
				<tr>
					<td align="right" class="txt_lable">Company:&nbsp;&nbsp;</td>
					<td>
						<select name="company_id"  onChange="SelectRedirect(this.value);">
													<option value="">-- SELECT --</option>
													<?php
														$sql_cp_names="SELECT * FROM `adm_companies` WHERE `status`=1";
														$query_cp_names=mysql_query($sql_cp_names);
														
														while($result_cp_names=mysql_fetch_array($query_cp_names)){
														    
														if($company_id_bar==$result_cp_names['cp_id']){
														echo '<option value="'.$result_cp_names['cp_id'].'" selected>'.$result_cp_names['company_name'].'</option>';
														}else{
														echo '<option value="'.$result_cp_names['cp_id'].'">'.$result_cp_names['company_name'].'</option>';
														}
															
														}
													?>
													</select>
					</td>

					<td  align="right" class="txt_lable">Model Name:&nbsp;&nbsp;</td>
					<td>
					
					<?php
					
					?>
						<select name="model_id" >
													<option value="">-- SELECT --</option>
													<?php
														$sql_model_names="SELECT * FROM `adm_ph_models` WHERE `status`=1 AND `company_id`=".$company_id_bar;

														$query_model_names=mysql_query($sql_model_names);
														while($result_model_names=mysql_fetch_array($query_model_names)){
														if($model_bar==$result_model_names['mod_id']){
														echo '<option value="'.$result_model_names['mod_id'].'" selected >'.$result_model_names['model_name'].'</option>';
														}else{
														echo '<option value="'.$result_model_names['mod_id'].'" >'.$result_model_names['model_name'].'</option>';
														}
														
															
														}
													?>
													</select>
					</td>
					
					
					
					</tr>
					
					<tr>
					<td align="right"  class="txt_lable">Product&nbsp;Name:&nbsp;&nbsp;</td>
					<td>
					
					<?php
					
					?>
						<select name="prod_cat_id" >
													<option value="">-- SELECT --</option>
													<?php
														$sql_prod_names="SELECT * FROM `adm_product_category` WHERE `status`=1";

														$query_prod_names=mysql_query($sql_prod_names);
														while($result_prod_names=mysql_fetch_array($query_prod_names)){
														if($prod_cat_bar==$result_prod_names['p_cat_id']){
														echo '<option value="'.$result_prod_names['p_cat_id'].'" selected>'.$result_prod_names['category_name'].'</option>';
														}else{
														echo '<option value="'.$result_prod_names['p_cat_id'].'" >'.$result_prod_names['category_name'].'</option>';
														}
														
															
														}
													?>
													</select>
					</td>
					
					<td class="txt_lable"></td>
					<td></td>
					</tr>
					
					
					<tr>
					<td align="right"  class="txt_lable">Sale&nbsp;Quantity:&nbsp;&nbsp;</td>
					<td><input type="text" name="sale_qty" value="<?php echo $sale_qty; ?> " ></td>
					
					<td  align="right" class="txt_lable">&nbsp;&nbsp;Product&nbsp;Price:&nbsp;&nbsp;</td>
					<td><input type="text" name="sale_price" value=" <?php echo $sale_price_1; ?>" ></td>
					</tr>
					<!--
					<tr>
					<td align="right"  class="txt_lable">Customer&nbsp;Name :&nbsp;&nbsp;</td>
					<td><input type="text" name="cust_name" value="" ></td>
					
					<td  align="right" class="txt_lable">&nbsp;&nbsp;Contact&nbsp;Number :&nbsp;&nbsp;</td>
					<td><input type="text" name="cust_contact" value="" ></td>
					
					</tr>
					
					<tr>
					<td align="right" class="txt_lable">Remarks :&nbsp;&nbsp;</td>
					<td><input type="text" name="remarks" value="" ></td>
					<td class="txt_lable">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Payment Mode :</td>
					<td>
							<select name='payment_mode'>
							<option value="">--SELECT--</option>
							<option value="cash">Cash</option>
							<option value="card">Credit/Debit Card</option>
							<option value="wallet">Mobile Wallet</option>
							<option value="none">None</option>
							</select>
					</td>
					</tr>-->
					
					<tr>
					
					<td align="right" class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></td>
					</tr>
				</form>
				<table style="border:1px solid #8DA1FA">
                <tr style="border:1px solid #8DA1FA">
                    <td>Barcode ID</td>
                    <td>Company Name</td>
                    <td>Model Name</td>
                    <td>Product Category</td>
                    <td>Price</td>
                </tr>
				</div>
				<?php
				    $sql_cart_data="SELECT * FROM `prod_cart_temp` WHERE `session_id`='".$session_id."' ";
                    $query_cart_data=mysql_query($sql_cart_data);
                    $result_cart_data=mysql_fetch_array($query_cart_data);

                    $barcode_list_unformat=$result_cart_data['barcode_id1'];
                    $barcode_list=explode('|',$barcode_list_unformat);

                    $i = 0;
                    $total=0;
                    //print_r($barcode_list);
                    while($i < count($barcode_list))
                    {
                    //echo $i;
                        $sql_bar_sale1="SELECT * FROM `adm_prod_inv_cr_tran` WHERE `inv_cr_id`=".$barcode_list[$i];
                        
                        $query_bar_sale1=mysql_query($sql_bar_sale1);
                        $result_bal_sale1=mysql_fetch_array($query_bar_sale1);
                        //print_r($result_bal_sale1); exit;
                        $barcode_id=$result_bal_sale1['inv_cr_id'];
                        $company_id_bar=$result_bal_sale1['company_id'];
                        
                        	$sql_cp_names="SELECT * FROM `adm_companies` WHERE `cp_id`=".$company_id_bar;
							$query_cp_names=mysql_query($sql_cp_names);
							$result_cp_names=mysql_fetch_array($query_cp_names);
						    $company_name_dis=$result_cp_names['company_name'];
							
                        $model_bar=$result_bal_sale1['model_id'];
                            $sql_model_names="SELECT * FROM `adm_ph_models` WHERE `status`=1 AND `mod_id`=".$model_bar;
                            //echo $sql_model_names;exit;
                            $query_model_names=mysql_query($sql_model_names);
                            $result_model_names=mysql_fetch_array($query_model_names);
                        $model_number_dis=$result_model_names['model_name'];
                            
                        $prod_cat_bar=$result_bal_sale1['prod_cat_id'];
                            $sql_prod_names="SELECT * FROM `adm_product_category` WHERE `p_cat_id`=".$prod_cat_bar;
                            //echo $sql_prod_names;exit;
                            $query_prod_names=mysql_query($sql_prod_names);
                            $result_prod_names=mysql_fetch_array($query_prod_names);
                        
                        $prod_cat_name_dis=$result_prod_names['category_name'];
                            
                        $sale_qty=1;
                        $sale_price_1=$result_bal_sale1['sale_price'];
                        $total=$total+$sale_price_1;
                    echo "
                        <tr style='border:1px solid #8DA1FA'>
                            <td>".$barcode_id."</td>
                            <td>".$company_name_dis."</td>
                            <td>".$model_number_dis."</td>
                            <td>".$prod_cat_name_dis."</td>
                            <td>".$sale_price_1."</td>
                        </tr>
                        
                    ";
                    $i++;
                    }
				?>
				<tr style="border:1px solid #8DA1FA">
				    <td></td><td></td><td></td><td>Total</td><td><?php echo $total;?></td>
				</tr>
				</table>
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