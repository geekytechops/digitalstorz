<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$from_date=date("Y-m-d");
$to_date=date("Y-m-d");
$tech_name='';
$sql_advance_amt_pend_trans=0;
$pend_adv_card_tot=0;
$pend_adv_cash_tot=0;
if(isset($_REQUEST['submit'])){ //When form Submits

	$tech_name=$_REQUEST['tech_name'];
	$from_date=$_REQUEST['from_date'].' 00:00:00';
	$to_date=$_REQUEST['to_date'].' 23:59:59';
	//echo $tech_name;exit;
	
	if($tech_name=='all'){
		$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE rejected='0' AND delete_status='0' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY delivered_date DESC";
		//$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE  delivered_date BETWEEN '".$from_date."' AND '".$to_date."' ORDER BY delivered_date DESC";
		//echo $sql_view_trans;

		//Query for getting total advance amount between selected dates.
		$sql_advance_amt="SELECT SUM(adv_amount) AS tot_adv_amount FROM `adm_cust_mob_add` WHERE rejected='0' AND delete_status='0' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."'";
		//echo $sql_advance_amt;
		//exit;
		$query_sql_advance_amt=mysql_query($sql_advance_amt);
		$result_sql_advance_amt=mysql_fetch_array($query_sql_advance_amt);
		//print_r($result_sql_advance_amt);
		$tot_adv_amt_disp=$result_sql_advance_amt['tot_adv_amount'];
	
		//GETTING PENDING TRANSACTION ADVANCE AMOUNT
		$sql_advance_amt_pend_trans="SELECT SUM(adv_amount) AS tot_adv_amount_pend FROM `adm_cust_mob_add` WHERE added_date BETWEEN '".$from_date."' AND '".$to_date."' AND status='Pending'";
		$query_advance_amt_pend_trans=mysql_query($sql_advance_amt_pend_trans);
		$result_sql_advance_amt_pend=mysql_fetch_array($query_advance_amt_pend_trans);
		
		//print_r($result_sql_advance_amt_pend);
		$pend_trans_adv_amt_final=$result_sql_advance_amt_pend['tot_adv_amount_pend'];
		//echo $pend_trans_adv_amt_final; exit;
		
		//GETTING PENDING ADV AMOUNT BY CARD
		$sql_pend_adv_card="SELECT SUM(adv_amount) AS adv_pend_card FROM `adm_cust_mob_add` WHERE added_date BETWEEN '".$from_date."' AND '".$to_date."' AND status='Pending' AND adv_payment_mode='card' ";
		$query_pend_adv_card=mysql_query($sql_pend_adv_card);
		$result_pend_adv_card=mysql_fetch_array($query_pend_adv_card);
		$pend_adv_card_tot=$result_pend_adv_card['adv_pend_card'];
		
		
		//GETTING PENDING ADV AMOUNT BY CASH
		$sql_pend_adv_card="SELECT SUM(adv_amount) AS adv_pend_cash FROM `adm_cust_mob_add` WHERE added_date BETWEEN '".$from_date."' AND '".$to_date."' AND status='Pending' AND adv_payment_mode='cash' ";
		$query_pend_adv_cash=mysql_query($sql_pend_adv_cash);
		$result_pend_adv_cash=mysql_fetch_array($query_pend_adv_cash);
		$pend_adv_cash_tot=$result_pend_adv_card['adv_pend_cash'];
		
		
		
	}else{
		$sql_view_trans="SELECT * FROM adm_cust_mob_add WHERE repair_by='".$tech_name."' AND rejected='0' AND delete_status='0' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."'  ORDER BY delivered_date DESC";
		
		$sql_advance_amt="SELECT SUM(adv_amount) AS tot_adv_amount FROM `adm_cust_mob_add` WHERE repair_by='".$tech_name."' AND delivered_date BETWEEN '".$from_date."' AND '".$to_date."'";
	$query_sql_advance_amt=mysql_query($sql_advance_amt);
	$result_sql_advance_amt=mysql_fetch_array($query_sql_advance_amt);
	//print_r($result_sql_advance_amt);
	$tot_adv_amt_disp=$result_sql_advance_amt['tot_adv_amount'];
	}
	//echo $sql_view_trans;exit;
	$query_view_trans=mysql_query($sql_view_trans);
	
	
}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
		<?php include("kol-mob-entry-menu.php");?>
		<div class="right_container">
		<div class="page_title_div"><h1>VIEW TRANSACTIONS</h1></div>
			<div class="content_holder">
				
				<form name="view_transactions" method="post" action="./transactions.php" onsubmit="return validate()">
				<table class="order_hisory_table">
					<tr class="table_heading">
						<td>Select User:</td>
						<td>
							<select name="tech_name" id="tech_name">
							<option value=""> -- SELECT -- </option>
							<?php 
							//echo $tech_name;
							$tech_list=array('vinay'=>'Vinay','vasu'=>'Vasu','sandeep'=>'Sandeep','all'=>'All','admin'=>'Admin');
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


					<?php
						if(isset($_REQUEST['submit'])){
						echo '<tr>
							<td><b>Order ID</b></td>
							<td><b>Received Date</b></td>
							<td><b>Delivered Date</b></td>
							<td><b>Repair By</b></td>
							<td><b>Mobile Name</b></td>
							<td><b>Defect</b></td>
							<td><b>Estimeted Amount</b></td>
							<td><b>Adv Amount</b></td>
							<td><b>Final/Actual Amount</b></td>
							<td><b>Spare Cost</b></td>
							<td><b>Payment Mode</b></td>
							
						</tr>';
						$total_final=0; 
						$cash_total=0; 
						$card_total=0;
						$gpay_total=0;
						$phonepe_total=0;
						$paytm_total=0;
						$mobiqwik_total=0;
						$freecharge_total=0;
						$wallet_total=0;
						$total_spare=0;
						$Advance_amt=0;
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
						}elseif($result_view_trans['payment_mode']=='googlepay'){
							$gpay_total=$gpay_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='phonepe'){
							$phonepe_total=$phonepe_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='paytm'){
							$paytm_total=$paytm_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='mobiqwik'){
							$mobiqwik_total=$mobiqwik_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='freecharge'){
							$freecharge_total=$freecharge_total+$result_view_trans['actual_amount'];
						}elseif($result_view_trans['payment_mode']=='none'){
						    $none_total=$none_total+$result_view_trans['actual_amount'];
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
						echo '<td>'.$result_view_trans['spare_cost'].'</td>';
						echo '<td>'.$result_view_trans['payment_mode'].'</td>';
						echo '</tr>';

						}
						echo '<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							
							<td style="color: green;font-size:15px; font-weight:bold">Advance&nbsp;Amount&nbsp;-&nbsp;</td>
							<td style="color: green;font-size:15px; font-weight:bold">'.($tot_adv_amt_disp+$pend_trans_adv_amt_final).' (From Pending -'.$pend_trans_adv_amt_final.' )</td>
							<td style="color: green;font-size:15px; font-weight:bold">&nbsp;</td>
							<td style="color: green;font-size:15px; font-weight:bold"></td>
							
						</tr>';
						echo '<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							
							<td style="color: green;font-size:15px; font-weight:bold">Grand&nbsp;Total&nbsp;-&nbsp;</td>
							<!--<td style="color: green;font-size:15px; font-weight:bold">'.($total_final+$tot_adv_amt_disp+$pend_trans_adv_amt_final).'</td>-->
							<td style="color: green;font-size:15px; font-weight:bold">'.($total_final).'</td>
							<td style="color: green;font-size:15px; font-weight:bold">&nbsp;Spare&nbsp-&nbsp;'.$total_spare.'</td>
							<!--<td style="color: green;font-size:15px; font-weight:bold">Net&nbsp;-&nbsp;'.(($total_final+$tot_adv_amt_disp+$pend_trans_adv_amt_final) - $total_spare).'</td>-->
							<td style="color: green;font-size:15px; font-weight:bold">Net&nbsp;-&nbsp;'.(($total_final) - $total_spare).'</td>
							
						</tr>';

						echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td>
						<td style="color: blue;font-size:15px; font-weight:bold" colspan="5">Cash - '.($cash_total+$pend_adv_cash_tot).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Card&nbsp;-&nbsp;'.($card_total+$pend_adv_card_tot).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Wallet - '.$wallet_total.'   None - '.$none_total.'</td>
						</tr>';
						
						echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td>
						<td style="color: blue;font-size:15px; font-weight:bold" colspan="5">G-Pay - '.$gpay_total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phone Pe&nbsp;-&nbsp;'.$phonepe_total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Paytm - '.$paytm_total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Freecharge - '.$freecharge_total.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mobiqwik - '.$mobiqwik_total.'</td>
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