<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';



			

$from_date=date("Y-m-d");
$to_date=date("Y-m-d");

$btn_value=" SEARCH";
$btn_name="submit";

if(isset($_REQUEST['company_id'])){ 
$selected_cpid=$_REQUEST['company_id'];

}
if(isset($_REQUEST['submit'])){ //When form Submits
		$from_date1=$_REQUEST['sale_from'].' 00:00:00';
		$to_date1=$_REQUEST['sale_to'].' 23:59:59';
		
			$sql_com="SELECT a.sale_id,
			(SELECT b.company_name from adm_companies b where b.cp_id=a.company_id),
			(SELECT c.model_name from adm_ph_models c where c.mod_id=a.model_id),
			(SELECT d.category_name from adm_product_category d where d.p_cat_id=a.prod_cat_id),
			a.sale_qty,
			a.sale_price,
			a.added_date,
			a.cust_name, 
			a.cust_contact,
			a.payment_mode,
			a.sold_by
			FROM `adm_prod_sale_tran` a WHERE a.added_date BETWEEN '".$from_date1."' AND '".$to_date1."' ORDER BY a.added_date DESC";
			
			$query_sql_com=mysql_query($sql_com);
			
			//exit;
			$from_date_tmp= explode(" ", $from_date1);
			$from_date=$from_date_tmp[0];
			
			$to_date_tmp= explode(" ", $to_date1);
			$to_date=$to_date_tmp[0];						
		
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
		if (document.product_add_inv.sale_from.value == "")
                {
                    document.product_add_inv.sale_from.focus();
                    alert("Enter From Date");
					return false;
                }
                
                if (document.product_add_inv.sale_to.value == "")
                {
                    document.product_add_inv.sale_to.focus();
                    alert("Enetr To Date");
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
		<?php 
		if($_SESSION['session_username']=="admin")
		include("products-menu.php");
		else
		include("kol-mob-entry-menu.php");
		
		?>
		<div class="right_container">
			<div class="page_title_div"><h1>VIEW SALE HISTORY</h1></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;View Sale History&nbsp;&nbsp;&nbsp;<?php echo $mess;?></div>
				
				<div class="content_holder_body">
				<form name="product_add_inv" method="post" action="./view-sale.php" onsubmit="return validate()">
					
				<table>
				<tr>
					<td align="right"  class="txt_lable">From Date:&nbsp;&nbsp;</td>
					<td><input type="text" name="sale_from" value="<?php echo $from_date;?>" ></td>
					
					<td  align="right" class="txt_lable">&nbsp;&nbsp;To Date:&nbsp;&nbsp;</td>
					<td><input type="text" name="sale_to" value="<?php echo $to_date;?>" ></td>
				</tr>
				</table>
				


					<div class="submit_button_div"><input  type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" /></div>
				</form>
				
				
				<br><br>
				<table class="order_hisory_table">
													<tr class="table_heading">
														
														<td><b>SALE ID</b></td>
														<td><b>Date</b></td>
														<td><b>Company</b></td>
														<td><b>Model</b></td>
														<td><b>Product Name</b></td>
														<td><b>Quantity</b></td>
														<td><b>Price</b></td>
														
														<td><b>Customer Name</b></td>
														<td><b>Contact</b></td>
														<td><b>Payment Mode</b></td>
														<td><b>Sold By</b></td>
														
													</tr>
				<?php
				while($result_sale=mysql_fetch_array($query_sql_com)){
			
				echo '<tr>
															
					<td>'.$result_sale['sale_id'].'</td>
					<td>'.$result_sale['added_date'].'</td>
					<td>'.$result_sale['1'].'</td>
					<td>'.$result_sale['2'].'</td>
					<td>'.$result_sale['3'].'</td>
					<td>'.$result_sale['sale_qty'].'</td>
					<td>'.$result_sale['sale_price'].'</td>
					<td>'.$result_sale['cust_name'].'</td>
					<td>'.$result_sale['cust_contact'].'</td>
					<td>'.$result_sale['payment_mode'].'</td>
					<td>'.$result_sale['sold_by'].'</td>
					
														
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