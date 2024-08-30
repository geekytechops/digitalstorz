<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$from_date=date("Y-m-d");
$to_date=date("Y-m-d");
$tech_name='';
if(isset($_REQUEST['submit'])){ //When form Submits

	$tech_name=$_REQUEST['tech_name'];
	$from_date=$_REQUEST['from_date'].' 00:00:00';
	$to_date=$_REQUEST['to_date'].' 23:59:59';
	//echo $tech_name;exit;
	
	if($tech_name=='all'){
		$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE rejected='0' AND delete_status='0' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY delivered_date DESC";
	}else{
		$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE repair_by='".$tech_name."' AND rejected='0' AND delete_status='0' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."'  ORDER BY delivered_date DESC";
	}
	//echo $sql_view_trans;exit;
	$query_view_trans=mysql_query($sql_view_trans);
	

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
		if (document.view_transactions.tech_name.value == "")
                {
                    document.view_transactions.tech_name.focus();
                    alert("Select Technician Name");
		    return false;
                }
                if (document.view_transactions.from_date.value == "")
                {
                    document.view_transactions.from_date.focus();
                    alert("Select From Date");
		    return false;
                }
                if (document.view_transactions.to_date.value == "")
                {
                    document.view_transactions.to_date.focus();
                    alert("Select To Date");
		    return false;
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
		<!-- <?php include("admin-menu.php");?>
		<p>&nbsp;</p>
		<p>&nbsp;&nbsp;&nbsp;<b>Shopping Cart Menu</b></p>
		<?php include("products-menu.php");?>
		<p>&nbsp;</p> -->
		<?php // include("kol-mob-entry-menu.php");?>
		<div class="right_container">
		<div class="page_title_div"><h1>CUSTOMER TRANSACTIONS</h1></div>
			<div class="content_holder">
				
				<form name="view_transactions" method="post" action="./transactions_online.php" onsubmit="return validate()">
				<table class="order_hisory_table">
					<tr class="table_heading">
						<td>Select User:</td>
						<td>
							<select name="tech_name" id="tech_name">
							<option value=""> -- SELECT -- </option>
							<?php 
							//echo $tech_name;
							$tech_list=array('vinay'=>'Vinay','vasu'=>'Vasu','all'=>'All','admin'=>'Admin');
							foreach($tech_list as $techkey => $techvalue) {
								if($techkey==$tech_name){
								   echo '<option selected value='.$techkey.'>'.$techvalue.'</option>';
								}else{
								   echo '<option value='.$techkey.'>'.$techvalue.'</option>';
								}
    							
							}
							?>
							</select>
						</td>
						<td>From Date:</td>
						<td><input type="text" name="from_date" value="<?php echo $from_date;?>"></td>
						<td>To Date:</td>
						<td><input type="text" name="to_date" value="<?php echo $to_date;?>"></td>
						<td><input type="submit" name="submit" value="Submit"></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					</table>
					<br>
					<table class="order_hisory_table">
					<tr>

					<?php
						if(isset($_REQUEST['submit'])){
						echo '<tr class="table_heading">
							<td><b>Order ID</b></td>
							<td width=175px><b>Received Date</b></td>
							<td width=175px><b>Delivered Date</b></td>
							<td><b>Repair By</b></td>
							<td width=205px><b>Mobile Name</b></td>
							<td width=225px><b>Defect</b></td>
							<td><b>Estimeted Amount</b></td>
							<td><b>Adv Amount</b></td>
							<td><b>Final/Actual Amount</b></td>

							<td><b>Payment Mode</b></td>
							
						</tr>';
						$total_final=0; $cash_total=0; $card_total=0; $wallet_total=0;$total_spare=0;
						while($result_view_trans=mysql_fetch_array($query_view_trans)){
						
						$mobile_def_sql='SELECT `defect_name` FROM `adm_mobile_defects` WHERE `defect_id`='.$result_view_trans['mobile_defect'];
						$mob_def_query=mysql_query($mobile_def_sql);
						$mob_def_result=mysql_fetch_array($mob_def_query);	
						
						$total_final=$total_final+$result_view_trans['actual_amount'];
						$total_spare=$total_spare+$result_view_trans['spare_cost'];
						if($result_view_trans['payment_mode']=='cash'){
							$cash_total=$cash_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='card'){
							$card_total=$card_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='wallet'){
							$wallet_total=$wallet_total+$result_view_trans['actual_amount'];
						}
						
						echo '<tr>';
						echo '<td>'.$result_view_trans['entry_id'].'</td>';
						echo '<td>'.$result_view_trans['added_date'].'</td>';
						echo '<td>'.$result_view_trans['delivered_date'].'</td>';
						echo '<td>'.$result_view_trans['repair_by'].'</td>';
						echo '<td>'.$result_view_trans['mobile_name'].'</td>';
						echo '<td>'.$mob_def_result['defect_name'].'</td>';
						echo '<td>'.$result_view_trans['est_amount'].'</td>';
						echo '<td>'.$result_view_trans['adv_amount'].'</td>';
						echo '<td>'.$result_view_trans['actual_amount'].'</td>';
						
						echo '<td>'.$result_view_trans['payment_mode'].'</td>';
						echo '</tr>';

						}
						echo '<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							
							<td style="color: green;font-size:15px; font-weight:bold">Grand&nbsp;Total&nbsp;-&nbsp;</td>
							<td colspan=2 style="color: green;font-size:15px; font-weight:bold">'.$total_final.'</td>
							
							
						</tr>';
						
						echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td>
						
						<td style="color: blue;font-size:15px; font-weight:bold" colspan="5">Cash - '.$cash_total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card&nbsp;-&nbsp;'.$card_total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Wallet - '.$wallet_total.'</td>
						</tr>';
						}
						
						
					?>
					
				</table>

				</form>

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