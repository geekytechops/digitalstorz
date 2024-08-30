<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");

?>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<style>
    table {
  border-spacing: 15px;
  margin-left: auto;
  margin-right: auto;
  font-family:sans-serif;
}

</style>
</head>
<link rel="stylesheet" href="./menu.css">
<link href='https://fonts.googleapis.com/css?family=Roboto:500,900,100,300,700,400' rel='stylesheet' type='text/css'>


  <body>
	<div class="header">
		&nbsp;&nbsp;&nbsp;&nbsp;Kolors Mobile Services
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
				<!-- <?php include("admin-menu.php");?> -->
		
		<?php 
		if ($_SESSION['session_username']=="admin"){
		include("products-menu.php");
		}
		?>

		<div class="right_container">
			<div class="page_title_div"><h1>Welcome <?php echo $_SESSION['session_username'];?></h1></div>
			<div class="content_holder">
				<!--<?php
					$sql_inprocess="SELECT COUNT(order_id) as inp_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=3";
					$query_inprocess=mysql_query($sql_inprocess);
					$result_inprocess=mysql_fetch_array($query_inprocess);

					$sql_completed="SELECT COUNT(order_id) as cmp_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=4";
					$query_completed=mysql_query($sql_completed);
					$result_completed=mysql_fetch_array($query_completed);
					
					$sql_rej="SELECT COUNT(order_id) as rj_count FROM  `cust_retail_unlock_orders` WHERE `order_status`=2";
					$query_rej=mysql_query($sql_rej);
					$result_rej=mysql_fetch_array($query_rej);
					?>
				<div style="color:red; font-size:16px; padding:10px;">Order Summary</div>
				<div style="color:blue; font-size:13px; padding:10px;">&nbsp;&nbsp;&nbsp;In Process Orders - <?php echo $result_inprocess['inp_count'];?></div>
				<div style="color:green; font-size:13px; padding:10px;">&nbsp;&nbsp;Completed Orders - <?php echo $result_completed['cmp_count'];?></div>
				<div style="color:red; font-size:13px; padding:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rejected Orders - <?php echo $result_rej['rj_count'];?></div> -->


				<?php
					$sql_all="SELECT COUNT(entry_id) as all_order_count FROM `adm_cust_mob_add` where `delete_status`='0'";
					$query_all=mysql_query($sql_all);
					$result_all=mysql_fetch_array($query_all);
			
					$sql_inprocess="SELECT COUNT(entry_id) as pend_count FROM  `adm_cust_mob_add` WHERE `status`='Pending' AND `delete_status`='0'";
					$query_inprocess=mysql_query($sql_inprocess);
					$result_inprocess=mysql_fetch_array($query_inprocess);

					$sql_completed="SELECT COUNT(entry_id) as cmp_count FROM  `adm_cust_mob_add` WHERE `status`='Completed' AND `delete_status`='0'";
					$query_completed=mysql_query($sql_completed);
					$result_completed=mysql_fetch_array($query_completed);
					
					$sql_rej="SELECT COUNT(entry_id) as rj_count FROM  `adm_cust_mob_add` WHERE `rejected`='1' AND `delete_status`='0'";
					$query_rej=mysql_query($sql_rej);
					$result_rej=mysql_fetch_array($query_rej);
					
					$sql_del="SELECT COUNT(entry_id) as del_count FROM  `adm_cust_mob_add` WHERE `status`='Delivered'";
					$query_del=mysql_query($sql_del);
					$result_del=mysql_fetch_array($query_del);
					?>
					
					
				<table >
				    <tr><td style="color:red; font-size:16px; padding:10px;"><b>ORDER SUMMARY</b></td></tr>
				    <tr><td>&nbsp;</td></tr>
				    <tr>
					<td style=" color:#1C3FED; font-size:14px; padding:30px; border: 1px solid black;border-radius: 8px;  background:#A8A8A4;">&nbsp;&nbsp;<b>TOTAL&nbsp;ORDERS&nbsp;-&nbsp;<?php echo $result_all['all_order_count'];?></b></td>
					<td style=" color:#EDED1C; font-size:14px; padding:30px; border: 1px solid black;border-radius: 8px;  background:#F38B0E;">&nbsp;&nbsp;<b>PENDING&nbsp;ORDERS&nbsp;-&nbsp;<?php echo $result_inprocess['pend_count'];?></b></td>
					<td style=" color:#1C3FED; font-size:14px; padding:30px; border: 1px solid black;border-radius: 8px;  background:#A7FE8D;"><b>COMPLETED&nbsp;&&nbsp;PENDING FOR&nbsp;DELIVERY&nbsp;ORDERS&nbsp;-&nbsp;<?php echo $result_completed['cmp_count'];?></b></td>&nbsp;
					<td style=" color:#F6ECEB; font-size:14px; padding:30px; border: 1px solid black;border-radius: 8px;  background:#F31F0E;">&nbsp;&nbsp;<b>REJECTED&nbsp;ORDERS&nbsp;-&nbsp;<?php echo $result_rej['rj_count'];?></b></td>
					<td style=" color:#EDED1C; font-size:14px; padding:30px; border: 1px solid black;border-radius: 8px;  background:#028908;">&nbsp;&nbsp;<b>DELIVERED&nbsp;ORDERS&nbsp;-&nbsp;<?php echo $result_del['del_count'];?></b></td>

				    </tr>
				</table>
                <!--<div style="color:red; font-size:16px; padding:10px;">Order Summary</div>
				<div style="color:blue; font-size:13px; padding:10px;">&nbsp;&nbsp;Total Orders - <?php echo $result_all['all_order_count'];?></div>
				<div style="color:blue; font-size:13px; padding:10px;">&nbsp;&nbsp;Pending Orders - <?php echo $result_inprocess['pend_count'];?></div>
				<div style="color:green; font-size:13px; padding:10px;">&nbsp;&nbsp;Completed & Pending For Delivery Orders - <?php echo $result_completed['cmp_count'];?></div>
				<div style="color:red; font-size:13px; padding:10px;">&nbsp;&nbsp;Rejected Orders - <?php echo $result_rej['rj_count'];?></div>
				<div style="color:green; font-size:13px; padding:10px;">&nbsp;&nbsp;Delivered Orders - <?php echo $result_del['del_count'];?></div> -->
				
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
